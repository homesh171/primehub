@extends('layouts.backend.master')
@section('page_title','Deduct Money To Agent Wallet')
@section('content')
<style>span{color:red;}</style>
 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Deduct Money</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">
                @include('layouts/flash-message')
                  <div class="card-body">
                    <form class="row g-3 needs-validation custom-input" novalidate="" method="POST" action="{{ route('superadmin.wallet.Deduct_money_to_agent') }}" enctype="multipart/form-data" id="myform">
                        @csrf

                      <div class="col-6">
                        <label class="form-label" for="validationCustom01">Amount<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Amount" name="amount" value="{{old('amount')}}" required="">
                        <div class="invalid-feedback">Please enter valid Amount</div>
                        <span>@error('amount') {{ $message }} @enderror</span>
                      </div>
                      
                      <div class="col-6">
                        <label class="form-label" for="validationCustom04">Agent<span>*</span></label>
                        <select class="form-select"  name="agent" value="{{old('paymentmode')}}" required="" id="paymentmode">
                          <option selected="" disabled="" value="">Select Agent</option>
                          @foreach($agent as $agnetdata)
                          <option value="{{$agnetdata->id}}">{{$agnetdata->agent_id}}({{$agnetdata->name}})({{$agnetdata->mobile_number}})</option>
                           @endforeach
                        </select>
                        <div class="invalid-feedback">Please select Payment Mode .</div>
                        <span>@error('paymentmode') {{ $message }} @enderror</span>
                      </div>
                      
                       <div class="col-6">
                        <label class="form-label" for="validationCustom01">Message<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="text" placeholder="Enter Message" name="message" value="{{old('message')}}" required="">
                        <div class="invalid-feedback">Please enter valid message</div>
                        <span>@error('message') {{ $message }} @enderror</span>
                      </div>
                      
      
                      <div class="col-12">
                         <button class="btn btn-primary" type="submit" id="submitBtn">Submit</button>
                      </div>
                      
                          
                      
                    </form>
                  </div>
                </div>
              </div>

                 </div>
                 </div>
                 </div>
       @endsection
      