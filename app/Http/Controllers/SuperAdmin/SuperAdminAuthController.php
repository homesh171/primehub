<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\superAdmin;
use Illuminate\Support\Carbon;
use App\Mail\mail;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;
use App\Services\OtpLogService;
use App\Services\LogService;
use Crypt;
use Session;
use App\Models\system_setting;
use App\Models\allmassageapis;
use Hash;

class SuperAdminAuthController extends Controller
{
    
    public function login(Request $request){
        
        $id = $request->session()->get('SUPERADMIN_ID');

         if(!empty($id)){
       return redirect('superadmin/index');
         }else{
             return view('backend/SuperAdmin/Auth/login');
         }
         
    }
    
    public function login_process(Request $request)
    {
        
     

        $result=DB::table('ph_super_admins')  
            ->where(['email'=>$request->email])
            ->get(); 
        
        if(isset($result[0])){
            $db_pwd=$result[0]->password;
       
                      if(Hash::check($request->password, $db_pwd)){
                $request->session()->put('SUPERADMIN_AUTHORIZED',true);
                $request->session()->put('SUPERADMIN_EMAIL',$result[0]->email);
                $status="success";
                $msg="";
                
                $otp = rand(111111, 999999);
                
                $expDate = Carbon::now()->addMinutes(5);
                
                $admin = DB::table('ph_super_admins')->where('email', $result[0]->email)->first();
            if ($admin) {
    $admin->otp = $otp;
    $admin->exptime = $expDate;
    
    
    DB::table('ph_super_admins')->where('email', $result[0]->email)->update([
        'otp' => $otp,
        'exptime' => $expDate,
    ]);
    
    $number = $result[0]->mobile;
    
 $sendotp = allmassageapis::where('id','1')->first();
 $massage = str_replace("{var}","$otp",$sendotp->massage);
 $otpstratus = sendOtp($number,$massage);

// $url = "https://baiji.co.in/api/send";
// $fields = [
//     'number'        => '91'.$result[0]->mobile,
//     'type'          => "text",
//     'message'       => 'Your Otp Verification Code is '.$otp.' - Primehubsofttechsolutions',
//     'instance_id'   => '65B0DEF86D9B1',
//     'access_token'  => '65b0dc7da84da',
// ];

// Http::get($url, $fields);
   
    
    $details = [
        
        'otp'=>$otp,
        
        ];
    
    
    \Mail::to($result[0]->email)->send(new \App\Mail\mail($details));
    
}

$userMobile = $result[0]->mobile;
$userRole = "1";
$userIp = $request->ip();
$userid = $admin->id;
$activity = '1';
$weburl = $_SERVER['REQUEST_URI'];

OtpLogService::logLogin($userMobile,$otp,$userRole,$userIp);
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);
                
            }else{
                $status="error";
                $msg="Please enter valid password";
            } 
            

        }else{
            $status="error";
            $msg="Please enter valid email id";
        }
       return response()->json(['status'=>$status,'msg'=>$msg]); 
       //$request->password
    }
    
    
    
    public function verify(Request $request){
         $auth = $request->session()->get('SUPERADMIN_AUTHORIZED');
         if($auth==true){
             
              return view('backend/SuperAdmin/Auth/unlock');
         }else{
             return redirect('superadmin/login')->with('error','Superadmin is not authorized');
         }
       
    }

    
    
    public function otp_verify(Request $request){
        

$email = $request->session()->get('SUPERADMIN_EMAIL');
$admin = DB::table('ph_super_admins')->where('email', $email)->first();

if ($admin && Carbon::now() <= Carbon::parse($admin->exptime)) {
    // Check if OTP is provided and matches the stored OTP
    if (!empty($request->otp) && $admin->otp == $request->otp) {

         DB::table('ph_super_admins')->where('email', $email)->update([
        'otp' => null,
        'exptime' => null,
    ]);
    
    
           $request->session()->flush();

        $request->session()->put('SUPERADMIN_LOGIN', true);
        $request->session()->put('SUPERADMIN_ID', $admin->id);
        $request->session()->put('SUPERADMIN_NAME', $admin->username);
        $request->session()->put('SUPERADMIN_EMAIL',$admin->email);


  $agent = new Agent();
    $browser = $agent->browser();
    $platform = $agent->platform();

$currentTimeZone = config('timezone');
$userAgent = $request->header('User-Agent');
$clientIp = $request->ip();


// $url = "https://baiji.co.in/api/send";
// $fields = [
//     'number'        => '91'.$admin->mobile,
//     'type'          => "text",
//     'message'       => "Hi $admin->username,\n\nThere was a successful login $admin->email on "
//              . Carbon::now()->format('d-m-Y (H:i:s)') . " - $currentTimeZone with the following device information.\n"
//              . "Device: $platform \nBrowser: $browser \nIP: $clientIp",
//     'instance_id'   => '65B0DEF86D9B1',
//     'access_token'  => '65b0dc7da84da',
// ];

// Http::get($url, $fields);


$userRole = "1";
$userIp = $request->ip();
$userid = $admin->id;
$activity = '2';
$weburl = $_SERVER['REQUEST_URI'];


LogService::logs($activity,$weburl,$userid,$userRole,$userIp);


        return redirect('superadmin/index');
    } else {
        // Invalid OTP
        return back()->with('error', 'Invalid OTP');
    }
} else {
    // OTP is invalid or has expired
    return back()->with('error', 'OTP Expired');
}

    }
    
    
            public function ResendOTP(Request $request)
{
  $email = $request->session()->get('SUPERADMIN_EMAIL');
                    $otp = rand(111111, 999999);
           
                $expDate = Carbon::now()->addMinutes(5);
                
                $admin = DB::table('ph_super_admins')->where('email', $email)->first();
            if ($admin) {
    $admin->otp = $otp;
    $admin->exptime = $expDate;
    DB::table('ph_super_admins')->where('email', $email)->update([
        'otp' => $otp,
        'exptime' => $expDate,
    ]);
    
     $number = $admin->mobile;
    
 $sendotp = allmassageapis::where('id','1')->first();
 $massage = str_replace("{var}","$otp",$sendotp->massage);
 $otpstratus = sendOtp($number,$massage);


// $url = "https://baiji.co.in/api/send";
// $fields = [
//     'number'        => '91'.$admin->mobile,
//     'type'          => "text",
//     'message'       => 'Your Otp Verification Code is '.$otp.' - Primehubsofttechsolutions',
//     'instance_id'   => '65B0DEF86D9B1',
//     'access_token'  => '65b0dc7da84da',
// ];

// Http::get($url, $fields);

    
    $details = [
        
        'otp'=>$otp,
        
        ];
    
    
   \Mail::to($email)->send(new \App\Mail\mail($details));
    
    

$userMobile = $admin->mobile;
$userRole = "1";
$userIp = $request->ip();
$userid = $admin->id;
$activity = '3';
$weburl = $_SERVER['REQUEST_URI'];

OtpLogService::logLogin($userMobile,$otp,$userRole,$userIp);
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);
 
   return response()->json(['message' => 'OTP Sent Successfully']);
}

}
    
    
        public function logout(Request $request)
{
   $email = $request->session()->get('SUPERADMIN_EMAIL');
    
    $admin = DB::table('ph_super_admins')->where('email', $email)->first();
    
    
$userRole = "1";
$userIp = $request->ip();
$userid = $admin->id;
$activity = '4';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);
    
   session()->flush(); 
    return redirect('superadmin/login')->with('error','Superadmin is not authorized');
}


     public function forgot_password(Request $request){
         
         return view('backend/SuperAdmin/Auth/forgot-password');
         
     }
     
       public function resetPassword(Request $request){
           
           
           $request->validate([
               
               'email'=>'required'
               ]);
             
     $user = DB::table('ph_super_admins')->where('email',$request->email)->first();
     
     if(!empty($user)){
         
         $token = Crypt::encrypt($user->email).rand(10,9999);
 
         $expFormat = mktime(
             date("H"), date("i")+15, date("s"), date("m"), date("d"), date("Y")
         );
 
         $expDate = date("Y-m-d H:i:s",$expFormat);

         $userToUpdate = DB::table('ph_super_admins')->where('email',$request->email)->first();
        
         
         if ($userToUpdate) {
                 DB::table('ph_super_admins')
        ->where('email', $request->email)
        ->update([
            'reset_link_token' => $token,
            'exptime' => $expDate
        ]);
             
             
             $img = system_setting::first();
             
             $details = [
               'token' =>$token,
               'email' =>$user->email,
               'logo' =>$img->dark_logo,
               'site_title'=>$img->site_title
             ];
           
             \Mail::to($request->email)->send(new \App\Mail\superadminforgotmail($details));
           
             return back()->with('success','Email Sent Successfully!');
         } else {
             return back()->with('error','User not found!!');
         }
                 
     } else {
                 
         return back()->with('error','This email is not registered!!');
     }
             
}



 public function getupdatePassword(Request $request){

     
                 $key = $request->query('key'); 
              $token = $request->query('token');
              
              
              $request->session()->put('key',$key);
              $request->session()->put('token',$token);
     
                 $user = DB::table('ph_super_admins')->where('email',$key)->where('reset_link_token',$token)->first();
                 
                 
              
             $curDate = date("Y-m-d H:i:s");

            if ($user) {
        $curDate = date("Y-m-d H:i:s");

        if($user->exptime >= $curDate) {
             return view('backend/SuperAdmin/Auth/reset-password');
             

            
        } else {
            return redirect('superadmin/forgot-password')->with('error', 'This link has expired!!');
        }
    } else {
        return redirect('superadmin/forgot-password')->with('error', 'Invalid link. Please try again with a valid link.');
    }

 }

 public function changePassword(Request $request){
     
     
          $request->validate([
         'password' =>'required',
         'cpassword' =>'required|same:password'
         
         ],[
             
            'cpassword.required'=> 'The Confirm Password field is required.' 
             ]);
            
   
              
              $key = $request->session()->get('key'); 
              $token = $request->session()->get('token'); 
              
         
     
                 $user = DB::table('ph_super_admins')->where('email',$key)->where('reset_link_token',$token)->first();
    
              
                 if ($user) {
                     DB::table('ph_super_admins')->where('email',$key)->where('reset_link_token',$token)->update([
                         
                         'reset_link_token'=>null,
                         'exptime'=>null,
                         'password' =>Hash::make($request->password)
                         ]);
                     
 
            
            Session::forget('key');
            Session::forget('token');
        return redirect('superadmin/login')->with('success', 'Password Successfully Updated!!');
     } else {
        return back()->with('error', 'Invalid link. Please try again with a valid link.');
     }
     
     
     
     
     
 }
     
    public function change_password(Request $request){
     
     
         $id = $request->session()->get('SUPERADMIN_EMAIL');
        
        if(!empty($id)){
            
            $user = DB::table('ph_super_admins')->where('email',$id)->first();
            
            return view('backend/SuperAdmin/ChangePassword/ChangePassword');
            
        }else{
            
               return redirect('agent/login')->with('error','Agent is not authorized');;
            
        }
 }
        
         
 public function updateAgentpassword(Request $request){
     
     
     $request->validate([
         'current_password'=>'required',
         'new_password'=>'required',
         'confirm_password'=>'required |same:new_password',
         ]);
     
         $id = $request->session()->get('SUPERADMIN_EMAIL');
        
        if(!empty($id)){
            
            $user = DB::table('ph_super_admins')->where('email',$id)->first();
            
            if($user){
                
            if(Hash::check($request->current_password,$user->password)){
                
                DB::table('ph_super_admins')->where('email',$id)->update([
                    'password'=>Hash::make($request->new_password),
                    ]);
                return back()->with('success',' Password Successfully Changed');
                
            }else{
                return back()->with('error','Current Password is Invalid');
            }
                
                
            }
            
            
        }else{
            
               return redirect('agent/login')->with('error','Agent is not authorized');;
            
        }
     
     
     
 } 




    
       
}
