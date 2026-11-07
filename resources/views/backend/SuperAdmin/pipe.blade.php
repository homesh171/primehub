@extends('layouts.backend.master')
@section('page_title','Pipe')
@section('content')

<div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Pipe Status</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">


                  <div class="card-body">
                                @include('layouts.flash-message')
                   <form class="row g-3 needs-validation custom-input" method="post" action="{{route('superadmin.updatepipe')}}">
    @csrf
    <div class="col-4">
        <label class="form-label" for="validationCustom02">Agents<span>*</span></label>
        <select class="form-control" name="agent">
            <option value="">--Select Agent--</option>
            @foreach($pipe as $pipes)
            
             <option value="{{$pipes->agentid}}">{{$pipes->agentname}}({{$pipes->agent_id}})</option>
            @endforeach
        </select>
        <span class="mt-1" style="color:red;">@error('agent') {{ $message }} @enderror</span>
    </div>
    
    
        <div class="col-4">
        <label class="form-label" for="validationCustom02">Pipe<span>*</span></label>
        <select class="form-control" name="pipe">
            <option value="">--Select Pipe--</option>
             <option value="Bank2">Bank2</option>
             <option value="Bank3">Bank3</option>
        </select>
        <span class="mt-1" style="color:red;">@error('pipe') {{ $message }} @enderror</span>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-danger">Update Pipe</button>
    </div>
</form>
     
                  </div>
                </div>
              </div>

                 </div>
                 </div>
                 </div>
       @endsection