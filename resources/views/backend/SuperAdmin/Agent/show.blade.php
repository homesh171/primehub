@extends('layouts.backend.master')
@section('page_title','Agent Data')
@section('content')

<div class="page-body">
<div class="container-fluid">
<div class="page-title">
<div class="row">
<div class="col-6">
<h4>Agent Data</h4>
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="card">


<div class="col-xl-12">
<div class="card height-equal">

<div class="card-body">
@include('layouts.flash-message')
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th scope="col">Agent Id</th>
<td>{{$data->agent_id}}</td>
</tr>
<tr>
<th scope="col">UserName</th>
<td>{{$data->username }}</td>
</tr>
<tr>
<th scope="col">Name</th>
<td>{{$data->name}}</td>
</tr>
<tr>
<th scope="col">E-mail Id</th>
<td>{{$data->email}}</td>
</tr>
<tr>
<th scope="col">Mobile Number</th>
<td>{{$data->mobile_number}}</td>
</tr>
<tr>
<th scope="col">WhatsApp Number</th>
<td>{{$data->whatsapp_number}}</td>
</tr>
<tr>
<th scope="col">Aadhar Number</th>
<td>{{$data->aadhar_number}}</td>
</tr>
<tr>
<th scope="col">Pan Number</th>
<td>{{$data->pan_number}}</td>
</tr>
<tr>
<th scope="col">Shop Name</th>
<td>{{$data->shop_name}}</td>
</tr>
<tr>
<th scope="col">Account Number</th>
<td>{{$data->account_number}}</td>
</tr>
<tr>
<th scope="col">Bank Name</th>
<td>{{$data->bank_name}}</td>
</tr>
<tr>
<th scope="col">Ifsc Code</th>
<td>{{$data->ifsc_code}}</td>
</tr>
<tr>
<th scope="col">Account Holder Name</th>
<td>{{$data->ac_holder_name}}</td>
</tr>
<tr>
<th scope="col">Upi ID</th>
<td>{{$data->upi_id}}</td>
</tr>
<tr>
<th scope="col">Date Of Birth</th>
<td>{{$data->age}}</td>
</tr>
<tr>
<th scope="col">Address</th>
<td>{{$data->address}}</td>
</tr>
<tr>
<th scope="col">Country</th>
<td>{{$data->country_name}}</td>
</tr>
<tr>
<th scope="col">State</th>
<td>{{$data->state_name}}</td>
</tr>

<tr>
<th scope="col">City</th>
<td>{{$data->city_name}}</td>
</tr>
<tr>
<th scope="col">PinCode</th>
<td>{{$data->pincode}}</td>
</tr>
<tr>
<th scope="col">Profile Image</th>

<td>

<a href="{{url('backend/uploads/Agent/ProfileImage/'.$data->profile_image)}}" data-fancybox="id_proof">
<img src="{{url('backend/uploads/Agent/ProfileImage/'.$data->profile_image)}}" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 150px; height: 100px;">
</a>
</td>
</tr>
<tr>
<th scope="col">AadharFrontImage</th>
<td>
<a href="{{url('backend/uploads/Agent/AadharFrontImage/'.$data->aadhar_front_image)}}" data-fancybox="id_proof">
<img src="{{url('backend/uploads/Agent/AadharFrontImage/'.$data->aadhar_front_image)}}" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 150px; height: 100px;">
</a></td>
</tr>
<tr>
<th scope="col">AadharBackImage</th>
<td>
<a href="{{url('backend/uploads/Agent/AadharBackImage/'.$data->aadhar_back_image)}}" data-fancybox="id_proof">
<img src="{{url('backend/uploads/Agent/AadharBackImage/'.$data->aadhar_back_image)}}" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 150px; height: 100px;">
</a></td>
</tr>
<tr>
<th scope="col">PanCardImage</th>
<td>
<a href="{{url('backend/uploads/Agent/PanCardImage/'.$data->pan_card_image)}}" data-fancybox="id_proof">
<img src="{{url('backend/uploads/Agent/PanCardImage/'.$data->pan_card_image)}}" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 150px; height: 100px;">
</a>
</td>
</tr>
<tr>
<th scope="col">ShopImages</th>
<td>  @foreach(json_decode($data->shop_photo, true) as $key => $media_gallery)
<a href="{{ url('backend/uploads/Agent/ShopImages/' . $media_gallery) }}" data-fancybox="id_proof">
<img src="{{ url('backend/uploads/Agent/ShopImages/' . $media_gallery) }}" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 150px; height: 100px;">
</a>

@endforeach</td>
</tr>


</thead>

</table>
</div>


</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

@push('scripts')

@endpush

@endsection