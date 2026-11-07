@extends('layouts.backend.agent.master')
@section('page_title','Payout Data')
@section('content')

<div class="page-body">
<div class="container-fluid">
<div class="page-title">
<div class="row">
<div class="col-6">
<h4>Payout Data</h4>
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
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th scope="col">Order Id</th>
<td>{{$txndata->order_id }}</td>
</tr>
<tr>
<th scope="col">Amount</th>
<td>₹{{$txndata->amount }}</td>
</tr>


<tr>
<th scope="col">Transaction Time</th>
<td>{{ date('j M Y H:i:s', strtotime($txndata->created_at)) }}</td>

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