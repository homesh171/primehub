@extends('layouts.backend.agent.master')
@section('page_title','Agent Onboarding Status')
@section('content')

 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Onboarding Status</h4>
                </div>
              </div>
            </div>
          </div>
    <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="card">
                  <div class="card-header border-l-primary">
                    
                    <p class="mt-1 f-m-light">{{$responseData['message']}}</p>
                  </div>
                  <div class="card-body">
                    <p><strong>{{$responseData['is_approved']}}</strong></p>
                  </div>
                </div>
              </div>

            </div>
          </div>
                 </div>
                 
                       @push('scripts')
      
     <script src="{{url('backend/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    @endpush
       @endsection