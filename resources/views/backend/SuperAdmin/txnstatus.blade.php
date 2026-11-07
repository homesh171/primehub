@extends('layouts.backend.master')
@section('page_title','Transaction Status')
@section('content')

<div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Transaction Status</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">


                  <div class="card-body">
                   <form class="row g-3 needs-validation custom-input" method="post" action="{{route('superadmin.aepstxnstatus')}}">
    @csrf
    <div class="col-4">
        <label class="form-label" for="validationCustom02">Reference Number<span>*</span></label>
        <input class="form-control"  type="number" placeholder="Enter Reference Number" name="reference_number" >
        <span class="mt-1" style="color:red;">@error('reference_number') {{ $message }} @enderror</span>
    </div>
@if(session('responseData'))
    {{-- Display responseData --}}
    <div class="col-8">
        <h6>Transaction Details</h6>
        <span>Amount: ₹{{ session('responseData')['amount'] }}</span><br>
        <span>Transaction Message: 
            @if(session('responseData')['txnstatus'] == 1)
                Success 
            @elseif(session('responseData')['txnstatus'] == 2)
                IN PROCESS 
            @else 
                Failed 
            @endif
        </span><br>
    </div>
@elseif(session('responseDataelse'))
    <div class="col-8">
<span>Transaction Message: {{ session('responseDataelse')['message'] }}</span>
</div>
@endif

    <div class="col-12">
        <button type="submit" class="btn btn-danger">Check Status</button>
    </div>
</form>
     
                  </div>
                </div>
              </div>

                 </div>
                 </div>
                 </div>

       @endsection