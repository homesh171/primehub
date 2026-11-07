
@extends('layouts.backend.agent.master')
@section('page_title','payout')
@section('content')
<style>span{color:red;}
.error{
  color:red !important;  
    margin:0 !important;  
    
}

</style>



 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Payout</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">
              
                  <div class="card-body">
                    <form class="row g-3 needs-validation custom-input" novalidate="" method="POST" enctype="multipart/form-data" id="payoutform">
                        @csrf
      @include('layouts.flash-message')
      <input type="hidden" name="beneficiary_id" value="{{$userData->beneficiary_id}}" />
                      <div class="col-6">
                        <label class="form-label" for="validationCustom01">Amount<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Amount" name="amount" value="{{old('amount')}}" required="">
                        <div class="invalid-feedback">Please enter valid Amount</div>
                        <span>@error('amount') {{ $message }} @enderror</span>
                      </div>
     
                        <div class="col-6">
                        <label class="form-label" for="validationCustom01">Account Number/Upi ID<span>*</span></label>
                        <select class="form-control" id="validationCustom01" name="payment_type" required="">
                            <option value="">--Select Account Number/Upi ID --</option>  
                          <option value="2">Upi ID ({{$userData->upi_id}})</option>  
                          <option value="3">Account Number ({{$userData->account_number}})</option>  
                        </select>
                        <div class="invalid-feedback">Please select valid type</div>
                        <span>@error('account') {{ $message }} @enderror</span>
                      </div>
      
                      <div class="col-12">
                         <button class="btn btn-primary" type="submit" >Submit</button>
                      </div>
                      
                          
                      
                    </form>
                  </div>
                </div>
              </div>

                 </div>
                 </div>
                 </div>
       @endsection
       @push('scripts')
       <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <!-- resources/views/payments/pay.blade.php -->
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
     <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script>

$(document).ready(function(){
var csrfToken = $('meta[name="csrf-token"]').attr('content');

$(document).on('submit', '#payoutform', function(e) {
e.preventDefault();

  var formData = $(this).serialize();


$.ajax({
url: '{{route('payout.payouttransfar')}}',
type: 'POST',
data : formData,
headers: {
'X-CSRF-TOKEN': csrfToken 
},
success: function(response) {
    
   // console.log(response);
if (response[0].results=='success') {
    
    swal({
				title: "Success", 
				text: response[0].massage, 
				type: "success",
			     }).then(function() {
        window.location.href = '{{route('agent.payout.payout')}}';
      });

} else if (response[0].results=='error') {
    swal({
				title: "Error", 
				text: response[0].massage, 
				type: "error",
			     }).then(function() {
        window.location.href = '{{route('agent.payout.payout')}}';
      });
}
},
error: function(xhr, status, error) {
console.error('Error:', error);
}
});

});








});

</script>



       @endpush