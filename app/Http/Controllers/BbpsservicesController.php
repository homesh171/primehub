<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorebbpsservicesRequest;
use App\Http\Requests\UpdatebbpsservicesRequest;
use App\Models\bbpsservices;
use App\Models\bbps_category;
use App\Models\billinfo;
use App\Models\Agent;
use App\Models\bbps_complaint;
use App\Models\bbps_transaction;
use App\Models\billfatchData;
use Illuminate\Http\Request;
use SimpleXMLElement;
use App\Models\system_setting;
use DB;
use session;
use Crypt;
use App\Services\LogService;

class BbpsservicesController extends Controller
{


public function index(Request $request)
{
if($request->session()->get('AGENT_EMAIL')){
$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();

$data['data'] = bbps_category::where('status','1')->get();
$data['paramInfo'] = billinfo::all();

$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '16';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

return view('backend/Agent/Bbps/bbps',$data);  



}else{
return redirect('agent/login')->with('error','Agent is not authorized');
}  


}


public function fetch_category(Request $request)
{

if($request->session()->get('AGENT_EMAIL')){
$category = $request->input('category');
$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();

$parameters  = DB::table('bbpsservices')->where('blr_category_id',$category)->get();
foreach ($parameters as $parameter) {
$responseData[] = [
'name' => $parameter->blr_name,
'value' => $parameter->id, 
];
}


$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '5';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

return response()->json($responseData);

}else{

return redirect('agent/login')->with('error','Agent is not authorized');
}
}



public function store_parameters(Request $request)
{

//**** Encryption Function ********
function encrypt($plainText, $key) {
$secretKey = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
$encryptedText = bin2hex($openMode);
return $encryptedText;
}

//**** Decryption Function ********
function decrypt($encryptedText, $key) {
$key = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$encryptedText = hextobin($encryptedText);
$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
return $decryptedText;
}

//**** Hexadecimal to Binary function for php 4.0 version ****
function hextobin($hexString) {
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

//**** To generate ramdom String ****
function generateRandomString($length = 35) {
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}

/* * ******************** */
/* * ******************** */
/* * ******************** */
$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();

// $userRole = "2";
// $userIp = $request->ip();
// $userid = $userData->id;
// $activity = '6';
// $weburl = $_SERVER['REQUEST_URI'];
// LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

$result = DB::table('bbpsservices')->orderBy('id','ASC')->where('blr_category_name','Credit Card')->get();

$data1 = [];
$limit = 500;

foreach ($result as $row) {
if ($limit-- <= 0) {
break; 
}
$data1[] = "<billerId>{$row->blr_id}</billerId>";
}

$plainText = '<?xml version="1.0" encoding="UTF-8"?><billerInfoRequest>' . implode('', $data1) . '</billerInfoRequest>';


// print_r($plainText);
// die;

$key = "42A135C6289905F72312335B68B19136";
$encrypt_xml_data = encrypt($plainText, $key);

$data['accessCode'] = "AVCF04SK43EI06CBKG";
$data['requestId'] = generateRandomString();
$data['ver'] = "1.0";
$data['instituteId'] = "CV46";

$parameters = http_build_query($data);

$url = "https://api.billavenue.com/billpay/extMdmCntrl/mdmRequestNew/xml?" . $parameters;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $encrypt_xml_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$result = curl_exec($ch);
//echo 'Encrypted Response: ' . $result . "<br><br>";
$response = decrypt($result, $key);
// echo "<pre>";
// echo htmlentities($response);
// $responseData = [
// 'parameters' => json_encode($data),
// 'encrypted_response' => $result,
// ];


$xmlData = $response;

$xml = new SimpleXMLElement($xmlData);

// print_r($xml);
// die;

$insertedCount = 0; 

foreach ($xml->biller as $biller) {
$existingRecord = billinfo::where('billerId', (string) $biller->billerId)->first();

if (!$existingRecord) {
$parameter = new billinfo();
$parameter->billerId = (string) $biller->billerId;
$parameter->billerName = (string) $biller->billerName;
$parameter->billerCategory = (string) $biller->billerCategory;
$parameter->billerAdhoc = (string) $biller->billerAdhoc;
$parameter->billerCoverage = (string) $biller->billerCoverage;
$parameter->billerFetchRequiremet = (string) $biller->billerFetchRequiremet;
$parameter->billerPaymentExactness = (string) $biller->billerPaymentExactness;
$parameter->billerSupportBillValidation = (string) $biller->billerSupportBillValidation;
$parameter->billerDescription = (string) $xml->biller->billerDescription;
$parameter->parameters = $data['requestId'];
$parameter->encrypted_response = $result;

foreach ($biller->billerInputParams->paramInfo as $paramInfo) {
$param = new billinfo(); 
$param->billerId = (string) $biller->billerId;
$param->billerName = (string) $biller->billerName;
$param->billerCategory = (string) $biller->billerCategory;
$param->billerAdhoc = (string) $biller->billerAdhoc;
$param->billerCoverage = (string) $biller->billerCoverage;
$param->billerFetchRequiremet = (string) $biller->billerFetchRequiremet;
$param->billerPaymentExactness = (string) $biller->billerPaymentExactness;
$param->billerSupportBillValidation = (string) $biller->billerSupportBillValidation;
$param->paramName = (string) $paramInfo->paramName;
$param->dataType = (string) $paramInfo->dataType;
$param->isOptional = filter_var((string) $paramInfo->isOptional, FILTER_VALIDATE_BOOLEAN);
$param->minLength = (int) $paramInfo->minLength;
$param->maxLength = (int) $paramInfo->maxLength;
$param->regEx = (string) $paramInfo->regEx;
$param->plans = (string) $paramInfo->values;
$param->billerDescription = (string) $xml->biller->billerDescription;
$param->parameters = $data['requestId'];
$param->encrypted_response = $result;
$param->billerPaymentModes = (string) $biller->billerPaymentModes;
$param->save();

$bbps_category = DB::table('bbps_categories')->where('category', $param->billerCategory)->first();
$bbpsservices = DB::table('bbpsservices')->where('blr_category_id', $bbps_category->id)->where('blr_id', $param->billerId)->first();

$data = billinfo::find($param->id);
$data->bbps_category = $bbps_category->id;
$data->bbpsservices = $bbpsservices->id;
$data->save();
}
$insertedCount++; 
}
}
// billinfo::insert($responseData);



return "Inserted $insertedCount records successfully.";

}

public function fetch_parameters(Request $request)
{

if($request->session()->get('AGENT_EMAIL')){
$category = $request->input('category');
$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();

$parameters  = billinfo::where('bbpsservices',$category)->get();

$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '7';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);


$responseData = [];
foreach ($parameters as $param) {
$responseData[$param->paramName] = [
'paramValue' => $param->paramValue,
'minLength' => $param->minLength,
'maxLength' => $param->maxLength,
'regEx' => $param->regEx,
'isOptional' => $param->isOptional,
'plans' => $param->plans,
'billerPaymentModes' => $param->billerPaymentModes,
'billerPaymentExactness' => $param->billerPaymentExactness,
];
}
return response()->json($responseData);

}else{

return redirect('agent/login')->with('error','Agent is not authorized');
}


}


public function store_bbpstbillfetch(Request $request){


//*********** Encryption Function *********************
function encrypt($plainText, $key) {
$secretKey = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
$encryptedText = bin2hex($openMode);
return $encryptedText;
}

//*********** Decryption Function *********************
function decrypt($encryptedText, $key) {
$key = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$encryptedText = hextobin($encryptedText);
$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
return $decryptedText;
}

//*********** Padding Function *********************
function pkcs5_pad($plainText, $blockSize) {
$pad = $blockSize - (strlen($plainText) % $blockSize);
return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********
function hextobin($hexString) {
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

//********** To generate ramdom String ********
function generateRandomString($length = 35) {
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}

/* * ************************************************************ */
/* * ************************************************************ */
/* * ************************************************************ */
$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();
$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '8';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

$catID = $request->serviceid;

$billerId = DB::table('bbpsservices')->where('id',$catID)->first();


$billerinfo = billinfo::where('billerId',$billerId->blr_id)->get();
$formData = $request->all();


$updatedFormData = [];

foreach ($formData as $key => $value) {
$newKey = str_replace('_', ' ', $key);
$updatedFormData[$newKey] = $value;
}


$plainText = '<billFetchRequest>
<agentId>CC01CV46AGTU00000004</agentId>
<agentDeviceInfo>
<ip>103.152.79.163</ip>
<initChannel>AGT</initChannel>
<mac>01-23-45-67-89-ab</mac>
</agentDeviceInfo>
<customerInfo>
<customerMobile>9079282750</customerMobile>
<customerEmail></customerEmail>
<customerAdhaar></customerAdhaar>
<customerPan></customerPan>
</customerInfo>
<billerId>' . $billerId->blr_id . '</billerId>
<inputParams>';
// print_r($billerinfo);
// die;


foreach ($billerinfo as $info) {


if (isset($formData)) {

$plainText .= '<input>';
$plainText .= '<paramName>' . $info->paramName . '</paramName>';
if ($info->paramName === 'Plan') {
$plans = explode(',', $info->plans);
foreach ($plans as $plan) {
$plainText .= '<paramValue>' . $plan . '</paramValue>';
}
} else {
$plainText .= '<paramValue>' . $updatedFormData[$info->paramName] . '</paramValue>';
}
$plainText .= '</input>';
}
}
$plainText .= '</inputParams></billFetchRequest>';

// echo '<pre>';
// echo $plainText;
// die;

$key = "42A135C6289905F72312335B68B19136";
$encrypt_xml_data = encrypt($plainText, $key);

$data['accessCode'] = "AVCF04SK43EI06CBKG";
$data['requestId'] = generateRandomString();
$data['encRequest'] = $encrypt_xml_data;
$data['ver'] = "1.0";
$data['instituteId'] = "CV46";
$parameters = http_build_query($data);

$url = "https://api.billavenue.com/billpay/extBillCntrl/billFetchRequest/xml";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$result = curl_exec($ch);
//echo $result . "////////////////////";
$response = decrypt($result, $key);
// echo "<pre>";
// echo htmlentities($response);
// exit;

$xmlData = $response;


$xml = new SimpleXMLElement($xmlData); 

function generateRandomBillNumber() {
return rand(1000000000, 9999999999); 
}

$fetacData = billfatchData::insert([
'billerID'=>$billerId->blr_id,
'token'=>$data['requestId'],
'billNumber'=>isset($xml->billerResponse->billNumber) ? (string) $xml->billerResponse->billNumber : generateRandomBillNumber(),
'ip' =>$request->ip()
]);

return response()->json($xml);   



}


public function encryptXml(Request $request)
{

$xmlRequest = $request->input('xmlRequest');
$encryptedXml = Crypt::encrypt($xmlRequest);
return response()->json(['encryptedXml' => $encryptedXml]);
}

public function billPayRequest(Request $request){


//*********** Encryption Function *********************
function encrypt($plainText, $key) {
$secretKey = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
$encryptedText = bin2hex($openMode);
return $encryptedText;
}

//*********** Decryption Function *********************
function decrypt($encryptedText, $key) {
$key = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$encryptedText = hextobin($encryptedText);
$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
return $decryptedText;
}

//*********** Padding Function *********************
function pkcs5_pad($plainText, $blockSize) {
$pad = $blockSize - (strlen($plainText) % $blockSize);
return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********
function hextobin($hexString) {
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

//********** To generate ramdom String ********
function generateRandomString($length = 35) {
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}

/* * ************************************************************ */
/* * ************************************************************ */
/* * ************************************************************ */

$user = $request->session()->get('AGENT_EMAIL');
$catID = $request->input('catid');
$billnumber = $request->input('billnumber');
$billerId = DB::table('bbpsservices')->where('id',$catID)->first();
$billinfo = billinfo::where('billerId',$billerId->blr_id)->first();
$string = billfatchData::orderBy('id','DESC')->first();
$amount =  $request->input('amount');
$customerName =  $request->input('customerName');
$agent = Agent::where('email',$user)->first();
$userData = Agent::where('email',$user)->first();
$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '9';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);
$xmlRequest = $request->xmlRequest;
$xmldata = Crypt::decrypt($xmlRequest);



if($user){
if($userData->wallet >= $amount){


$plainText = '<?xml version="1.0" encoding="UTF-8"?>
<billPaymentRequest>
<agentId>CC01CV46AGTU00000004</agentId>
<billerAdhoc>true</billerAdhoc>
<agentDeviceInfo>
<ip>192.168.2.73</ip>
<initChannel>AGT</initChannel>
<mac>01-23-45-67-89-ab</mac>
</agentDeviceInfo>
<customerInfo>
<customerMobile>9898990084</customerMobile>
<customerEmail></customerEmail>
<customerAdhaar></customerAdhaar>
<customerPan></customerPan>
</customerInfo>
<billerId>'.$billerId->blr_id.'</billerId>
'.$xmldata.'
</billPaymentRequest>';


$key = "42A135C6289905F72312335B68B19136";
$encrypt_xml_data = encrypt($plainText, $key);

$data['accessCode'] = "AVCF04SK43EI06CBKG";

if($billinfo->billerFetchRequiremet=='MANDATORY'){

$data['requestId'] = $string->token;   
}else{
$data['requestId'] = generateRandomString();  
}

$data['encRequest'] = $encrypt_xml_data;
$data['ver'] = "1.0";
$data['instituteId'] = "CV46";
$parameters = http_build_query($data);

$url = "https://api.billavenue.com/billpay/extBillPayCntrl/billPayRequest/xml";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$result = curl_exec($ch);

$response = decrypt($result, $key);

$xmlData = $response;
$xml = new SimpleXMLElement($xmlData); 

if($xml->responseCode == '200') {
$errorMessage = 'Server Down please try again later!';
if (isset($errorMessage)) {
$request->session()->flash('error', $errorMessage);
}
return back();
}else{
$jsonData = json_decode(json_encode($xml), true);
$payment_status = '0';
$services_id = '3';
$message = 'Bill Payment';


if ($xml->responseCode == '000') {
$deductamount= $agent->wallet-$amount;
$agent->wallet = $deductamount;
$agent->save();

$transaction = new bbps_transaction();
$transaction->agent_id = $agent->id;
$transaction->role = $userRole;
$transaction->responseCode =  isset($jsonData['responseCode']) ? $jsonData['responseCode'] : '';
$transaction->responseReason =  isset($jsonData['responseReason']) ? $jsonData['responseReason'] : '';
$transaction->txnRefId =  isset($jsonData['txnRefId']) ? $jsonData['txnRefId'] : '';
$transaction->approvalRefNumber =  isset($jsonData['approvalRefNumber']) ? $jsonData['approvalRefNumber'] : '';
$transaction->txnRespType =  isset($jsonData['txnRespType']) ? $jsonData['txnRespType'] : '';
$transaction->CustConvFee =  isset($jsonData['CustConvFee']) ? $jsonData['CustConvFee'] : '';
$transaction->RespAmount =  isset($jsonData['RespAmount'])/100 ? $jsonData['RespAmount']/100 : '';
$transaction->RespCustomerName =  isset($jsonData['RespCustomerName']) ? $jsonData['RespCustomerName'] : '';
$transaction->biller_id =  $billinfo->billerId;
$transaction->biller_name =  $billinfo->billerName;
$transaction->ip = $request->ip();
$transaction->save();
$successMessage = 'Bill Payment Successfull';
walletLog('1',$userRole,$userid,$services_id,$message,$userIp,$amount);
}elseif($xml->responseCode == '999'){

$deductamount= $agent->wallet-$amount;
$agent->wallet = $deductamount;
$agent->save();

$transaction = new bbps_transaction();
$transaction->agent_id = $agent->id;
$transaction->role = $userRole;
$transaction->responseCode =  isset($jsonData['responseCode']) ? $jsonData['responseCode'] : '999';
$transaction->responseReason =  isset($jsonData['responseReason']) ? $jsonData['responseReason'] : 'Processing';
$transaction->txnRefId =  isset($jsonData['txnRefId']) ? $jsonData['txnRefId'] : rand('000000000','999999999');
$transaction->approvalRefNumber =  isset($jsonData['approvalRefNumber']) ? $jsonData['approvalRefNumber'] : '';
$transaction->txnRespType =  isset($jsonData['txnRespType']) ? $jsonData['txnRespType'] : '';
$transaction->CustConvFee =  isset($jsonData['CustConvFee']) ? $jsonData['CustConvFee'] : '';
$transaction->RespAmount =  isset($jsonData['RespAmount'])/100 ? $jsonData['RespAmount']/100 : $amount;
$transaction->RespCustomerName =  isset($jsonData['RespCustomerName']) ? $jsonData['RespCustomerName'] : $customerName;
$transaction->biller_id =  $billinfo->billerId;
$transaction->biller_name =  $billinfo->billerName;
$transaction->ip = $request->ip();
$transaction->save();
$errorMessage = 'Payment Processing';

}else{

$transaction = new bbps_transaction();
$transaction->agent_id = $agent->id;
$transaction->role = $userRole;
$transaction->responseCode =  isset($jsonData['responseCode']) ? $jsonData['responseCode'] : '001';
$transaction->responseReason =  isset($jsonData['responseReason']) ? $jsonData['responseReason'] : 'Failed';
$transaction->txnRefId =  isset($jsonData['txnRefId']) ? $jsonData['txnRefId'] : rand('000000000','999999999');
$transaction->approvalRefNumber =  isset($jsonData['approvalRefNumber']) ? $jsonData['approvalRefNumber'] : '';
$transaction->txnRespType =  isset($jsonData['txnRespType']) ? $jsonData['txnRespType'] : '';
$transaction->CustConvFee =  isset($jsonData['CustConvFee']) ? $jsonData['CustConvFee'] : '';
$transaction->RespAmount =  isset($jsonData['RespAmount'])/100 ? $jsonData['RespAmount']/100 : $amount;
$transaction->RespCustomerName =  isset($jsonData['RespCustomerName']) ? $jsonData['RespCustomerName'] : $customerName;
$transaction->biller_id =  $billinfo->billerId;
$transaction->biller_name =  $billinfo->billerName;
$transaction->ip = $request->ip();
$transaction->save();
$errorMessage = 'Server problem please try again later!';
}



if (isset($successMessage)) {
$request->session()->flash('success', $successMessage);
}
if (isset($errorMessage)) {
$request->session()->flash('error', $errorMessage);
}
return back();
}

}else{


$transaction = new bbps_transaction();

$transaction->agent_id = $agent->id;
$transaction->role = $userRole;
$transaction->responseCode =  isset($jsonData['responseCode']) ? $jsonData['responseCode'] : '500';
$transaction->responseReason =  isset($jsonData['responseReason']) ? $jsonData['responseReason'] : 'Failed';
$transaction->txnRefId =  isset($jsonData['txnRefId']) ? $jsonData['txnRefId'] : rand('000000000','999999999');
$transaction->approvalRefNumber =  isset($jsonData['approvalRefNumber']) ? $jsonData['approvalRefNumber'] : '';
$transaction->txnRespType =  isset($jsonData['txnRespType']) ? $jsonData['txnRespType'] : '';
$transaction->CustConvFee =  isset($jsonData['CustConvFee']) ? $jsonData['CustConvFee'] : '';
$transaction->RespAmount =  isset($jsonData['RespAmount'])/100 ? $jsonData['RespAmount']/100 : $amount;
$transaction->RespCustomerName =  isset($jsonData['RespCustomerName']) ? $jsonData['RespCustomerName'] : $customerName;
$transaction->biller_id =  $billinfo->billerId;
$transaction->biller_name =  $billinfo->billerName;
$transaction->ip = $request->ip();
$transaction->save();

$errorMessage =  'Insufficient Wallet balance';
if (isset($errorMessage)) {
$request->session()->flash('error', $errorMessage);
}

return back();

}}else{

return redirect('agent/login')->with('error','Agent is not authorized');

}


}

public function agentPinVerify(Request $request)
{
$user = $request->session()->get('AGENT_EMAIL');

if ($user) {
$agent = Agent::where('email', $user)->first();

if ($agent) {
$pin = $request->agentPin;



if ($agent->agent_pin == $pin) {
return response()->json(['success' => 'success']);
}else{
return response()->json(['error' => 'Invalid Agent PIN. Please enter a valid PIN']); 
}
} else {
return redirect('agent/login')->with('error', 'Agent not found.');
}
} else {
return redirect('agent/login')->with('error', 'User session not found.');
}
}








public function billhistory(Request $request)
{

if($request->session()->get('AGENT_EMAIL')){

$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();

return view('backend/Agent/Bbps/billHistory');

$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '10';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

}else{
return redirect('agent/login')->with('error','Agent is not authorized');
}  
}



function billhistoryajexview(Request $request){

$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];


$agentdata = bbps_transaction::billhistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$agentdatacount = bbps_transaction::billhistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);


$globalData = system_setting::first();



$i = 1;

$data = array();
foreach ($agentdata as  $row) {


if($row->responseReason=='Successful'){
$status = '<span class="badge rounded-pill badge-success">Success</span>';
}elseif($row->responseReason=='Failed'){
$status = '<span class="badge rounded-pill badge-danger">Failed</span>';
}elseif($row->responseReason=='Failure'){
$status = '<span class="badge rounded-pill badge-danger">Failed</span>';
}else{
$status = '<span class="badge rounded-pill badge-warning">Processing</span>';
}


if($row->responseReason=='Successful'){
$prient = '<i class="fa fa-print" style="font-size: 25px; color:#54BA4A;"></i>';
}elseif($row->responseReason=='Failed'){
$prient = '<i class="fa fa-print" style="font-size: 25px; color:#ea4159;"></i>';
}elseif($row->responseReason=='Failure'){
$prient = '<i class="fa fa-print" style="font-size: 25px; color:#ea4159;"></i>';
}else{
$prient = '<i class="fa fa-print" style="font-size: 25px; color:#FFAA05;"></i>';
}



$Receipt = '<a href="#" data-bs-toggle="modal" data-bs-target="#'.$row->txnRefId.'">'.$prient.'</i></a>

  <div class="modal fade " id="'.$row->txnRefId.'" tabindex="-1" role="dialog" aria-labelledby="'.$row->txnRefId.'" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content printable-area">
                          <div class="modal-body printable-area"> 
                            <div class="modal-toggle-wrapper">  
                              <ul class="modal-img justify-content-between">
                               <li> <img src="'.url('backend/uploads/setting/'.$globalData->dark_logo).'" alt="error"></li>
                                <li> <img src="'.url('backend/assets/images/BBPS New Logo_1-05.jpg').'" alt="error"></li>
                               
                              </ul>
                              <h4 class="text-center pb-2">Payment '.$row->responseReason.'</h4>
                          <table class="table">
    <tbody>
        <tr>
            <td>Transaction ID</td>
            <td>'.$row->txnRefId.'</td>
        </tr>
         <tr>
            <td>Biller ID</td>
            <td>'.$row->biller_id.'</td>
        </tr>
        <tr>
            <td>Biller Name</td>
            <td>'.$row->biller_name.'</td>
        </tr>
                     <tr>
            <td>Approval Ref.Number</td>
            <td>'.$row->approvalRefNumber.'</td>
        </tr>
        <tr>
            <td>Customer Name</td>
            <td>'.$row->RespCustomerName.'</td>
        </tr>
        <tr>
            <td>Bill Amount</td>
            <td>₹'.$row->RespAmount.'</td>
        </tr>
        <tr>
            <td>Transaction Date and Time</td>
            <td>'. date('j M Y h:i:s',strtotime($row->created_at)).'</td>
        </tr>
        <tr>
            <td>Payment Mode</td>
            <td id="paymentModeCell">Cash</td>
        </tr>
        <tr>
            <td>Transaction Status</td>
            <td>'.$row->responseReason.'</td>
        </tr>
    </tbody>
</table>
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
"agent_id" => $row->agent_id,
"agent_name_id" => getUsernameByAgentId($row->agent_id) . '(<span style="color:red;">' . $row->agent_id . '</span>)',
"customername"=>$row->RespCustomerName,
"transactionID"=>$row->txnRefId,
"Amount"=> '₹'.$row->RespAmount,
"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
"Receipt"=> $Receipt,
"status"=> $status,
);
}
$aid = $request->session()->get('AGENT_EMAIL');
$user = DB::table('agents')->where('email',$aid)->first();
if($user){
$query = DB::table('bbps_transactions')->where('agent_id',$user->id)->orderby('id','DESC');
}else{
$query = DB::table('bbps_transactions')->orderby('id','DESC');
}

$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $tot_rows,
"recordsFiltered" => $agentdatacount,
"data" => $data
);


echo json_encode($datas);

}





public function complaint_registron(Request $request)
{

if($request->session()->get('AGENT_EMAIL')){

$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();

$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '11';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

return view('backend/Agent/Bbps/complaint-registron');



}else{
return redirect('agent/login')->with('error','Agent is not authorized');
}  

}

public function complaintregistronData(Request $request)
{

if($request->session()->get('AGENT_EMAIL')){


//*********** Encryption Function *********************
function encrypt($plainText, $key) {
$secretKey = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
$encryptedText = bin2hex($openMode);
return $encryptedText;
}

//*********** Decryption Function *********************
function decrypt($encryptedText, $key) {
$key = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$encryptedText = hextobin($encryptedText);
$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
return $decryptedText;
}

//*********** Padding Function *********************
function pkcs5_pad($plainText, $blockSize) {
$pad = $blockSize - (strlen($plainText) % $blockSize);
return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********
function hextobin($hexString) {
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

//********** To generate ramdom String ********
function generateRandomString($length = 35) {
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}

/* * ************************************************************ */
/* * ************************************************************ */
/* * ************************************************************ */



$formData = $request->all();

// print_r($formData);
// die;

$plainText = '<?xml version="1.0" encoding="UTF-8"?>
<complaintRegistrationReq>
<complaintType>Transaction</complaintType>
<participationType />
<agentId />
<txnRefId>' . $formData['refid'] . '</txnRefId>
<billerId />
<complaintDesc>' . $formData['desc'] . '</complaintDesc>
<servReason />
<complaintDisposition>' . $formData['transactionIssue'] . '</complaintDisposition>
</complaintRegistrationReq>';



// echo '<pre>';
// echo $plainText;
// die;

$key = "42A135C6289905F72312335B68B19136";
$encrypt_xml_data = encrypt($plainText, $key);

$data['accessCode'] = "AVCF04SK43EI06CBKG";
$data['requestId'] = generateRandomString();
$data['encRequest'] = $encrypt_xml_data;
$data['ver'] = "1.0";
$data['instituteId'] = "CV46";
$parameters = http_build_query($data);

$url = "https://api.billavenue.com/billpay/extComplaints/register/xml";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$result = curl_exec($ch);
$response = decrypt($result, $key);
// echo "<pre>";
// echo htmlentities($response);
// exit;

$xmlData = $response;

$xml = new SimpleXMLElement($xmlData); 



$jsonData = json_decode(json_encode($xml), true);
$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();


if($user){
$userID = $userData->id;
}

return response()->json($xml);  
$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '12';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

$com= new bbps_complaint;
$com->agentID = $userID;
$com->role = $userRole;
$com->ReferenceID = $formData['refid'];
$com->Disposition = $formData['desc'];
$com->description = $formData['transactionIssue'] ? $formData['transactionIssue'] : '';
$com->complaintID = $jsonData['complaintId'] ? $jsonData['complaintId'] : '';
$com->ComplaintAssigned = $jsonData['complaintAssigned'] ? $jsonData['complaintAssigned'] : '';
$com->ip = $request->ip();
$com->save();

if ($xml->responseCode == '000') {
$successMessage = 'Complaint Registered Successfully';
} else {
$errorMessage = 'Server problem please try again later';
}

if (isset($successMessage)) {
$request->session()->flash('success', $successMessage);
}
if (isset($errorMessage)) {
$request->session()->flash('error', $errorMessage);
}





}else{
return redirect('agent/login')->with('error','Agent is not authorized');
}  

}

public function complaintracking(Request $request)
{

if($request->session()->get('AGENT_EMAIL')){

//*********** Encryption Function *********************
function encrypt($plainText, $key) {
$secretKey = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
$encryptedText = bin2hex($openMode);
return $encryptedText;
}

//*********** Decryption Function *********************
function decrypt($encryptedText, $key) {
$key = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$encryptedText = hextobin($encryptedText);
$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
return $decryptedText;
}

//*********** Padding Function *********************
function pkcs5_pad($plainText, $blockSize) {
$pad = $blockSize - (strlen($plainText) % $blockSize);
return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********
function hextobin($hexString) {
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

//********** To generate ramdom String ********
function generateRandomString($length = 35) {
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}

/* * ************************************************************ */
/* * ************************************************************ */
/* * ************************************************************ */
$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();
$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '13';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

$formData = $request->all();

// print_r($formData);
// die;

$plainText = '<?xml version="1.0" encoding="UTF-8"?>
<complaintTrackingReq>
<complaintType>Transaction</complaintType>
<complaintId>'.$formData['complaintID'].'</complaintId>
</complaintTrackingReq>';



// echo '<pre>';
// echo $plainText;
// die;

$key = "42A135C6289905F72312335B68B19136";
$encrypt_xml_data = encrypt($plainText, $key);

$data['accessCode'] = "AVCF04SK43EI06CBKG";
$data['requestId'] = generateRandomString();
$data['encRequest'] = $encrypt_xml_data;
$data['ver'] = "1.0";
$data['instituteId'] = "CV46";
$parameters = http_build_query($data);

$url = "https://api.billavenue.com/billpay/extComplaints/track/xml";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$result = curl_exec($ch);
$response = decrypt($result, $key);
// echo "<pre>";
// echo htmlentities($response);
// exit;

$xmlData = $response;
$xml = new SimpleXMLElement($xmlData); 

// if ($xml->responseCode == '000') {
//     $successMessage = 'Complaint Registered Successfully';
// } else {
//     $errorMessage = 'Server problem please try again later';
// }

//  if (isset($successMessage)) {
//         $request->session()->flash('success', $successMessage);
//     }
//     if (isset($errorMessage)) {
//         $request->session()->flash('error', $errorMessage);
//     }

return response()->json($xml);   



}else{
return redirect('agent/login')->with('error','Agent is not authorized');
}  

}


public function search_transaction(Request $request)
{

if($request->session()->get('AGENT_EMAIL')){
$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();
$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '14';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

return view('backend/Agent/Bbps/search-transaction');

}else{
return redirect('agent/login')->with('error','Agent is not authorized');
}  

}

public function searchTransactionData(Request $request)
{

if($request->session()->get('AGENT_EMAIL')){

//*********** Encryption Function *********************
function encrypt($plainText, $key) {
$secretKey = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
$encryptedText = bin2hex($openMode);
return $encryptedText;
}

//*********** Decryption Function *********************
function decrypt($encryptedText, $key) {
$key = hextobin(md5($key));
$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
$encryptedText = hextobin($encryptedText);
$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
return $decryptedText;
}

//*********** Padding Function *********************
function pkcs5_pad($plainText, $blockSize) {
$pad = $blockSize - (strlen($plainText) % $blockSize);
return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********
function hextobin($hexString) {
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

//********** To generate ramdom String ********
function generateRandomString($length = 35) {
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}

/* * ************************************************************ */
/* * ************************************************************ */
/* * ************************************************************ */

$user = $request->session()->get('AGENT_EMAIL');
$userData = Agent::where('email',$user)->first();


$userRole = "2";
$userIp = $request->ip();
$userid = $userData->id;
$activity = '15';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);


$formData = $request->TRANS_REF_ID;

$plainText = '<?xml version="1.0" encoding="UTF-8"?>
<transactionStatusReq>
<trackType>TRANS_REF_ID</trackType>
<trackValue>'.$formData.'</trackValue>
</transactionStatusReq>';



// echo '<pre>';
// echo $plainText;
// die;

$key = "42A135C6289905F72312335B68B19136";
$encrypt_xml_data = encrypt($plainText, $key);

$data['accessCode'] = "AVCF04SK43EI06CBKG";
$data['requestId'] = generateRandomString();
$data['encRequest'] = $encrypt_xml_data;
$data['ver'] = "1.0";
$data['instituteId'] = "CV46";
$parameters = http_build_query($data);

$url = "https://api.billavenue.com/billpay/transactionStatus/fetchInfo/xml";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$result = curl_exec($ch);
$response = decrypt($result, $key);
// echo "<pre>";
// echo htmlentities($response);
// exit;

$xmlData = $response;


$xml = new SimpleXMLElement($xmlData); 


return response()->json($xml);



}else{
return redirect('agent/login')->with('error','Agent is not authorized');
}  

}







}
