<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Requests\StoresuperAdminRequest;
use App\Http\Requests\UpdatesuperAdminRequest;
use App\Models\superAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\bbps_category;
use App\Models\wallet_log;
use App\Models\complain;
use App\Models\system_setting;
use App\Models\script;
use App\Models\news;
use DB;
use Crypt;
use GuzzleHttp\Client;
use App\Models\aepsEnquiry;
use App\Models\aepsWithdrawl;
use App\Models\aepsMiniStatement;
use App\Models\Ministatement;
use App\Models\aepstxnstatus;
use App\Models\AEPSOnboarding;
use App\Models\mobile_recharege_tex;
use App\Models\balance_withdrawl_tax;
use Illuminate\Support\Carbon;
use App\Services\LogService;
class SuperAdminController extends Controller
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
        $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){
            
            $data['totalagent'] = Agent::count();
            $data['totalamount'] = Agent::sum('wallet');
            $admintotalamount['admintotalamount'] = DB::table('ph_super_admins')->first();
            $data['txn'] = wallet_log::limit(5)->orderby('id','DESC')->get();

             
            
            return view('backend/SuperAdmin/index',$data,$admintotalamount);
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
        
     
    }
    
    
    public function system_setting(Request $request){
        
               $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){ 
            
            $data['data'] = system_setting::first();
            
            return view('backend/SuperAdmin/system-setting/system-setting',$data);
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
    
    
        public function system_settingupdate(Request $request,$id){
            
            $settings = system_setting::find($id);
        $settings->site_title = $request->input('site_title');
        $settings->email = $request->input('email');
        $settings->telephone = $request->input('telephone');
        $settings->mobile_number = $request->input('mobile_number');
        $settings->whatsapp_number = $request->input('whatsapp_number');
        $settings->url = $request->input('url');
        $settings->copyright_details = $request->input('copyright_details');
        $settings->address = $request->input('address');
        $settings->map_iframe = $request->input('map_iframe');
        $settings->meta_keywords = $request->input('meta_keywords');
        $settings->meta_description = $request->input('meta_description');
        $settings->short_description = $request->input('short_description');
        $settings->bank_name = $request->input('bank_name');
        $settings->ifsc_code = $request->input('ifsc_code');
        $settings->account_number = $request->input('account_number');
        $settings->account_holder_name = $request->input('account_holder_name');
        $settings->upi_id = $request->input('upi_id');
        $settings->access_token = $request->input('access_token');
        $settings->instance_id = $request->input('instance_id');
        $settings->whatsapp_api_url = $request->input('whatsapp_api_url');
        
        
         if ($request->hasFile('favicon')) {
    $this->deleteImage($settings->favicon, 'backend/uploads/setting');
    $image1 = $request->file('favicon');
    $Extension = $image1->getClientOriginalExtension();
    $favicon =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/setting');
    $image1Path = $destinationPath. "/".  $favicon;
    $image1->move($destinationPath, $favicon);
    $settings->favicon = $favicon;
  }else{
      $settings->favicon = $request->hiddenfavicon;
  }
  
  
         if ($request->hasFile('dark_logo')) {
    $this->deleteImage($settings->dark_logo, 'backend/uploads/setting');
    $image1 = $request->file('dark_logo');
    $Extension = $image1->getClientOriginalExtension();
    $dark_logo =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/setting');
    $image1Path = $destinationPath. "/".  $dark_logo;
    $image1->move($destinationPath, $dark_logo);
    $settings->dark_logo = $dark_logo;
  }else{
      $settings->dark_logo = $request->hiddendark_logo;
  }
  
  
         if ($request->hasFile('white_logo')) {
    $this->deleteImage($settings->white_logo, 'backend/uploads/setting');
    $image1 = $request->file('white_logo');
    $Extension = $image1->getClientOriginalExtension();
    $white_logo =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/setting');
    $image1Path = $destinationPath. "/".  $white_logo;
    $image1->move($destinationPath, $white_logo);
    $settings->white_logo = $white_logo;
  }else{
      $settings->white_logo = $request->hiddenwhite_logo;
  }
  
  
           if ($request->hasFile('barcode_file')) {
    $this->deleteImage($settings->barcode_file, 'backend/uploads/setting');
    $image1 = $request->file('barcode_file');
    $Extension = $image1->getClientOriginalExtension();
    $barcode_file =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/setting');
    $image1Path = $destinationPath. "/".  $barcode_file;
    $image1->move($destinationPath, $barcode_file);
    $settings->barcode_file = $barcode_file;
  }else{
      $settings->barcode_file = $request->hiddenbarcode_file;
  }

   
        $settings->save();
        
        return back()->with('success','Successfully Update');
    }
    
 public function createScipt(Request $request){
     
       $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){ 
            $script['script'] = script::paginate(10);
            return view('backend/SuperAdmin/scripts/create',$script);
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
     
 }
 
  public function scriptstore(Request $request)
    {
        $request->validate([
            'url_name' => 'required|string|max:255|unique:bbps_categories,category',
            'script' => 'required|string',
        ]);

        // Assuming you have a Script model
        $script = new script([
            'ip' => $request->ip(),
            'url_name' => $request->input('url_name'),
            'script' => $request->input('script'),
        ]);

        $script->save();

        return back()->with('success', 'Script inserted successfully.');
    }
    
    
     
  public function scriptupdate(Request $request,$id)
    {

        $aid = $request->session()->get('SUPERADMIN_ID');
        if(!empty($aid)){ 
        $script = script::find($id);
            $script->ip = $request->ip();
            $script->url_name = $request->input('url_name');
            $script->script = $request->input('script');
     

        $script->update();

        return back()->with('success', 'Script Update successfully.');
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
    
    
     public function deleteScipt(Request $request,$id){
     
       $aid = $request->session()->get('SUPERADMIN_ID');
        if(!empty($aid)){ 
            $script = script::find($id);
            
            $script->delete();
            
            return back()->with('error', 'Script Delete successfully.');
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
     
 }
         public function settings(Request $request){
     
       $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){ 
           
           return view('backend/SuperAdmin/settings');
           
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
     
 }
 
 
 public function createBillCategory(Request $request){
     
      $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){ 
            $cate['cate'] = bbps_category::paginate(4);
            return view('backend/SuperAdmin/BillCategory/create',$cate);
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
     
 }
 
   public function bbpsCategorystore(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255|unique:bbps_categories,category',
            'image' => 'required',
        ]);
        
        $cate = new bbps_category;
        $cate->category = $request->category;
        $cate->ip = $request->ip();

if ($request->hasFile('image')) {
    $image1 = $request->file('image');
    $Extension = $image1->getClientOriginalExtension();
    $image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/BbpsCategory');
    $image1Path = $destinationPath. "/".  $image;
    $image1->move($destinationPath, $image);
     $cate->image = $image;
  }
       

        $cate->save();

        return back()->with('success', 'BBps Category inserted successfully.');
    }
    
    
    
       public function bbpsCategorytupdate(Request $request,$id)
    {
        $did = Crypt::decrypt($id);
        
        $request->validate([
            'category' => 'required|string|max:255,'.$did,
            'image' => 'required',
        ]);
        
        $cate = bbps_category::find($did);
        $cate->category = $request->category;
        $cate->ip = $request->ip();

if ($request->hasFile('image')) {
    $image1 = $request->file('image');
    $Extension = $image1->getClientOriginalExtension();
    $image =uniqid() . '_' . time(). '.' .$Extension;
    $destinationPath = public_path('backend/uploads/BbpsCategory');
    $image1Path = $destinationPath. "/".  $image;
    $image1->move($destinationPath, $image);
     $cate->image = $image;
  }else{
      
       $cate->image = $request->image;
  }
       

        $cate->save();

        return back()->with('success', 'BBps Category Updated successfully.');
    }
 
 
    
     public function deletebbpsCategory(Request $request,$id){
     
       $aid = $request->session()->get('SUPERADMIN_ID');
       
       
       $did = Crypt::decrypt($id);
        if(!empty($aid)){ 
            $script = bbps_category::find($did);
            
            $script->delete();
            
            return back()->with('error', 'BbpsCategory Delete successfully.');
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
     
 
     }   
     
     
    public function complaintRegister(Request $request)
{
   $data = $request->all();

// print_r($data);
// die;

    try {
        $complain = complain::insert($data); 

        return response()->json([
            'success' => true,
            'message' => 'Complaint registered successfully',
            'data' => $complain
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to register complaint',
            'error' => $e->getMessage()
        ], 500);
    }
}
 
     
         public function viewalltxn(Request $request)
    {
        $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){

            return view('backend/SuperAdmin/viewalltxn');
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
        
     
    }
     
     
     public function viewalltxnData(Request $request){
         
               $aid = $request->session()->get('SUPERADMIN_ID');
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
$status = '<span class="badge rounded-pill badge-success">Success</span>';
}elseif($row->payment_status=='2'){
$status = '<span class="badge rounded-pill badge-warning">Success</span>';
}else{
$status = '<span class="badge rounded-pill badge-danger">Failed</span>';
} 



if($row->wallet_logsRoleId=='1' && $row->wallet_logsUserId=='1'){
  
  $name = 'SuperAdmin';  
}else{
    $name = $row->name; 
}

$data[] = array(
	"id"=> $i++,
	"Name"=> $name,
	"Agent_id"=> $row->Agent_id,
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
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }

     }
     
     
    
function Wihdrawhistory(Request $request){
          $id = $request->session()->get('SUPERADMIN_ID');

  if (!empty($id)) {
      
      return view('backend/SuperAdmin/Wihdrawhistory');
      
  } else {
        return redirect('superadmin/login')->with('error', 'Superadmin is not authorized');
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
$userdata = Agent::where('id',$row->user_id)->first();

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
"AgentID"=>$row->submerchantid,
"Name"=>$row->name,
"referenceno"=>$row->referenceno,
"adhaarnumber"=>$row->adhaarnumber,
"Amount"=> '₹'.$row->txn_amount,
"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
"Receipt"=> $Receipt,
"status"=> $status,
);
}

$query = DB::table('aeps_withdrawls')->orderby('id','DESC');


$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $tot_rows,
"recordsFiltered" => $Withdrawaldatacount,
"data" => $data
);


echo json_encode($datas);

}



 private function viewmobilerechargeHistoryajex($request, $draw, $searchValue, $columnSortOrder, $columnName, $columnIndex, $filltersearchValue, $rowcount) {
    $start = $draw;

    $query = DB::table('recharges');

    

    if ($searchValue) {
        $query->where(function ($q) use ($searchValue) {
            $q->where('refid', 'like', '%' . $searchValue . '%')
              ->orWhere('amount', 'like', '%' . $searchValue . '%')
              ->orWhere('mobile', 'like', '%' . $searchValue . '%')
              ->orWhere('created_at', 'like', '%' . $searchValue . '%');
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

function mobilerechargeHistory(Request $request){
          $id = $request->session()->get('SUPERADMIN_ID');

  if (!empty($id)) {
      
      return view('backend/SuperAdmin/mobilerechargeHistory');
      
  } else {
        return redirect('superadmin/login')->with('error', 'Superadmin is not authorized');
    }
}

function viewmobilerechargeHistory(Request $request){

$globalData = system_setting::first();

$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];


$rechargedata =$this->viewmobilerechargeHistoryajex($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$Withdrawaldatacount = $this->viewmobilerechargeHistoryajex($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);





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
$id = $row->user_id;
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
"agentdata" => getUsernameByAgentId($userdata->agent_id) . '(<span style="color:red;">' . $userdata->agent_id . '</span>)',
"referenceno"=>$row->refid,
"Amount"=> '₹'.$row->amount,
"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
"Mobile"=> $row->mobile,
"Receipt"=> $Receipt,
"Message"=> $row->message,
"status"=> $status,
);
}

$query = DB::table('recharges')->orderby('id','DESC');


$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $tot_rows,
"recordsFiltered" => $Withdrawaldatacount,
"data" => $data
);


echo json_encode($datas);

}


public function txnstatus(Request $request){
         $id = $request->session()->get('SUPERADMIN_ID');

        if(!empty($id)){

$userRole = "1";
$userIp = $request->ip();
$activity = '32';
$weburl = $_SERVER['REQUEST_URI'];
LogService::logs($activity,$weburl,$id,$userRole,$userIp);

        return view('backend/SuperAdmin/txnstatus');
    }else{
    return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    
}
public function aepstxnstatus(Request $request){
    
    $request->validate([
        
        'reference_number' =>'required'
        ]);
    
        $id = $request->session()->get('SUPERADMIN_ID');

        if(!empty($id)){


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
            'user_role' => '1',
            'user_id' => $id,
            ]);
   
  
$services_id = '6';
$userRole = "1";
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
    return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    
}


function blanceenqueryhistory(Request $request){
          $id = $request->session()->get('SUPERADMIN_ID');

  if (!empty($id)) {
      
      return view('backend/SuperAdmin/blanceenqueryhistory');
      
  } else {
        return redirect('superadmin/login')->with('error', 'Superadmin is not authorized');
    }
} 
    
    
    function viewblanceenqueryhistory(Request $request){

$globalData = system_setting::first();

$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];


$Withdrawaldata = aepsEnquiry::viewblanceenqueryhistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$Withdrawaldatacount = aepsEnquiry::viewblanceenqueryhistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);





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
$userdata = Agent::where('id',$row->user_id)->first();

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
"AgentID"=>$row->submerchantid,
"referenceno"=>$row->referenceno,
"adhaarnumber"=>$row->adhaarnumber,
"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
"Receipt"=> $Receipt,
"status"=> $status,
);
}

$query = DB::table('aeps_withdrawls')->orderby('id','DESC');


$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $tot_rows,
"recordsFiltered" => $Withdrawaldatacount,
"data" => $data
);


echo json_encode($datas);

} 


function ministatementhistory(Request $request){
          $id = $request->session()->get('SUPERADMIN_ID');

  if (!empty($id)) {
      
      return view('backend/SuperAdmin/ministatementhistory');
      
  } else {
        return redirect('superadmin/login')->with('error', 'Superadmin is not authorized');
    }
} 
    
    
    function viewministatementhistory(Request $request){

$globalData = system_setting::first();

$draw= $request->draw;
$rows = $request->start;
$columnIndex = $request->order[0]['column'];
$columnName = $request->columns[$columnIndex]['data'];
$columnSortOrder = $request->order[0]['dir'];
$filltersearchValue = $request->columns[$columnIndex]['search']['value'];
$searchValue = $request->search['value'];


$Withdrawaldata = aepsMiniStatement::viewministatementhistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$Withdrawaldatacount = aepsMiniStatement::viewministatementhistory($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);





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
$userdata = Agent::where('id',$row->user_id)->first();

 $timestamp = Carbon::parse($row->timestamp);

        $formattedDate = $timestamp->format('j M Y');
        $formattedTime = $timestamp->format('H:i:s');
        
        
        $responseDatapdf = Ministatement::where('MiniStatement_id',$row->id)->get()->toArray();

        
         $Receiptdata = '';
        foreach ($responseDatapdf as $transaction){
            
          $Receiptdata .='<tr>
                    <td style="border: 1px solid #3a3737; padding: 0.5rem;">'.$transaction['date'].'</td>
                    <td style="border: 1px solid #3a3737; padding: 0.5rem;">'. $transaction['narration'] .'</td>
                    <td style="border: 1px solid #3a3737; padding: 0.5rem;">'. $transaction['txnType'] .'</td>
                    <td style="border: 1px solid #3a3737; padding: 0.5rem;">'. $transaction['amount'] .'</td>
                    
                </tr>';
        }
			

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
          <td style="border: 1px solid #3a3737; padding: 8px; color: #000e14; font-size: 16px;">Account Balance:</td>
          <td colspan="3" style="border: 1px solid #3a3737; padding: 8px; color: #000; font-size: 16px; font-weight: 600;">'.$row->balanceamount.'</td>
        </tr>
    </tbody>
  </table>
  
 <table style="border-collapse: collapse; width: 100%; border: 1px solid #3a3737;">
		<thead>
			<tr>
				<th style="border: 1px solid #3a3737; font-size: 18px; background-color: #f8f9fa; padding: 0.5rem;">date </th>
				<th style="border: 1px solid #3a3737; font-size: 18px; background-color: #f8f9fa; padding: 0.5rem;">descr </th>
				<th style="border: 1px solid #3a3737; font-size: 18px; background-color: #f8f9fa; padding: 0.5rem;">txntype </th>
				<th style="border: 1px solid #3a3737; font-size: 18px; background-color: #f8f9fa; padding: 0.5rem;">amount </th>
			</tr>
		</thead>
		<tbody>
		'.$Receiptdata.'
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
"AgentID"=>$row->submerchantid,
"referenceno"=>$row->referenceno,
"adhaarnumber"=>$row->adhaarnumber,
"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
"Receipt"=> $Receipt,
"status"=> $status,
);
}

$query = DB::table('aeps_withdrawls')->orderby('id','DESC');


$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $tot_rows,
"recordsFiltered" => $Withdrawaldatacount,
"data" => $data
);


echo json_encode($datas);

} 




    public function balancewithdrawltax(Request $request){
        
               $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){ 
        $charges = balance_withdrawl_tax::get();
            return view('backend/SuperAdmin/balancewithdrawltax',compact('charges'));
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
    
    
     public function updatebalancewithdrawltax(Request $request)
    {
        $data = $request->all();
        
        foreach ($data['charges'] as $chargeData) {
            if (isset($chargeData['id']) && $chargeData['id']) {
              
                $charge = balance_withdrawl_tax::find($chargeData['id']);
                if ($charge) {
                    $charge->start_price = $chargeData['start_price'];
                    $charge->last_price = $chargeData['last_price'];
                    $charge->commission = $chargeData['commission'];
                    $charge->tax = $chargeData['tax'];
                    $charge->save();
                }
            } else {
           
                balance_withdrawl_tax::create([
                    'start_price' => $chargeData['start_price'],
                    'last_price' => $chargeData['last_price'],
                    'commission' => $chargeData['commission'],
                    'tax' => $chargeData['tax'],
                ]);
            }
        }


     if (isset($data['deleted_ids']) && !empty($data['deleted_ids'])) {
            $deletedIds = explode(',', $data['deleted_ids']);
            balance_withdrawl_tax::destroy($deletedIds);
        }

        return back()->with('success', 'Charges updated successfully!');
    }
   

 

    public function mobilerecharegetexes(Request $request){
        
               $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){ 
        $charges = mobile_recharege_tex::first();
            return view('backend/SuperAdmin/mobilerecharegetexes',compact('charges'));
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }



    public function updatemobilerecharegetexes(Request $request,$uid){
        
        $data = $request->all();
               $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){ 
       mobile_recharege_tex::find($uid)->update($data);
       return back()->with('success', 'Charges updated successfully!');
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
    
    /****************************************************************************************************************************************/
    
    
    
     public function createnews(Request $request){
     
       $id = $request->session()->get('SUPERADMIN_ID');
        if(!empty($id)){ 
            $news['news'] = news::paginate(10);
            return view('backend/SuperAdmin/news/create',$news);
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
     
 }
 
  public function newsstore(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
        ]);

        
        $script = new news([
            'title' => $request->input('title'),
        ]);

        $script->save();

        return back()->with('success', 'News inserted successfully.');
    }
    
    
     
  public function newsupdate(Request $request,$id)
    {

        $aid = $request->session()->get('SUPERADMIN_ID');
        if(!empty($aid)){ 
        $news = news::find($id);
            $news->title = $request->input('title');
     

        $news->update();

        return back()->with('success', 'News Update successfully.');
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
    
    
     public function deletenews(Request $request,$id){
     
       $aid = $request->session()->get('SUPERADMIN_ID');
        if(!empty($aid)){ 
            $news = news::find($id);
            
            $news->delete();
            
            return back()->with('error', 'News Delete successfully.');
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
     
 }
 
 
 
 
      public function pipe(Request $request){
     
       $aid = $request->session()->get('SUPERADMIN_ID');
        if(!empty($aid)){ 
           
           $pipe =AEPSOnboarding::join('agents','agents.id','=','a_e_p_s_onboardings.user_id')->where('onboard_pending','1')
           ->select('agents.name as agentname','a_e_p_s_onboardings.*','agents.id as agentid','agents.agent_id')
           ->OrderBy('a_e_p_s_onboardings.id','Desc')
           ->get();
           
           return view('backend/SuperAdmin/pipe',compact('pipe'));
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
     
 }
 
 
public function updatepipe(Request $request)
{
    
    
    $request->validate([
        
        'pipe' => 'required',
        'agent' => 'required'
        
        ]);
    $aid = $request->session()->get('SUPERADMIN_ID');
    
    if (!empty($aid)) { 
    
        $userid = $request->agent;
        
      
        $bank2 = $request->pipe == 'Bank2' ? '1' : '0';
        $bank3 = $request->pipe == 'Bank3' ? '1' : '0';

 
        AEPSOnboarding::where('user_id', $userid)->update([
            'Bank2' => $bank2,
            'Bank3' => $bank3
        ]);


        return back()->with('success','Pipe Successfully Updated');
    } else {

        return redirect('superadmin/login')->with('error', 'Superadmin is not authorized');
    }
}

      public function ticket(Request $request){
     
       $aid = $request->session()->get('SUPERADMIN_ID');
        if(!empty($aid)){ 
           
           $ticket =complain::OrderBy('id','Desc')->get();
           
           return view('backend/SuperAdmin/ticket',compact('ticket'));
        }else{
            return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
     
 }
 
 

}
