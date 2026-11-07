<?php

namespace App\Http\Controllers\Softwareapi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
use App\Models\allmassageapis;
use App\Models\agentpermissions;
use App\Models\Agent;
use App\Models\recharge;
use App\Models\AEPSOnboarding;
use App\Models\aeps_2factor_register;
use App\Models\TxnMerchantAuthenticity;
use App\Models\aepsEnquiry;
use App\Models\aepsWithdrawl;
use App\Models\aepsMiniStatement;
use App\Models\system_setting;
use App\Models\Ministatement;
use App\Models\aepstxnstatus;
use App\Models\mobile_recharege_tex;
use App\Models\balance_withdrawl_tax;
use session;
use Crypt;
use App\Services\LogService;
use GuzzleHttp\Client;
use stdClass;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Cache;

class Aepscontroller extends Controller
{
    
    
    
/***************************************************************************Onboarding Start*************************************************************/

public function agentOnboarding(Request $request){
             $id = $request->session()->get('AGENT_ID');
          
        if(!empty($id)){
             $user = Agent::where('id',$id)->first();
             $Onboarding = AEPSOnboarding::where('user_id', $user->id)->first();
             
                      
                            
if (isset($Onboarding)) {
 
    if ($Onboarding->Bank2 == 1) {
        $pipe = 'bank2'; 
    } elseif ($Onboarding->Bank3 == 1) {
        $pipe = 'bank3'; 
    } else {
        $pipe = 'No bank selected'; 
    }
} else {
    $pipe = 'Onboarding record not found'; 
}
             
             $client = new Client();
             
    
        
        try {
            $response = $client->request('POST', getonboardstatus(), [
  

                   'body' => '{"merchantcode":"'.$user->agent_id.'","mobile":"'.$user->mobile_number.'","pipe":"'.$pipe.'"}',
                   'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseDataStatus = json_decode($body, true);
            
            // print_r($responseDataStatus);
            // die;
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
 $userRole = "2";
$userIp = $request->ip();
$activity = '19';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        return view('backend/Agent/Aeps/onboarding-web',compact('user','Onboarding','responseDataStatus'));
    }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
public function proceedOnboarding(Request $request){
    $id = $request->session()->get('AGENT_ID');
   
    if (!empty($id)) {
        $user = Agent::where('id', $id)->first();
        if(agentWelletbalance($id) >= '10'){
        
        if (!$user) {
            return response()->json(['error' => 'Agent not found'], 404);
        }

        $client = new Client();

        try {
            $response = $client->request('POST', onboardurl(), [
  

                  'body' => '{"merchantcode":"'.$user->agent_id.'","mobile":"'.$user->mobile_number.'","is_new":"1","email":"'.$user->email.'","firm":"PRIMEHUB SOFT TECH SOLUTIONS PRIVATE LIMITED","callback":"https://merchant.primehubsofttechsolutions.com/aeps/agentOnboardingCallback"}',
                   'headers' => [
                     'Token' => JwtToken(),
                     'accept' => 'application/json',
                      'content-type' => 'application/json',
                      ],
                       ]);
            
            $body = $response->getBody();
            
            $responseData = json_decode($body, true);
            
            $onboardingData = AEPSOnboarding::where('merchantcode',$user->agent_id)->first();
            
if($onboardingData){
   
     AEPSOnboarding::where('merchantcode',$user->agent_id)->update([
    'createtime'=>Carbon::now()->addMinutes(5),
    'redirecturl'=>$responseData['redirecturl'],
]);  
    
}else{
  AEPSOnboarding::create([
    'phone_number' => $user->mobile_number,
    'email' => $user->email,
    'merchantcode' => $user->agent_id,
    'user_id' => $user->id,
    'user_role' => $user->role,
    'status'=>$responseData['status'],
    'response_code'=>$responseData['response_code'],
    'redirecturl'=>$responseData['redirecturl'],
    'onboard_pending'=>$responseData['onboard_pending'],
    'message'=>$responseData['message'],
    'createtime'=>Carbon::now()->addMinutes(5),
]);  
    
}
            



$payment_status = '0';
$services_id = '7';
$userRole = "2";
$userIp = $request->ip();
$activity = '20';
$weburl = $_SERVER['REQUEST_URI'];
$amount = '10';
$message = "Onboarding proceed";
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

 agentWelletbalanceUpdate($id,$amount);
walletLog($payment_status,$userRole,$id,$services_id,$message,$userIp,$amount);
        

            return back()->with('success', $responseData['message']);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            
 
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        }else {
        return back()->with('error', ' Insufficient fund in your account. Please topup your wallet before initiating transaction.');
    }

    } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}




public function agentOnboardingCallback(Request $request){
    
if(!empty($request['data'])){
$jwt = $request['data'];
$parts = explode('.', $jwt);
$header = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[0])), true);
$payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])), true);
$signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[2]));

$id = $request->session()->get('AGENT_ID');
 $user = Agent::where('id', $id)->first();
            
AEPSOnboarding::where('merchantcode', $user->agent_id)
    ->update([
        'refno' => $payload['refno'],
        'txnid' => $payload['txnid'],
        'partnerid' => $payload['partnerid'],
        'is_icici_kyc' => $payload['is_icici_kyc'],
        'Bank1' => '0',
        'Bank2' => '1',
        'Bank3' => $payload['bank']['Bank3'],
        'createtime'=>null,
        ]);
}
$jsonResponse = response()->json(['status' => 200, 'message' => 'Transaction completed successfully']);

return $jsonResponse;



    }
    




public function agentOnboardingStatus(Request $request){
    $id = $request->session()->get('AGENT_ID');
   
    if (!empty($id)) {
        $user = Agent::where('id', $id)->first();
        
        
        if (!$user) {
            return response()->json(['error' => 'Agent not found'], 404);
        }
        
        
                   $Onboarding = AEPSOnboarding::where('user_id', $user->id)->first();
                   
       
             
                      
if (isset($Onboarding)) {
 
    if ($Onboarding->Bank2 == 1) {
        $pipe = 'bank2'; 
    } elseif ($Onboarding->Bank3 == 1) {
        $pipe = 'bank3'; 
    } else {
        $pipe = 'No bank selected'; 
    }
} else {
    $pipe = 'Onboarding record not found'; 
}

            
      

        $client = new Client();
        
        try {
            $response = $client->request('POST', getonboardstatus(), [
  

                   'body' => '{"merchantcode":"'.$user->agent_id.'","mobile":"'.$user->mobile_number.'","pipe":"'.$pipe.'"}',
                   'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);
            

            $body = $response->getBody();
            $responseData = json_decode($body, true);
            

            
if (isset($responseData['is_approved']) && $responseData['is_approved'] == "Accepted" 
    && isset($responseData['response_code']) && $responseData['response_code'] == 1 
    && isset($responseData['status']) && $responseData['status'] == true) {
      
    AEPSOnboarding::where('user_id', $user->id)->update([
        'onboarding_status' => $responseData['status'],
        'message' => $responseData['message'],
        'onboard_pending' => null,
    ]);
} else {
    
    
}


$userRole = "2";
$userIp = $request->ip();
$activity = '21';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

return view('backend/Agent/Aeps/onboarding-status',compact('responseData'));
            //return back()->with('success', $responseData['message']);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}

/***************************************************************************Onboarding End*************************************************************/
/***************************************************************************agentRegistration Start*************************************************************/

public function agentRegistration (Request $request){
             $id = $request->session()->get('AGENT_ID');
          
        
        if(!empty($id)){
             $user = Agent::where('id',$id)->first();
            

$userRole = "2";
$userIp = $request->ip();
$activity = '22';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        return view('backend/Agent/Aeps/agentRegistration',compact('user'));
    }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
public function AgentKycRegistration (Request $request){
             $id = $request->session()->get('AGENT_ID');
          
        
        if(!empty($id)){
            $user = Agent::where('id',$id)->first();

    $userId = $user->id;
    $userRole = $user->role;
    $accessModeType = 'SITE';
    $adhaarNumber = $user->aadhar_number;
    $mobileNumber = $user->mobile_number;
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $referenceNo = rand(111111111111, 999999999999);
    $subMerchantId = $user->agent_id;
    $xmlData = $request->xmlData;
    $ipAddress = $request->ip();
    $timestamp = now()->format('Y-m-d H:i:s');
    


    $register = aeps_2factor_register::where('user_id',$user->id)->first();

if(!empty($register)){
if($register->status ==0){
$userData = aeps_2factor_register::where('user_id', $register->user_id)->first();;   
$userData->user_id = $userId;
$userData->user_role = $userRole;
$userData->accessmodetype = 'SITE';
$userData->adhaarnumber = $adhaarNumber;
$userData->mobilenumber = $mobileNumber;
$userData->latitude = $latitude;
$userData->longitude = $longitude;
$userData->referenceno = $referenceNo;
$userData->submerchantid = $subMerchantId;
$userData->data = $xmlData;
$userData->ipaddress = $ipAddress;
$userData->timestamp = $timestamp;
$userData->save();
    }elseif($register->status =='1'){

   $userData = new stdClass();
$userData->id = $register->id;
 
   } }else {
$userData = new aeps_2factor_register();    
$userData->user_id = $userId;
$userData->user_role = $userRole;
$userData->accessmodetype = 'SITE';
$userData->adhaarnumber = $adhaarNumber;
$userData->mobilenumber = $mobileNumber;
$userData->latitude = $latitude;
$userData->longitude = $longitude;
$userData->referenceno = $referenceNo;
$userData->submerchantid = $subMerchantId;
$userData->data = $xmlData;
$userData->ipaddress = $ipAddress;
$userData->timestamp = $timestamp;
$userData->save();
}
     $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'adhaarnumber' => $adhaarNumber,
            'mobilenumber' => $mobileNumber,
            'submerchantid' => $subMerchantId,
            'ipaddress' => $ipAddress,
            'accessmodetype' => 'SITE',
            'referenceno' => $referenceNo,
            'timestamp' => $timestamp,
            'data' => $xmlData,
        ];



        $encryptedData = EncryptionBody($request, $data);
        
                   $Onboarding = AEPSOnboarding::where('user_id', $user->id)->first();
             
                      
             if($Onboarding->Bank2=='0' && $Onboarding->Bank1=='0'){
                 
                 $api = TwofactorkycregistrationBANK3();
             }else{
                 $api = Twofactorkycregistration(); 
             }
        

             $client = new Client();

                   try {
                  $response = $client->request('POST', $api, [
                
                 'body' => '{"body":"' . $encryptedData . '"}',
                  'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);
               

      if (isset($responseData['response_code']) && $responseData['response_code'] == 1 
    && isset($responseData['status']) && $responseData['status'] == true){
      
aeps_2factor_register::where('id', $userData->id)->update([
    'status' => $responseData['status'],
    'errorcode' => $responseData['errorcode'],
    'response_code' => $responseData['response_code'],
    'message' => $responseData['message'],
]);
  
$message = 'AEPS Two Factor Registration';
$userRole = "2";
$userIp = $request->ip();
$activity = '23';
$weburl = $_SERVER['REQUEST_URI'];


LogService::logs($activity,$weburl,$id,$userRole,$userIp);

                    }else{
                        
                    }
                    
            return response()->json($responseData);        
                    
        } catch (\GuzzleHttp\Exception\ClientException $e) {
             $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
    
    if(isset($responseBody) && $responseBody){
     return response()->json($responseBody);
    }else{
        return response()->json('error', 'something went wrong');
    }
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

           
$userRole = "2";
$userIp = $request->ip();
$activity = '23';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);
    }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
/***************************************************************************agentRegistration End*************************************************************/
/***************************************************************************agentAuthenticate Start*************************************************************/
public function agentAuthenticate (Request $request){
             $id = $request->session()->get('AGENT_ID');
          
        
        if(!empty($id)){
             $user = Agent::where('id',$id)->first();
            

$userRole = "2";
$userIp = $request->ip();
$activity = '24';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        return view('backend/Agent/Aeps/agentAuthenticate',compact('user'));
    }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
public function AgentKycAuthenticate(Request $request){
             $id = $request->session()->get('AGENT_ID');
          
        
        if(!empty($id)){
            $user = Agent::where('id',$id)->first();

$userRegistrationcheck = aeps_2factor_register::where('user_id',$user->id)->where('status','1')->first();

if(!empty($userRegistrationcheck)){

    $userId = $user->id;
    $userRole = $user->role;
    $accessModeType = 'SITE';
    $adhaarNumber = $user->aadhar_number;
    $mobileNumber = $user->mobile_number;
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $referenceNo = rand(111111111111, 999999999999);
    $subMerchantId = $user->agent_id;
    $xmlData = $request->xmlData;
    $ipAddress = $request->ip();
    $timestamp = now()->format('Y-m-d H:i:s');
    

     $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'adhaarnumber' => $adhaarNumber,
            'mobilenumber' => $mobileNumber,
            'submerchantid' => $subMerchantId,
            'ipaddress' => $ipAddress,
            'accessmodetype' => 'SITE',
            'referenceno' => $referenceNo,
            'timestamp' => $timestamp,
            'data' => $xmlData,
        ];



        $encryptedData = EncryptionBody($request, $data);
        
                   $Onboarding = AEPSOnboarding::where('user_id', $user->id)->first();
             
                   if($Onboarding->Bank2=='0' && $Onboarding->Bank1=='0'){
                 
                 $api = TwofactorkycAuthenticateBANK3();
             }else{
                 $api = TwofactorkycAuthenticate(); 
             }
     
             $client = new Client();

                   try {
                  $response = $client->request('POST', $api, [
                
                 'body' => '{"body":"' . $encryptedData . '"}',
                  'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);

    
      
      if (isset($responseData['response_code']) && $responseData['response_code'] == 1 
    && isset($responseData['status']) && $responseData['status'] == true  && isset($responseData['errorcode']) && $responseData['errorcode'] == 2){
        
        
    Cache::put('AGENTAuthKycId', Crypt::encrypt($id), now()->addHours(23));
    Cache::put('AGENTAuthKyc', true, now()->addHours(23));

      
aeps_2factor_register::where('id', $userRegistrationcheck->id)->update([
    'status' => $responseData['status'],
    'errorcode' => '5',
    'response_code' => $responseData['response_code'],
    'message' => $responseData['message'],
]);
  

                    }else{
                        
                    }

$services_id = '6';
$message = 'AEPS Two Factor Registration';
$userRole = "2";
$userIp = $request->ip();
$activity = '23';
$weburl = $_SERVER['REQUEST_URI'];


LogService::logs($activity,$weburl,$id,$userRole,$userIp);
   return response()->json($responseData);
         
        } catch (\GuzzleHttp\Exception\ClientException $e) {
             $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
    
    if(isset($responseBody) && $responseBody){
     return response()->json($responseBody);
    }else{
        return response()->json(['error' =>'something went wrong']);
    }
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

           
$userRole = "2";
$userIp = $request->ip();
$activity = '23';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);
 }else{
return response()->json(['message' => 'AEPS Two Factor Authentication is not registered. please register']);


 }   }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}

/***************************************************************************agentAuthenticate End*************************************************************/
/***************************************************************************agentmerchant_authencity Start*************************************************************/
public function agentmerchant_authencity (Request $request){
             $id = $request->session()->get('AGENT_ID');
          
        
        if(!empty($id)){
             $user = Agent::where('id',$id)->first();
            

$userRole = "2";
$userIp = $request->ip();
$activity = '24';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        return view('backend/Agent/Aeps/agentmerchant_authencity',compact('user'));
    }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
public function AgentKycmerchant_authencity(Request $request){
             $id = $request->session()->get('AGENT_ID');
          
        if(!empty($id)){
            $user = Agent::where('id',$id)->first();

$userRegistrationcheck = aeps_2factor_register::where('user_id',$user->id)->where('status','1')->first();

if(!empty($userRegistrationcheck)){

    $userId = $user->id;
    $userRole = $user->role;
    $accessModeType = 'SITE';
    $adhaarNumber = $user->aadhar_number;
    $mobileNumber = $user->mobile_number;
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $referenceNo = rand(111111111111, 999999999999);
    $subMerchantId = $user->agent_id;
    $xmlData = $request->xmlData;
    $ipAddress = $request->ip();
    $timestamp = now()->format('Y-m-d H:i:s');
    

     $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'adhaarnumber' => $adhaarNumber,
            'mobilenumber' => $mobileNumber,
            'submerchantid' => $subMerchantId,
            'ipaddress' => $ipAddress,
            'accessmodetype' => 'SITE',
            'referenceno' => $referenceNo,
            'timestamp' => $timestamp,
            'data' => $xmlData,
        ];


        $encryptedData = EncryptionBody($request, $data);
        
        
                $Onboarding = AEPSOnboarding::where('user_id', $user->id)->first();
             
                   if($Onboarding->Bank2=='0' && $Onboarding->Bank1=='0'){
                 
                 $api = Twofactorkycmerchant_authencityBANK3();
             }else{
                 $api = Twofactorkycmerchant_authencity(); 
             }
        
             $client = new Client();

                   try {
                  $response = $client->request('POST', $api, [
                
                 'body' => '{"body":"' . $encryptedData . '"}',
                  'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);
            
             if (isset($responseData['errorcode']) && $responseData['errorcode'] == 0
    && isset($responseData['response_code']) && $responseData['response_code'] == 1 
    && isset($responseData['status']) && $responseData['status'] == true){
      
           $TxnMerchantAuthenticity = new TxnMerchantAuthenticity;
           $TxnMerchantAuthenticity->status = $responseData['status'];
           $TxnMerchantAuthenticity->user_id = $userId;
           $TxnMerchantAuthenticity->user_role = $userRole;
           $TxnMerchantAuthenticity->message = $responseData['message'];
           $TxnMerchantAuthenticity->MerAuthTxnId = $responseData['MerAuthTxnId'];
           
            $TxnMerchantAuthenticity->save();
            
            $request->session()->put('MerAuthTxnId', $TxnMerchantAuthenticity->MerAuthTxnId,2);
            $request->session()->put('expires_at', now()->addMinutes(2));
    
    Cache::put('bank', $request->bank, now()->addMinutes(1));
    Cache::put('adhaarnumber', $request->adhaarnumber, now()->addMinutes(1));
    Cache::put('mobilenumber', $request->mobilenumber, now()->addMinutes(1));
    Cache::put('amount', $request->amount, now()->addMinutes(1));
    Cache::put('cash', $request->cash, now()->addMinutes(1));
    Cache::put('remark', $request->remark, now()->addMinutes(1));
    Cache::put('devicetran', $request->devicetran, now()->addMinutes(1));
    Cache::put('transactiontype', $request->transactiontype, now()->addMinutes(1));
  
$services_id = '6';
$message = 'Txn Merchant Authenticity';
$userRole = "2";
$userIp = $request->ip();
$activity = '25';
$weburl = $_SERVER['REQUEST_URI'];


LogService::logs($activity,$weburl,$id,$userRole,$userIp);

                    }else{
                        
                    }


return response()->json($responseData);
         
        } catch (\GuzzleHttp\Exception\ClientException $e) {
             $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
    
    if(isset($responseBody) && $responseBody){
     return response()->json($responseBody);
    }else{
        return response()->json(['error' =>'something went wrong']);
    }
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

           
$userRole = "2";
$userIp = $request->ip();
$activity = '23';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);
 }else{
return response()->json(['message' => 'AEPS Two Factor Authentication is not registered. please register']);


 }   }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
/***************************************************************************agentmerchant_authencity End*************************************************************/
/***************************************************************************balanceenquiry Start*************************************************************/
public function balanceenquiry (Request $request){
$id = $request->session()->get('AGENT_ID');
          
        
        if(!empty($id)){
             $user = Agent::where('id',$id)->first();
            
            $client = new Client();
            
                    try {
                $response = $client->request('POST', banklist(), [
  
                   'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=> Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseData = json_decode($body, true);
            

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

$userRole = "2";
$userIp = $request->ip();
$activity = '26';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        return view('backend/Agent/Aeps/balanceenquiry',compact('user','responseData'));
    }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
public function aepsbalanceenquiry(Request $request){
             $id = $request->session()->get('AGENT_ID');
          
        if(!empty($id)){
            $user = Agent::where('id',$id)->first();
            
               
                   $Onboarding = AEPSOnboarding::where('user_id', $user->id)->first();
             
             if($Onboarding->Bank2=='0' && $Onboarding->Bank1=='0'){
                 
                 $pipe = 'bank3';
             }else{
                $pipe = 'bank2'; 
             }
            
     

    $userId = $user->id;
    $userRole = $user->role;
    $adhaarNumber = $request->input('adhaarnumber');
    $mobileNumber = $request->input('mobilenumber');
    $nationalbankidentification = $request->input('bank');
    $requestremarks = $request->input('remark');
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $pipe= $pipe;
    $referenceNo = rand(111111111111, 999999999999);
    $subMerchantId = $user->agent_id;
    $xmlData = $request->xmlData;
    $ipAddress = $request->ip();
    $timestamp = now()->format('Y-m-d H:i:s');
    $accessmodetype = 'SITE';
    $transactiontype = 'BE';
    $is_iris = 'No';
    
$aepsEnquiryData = new aepsEnquiry();
$aepsEnquiryData->user_role = $userRole;
$aepsEnquiryData->user_id = $userId;
$aepsEnquiryData->latitude = $latitude;
$aepsEnquiryData->longitude = $longitude;
$aepsEnquiryData->adhaarnumber = Str::mask($adhaarNumber, 'X', -12, 8);;
$aepsEnquiryData->mobilenumber = $mobileNumber;
$aepsEnquiryData->submerchantid = $subMerchantId;
$aepsEnquiryData->ipaddress = $ipAddress;
$aepsEnquiryData->accessmodetype = $accessmodetype;
$aepsEnquiryData->referenceno = $referenceNo;
$aepsEnquiryData->data = $xmlData;
$aepsEnquiryData->pipe = $timestamp;
$aepsEnquiryData->timestamp = $timestamp;
$aepsEnquiryData->transactiontype = $transactiontype;
$aepsEnquiryData->is_iris = $is_iris;
$aepsEnquiryData->nationalbankidentification = $nationalbankidentification;
$aepsEnquiryData->requestremarks = $requestremarks;
$aepsEnquiryData->save();



     $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'adhaarnumber' => $adhaarNumber,
            'mobilenumber' => $mobileNumber,
            'submerchantid' => $subMerchantId,
            'ipaddress' => $ipAddress,
            'accessmodetype' => $accessmodetype,
            'referenceno' => $referenceNo,
            'timestamp' => $timestamp,
            'data' => $xmlData,
            'pipe' => $pipe,
            'transactiontype' =>$transactiontype,
            'is_iris' =>$is_iris,
            'nationalbankidentification'=>$nationalbankidentification,
            'requestremarks' =>$requestremarks
        ];


        $encryptedData = EncryptionBody($request, $data);
        
    
        
             $client = new Client();

                   try {
                  $response = $client->request('POST', balanceenquiry(), [
                
                 'body' => '{"body":"' . $encryptedData . '"}',
                  'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);

// print_r($responseData);
// die;
      
   if (isset($responseData['errorcode']) && $responseData['errorcode'] == 0000 
    && isset($responseData['response_code']) && $responseData['response_code'] == 1 
    && isset($responseData['status']) && $responseData['status'] == true){
        aepsEnquiry::where('id', $aepsEnquiryData->id)->update([
            'status' => $responseData['status'],
            'message' => $responseData['message'],
            'amount' => $responseData['amount'],
            'balanceamount' => $responseData['balanceamount'],
            'bankrrn' => $responseData['bankrrn'],
            'bankiin' => $responseData['bankiin'],
            'response_code' => $responseData['response_code'],
            'errorcode' => $responseData['errorcode'],
            'clientrefno' => $responseData['clientrefno'],
            'ackno' => $responseData['ackno'],
            ]);
  
$services_id = '6';
$message = 'Balance Enquiry Proceed';
$userRole = "2";
$userIp = $request->ip();
$activity = '27';
$weburl = $_SERVER['REQUEST_URI'];


            
                    try {
                $response = $client->request('POST', banklist(), [
  
                   'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=> Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseDatabank = json_decode($body, true);
            
            
   $bankname = null;
    foreach ($responseDatabank['banklist']['data'] as $bank) {
        if ($bank['iinno'] == $aepsEnquiryData->nationalbankidentification) {
            $bankname = $bank['bankName'];
            break;
        }
    }

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
$userdata = Agent::where('id',$id)->first();
$responseDatapdfs = $responseData;
    $pdf = Pdf::loadView('backend.Agent.Aeps.balanceenquiryPdf', compact('aepsEnquiryData','bankname','responseDatapdfs','userdata'));


$fileName = 'balanceenquiryPdf' . $aepsEnquiryData->adhaarnumber . '.pdf';
    $filePath = storage_path('app/public/' . $fileName);
    $pdf->save($filePath);
    
    return response()->json([
        'status' => true,
        'message' => 'PDF generated successfully',
        'pdf_url' => asset('public/storage/' . $fileName),
        'filename' => $fileName,
        'balanceamount' =>$responseData['balanceamount']
    ]);

LogService::logs($activity,$weburl,$id,$userRole,$userIp);

                    }else{
                        
                    }


return response()->json($responseData);
         
        } catch (\GuzzleHttp\Exception\ClientException $e) {
             $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
    
    if(isset($responseBody) && $responseBody){
     return response()->json($responseBody);
    }else{
        return response()->json(['error' =>'something went wrong']);
    }
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

           


  }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
/***************************************************************************balanceenquiry End*************************************************************/
/***************************************************************************balanceWihdraw Start*************************************************************/
public function balanceWihdraw (Request $request){
$id = $request->session()->get('AGENT_ID');
          
        
        if(!empty($id)){
//             if(!empty($request->session()->has('MerAuthTxnId'))){
//  if ($request->session()->has('MerAuthTxnId') && now()->gte($request->session()->get('expires_at'))) {

//     $request->session()->forget('MerAuthTxnId');
//     $request->session()->forget('expires_at');
    
// return redirect('agent/aeps/agentmerchant_authencity')->with('error','Agent is not authorized Please authorized');
    
// }else{
             $user = Agent::where('id',$id)->first();
            
            $client = new Client();
            
                    try {
                $response = $client->request('POST', banklist(), [
  
                   'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=> Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseData = json_decode($body, true);
            

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

$userRole = "2";
$userIp = $request->ip();
$activity = '28';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        return view('backend/Agent/Aeps/balanceWihdraw',compact('user','responseData'));
    }   
    
//     }else{
//   return redirect('agent/aeps/agentmerchant_authencity')->with('error','Agent is not authorized Please authorized');  
// }
   // }
    else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
public function aepsbalancewihdraw(Request $request){
             $id = $request->session()->get('AGENT_ID');
        if(!empty($id)){
            if(!empty($request->session()->has('MerAuthTxnId'))){
           if ($request->session()->has('MerAuthTxnId') && now()->gte($request->session()->get('expires_at'))) {

    $request->session()->forget('MerAuthTxnId');
    $request->session()->forget('expires_at');
    
return redirect('agent/aeps/agentmerchant_authencity')->with('error','Agent is not authorized Please authorized');
    
}else{
    
    $services_id = '6';
$message = 'Bank Withdrawl';
$userRole = "2";
$userIp = $request->ip();
$activity = '29';
$weburl = $_SERVER['REQUEST_URI'];
$payment_status = '1';
            
 $user = Agent::where('id',$id)->first();
 
         $Onboarding = AEPSOnboarding::where('user_id', $user->id)->first();
             
             if($Onboarding->Bank2=='0' && $Onboarding->Bank1=='0'){
                 
                 $pipe = 'bank3';
             }else{
                $pipe = 'bank2'; 
             }

    $userId = $user->id;
    $userRole = $user->role;
    $adhaarNumber = $request->input('adhaarnumber');
    $mobileNumber = $request->input('mobilenumber');
    $nationalbankidentification = $request->input('bank');
    $requestremarks = $request->input('remark');
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $pipe= $pipe;
    $referenceNo = rand(111111111111, 999999999999);
    $subMerchantId = $user->agent_id;
    $xmlData = $request->xmlData;
    $ipAddress = $request->ip();
    $timestamp = now()->format('Y-m-d H:i:s');
    $accessmodetype = 'SITE';
    $transactiontype = 'CW';
    $is_iris = 'No';
    $amount = $request->input('amount');
    $MerAuthTxnId = $request->session()->get('MerAuthTxnId');
    
$aepsEnquiryData = new aepsWithdrawl();
$aepsEnquiryData->user_role = $userRole;
$aepsEnquiryData->user_id = $userId;
$aepsEnquiryData->latitude = $latitude;
$aepsEnquiryData->longitude = $longitude;
$aepsEnquiryData->adhaarnumber = Str::mask($adhaarNumber, 'X', -12, 8);
$aepsEnquiryData->mobilenumber = $mobileNumber;
$aepsEnquiryData->submerchantid = $subMerchantId;
$aepsEnquiryData->ipaddress = $ipAddress;
$aepsEnquiryData->accessmodetype = $accessmodetype;
$aepsEnquiryData->referenceno = $referenceNo;
$aepsEnquiryData->data = $xmlData;
$aepsEnquiryData->timestamp = $timestamp;
$aepsEnquiryData->pipe = $pipe;
$aepsEnquiryData->transactiontype = $transactiontype;
$aepsEnquiryData->is_iris = $is_iris;
$aepsEnquiryData->nationalbankidentification = $nationalbankidentification;
$aepsEnquiryData->requestremarks = $requestremarks;
$aepsEnquiryData->MerAuthTxnId = $MerAuthTxnId;
$aepsEnquiryData->timestamp = $timestamp;
$aepsEnquiryData->amount = $amount;
$aepsEnquiryData->save();



     $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'adhaarnumber' => $adhaarNumber,
            'mobilenumber' => $mobileNumber,
            'submerchantid' => $subMerchantId,
            'ipaddress' => $ipAddress,
            'accessmodetype' => $accessmodetype,
            'referenceno' => $referenceNo,
            'timestamp' => $timestamp,
            'data' => $xmlData,
            'pipe' => $pipe,
            'transactiontype' =>$transactiontype,
            'is_iris' =>$is_iris,
            'nationalbankidentification'=>$nationalbankidentification,
            'requestremarks' =>$requestremarks,
            'amount' =>$amount,
            'MerAuthTxnId' =>$MerAuthTxnId
        ];


        $encryptedData = EncryptionBody($request, $data);
        
 
        
             $client = new Client();

                  try {
                  $response = $client->request('POST', authcashwithdraw(), [
                
                 'body' => '{"body":"' . $encryptedData . '"}',
                  'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                      ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);

Cache::forget('bank');
Cache::forget('transactiontype');
Cache::forget('adhaarnumber');
Cache::forget('mobilenumber');
Cache::forget('amount');
Cache::forget('remark');
Cache::forget('devicetran');

            // print_r($responseData);
            // die;

      if (isset($responseData['errorcode']) && $responseData['errorcode'] == 0 
    && isset($responseData['response_code']) && $responseData['response_code'] == 1 
    && isset($responseData['status']) && $responseData['status'] == true) {
      
        aepsWithdrawl::where('id', $aepsEnquiryData->id)->update([
            'status' => isset($responseData['status']) ? $responseData['status'] :'',
            'message' => isset($responseData['message']) ? $responseData['message'] : '',
            'txn_amount' => isset($responseData['amount']) ? $responseData['amount'] : '',
            'errorcode' => isset($responseData['errorcode']) ? $responseData['errorcode'] : '',
            'bankrrn' => isset($responseData['bankrrn']) ? $responseData['bankrrn'] : '',
            'response_code' => isset($responseData['response_code']) ? $responseData['response_code'] : '',
            'ackno' => isset($responseData['ackno']) ? $responseData['ackno'] : '',
            'bankiin' => isset($responseData['bankiin']) ? $responseData['bankiin'] : '',
            'clientrefno' => isset($responseData['clientrefno']) ? $responseData['clientrefno'] : '',
            'name' => isset($responseData['name']) ? $responseData['name'] : '',
            'balanceamount' => isset($responseData['balanceamount']) ? $responseData['balanceamount'] : '',
            ]);
  
$request->session()->forget('MerAuthTxnId');
$request->session()->forget('expires_at');

$wallet = agent::where('id',$id)->pluck('wallet')->first();

   $lastamount = $wallet+$responseData['amount'];

agent::where('id',$id)->update(['wallet'=>$lastamount]);
walletLog($payment_status,$userRole,$id,$services_id,$message,$userIp,$responseData['amount']);


    $chargesCollection = DB::table('balance_withdrawl_taxes')
    ->get();
    
    if($chargesCollection !=null){
    $commmisionamount = null;
    
    foreach ($chargesCollection as $charge) {
    if ($charge->start_price <= $amount && $charge->last_price >= $amount) {
        $commmisionamount = $charge;
        break;
    }
}

$walletend = agent::where('id',$id)->pluck('wallet')->first();

$commmision = $commmisionamount->commission;
$commmisionwallet = $walletend+$commmision;
agent::where('id',$id)->update(['wallet'=>$commmisionwallet]);
walletLog($payment_status,$userRole,$id,$services_id,'Bank Withdrawl Commission',$userIp,$commmision);

$tsdamount = $commmision*$commmisionamount->tax/100;
 agentWelletbalanceUpdate($id,$tsdamount);
walletLog('0',$userRole,$id,$services_id,'Bank Withdrawl Tds',$userIp,$tsdamount);
}



         try {
                $response = $client->request('POST', banklist(), [
  
                   'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=> Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseDatabank = json_decode($body, true);
            
            
   $bankname = null;
    foreach ($responseDatabank['banklist']['data'] as $bank) {
        if ($bank['iinno'] == $aepsEnquiryData->nationalbankidentification) {
            $bankname = $bank['bankName'];
            break;
        }
    }

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
$userdata = Agent::where('id',$id)->first();
$responseDatapdfs = $responseData;
    $pdf = Pdf::loadView('backend.Agent.Aeps.balanceWihdrawalPdf', compact('aepsEnquiryData','bankname','responseDatapdfs','userdata'));


$fileName = 'balanceWihdrawalPdf' . $aepsEnquiryData->adhaarnumber . '.pdf';
    $filePath = storage_path('app/public/' . $fileName);
    $pdf->save($filePath);
    
    return response()->json([
        'status' => true,
        'message' => 'PDF generated successfully',
        'pdf_url' => asset('public/storage/' . $fileName),
        'filename' => $fileName,
        'amount' =>$responseData['amount'],
        'balanceamount' =>$responseData['balanceamount']
    ]);

LogService::logs($activity,$weburl,$id,$userRole,$userIp);


                    }else{
                        
                        
                        
                    }


return response()->json($responseData);
         
        } catch (\GuzzleHttp\Exception\ClientException $e) {
             $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
    
    if(isset($responseBody) && $responseBody){
     return response()->json($responseBody);
    }else{
        return response()->json(['error' =>'something went wrong']);
    }
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

            }
}else{
  return redirect('agent/aeps/agentmerchant_authencity')->with('error','Agent is not authorized Please authorized');  
}
  }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
/***************************************************************************balanceWihdraw End*************************************************************/
/***************************************************************************ministatement Start*************************************************************/

public function ministatement (Request $request){
$id = $request->session()->get('AGENT_ID');
          

        if(!empty($id)){
             $user = Agent::where('id',$id)->first();
            
            $client = new Client();
            
                    try {
                $response = $client->request('POST', banklist(), [
  
                   'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=> Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseData = json_decode($body, true);
            

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

$userRole = "2";
$userIp = $request->ip();
$activity = '29';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        return view('backend/Agent/Aeps/ministatement',compact('user','responseData'));
    }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
public function aepsministatement(Request $request){
             $id = $request->session()->get('AGENT_ID');
          
        if(!empty($id)){
            $user = Agent::where('id',$id)->first();
            
                   $Onboarding = AEPSOnboarding::where('user_id', $user->id)->first();
             
             if($Onboarding->Bank2=='0' && $Onboarding->Bank1=='0'){
                 
                 $pipe = 'bank3';
             }else{
                $pipe = 'bank2'; 
             }


    $userId = $user->id;
    $userRole = $user->role;
    $adhaarNumber = $request->input('adhaarnumber');
    $mobileNumber = $request->input('mobilenumber');
    $nationalbankidentification = $request->input('bank');
    $requestremarks = $request->input('remark');
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $pipe= $pipe;
    $referenceNo = rand(111111111111, 999999999999);
    $subMerchantId = $user->agent_id;
    $xmlData = $request->xmlData;
    $ipAddress = $request->ip();
    $timestamp = now()->format('Y-m-d H:i:s');
    $accessmodetype = 'SITE';
    $transactiontype = 'MS';
    $is_iris = 'No';
    
$aepsMiniStatement = new aepsMiniStatement();
$aepsMiniStatement->user_role = $userRole;
$aepsMiniStatement->user_id = $userId;
$aepsMiniStatement->latitude = $latitude;
$aepsMiniStatement->longitude = $longitude;
$aepsMiniStatement->adhaarnumber = Str::mask($adhaarNumber, 'X', -12, 8);
$aepsMiniStatement->mobilenumber = $mobileNumber;
$aepsMiniStatement->submerchantid = $subMerchantId;
$aepsMiniStatement->ipaddress = $ipAddress;
$aepsMiniStatement->accessmodetype = $accessmodetype;
$aepsMiniStatement->referenceno = $referenceNo;
$aepsMiniStatement->data = $xmlData;
$aepsMiniStatement->pipe = $pipe;
$aepsMiniStatement->timestamp = $timestamp;
$aepsMiniStatement->transactiontype = $transactiontype;
$aepsMiniStatement->is_iris = $is_iris;
$aepsMiniStatement->nationalbankidentification = $nationalbankidentification;
$aepsMiniStatement->requestremarks = $requestremarks;
$aepsMiniStatement->save();



     $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'adhaarnumber' => $adhaarNumber,
            'mobilenumber' => $mobileNumber,
            'submerchantid' => $subMerchantId,
            'ipaddress' => $ipAddress,
            'accessmodetype' => $accessmodetype,
            'referenceno' => $referenceNo,
            'timestamp' => $timestamp,
            'data' => $xmlData,
            'pipe' => $pipe,
            'transactiontype' =>$transactiontype,
            'is_iris' =>$is_iris,
            'nationalbankidentification'=>$nationalbankidentification,
            'requestremarks' =>$requestremarks
        ];


        $encryptedData = EncryptionBody($request, $data);

             $client = new Client();

                  try {
                  $response = $client->request('POST', ministatement(), [
                
                 'body' => '{"body":"' . $encryptedData . '"}',
                  'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                      ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);
            
            // print_r($responseData);
            // die;
            
  if (isset($responseData['response_code']) && $responseData['response_code'] == 1 
    && isset($responseData['status']) && $responseData['status'] == true){
        aepsMiniStatement::where('id', $aepsMiniStatement->id)->update([
            'status' => $responseData['status'],
            'message' => $responseData['message'],
            'datetime' => $responseData['datetime'],
            'balanceamount' => $responseData['balanceamount'],
            'bankrrn' => $responseData['bankrrn'],
            'bankiin' => $responseData['bankiin'],
            'response_code' => $responseData['response_code'],
            'errorcode' => $responseData['errorcode'],
            'ackno' => $responseData['ackno'],
            ]);
         
         $transactions = [];
            
foreach ($responseData['ministatement'] as $data) {

    $parts = explode(' ', $data);
    
    $date = $parts[0];
    $narration = $parts[1];
    $txnIndicator = $parts[2];
   $amount = implode(' ', array_slice($parts, 3));
    
    $txnTypeFormatted = $txnIndicator == 'C' ? 'Credit' : 'Debit';
    

        
        $transactions[] = [
        'date' => $date,
        'txnType' => $txnTypeFormatted,
        'amount' => $amount,
        'narration' => $narration
    ];
    
$mini = Ministatement::create([
        'MiniStatement_id' => $aepsMiniStatement->id,
        'user_id' => $userId,
        'user_role' => $userRole,
        'bankiin' => $responseData['bankiin'],
        'ackno' => $responseData['ackno'],
        'date' => $date,
        'txnType' => $txnTypeFormatted,
        'amount' => $amount,
        'narration' => $narration,
    ]);
}

$responseDatapdf['transactions'] = $transactions;


$services_id = '6';
$userRole = "2";
$userIp = $request->ip();
$activity = '31';
$weburl = $_SERVER['REQUEST_URI'];


LogService::logs($activity,$weburl,$id,$userRole,$userIp);



            
                    try {
                $response = $client->request('POST', banklist(), [
  
                   'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=> Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseDatabank = json_decode($body, true);
            
            
   $bankname = null;
    foreach ($responseDatabank['banklist']['data'] as $bank) {
        if ($bank['iinno'] == $aepsMiniStatement->nationalbankidentification) {
            $bankname = $bank['bankName'];
            break;
        }
    }

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


// print_r($responseData);
// die;

        $responseDatapdfs = $responseData;


$userdata = Agent::where('id',$id)->first();

    $pdf = Pdf::loadView('backend.Agent.Aeps.MiniStatementpdf', compact('aepsMiniStatement','bankname','responseDatapdf','responseDatapdfs','userdata'));


$fileName = 'MiniStatementpdf' . $aepsMiniStatement->adhaarnumber . '.pdf';
    $filePath = storage_path('app/public/' . $fileName);
    $pdf->save($filePath);
    
    return response()->json([
        'status' => true,
        'message' => 'PDF generated successfully',
        'pdf_url' => asset('public/storage/' . $fileName),
        'filename' => $fileName,
        'balanceamount' =>$responseData['balanceamount']
    ]);

                    }else{
                        
                    }



         
        } catch (\GuzzleHttp\Exception\ClientException $e) {
             $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
    
    if(isset($responseBody) && $responseBody){
     return response()->json($responseBody);
    }else{
        return response()->json(['error' =>'something went wrong']);
    }
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

           


  }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}


/***************************************************************************ministatement End*************************************************************/


public function txnstatus (Request $request){
         $id = $request->session()->get('AGENT_ID');

        if(!empty($id)){
             $user = Agent::where('id',$id)->first();

$userRole = "2";
$userIp = $request->ip();
$activity = '32';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        return view('backend/Agent/Aeps/txnstatus');
    }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}
public function aepstxnstatus(Request $request){
    
    $request->validate([
        
        'reference_number' =>'required'
        ]);
    
        $id = $request->session()->get('AGENT_ID');

        if(!empty($id)){
    $user = Agent::where('id',$id)->first();
    $userId = $user->id;
    $userRole = $user->role;

     $data = [
        'reference' => $request->reference_number,
        ];
        
        $encryptedData = EncryptionBody($request, $data);
        
        


             $client = new Client();

                   try {
                  $response = $client->request('POST', txnstatus(), [
                
                 'body' => '{"body":"' . $encryptedData . '"}',
                  'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);
        // print_r($responseData);
        // die;

   if (isset($responseData['response_code']) && $responseData['response_code'] == 1 
    && isset($responseData['status']) && $responseData['status'] == true){
        aepstxnstatus::create([
            'status' => $responseData['status'],
            'message' => $responseData['message'],
            'txnstatus' => $responseData['txnstatus'],
            'bankrrn' => $responseData['bankrrn'],
            'response_code' => $responseData['response_code'],
            'amount' => $responseData['amount'],
            'ackno' => $responseData['ackno'],
            'reference_number' => $request->reference_number,
            'user_role' => $userRole,
            'user_id' => $userId,
            ]);
   
  
$services_id = '6';
$userRole = "2";
$userIp = $request->ip();
$activity = '33';
$weburl = $_SERVER['REQUEST_URI'];

LogService::logs($activity,$weburl,$id,$userRole,$userIp);

return back()->with('responseData', $responseData);

          
                    }elseif(isset($responseData['response_code']) && $responseData['response_code'] != 1){
                        return back()->with('responseDataelse', $responseData);
                    }


         
        } catch (\GuzzleHttp\Exception\ClientException $e) {
             $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
    
    if(isset($responseBody) && $responseBody){
     return response()->json($responseBody);
    }else{
        return response()->json(['error' =>'something went wrong']);
    }
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

           


  }else{
    return redirect('agent/login')->with('error','Agent is not authorized');
        }
    
}

/***************************************************************************ministatement End*************************************************************/
/***************************************************************************Recharge*************************************************************/

public function mobileRecharge(Request $request)
{
    
      $id = $request->session()->get('AGENT_ID');

  if (!empty($id)) {
        
         $client = new Client();
         
           try {
            $response = $client->request('POST', getoperator(), [
 
                 'headers' => [
                     'Token' => JwtToken(),
                     'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);
            

            

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        
     return view('backend/Agent/Aeps/mobileRecharge',compact('responseData'));
    } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}


public function hlrcheck(Request $request)
{
    
      $id = $request->session()->get('AGENT_ID');

  if (!empty($id)) {
      
               $client = new Client();
         
           try {
            $response = $client->request('POST', hlrcheck(), [
                 'body' => '{"number":'.$request->mobile_number.',"type":"mobile"}',
                 'headers' => [
                     'Token' => JwtToken(),
                     'accept' => 'application/json',
                      'content-type' => 'application/json',
                     // 'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);
            return response()->json($responseData);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

      
      
  } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}

public function browseplan(Request $request)
{

      $id = $request->session()->get('AGENT_ID');

  if (!empty($id)) {
      
            $client = new Client();
         
           try {
            $response = $client->request('POST', browseplan(), [
                 'body' => '{"circle":"'.$request->circle.'","op":"'.$request->op.'"}',
                 'headers' => [
                     'Token' => JwtToken(),
                     'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                       ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);

            return response()->json($responseData);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            return response()->json(['error' => $responseBody], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
      
      
  } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}
public function dorecharge(Request $request)
{
    
      $id = $request->session()->get('AGENT_ID');

  if (!empty($id)) {
        if(agentWelletbalance($id) >= $request->amount){
            
$payment_status = '0';
$services_id = '5';
$message = 'Mobile Recharge';
$userRole = "2";
$userIp = $request->ip();
$activity = '18';
$weburl = $_SERVER['REQUEST_URI'];
            
            $user = Agent::where('id',$id)->first();
                    $client = new Client();
         
          try {
            $response = $client->request('POST', dorecharge(), [

                 'body' => '{"operator":'.$request->operator.',"canumber":'.$request->mobile_number.',"amount":'.$request->amount.',"referenceid":"'.rand('11111111111','99999999999').'"}',
                
                 'headers' => [
                     'Token' => JwtToken(),
                     'accept' => 'application/plain',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=>Authorisedkey(),
                      ],
                      ]);

            $body = $response->getBody();
            $responseData = json_decode($body, true);
          //return response()->json($responseData);
  if ($responseData['status'] == true && $responseData['response_code'] == 1) {
      
     recharge::create([
    'status' => $responseData['status'],
    'response_code' => $responseData['response_code'],
    'operatorid' => $responseData['operatorid'],
    'ackno'=>$responseData['ackno'],
    'refid'=>$responseData['refid'],
    'message'=>$responseData['message'],
    'mobile'=>$request->mobile_number,
    'user_id'=>$user->id,
    'user_role'=>$user->role,
    'amount'=>$request->amount,
]);


$mobile_recharege_tex = mobile_recharege_tex::first();

      // Update agent's wallet balance
    agentWelletbalanceUpdate($id, $request->amount);
walletLog($responseData['status'],$userRole,$id,$services_id,$message,$userIp,$request->amount);
    // Get current wallet balance
    $wallet = agent::where('id', $id)->pluck('wallet')->first();

    // Calculate new balance with 1% increment
    
    
    
    $Commission = $request->amount * $mobile_recharege_tex->commission / 100;
    $lastamount = $wallet + $Commission;
    agent::where('id', $id)->update(['wallet' => $lastamount]);
     walletLog('1',$userRole,$id,$services_id,'Mobile Recharge Commission ',$userIp,$Commission);
    // Further update wallet balance with 2% of the last amount
    $tsdamount = $Commission * $mobile_recharege_tex->tax / 100;
 agentWelletbalanceUpdate($id,$tsdamount);
    walletLog($responseData['status'],$userRole,$id,$services_id,'Mobile Recharge TDS ',$userIp,$tsdamount);

LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        
        return back()->with('success', $responseData['message']);
    } else {
        return back()->with('error', $responseData['message']);
    }

} catch (\GuzzleHttp\Exception\ClientException $e) {
    $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
    
    if(isset($responseBody['response_code']) && $responseBody['response_code'] == '16'){
        return back()->with('error', 'server is down, please try again sometime.');
    }elseif(isset($responseBody) && $responseBody){
     return back()->with('error', $responseBody['message']);
    }else{
        return back()->with('error', 'something went wrong');
    }

} catch (\Exception $e) {
    return response()->json(['error' => $e->getMessage()], 500);
} 
            
        }else {
        return back()->with('error', ' Insufficient fund in your account. Please topup your wallet before initiating transaction.');
    }


    } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}

/*********************************************************************************************************************************************************************************/

function Wihdrawhistory(Request $request){
          $id = $request->session()->get('AGENT_ID');

  if (!empty($id)) {
      
      return view('backend/Agent/Aeps/Wihdrawhistory');
      
  } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}


function viewWihdrawhistory(Request $request){

$globalData = system_setting::first();

$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];


$Withdrawaldata = aepsWithdrawl::viewWihdrawhistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$Withdrawaldatacount = aepsWithdrawl::viewWihdrawhistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);





$i = 1;

$data = array();
foreach ($Withdrawaldata as  $row) {


if($row->status=='1'){
$status = '<span class="badge rounded-pill badge-success">Success</span>';
}else{
$status = '<span class="badge rounded-pill badge-danger">Failed</span>';
}


if($row->status=='1'){
$prient = '<i class="fa fa-print" style="font-size: 25px; color:#54BA4A;"></i>';
}else{
$prient = '<i class="fa fa-print" style="font-size: 25px; color:#ea4159;"></i>';
}

$id = $request->session()->get('AGENT_ID');
     $client = new Client();
  try {
                $response = $client->request('POST', banklist(), [
  
                   'headers' => [
                     'Token' => JwtToken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      //'Authorisedkey'=> Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseDatabank = json_decode($body, true);
            
            
   $bankname = null;
    foreach ($responseDatabank['banklist']['data'] as $bank) {
        if ($bank['iinno'] == $row->nationalbankidentification) {
            $bankname = $bank['bankName'];
            break;
        }
    }

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
$userdata = Agent::where('id',$id)->first();

 $timestamp = Carbon::parse($row->timestamp);

        $formattedDate = $timestamp->format('j M Y');
        $formattedTime = $timestamp->format('H:i:s');

$Receipt = '<a href="#" data-bs-toggle="modal" data-bs-target="#'.$row->referenceno.'">'.$prient.'</i></a>

  <div class="modal fade " id="'.$row->referenceno.'" tabindex="-1" role="dialog" aria-labelledby="'.$row->referenceno.'" aria-hidden="true">
                      <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content printable-area">
                          <div class="modal-body printable-area"> 
                            <div class="modal-toggle-wrapper">  
                          <div style="padding: 20px;">
    <div style="border-top: 2px solid #005192; padding: 10px 0; display: flex; align-items: center; justify-content: space-between;">
      <img src="' .url('backend/uploads/setting/'.$globalData->dark_logo) . '" style="width: 105px;" alt="Bank Logo 1">
    </div>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #3a3737;">
      <thead>
        <tr>
          <td colspan="4" style="border: 1px solid #3a3737; padding: 8px; color: #ababab; font-size: 22px;">Cash Withdrawal</td>
        </tr>
      </thead>
      <tbody>
		<tr>
			<td style="color: #000e14; font-size: 16px;">Date:</td>
			<td style="color: #000; font-size: 16px; font-weight: 600;">'.$formattedDate.'</td>
			<td style="color: #000e14; font-size: 16px;">Time:</td>
			<td style="color: #000; font-size: 16px; font-weight: 600;">'.$formattedTime.'</td>
		</tr>
	    <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">BC Name:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$userdata->name.'</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Agent Id:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$userdata->agent_id.'</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">BC Mobile:</td>
          <td colspan="3" style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$userdata->mobile_number.'</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Customer Aadhaar/VID No:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$row->adhaarnumber.'</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Bank Name:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$bankname.'</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Transaction Id:</td>
          <td colspan="3" style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$row->referenceno.'</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">RRN:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$row->bankrrn.'</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Transaction Status:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #0daa0d; font-size: 16px; font-weight: 600;">'.$row->message.'</td>
        </tr>
		<tr>
			<td style="color: #000e14; font-size: 16px;">Transaction Amount:</td>
			<td style="color: #000; font-size: 16px; font-weight: 600;">'.$row->amount.'</td>
		</tr>
	<tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Account Balance:</td>
          <td colspan="3" style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$row->balanceamount.'</td>
        </tr>
    </tbody>
  </table>
  
  
</div>


<div class="d-flex ">
    <button class="btn btn-secondary d-flex mt-1 me-1 close-button no-print" type="button" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary d-flex mt-1 print-button no-print" type="button" onclick="printReceipt();">Print Receipt</button>
</div>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

';


$data[] = array(
"id"=> $i++,
"Name"=>$row->name,
"referenceno"=>$row->referenceno,
"adhaarnumber"=>$row->adhaarnumber,
"Amount"=> '₹'.$row->txn_amount,
"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
"Receipt"=> $Receipt,
"status"=> $status,
);
}
$aid = $request->session()->get('AGENT_EMAIL');
$user = DB::table('agents')->where('email',$aid)->first();
if($user){
$query = DB::table('aeps_withdrawls')->where('user_id',$user->id)->orderby('id','DESC');
}else{
$query = DB::table('aeps_withdrawls')->orderby('id','DESC');
}

$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $tot_rows,
"recordsFiltered" => $Withdrawaldatacount,
"data" => $data
);


echo json_encode($datas);

}

function mobilerechargeHistory(Request $request){
          $id = $request->session()->get('AGENT_ID');

  if (!empty($id)) {
      
      return view('backend/Agent/Aeps/mobilerechargeHistory');
      
  } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}

function viewmobilerechargeHistory(Request $request){

$globalData = system_setting::first();
$id = $request->session()->get('AGENT_ID');
$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];


$rechargedata = recharge::viewmobilerechargeHistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$Withdrawaldatacount = recharge::viewmobilerechargeHistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);





$i = 1;

$data = array();
foreach ($rechargedata as  $row) {


if($row->status=='1'){
$status = '<span class="badge rounded-pill badge-success">Success</span>';
}else{
$status = '<span class="badge rounded-pill badge-danger">Failed</span>';
}

if($row->status=='1'){
$prient = '<i class="fa fa-print" style="font-size: 25px; color:#54BA4A;"></i>';
}else{
$prient = '<i class="fa fa-print" style="font-size: 25px; color:#ea4159;"></i>';
}
$userdata = Agent::where('id',$id)->first();
 $timestamp = Carbon::parse($row->created_at);

        $formattedDate = $timestamp->format('j M Y');
        $formattedTime = $timestamp->format('H:i:s');

$Receipt = '<a href="#" data-bs-toggle="modal" data-bs-target="#'.$row->refid.'">'.$prient.'</i></a>

  <div class="modal fade " id="'.$row->refid.'" tabindex="-1" role="dialog" aria-labelledby="'.$row->refid.'" aria-hidden="true">
                      <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content printable-area">
                          <div class="modal-body printable-area"> 
                            <div class="modal-toggle-wrapper">  
                          <div style="padding: 20px;">
    <div style="border-top: 2px solid #005192; padding: 10px 0; display: flex; align-items: center; justify-content: space-between;">
      <img src="' .url('backend/uploads/setting/'.$globalData->dark_logo) . '" style="width: 105px;" alt="Bank Logo 1">
    </div>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #3a3737;">
      <thead>
        <tr>
          <td colspan="4" style="border: 1px solid #3a3737; padding: 8px; color: #ababab; font-size: 22px;">Mobile Recharge</td>
        </tr>
      </thead>
      <tbody>
		<tr>
			<td style="color: #000e14; font-size: 16px;">Date:</td>
			<td style="color: #000; font-size: 16px; font-weight: 600;">'.$formattedDate.'</td>
			<td style="color: #000e14; font-size: 16px;">Time:</td>
			<td style="color: #000; font-size: 16px; font-weight: 600;">'.$formattedTime.'</td>
		</tr>
	    <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">BC Name:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$userdata->name.'</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Agent Id:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$userdata->agent_id.'</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">BC Mobile:</td>
          <td colspan="3" style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$userdata->mobile_number.'</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Amount:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.'₹'.$row->amount.'</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Mobile Number:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$row->mobile.'</td>
        </tr>
        <tr>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Transaction Id:</td>
          <td colspan="3" style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$row->refid.'</td>
        </tr>
       <tr>

          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Transaction Status:</td>
          <td style="border: 1px solid #3a3737; padding: 8px; color: #0daa0d; font-size: 16px; font-weight: 600;">'.$status.'</td>
        </tr>
    </tbody>
  </table>
  
  
</div>


<div class="d-flex ">
    <button class="btn btn-secondary d-flex mt-1 me-1 close-button no-print" type="button" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary d-flex mt-1 print-button no-print" type="button" onclick="printReceipt();">Print Receipt</button>
</div>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

';


$data[] = array(
"id"=> $i++,
"referenceno"=>$row->refid,
"Amount"=> '₹'.$row->amount,
"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
"Mobile"=> $row->mobile,
"Receipt"=> $Receipt,
"Message"=> $row->message,
"status"=> $status,
);
}
$aid = $request->session()->get('AGENT_EMAIL');
$user = DB::table('agents')->where('email',$aid)->first();
if($user){
$query = DB::table('recharges')->where('user_id',$user->id)->orderby('id','DESC');
}else{
$query = DB::table('recharges')->orderby('id','DESC');
}

$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $tot_rows,
"recordsFiltered" => $Withdrawaldatacount,
"data" => $data
);


echo json_encode($datas);

}



/***************************************************************************************************COURIER  API************************************************************************************/



public function courierCreate(Request $request)
{

      $id = $request->session()->get('AGENT_ID');

  if (!empty($id)) {

      return view('backend/Agent/Aeps/courier/create');
      
  } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}


public function courieprocceddata(Request $request)
{

      $id = $request->session()->get('AGENT_ID');
      

  if (!empty($id)) {
      
       //$data = $request->session()->get('responseData');
      

      return view('backend/Agent/Aeps/courier/courieprocceddata');
      
  } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}






public function courierproceed(Request $request)
{

      $id = $request->session()->get('AGENT_ID');
      
      $cusid= 'CUS'.rand('11111111111','99999999999');
      
$cusdata = [$request->destination_code,$request->booking_date,$request->origin_code,$request->pcs,$request->actual_weight,$cusid];
  

  if (!empty($id)) {

     $client = new Client();
  try {
                $response = $client->request('POST', check_rate(), [
                   'body' => '{"destination_code":"'.$request->destination_code.'","booking_date":"'.$request->booking_date.'","origin_code":"'.$request->origin_code.'","pcs":"'.$request->pcs.'","actual_weight":"'.$request->actual_weight.'","customer_code":"'.$cusid.'"}',
                   'headers' => [
                     'Token' => testtoken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      'Authorisedkey'=> Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseData = json_decode($body, true);
            

            $request->session()->put('responseData',$responseData['data']);
                 $request->session()->put('cusdata', $cusdata);
        return response()->json($responseData);

          
          

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
      
  } else {
        return redirect('agent/login')->with('error', 'Agent is not authorized');
    }
}



function courierpartnerCheck(Request $request){
    
    
    $cusid = $request->session()->get('cusdata')[5];
    
parse_str($request->input('formData'), $data);

               $client = new Client();
  try {
                $response = $client->request('POST', check_rate(), [
                   'body' => '{"destination_code":"'.$data['destination_code'].'","booking_date":"'.$data['booking_date'].'","origin_code":"'.$data['origin_code'].'","pcs":"'.$data['pcs'].'","actual_weight":"'.$data['actual_weight'].'","customer_code":"'.$cusid.'"}',
                   'headers' => [
                     'Token' => testtoken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      'Authorisedkey'=> Authorisedkey(),
                      ],
                       ]);
 
            $body = $response->getBody();
            $responseData = json_decode($body, true);
            

                     
   $curiorname = null;
   foreach ($responseData['data'] as $partner) {
      
                if ($partner['code'] == $data['courier_partner']) {
                    $curiorname = $partner;
                    break;
                }
            }
return response()->json([
    'responseData' => $responseData,
    'curiorname' => $curiorname
], 200); 


        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
}




function createcourier(Request $request){
    
   $data =  $request->all();
    

    $destination_code = $data['destination_code'] ?? '';
    $booking_date = $data['booking_date'] ?? '';
    $origin_code = $data['origin_code'] ?? '';
    $pcs = $data['pcs'] ?? 0;
    $actual_weight = $data['actual_weight'] ?? 0;
   

    $refid = $data['refid'] ?? '';
    $product_code = $data['product_code'] ?? '';
    $booking_time = $data['booking_time'] ?? '';
    $shipment_value = $data['shipment_value'] ?? '';
    $shipment_content = $data['shipment_content'] ?? '';
    $remark = $data['remark'] ?? '';
    $shipper_name = $data['Shipper_name'] ?? '';
    $shipper_company_name = $data['shipper_company_name'] ?? '';
    $shipper_contact_no = $data['shipper_contact_no'] ?? '';
    $shipper_email = $data['shipper_email'] ?? '';
    $shipper_address_line_1 = $data['shipper_address_line_1'] ?? '';
    $shipper_address_line_2 = $data['shipper_address_line_2'] ?? '';
    $shipper_address_line_3 = $data['shipper_address_line_3'] ?? '';
    $shipper_city = $data['shipper_city'] ?? '';
    $shipper_state = $data['shipper_state'] ?? '';
    $shipper_country = $data['shipper_country'] ?? '';
    $shipper_zip_code = $data['shipper_zip_code'] ?? '';
    $shipper_gstin_type = $data['shipper_gstin_type'] ?? '';
    $shipper_gstin_no = $data['shipper_gstin_no'] ?? '';
    $consignee_name = $data['consignee_name'] ?? '';
    $consignee_company_name = $data['consigne_company_name'] ?? '';
    $consignee_contact_no = $data['consignee_contact_no'] ?? '';
    $consignee_email = $data['consignee_email'] ?? '';
    $consignee_address_line_1 = $data['consignee_address_line_1'] ?? '';
    $consignee_address_line_2 = $data['consignee_address_line_2'] ?? '';
    $consignee_address_line_3 = $data['consignee_address_line_3'] ?? '';
    $consignee_city = $data['consignee_city'] ?? '';
    $consignee_state = $data['consignee_state'] ?? '';
    $consignee_country = $data['consignee_country'] ?? '';
    $consignee_zip_code = $data['consignee_zip_code'] ?? '';
    $consignee_gstin_type = $data['consignee_gstin_type'] ?? '';
    $consignee_gstin_no = $data['consignee_gstin_no'] ?? '';
    $pickup_address_name = $data['pickup_address_name'] ?? '';
    $pickup_address_code = $data['pickup_address_code'] ?? '';
    $pickup_address_contact_no = $data['pickup_address_contact_no'] ?? '';
    $pickup_address_email = $data['pickup_address_email'] ?? '';
    $pickup_address_address_line_1 = $data['pickup_address_address_line_1'] ?? '';
    $pickup_address_address_line_2 = $data['pickup_address_address_line_2'] ?? '';
    $pickup_address_address_line_3 = $data['pickup_address_address_line_3'] ?? '';
    $pickup_address_city = $data['pickup_address_city'] ?? '';
    $pickup_address_state = $data['pickup_address_state'] ?? '';
    $pickup_address_country = $data['pickup_address_country'] ?? '';
    $pickup_address_zip_code = $data['pickup_address_zip_code'] ?? '';
    $pickup_address_gstin_type = $data['pickup_address_gstin_type'] ?? '';
    $pickup_address_gstin_no = $data['pickup_address_gstin_no'] ?? '';
    $pickup_request = $data['pickup_request'] ?? 'YES';
    $docket_items = $data['docket_items'] ?? [];
    $free_form_line_items = $data['free_form_line_items'] ?? [];
    
    
    
     $body = [
        'refid' => $refid,
        'origin_code' => $origin_code,
        'product_code' => $product_code,
        'destination_code' => $destination_code,
        'booking_date' => $booking_date,
        'booking_time' => $booking_time,
        'pcs' => $pcs,
        'shipment_value' => $shipment_value,
        'shipment_value_currency' => 'INR',
        'actual_weight' => $actual_weight,
        'shipment_invoice_no' => 'TEST_INV1',
        'shipment_invoice_date' => $booking_date,
        'shipment_content' => $shipment_content,
        'remark' => $remark,
        'new_docket_free_form_invoice' => '1',
        'free_form_currency' => 'INR',
        'terms_of_trade' => 'FOB',
        'api_service_code' => $data['courier_partner'],
        'api_vendor_code' => '',
        'shipper_name' => $shipper_name,
        'shipper_company_name' => $shipper_company_name,
        'shipper_contact_no' => $shipper_contact_no,
        'shipper_email' => $shipper_email,
        'shipper_address_line_1' => $shipper_address_line_1,
        'shipper_address_line_2' => $shipper_address_line_2,
        'shipper_address_line_3' => $shipper_address_line_3,
        'shipper_city' => $shipper_city,
        'shipper_state' => $shipper_state,
        'shipper_country' => $shipper_country,
        'shipper_zip_code' => $shipper_zip_code,
        'shipper_gstin_type' => $shipper_gstin_type,
        'shipper_gstin_no' => $shipper_gstin_no,
        'consignee_name' => $consignee_name,
        'consignee_company_name' => $consignee_company_name,
        'consignee_contact_no' => $consignee_contact_no,
        'consignee_email' => $consignee_email,
        'consignee_address_line_1' => $consignee_address_line_1,
        'consignee_address_line_2' => $consignee_address_line_2,
        'consignee_address_line_3' => $consignee_address_line_3,
        'consignee_city' => $consignee_city,
        'consignee_state' => $consignee_state,
        'consignee_country' => $consignee_country,
        'consignee_zip_code' => $consignee_zip_code,
        'consignee_gstin_type' => $consignee_gstin_type,
        'consignee_gstin_no' => $consignee_gstin_no,
        'pickup_address_name' => $pickup_address_name,
        'pickup_address_code' => $pickup_address_code,
        'pickup_address_contact_no' => $pickup_address_contact_no,
        'pickup_address_email' => $pickup_address_email,
        'pickup_address_address_line_1' => $pickup_address_address_line_1,
        'pickup_address_address_line_2' => $pickup_address_address_line_2,
        'pickup_address_address_line_3' => $pickup_address_address_line_3,
        'pickup_address_city' => $pickup_address_city,
        'pickup_address_state' => $pickup_address_state,
        'pickup_address_country' => $pickup_address_country,
        'pickup_address_zip_code' => $pickup_address_zip_code,
        'pickup_address_gstin_type' => $pickup_address_gstin_type,
        'pickup_address_gstin_no' => $pickup_address_gstin_no,
        'pickup_request' => $pickup_request,
        'docket_items' => $docket_items,
        'free_form_line_items' => $free_form_line_items
    ];


          $client = new Client();
          
          try{
              
              $response = $client->request('POST', createcourier(), [
  'body' => json_encode($body),
  'headers' => [
                       'Token' => testtoken(),
                      'accept' => 'application/json',
                      'content-type' => 'application/json',
                      'Authorisedkey'=> Authorisedkey(),
  ],
]);


         $body = $response->getBody();
            $responseData = json_decode($body, true);
            
return response()->json([
'responseData'=>$responseData
], 200);
          }
          catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return back()->with('error', $responseBody['message']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    
    
}


}