@extends('layouts.backend.master')
@section('page_title','index')
@section('content')

 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Agent List</h4>
                </div>
                <div class="col-6 text-end">
                <a class="btn btn-primary mb-2" href="{{route('superadmin.agent.create')}}"><i class="fa fa-plus-circle" style="margin-right: 0;" aria-hidden="true"></i></a>
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
                   <table class="display" id="basic21" style="width:100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Agent ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Wallet</th>
                            <th>Master Status</th>
                            <th>Action</th>
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
                  
                  @push('scripts')
                  
    <script src="{{url('backend/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
 
    
    <script>
    $(document).ready(function(){
        

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });  
        $('#basic21').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'POST',
            'ajax': {
            'url': "{{route('superadmin.agent.agentajexview')}}",
            },
            'columns': [
                { data: 'id' },
                { data: 'agentid' },
                { data: 'name' },
                { data: 'email' },
                { data: 'mobile' },
                { data: 'wallet' },
                { data: 'status' },
    			{ data : 'action' },
            ]
        });

$(document).on('change', '.js-switch', function () {
    

        let status = $(this).prop('checked') === true ? 0 : 1;
        let userId = $(this).data('id');

        $.ajax({
            type: "post",
            dataType: "json",
            url: "{{route('superadmin.agent.status')}}",
            data: {'kyc_status': status, 'id': userId},
            success: function (data) {
                console.log("AJAX Success: ", data);
                alert(data.message);
            },
            error: function (error) {
                console.log("AJAX Error: ", error);
                alert("Error occurred!");
            }
        });
    });
});


    
</script>
    
                  @endpush

@endsection