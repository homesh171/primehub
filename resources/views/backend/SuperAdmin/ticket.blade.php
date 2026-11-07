@extends('layouts.backend.master')
@section('page_title','All Tickets')
@section('content')

 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>All Tickets</h4>
                </div>
              </div>
            </div>
          </div>
     
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
       
               
                             <div class="col-xl-12">
    
              
                  <div class="card-body">
        

                      @include('layouts.flash-message')
                         <div class="table-responsive theme-scrollbar">
                   <table class="display" id="basic-6" style="width:100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Subject</th>
                            <th>Message</th>
                       
                          </tr>
                        </thead>
                <tbody>
                    @php
                    $i=1;
                    @endphp
                    @foreach($ticket as $data)
                    <tr>
                        <td>{{$i++;}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->number}}</td>
                        <td>{{$data->subject}}</td>
                        <td>{{$data->complain}}</td>
                      
                    </tr>
                    @endforeach
                </tbody>

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
                  @push('scripts')
                  
                  
                  
     <script src="{{url('backend/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    
    @endpush


@endsection