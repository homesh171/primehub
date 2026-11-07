@extends('layouts.backend.master')
@section('page_title','BBPS')
@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-6">
          <h4>Complaint Registration and Tracking</h4>
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
          <div class="card-body d-flex">
              <div class="col-6" id="complainttrans">
            <form class="row g-3 needs-validation custom-input"  novalidate="" enctype="multipart/form-data" method="POST" id="RegisterComplaint" >
              <div class="col-md-6" id="complainttrans" name="complaintType">
                <h4 class="mb-3">Register Complaint</h4>
                <input type="radio" id="complaintTrans" required/>&nbsp;Transaction <br>
                <label class="form-label mt-2">Transaction Reference ID<span>*</span></label>
                <input class="form-control" name="refid" required/> 

                <label class="form-label">Select Disposition<span>*</span></label>
                <select id="transactionIssue" class="form-control" name="transactionIssue" required>
                  <option value="">--Select Disposition--</option>
                  <option value="Transaction Successful, account not updated">Transaction Successful, account not updated</option>
                  <option value="Amount deducted, biller account credited but transaction ID not received">Amount deducted, biller account credited but transaction ID not received</option>
                  <option value="Amount deducted, biller account not credited & transaction ID not received">Amount deducted, biller account not credited & transaction ID not received</option>
                  <option value="Amount deducted multiple times">Amount deducted multiple times</option>
                  <option value="Double payment updated">Double payment updated</option>
                  <option value="Erroneously paid in wrong account">Erroneously paid in wrong account</option>
                  <option value="Others, provide details in description">Others, provide details in description</option>
                </select>
                
                <label class="form-label">Description<span>*</span></label>
                <textarea class="form-control" type="text" name="desc" required></textarea>
                
              </div>  



              <div class="col-md-12 mt-2">
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
            </form>
    
                        <div id="complainmsg" style="display:none">
            </div>
          </div>
            <div class="col-6">
                
                <div class="col-md-6" id="complaintTrackingSection">
                <h4 class="mb-3">Complaint Tracking</h4>
                <form method="post" id="complaintTracking"  class="needs-validation custom-input"   novalidate="">
                <input type="radio" id="complaintTrack" name="complaintTrack" required/>&nbsp;Transaction <br>
                <input class="form-control mt-2" name="complaintID" placeholder="Enter Complaint ID" required/>
                  <button class="btn btn-primary mt-2" type="submit">Submit</button>
                  </form>
              </div>
            </div>

    
             <div id="trackmsg" style="display:none">

            </div>
          </div>
                  <div id="error-message"></div>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

<script>
@if(session('success'))
swal(
'Success',
'{{ session('success') }}',
'success'
)
@endif


@if(session('error'))
swal(
'Error',
'{{ session('error') }}',
'error'
)
@endif
</script>
<script>
    $(document).ready(function(){
var csrfToken = $('meta[name="csrf-token"]').attr('content');

$(document).on('submit','#RegisterComplaint',function(e){
e.preventDefault();
var formData = $(this).serialize();
$('#loader').css('display', 'flex');
$('#error-message').empty();
$('#complainmsg').empty();
$.ajax({
url: '{{route('superadmin.bbps.complaintregistronData')}}',
method: 'post',
headers: {
'X-CSRF-TOKEN': csrfToken 
},
data: formData,
success: function(response) {

$('#complainmsg').css('display', 'block');

$('#complainmsg').html(''); 

  if (response.responseCode=='000') {
      $('#loader').hide();
         $('#complainmsg').append('<h6>Complaint Registered Successfully</h6>');
        $('#complainmsg').append('<span>Complaint ID: ' + response.complaintId + '</span></br>');
        $('#complainmsg').append('<span>Complaint Assigned: ' + response.complaintAssigned + '</span></br>');

    }else if (response.errorInfo) {
$('#loader').hide();
var errorMessage = response.errorInfo.error.errorMessage;
$('#error-message').css('display', 'block');
$('#error-message').text(errorMessage);
} else {
$('#loader').hide();
$('#error-message').css('display', 'block');
$('#error-message').text('Unexpected response structure.');
}

},
error: function(xhr, status, error) {
$('#loader').hide();

}
});

});



$(document).on('submit','#complaintTracking',function(e){
e.preventDefault();
var formData = $(this).serialize();
$('#loader').css('display', 'flex');
$('#error-message').empty();
$('#trackmsg').empty();

$.ajax({
url: '{{route('superadmin.bbps.complaintracking')}}',
method: 'post',
headers: {
'X-CSRF-TOKEN': csrfToken 
},
data: formData,
success: function(response) {
$('#trackmsg').css('display', 'block');

$('#trackmsg').html(''); 

  if (response.responseCode=='000') {
      $('#loader').hide();
       $('#trackmsg').append('<span>Complaint ID: ' + response.complaintId + '</span></br>');
        $('#trackmsg').append('<span>Complaint Assigned: ' + response.complaintAssigned + '</span></br>');
        $('#trackmsg').append('<span>Complaint Status: ' + response.complaintStatus + '</span></br>');

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




<script>
document.addEventListener('DOMContentLoaded', function() {
    const complaintTrans = document.querySelector('#complaintTrans');
    const complaintTrack = document.querySelector('#complaintTrack');
    const complaintTrackingSection = document.querySelector('#complaintTrackingSection');
    
    complaintTrans.addEventListener('change', function() {
        if (complaintTrans.checked) {
            document.querySelector('#complainttrans').style.display = 'block';
            complaintTrackingSection.style.display = 'none';
        }
    });

    complaintTrack.addEventListener('change', function() {
        if (complaintTrack.checked) {
            document.querySelector('#complainttrans').style.display = 'none';
            complaintTrackingSection.style.display = 'block';
        }
    });
});
</script>

@endpush


@endsection
