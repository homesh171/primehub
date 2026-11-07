<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Mail\mail;
use Illuminate\Support\Facades\Http;
use App\Services\OtpLogService;
use App\Services\LogService;
use Hash;
use Jenssegers\Agent\Agent;
use App\Models\system_setting;
use App\Models\wallet_recharge;
use App\Models\allmassageapis;
use App\Models\wallet_log;
use App\Models\bbps_category;
use App\Models\news;
use Crypt;
use Session;

class AgentController extends Controller
{
    function index(Request $request){
       $id = $request->session()->get('AGENT_ID');
        
        if(!empty($id)){
            $data['totalmaount'] = DB::table('agents')->where('id',$id)->first();
            $data['txn'] = wallet_log::where('user_id',$id)->where('role_id',$data['totalmaount']->role)->limit(5)->orderby('id','DESC')->get();
            $data['news'] = news::limit(5)->orderby('id','DESC')->get();
            $data['data'] = bbps_category::where('status','1')->get();
            return view('backend/Agent/index',$data);
        }else{
               return redirect('agent/login')->with('error','Agent is not authorized');;
        }
    }
    
      public function checkAgentStatus(Request $request)
    {
        if ($request->session()->get('AGENT_EMAIL')) {
            $agent = DB::table('agents')->where('email', $request->session()->get('AGENT_EMAIL'))->first();
            return response()->json(['kyc_status' => $agent ? $agent->kyc_status : null]);
        }
        
        return response()->json(['kyc_status' => null]);
    }
    
    
    
      public function login(Request $request){
        
        $id = $request->session()->get('AGENT_ID');

         if(!empty($id)){
       return redirect('agent/index');
         }else{
             return view('backend/Agent/login');
         }
         
    }
    
    
    
        public function login_process(Request $request)
    {
        
     

        $result=DB::table('agents')  
            ->where(['email'=>$request->email])
            ->get(); 
        
        if(isset($result[0])){
            $db_pwd=$result[0]->password;
       
$sts = $result[0]->kyc_status;
            if(!($sts=='1')){
       
       
                if(Hash::check($request->password, $db_pwd)){
                $request->session()->put('AGENT_AUTHORIZED',true);
                $request->session()->put('AGENT_EMAIL',$result[0]->email);
                  // $request->session()->put('AGENT_LOGIN', true);
        // $request->session()->put('AGENT_ID', $result[0]->id);
        // $request->session()->put('AGENT_NAME', $result[0]->username);
        //$request->session()->put('AGENT_EMAIL',$admin->email);
                $status="success";
                $msg="";
                
                $otp = rand(111111, 999999);
                
                $expDate = Carbon::now()->addMinutes(5);
                
                $admin = DB::table('agents')->where('email', $result[0]->email)->first();
            if ($admin) {
    $admin->otp = $otp;
    $admin->exptime = $expDate;
    
    
    DB::table('agents')->where('email', $result[0]->email)->update([
        'otp' => $otp,
        'exptime' => $expDate,
    ]);
    
    $number = $result[0]->mobile_number;
    
 $sendotp = allmassageapis::where('id','1')->first();
 $massage = str_replace("{var}","$otp",$sendotp->massage);
 
 
 $otpstratus = sendOtp($number,$massage);

// $url = "https://baiji.co.in/api/send";
// $fields = [
//     'number'        => '91'.$result[0]->mobile_number,
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


$userMobile = $result[0]->mobile_number;
$userRole = "2";
$userIp = $request->ip();
$userid = $admin->id;
$activity = '1';
$weburl = $_SERVER['REQUEST_URI'];

OtpLogService::logLogin($userMobile,$otp,$userRole,$userIp);
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);
                
            }else{
                $status="error";
                $msg="Please enter valid password";
            } }else{
                
                 $status="error";
                $msg="Your account has been deactivated Please contact customer service!"; 
            }
            

        }else{
            $status="error";
            $msg="Please enter valid email id";
        }
       return response()->json(['status'=>$status,'msg'=>$msg]); 
       //$request->password
    }
    
    
    
    public function verify(Request $request){
         $auth = $request->session()->get('AGENT_AUTHORIZED');
         if($auth==true){
             
              return view('backend/Agent/unlock');
         }else{
             
               return redirect('agent/login')->with('error','Agent is not authorized');
         }
       
    }

    
    
    public function otp_verify(Request $request){
        
  $auth = $request->session()->get('AGENT_AUTHORIZED');
         if($auth==true){
$email = $request->session()->get('AGENT_EMAIL');
$admin = DB::table('agents')->where('email', $email)->first();

if ($admin && Carbon::now() <= Carbon::parse($admin->exptime)) {
    // Check if OTP is provided and matches the stored OTP
    if (!empty($request->otp) && $admin->otp == $request->otp) {

         DB::table('agents')->where('email', $email)->update([
        'otp' => null,
        'exptime' => null,
    ]);

         $request->session()->flush();

        $request->session()->put('AGENT_LOGIN', true);
        $request->session()->put('AGENT_ID', $admin->id);
        $request->session()->put('AGENT_NAME', $admin->username);
        $request->session()->put('AGENT_EMAIL',$admin->email);


  $agent = new Agent();
    $browser = $agent->browser();
    $platform = $agent->platform();

$currentTimeZone = config('timezone');
$userAgent = $request->header('User-Agent');
$clientIp = $request->ip();


// $url = "https://baiji.co.in/api/send";
// $fields = [
//     'number'        => '91'.$admin->mobile_number,
//     'type'          => "text",
//     'message'       => "Hi $admin->username,\n\nThere was a successful login $admin->email on "
//              . Carbon::now()->format('d-m-Y (H:i:s)') . " - $currentTimeZone with the following device information.\n"
//              . "Device: $platform \nBrowser: $browser \nIP: $clientIp",
//      'instance_id'   => '65B0DEF86D9B1',
//     'access_token'  => '65b0dc7da84da',
// ];

// Http::get($url, $fields);

$userRole = "2";
$userIp = $request->ip();
$userid = $admin->id;
$activity = '2';
$weburl = $_SERVER['REQUEST_URI'];


LogService::logs($activity,$weburl,$userid,$userRole,$userIp);


        return redirect('agent/index');
    } else {
        // Invalid OTP
        return back()->with('error', 'Invalid OTP');
    }
} else {
    // OTP is invalid or has expired
    return back()->with('error', 'OTP Expired');
}}else{
               return redirect('agent/login')->with('error','Agent is not authorized');;
         }

    }
    
    
            public function ResendOTP(Request $request)
{
      $auth = $request->session()->get('AGENT_AUTHORIZED');
         if($auth==true){
  $email = $request->session()->get('AGENT_EMAIL');
                    $otp = rand(111111, 999999);
           
                $expDate = Carbon::now()->addMinutes(5);
                
                $admin = DB::table('agents')->where('email', $email)->first();
            if ($admin) {
    $admin->otp = $otp;
    $admin->exptime = $expDate;
    DB::table('agents')->where('email', $email)->update([
        'otp' => $otp,
        'exptime' => $expDate,
    ]);
    
     $number = $admin->mobile_number;
 $sendotp = allmassageapis::where('id','1')->first();
 $massage = str_replace("{var}","$otp",$sendotp->massage);
 $otpstratus = sendOtp($number,$massage);


// $url = "https://baiji.co.in/api/send";
// $fields = [
//     'number'        => '91'.$admin->mobile_number,
//     'type'          => "text",
//     'message'       => 'Your Otp Verification Code is '.$otp.' - Primehubsofttechsolutions',
//   'instance_id'   => '65B0DEF86D9B1',
//     'access_token'  => '65b0dc7da84da',
// ];

// Http::get($url, $fields);

    
    $details = [
        
        'otp'=>$otp,
        
        ];
    
    
    \Mail::to($email)->send(new \App\Mail\mail($details));
    
    
$userMobile = $admin->mobile_number;
$userRole = "2";
$userIp = $request->ip();
$userid = $admin->id;
$activity = '3';
$weburl = $_SERVER['REQUEST_URI'];

OtpLogService::logLogin($userMobile,$otp,$userRole,$userIp);
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);
 
   return response()->json(['message' => 'OTP Sent Successfully']);
}}else{
               return redirect('agent/login')->with('error','Agent is not authorized');;
         }

}
    
    
        public function logout(Request $request)
{
    
    
   $email = $request->session()->get('AGENT_EMAIL');

        
        if(!empty($email)){
    
    $admin = DB::table('agents')->where('email', $email)->first();
            
   
             

$userRole = "2";
$userIp = $request->ip();
$userid = $admin->id;
$activity = '4';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$userid,$userRole,$userIp);
    
   session()->flush(); 
   
      return redirect('agent/login')->with('error','Agent is not authorized');;
}else{
               return redirect('agent/login')->with('error','Agent is not authorized');;
         }}
    
    
    



/********************************************************************************************/
public function addmoney(Request $request){
        
             $id = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($id)){
            
       $data['paymentmode'] = DB::table('paymentmodes')->where('status','1')->get();
        return view('backend/Agent/Wallet/addmoney',$data);
        
    }else{
          return redirect('agent/login')->with('error','Agent is not authorized');;
    }}


 public function transaction_history(Request $request){
        
             $aid = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($aid)){
            
            
            $user = DB::table('agents')->where('email',$aid)->first();
            
            
$query = DB::table('wallet_recharges')->where('user_id',$user->id)->orderby('id','DESC');


   if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->input('from_date'));
    }

    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->input('to_date'));
    }

    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    if ($request->filled('transaction_id')) {
        $query->where('tran_id', 'like', '%' . $request->input('transaction_id') . '%');
    }

    $data['txnhistoy'] = $query->paginate(10);

       $data['old_input'] = $request->all();
        return view('backend/Agent/Wallet/transaction-history',$data)->withInput($data['old_input']);
        
    }else{
          return redirect('agent/login')->with('error','Agent is not authorized');;
    }}
    
        
        private function historyajexview($request,$draw,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,$rowcount){
       
       
 $start = $draw;

    $query = DB::table('wallet_recharges');

if ($request->session()->has('AGENT_EMAIL')) {
       
               $aid = $request->session()->get('AGENT_EMAIL');
        $user = DB::table('agents')->where('email', $aid)->first();
        $query->where('user_id', $user->id)->where('roleid', $user->role)->where('payment_request_id', '=' ,null);
         
    }


    if ($searchValue) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('order_id', 'like', '%' . $searchValue . '%')
              ->orWhere('tran_id', 'like', '%' . $searchValue . '%')
              ->orWhere('amount', 'like', '%' . $searchValue . '%');
        });
    }


    $sql = $query->toSql();

    $bindings = $query->getBindings();

    foreach ($bindings as $binding) {
        $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
    }

    if ($rowcount == 1) {
        $query->orderBy('id', 'desc')->limit(10)->offset($start);
        return $query->get();
    } else {
        return $query->count();
    }




        
}
    
    function transactionhistoryajexview(Request $request){
     
$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];


$agentdata =  $this->historyajexview($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$agentdatacount =  $this->historyajexview($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);
    // print_r($agentdatacount);
    // die;
$i = 1;

$data = array();
foreach ($agentdata as  $row) {
    
$action = '<ul class="action" style="justify-content: space-around;">';
$action .= '<li class="delete"><a href="' .route('agent.wallet.transaction-history-data', ['id' => Crypt::encrypt($row->id)]). '"><i class="icon-eye"></i></a></li>';
$action .= '</ul>';
 
if($row->status=='success'){
$status = '<span class="badge rounded-pill badge-success">Success</span>';
}else if($row->status=='pending'){
    $status = '<span class="badge rounded-pill badge-warning">pending</span>';
}else if($row->status=='Deduct'){
    $status = '<span class="badge rounded-pill badge-warning">Deduct</span>';
}else{
$status = '<span class="badge rounded-pill badge-danger">Failed</span>';
} 

$data[] = array(
	"id"=> $i++,
	"oredrid"=>$row->order_id,
    "transactionID"=>$row->tran_id,
	"Amount"=> '₹'.$row->amount,
	"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
	"status"=> $status,
	"action" => $action,
	);
}
  $aid = $request->session()->get('AGENT_EMAIL');
   $user = DB::table('agents')->where('email',$aid)->first();
if($user){
    $query = DB::table('wallet_recharges')->where('user_id',$user->id)->orderby('id','DESC');
}else{
    $query = DB::table('wallet_recharges')->orderby('id','DESC');
}

$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $agentdatacount,
"recordsFiltered" => $agentdatacount,
"data" => $data
);


echo json_encode($datas);

}


 public function transaction_history_data(Request $request,$id){
        
             $aid = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($aid)){
               $user = DB::table('agents')->where('email',$aid)->first();
               
                       if ($user) {
            $did = Crypt::decrypt($id);
            
$txndata = DB::table('wallet_recharges')
->join('paymentmodes','wallet_recharges.paymentMode','=','paymentmodes.id')
->select('wallet_recharges.ip as walletip','wallet_recharges.created_at as walletcreate','wallet_recharges.*','paymentmodes.*')
->where('wallet_recharges.user_id',$user->id)
->where('wallet_recharges.id',$did)->first();


            if ($txndata) {
                $data['txndata'] = $txndata;
                return view('backend/Agent/Wallet/transaction-history-data', $data);
            } else {
       
                return redirect('/')->with('error', 'Transaction not found for the logged-in user.');
            } 
            
            }else {

            return redirect('/')->with('error', 'User not authorized.');
        }
        }
        else{
          return redirect('agent/login')->with('error','Agent is not authorized');;
    }
    
    
 }
    
       public function forgot_password(Request $request){
         
         return view('backend/Agent/forgot-password');
         
     }
     
       public function resetPassword(Request $request){
           
           
           $request->validate([
               
               'email'=>'required'
               ]);
             
     $user = DB::table('agents')->where('email',$request->email)->first();
     
     if(!empty($user)){
         
         $token = Crypt::encrypt($user->email).rand(10,9999);
 
         $expFormat = mktime(
             date("H"), date("i")+15, date("s"), date("m"), date("d"), date("Y")
         );
 
         $expDate = date("Y-m-d H:i:s",$expFormat);

         $userToUpdate = DB::table('agents')->where('email',$request->email)->first();
        
         
         if ($userToUpdate) {
                 DB::table('agents')
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
           
             \Mail::to($request->email)->send(new \App\Mail\agentforgotmail($details));
           
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
     
                 $user = DB::table('agents')->where('email',$key)->where('reset_link_token',$token)->first();
                 
                 
              
             $curDate = date("Y-m-d H:i:s");

            if ($user) {
        $curDate = date("Y-m-d H:i:s");

        if($user->exptime >= $curDate) {
             return view('backend/Agent/reset-password');
             

            
        } else {
            return redirect('agent/forgot-password')->with('error', 'This link has expired!!');
        }
    } else {
        return redirect('agent/forgot-password')->with('error', 'Invalid link. Please try again with a valid link.');
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
              
         
     
                 $user = DB::table('agents')->where('email',$key)->where('reset_link_token',$token)->first();
    
              
                 if ($user) {
                     DB::table('agents')->where('email',$key)->where('reset_link_token',$token)->update([
                         
                         'reset_link_token'=>null,
                         'exptime'=>null,
                         'password' =>Hash::make($request->password)
                         ]);
                     
 
            
            Session::forget('key');
            Session::forget('token');
          return redirect('agent/login')->with('success', 'Password Successfully Updated!!');
     } else {
        return back()->with('error', 'Invalid link. Please try again with a valid link.');
     }
     
     
     
     
     
 }
 
 
 
 public function change_password(Request $request){
     
     
         $id = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($id)){
            
            $user = DB::table('agents')->where('email',$id)->first();
            
            return view('backend/Agent/ChangePassword/ChangePassword');
            
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
     
         $id = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($id)){
            
            $user = DB::table('agents')->where('email',$id)->first();
            
            if($user){
                
            if(Hash::check($request->current_password,$user->password)){
                
                DB::table('agents')->where('email',$id)->update([
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
     
    
    
    
      public function viewalltxn(Request $request)
    {
        $id = $request->session()->get('AGENT_EMAIL');
        if(!empty($id)){

            return view('backend/Agent/viewalltxn');
        }else{
            return redirect('agent/login')->with('error','Agent is not authorized');
        }
        
     
    }
     
     
     public function viewalltxnData(Request $request){
         
               $aid = $request->session()->get('AGENT_EMAIL');
        if(!empty($aid)){ 
$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];



                  
$filteredData = wallet_log::viewalltxn($request, $rows, $searchValue, $columnSortOrder, $columnName, $columnIndex, $filltersearchValue, 1);
                      
$agentdatacount = wallet_log::viewalltxn($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);

$i = 1;

$data = array();
foreach ($filteredData as  $row) {
    
 
if($row->payment_status=='1'){
$status = '<span class="badge rounded-pill badge-success">ADDED</span>';
}else{
$status = '<span class="badge rounded-pill badge-danger">DEDUCT</span>';
} 



if($row->wallet_logsRoleId=='1' && $row->wallet_logsUserId=='1'){
  
  $name = 'SuperAdmin';  
}else{
    $name = $row->name; 
}

$data[] = array(
	"id"=> $i++,
	"Name"=> $name,
	"Amount"=> '₹'.$row->amount,
	"Date"=> date('j M Y h:i:s',strtotime($row->wallet_logscreated_at)),
	"Message"=> $row->message,
	"Service"=> $row->service_name,
	"status"=> $status,
	);
}

$query = DB::table('wallet_logs')->orderby('id','DESC');
$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $tot_rows,
"recordsFiltered" => $agentdatacount,
"data" => $data
);


echo json_encode($datas);

 }else{
            return redirect('agent/login')->with('error','Agent is not authorized');
        }

     }
     
     
     
     
    
    
    
    public function moneyrequset(Request $request){
        
             $id = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($id)){
            
        return view('backend/Agent/Wallet/moneyrequset');
        
    }else{
          return redirect('agent/login')->with('error','Agent is not authorized');;
    }}
    
    
    
    
     public function payment_requset_history(Request $request){
        
             $aid = $request->session()->get('AGENT_EMAIL');
        
        if(!empty($aid)){
            
        return view('backend/Agent/Wallet/payment-requset-history');
        
    }else{
          return redirect('agent/login')->with('error','Agent is not authorized');;
    }}
    
    
    

    
    
    function payment_requset_historyajexview(Request $request){
     
$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];


$agentdata = wallet_recharge::agentajexview($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$agentdatacount = wallet_recharge::agentajexview($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);




$i = 1;

$data = array();
foreach ($agentdata as  $row) {
    
$action = '<ul class="action" style="justify-content: space-around;">';
if($row->payment_request_status=='1'){
  $action .= '<li class="delete"><a href="' .route('agent.wallet.transaction-history-data', ['id' => Crypt::encrypt($row->id)]). '"><i class="icon-eye"></i></a></li>';  
}
$action .= '</ul>';
 
if($row->status=='success'){
$status = '<span class="badge rounded-pill badge-success">Success</span>';
}else if($row->status=='pending'){
    $status = '<span class="badge rounded-pill badge-warning">pending</span>';
}else{
$status = '<span class="badge rounded-pill badge-danger">Failed</span>';
} 

$data[] = array(
	"id"=> $i++,
	"oredrid"=>$row->order_id,
	"payment_request_id" =>$row->payment_request_id,
    "transactionID"=>$row->tran_id,
	"Amount"=> '₹'.$row->amount,
	"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
	"status"=> $status,
	"action" => $action,
	);
}
  $aid = $request->session()->get('AGENT_EMAIL');
   $user = DB::table('agents')->where('email',$aid)->first();
if($user){
    $query = DB::table('wallet_recharges')->where('user_id',$user->id)->where('payment_request_id', '!=' ,null)->orderby('id','DESC');
}else{
    $query = DB::table('wallet_recharges')->orderby('id','DESC');
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


}











