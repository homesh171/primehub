@extends('layouts.backend.master')
@section('page_title','BBPS')
@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-6">
          <h4>Search Transaction</h4>
        </div>
        <div class="col-6 text-end">
          <img src="{{url('backend/assets/images/BBPS New Logo_1-01.jpg')}}" width="40px"/>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">  
        <div class="card">
          <div class="card-body">
            <form class="row g-3 needs-validation custom-input"   novalidate="" enctype="multipart/form-data" method="POST" id="complaintTrackingform">
                @csrf
              <div class="col-md-6" id="complainttrans">
                <h4 class="mb-3">Search Transaction</h4>
                <!--<input type="radio" id="complaintTrans"/>&nbsp;Transaction <br>-->
                <label class="form-label mt-2">Transaction Reference ID<span>*</span></label>
                <input class="form-control" name="TRANS_REF_ID"  required/> 

                <!--<h4 class="text-center mt-1">OR</h4>-->
                <!--<label class="form-label">Enter Mobile No.<span>*</span></label>-->
                <!--<input class="form-control" name="mobile_number" /> -->

                <!--<label class="form-label">Start Date<span>*</span></label>-->
                <!--<input class="form-control" type="date" name="mobile_number" /> -->

                <!--<label class="form-label">End Date<span>*</span></label>-->
                <!--<input class="form-control" type="date" name="mobile_number" /> -->


                
              </div>  

              <div class="col-md-6" id="complaintTrackingSection" style="display:none">
        

              </div>

              <div class="col-md-12 mt-2">
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
              <div id="error-message"></div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="loader" style="display: none;
justify-content: center;
position: absolute;
bottom: 29%;
left: 53%;">
<img src="{{url('backend/assets/Hourglass.gif')}}" alt="Loading..." /> 
</div>
 
@push('scripts')



<script>
    $(document).ready(function(){
var csrfToken = $('meta[name="csrf-token"]').attr('content');

$(document).on('submit','#complaintTrackingform',function(e){
e.preventDefault();
var formData = $(this).serialize();
$('#loader').css('display', 'flex');
$('#error-message').css('display', 'none');

$.ajax({
url: '{{route('superadmin.bbps.searchTransactionData')}}',
method: 'post',
headers: {
'X-CSRF-TOKEN': csrfToken 
},
data: formData,
success: function(response) {

$('#complaintTrackingSection').css('display', 'block');

$('#complaintTrackingSection').html(''); 

  if (response.responseCode=='000') {
      $('#loader').hide();
      
        $('#complaintTrackingSection').append('<h6>Transaction Details</h6>');
        $('#complaintTrackingSection').append('<span>Biller name: ' + response.txnList.respCustomerName + '</span></br>');
        $('#complaintTrackingSection').append('<span>Amount: ₹' + response.txnList.amount/100 + '</span></br>');
var originalDate = new Date(response.txnList.txnDate);
var formattedDate =
  ("0" + originalDate.getDate()).slice(-2) + "-" +
  ("0" + (originalDate.getMonth() + 1)).slice(-2) + "-" +
  originalDate.getFullYear() + " " +
  ("0" + originalDate.getHours()).slice(-2) + ":" +
  ("0" + originalDate.getMinutes()).slice(-2) + ":" +
  ("0" + originalDate.getSeconds()).slice(-2);

$('#complaintTrackingSection').append('<span>Transaction Date: ' + formattedDate + '</span><br>');

        $('#complaintTrackingSection').append('<span>Transaction Ref ID : ' + response.txnList.txnReferenceId + '</span></br>');
        $('#complaintTrackingSection').append('<span>Transaction Status: ' + response.txnList.txnStatus + '</span></br>');
    }else if (response.errorInfo) {
$('#loader').hide();
var errorMessage = response.errorInfo.error.errorMessage;
 $('#error-message').css('display', 'block').html(errorMessage);
}else{
$('#loader').hide();
$('#error-message').css('display', 'block').html('Unexpected response structure.');

}

},
error: function(xhr, status, error) {
$('#loader').hide();
}
});

});

});

</script>


@endpush


@endsection
