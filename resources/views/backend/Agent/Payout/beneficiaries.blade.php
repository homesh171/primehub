@extends('layouts.backend.agent.master')
@section('page_title','Add Money')
@section('content')
<style>

span{
    color:red;
}

.error{
  color:red !important;  
    margin:0 !important;  
}

</style>

 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-12">
                  <h4>Add Beneficiaries and DMT Payment Transfer</h4>
                </div>
              </div>
            </div>
          </div>

<div class="container-fluid">
<div class="row">
<div class="col-sm-12">  
<div class="card">
<div class="card-body">
                      
<form class="row g-3 custom-input" enctype="multipart/form-data" method="POST">
@csrf
<div class="col-6">
<label class="form-label">Mobile Number<span>*</span></label>
<input class="form-control" maxlength="10" value="{{ session()->get('benefinumber') }}" type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter Number" id="number"  name="number" required>
<div style="color:red;" id="error">@error('mobile') {{ $message }} @enderror</div>
<button class="btn btn-primary otpsend mt-1" type="button" id="sendotpbutton">Check Verify</button>
</div>

<div class="col-6 otpinputhide" style="display:none;">
<label class="form-label">OTP<span>*</span></label>
<input class="form-control" maxlength="6" type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Enter OTP" id="otp"  name="otp" required>
<div style="color:red;" id="otperror">@error('otp') {{ $message }} @enderror</div>
</div>

<div class="co-d-3 verifyotphide" style="display:none;">
    <button class="btn btn-primary" type="button"  id="verifyotp">Verify OTP</button>
</div>

</form>

                    
                  </div>
                </div>
              </div>
              
              <div class="col-md-7">
                  @if(!empty(session()->get('benefinumber'))) 
                  
                          
                    @php
                    
                    $number = session()->get('benefinumber');
                    
                    @endphp
                  
                <div class="card">
                  <div class="card-body">
                    
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#exampleModal">Add Beneficiaries</button>  
                    
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-body">

                    <form class="row g-3 needs-validation" action="{{route('payout.addbeneficiariesaccount')}}" novalidate="" method="POST">
                        
                        @csrf
                        
                        <div class="col-md-6">
                        <label class="form-label" for="account_number">Account Number</label>
                        <input class="form-control" id="account_number" name="account_number" type="number" value="" placeholder="" required="">
                        </div>
                        
                        <div class="col-md-6">
                        <label class="form-label" for="ifsc_code">IFSC Code</label>
                        <input class="form-control" id="ifsc_code" name="ifsc_code" type="text" value="" placeholder="" required="">
                        </div>

                        <div class="col-md-6">
                        <label class="form-label" for="mobile">Mobile Number</label>
                        <input class="form-control" id="mobile" type="number" name="mobile" value="{{$number}}" placeholder="" required="" readonly>
                        </div>
                        
                        <div class="col-md-6">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control" id="name" type="text" name="name" value="" placeholder="" required="">
                        </div>
                        
                        <div class="col-md-12">
                        <label class="form-label" for="email">Email Address</label>
                        <input class="form-control" id="email" type="email" name="email" value="" placeholder="" required="">
                        </div>
                        
                        <div class="col-md-12">
                        <label class="form-label" for="address">Address</label>
                        <input class="form-control" id="address" name="address" value="Jaipur" type="text" placeholder="" required="">
                        </div>
                        
                        <div class="col-md-12">
                        <label class="form-label" for="">Payment Method</label><br>
                        <input type="checkbox" value="1" name="allowed_payment_types[]" > NEFT &nbsp&nbsp
                       <!--- <input type="checkbox" value="2" name="allowed_payment_types[]" > UPI &nbsp&nbsp -->
                        <input type="checkbox" value="3" name="allowed_payment_types[]" checked> IMPS &nbsp&nbsp
                        <input type="checkbox" value="4" name="allowed_payment_types[]"> RTGS &nbsp&nbsp
                        </div>
                        
                        <div class="col-md-12" style="display:none;">
                        <label class="form-label" for="upi">UPI</label>
                        <input class="form-control" id="vpa" name="vpa" type="text" placeholder="">
                        </div>
                        
                        <div class="col-md-12"> 
                        <button class="btn btn-primary" type="submit" name="submit" value="submit">Submit</button>
                        </div>
                        
                    </form>
                              
                    </div>
                    </div>
                    </div>
                    </div>
     
            @foreach($details as $detailsdata)     
            <div class="light-card balance-card widget-hover cardlistdata">
            <div class="svg-box"><i class="fa fa-university"></i></div>
            <div> <span class="f-light"> {{$detailsdata['name']}} ({{$detailsdata['ifsc_code']}})</span>
            <h6 class="mt-1 mb-0">{{$detailsdata['account_number']}}</h6>
            </div>
            <div class="ms-auto text-end">
            <div class="dropdown icon-dropdown">
            <button onclick="amountpayout('{{$detailsdata['beneficiary_id']}}','{{$detailsdata['name']}}','{{$detailsdata['ifsc_code']}}','{{$detailsdata['account_number']}}','{{$detailsdata['allowed_payment_types']}}');" class="btn btn-primary buttonpadding" type="button"><i class="fa fa-telegram"></i></button>
            </div>
            </div>
            </div>
            @endforeach

                    </div>
                </div>
                
                
<div class="modal fade" id="paymentpopap" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">Payment</div>
<div class="modal-body">

<form class="row g-3"  method="POST">
@csrf
<input class="form-control" id="paymentbeni" name="beneficiary_id" type="hidden" readonly required="">
<div class="col-md-6">
<label class="form-label" for="account_number">Account Number</label>
<input class="form-control" id="paymentaccountnumber" name="account_number" type="number" readonly required="">
</div>

<div class="col-md-6">
<label class="form-label" for="ifsc_code">IFSC Code</label>
<input class="form-control" id="paymentifsc" name="ifsc_code" type="text" readonly required="">
</div>

<div class="col-md-6">
<label class="form-label" for="name">Name</label>
<input class="form-control" id="paymentname" type="text" name="name" readonly required="">
</div>

<div class="col-md-6">
<label class="form-label" for="name">Amount</label>
<input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" id="amount" type="text" name="amount"  required="">
<div style="color:red;" id="erroramount"></div>
</div>

<div class="col-md-12">
<label class="form-label" for="">Payment Method</label><br>
<select class="form-control" id="paymentmode" required name="payment_type">
</select>
</div>

<div class="col-md-12"> 
<button class="btn btn-primary" type="button" id="payoutpayment" name="payment" value="payment">Submit</button>
</div>

</form>

</div>
</div>
</div>
</div>                

@push('scripts')


<script>
$(document).ready(function() {
$("#payoutpayment").click(function() {

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});    
    
var paymentbeni = $("#paymentbeni").val();
var amount = $("#amount").val();
var payment_type = $("#paymentmode").val();

if(amount == "")
{
document.getElementById("erroramount").innerHTML = "";
$("#erroramount").show();
document.getElementById("erroramount").innerHTML = "Amount Required";
document.getElementById("amount").focus();
return false;
} else {
$.ajax({
type: 'POST',
url:"{{route('payout.payoutpayment')}}",
dataType:"json",
data: {
amount: amount,
beneficiary_id: paymentbeni,
payment_type:payment_type,
},
success: function(data) {

if(data.results == "success")
{
    
   
  var notify = $.notify(
    '<i class="fa fa-bell-o"></i><strong>'+data.massage+'</strong>',
    {
      type: "theme",
      allow_dismiss: true,
      delay: 5000,
      showProgressbar: true,
      timer: 300,
      animate: {
        enter: "animated fadeInDown",
        exit: "animated fadeOutUp",
      },
    }
  );
$('#number').prop('readonly', true);
document.getElementById("sendotpbutton").innerHTML = "Check Verify";
$(".otpinputhide").show();
$(".verifyotphide").show();

window.location.reload();

} else if(data.results == "error"){

var notify = $.notify(
'<i class="fa fa-bell-o"></i><strong>'+data.massage+'</strong>',
{
type: "theme",
allow_dismiss: true,
delay: 5000,
showProgressbar: true,
timer: 300,
animate: {
enter: "animated fadeInDown",
exit: "animated fadeOutUp",
},
}
);

}
}

});	
}
});
});
</script>


<script>

function amountpayout(beneficiary_id,name,ifsc_code,account_number,allowed_payment_types){
    
$('#paymentbeni').val(beneficiary_id);
$('#paymentname').val(name);
$('#paymentifsc').val(ifsc_code);
$('#paymentaccountnumber').val(account_number);

let words = allowed_payment_types.split(',');
for (i = 0; i < words.length; i++) {
    if(words[i] == '1'){
        var selectvalue1 = "<option value='1'>NEFT</option>"
    }
    if(words[i] == '2'){
        var selectvalue2 = "<option value='2'>UPI</option>"
    }
    if(words[i] == '3'){
        var selectvalue3 = "<option value='3'>IMPS</option>"
    }
    if(words[i] == '4'){
        var selectvalue4 = "<option value='4'>RTGS</option>"
    }
}


$('#paymentmode').html(selectvalue1+selectvalue2+selectvalue3+selectvalue4);
$('#paymentpopap').modal('show');

};
</script>


@endpush
            
@endif
</div>
              
              

    @if(session()->get('benefinumber'))
    <div class="col-md-5">
         <div class="card">
                  <div class="card-body">
    <h5 class="text-center">Recent Transtaiom History</h5>
@forelse($txn as $tran)
    <div class="row mt-3">
        <div class="col-md-6">
            <span class="f-light">@if(!empty($tran->account_number)) {{$tran->account_number}} @else {{$tran->vpa}} @endif</span>
            <span class="f-light">@if(!empty($tran->ifsc_code))({{$tran->ifsc_code}})@endif</span>
           <span class="f-light">{{ date('j M Y h:i:s a', strtotime($tran->created_at)) }}</span>
        </div>
        <div class="col-md-2">
            <h4><a href="{{route('agent.payout.payout-invoice',['id'=>Crypt::encrypt($tran->id)])}}"><i class="fa fa-print" aria-hidden="true"></i></a></h4>
        </div>
        <div class="col-md-4">
            <span class="f-light me-2">₹{{$tran->amount}}</span>
            <span>@if($tran->payout_status=='Success' )<span class="badge rounded-pill badge-success">Success</span>@elseif($tran->payout_status=='Pending')<span class="badge rounded-pill badge-warning">Pending</span>@else<span class="badge rounded-pill badge-danger">Failed</span>@endif </span>
        </div>
    </div>
    <hr>
@empty

    <div class="row">
        <div class="col-md-12 mt-2 text-center">
            <p style="color:red">No transactions found.</p>
        </div>
    </div>
@endforelse
    
      </div>
</div>                
</div>
    @endif

</div>
</div>
</div>


@endsection
@push('scripts')
       
       
<script src="{{url('backend/assets/js/modalpage/validation-modal.js')}}"></script>

       
<script>
$(document).ready(function() {
$("#verifyotp").click(function() {

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});    
    
var number = $("#number").val();
var otp = $("#otp").val();

if(number == "")
{
document.getElementById("error").innerHTML = "";
$("#error").show();
document.getElementById("error").innerHTML = "Mobile Number Required";
document.getElementById("number").focus();
return false;
}else if(number.length!=10){
    document.getElementById("error").innerHTML = "";
$("#error").show();
document.getElementById("error").innerHTML = "Mobile Number Required 10 Degit";
document.getElementById("number").focus();
return false;
}else if(otp == ""){
document.getElementById("otperror").innerHTML = "";
$("#otperror").show();
document.getElementById("otperror").innerHTML = "OTP Required";
document.getElementById("number").focus();
return false;
}else if(otp.length!=6){
    document.getElementById("otperror").innerHTML = "";
$("#otperror").show();
document.getElementById("otperror").innerHTML = "OTP Required 6 Degit";
document.getElementById("number").focus();
return false;
}
else
{
$.ajax({
type: 'POST',
url:"{{route('payout.addbeneficiariesnumberverify')}}",
dataType:"json",
data: {
number: number,
otp: otp,
},
success: function(data) {

if(data.results == "success")
{
  var notify = $.notify(
    '<i class="fa fa-bell-o"></i><strong>'+data.massage+'</strong>',
    {
      type: "theme",
      allow_dismiss: true,
      delay: 2000,
      showProgressbar: true,
      timer: 300,
      animate: {
        enter: "animated fadeInDown",
        exit: "animated fadeOutUp",
      },
    }
  );


$('#number').removeProp('readonly', true);
$(".otpinputhide").hide();
$(".verifyotphide").hide();


window.location.reload();

} else if(data.results == "error"){
    
    var notify = $.notify(
    '<i class="fa fa-bell-o"></i><strong>'+data.massage+'</strong>',
    {
      type: "theme",
      allow_dismiss: true,
      delay: 2000,
      showProgressbar: true,
      timer: 300,
      animate: {
        enter: "animated fadeInDown",
        exit: "animated fadeOutUp",
      },
    }
  );

}

}
});	
}
});
});
</script>



<script>
$(document).ready(function() {
$("#sendotpbutton").click(function() {

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});    
    
var number = $("#number").val();

if(number == "")
{
document.getElementById("error").innerHTML = "";
$("#error").show();
document.getElementById("error").innerHTML = "Mobile Number Required";
document.getElementById("number").focus();
return false;
}else if(number.length!=10){
    document.getElementById("error").innerHTML = "";
$("#error").show();
document.getElementById("error").innerHTML = "Mobile Number Required 10 Degit";
document.getElementById("number").focus();
return false;
}
else
{
$.ajax({
type: 'POST',
url:"{{route('payout.addbeneficiaries')}}",
dataType:"json",
data: {
number: number,
},
success: function(data) {

if(data.results == "success")
{
  var notify = $.notify(
    '<i class="fa fa-bell-o"></i><strong>'+data.massage+'</strong>',
    {
      type: "theme",
      allow_dismiss: true,
      delay: 2000,
      showProgressbar: true,
      timer: 300,
      animate: {
        enter: "animated fadeInDown",
        exit: "animated fadeOutUp",
      },
    }
  );
$('#number').prop('readonly', true);
document.getElementById("sendotpbutton").innerHTML = "Check Verify";
$(".otpinputhide").show();
$(".verifyotphide").show();



} else if(data.results == "Already"){

window.location.reload();

}else if(data.results == "error"){

var notify = $.notify(
'<i class="fa fa-bell-o"></i><strong>'+data.massage+'</strong>',
{
type: "theme",
allow_dismiss: true,
delay: 2000,
showProgressbar: true,
timer: 300,
animate: {
enter: "animated fadeInDown",
exit: "animated fadeOutUp",
},
}
);

}
}
});	
}
});
});
</script>

@endpush