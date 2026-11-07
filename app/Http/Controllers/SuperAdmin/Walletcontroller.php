<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\wallet_recharge;
use App\Models\Agent;
use Crypt;

class Walletcontroller extends Controller
{
    
    
    function addmoney(Request $request){
        
             $id = $request->session()->get('SUPERADMIN_EMAIL');
        
        if(!empty($id)){
            
       $data['paymentmode'] = DB::table('paymentmodes')->where('status','1')->get();
        return view('backend/SuperAdmin/Wallet/addmoney',$data);
        
    }else{
        return redirect('superadmin/login')->with('error','Superadmin is not authorized');
    }}
    
    
        public function addmoneytoagent(Request $request)
    {
             $id = $request->session()->get('SUPERADMIN_ID');
        

        
        if(!empty($id)){
            
             $data['agent'] = DB::table('agents')->where('kyc_status','0')->get();         
            return view('backend/SuperAdmin/Wallet/addmoneytoagent',$data);
        }else{
             return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
    
    
            public function Add_money_to_agent(Request $request)
    {
             $id = $request->session()->get('SUPERADMIN_ID');
        
        if(!empty($id)){
            
$agent =  DB::table('agents')->where('id',$request->agent)->first();
$role=  DB::table('roles')->where('id',$agent->role)->first();
$permission=  DB::table('agentpermissions')->where('user_id',$agent->id)->first();

// print_r($agent->id);
// die;

$lsatamount= $request->amount;

  if($permission->wallet_load_type=='1'){
      
      
   $balance = $lsatamount - ($lsatamount * $permission->wallet_load_charge / 100);
    $charge=  $lsatamount-$balance;
  }else{
      
            $balance = $lsatamount - $permission->wallet_load_charge;
            $charge=  $lsatamount-$balance;
  }  
            
            
            $payInfo = [
'amount' => $lsatamount,
'paymentMode' => '4',
'merchant_id' => '0',
'tran_id' => 'PHSTS' . uniqid(),
'status' => 'success',
'user_id' => $agent->id,
'roleid' =>$role->id,
'ip' => $request->ip(),
'charge' => $charge,
'wallet_balance' => $balance,
'wallet_load_type' =>$permission->wallet_load_type,
'wallet_load_charge' =>$permission->wallet_load_charge,
        ];
        
        $result = wallet_recharge::create($payInfo);
        
                $agentwallet = DB::table('agents')->find($agent->id);

if ($agentwallet) {
DB::table('agents')
->where('id', $agent->id)
->update(['wallet' => $agentwallet->wallet + $balance]);
}



       
           $result->order_id = 'ORDER' . str_pad($result->id, 6, '0', STR_PAD_LEFT);
    $result->save(); 
    
    walletLog('1',$role->id,$agent->id,'4','Money Added To Wallet',$request->ip(),$lsatamount);
            
   return back()->with('success','Payment Added Successfully');
        }else{
             return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
    
            public function deductmoneytoagent(Request $request)
    {
             $id = $request->session()->get('SUPERADMIN_ID');
        

        
        if(!empty($id)){
            
             $data['agent'] = DB::table('agents')->where('kyc_status','0')->get();         
            return view('backend/SuperAdmin/Wallet/deductmoneytoagent',$data);
        }else{
             return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
    
    
    
        
            public function Deduct_money_to_agent(Request $request)
    {
             $id = $request->session()->get('SUPERADMIN_ID');
        
        if(!empty($id)){
            
$agent =  DB::table('agents')->where('id',$request->agent)->first();
$role=  DB::table('roles')->where('id',$agent->role)->first();
$permission=  DB::table('agentpermissions')->where('user_id',$agent->id)->first();

// print_r($agent->id);
// die;

$lsatamount= $request->amount;

            
            $payInfo = [
'amount' => $lsatamount,
'paymentMode' => '4',
'merchant_id' => '0',
'tran_id' => 'PHSTS' . uniqid(),
'status' => 'Deduct',
'user_id' => $agent->id,
'roleid' =>$role->id,
'ip' => $request->ip(),
'charge' => '',
'wallet_balance' => '',
'wallet_load_type' =>'',
'wallet_load_charge' =>'',
        ];
        
        $result = wallet_recharge::create($payInfo);
        
                $agentwallet = DB::table('agents')->find($agent->id);

if ($agentwallet) {
DB::table('agents')
->where('id', $agent->id)
->update(['wallet' => $agentwallet->wallet - $lsatamount]);
}
       walletLog('2',$role->id,$agent->id,'8',$request->message,$request->ip(),$lsatamount);
           $result->order_id = 'ORDER' . str_pad($result->id, 6, '0', STR_PAD_LEFT);
    $result->save(); 
            
   return back()->with('error','Payment Deduct Successfully');
        }else{
             return redirect('superadmin/login')->with('error','Superadmin is not authorized');
        }
    }
    
    
      public function transaction_history(Request $request){
        
             $aid = $request->session()->get('SUPERADMIN_EMAIL');
        
        if(!empty($aid)){
            
$query = DB::table('wallet_recharges')->orderby('id','DESC');


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

    $data['txnhistoy'] = $query->get();
$data['old_input'] = $request->all();
       
        return view('backend/SuperAdmin/Wallet/transaction-history',$data)->withInput($data['old_input']);
        
    }else{
        return redirect('superadmin/login')->with('error','Superadmin is not authorized');
    }}
    
    
     public function transaction_history_data(Request $request,$id){
        
             $aid = $request->session()->get('SUPERADMIN_EMAIL');
        
        if(!empty($aid)){
               $did = Crypt::decrypt($id);
            
$data['txndata'] = DB::table('wallet_recharges')
->join('paymentmodes','wallet_recharges.paymentMode','=','paymentmodes.id')
->join('agents','wallet_recharges.user_id','=','agents.id')
->select('wallet_recharges.ip as walletip','wallet_recharges.created_at as walletcreate','wallet_recharges.*','paymentmodes.*','agents.*')
->where('wallet_recharges.id',$did)->first();



        return view('backend/SuperAdmin/Wallet/transaction-history-data',$data);
        
    }else{
        return redirect('superadmin/login')->with('error','Superadmin is not authorized');
    }}
    
    
    
    private function historyajexview($request,$draw,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,$rowcount){
       
       
 $start = $draw;

    $query = DB::table('wallet_recharges');

if ($request->session()->has('SUPERADMIN_EMAIL')) {
       
             $query->where('payment_request_id', '=' ,null);
         
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


$agentdata = $this->historyajexview($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,1);
$agentdatacount = $this->historyajexview($request,$rows,$searchValue,$columnSortOrder,$columnName,$columnIndex,$filltersearchValue,0);

$i = 1;

$data = array();
foreach ($agentdata as  $row) {
    
$action = '<ul class="action" style="justify-content: space-around;">';
$action .= '<li class="delete"><a href="' .route('superadmin.wallet.transaction-history-data', ['id' => Crypt::encrypt($row->id)]). '"><i class="icon-eye"></i></a></li>';
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

$query = DB::table('wallet_recharges')->orderby('id','DESC');
$tot_rows = $query->count();

$datas = array(
"draw" => $draw,
"recordsTotal" => $agentdatacount,
"recordsFiltered" => $agentdatacount,
"data" => $data
);


echo json_encode($datas);

}


 public function payment_requset_history(Request $request){
        
             $aid = $request->session()->get('SUPERADMIN_EMAIL');
        
        if(!empty($aid)){
            
        return view('backend/SuperAdmin/Wallet/payment-requset-history');
        
    }else{
          return redirect('superadmin/login')->with('error','Superadmin is not authorized');
    }
    
    
 }
    
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



// print_r($agentdatacount);
// die;
$i = 1;

$data = array();
foreach ($agentdata as  $row) {
    
$action = '<ul class="action" style="justify-content: space-around;">';
 
$action .= '<li class="delete"><a href="' .route('superadmin.wallet.transaction-history-data', ['id' => Crypt::encrypt($row->id)]). '"><i class="icon-eye"></i></a></li>';  

$action .= '</ul>';
 
if($row->status=='success'){
$statusClass = 'badge-success';
}else if($row->status=='pending'){
    $statusClass = 'badge-warning';
}else{
$statusClass = 'badge-danger';
} 


$script= "

    <script>
document.getElementById('confirmButton$row->id').addEventListener('click', function() {
 swal({
				title: 'Are you sure?', 
				text: 'Do you want to save the changes?', 
				 type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!'
            
		    })
		    	.then((result) => {
					if (result.value) {
					 document.getElementById('statusForm{$row->id}').submit();
					} else if (result.dismiss === 'cancel') {
					    swal(
					      'Cancelled',
					      'Your stay here :)',
					      'error'
					    )
					}
				})
});
</script>";



if ($row->payment_request_status != 1) {
    $model = '
    <span class="badge rounded-pill ' . $statusClass . ' status-badge" data-id="' . $row->id . '" id="statusbadge" data-bs-toggle="modal" data-bs-target="#statusbadge'. $row->id.'">' . ucfirst($row->status) . '</span>
    <div class="modal fade" id="statusbadge' . $row->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="statusModalLabel">Change Status</h5>
          </div>
          <div class="modal-body">
            <form method="post" action="'.route("superadmin.wallet.payment_requset_update_status").'" id="statusForm'.$row->id.'" class="needs-validation ">
              <input type="hidden" name="_token" value="'.csrf_token().'">
              <input type="hidden" id="transactionId" name="transactionId" value="'.$row->id.'">
              <div class="form-group">
                <label for="statusSelect">Select Status</label>
                <select class="form-control" name="payment_request_status" required>
                  <option value="">--Select Status--</option>
                  <option value="1" '.($row->payment_request_status == '1' ? 'selected' : '').'>Success</option>
                  <option value="2" '.($row->payment_request_status == '2' ? 'selected' : '').'>Pending</option>
                  <option value="0" '.($row->payment_request_status == '0' ? 'selected' : '').'>Failed</option>
                </select>
              </div>
              <button type="button" class="btn btn-primary mt-1" id="confirmButton'.$row->id.'">Save changes</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    '.$script.'
    ';
} else {
    $model = '
    <span class="badge rounded-pill ' . $statusClass . ' status-badge" data-id="' . $row->id . '" id="statusbadge">' . ucfirst($row->status) . '</span>';
}

$screenshot = '<a href="'.url('backend/uploads/payment-requset/'.$row->payment_screenshot).'" data-fancybox="image" data-caption=""><img src="'.url('backend/uploads/payment-requset/'.$row->payment_screenshot).'"  width="100px"/></a>';

$data[] = array(
	"id"=> $i++,
	"oredrid"=>$row->order_id,
	"payment_request_id" =>$row->payment_request_id,
    "transactionID"=>$row->tran_id,
	"Amount"=> '₹'.$row->amount,
	"Date"=> date('j M Y h:i:s',strtotime($row->created_at)),
	"status" => $model,
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



public function payment_requset_update_status(Request $request)
{
    
    $data = $request->all();
    
    

    
    $transactionId = $data['transactionId'];
    $payment_request_status = $data['payment_request_status'];

    if($payment_request_status=='1'){
    $status = 'success';
}elseif($payment_request_status=='2'){
    $status = 'pending';
}else{
    $status = 'failed';
}
$user = DB::table('wallet_recharges')->where('id',$transactionId)->first();

    $transaction = wallet_recharge::find($transactionId);
    if ($transaction) {
        $transaction->payment_request_status = $payment_request_status;
        $transaction->status = $status;
        $transaction->save();
        
        
        $userIp = $request->ip();
        $message = 'Money Added To Wallet';
         $agentwallet = Agent::where('id',$user->user_id)->first();
        DB::table('agents')
->where('id', $user->user_id)
->update(['wallet' => $agentwallet->wallet + $user->wallet_balance]);
     walletLog('1','2',$user->user_id,'4',$message,$userIp,$user->wallet_balance);   
    }
return back()->with('success','Status Succesfully updated');

}


}
    
    
    

