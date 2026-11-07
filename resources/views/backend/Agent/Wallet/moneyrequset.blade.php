
@extends('layouts.backend.agent.master')
@section('page_title','Payment Request')
@section('content')
<style>span{color:red;}
.error{
  color:red !important;  
    margin:0 !important;  
    
}

</style>


@php
    
$usesrdata =  DB::table('agents')->where('email',session()->get('AGENT_EMAIL'))->first();

$role=  DB::table('roles')->where('id',$usesrdata->role)->first();
$checkpaymentlimt =  DB::table('agentpermissions')->where('user_id',$usesrdata->id)->where('role',$role->id)->first();
$limit = $checkpaymentlimt->wallet_limit;
$status = $checkpaymentlimt->wallet_status
@endphp
 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Payment Request</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">
              
                  <div class="card-body">
                      <div class="row">
                    <div class="col-4"> 
                        <div class="card small-widget"> 
                          <div class="card-body primary"> <h4 class="f-light mb-3">Bank Details</h4>
                            <div class="d-flex align-items-end gap-1">
                              <span class="font-primary f-14 f-w-500">Bank Name: {{$globalData->bank_name}}</span>
                      
                            </div>
                 <div class="d-flex align-items-end gap-1">
                              <span class="font-primary f-14 f-w-500">Account Number: {{$globalData->account_number}}</span>
                     
                            </div>
                                <div class="d-flex align-items-end gap-1">
                              <span class="font-primary f-14 f-w-500">Ifsc Code : {{$globalData->ifsc_code}}</span>
                   
                            </div>
                             <div class="d-flex align-items-end gap-1">
                              <span class="font-primary f-14 f-w-500">Account Holder Name : {{$globalData->account_holder_name}}</span>
                   
                            </div>
                          </div>
                        </div>
                      </div>
                      
                                 <div class="col-4"> 
                        <div class="card small-widget"> 
                          <div class="card-body primary"> <h4 class="f-light mb-3 text-center">Qr Code </h4>
                            <div class="d-flex align-items-end gap-1">
                              <span class="font-primary f-14 f-w-500 text-center"><img class="img-fluid" src="{{url('backend/uploads/setting/'.$globalData->barcode_file)}}" alt="" width="41%"></span>
                      
                            </div>
      
                          </div>
                        </div>
                      </div>
                      
                                     <div class="col-4"> 
                        <div class="card small-widget"> 
                          <div class="card-body primary"> <h4 class="f-light mb-3">Upi ID </h4>
                            <div class="d-flex align-items-end gap-1">
                             <span class="font-primary f-14 f-w-500">Upi ID : {{$globalData->upi_id}}</span>
                      
                            </div>
      
                          </div>
                        </div>
                      </div>
                         </div>
                      
                    <form class="row g-3 needs-validation custom-input" novalidate="" method="POST" action="{{ route('payment.paymentrequset') }}" enctype="multipart/form-data" id="myform">
                        @csrf
                            @include('layouts.flash-message')
                      <div class="col-6">
                        <label class="form-label" for="validationCustom01">Amount<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Amount" name="amount" value="{{old('amount')}}" required="">
                        <div class="invalid-feedback">Please enter valid Amount</div>
                        <span>@error('amount') {{ $message }} @enderror</span>
                      </div>
                      

                      
                      <div class="col-6">
                        <label class="form-label" for="validationCustom04">Payment Mode<span>*</span></label>
                        <select class="form-select"  name="payment_mode" value="{{old('payment_mode')}}" required="" id="payment_mode">
                          <option selected="" disabled="" value="">Select Payment Mode</option>
                    
                          <option value="Bank Account">Bank Account</option>
                          <option value="Qr Code">Qr Code</option>
                          <option value="Upi ID">Upi ID</option>

                        </select>
                        <div class="invalid-feedback">Please select Payment Mode .</div>
                        <span>@error('paymentmode') {{ $message }} @enderror</span>
                      </div>
                      
                    <div class="col-6">
                        <label class="form-label" for="validationCustom01">Mobile Number<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="text" placeholder="Enter Mobile Number" name="payment_request_id" value="{{old('payment_request_id')}}" required="">
                        <div class="invalid-feedback">Please enter valid Amount</div>
                        <span>@error('payment_request_id') {{ $message }} @enderror</span>
                      </div>
                      
                      <!--  <div class="col-6">-->
                      <!--  <label class="form-label" for="validationCustom01">Payment Screenshot<span>*</span></label>-->
                      <!--  <input class="form-control" id="validationCustom01" type="file" name="payment_screenshot" value="{{old('payment_screenshot')}}" required="">-->
                      <!--  <div class="invalid-feedback">Please enter valid Amount</div>-->
                      <!--  <span>@error('payment_screenshot') {{ $message }} @enderror</span>-->
                      <!--</div>-->
      
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
    }); 
  

</script>



       @endpush