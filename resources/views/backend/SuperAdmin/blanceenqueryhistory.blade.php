@extends('layouts.backend.master')
@section('page_title','Balance Enquiry History')
@section('content')
<style>
       @media print {
            .no-print {
                display: none !important;
                background:none !important;
            }
            
               body * {
        visibility: hidden !important;
    }
    .printable-area, .printable-area * {
        visibility: visible !important;
    }
        }
</style>

 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Balance Enquiry History</h4>
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
                         <div class="">
                   <table class="display" id="basic21" style="width:100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Agent ID</th>
                            <th>Reference ID</th>
                            <th>Aadhar Number</th>
                             <th>Date</th>
                             <th>Receipt</th>
                            <th>Status</th>
                          </tr>
                        </thead>

                      </table>
        <div class="container mt-4">
    <!-- Your paginated data goes here -->

    <!-- Pagination Links -->

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
            'url': "{{route('superadmin.viewblanceenqueryhistory')}}",
            },
            'columns': [
                { data: 'id' },
                { data: 'AgentID' },
                { data: 'referenceno' },
                { data: 'adhaarnumber' },
                { data: 'Date' },
                { data: 'Receipt' },
                { data: 'status' },
            ]
        });
    });
</script>
         
                           
<script>



    
    
        function printReceipt() {

        var buttons = document.querySelectorAll('.no-print');
        buttons.forEach(function(button) {
            button.style.display = 'none';
        });

        window.print();

        document.querySelector('.modal-body h4').innerText = "Payment Successful";
        buttons.forEach(function(button) {
            button.style.display = 'block';
        });
    }

</script>

                  
                  @endpush

@endsection