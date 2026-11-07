<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\AgentauthController;
use App\Http\Controllers\payment\Phonepecontroller;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\SuperAdmin\Walletcontroller;
use App\Http\Controllers\SuperAdmin\BbpsservicesController as superadminBbpsservicesController;
use App\Http\Controllers\payment\Paymentcontroller;
use App\Http\Controllers\Softwareapi\Payoutcontroller;
use App\Http\Controllers\BbpsservicesController;
use App\Http\Controllers\Softwareapi\Aepscontroller;
use App\Http\Middleware\LogPageLoad;
use App\Http\Middleware\CheckStatus;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', function () {
return redirect('/');
});

/******************************************************SUPERADMIN START************************************************************************/

Route::prefix('superadmin')->name('superadmin.')->group(function(){



Route::get('login',[SuperAdminAuthController::class,'login'])->name('login');  
Route::post('/login_process',[SuperAdminAuthController::class,'login_process']);
Route::get('/verify',[SuperAdminAuthController::class,'verify'])->name('verify');
Route::post('/otp_verify',[SuperAdminAuthController::class,'otp_verify'])->name('otp_verify');
Route::post('/ResendOTP',[SuperAdminAuthController::class,'ResendOTP'])->name('ResendOTP');
Route::get('/logout',[SuperAdminAuthController::class,'logout'])->name('logout');
Route::get('/', function () {
if (Session::has('SUPERADMIN_EMAIL')) {
return redirect()->route('superadmin.index');
} else {
return redirect()->route('superadmin.login');
}
})->name('home');

Route::middleware([LogPageLoad::class])->group(function () {


Route::get('/forgot-password',[SuperAdminAuthController::class,'forgot_password'])->name('forgot-password');
Route::post('/resetPassword',[SuperAdminAuthController::class,'resetPassword'])->name('resetPassword');
Route::get('/updatePassword',[SuperAdminAuthController::class,'getupdatePassword'])->name('getupdatePassword');
Route::post('/changePassword',[SuperAdminAuthController::class,'changePassword'])->name('changePassword');
Route::get('/change-password',[SuperAdminAuthController::class,'change_password'])->name('change-password');
Route::post('/updateAgentpassword',[SuperAdminAuthController::class,'updateAgentpassword'])->name('updateAgentpassword');


Route::get('index',[SuperAdminController::class,'index'])->name('index');
Route::get('settings',[SuperAdminController::class,'settings'])->name('settings');


Route::prefix('agent')->name('agent.')->group(function(){

Route::get('index',[AgentauthController::class,'index'])->name('index');
Route::get('create',[AgentauthController::class,'create'])->name('create'); 
Route::get('/get-states', [AgentauthController::class,'getStates'])->name('get-states');
Route::get('/get-cities', [AgentauthController::class,'getCities'])->name('get-cities');
Route::post('/store', [AgentauthController::class,'store'])->name('store');
Route::get('/edit/{id}', [AgentauthController::class,'edit'])->name('edit');
Route::post('/update/{id}', [AgentauthController::class,'update'])->name('update');
Route::get('/show/{id}',[AgentauthController::class,'show'])->name('show'); 
Route::get('/permissions/{id}',[AgentauthController::class,'permissions'])->name('permissions');
Route::get('/fetch-agent-permissions/{agentId}', [AgentauthController::class,'fetchAgentPermissions'])->name('fetch-agent-permissions');
Route::post('/updatepermissions', [AgentauthController::class,'updatepermissions'])->name('updatepermissions'); 
Route::post('/agentajexview', [AgentauthController::class,'agentajexview'])->name('agentajexview'); 
Route::post('/status', [AgentauthController::class,'updateUserStatus'])->name('status');
Route::post('/addAgentbeneficiariesaccount', [AgentauthController::class,'addAgentbeneficiariesaccount'])->name('addAgentbeneficiariesaccount');
Route::post('/agentdmtchrageupdate/{id}', [AgentauthController::class,'agentdmtchrageupdate'])->name('agentdmtchrageupdate');
Route::post('/agentpayouttchrageupdate/{id}', [AgentauthController::class,'agentpayouttchrageupdate'])->name('agentpayouttchrageupdate');
});



Route::prefix('wallet')->name('wallet.')->group(function(){

Route::get('addmoney',[Walletcontroller::class,'addmoney'])->name('addmoney');
Route::get('addmoneytoagent',[Walletcontroller::class,'addmoneytoagent'])->name('addmoneytoagent');
Route::post('Add_money_to_agent',[Walletcontroller::class,'Add_money_to_agent'])->name('Add-money-to-agent');
Route::get('deductmoneytoagent',[Walletcontroller::class,'deductmoneytoagent'])->name('deductmoneytoagent');
Route::post('Deduct_money_to_agent',[Walletcontroller::class,'Deduct_money_to_agent'])->name('Deduct_money_to_agent');
Route::get('transaction-history',[Walletcontroller::class,'transaction_history'])->name('transaction-history');
Route::get('transaction-history-data/{id}',[Walletcontroller::class,'transaction_history_data'])->name('transaction-history-data');
Route::post('/transactionhistoryajexview', [Walletcontroller::class,'transactionhistoryajexview'])->name('transactionhistoryajexview'); 
Route::get('/payment-requset-history',[Walletcontroller::class,'payment_requset_history'])->name('payment_requset_history');
Route::post('/payment_requset_historyajexview', [Walletcontroller::class,'payment_requset_historyajexview'])->name('payment_requset_historyajexview');
Route::post('/wallet/update-status', [Walletcontroller::class, 'payment_requset_update_status'])->name('payment_requset_update_status');
});


Route::prefix('scripts')->name('scripts.')->group(function(){

Route::get('create',[SuperAdminController::class,'createScipt'])->name('create');
Route::post('store',[SuperAdminController::class,'scriptstore'])->name('store');
Route::post('/update/{id}',[SuperAdminController::class,'scriptupdate'])->name('update');
Route::get('/delete/{id}',[SuperAdminController::class,'deleteScipt'])->name('delete');
});


Route::prefix('news')->name('news.')->group(function(){

Route::get('create',[SuperAdminController::class,'createnews'])->name('create');
Route::post('store',[SuperAdminController::class,'newsstore'])->name('store');
Route::post('/update/{id}',[SuperAdminController::class,'newsupdate'])->name('update');
Route::get('/delete/{id}',[SuperAdminController::class,'deletenews'])->name('delete');
});


Route::prefix('BillCategory')->name('BillCategory.')->group(function(){

Route::get('create',[SuperAdminController::class,'createBillCategory'])->name('create');
Route::post('store',[SuperAdminController::class,'bbpsCategorystore'])->name('store');
Route::post('/update/{id}',[SuperAdminController::class,'bbpsCategorytupdate'])->name('update');
Route::get('/delete/{id}',[SuperAdminController::class,'deletebbpsCategory'])->name('delete');
});


Route::prefix('system-setting')->name('setting.')->group(function(){
Route::get('/system-setting', [SuperAdminController::class,'system_setting'])->name('systemSetting');
Route::post('/update/{id}',[SuperAdminController::class,'system_settingupdate'])->name('update');

});



Route::prefix('bbps')->name('bbps.')->group(function(){
Route::get('index',[superadminBbpsservicesController::class,'index'])->name('index');    
Route::get('complaint-registron',[superadminBbpsservicesController::class,'complaint_registron'])->name('complaint-registron');    
Route::get('search-transaction',[superadminBbpsservicesController::class,'search_transaction'])->name('search-transaction');  
Route::post('fetch_category',[superadminBbpsservicesController::class,'fetch_category'])->name('fetch_category');     
Route::post('store_parameters',[superadminBbpsservicesController::class,'store_parameters'])->name('store_parameters');     
Route::post('fetch_parameters',[superadminBbpsservicesController::class,'fetch_parameters'])->name('fetch_parameters'); 
Route::post('store_bbpstbillfetch',[superadminBbpsservicesController::class,'store_bbpstbillfetch'])->name('store_bbpstbillfetch');  
Route::post('billPayRequest',[superadminBbpsservicesController::class,'billPayRequest'])->name('billPayRequest');  
Route::get('billhistory',[superadminBbpsservicesController::class,'billhistory'])->name('billing-history');  
Route::post('/billhistoryajexview', [superadminBbpsservicesController::class,'billhistoryajexview'])->name('billhistoryajexview'); 
Route::post('/searchTransactionData', [superadminBbpsservicesController::class,'searchTransactionData'])->name('searchTransactionData'); 
Route::post('/complaintregistronData', [superadminBbpsservicesController::class,'complaintregistronData'])->name('complaintregistronData'); 
Route::post('/complaintracking', [superadminBbpsservicesController::class,'complaintracking'])->name('complaintracking'); 
Route::post('/encrypt-xml', [superadminBbpsservicesController::class,'encryptXml'])->name('encrypt-xml');
Route::post('/agentPinVerify', [superadminBbpsservicesController::class,'agentPinVerify'])->name('agentPinVerify'); 
}); 


Route::get('/viewalltxn', [SuperAdminController::class,'viewalltxn'])->name('viewalltxn'); 
Route::post('/viewalltxnData', [SuperAdminController::class,'viewalltxnData'])->name('viewalltxnData'); 
Route::get('Wihdrawhistory',[SuperAdminController::class,'Wihdrawhistory'])->name('Wihdrawhistory');
Route::get('mobilerechargeHistory',[SuperAdminController::class,'mobilerechargeHistory'])->name('mobilerechargeHistory');
Route::post('viewmobilerechargeHistory',[SuperAdminController::class,'viewmobilerechargeHistory'])->name('viewmobilerechargeHistory');
Route::get('txnstatus',[SuperAdminController::class,'txnstatus'])->name('txnstatus');
Route::post('viewWihdrawhistory',[SuperAdminController::class,'viewWihdrawhistory'])->name('viewWihdrawhistory');
Route::post('aepstxnstatus',[SuperAdminController::class,'aepstxnstatus'])->name('aepstxnstatus');
Route::get('blanceenqueryhistory',[SuperAdminController::class,'blanceenqueryhistory'])->name('blanceenqueryhistory');
Route::post('viewblanceenqueryhistory',[SuperAdminController::class,'viewblanceenqueryhistory'])->name('viewblanceenqueryhistory');
Route::get('ministatementhistory',[SuperAdminController::class,'ministatementhistory'])->name('ministatementhistory');
Route::post('viewministatementhistory',[SuperAdminController::class,'viewministatementhistory'])->name('viewministatementhistory');
Route::get('balancewithdrawltax',[SuperAdminController::class,'balancewithdrawltax'])->name('balancewithdrawltax');
Route::post('updatebalancewithdrawltax',[SuperAdminController::class,'updatebalancewithdrawltax'])->name('updatebalancewithdrawltax');
Route::get('mobilerecharegetexes',[SuperAdminController::class,'mobilerecharegetexes'])->name('mobilerecharegetexes');
Route::post('updatemobilerecharegetexes/{id}',[SuperAdminController::class,'updatemobilerecharegetexes'])->name('updatemobilerecharegetexes');
Route::get('pipe',[SuperAdminController::class,'pipe'])->name('pipe');
Route::post('updatepipe',[SuperAdminController::class,'updatepipe'])->name('updatepipe');
Route::get('ticket',[SuperAdminController::class,'ticket'])->name('ticket');
});

});

/******************************************************SUPERADMIN END************************************************************************/

/******************************************************AGENT START************************************************************************/


Route::prefix('agent')->name('agent.')->group(function(){
Route::get('/check-agent-status', [AgentController::class, 'checkAgentStatus'])->name('check-agent-status');
Route::get('login',[AgentController::class,'login'])->name('login');  
Route::post('/login_process',[AgentController::class,'login_process']);
Route::get('/verify',[AgentController::class,'verify'])->name('verify');
Route::post('/otp_verify',[AgentController::class,'otp_verify'])->name('otp_verify');
Route::post('/ResendOTP',[AgentController::class,'ResendOTP'])->name('ResendOTP');
Route::get('/logout',[AgentController::class,'logout'])->name('logout');
Route::view('/Terms-Conditions','backend/Agent/Terms&Conditions')->name('Terms&Conditions');

Route::get('/', function () {
if (Session::has('AGENT_EMAIL')) {
return redirect()->route('agent.index');
} else {
return redirect()->route('agent.login');
}
})->name('home');

Route::middleware([CheckStatus::class])->group(function () {
Route::middleware([LogPageLoad::class])->group(function () {


Route::get('index',[AgentController::class,'index'])->name('index');
Route::get('/forgot-password',[AgentController::class,'forgot_password'])->name('forgot-password');
Route::post('/resetPassword',[AgentController::class,'resetPassword'])->name('resetPassword');
Route::get('/updatePassword',[AgentController::class,'getupdatePassword'])->name('getupdatePassword');
Route::post('/changePassword',[AgentController::class,'changePassword'])->name('changePassword');
Route::get('/change-password',[AgentController::class,'change_password'])->name('change-password');
Route::post('/updateAgentpassword',[AgentController::class,'updateAgentpassword'])->name('updateAgentpassword');
Route::view('/franchise-agreement/{id}','backend/Agent/franchise-agreement')->name('franchise-agreement');
Route::prefix('wallet')->name('wallet.')->group(function(){

Route::get('addmoney',[AgentController::class,'addmoney'])->name('addmoney');
Route::get('transaction-history',[AgentController::class,'transaction_history'])->name('transaction-history');
Route::get('transaction-history-data/{id}',[AgentController::class,'transaction_history_data'])->name('transaction-history-data');
Route::post('/transactionhistoryajexview', [AgentController::class,'transactionhistoryajexview'])->name('transactionhistoryajexview');
Route::get('/moneyrequset',[AgentController::class,'moneyrequset'])->name('moneyrequset');
Route::get('/payment-requset-history',[AgentController::class,'payment_requset_history'])->name('payment_requset_history');
Route::post('/payment_requset_historyajexview', [AgentController::class,'payment_requset_historyajexview'])->name('payment_requset_historyajexview');
});

Route::prefix('payout')->name('payout.')->group(function(){

Route::get('beneficiaries',[Payoutcontroller::class,'beneficiaries'])->name('beneficiaries');
Route::get('transaction-history',[Payoutcontroller::class,'transaction_history'])->name('transaction-history');
Route::get('transaction-history-data/{id}',[Payoutcontroller::class,'transaction_history_data'])->name('transaction-history-data');
Route::get('payout-invoice/{id}',[Payoutcontroller::class,'payout_invoice'])->name('payout-invoice');
Route::get('payout',[Payoutcontroller::class,'payout'])->name('payout');
Route::get('payouttxn',[Payoutcontroller::class,'payouttxn'])->name('payouttxn');

});


Route::prefix('bbps')->name('bbps.')->group(function(){

Route::get('index',[BbpsservicesController::class,'index'])->name('index');    
Route::get('complaint-registron',[BbpsservicesController::class,'complaint_registron'])->name('complaint-registron');    
Route::get('search-transaction',[BbpsservicesController::class,'search_transaction'])->name('search-transaction');  
Route::post('fetch_category',[BbpsservicesController::class,'fetch_category'])->name('fetch_category');     
Route::post('store_parameters',[BbpsservicesController::class,'store_parameters'])->name('store_parameters');     
Route::post('fetch_parameters',[BbpsservicesController::class,'fetch_parameters'])->name('fetch_parameters'); 
Route::post('store_bbpstbillfetch',[BbpsservicesController::class,'store_bbpstbillfetch'])->name('store_bbpstbillfetch');  
Route::post('billPayRequest',[BbpsservicesController::class,'billPayRequest'])->name('billPayRequest');  
Route::get('billhistory',[BbpsservicesController::class,'billhistory'])->name('billing-history');  
Route::post('/billhistoryajexview', [BbpsservicesController::class,'billhistoryajexview'])->name('billhistoryajexview'); 
Route::post('/searchTransactionData', [BbpsservicesController::class,'searchTransactionData'])->name('searchTransactionData'); 
Route::post('/complaintregistronData', [BbpsservicesController::class,'complaintregistronData'])->name('complaintregistronData'); 
Route::post('/complaintracking', [BbpsservicesController::class,'complaintracking'])->name('complaintracking'); 
Route::post('/encrypt-xml', [BbpsservicesController::class,'encryptXml'])->name('encrypt-xml'); 
Route::post('/agentPinVerify', [BbpsservicesController::class,'agentPinVerify'])->name('agentPinVerify'); 
});  

Route::prefix('aeps')->name('aeps.')->group(function(){
Route::get('agentOnboarding',[Aepscontroller::class,'agentOnboarding'])->name('agentOnboarding');
Route::get('agentOnboardingStatus',[Aepscontroller::class,'agentOnboardingStatus'])->name('agentOnboardingStatus');
Route::get('agentRegistration',[Aepscontroller::class,'agentRegistration'])->name('agentRegistration');
Route::get('agentAuthenticate',[Aepscontroller::class,'agentAuthenticate'])->name('agentAuthenticate');
Route::get('agentmerchant_authencity',[Aepscontroller::class,'agentmerchant_authencity'])->name('agentmerchant_authencity');
Route::get('balanceenquiry',[Aepscontroller::class,'balanceenquiry'])->name('balanceenquiry');
Route::get('balanceWihdraw',[Aepscontroller::class,'balanceWihdraw'])->name('balanceWihdraw');
Route::get('ministatement',[Aepscontroller::class,'ministatement'])->name('ministatement');
Route::get('txnstatus',[Aepscontroller::class,'txnstatus'])->name('txnstatus');
Route::get('Wihdrawhistory',[Aepscontroller::class,'Wihdrawhistory'])->name('Wihdrawhistory');


});


Route::prefix('mobileRecharge')->name('mobileRecharge.')->group(function(){
Route::get('mobileRecharge',[Aepscontroller::class,'mobileRecharge'])->name('mobileRecharge');
Route::post('hlrcheck',[Aepscontroller::class,'hlrcheck'])->name('hlrcheck');
Route::post('browseplan',[Aepscontroller::class,'browseplan'])->name('browseplan');
Route::post('dorecharge',[Aepscontroller::class,'dorecharge'])->name('dorecharge');
Route::get('mobilerechargeHistory',[Aepscontroller::class,'mobilerechargeHistory'])->name('mobilerechargeHistory');
});



Route::prefix('courier')->name('courier.')->group(function(){
Route::get('courierCreate',[Aepscontroller::class,'courierCreate'])->name('courierCreate');
Route::get('courieprocceddata',[Aepscontroller::class,'courieprocceddata'])->name('courieprocceddata');
});


Route::get('/viewalltxn', [AgentController::class,'viewalltxn'])->name('viewalltxn'); 
Route::post('/viewalltxnData', [AgentController::class,'viewalltxnData'])->name('viewalltxnData'); 
});

});
});
/******************************************************AGENT END************************************************************************/


/******************************************************PAYMENT START************************************************************************/

Route::middleware([LogPageLoad::class])->group(function () {
Route::prefix('payment')->name('payment.')->group(function(){
Route::post('paymentaddmoney',[Paymentcontroller::class,'paymentaddmoney'])->name('paymentaddmoney');
Route::any('phoneperesponse',[Paymentcontroller::class,'phoneperesponse'])->name('phoneperesponse');
Route::post('razorpay-payment', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');
Route::any('cc-response',[Paymentcontroller::class,'ccResponse'])->name('cc-response');
Route::post('paymentrequset',[Paymentcontroller::class,'paymentrequset'])->name('paymentrequset');

});
});
/******************************************************PAYMENT END************************************************************************/




/******************************************************Payout Working  START************************************************************************/

Route::middleware([LogPageLoad::class])->group(function () {
Route::prefix('payout')->name('payout.')->group(function(){

Route::post('addbeneficiaries',[Payoutcontroller::class,'addbeneficiaries'])->name('addbeneficiaries');
Route::post('addbeneficiariesnumberverify',[Payoutcontroller::class,'addbeneficiariesnumberverify'])->name('addbeneficiariesnumberverify');
Route::post('addbeneficiariesaccount',[Payoutcontroller::class,'addbeneficiariesaccount'])->name('addbeneficiariesaccount');
Route::post('payoutpayment',[Payoutcontroller::class,'payoutpayment'])->name('payoutpayment');
Route::post('payouttransfar',[Payoutcontroller::class,'payouttransfar'])->name('payouttransfar');

});
});
/******************************************************Payout Working END************************************************************************/
 
/******************************************************AEPS Working START************************************************************************/
Route::middleware([LogPageLoad::class])->group(function () {
Route::prefix('aeps')->name('aeps.')->group(function(){
Route::post('proceedOnboarding',[Aepscontroller::class,'proceedOnboarding'])->name('proceedOnboarding');
Route::post('AgentKycRegistration',[Aepscontroller::class,'AgentKycRegistration'])->name('AgentKycRegistration');
Route::post('AgentKycAuthenticate',[Aepscontroller::class,'AgentKycAuthenticate'])->name('AgentKycAuthenticate');
Route::post('AgentKycmerchant_authencity',[Aepscontroller::class,'AgentKycmerchant_authencity'])->name('AgentKycmerchant_authencity');
Route::post('aepsbalanceenquiry',[Aepscontroller::class,'aepsbalanceenquiry'])->name('aepsbalanceenquiry');
Route::post('aepsbalancewihdraw',[Aepscontroller::class,'aepsbalancewihdraw'])->name('aepsbalancewihdraw');
Route::post('aepsministatement',[Aepscontroller::class,'aepsministatement'])->name('aepsministatement');
Route::post('aepstxnstatus',[Aepscontroller::class,'aepstxnstatus'])->name('aepstxnstatus');
Route::post('viewWihdrawhistory',[Aepscontroller::class,'viewWihdrawhistory'])->name('viewWihdrawhistory');
Route::any('agentOnboardingCallback',[Aepscontroller::class,'agentOnboardingCallback'])->name('agentOnboardingCallback');
Route::post('viewmobilerechargeHistory',[Aepscontroller::class,'viewmobilerechargeHistory'])->name('viewmobilerechargeHistory');
Route::post('courierproceed',[Aepscontroller::class,'courierproceed'])->name('courierproceed');
Route::post('courierpartnerCheck',[Aepscontroller::class,'courierpartnerCheck'])->name('courierpartnerCheck');
Route::post('createcourier',[Aepscontroller::class,'createcourier'])->name('createcourier');
});
});


Route::get('reset', function (){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    
    return back();
});
