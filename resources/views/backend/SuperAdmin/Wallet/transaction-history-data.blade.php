@extends('layouts.backend.master')
@section('page_title','Agent Data')
@section('content')

<div class="page-body">
<div class="container-fluid">
<div class="page-title">
<div class="row">
<div class="col-6">
<h4>Transaction Data</h4>
</div>
</div>
</div>
</div>
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="card">


<div class="card-body">
<div class="table-responsive">
<table class="table">
<thead>
    <tr>
<th scope="col">Agent Name</th>
<td>{{$txndata->name }}</td>
</tr>
    <tr>
<th scope="col">Agent ID</th>
<td>{{$txndata->agent_id }}</td>
</tr>
<tr>
<th scope="col">Order Id</th>
<td>{{$txndata->order_id }}</td>
</tr>
<tr>
<th scope="col">Amount</th>
<td>{{$txndata->amount }}</td>
</tr>
<tr>
<th scope="col">Payment Mode</th>
<td>{{$txndata->title }}</td>
</tr>
<tr>
<th scope="col">Transaction Id</th>
<td>{{$txndata->tran_id}}</td>
</tr>
@if($txndata->merchant_id != null)
   @if($txndata->merchant_id == 0)
   <tr>
<th scope="col">Merchant Id</th>
<td>SuperAdmin</td>
</tr>
   @else
<tr>
<th scope="col">Merchant Id</th>
<td>{{$txndata->merchant_id }}</td>
</tr>
@endif
@endif
<tr>
    @if($txndata->payment_id != null)
 
<th scope="col">Paymen Id</th>
<td>{{$txndata->payment_id }}</td>
</tr>
@endif
   @if($txndata->providerReferenceId != null)
<tr>
<th scope="col">Provider ReferenceId</th>
<td>{{$txndata->providerReferenceId }}</td>
</tr>
@endif
   @if($txndata->checksum != null)
<tr>
<th scope="col">Checksum</th>
<td>{{$txndata->checksum }}</td>
</tr>
@endif
<tr>
<th scope="col">Ip</th>
<td>{{$txndata->walletip }}</td>
</tr>
  @if($txndata->charge != null)
<tr>
<th scope="col">Charge</th>
<td>₹{{$txndata->charge }}</td>
</tr>
@endif
  @if($txndata->wallet_balance != null)
<tr>
<th scope="col">Wallet Balance</th>
<td>₹{{$txndata->wallet_balance }}</td>
</tr>
@endif
  @if($txndata->wallet_load_charge != null)
<tr>
<th scope="col">Wallet Load Charge</th>
<td>{{$txndata->wallet_load_type == '1' ? '' : '₹'}}{{$txndata->wallet_load_charge }}{{$txndata->wallet_load_type == '1' ? '%' : ''}}</td>
</tr>
@endif

<tr>
<th scope="col">Transaction Time</th>
<td>{{ date('j M Y H:i:s', strtotime($txndata->walletcreate)) }}</td>

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

@endsection