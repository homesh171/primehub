@extends('layouts.backend.master')
@section('page_title','AgentCreate')
@section('content')
<style>span{color:red;}</style>
<div class="page-body">
<div class="container-fluid">
<div class="page-title">
<div class="row">
<div class="col-6">
<h4>Create Agent Form</h4>
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="card height-equal">
<div class="card-body">
<form class="row g-3 needs-validation custom-input"   novalidate="" method="POST" action="{{ route('superadmin.agent.store') }}" enctype="multipart/form-data">
@csrf
<div class="col-4">
<label class="form-label" for="validationCustom01">Name<span>*</span></label>
<input class="form-control" id="validationCustom01" type="text" placeholder="Enter Name" name="name" value="{{old('name')}}" required="">
<div class="invalid-feedback">Please enter valid Name</div>
@if($errors->has('name'))
<span>@error('name') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-4">
<label class="form-label" for="validationCustom001">Email<span>*</span></label>
<input class="form-control" id="validationCustom001" type="email" placeholder="Enter Email" name="email" value="{{old('email')}}" required="">
<div class="invalid-feedback">Please enter valid Email</div>
@if($errors->has('email'))
<span>@error('email') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-4">
<label class="form-label" for="validationCustom001">Mobile Number<span>*</span></label>
<input class="form-control" id="validationCustom001" type="tel" placeholder="Enter Mobile Number" name="mobile_number" value="{{old('mobile_number')}}" required="">
<div class="invalid-feedback">Please your valid Mobile Number</div>
@if($errors->has('mobile_number'))
<span>@error('mobile_number') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-4">
<label class="form-label" for="validationCustom001">WhatsApp Number<span>*</span></label>
<input class="form-control" id="validationCustom001" type="tel" placeholder="Enter WhatsApp Number" name="whatsapp_number" value="{{old('whatsapp_number')}}" required="">
<div class="invalid-feedback">Please enter valid WhatsApp Number</div>
@if($errors->has('whatsapp_number'))
<span>@error('whatsapp_number') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-4">
<label class="col-sm-12 col-form-label" >Profile Image <span>*</span></label>
<input class="form-control"  type="file" name="profile_image" value="{{old('profile_image')}}" required="">
<div class="invalid-feedback">Please Upload a valid Profile Image</div>
@if($errors->has('profile_image'))
<span>@error('profile_image') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div> 
<div class="col-4">
<label class="col-sm-12 col-form-label" >UserName<span>*</span></label>
<input class="form-control"  type="text" placeholder="Enter UserName" name="username" value="{{old('username')}}" required="">
<div class="invalid-feedback">Please enter valid UserName</div>
@if($errors->has('username'))
<span>@error('username') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-4">
<label class="col-sm-12 col-form-label" >Password<span>*</span></label>
<input class="form-control"  type="password" placeholder="Enter Password" name="password" value="{{old('password')}}" required="">
<div class="invalid-feedback">Please enter valid password</div>
@if($errors->has('password'))
<span>@error('password') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-4">
<label class="col-sm-12 col-form-label" >Date Of Birth<span>*</span></label>
<input class="form-control" id="datetime-local" type="date" placeholder="Date Of Birth" name="age" value="{{old('age')}}"  required="">
<div class="invalid-feedback">Please enter valid Date Of Birth</div>
@if($errors->has('age'))
<span>@error('age') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-4">
<label class="col-sm-12 col-form-label" >Agent Pin<span>*</span></label>
<input class="form-control"  type="number" placeholder="Enter Agent Pin" name="agent_pin" value="{{old('agent_pin')}}" required="">
<div class="invalid-feedback">Please enter valid Agent Pin</div>
@if($errors->has('agent_pin'))
<span>@error('agent_pin') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-4">
<label class="col-sm-12 col-form-label" >Aadhar Number<span>*</span></label>
<input class="form-control"  type="number" placeholder="Enter Aadhar Number" name="aadhar_number" value="{{old('aadhar_number')}}" required="">
<div class="invalid-feedback">Please enter valid Aadhar Number</div>
@if($errors->has('aadhar_number'))
<span>@error('aadhar_number') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-4">
<label class="col-sm-12 col-form-label" >Aadhar Front Image<span>*</span></label>
<input class="form-control"  type="file" name="aadhar_front_image" accept=".jpg,.png" value="{{old('aadhar_front_image')}}" required="">
<div class="invalid-feedback">Please Upload a valid Aadhar Front Image</div>
@if($errors->has('aadhar_front_image'))
<span>@error('aadhar_front_image') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-4">
<label class="col-sm-12 col-form-label" >Aadhar Back Image<span>*</span></label>
<input class="form-control"  type="file" name="aadhar_back_image" accept=".jpg,.png" value="{{old('aadhar_back_image')}}" required="">
<div class="invalid-feedback">Please Upload a valid Aadhar Back Image</div>
@if($errors->has('aadhar_back_image'))
<span>@error('aadhar_back_image') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-4">
<label class="col-sm-12 col-form-label" >Pan Card Number<span>*</span></label>
<input class="form-control"  type="text" placeholder="Enter Pan Card Number" name="pan_number" value="{{old('pan_number')}}" required="" style="text-transform: uppercase;">
<div class="invalid-feedback">Please enter valid Pan Card Number</div>
@if($errors->has('pan_number'))
<span>@error('pan_number') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-4">
<label class="col-sm-12 col-form-label" >Pan card Image<span>*</span></label>
<input class="form-control"  type="file" name="pan_card_image" accept=".jpg,.png" value="{{old('pan_card_image')}}" required="">
<div class="invalid-feedback">Please Upload valid Pan card Image</div>
@if($errors->has('pan_card_image'))
<span>@error('pan_card_image') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-4">
<label class="col-sm-12 col-form-label" >Shop Name <span>*</span></label>
<input class="form-control"  type="text" placeholder="Enter Shop Name" name="shop_name" value="{{old('shop_name')}}" required="">
<div class="invalid-feedback">Please enter Shop Name</div>
@if($errors->has('shop_name'))
<span>@error('shop_name') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-4">
<label class="col-sm-12 col-form-label" >Bank Name<span>*</span></label>
<input class="form-control"  type="text" placeholder="Enter Bank Name" name="bank_name" value="{{old('bank_name')}}" required="">
<div class="invalid-feedback">Please enter Bank Name</div>
@if($errors->has('bank_name'))
<span>@error('bank_name') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>


<div class="col-4">
<label class="col-sm-12 col-form-label" >Account Number<span>*</span></label>
<input class="form-control"  type="text" placeholder="Enter Account Number" name="account_number" value="{{old('account_number')}}" required="">
<div class="invalid-feedback">Please enter Account Number</div>
@if($errors->has('account_number'))
<span>@error('account_number') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>


<div class="col-4">
<label class="col-sm-12 col-form-label" >Ifsc Code <span>*</span></label>
<input class="form-control"  type="text" placeholder="Enter Ifsc Code" name="ifsc_code" value="{{old('ifsc_code')}}" required="">
<div class="invalid-feedback">Please enter Ifsc Code</div>
@if($errors->has('ifsc_code'))
<span>@error('ifsc_code') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>


<div class="col-4">
<label class="col-sm-12 col-form-label" >Account Holder Name <span>*</span></label>
<input class="form-control"  type="text" placeholder="Enter Account Holder Name" name="ac_holder_name" value="{{old('ac_holder_name')}}" required="">
<div class="invalid-feedback">Please enter Account Holder Name</div>
@if($errors->has('ac_holder_name'))
<span>@error('ac_holder_name') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-4">
<label class="col-sm-12 col-form-label" >Upi ID <span>*</span></label>
<input class="form-control"  type="text" placeholder="Enter Upi ID" name="upi_id" value="{{old('upi_id')}}" required="">
<div class="invalid-feedback">Please enter Upi ID</div>
@if($errors->has('upi_id'))
<span>@error('upi_id') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-4">
<label class="col-sm-12 col-form-label" >Shop Images <span>*</span></label>
<input class="form-control"  type="file" name="shop_photo[]" multiple accept=".jpg,.png" value="{{old('shop_photo')}}" required="">
<div class="invalid-feedback">Please Upload valid Shop Images</div>
@if($errors->has('name'))
<span>@error('name') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-3">
<label class="form-label" for="validationCustom04">Country<span>*</span></label>
<select class="form-select" id="countries" onchange="getStates()" name="country" value="{{old('country')}}" required="">
<option selected="" disabled="" value="">Choose...</option>
@foreach($country as $countries)
<option value="{{$countries->id}}">{{$countries->name}}</option>
@endforeach
</select>
<div class="invalid-feedback">Please select a valid Country.</div>
@if($errors->has('country'))
<span>@error('country') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-3">
<label class="form-label" for="validationCustom04">State<span>*</span></label>
<select class="form-select"  id="states" onchange="getCities()" name="state" value="{{old('state')}}" required="">

</select>
<div class="invalid-feedback">Please select a valid state.</div>
@if($errors->has('state'))
<span>@error('state') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>


<div class="col-md-3">
<label class="form-label" for="validationCustom03">City<span>*</span></label>
<select class="form-select"  id="cities" name="city" value="{{old('city')}}" required="">

</select>
<div class="invalid-feedback">Please select a valid City.</div>
@if($errors->has('city'))
<span>@error('city') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>
<div class="col-md-3">
<label class="form-label" >Pincode<span>*</span></label>
<input class="form-control"  type="number" placeholder="Enter Pincode" name="pincode" value="{{old('pincode')}}" required="">
<div class="invalid-feedback">Please provide a valid Pincode.</div>
@if($errors->has('pincode'))
<span>@error('pincode') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-12">
<label class="col-sm-12 col-form-label" >Address<span>*</span></label>
<textarea class="form-control"  type="text" placeholder="Enter Address" name="address" required="">{{old('address')}}</textarea>
<div class="invalid-feedback">Please enter your valid Address</div>
@if($errors->has('address'))
<span>@error('address') {{ $message }} @enderror</span>
@else
<span style="display: none;"></span>
@endif
</div>

<div class="col-12">
<button class="btn btn-primary" type="submit">Submit form</button>
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

@endpush