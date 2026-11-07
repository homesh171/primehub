<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Models\Agent;
use App\Models\agentpermissions;
use App\Models\AgentPayoutCharges;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\LogService;
use App\Models\payout_beneficiaries_add;
use App\Models\payout_charges;
use App\Mail\agentadpasssend;
use Hash;
use session;
use Crypt;

class AgentauthController extends Controller
{
  
      private function deleteImage($filename, $path)
    {
        $filePath = public_path($path . '/' . $filename);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
  
    public function index(Request $request)
    {
        $id = $request->session()->get('SUPERADMIN_EMAIL');
        if(!empty($id)){
        return view('backend/SuperAdmin/Agent/index');
        }else{
          return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
  
    public function create(Request $request)
    {
            $id = $request->session()->get('SUPERADMIN_EMAIL');
        
        if(!empty($id)){
         $data = DB::table('tbl_countries')->get();
         
       return view('backend/SuperAdmin/Agent/create',['country'=>$data]);
        }else{
               return redirect('superadmin/login')->with('error','Superadmin is not authorized');
         }
    }
    
    
 public function getStates(Request $request)
    {
        $countryId = $request->input('country_id');

  
        $states =DB::table('tbl_states')->where('country_id', $countryId)->get();

        return response()->json($states);
    }

    public function getCities(Request $request)
    {
        $stateId = $request->input('state_id');

       
        $cities = DB::table('tbl_cities')->where('state_id', $stateId)->get();

        return response()->json($cities);
    }
    
    

    public function store(Request $request)
    {
        
          $id = $request->session()->get('SUPERADMIN_EMAIL');
        
        if(!empty($id)){
      $request->validate([
            
            'name' => 'required',
            'mobile_number' => 'required|unique:agents,mobile_number',
            'email' => 'required|unique:agents,email',
            'whatsapp_number' => 'required|unique:agents,whatsapp_number',
            'country' => 'required',
            'address' => 'required',
            'shop_photo' => 'required',
            'shop_name' => 'required',
            'pan_card_image' => 'required|file|mimes:jpeg,png',
            'pan_number' => 'required|unique:agents,pan_number',
            'aadhar_back_image' => 'required|file|mimes:jpeg,png',
            'aadhar_front_image' => 'required|file|mimes:jpeg,png',
            'agent_pin' => 'required',
            'age' => 'required',
            'password' => 'required|min:6',
            'state' => 'required',
            'pincode' => 'required',
            'city' => 'required',
            'aadhar_number' => 'required|unique:agents,aadhar_number|min:12|max:12',
            'username' => 'required|unique:agents,username',
            'profile_image' => 'required|file|mimes:jpeg,png',
            'upi_id' => 'required',
            'ac_holder_name' => 'required',
            'ifsc_code' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',
            
            ]);
            
            $agent = new Agent;
            $agent->name = $request->name;
            $agent->email = $request->email;
            $agent->mobile_number = $request->mobile_number;
            $agent->whatsapp_number = $request->whatsapp_number;
            $agent->country = $request->country;
            $agent->address = $request->address;
            $agent->shop_name = $request->shop_name;
            $agent->pan_number = $request->pan_number;
            $agent->agent_pin = $request->agent_pin;
            $agent->age = $request->age;
            $agent->password = Hash::make($request->password);
            $agent->state = $request->state;
            $agent->pincode = $request->pincode;
            $agent->city = $request->city;
            $agent->aadhar_number = $request->aadhar_number;
            $agent->upi_id = $request->upi_id;
            $agent->ac_holder_name = $request->ac_holder_name;
            $agent->ifsc_code = $request->ifsc_code;
            $agent->account_number = $request->account_number;
            $agent->bank_name = $request->bank_name;
            $agent->username = $request->username;
            
            
    if ($request->hasFile('pan_card_image')) {
    $image1 = $request->file('pan_card_image');
    $Extension = $image1->getClientOriginalExtension();
    $pan_card_image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/Agent/PanCardImage');
    $image1Path = $destinationPath. "/".  $pan_card_image;
    $image1->move($destinationPath, $pan_card_image);
    $agent->pan_card_image = $pan_card_image;
  }
  
  
      if ($request->hasFile('profile_image')) {
    $image1 = $request->file('profile_image');
    $Extension = $image1->getClientOriginalExtension();
    $profile_image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/Agent/ProfileImage');
    $image1Path = $destinationPath. "/".  $profile_image;
    $image1->move($destinationPath, $profile_image);
    $agent->profile_image = $profile_image;
  }
  
  
    if ($request->hasFile('aadhar_back_image')) {
    $image1 = $request->file('aadhar_back_image');
    $Extension = $image1->getClientOriginalExtension();
    $aadhar_back_image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/Agent/AadharBackImage');
    $image1Path = $destinationPath. "/".  $aadhar_back_image;
    $image1->move($destinationPath, $aadhar_back_image);
    $agent->aadhar_back_image = $aadhar_back_image;
  }
  
  
    if ($request->hasFile('aadhar_front_image')) {
    $image1 = $request->file('aadhar_front_image');
    $Extension = $image1->getClientOriginalExtension();
    $aadhar_front_image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/Agent/AadharFrontImage');
    $image1Path = $destinationPath. "/".  $aadhar_front_image;
    $image1->move($destinationPath, $aadhar_front_image);
    $agent->aadhar_front_image = $aadhar_front_image;
  }
  
  
   if($request->hasfile('shop_photo'))
             {
                foreach($request->file('shop_photo') as $file)
                {
                     $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
                     $path = public_path() . '/backend/uploads/Agent/ShopImages';
                     $file->move($path, $name);
                     $Imgdata[] = $name;
                }
                $agent->shop_photo = json_encode($Imgdata);
             }
  
            
            $agent->save();
    $agent->agent_id = 'PH' . str_pad($agent->id, 6, '0', STR_PAD_LEFT);
    $agent->save();
    
    
    
    if($agent ==true){
        
        new agentpermissions([
            'user_id'=>$agent->id
            ]);
            
            
                $details = [
        
        'email'=>$request->email,
        'password'=>$request->password,
        
        ];
    
    
    \Mail::to($request->email)->send(new \App\Mail\agentadpasssend($details));
    }
    
    
  $parminssion =   DB::table('agentpermissions')->insert([
      
      'user_id' =>$agent->id,
      'role' =>'2',
      'ip' =>$request->ip()
      ]);
    
    
 $email = $request->session()->get('SUPERADMIN_EMAIL');  
$admin = DB::table('ph_super_admins')->where('email', $email)->first();
$userRole = "1";
$userIp = $request->ip();
$userid = $admin->id;
$activity = 'Store';
$weburl = $_SERVER['REQUEST_URI'];

LogService::logs($activity,$weburl,$userid,$userRole,$userIp);



    
return redirect('superadmin/agent/index')->with('success','Agent Successfully Created');
}else{
               return redirect('superadmin/login')->with('error','Superadmin is not authorized');
         }
    }
    
    
    


    /**
     * Display the specified resource.
     */
    public function show(Request $request,$id)
    {
  $ids = $request->session()->get('SUPERADMIN_EMAIL');
     $did = Crypt::decrypt($id);
        
        if(!empty($ids)){
        $agents['data'] = DB::table('agents')
    ->join('tbl_countries', 'agents.country', '=', 'tbl_countries.id')
    ->join('tbl_cities', 'agents.city', '=', 'tbl_cities.id')
    ->join('tbl_states', 'agents.state', '=', 'tbl_states.id')
    ->select('agents.*', 'tbl_countries.name as country_name', 'tbl_cities.name as city_name', 'tbl_states.name as state_name')
    ->where('agents.id', $did)
    ->first();
    
    
 
      
        
        
$email = $request->session()->get('SUPERADMIN_EMAIL');  
$admin = DB::table('ph_super_admins')->where('email', $email)->first();
$userRole = "1";
$userIp = $request->ip();
$userid = $admin->id;
$activity = 'Show';
$weburl = $_SERVER['REQUEST_URI'];

LogService::logs($activity,$weburl,$userid,$userRole,$userIp);

  return view('backend/SuperAdmin/Agent/show',$agents);
        }else{
               return redirect('superadmin/login')->with('error','Superadmin is not authorized');
         }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
          $ids = $request->session()->get('SUPERADMIN_EMAIL');
        
        $did = Crypt::decrypt($id);
        
        if(!empty($ids)){
        $country['country'] = DB::table('tbl_countries')->get();
        $data['data'] = Agent::where('id',$did)->first();
        $data['statedata'] = DB::table('tbl_states')->where('country_id',$data['data']->country)->get();
        $data['citydata'] = DB::table('tbl_cities')->where('state_id',$data['data']->state)->get();
      
$email = $request->session()->get('SUPERADMIN_EMAIL');  
$admin = DB::table('ph_super_admins')->where('email', $email)->first();
$userRole = "1";
$userIp = $request->ip();
$userid = $admin->id;
$activity = 'Edit';
$weburl = $_SERVER['REQUEST_URI'];

LogService::logs($activity,$weburl,$userid,$userRole,$userIp);
return view('backend/SuperAdmin/Agent/edit',$country,$data);
        
        }else{
               return redirect('superadmin/login')->with('error','Superadmin is not authorized');
         }
    }


    public function update(Request $request,$id)
    {
          $aid = $request->session()->get('SUPERADMIN_EMAIL');
          
             $did = Crypt::decrypt($id);
        
        if(!empty($aid)){
        $request->validate([
    'name' => 'required',
    'mobile_number' => 'required|unique:agents,mobile_number,' . $did,
    'email' => 'required|unique:agents,email,' . $did,
    'whatsapp_number' => 'required|unique:agents,whatsapp_number,' . $did,
    'country' => 'required',
    'address' => 'required',
    'shop_name' => 'required',
    'pan_card_image' => 'file|mimes:jpeg,png',
    'pan_number' => 'required|unique:agents,pan_number,' . $did,
    'aadhar_back_image' => 'file|mimes:jpeg,png',
    'aadhar_front_image' => 'file|mimes:jpeg,png',
    'age' => 'required',
    'state' => 'required',
    'pincode' => 'required',
    'city' => 'required',
    'aadhar_number' => 'required|unique:agents,aadhar_number,' . $did,
    'username' => 'required|unique:agents,username,' . $did,
    'profile_image' => 'file|mimes:jpeg,png',
    'upi_id' => 'required',
    'ac_holder_name' => 'required',
    'ifsc_code' => 'required',
    'account_number' => 'required',
    'bank_name' => 'required',
]);


            
            $agent = Agent::find($did);
            $agent->name = $request->name;
            $agent->email = $request->email;
            $agent->mobile_number = $request->mobile_number;
            $agent->whatsapp_number = $request->whatsapp_number;
            $agent->country = $request->country;
            $agent->address = $request->address;
            $agent->shop_name = $request->shop_name;
            $agent->pan_number = $request->pan_number;
            $agent->age = $request->age;
            $agent->state = $request->state;
            $agent->pincode = $request->pincode;
            $agent->city = $request->city;
            $agent->aadhar_number = $request->aadhar_number;
            $agent->username = $request->username;
            $agent->upi_id = $request->upi_id;
            $agent->ac_holder_name = $request->ac_holder_name;
            $agent->ifsc_code = $request->ifsc_code;
            $agent->account_number = $request->account_number;
            $agent->bank_name = $request->bank_name;
            
    if ($request->hasFile('pan_card_image')) {
    $this->deleteImage($agent->pan_card_image, 'backend/uploads/Agent/PanCardImage');
    $image1 = $request->file('pan_card_image');
    $Extension = $image1->getClientOriginalExtension();
    $pan_card_image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/Agent/PanCardImage');
    $image1Path = $destinationPath. "/".  $pan_card_image;
    $image1->move($destinationPath, $pan_card_image);
    $agent->pan_card_image = $pan_card_image;
  }else{
      $agent->pan_card_image = $request->hiddenpan_card_image;
  }
  
  
      if ($request->hasFile('profile_image')) {
    $this->deleteImage($agent->profile_image, 'backend/uploads/Agent/ProfileImage');
    $image1 = $request->file('profile_image');
    $Extension = $image1->getClientOriginalExtension();
    $profile_image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/Agent/ProfileImage');
    $image1Path = $destinationPath. "/".  $profile_image;
    $image1->move($destinationPath, $profile_image);
    $agent->profile_image = $profile_image;
  }else{
      $agent->profile_image = $request->hiddenprofile_image;
  }
  
  
    if ($request->hasFile('aadhar_back_image')) {
    $this->deleteImage($agent->aadhar_back_image, 'backend/uploads/Agent/AadharBackImage');
    $image1 = $request->file('aadhar_back_image');
    $Extension = $image1->getClientOriginalExtension();
    $aadhar_back_image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/Agent/AadharBackImage');
    $image1Path = $destinationPath. "/".  $aadhar_back_image;
    $image1->move($destinationPath, $aadhar_back_image);
    $agent->aadhar_back_image = $aadhar_back_image;
  }else{
      $agent->aadhar_back_image = $request->hiddenaadhar_back_image;
  }
  
  
    if ($request->hasFile('aadhar_front_image')) {
    $this->deleteImage($agent->aadhar_front_image, 'backend/uploads/Agent/AadharFrontImage');
    $image1 = $request->file('aadhar_front_image');
    $Extension = $image1->getClientOriginalExtension();
    $aadhar_front_image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/Agent/AadharFrontImage');
    $image1Path = $destinationPath. "/".  $aadhar_front_image;
    $image1->move($destinationPath, $aadhar_front_image);
    $agent->aadhar_front_image = $aadhar_front_image;
  }
  else{
      $agent->aadhar_front_image = $request->hiddenaadhar_front_image;
  }
  
   if($request->hasfile('shop_photo'))
             {
                 
                 $previousShopPhotos = json_decode($agent->shop_photo, true);
        foreach ($previousShopPhotos as $previousShopPhoto) {
            $this->deleteImage($previousShopPhoto, 'backend/uploads/Agent/ShopImages');
        }
                 
                foreach($request->file('shop_photo') as $file)
                {    
                    
                     $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
                     $path = public_path() . '/backend/uploads/Agent/ShopImages';
                     $file->move($path, $name);
                     $Imgdata[] = $name;
                }
                $agent->shop_photo = json_encode($Imgdata);
             }else{
      $agent->shop_photo = $request->hiddenshop_photo;
  }
  
            
            $agent->save();
            
            
             $email = $request->session()->get('SUPERADMIN_EMAIL');  
$admin = DB::table('ph_super_admins')->where('email', $email)->first();
$userRole = "1";
$userIp = $request->ip();
$userid = $admin->id;
$activity = 'Update';
$weburl = $_SERVER['REQUEST_URI'];

LogService::logs($activity,$weburl,$userid,$userRole,$userIp);
            
            
            return redirect('superadmin/agent/index')->with('info','Agent Successfully Updated');
        }else{
               return redirect('superadmin/login')->with('error','Superadmin is not authorized');
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function permissions(Request $request,$id)
    {   $aid = $request->session()->get('SUPERADMIN_EMAIL');
           $did = Crypt::decrypt($id);
        if(!empty($aid)){
            
        $data = agentpermissions::where('user_id', $did)->first();
        $payoutcharges = payout_charges::where('agent_id', $did)->get();
        $charges = AgentPayoutCharges::where('agent_id', $did)->get();
        $agent_id = $did;

        return view('backend/SuperAdmin/Agent/permissions',compact('data','charges','agent_id','payoutcharges'));
        
       } else{
               return redirect('superadmin/login')->with('error','Superadmin is not authorized');
         }
        
    }
    


    public function updatepermissions(Request $request)
    {   $aid = $request->session()->get('SUPERADMIN_EMAIL');
        
        if(!empty($aid)){
            
         $agentpermissions = agentpermissions::find($request->id);
         $agentpermissions->wallet_limit = $request->wallet_limit;
         $agentpermissions->wallet_status = $request->wallet_status;
         $agentpermissions->wallet_load_type = $request->wallet_load_type;
         $agentpermissions->wallet_load_charge = $request->wallet_load_charge;
         $agentpermissions->payout_limit = $request->payout_limit;
         $agentpermissions->default_payout_changes = $request->default_payout_changes;
         $agentpermissions->payout_type = $request->payout_type;
         
         $agentpermissions->update();
         
        return redirect('superadmin/agent/index')->with('success','Permission Successfully updated');
        
       } else{
               return redirect('superadmin/login')->with('error','Superadmin is not authorized');
         }
        
    }
    
    
    
    public function agentdmtchrageupdate(Request $request,$id)
    {
        $agent_id = Crypt::decrypt($id);
        $data = $request->all();
        
        foreach ($data['charges'] as $chargeData) {
            if (isset($chargeData['id']) && $chargeData['id']) {
              
                $charge = AgentPayoutCharges::find($chargeData['id']);
                if ($charge) {
                    $charge->start_price = $chargeData['start_price'];
                    $charge->last_price = $chargeData['last_price'];
                    $charge->charges_amount = $chargeData['charges_amount'];
                    $charge->save();
                }
            } else {
           
                AgentPayoutCharges::create([
                    'agent_id' => $agent_id,
                    'start_price' => $chargeData['start_price'],
                    'last_price' => $chargeData['last_price'],
                    'charges_amount' => $chargeData['charges_amount'],
                ]);
            }
        }


     if (isset($data['deleted_ids']) && !empty($data['deleted_ids'])) {
            $deletedIds = explode(',', $data['deleted_ids']);
            AgentPayoutCharges::destroy($deletedIds);
        }

        return back()->with('success', 'Charges updated successfully!');
    }
    
    
    
    
        
    public function agentpayouttchrageupdate(Request $request,$id)
    {
        $agent_id = Crypt::decrypt($id);
        $data = $request->all();
        
        foreach ($data['payoutcharges'] as $chargeData) {
            if (isset($chargeData['id']) && $chargeData['id']) {
              
                $charge = payout_charges::find($chargeData['id']);
                if ($charge) {
                    $charge->start_price = $chargeData['start_price'];
                    $charge->last_price = $chargeData['last_price'];
                    $charge->charges_amount = $chargeData['charges_amount'];
                    $charge->save();
                }
            } else {
           
                payout_charges::create([
                    'agent_id' => $agent_id,
                    'start_price' => $chargeData['start_price'],
                    'last_price' => $chargeData['last_price'],
                    'charges_amount' => $chargeData['charges_amount'],
                ]);
            }
        }


     if (isset($data['deleted_ids']) && !empty($data['deleted_ids'])) {
            $deletedIds = explode(',', $data['deleted_ids']);
            payout_charges::destroy($deletedIds);
        }

        return back()->with('success', 'Charges updated successfully!');
    }
    
    
function agentajexview(Request $request){
     
$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];


$agentdata = Agent::agentajexview($rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$agentdatacount = Agent::agentajexview($rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);

$i = 1;

$data = array();
foreach ($agentdata as $row) {
    
$action = '<ul class="action" style="justify-content: space-around;">';
$action .= '<li class="edit"><a href="' . route('superadmin.agent.edit', ['id' => Crypt::encrypt($row->id)]) . '"><i class="icon-pencil-alt"></i></a></li>';
$action .= '<li class="delete"><a href="' . route('superadmin.agent.show', ['id' => Crypt::encrypt($row->id)]) . '"><i class="icon-eye"></i></a></li>';
$action .= '<li class="delete"><a href="' . route('superadmin.agent.permissions', ['id' => Crypt::encrypt($row->id)]) . '"><i class="fa fa-spin fa-cog"></i></a></li>';
$action .= '</ul>';


$status = ' <label class="switch m5">
      <input type="checkbox" data-id="' . $row->id . '" name="kyc_status" class="js-switch" ' . ($row->kyc_status == 0 ? 'checked' : '1') . '>
      <small></small>
    </label>';

$data[] = array(
	"id"=> $i++,
	"agentid"=>$row->agent_id,
    "name"=>$row->name,
	"email"=> $row->email,
	"mobile"=> $row->mobile_number,
    "wallet"=> '₹'.$row->wallet,
	"status"=> $status,
	"action" => $action,
	);
}

$query = DB::table('agents')->orderby('id','DESC');
$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $tot_rows,
"recordsFiltered" => $agentdatacount,
"data" => $data
);


echo json_encode($datas);

}
    

public function updateUserStatus(Request $request)
{
    
    $user = Agent::findorfail($request->id);
    $user->kyc_status = $request->kyc_status;
    $user->save();

    return response()->json(['message' => 'Agent status updated successfully.']);
}



function addAgentbeneficiariesaccount(Request $request){
    


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
	'vpa' =>  $request->vpa,
	"allowed_payment_types" => array(1,2,3,4),
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
// print_r($responseObject);
// die;

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
Agent::where('id',$request->id)->update(['beneficiary_id'=>$databeni['id']]);

return back()->with('success','Beneficiaries Successfully Add');

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


// print_r($databeni);
// die;

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
Agent::where('id',$request->id)->update(['beneficiary_id'=>$databeni['id']]);
}else{
DB::table('payout_beneficiaries_adds')->insert($data);    
}

return back()->with('success','Beneficiaries Successfully Add');

}else{
 
    return back()->with('success','Invalid Account Number And IFSC Code');
}    

}






}
