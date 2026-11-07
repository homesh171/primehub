<?php

namespace App\Http\Controllers\Softwareapi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
use App\Models\allmassageapis;
use App\Models\payout_benefi_numberverify;
use App\Models\payout_beneficiaries_add;
use App\Models\agentpermissions;
use App\Models\Agent;
use App\Models\payout_charges;
use App\Models\payout_history;
use session;
use Crypt;
use App\Services\LogService;


class Payoutcontroller extends Controller
{
    

function beneficiaries(Request $request){
    
    $id = $request->session()->get('AGENT_ID');
    $data['user_permissions'] = agentpermissions::where('user_id',$id)->first();
    $data['txn'] = payout_history::where('agent_id',$id)->limit(5)->orderBy('id','DESC')->get();

   if(empty(session()->get('benefinumber'))){
    return View('backend/Agent/Payout/beneficiaries');
   }else{
    $number =  session()->get('benefinumber');   
         
    $data['details'] = payout_beneficiaries_add::where('mobile_number',$number)->get();
    
    return View('backend/Agent/Payout/beneficiaries',$data);
   }
}


function addbeneficiaries(Request $request){

$number =  $request->number;    

$checknumber = payout_benefi_numberverify::where('number',$number)->first();
$checknumbesqar = payout_benefi_numberverify::where('number',$number)->get();
$Count = $checknumbesqar->count();

if($Count > 0){
    
    if($checknumber->status == "1"){
    $request->session()->put('benefinumber',$number);
    $data['results'] = 'Already';
    $data['massage'] = 'Mobile Number Already Verified';  
    }else{
        

$otp = rand(111111, 999999);
$addbeninumberdata = array(
    'number' =>$number,
    'otp' => $otp,
    );

$addbeninumber =  payout_benefi_numberverify::where('number',$number)->update($addbeninumberdata);


if($addbeninumber == true){
    
 $sendotp = allmassageapis::where('id','1')->first();
 
 $massage = str_replace("{var}","$otp",$sendotp->massage);
 $otpstratus = sendOtp($number,$massage);
 

 if($otpstratus == 'success'){
    $data['results'] = 'success';
    $data['massage'] = 'OTP Sent Successfully';
 }else{
    $data['results'] = 'error';
    $data['massage'] = 'OTP Has Not Been Sent'; 
 }

}else{
    $data['results'] = 'error';
    $data['massage'] = 'Mobile Number Add Failed'; 
}
        
    }
    

}else{
    

    
$otp = rand(111111, 999999);
$addbeninumberdata = array(
    'number' =>$number,
    'otp' => $otp,
    );

$addbeninumber =  payout_benefi_numberverify::create($addbeninumberdata);

if($addbeninumber == true){
    
 $sendotp = allmassageapis::where('id','1')->first();
 

 $massage = str_replace("{var}","$otp",$sendotp->massage);
 $otpstratus = sendOtp($number,$massage);
 
 if($otpstratus == 'success'){
    $data['results'] = 'success';
    $data['massage'] = 'OTP Sent Successfully';
 }else{
    $data['results'] = 'error';
    $data['massage'] = 'OTP Has Not Been Sent'; 
 }

}else{
    $data['results'] = 'error';
    $data['massage'] = 'Mobile Number Add Failed'; 
}
}
    
echo json_encode($data);

}    



function addbeneficiariesnumberverify(Request $request){
    
    $number =  $request->number; 
    $otp =  $request->otp; 

   $verifynumber = payout_benefi_numberverify::where('number',$number)->where('otp',$otp)->get();
   $Count = $verifynumber->count();
   
if($Count > 0){
    
    $status = array(
        'status' => '1',
        );
    

$request->session()->put('benefinumber',$number);

    
    $addbeninumber =  payout_benefi_numberverify::where('number',$number)->update($status);
    $data['results'] = 'success';
    $data['massage'] = 'Mobile Number Verified';  
}else{
   $data['results'] = 'error';
   $data['massage'] = 'Invalid OTP';   
}

echo json_encode($data);

}


function addbeneficiariesaccount(Request $request){
    


$secret = payout_secrect();
$access_key = payout_access_key();


$url = "https://api.frenzopay.com/api/v1/payout/beneficiary";
$fields = [
    'account_number' => $request->account_number,
    'address'        => $request->address,
    'ifsc_code'   => $request->ifsc_code,
    'mobile_number'  => $request->mobile,
	'name'  => $request->name,
	'email' =>  $request->email,
	"allowed_payment_types" => array(1),
];

$recorddata = json_encode($fields);
$x_timestamp  = floor(microtime(true) * 1000);
$path = "/api/v1/payout/beneficiary";

$signature =  calculate_hmac($secret, $x_timestamp,$recorddata,$path,'','POST');

$header_data = array(
	"Content-Type: application/json",
	"Accept: application/json",
	"access_key:".$access_key ,
	"signature:". $signature,
	"X-Timestamp:".$x_timestamp,
);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $recorddata);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch,CURLOPT_HTTPHEADER,$header_data); 
curl_setopt($ch,CURLOPT_HEADER,0); 
$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$responseObject = json_decode($response,true);

// $responseObject['duplicate_beneficiary_id'];


if($http_status == "201"){

$path201 = "/api/v1/payout/beneficiary/" . $responseObject['id'];
$url201 = "https://api.frenzopay.com" . $path201;
$signature201 = calculate_hmac($secret, $x_timestamp, '', $path201, '', 'GET');

$header_data = array(
    "Content-Type: application/json",
    "Accept: application/json",
    "access_key:" . $access_key,
    "signature:" . $signature201,
    "X-Timestamp:" . $x_timestamp,
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url201);
curl_setopt($ch, CURLOPT_HTTPGET, true); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
curl_setopt($ch, CURLOPT_HEADER, 0);  
$result = curl_exec($ch);
$databeni =  json_decode($result, true);

$data = array(
'account_number' => $databeni['account_number'] ,
'ifsc_code' => $databeni['ifsc_code'],
'address' => $databeni['address'],
'mobile_number' => $databeni['mobile_number'],
'name' => $databeni['name'],
'email' => $databeni['email'] ,
'allowed_payment_types' => implode(',',$databeni['allowed_payment_types']),
'vpa' => $databeni['vpa'],
'beneficiary_id' => $databeni['id'],
'ip' => $_SERVER['REMOTE_ADDR'],
); 

DB::table('payout_beneficiaries_adds')->insert($data);

return redirect('agent/payout/beneficiaries')->with('success','Beneficiaries Successfully Add');

}elseif($http_status == "400"){
   
$path201 = "/api/v1/payout/beneficiary/" . $responseObject['duplicate_beneficiary_id'];
$url201 = "https://api.frenzopay.com" . $path201;
$signature201 = calculate_hmac($secret, $x_timestamp, '', $path201, '', 'GET');

$header_data = array(
    "Content-Type: application/json",
    "Accept: application/json",
    "access_key:" . $access_key,
    "signature:" . $signature201,
    "X-Timestamp:" . $x_timestamp,
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url201);
curl_setopt($ch, CURLOPT_HTTPGET, true); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
curl_setopt($ch, CURLOPT_HEADER, 0);  
$result = curl_exec($ch); 
$databeni =  json_decode($result, true);

$data = array(
'account_number' => $databeni['account_number'] ,
'ifsc_code' => $databeni['ifsc_code'],
'address' => $databeni['address'],
'mobile_number' => $databeni['mobile_number'],
'name' => $databeni['name'],
'email' => $databeni['email'] ,
'allowed_payment_types' => implode(',',$databeni['allowed_payment_types']),
'vpa' => $databeni['vpa'],
'beneficiary_id' => $databeni['id'],
'ip' => $_SERVER['REMOTE_ADDR'],
); 

$checknumbesqar = payout_beneficiaries_add::where('beneficiary_id',$databeni['id'])->get();
$Count = $checknumbesqar->count();
if($Count > 0){
$addbeninumber =  payout_beneficiaries_add::where('beneficiary_id',$databeni['id'])->update($data);
}else{
DB::table('payout_beneficiaries_adds')->insert($data);    
}

return redirect('agent/payout/beneficiaries')->with('success','Beneficiaries Successfully Add');

}else{
 
    return redirect('agent/payout/beneficiaries')->with('success','Invalid Account Number And IFSC Code');
}    

}




/******** Payout Amount    ******/

function payoutpayment(Request $request){


$id = $request->session()->get('AGENT_ID');
$requestedAmount = $request->amount;

$chargesCollection = DB::table('payout_charges')
    ->where('agent_id', $id)
    ->get();



$user_permissions = agentpermissions::where('user_id',$id)->first();  
$user_data  = Agent::where('id',$id)->first(); 

 
    
$default_payout_changescount = $chargesCollection->count();

$payment_status = '0';
$services_id = '2';
$message = 'User Payout';
$userRole = "2";
$userIp = $request->ip();
$activity = '17';
$weburl = $_SERVER['REQUEST_URI'];


LogService::logs($activity,$weburl,$user_data->id,$userRole,$userIp);


if($default_payout_changescount > 0){
    $chargesCollection = DB::table('payout_charges')
    ->where('agent_id', $id)
    ->get();
    $userspermisionamount = null;
    
    foreach ($chargesCollection as $charge) {
    if ($charge->start_price <= $requestedAmount && $charge->last_price >= $requestedAmount) {
        $userspermisionamount = $charge->charges_amount;
        break;
    }
}


if (!$userspermisionamount) {
    $userspermisionamount = $user_permissions->default_payout_changes;
}

if($user_permissions->payout_type =='1'){
   
   $chargeamount =  $request->amount*$userspermisionamount/100; 
   
}else{
$chargeamount = $userspermisionamount; 

}


}else{
$chargeamount = $user_permissions->default_payout_changes; 

}


$totalamount =  $chargeamount + $request->amount;

$walleteamount = $user_data->wallet;

$userspermisionamount1 = DB::table('system_settings')->where('id','1')->first();


if($userspermisionamount1->payout_server == '0'){
   $data['results'] = 'error';
   $data['massage'] = 'Payment server is down, please try again sometime.';
}else{
    
if(payoutbalance() < $request->amount){
   $data['results'] = 'error';
   $data['massage'] = 'Payment server is down, please try again sometime.';  
}else{    

if($user_permissions->payout_limit <= $request->amount){
   $data['results'] = 'error';
   $data['massage'] = 'You can send money only for less than Rs '.$user_permissions->payout_limit;
}else{

if($walleteamount <= $totalamount){

   $data['results'] = 'error';
   $data['massage'] = 'There is No Balance in Your Account';    

}else{    

$secret = payout_secrect();
$access_key = payout_access_key();


$url = "https://api.frenzopay.com/api/v1/payout/";
$fields = [
    'beneficiary_id' => $request->beneficiary_id,
    'amount'        => $request->amount*100,
    'payment_method'   => $request->payment_type,
];

$recorddata = json_encode($fields);
$x_timestamp  = floor(microtime(true) * 1000);
$path = "/api/v1/payout/";

$signature =  calculate_hmac($secret, $x_timestamp,$recorddata,$path,'','POST');

$header_data = array(
	"Content-Type: application/json",
	"Accept: application/json",
	"access_key:".$access_key ,
	"signature:". $signature,
	"X-Timestamp:".$x_timestamp,
);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $recorddata);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch,CURLOPT_HTTPHEADER,$header_data); 
curl_setopt($ch,CURLOPT_HEADER,0); 
$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$responseObject = json_decode($response,true);




if($user_permissions->payout_type =='1'){
   
   $user_charge_percentage = $userspermisionamount; 
}else{
     $user_charge_payment = $userspermisionamount; 
}


$paymenthidata = array(
    'agent_id' =>  $id,
    'order_id' => rand(9999999999,1000000000),
    'transactionid' => 'PHSTS'.rand(9999999999,1000000000),
    'acquirer_message' => $responseObject['data']['acquirer_message'],
    'amount' => $responseObject['data']['amount'] / 100,
    'bank_reference_id' => $responseObject['data']['bank_reference_id'],
    'beneficiary' => $responseObject['data']['beneficiary'],
    'fees' => $responseObject['data']['fees']/100,
    'payout_id' =>$responseObject['data']['id'],
    'account_number' => $responseObject['data']['metadata']['account_number'],
    'ifsc_code' => $responseObject['data']['metadata']['ifsc_code'],
    'payment_method' =>  $responseObject['data']['payment_method'],
    'payout_status' =>  $responseObject['data']['status'],
    'payout_changes' => $chargeamount,
    'payout_totalamount' => $totalamount,
    'user_change_percentage' => isset($user_charge_percentage) ? $user_charge_percentage.'.%.' : null,
    'user_change_payment' => isset($user_charge_payment) ? $user_charge_payment : null,
    'updated_at'  => date('Y-m-d H:i:s'),
    'created_at'  => date('Y-m-d H:i:s'),
    'strtotime' => strtotime(date('Y-m-d H:i:s')),
    );
    
    
    
$datacode = DB::table('payout_histories')->insert($paymenthidata);


walletLog($payment_status,$userRole,$user_data->id,$services_id,$message,$userIp,$totalamount);

if($datacode == true){
$updatewallete = $walleteamount - $totalamount;
$updateamount  = array(
'wallet' => $updatewallete,
);
$addbeninumber =  Agent::where('id',$id)->update($updateamount);
$data['results'] = 'success';
$data['massage'] = 'Successful Payment Transaction';  
    
}else{
$data['results'] = 'failed';
$data['massage'] = 'There is No Balance in Your Account';    
}

}
}

}

}

echo json_encode($data);

}


function transaction_history(Request $request){
    
            $aid = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($aid)){
    $user = DB::table('agents')->where('email',$aid)->first();
$query = DB::table('payout_histories')->where('agent_id',$user->id)->orderby('id','DESC');



   if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->input('from_date'));
    }

    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->input('to_date'));
    }

    if ($request->filled('status')) {
        $query->where('payout_status', $request->input('status'));
    }

    if ($request->filled('transaction_id')) {
        $query->where('transactionid', 'like', '%' . $request->input('transaction_id') . '%');
    }

$data['txnhistoy'] = $query->paginate(10);
$data['old_input'] = $request->all();

    return view('backend/Agent/Payout/transaction-history',$data)->withInput($data['old_input']);
        }else{
        return redirect('agent/login');
    }
}



 public function transaction_history_data(Request $request,$id){
        
             $aid = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($aid)){
            
            
$data['txndata'] = DB::table('payout_histories')->where('id',$id)->first();
        return view('backend/Agent/Payout/transaction-history-data',$data);
    }else{
        return redirect('agent/login');
    }
     
 }
 
 
 public function payout_invoice(Request $request,$id){
        
             $aid = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($aid)){
            
            $did = Crypt::decrypt($id);
            
$data['txndata'] = DB::table('payout_histories')
    ->join('payout_beneficiaries_adds', 'payout_beneficiaries_adds.account_number', '=', 'payout_histories.account_number')
    ->join('agents', 'agents.id', '=', 'payout_histories.agent_id')
    ->select(
        'agents.name as agentname',
        'agents.*',
        'payout_beneficiaries_adds.*',
        'payout_histories.created_at as payoutcreated_at',
        'payout_histories.*',
        'agents.address as agentaddress',
        'agents.mobile_number as agentmobile'
    )
    ->where('payout_histories.id', $did)
    ->first();

        return view('backend/Agent/Invoice/Payout/payout-invoice',$data);
    }else{
        return redirect('agent/login');
    }
     
 }
 
 

 
 
 /********************************************************************************************************PAYOUT START******************************************************************************************************/


 
 
function payout (Request $request){
$aid = $request->session()->get('AGENT_EMAIL');
        
if(!empty($aid)){
            $userData['userData'] = Agent::where('email',$aid)->first();
            
$payment_status = '0';
$services_id = '2';
$message = 'Payout Withdrawl';
$userRole = "2";
$userIp = $request->ip();
$activity = '17';
$weburl = $_SERVER['REQUEST_URI'];


LogService::logs($activity,$weburl,$userData['userData']->id,$userRole,$userIp);
            
        return view('backend/Agent/Payout/payout',$userData);
    }else{
        return redirect('agent/login');
    }
 }
 

function payouttransfar(Request $request){
    
    //$data  = $request->all();
    
    
    
    $id = $request->session()->get('AGENT_ID');


$requestedAmount = $request->amount;

$chargesCollection = DB::table('agent_payout_charges')
    ->where('agent_id', $id)
    ->get();



$user_permissions = agentpermissions::where('user_id',$id)->first();  
$user_data  = Agent::where('id',$id)->first(); 

 
    
$default_payout_changescount = $chargesCollection->count();

$payment_status = '0';
$services_id = '2';
$message = 'Agent Payout';
$userRole = "2";
$userIp = $request->ip();
$activity = '34';
$weburl = $_SERVER['REQUEST_URI'];


LogService::logs($activity,$weburl,$user_data->id,$userRole,$userIp);

if($default_payout_changescount > 0){
    $chargesCollection = DB::table('agent_payout_charges')
    ->where('agent_id', $id)
    ->get();
    $userspermisionamount = null;
    
    foreach ($chargesCollection as $charge) {
    if ($charge->start_price <= $requestedAmount && $charge->last_price >= $requestedAmount) {
        $userspermisionamount = $charge->charges_amount;
        break;
    }
}


if (!$userspermisionamount) {
    $userspermisionamount = $user_permissions->default_payout_changes;
}

if($user_permissions->payout_type =='1'){
   
   $chargeamount =  $request->amount*$userspermisionamount/100; 
   
}else{
$chargeamount = $userspermisionamount; 

}

}else{
$chargeamount = $user_permissions->default_payout_changes; 

}

$totalamount =  $chargeamount + $request->amount;

$walleteamount = $user_data->wallet;

$userspermisionamount1 = DB::table('system_settings')->where('id','1')->first();


if($userspermisionamount1->payout_server == '0'){
   $data['results'] = 'error';
   $data['massage'] = 'Payment server is down, please try again sometime.';
}else{
    
    if($user_data->beneficiary_id != null){
    
if(payoutbalance() < $request->amount){
   $data['results'] = 'error';
   $data['massage'] = 'Payment server is down, please try again sometime.';  
}else{    

if($request->amount > $user_permissions->payout_limit){
   $data['results'] = 'error';
   $data['massage'] = 'You can send money only for less than Rs '.$user_permissions->payout_limit;
}else{

if($walleteamount < $totalamount){

   $data['results'] = 'error';
   $data['massage'] = 'There is No Balance in Your Account';    

}else{    

$secret = payout_secrect();
$access_key = payout_access_key();


$url = "https://api.frenzopay.com/api/v1/payout/";
$fields = [
    'beneficiary_id' => $request->beneficiary_id,
    'amount'        => $request->amount*100,
    'payment_method'   => $request->payment_type,
];

$recorddata = json_encode($fields);
$x_timestamp  = floor(microtime(true) * 1000);
$path = "/api/v1/payout/";

$signature =  calculate_hmac($secret, $x_timestamp,$recorddata,$path,'','POST');


// print_r($signature);
// die;

$header_data = array(
	"Content-Type: application/json",
	"Accept: application/json",
	"access_key:".$access_key ,
	"signature:". $signature,
	"X-Timestamp:".$x_timestamp,
);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $recorddata);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch,CURLOPT_HTTPHEADER,$header_data); 
curl_setopt($ch,CURLOPT_HEADER,0); 
$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$responseObject = json_decode($response,true);

if($user_permissions->payout_type =='1'){
   
   $user_charge_percentage = $userspermisionamount; 
}else{
     $user_charge_payment = $userspermisionamount; 
}



$paymenthidata = array(
    'agent_id' =>  $user_data->agent_id,
    'user_id' =>  $id,
    'user_role' =>  $user_data->role,
    'order_id' => rand(9999999999,1000000000),
    'transactionid' => 'PHSTS'.rand(9999999999,1000000000),
    'acquirer_message' => isset($responseObject['data']['acquirer_message']) ? $responseObject['data']['acquirer_message'] : null,
    'amount' => isset($responseObject['data']['amount']) ? $responseObject['data']['amount'] / 100 : null,
    'bank_reference_id' => isset($responseObject['data']['bank_reference_id']) ? $responseObject['data']['bank_reference_id'] : null,
    'beneficiary' => isset($responseObject['data']['beneficiary']) ? $responseObject['data']['beneficiary'] : null,
    'fees' => isset($responseObject['data']['fees']) ? $responseObject['data']['fees']/100 : null,
    'payout_id' =>isset($responseObject['data']['id']) ? $responseObject['data']['id'] : null,
    'account_number' => isset($responseObject['data']['metadata']['account_number'])  ? $responseObject['data']['metadata']['account_number'] : null,
    'vpa' => isset($responseObject['data']['metadata']['vpa']) ? $responseObject['data']['metadata']['vpa'] : null,
    'ifsc_code' => isset($responseObject['data']['metadata']['ifsc_code']) ? $responseObject['data']['metadata']['ifsc_code'] : null,
    'payment_method' =>  isset($responseObject['data']['payment_method']) ? $responseObject['data']['payment_method'] : null,
    'payout_status' =>  isset($responseObject['data']['status']) ? $responseObject['data']['status'] : null,
    'payout_charges' => $chargeamount,
    'payout_totalamount' => $totalamount,
    'user_charge_percentage' =>isset($user_charge_percentage) ? $user_charge_percentage.'.%.' : null,
    'user_charge_payment' => isset($user_charge_payment) ? $user_charge_payment : null,
    'updated_at'  => date('Y-m-d H:i:s'),
    'created_at'  => date('Y-m-d H:i:s'),
    'strtotime' => strtotime(date('Y-m-d H:i:s')),
    );
    
    
    
$datacode = DB::table('agentpayouthistories')->insert($paymenthidata);

if($datacode == true){
$updatewallete = $walleteamount - $totalamount;
$updateamount  = array(
'wallet' => $updatewallete,
);
$addbeninumber =  Agent::where('id',$id)->update($updateamount);



walletLog($payment_status,$userRole,$user_data->id,$services_id,$message,$userIp,$totalamount);


$data['results'] = 'success';
$data['massage'] = 'Successful Payment Transaction';  
    
}else{
$data['results'] = 'failed';
$data['massage'] = 'There is No Balance in Your Account';    
}

}
}

}
}else{
    
   $data['results'] = 'error';
   $data['massage'] = 'Your account is not verified please contact administrator'; 
}
}
// return view('backend/Agent/Payout/payout', compact('data'));
    
return response()->json([$data]);
    
    
    
}



function payouttxn(Request $request){
    
            $aid = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($aid)){
    $user = DB::table('agents')->where('email',$aid)->first();
$query = DB::table('agentpayouthistories')->where('user_id',$user->id)->orderby('id','DESC');



   if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->input('from_date'));
    }

    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->input('to_date'));
    }

    if ($request->filled('status')) {
        $query->where('payout_status', $request->input('status'));
    }

    if ($request->filled('transaction_id')) {
        $query->where('transactionid', 'like', '%' . $request->input('transaction_id') . '%');
    }

$data['txnhistoy'] = $query->paginate(10);
$data['old_input'] = $request->all();

    return view('backend/Agent/Payout/payouttxn',$data)->withInput($data['old_input']);
        }else{
        return redirect('agent/login');
    }
}
    

}
