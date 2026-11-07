@extends('layouts.backend.master')
@section('page_title','system-setting')
@section('content')

<div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Website Settings</h4>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">                                       
                        <svg class="stroke-icon">
                          <use href="https://develop.basketbazar.com//assets/svg/icon-sprite.svg#stroke-home"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Website Settings</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
             <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
               
              <div class="col-xl-12">
                                  <div class="card height-equal">
                  <div class="card-body">
                  
                    <form class="row g-3 needs-validation custom-input" enctype="multipart/form-data" novalidate="" action="{{route('superadmin.setting.update',['id'=>$data->id])}}" method="POST">
                        @csrf
                      <div class="col-6">
                        <label class="form-label" for="">Site Title</label>
                        <input class="form-control" id="" type="text" placeholder="Site Title" value="{{$data['site_title']}}" name="site_title">
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                      
                      <div class="col-6">
                        <label class="form-label" for="">Email</label>
                        <input class="form-control" id="" type="text" placeholder="Email" value="{{$data['email']}}" name="email">
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                      
                    
                    <div class="col-4">
                        <label class="form-label" for="">Telephone</label>
                        <input class="form-control" id="" type="text" placeholder="Telephone" value="{{$data['telephone']}}" name="telephone">
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                      
                    <div class="col-4">
                        <label class="form-label" for="">Mobile Number</label>
                        <input class="form-control" id="" type="number" placeholder="Mobile Number" value="{{$data['mobile_number']}}" name="mobile_number">
                        <div class="invalid-feedback">Please enter your valid </div>
                    </div>
                    
                      <div class="col-4">
                        <label class="form-label" for="">Whatsapp No</label>
                        <input class="form-control" id="" type="text" placeholder="Whatsapp No" value="{{$data['whatsapp_number']}}" name="whatsapp_number">
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                      
                     <div class="col-4"> 
                        <label class="form-label" for="formFile1">Favicon</label>
                        <div class="input-group" style="margin-top: 4px;">
                        <input type="file" class="form-control" name="favicon" >
                                                <a href="" data-fancybox="image" data-caption="">
                        <img src="{{url('backend/uploads/setting/'.$data->favicon)}}" style=" width: 50px;height:38px; margin-left: 10px !important;
                        padding: 0 !important;">
                        </a>
                        <input type="hidden" class="form-control" name="hiddenfavicon" placeholder="" value="{{$data['favicon']}}">
                                                <div class="invalid-feedback">Invalid form file selected</div>
                    </div>
                    </div>
                      
                      <div class="col-4"> 
                        <label class="form-label" for="formFile1">Dark Logo</label>
                         <div class="input-group" style="margin-top: 4px;">
                        <input type="file" class="form-control" name="dark_logo" value="1704030980dark_logo.png">
                                                <a href="" data-fancybox="image" data-caption="">
                        <img src="{{url('backend/uploads/setting/'.$data->dark_logo)}}" style=" width: 50px;height:38px; margin-left: 10px !important;
                        padding: 0 !important;">
                        </a> 
                        <input type="hidden" class="form-control" name="hiddendark_logo" placeholder="" value="{{$data['dark_logo']}}">
                                               <div class="invalid-feedback">Invalid form file selected</div>
                     </div>
                    </div>
                    
                    <div class="col-4"> 
                        <label class="form-label" for="formFile1">White Logo</label>
                         <div class="input-group" style="margin-top: 4px;">
                        <input type="file" class="form-control" name="white_logo" value="1704449879white_logo.png">
                                                <a href="" data-fancybox="image" data-caption="">
                        <img src="{{url('backend/uploads/setting/'.$data->white_logo)}}" style=" width: 50px;height:38px; margin-left: 10px !important;
                        padding: 0 !important;">
                        </a>
                        <input type="hidden" class="form-control" name="hiddenwhite_logo" placeholder="" value="{{$data['white_logo']}}">
                                                <div class="invalid-feedback">Invalid form file selected</div>
                     </div>
                    </div>
                    
                    
                                 <div class="col-4">
                        <label class="form-label" for="">Bank Name</label>
                        <input class="form-control" id="" type="text" placeholder="Bank Name" value="{{$data['bank_name']}}" name="bank_name">
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                      
                    <div class="col-4">
                        <label class="form-label" for="">Ifsc Code</label>
                        <input class="form-control" id="" type="text" placeholder="Ifsc Code" value="{{$data['ifsc_code']}}" name="ifsc_code">
                        <div class="invalid-feedback">Please enter your valid </div>
                    </div>
                    
                           <div class="col-4">
                        <label class="form-label" for="">Account Number</label>
                        <input class="form-control" id="" type="text" placeholder="Account Number" value="{{$data['account_number']}}" name="account_number">
                        <div class="invalid-feedback">Please enter your valid </div>
                    </div>
                    
                    
                          <div class="col-4">
                        <label class="form-label" for="">Account Holder Name</label>
                        <input class="form-control" id="" type="text" placeholder="Account Holder Name" value="{{$data['account_holder_name']}}" name="account_holder_name">
                        <div class="invalid-feedback">Please enter your valid </div>
                    </div>
                    
                          <div class="col-4">
                        <label class="form-label" for="">Upi Id</label>
                        <input class="form-control" id="" type="text" placeholder="Upi Id" value="{{$data['upi_id']}}" name="upi_id">
                        <div class="invalid-feedback">Please enter your valid </div>
                    </div>
                    
                          <div class="col-4">
                        <label class="form-label" for="">Barcode File</label>
                        <input class="form-control" id="" type="file" placeholder="Barcode File"  name="barcode_file">
                                         <a href="" data-fancybox="image" data-caption="">
                        <img src="{{url('backend/uploads/setting/'.$data->barcode_file)}}" style=" width: 50px;height:38px; margin-left: 10px !important;
                        padding: 0 !important;">
                        </a>
                        <input type="hidden" class="form-control" name="hiddenbarcode_file" placeholder="" value="{{$data['barcode_file']}}">
                    </div>
                    
                          <div class="col-4">
                        <label class="form-label" for="">WhatsApp Access Token</label>
                        <input class="form-control" id="" type="text" placeholder="WhatsApp Access Token" value="{{$data['access_token']}}" name="access_token">
                        <div class="invalid-feedback">Please enter your valid </div>
                    </div>
                    
                          <div class="col-4">
                        <label class="form-label" for="">WhatsApp Instance Id</label>
                        <input class="form-control" id="" type="text" placeholder="WhatsApp Instance Id" value="{{$data['instance_id']}}" name="instance_id">
                        <div class="invalid-feedback">Please enter your valid </div>
                    </div>
                    
                    
                          <div class="col-4">
                        <label class="form-label" for="">Whatsapp Api Url</label>
                        <input class="form-control" id="" type="text" placeholder="Whatsapp Api Url" value="{{$data['whatsapp_api_url']}}" name="whatsapp_api_url">
                        <div class="invalid-feedback">Please enter your valid </div>
                    </div>
                    
                     <div class="col-6">
                        <label class="form-label" for="">URL</label>
                         <textarea class="form-control" id="" name="url" placeholder="URL" rows="2">{{$data['url']}}</textarea>
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                      
                      <div class="col-6">
                        <label class="form-label" for="">Copyright Details </label>
                         <textarea class="form-control" id="" placeholder="Copyright Details" rows="2" name="copyright_details">{{$data['copyright_details']}}</textarea>
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                      
                    <div class="col-6">
                        <label class="form-label" for="validationCustom01">Address</label>
                         <textarea class="form-control" id="" placeholder="Address" rows="2" name="address">{{$data['address']}}</textarea>
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>

                      <div class="col-6">
                        <label class="form-label" for="">Map Iframe</label>
                         <textarea class="form-control" id="" placeholder="Map Iframe" rows="2" name="map_iframe">{{$data['map_iframe']}}</textarea>
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>

                      <div class="col-6">
                        <label class="form-label" for="">Meta Keywords</label>
                         <textarea class="form-control" id="" placeholder="Meta Keywords" rows="2" name="meta_keywords">{{$data['meta_keywords']}}</textarea>
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                      
                      <div class="col-6">
                        <label class="form-label" for="">Meta Description </label>
                         <textarea class="form-control" id="" placeholder="Meta Description" rows="2" name="meta_description">{{$data['meta_description']}}</textarea>
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                    <div class="col-12">
                        <label class="form-label" for="">Short Description </label>
                         <textarea class="form-control" id="" placeholder="Short Description" rows="2" name="short_description">{{$data['short_description']}}</textarea>
                        <div class="invalid-feedback">Please enter your valid </div>
                      </div>
                      
                      

                     <div class="col-12">
                        <br><button class="btn btn-primary" value="submit" type="submit">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
     </div>

@endsection