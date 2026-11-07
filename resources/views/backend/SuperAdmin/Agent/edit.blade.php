@extends('layouts.backend.master')
@section('page_title','AgentCreate')
@section('content')
<style>span{color:red;}</style>
 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Update Agent Form</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
       
                  <div class="card-body">
                             <div class="col-xl-12">
                <div class="card height-equal">
              
                  <div class="card-body">
                    <form class="row g-3 "novalidate="" method="POST" action="{{ route('superadmin.agent.update',['id'=>Crypt::encrypt($data->id)]) }}" enctype="multipart/form-data">
                        @csrf
                      <div class="col-4">
                        <label class="form-label" for="validationCustom01">Name<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="text" placeholder="Enter Name" name="name" value="{{$data['name']}}" >
                        <div class="invalid-feedback">Please enter valid Name</div>
                        <span>@error('name') {{ $message }} @enderror</span>
                      </div>
                            <div class="col-4">
                        <label class="form-label" for="validationCustom001">Email<span>*</span></label>
                        <input class="form-control" id="validationCustom001" type="email" placeholder="Enter Email" name="email" value="{{$data['email']}}" >
                        <div class="invalid-feedback">Please enter valid Email</div>
                        <span>@error('email') {{ $message }} @enderror</span>
                      </div>
                             <div class="col-4">
                        <label class="form-label" for="validationCustom001">Mobile Number<span>*</span></label>
                        <input class="form-control" id="validationCustom001" type="tel" placeholder="Enter Mobile Number" name="mobile_number" value="{{$data['mobile_number']}}" >
                        <div class="invalid-feedback">Please your valid Mobile Number</div>
                        <span>@error('mobile_number') {{ $message }} @enderror</span>
                      </div>
                      
                                <div class="col-4">
                        <label class="form-label" for="validationCustom001">WhatsApp Number<span>*</span></label>
                        <input class="form-control" id="validationCustom001" type="tel" placeholder="Enter WhatsApp Number" name="whatsapp_number" value="{{$data['whatsapp_number']}}" >
                        <div class="invalid-feedback">Please enter valid WhatsApp Number</div>
                        <span>@error('whatsapp_number') {{ $message }} @enderror</span>
                      </div>
                      
                         <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Profile Image <span>*</span></label>
                        <input class="form-control"  type="file" name="profile_image" value="{{old('profile_image')}}" >
                        <input class="form-control"  type="hidden" name="hiddenprofile_image" value="{{$data['profile_image']}}" >
                        <img src="{{url('backend/uploads/Agent/ProfileImage/'.$data->profile_image)}}" width="70px"/>
                        <div class="invalid-feedback">Please Upload a valid Profile Image</div>
                        <span>@error('profile_image') {{ $message }} @enderror</span>
                      </div> 
                        <div class="col-4">
                        <label class="col-sm-12 col-form-label" >UserName<span>*</span></label>
                        <input class="form-control"  type="text" placeholder="Enter UserName" name="username" value="{{$data['username']}}" >
                        <div class="invalid-feedback">Please enter valid UserName</div>
                        <span>@error('username') {{ $message }} @enderror</span>
                      </div>
                      
                          <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Date Of Birth<span>*</span></label>
                        <input class="form-control" id="datetime-local" type="date" placeholder="Date Of Birth" name="age" value="{{$data['age']}}"  >
                        <div class="invalid-feedback">Please enter valid Date Of Birth</div>
                        <span>@error('age') {{ $message }} @enderror</span>
                      </div>
                         <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Aadhar Number<span>*</span></label>
                        <input class="form-control"  type="number" placeholder="Enter Aadhar Number" name="aadhar_number" value="{{$data['aadhar_number']}}" >
                        <div class="invalid-feedback">Please enter valid Aadhar Number</div>
                        <span>@error('aadhar_number') {{ $message }} @enderror</span>
                      </div>
                         <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Aadhar Front Image<span>*</span></label>
                        <input class="form-control"  type="file" name="aadhar_front_image" accept=".jpg,.png" value="{{old('aadhar_front_image')}}" >
                        <input class="form-control"  type="hidden" name="hiddenaadhar_front_image" accept=".jpg,.png" value="{{$data['aadhar_front_image']}}" >
                        <img src="{{url('backend/uploads/Agent/AadharFrontImage/'.$data->aadhar_front_image)}}" width="70px"/>
                        <div class="invalid-feedback">Please Upload a valid Aadhar Front Image</div>
                        <span>@error('aadhar_front_image') {{ $message }} @enderror</span>
                      </div>
                         <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Aadhar Back Image<span>*</span></label>
                        <input class="form-control"  type="file" name="aadhar_back_image" accept=".jpg,.png" value="{{old('aadhar_back_image')}}" >
                        <input class="form-control"  type="hidden" name="hiddenaadhar_back_image" accept=".jpg,.png" value="{{$data['aadhar_back_image']}}" >
                        <img src="{{url('backend/uploads/Agent/AadharBackImage/'.$data->aadhar_back_image)}}" width="70px"/>
                        <div class="invalid-feedback">Please Upload a valid Aadhar Back Image</div>
                        <span>@error('aadhar_back_image') {{ $message }} @enderror</span>
                      </div>
                      
                         <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Pan Card Number<span>*</span></label>
                        <input class="form-control"  type="text" placeholder="Enter Pan Card Number" name="pan_number" value="{{$data['pan_number']}}"  style="text-transform: uppercase;">
                        <div class="invalid-feedback">Please enter valid Pan Card Number</div>
                        <span>@error('pan_number') {{ $message }} @enderror</span>
                      </div>
                         <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Pan card Image<span>*</span></label>
                        <input class="form-control"  type="file" name="pan_card_image" accept=".jpg,.png" value="{{old('pan_card_image')}}" >
                        <input class="form-control"  type="hidden" name="hiddenpan_card_image" accept=".jpg,.png" value="{{$data['pan_card_image']}}" >
                        <img src="{{url('backend/uploads/Agent/PanCardImage/'.$data->pan_card_image)}}" width="70px"/>
                        <div class="invalid-feedback">Please Upload valid Pan card Image</div>
                        <span>@error('pan_card_image') {{ $message }} @enderror</span>
                      </div>
                          <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Shop Name <span>*</span></label>
                        <input class="form-control"  type="text" placeholder="Enter Shop Name" name="shop_name" value="{{$data['shop_name']}}" >
                        <div class="invalid-feedback">Please enter Shop Name</div>
                        <span>@error('shop_name') {{ $message }} @enderror</span>
                      </div>
                      
                           <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Bank Name<span>*</span></label>
                        <input class="form-control"  type="text" placeholder="Enter Bank Name" name="bank_name" value="{{$data['bank_name']}}" required="">
                        <div class="invalid-feedback">Please enter Bank Name</div>
                        <span>@error('bank_name') {{ $message }} @enderror</span>
                      </div>
                      
                      
                            <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Account Number<span>*</span></label>
                        <input class="form-control"  type="text" placeholder="Enter Account Number" name="account_number" value="{{$data['account_number']}}" required="">
                        <div class="invalid-feedback">Please enter Account Number</div>
                        <span>@error('account_number') {{ $message }} @enderror</span>
                      </div>
                      
                      
                            <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Ifsc Code <span>*</span></label>
                        <input class="form-control"  type="text" placeholder="Enter Ifsc Code" name="ifsc_code" value="{{$data['ifsc_code']}}" required="">
                        <div class="invalid-feedback">Please enter Ifsc Code</div>
                        <span>@error('ifsc_code') {{ $message }} @enderror</span>
                      </div>
                      
                      
                            <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Account Holder Name <span>*</span></label>
                        <input class="form-control"  type="text" placeholder="Enter Account Holder Name" name="ac_holder_name" value="{{$data['ac_holder_name']}}" required="">
                        <div class="invalid-feedback">Please enter Account Holder Name</div>
                        <span>@error('ac_holder_name') {{ $message }} @enderror</span>
                      </div>
                      
                            <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Upi ID <span>*</span></label>
                        <input class="form-control"  type="text" placeholder="Enter Upi ID" name="upi_id" value="{{$data['upi_id']}}" required="">
                        <div class="invalid-feedback">Please enter Upi ID</div>
                        <span>@error('upi_id') {{ $message }} @enderror</span>
                      </div>
                      
                        <div class="col-4">
                        <label class="col-sm-12 col-form-label" >Shop Images <span>*</span></label>
                        <input class="form-control"  type="file" name="shop_photo[]" multiple accept=".jpg,.png" value="{{old('shop_photo')}}" >
                        <input class="form-control"  type="hidden" name="hiddenshop_photo" accept=".jpg,.png" value="{{$data['shop_photo']}}" >
                           <div id="image-preview">
        @foreach(json_decode($data->shop_photo, true) as $key => $media_gallery)
            <div class="image-container">
                <img src="{{ url('backend/uploads/Agent/ShopImages/' . $media_gallery) }}" width="70px"/>
               
            </div>
        @endforeach
                        <div class="invalid-feedback">Please Upload valid Shop Images</div>
                        <span>@error('shop_photo') {{ $message }} @enderror</span>
                      </div>
                      </div>
                   
                      
                      
                            <div class="col-4">
                        <label class="form-label" for="validationCustom04">Country<span>*</span></label>
                        <select class="form-select" id="countries" onchange="getStates()" name="country" >
                          <option selected="" disabled="" value="">Choose...</option>
                          @foreach($country as $countries)
                          <option value="{{$countries->id}}" {{($countries->id)==$data->country ? 'selected' :''}}>{{$countries->name}}</option>
                           @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a valid Country.</div>
                        <span>@error('country') {{ $message }} @enderror</span>
                      </div>
                      
                            <div class="col-4">
                        <label class="form-label" for="validationCustom04">State<span>*</span></label>
                        <select class="form-select"  id="states" onchange="getCities()" name="state" value="{{$data['state']}}" >

                            @foreach($statedata as $state)
                            <option value="{{$state->id}}" {{($state->id)==$data->state ? 'selected' :''}}>{{$state->name}}</option>
                            @endforeach

                        </select>
                        <div class="invalid-feedback">Please select a valid state.</div>
                       <span>@error('state') {{ $message }} @enderror</span>
                      </div>
                      
                
                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom03">City<span>*</span></label>
                        <select class="form-select"  id="cities" name="city" value="{{$data['city']}}" >
                           @foreach($citydata as $city)
                            <option value="{{$city->id}}" {{($city->id)==$data->city ? 'selected' :''}}>{{$city->name}}</option>
                            @endforeach

                        </select>
                        <div class="invalid-feedback">Please select a valid City.</div>
                          <span>@error('city') {{ $message }} @enderror</span>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" >Pincode<span>*</span></label>
                        <input class="form-control"  type="number" placeholder="Enter Pincode" name="pincode" value="{{$data['pincode']}}" >
                        <div class="invalid-feedback">Please provide a valid Pincode.</div>
                        <span>@error('pincode') {{ $message }} @enderror</span>
                      </div>
  
                     <div class="col-12">
                        <label class="col-sm-12 col-form-label" >Address<span>*</span></label>
                        <textarea class="form-control"  type="text" placeholder="Enter Address" name="address" >{{$data['address']}}</textarea>
                        <div class="invalid-feedback">Please enter your valid Address</div>
                        <span>@error('address') {{ $message }} @enderror</span>
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
                 </div>
                 </div>
                 </div>
       @endsection
       @push('scripts')
       <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


       @endpush