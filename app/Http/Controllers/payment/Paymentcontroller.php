<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dipesh79\LaravelPhonePe\LaravelPhonePe;
use Razorpay\Api\Api;
use DB;
use App\Models\wallet_recharge;
use App\Models\Agent;
use Illuminate\Support\Str;
use Ixudra\Curl\Facades\Curl;

class Paymentcontroller extends Controller
{

    
    public function paymentaddmoney(Request $request)
{



           
if($request->paymentmode == '1'){

$request->validate([
'amount' => 'required',
'paymentmode' => 'required',
]);

$amount = $request->amount;
$tran_id = 'PHSTS' . uniqid();

$adminemail = $request->session()->get('SUPERADMIN_EMAIL');


$request->session()->put('paymentmode',$request->paymentmode);


if($adminemail){

$request->session()->put('SUPERADMIN_PAYMENT',true);

$superadmin =  DB::table('ph_super_admins')->where('email',$request->session()->get('SUPERADMIN_EMAIL'))->first();



$data = array (
'merchantId' => 'PGTESTPAYUAT',
'merchantTransactionId' => $tran_id,
'merchantUserId' => 'MUID123',
'amount' => $amount*100,
'redirectUrl' => route('payment.phoneperesponse'),
'redirectMode' => 'POST',
'callbackUrl' => route('payment.phoneperesponse'),
'mobileNumber' => $superadmin->mobile,
'paymentInstrument' => 
array (
'type' => 'PAY_PAGE',
),
);

$encode = base64_encode(json_encode($data));

$saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
$saltIndex = 1;

$string = $encode.'/pg/v1/pay'.$saltKey;
$sha256 = hash('sha256',$string);

$finalXHeader = $sha256.'###'.$saltIndex;

$url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";

$response = Curl::to($url)
->withHeader('Content-Type:application/json')
->withHeader('X-VERIFY:'.$finalXHeader)
->withData(json_encode(['request' => $encode]))
->post();

$rData = json_decode($response);

return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);

}else{
    
    
$usesrdata =  DB::table('agents')->where('email',$request->session()->get('AGENT_EMAIL'))->first();

$role=  DB::table('roles')->where('id',$usesrdata->role)->first();
$checkpaymentlimt =  DB::table('agentpermissions')->where('user_id',$usesrdata->id)->where('role',$role->id)->first();   

// print_r($checkpaymentlimt);
// die;

if($checkpaymentlimt->wallet_status == '1'){
if($checkpaymentlimt->wallet_limit >= $request->amount){

$request->session()->put('AGENT_PAYMENT',true);
$usesrdata =  DB::table('agents')->where('email',$request->session()->get('AGENT_EMAIL'))->first();
$data = array (
'merchantId' => 'PGTESTPAYUAT',
'merchantTransactionId' => $tran_id,
'merchantUserId' => 'MUID123',
'amount' => $amount*100,
'redirectUrl' => route('payment.phoneperesponse'),
'redirectMode' => 'POST',
'callbackUrl' => route('payment.phoneperesponse'),
'mobileNumber' => $usesrdata->mobile_number,
'paymentInstrument' => 
array (
'type' => 'PAY_PAGE',
),

);

$encode = base64_encode(json_encode($data));

$saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
$saltIndex = 1;

$string = $encode.'/pg/v1/pay'.$saltKey;
$sha256 = hash('sha256',$string);

$finalXHeader = $sha256.'###'.$saltIndex;

$url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";

$response = Curl::to($url)
->withHeader('Content-Type:application/json')
->withHeader('X-VERIFY:'.$finalXHeader)
->withData(json_encode(['request' => $encode]))
->post();

$rData = json_decode($response);

return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);
}else{
return back()->with('error','Your Maximun Add Money Limit Only ₹'.$checkpaymentlimt->wallet_limit.'');
}}else{
return back()->with('error','Your account has been temporarily blocked. Please contact our support team for further assistance.');
}
}

}else if ($request->paymentmode == '2') {

$ip = $request->ip();
if($request->session()->get('SUPERADMIN_EMAIL')){



$input = $request->all();

$api = new Api("rzp_live_eQn2rG7gwqwLMo", "vIP9NVLT9ytg2SQKvIphrbD5");

if (count($input) && !empty($input['razorpay_payment_id'])) {
try {

$payment = $api->payment->fetch($request->razorpay_payment_id);
$data =    $payment->capture(array('amount' => $payment['amount']));

$superadmin =  DB::table('ph_super_admins')->where('email',$request->session()->get('SUPERADMIN_EMAIL'))->first();
$role=  DB::table('roles')->where('id',$superadmin->role)->first();

$userIp = $request->ip();

walletLog('1',$role->id,$superadmin->id,'4','Money Added To Wallet',$userIp,$request->amount);

if($data->status == 'captured'){

$paymentstatus = 'success';

}else{
$paymentstatus = 'failed';
}

$payInfo = [
'amount' => $request->amount,
'paymentMode' => $request->paymentmode,
'tran_id' => 'PHSTS' . uniqid(),
'status' => $paymentstatus,
'user_id' => $superadmin->id,
'roleid' =>$role->id,
'payment_id' =>$request->razorpay_payment_id,
'ip' => $ip,
'charge' => '',
'wallet_balance' => $request->amount,
];

$result = wallet_recharge::create($payInfo);

$adminwallet = DB::table('ph_super_admins')->find($superadmin->id);
if($paymentstatus=='success'){
if ($adminwallet) {
DB::table('ph_super_admins')
->where('id', $superadmin->id)
->update(['wallet' => $adminwallet->wallet + $request->amount]);
}
}

$result->order_id = 'ORDER' . str_pad($result->id, 6, '0', STR_PAD_LEFT);
$result->save(); 


return response()->json(['success' => true]);
} catch (\Exception $e) {
return response()->json(['success' => false, 'error' => $e->getMessage()]);
}
}
} elseif($request->session()->get('AGENT_EMAIL')){


$input = $request->all();

$api = new Api("rzp_live_eQn2rG7gwqwLMo", "vIP9NVLT9ytg2SQKvIphrbD5");

if (count($input) && !empty($input['razorpay_payment_id'])) {
try {
$payment = $api->payment->fetch($request->razorpay_payment_id);
$data =    $payment->capture(array('amount' => $payment['amount']));

$usesrdata =  DB::table('agents')->where('email',$request->session()->get('AGENT_EMAIL'))->first();
$role=  DB::table('roles')->where('id',$usesrdata->role)->first();
$permission=  DB::table('agentpermissions')->where('user_id',$usesrdata->id)->first();

$lsatamount= $request->amount;


$userIp = $request->ip();

walletLog('1',$role->id,$usesrdata->id,'4','Money Added To Wallet',$userIp,$request->amount);

  if($permission->wallet_load_type=='1'){
      
      
   $balance = $lsatamount - ($lsatamount * $permission->wallet_load_charge / 100);
    $charge=  $lsatamount-$balance;
  }else{
      
            $balance = $lsatamount - $permission->wallet_load_charge;
            $charge=  $lsatamount-$balance;
  }



if($data->status == 'captured'){

$paymentstatus = 'success';

}else{
$paymentstatus = 'failed';
}

$payInfo = [
'amount' => $lsatamount,
'paymentMode' => $request->paymentmode,
'tran_id' => 'PHSTS' . uniqid(),
'status' => $paymentstatus,
'user_id' => $usesrdata->id,
'roleid' =>$role->id,
'payment_id' =>$request->razorpay_payment_id,
'ip' => $ip,
'charge' => $charge,
'wallet_balance' => $balance,
'wallet_load_type' =>$permission->wallet_load_type,
'wallet_load_charge' =>$permission->wallet_load_charge,
];


$result = wallet_recharge::create($payInfo);

$agentwallet = DB::table('agents')->find($usesrdata->id);
if($paymentstatus=='success'){
if ($agentwallet) {
DB::table('agents')
->where('id', $usesrdata->id)
->update(['wallet' => $agentwallet->wallet + $balance]);
}
}
$result->order_id = 'ORDER' . str_pad($result->id, 6, '0', STR_PAD_LEFT);
$result->save(); 

return response()->json(['success' => true]);
} catch (\Exception $e) {
return response()->json(['success' => false, 'error' => $e->getMessage()]);
}
}

}



}else if ($request->paymentmode == '3') {


$input = $request->all();

$input['amount'] = '1';
$input['order_id'] = "123BCD";
$input['currency'] = "INR";
$input['redirect_url'] = route('payment.cc-response');
$input['cancel_url'] = route('payment.cc-response');
$input['language'] = "EN";
$input['merchant_id'] = "3212743";

$merchant_data = "";

$working_key = 'D20F87C33C7CFB63F3B511E4E230A573'; //Shared by CCAVENUES
$access_code = 'AVWL52LA85CC12LWCC'; //Shared by CCAVENUES

$input['merchant_param1'] = "some-custom-inputs"; // optional parameter
$input['merchant_param2'] = "some-custom-inputs"; // optional parameter
$input['merchant_param3'] = "some-custom-inputs"; // optional parameter
$input['merchant_param4'] = "some-custom-inputs"; // optional parameter
$input['merchant_param5'] = "some-custom-inputs"; // optional parameter
foreach ($input as $key => $value) {
$merchant_data .= $key . '=' . $value . '&';
}

$encrypted_data = $this->encryptCC($merchant_data, $working_key);
$url = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest=' . $encrypted_data . '&access_code=' . $access_code;

return redirect($url);



}

///}else{
    
 //   return redirect('superadmin/index');
    
/// }

}
        
        
     public function ccResponse(Request $request)
{
    try {
        $workingKey = 'D20F87C33C7CFB63F3B511E4E230A573'; //Working Key should be provided here.
        $encResponse = $_POST["encResp"];

        $rcvdString = $this->decryptCC($encResponse, $workingKey);      
        $order_status = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
        return response()->json(['success' => true, $dataSize]);
}catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}

public function encryptCC($plainText, $key)
{
    $key = $this->hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    $encryptedText = bin2hex($openMode);
    return $encryptedText;
}

public function decryptCC($encryptedText, $key)
{
    $key = $this->hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText = $this->hextobin($encryptedText);
    $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    return $decryptedText;
}

public function pkcs5_padCC($plainText, $blockSize)
{
    $pad = $blockSize - (strlen($plainText) % $blockSize);
    return $plainText . str_repeat(chr($pad), $pad);
}

public function hextobin($hexString)
{
    $length = strlen($hexString);
    $binString = "";
    $count = 0;
    while ($count < $length) {
        $subString = substr($hexString, $count, 2);
        $packedString = pack("H*", $subString);
        if ($count == 0) {
            $binString = $packedString;
        } else {
            $binString .= $packedString;
        }

        $count += 2;
    }
    return $binString;
}
        
      
    public function phoneperesponse(Request $request)
{
    

    
    if($request->session()->get('SUPERADMIN_PAYMENT')){
        
        
        
        
        $superadmin =  DB::table('ph_super_admins')->where('email',$request->session()->get('SUPERADMIN_EMAIL'))->first();
        $role=  DB::table('roles')->where('id',$superadmin->role)->first();
        
        
        

        
        $phonepe = new LaravelPhonePe();
 $response = $phonepe->getTransactionStatus($request->all());

$lsatamount= $request->amount/100;


$userIp = $request->ip();

walletLog('1',$role->id,$superadmin->id,'4','Money Added To Wallet',$userIp,$request->amount/100);

if($request->code == 'PAYMENT_SUCCESS'){
    
    $paymentstatus = 'success';
    
}else{
    $paymentstatus = 'failed';
}





$result = wallet_recharge::create([
    
    'amount' => $lsatamount,
    'paymentMode' => $request->session()->get('paymentmode'),
    'tran_id' => $request->transactionId,
    'merchant_id' => $request->merchantId,
    'status' => $paymentstatus,
    'user_id' => $superadmin->id,
    'roleid' =>$role->id,
    'providerReferenceId' =>$request->providerReferenceId,
    'payment_id' =>$request->payment_id,
    'ip' => $request->ip(),
    'charge' => '',
    'checksum' => $request->checksum,
    'wallet_balance' => $request->amount/100,
    ]);
    
    
               $result->order_id = 'ORDER' . str_pad($result->id, 6, '0', STR_PAD_LEFT);
    $result->save(); 

$request->session()->forget('paymentmode');
$request->session()->forget('SUPERADMIN_PAYMENT');
$superadminwallet = DB::table('ph_super_admins')->find($superadmin->id);

if($paymentstatus=='success'){
if ($superadminwallet) {
    DB::table('ph_super_admins')
        ->where('id', $superadmin->id)
        ->update(['wallet' => $superadminwallet->wallet + $lsatamount]);
}
}

 if($result){

return redirect('superadmin/index');
 }
 else
 {
   echo "Payment Failed";       
 }
}else if($request->session()->get('AGENT_PAYMENT')){
        
        $usesrdata =  DB::table('agents')->where('email',$request->session()->get('AGENT_EMAIL'))->first();
        $role=  DB::table('roles')->where('id',$usesrdata->role)->first();
        $permission=  DB::table('agentpermissions')->where('user_id',$usesrdata->id)->first();
        

$userIp = $request->ip();

walletLog('1',$role->id,$usesrdata->id,'4','Money Added To Wallet',$userIp,$request->amount/100);
        
$phonepe = new LaravelPhonePe();
 $response = $phonepe->getTransactionStatus($request->all());

$lsatamount= $request->amount/100;

  if($permission->wallet_load_type=='1'){
      
      
   $balance = $lsatamount - ($lsatamount * $permission->wallet_load_charge / 100);
    $charge=  $lsatamount-$balance;
  }else{
      
     $balance = $lsatamount - $permission->wallet_load_charge;
      $charge=  $lsatamount-$balance;
  }

if($request->code == 'PAYMENT_SUCCESS'){
    
    $paymentstatus = 'success';
    
}else{
    $paymentstatus = 'failed';
}

$result = wallet_recharge::create([
    
    'amount' => $lsatamount,
    'paymentMode' => $request->session()->get('paymentmode'),
    'tran_id' => $request->transactionId,
    'merchant_id' => $request->merchantId,
    'status' => $paymentstatus,
    'user_id' => $usesrdata->id,
    'roleid' =>$role->id,
     'providerReferenceId' =>$request->providerReferenceId,
    'payment_id' =>$request->payment_id,
    'ip' => $request->ip(),
    'charge' => $charge,
    'checksum' => $request->checksum,
    'wallet_balance' => $balance,
    'wallet_load_type' =>$permission->wallet_load_type,
     'wallet_load_charge' =>$permission->wallet_load_charge,
    ]);
    
    
    $result->order_id = 'ORDER' . str_pad($result->id, 6, '0', STR_PAD_LEFT);
    $result->save(); 

$request->session()->forget('paymentmode');
$request->session()->forget('AGENT_PAYMENT');


if($paymentstatus=='success'){
$agent = Agent::find($usesrdata->id); 
if ($agent) {
    $agent->wallet += $balance; 
    $agent->save();
}
}



 if($result){

return redirect('agent/index');
 }
 else
 {
   echo "Payment Failed";       
 }
}

        
    }
    
 
 
 function paymentrequset(Request $request){
     
     $request->validate([
         
         'amount' => 'required',
         'payment_mode' => 'required',

         
         
         
         ]);
        
        $usesrdata =  DB::table('agents')->where('email',$request->session()->get('AGENT_EMAIL'))->first();
        $role=  DB::table('roles')->where('id',$usesrdata->role)->first();
        $permission=  DB::table('agentpermissions')->where('user_id',$usesrdata->id)->first();
        $amount = $request->amount;

$userIp = $request->ip();


  if($permission->wallet_load_type=='1'){
      
      
   $balance = $amount - ($amount * $permission->wallet_load_charge / 100);
    $charge=  $amount-$balance;
  }else{
      
     $balance = $amount - $permission->wallet_load_charge;
      $charge=  $amount-$balance;
  }
  
  
  if ($request->hasFile('payment_screenshot')) {
    $image1 = $request->file('payment_screenshot');
    $Extension = $image1->getClientOriginalExtension();
    $payment_screenshot =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/payment-requset');
    $image1Path = $destinationPath. "/".  $payment_screenshot;
    $image1->move($destinationPath, $payment_screenshot);
  }
  
  
     $tran_id = 'PHSTS' . uniqid();
     $result = wallet_recharge::create([
    'tran_id' =>$tran_id,
    'paymentMode' =>'4',
    'amount' => $amount,
    //'payment_screenshot' => $payment_screenshot,
    'payment_request_id' => $request->payment_request_id,
    'payment_mode' => $request->payment_mode,
    'user_id' => $usesrdata->id,
    'roleid' =>$role->id,
    'ip' => $request->ip(),
    'charge' => $charge,
    'checksum' => $request->checksum,
    'wallet_balance' => $balance,
    'wallet_load_type' =>$permission->wallet_load_type,
    'wallet_load_charge' =>$permission->wallet_load_charge,
    'status'=>'pending'
    ]);
    
    
    $result->order_id = 'ORDER' . str_pad($result->id, 6, '0', STR_PAD_LEFT);
    $result->save(); 
   return back()->with('success','Payment Requset Successfull');
 }
    
    
}
