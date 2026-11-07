@extends('layouts.backend.master')
@section('page_title','Add Money')
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
                  <h4>Add Money</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">
              
                  <div class="card-body">
                    <form class="row g-3 needs-validation custom-input" novalidate="" method="POST" action="{{ route('payment.paymentaddmoney') }}" enctype="multipart/form-data" id="myform">
                        @csrf

                      <div class="col-6">
                        <label class="form-label" for="validationCustom01">Amount<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Amount" name="amount" value="{{old('amount')}}" required="">
                        <div class="invalid-feedback">Please enter valid Amount</div>
                        <span>@error('amount') {{ $message }} @enderror</span>
                      </div>
                      
                      <div class="col-6">
                        <label class="form-label" for="validationCustom04">Payment Gateway<span>*</span></label>
                        <select class="form-select"  name="paymentmode" value="{{old('paymentmode')}}" required="" id="paymentmode">
                          <option selected="" disabled="" value="">Select Payment Mode</option>
                          @foreach($paymentmode as $paymentmodedata)
                          <option value="{{$paymentmodedata->id}}">{{$paymentmodedata->title}}</option>
                           @endforeach
                        </select>
                        <div class="invalid-feedback">Please select Payment Mode .</div>
                        <span>@error('paymentmode') {{ $message }} @enderror</span>
                      </div>
                      
      
                      <div class="col-12">
                         <button class="btn btn-primary" type="button" id="submitBtn">Submit</button>
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


    $(document).ready(function () {
        
                
         $('#myform').validate({
        rules: {
            amount: {
                required: true,
            },
            paymentmode: {
                required: true,
            },
        }
    });
        
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#submitBtn").click(function () {
        var selectedPaymentMode = $("#paymentmode").val();

        if (selectedPaymentMode == 2) {
      var amount = $('input[name=amount]').val();
            var total_amount = amount * 100;
            var options = {
                "key": "rzp_test_sDiEoshy5J2uDN",
                "amount": total_amount, 
                "currency": "INR",
                "name": "primehubsofttechsolutions",
                "description": "Test Transaction",
                "image": "",
                "order_id": "", 
                "handler": function (response){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
$.ajax({
    type: 'POST',
    url: "{{ route('payment.paymentaddmoney') }}",
    data: { razorpay_payment_id: response.razorpay_payment_id, amount: amount,paymentmode:selectedPaymentMode},
    success: function (data) {
 if (data.success) {
   swal({
				title: "Success", 
				text: "Payment Successfull", 
				type: "success",
			     }).then(function() {
        window.location.href = '{{ route('superadmin.index') }}';
      });
} else {
    console.error('Error:', data.error); 
    alert('Payment failed: ' + data.error);
}
    },
    error: function (xhr, textStatus, errorThrown) {
        console.error('AJAX Error:', textStatus, errorThrown);
        alert('AJAX Error: ' + textStatus + ' - ' + errorThrown);
    }
});

                },
                "prefill": {
                    "name": "test",
                    "email": "test@example.com",
                    "contact": "9999999999"
                },
                "notes": {
                    "address": "test test"
                },
                "theme": {
                    "color": "#218838"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        }
        else {
            // Submit the form
            $("form").submit();
        }
    });
});

</script>



       @endpush