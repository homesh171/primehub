<?php

use App\Models\allmassageapis;
use App\Models\service;
use App\Models\wallet_log;
use App\Models\agent;
use Illuminate\Http\Request;
use Illuminate\Http\session;


function sendOtp($number, $massage)
{
    $sendotp = allmassageapis::where('id', '1')->first();
    $apiUrl = $sendotp->masgapiurl;
    $username = $sendotp->username;
    $apiKey = $sendotp->apikey;
    $sender = $sendotp->sender;
    $mobile = '91' . $number;
    $message = $massage;
    $route = $sendotp->route;
    $templateId = $sendotp->templateid;
    $format = 'JSON';
    $requestUrl = "$apiUrl?authentic-key=$apiKey&senderid=$sender&route=$route&number=$mobile&message=$message&templateid=$templateId";
    $response = Http::get($requestUrl);
    $responseJson = $response->json();
    
    if ($responseJson['Status'] == "Success") {
        return "success";
    }
}

function calculate_hmac($secret, $timestamp, $body, $path, $query_string = '', $method = 'GET')
{
    $message = $method . "\n" . $path . "\n" . $query_string . "\n" . $body . "\n" . $timestamp . "\n";
    return hash_hmac('sha512', $message, $secret);
}

function payout_secrect()
{
    return "62e29979bae8081e56023afb5adc7aca";
}

function payout_access_key()
{
    return "9fd23a6616992835f211a5a71fa55c1f";
}

function payoutbalance()
{
    $secret = payout_secrect();
    $access_key = payout_access_key();
    $txnid = 235;
    $x_timestamp  = floor(microtime(true) * 1000);
    $path = "/api/v1/payout/balance/" . $txnid;
    $url = "https://api.frenzopay.com" . $path;
    $signature = calculate_hmac($secret, $x_timestamp, '', $path, '', 'GET');
    $header_data = array(
        "Content-Type: application/json",
        "Accept: application/json",
        "access_key:" . $access_key,
        "signature:" . $signature,
        "X-Timestamp:" . $x_timestamp,
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPGET, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
    curl_setopt($ch, CURLOPT_HEADER, 0);  
    $result = json_decode(curl_exec($ch));
    

    return $result->balance / 100;
    
 
}


function agentWelletbalance($id)
{
   $wallet = agent::where('id',$id)->pluck('wallet')->first();
   return $wallet;
}


function agentWelletbalanceUpdate($id,$amount)
{
   $wallet = agent::where('id',$id)->pluck('wallet')->first();
   $lastamount = $wallet-$amount;
   agent::where('id',$id)->update(['wallet'=>$lastamount]);

}


function walletLog($payment_status, $userRole, $userid, $services_id, $message, $userIp, $amount)
{
    $wallet = new wallet_log([
        'payment_status' => $payment_status,
        'role_id' => $userRole,
        'user_id' => $userid,
        'services_id' => $services_id,
        'message' => $message,
        'amount' => $amount,
        'ip' => $userIp
    ]);
    $wallet->save();
}


function JwtToken()
{
    $current_timestamp = time() * 1000;
    
    //LIVE
    $partnerId = "PS005241";
    
    //UAT
    //$partnerId = "PS001693";
    
    
    $reqid = rand('111111','999999');

    $payload = json_encode([
        "timestamp" => $current_timestamp,
        "partnerId" => $partnerId,
        "reqid" => $reqid
    ]);

 //LIVE 
 $key = "UFMwMDUyNDEwZGRmYzgxYmYyNjk0MTJkOGU1ZDg1ZDU2MjhiZWEwODE3MTQ3MzY4NzI="; 
    
    //UAT
// $key = "UFMwMDE2OTNiZmMzYTlmOTYwOTc3MDE4OTRjMThkYjNhMzZkOTI3Yg=="; 
    
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    
    return $jwt;
    // print_r($jwt);
    // die;

  // return "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0aW1lc3RhbXAiOjE1NDEwNDQyNTcwMDAsInBhcnRuZXJJZCI6IlBTMDAxNjkzIiwicmVxaWQiOiIxMzIzNjMifQ.1aQ7xGqYnqK_z4RdYLEsKWtJBI3oEhfYqMKrOyrTFKQ";
}


function testtoken(){
    return "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0aW1lc3RhbXAiOjE1NDEwNDQyNTcwMDAsInBhcnRuZXJJZCI6IlBTMDAxNjkzIiwicmVxaWQiOiIxMzIzNjMifQ.1aQ7xGqYnqK_z4RdYLEsKWtJBI3oEhfYqMKrOyrTFKQ";
}

function getoperator()
{
    return 'https://api.paysprint.in/api/v1/service/recharge/recharge/getoperator';
    //return 'https://sit.paysprint.in/service-api/api/v1/service/recharge/recharge/getoperator';
}

function dorecharge()
{
    return 'https://api.paysprint.in/api/v1/service/recharge/recharge/dorecharge';
   // return 'https://sit.paysprint.in/service-api/api/v1/service/recharge/recharge/dorecharge';
    
}


function browseplan()
{
    return 'https://api.paysprint.in/api/v1/service/recharge/hlrapi/browseplan';
    //return 'https://sit.paysprint.in/service-api/api/v1/service/recharge/hlrapi/browseplan';
}


function hlrcheck()
{
    return 'https://api.paysprint.in/api/v1/service/recharge/hlrapi/hlrcheck';
    //return 'https://sit.paysprint.in/service-api/api/v1/service/recharge/hlrapi/hlrcheck';
}

function Authorisedkey()
{
    return 'ODMwNGFjZjVkYWY5MTJkNWYxYWM0NTllMzFlNzczNWM=';
}

function onboardurl()
{
    return 'https://api.paysprint.in/api/v1/service/onboard/onboard/getonboardurl';
}

function getonboardstatus()
{
    return 'https://api.paysprint.in/api/v1/service/onboard/onboard/getonboardstatus';
}

function Twofactorkycregistration()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/kyc/Twofactorkyc/registration';
}


function TwofactorkycregistrationBANK3()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/kyc/Twofactorkyc/register_agent';
}

function TwofactorkycAuthenticate()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/kyc/Twofactorkyc/authentication';
}


function TwofactorkycAuthenticateBANK3()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/kyc/Twofactorkyc/auth_login';
}

function Twofactorkycmerchant_authencity()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/kyc/Twofactorkyc/merchant_authencity';
}


function Twofactorkycmerchant_authencityBANK3()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/kyc/Twofactorkyc/agent_authencity';
}

function balanceenquiry()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/balanceenquiry/index';
}

function authcashwithdraw()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/authcashwithdraw/index';
    
}

function banklist()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/banklist/index';
}


function ministatement()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/ministatement/index';
}


function txnstatus()
{
    return 'https://api.paysprint.in/api/v1/service/aeps/aepsquery/query';
}


function check_rate()
{
    return 'https://sit.paysprint.in/service-api/api/v1/service/courier/docket/check_rate';
}


function createcourier()
{
    return 'https://sit.paysprint.in/service-api/api/v1/service/courier/docket/create';
}

function EncryptionBody($request,$data)
{
 //LIVE 
  $key ='23337c94b02479a0';
  $iv=   '0a236aa665adf133';
  
  //UAT
//   $key ='402cef0855a86c4a';
//   $iv=   '111ebde6377f3bab';
  
  $datapost = $data;
  $cipher  =   openssl_encrypt(json_encode($datapost,true), 'AES-128-CBC', $key, $options=OPENSSL_RAW_DATA, $iv);
  $encryptedData=       base64_encode($cipher);
    
    return $encryptedData;
}

function getUsernameByAgentId($agent_id) {
    $agent = DB::table('agents')->where('agent_id', $agent_id)->first();
    return $agent ? $agent->name : 'Unknown Agent';
}

// while (true) {
//     $token = JwtToken();
//     sleep(300); // Sleep for 5 minutes
// }