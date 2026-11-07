@extends('layouts.backend.master')
@section('page_title','Payment Requset History')
@section('content')

<style>
    #statusbadge{cursor: pointer;
}
</style>

 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Payment Requset History</h4>
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
                            <th>Order ID</th>
                            <th>Mobile Number</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                      </table>
        <div class="container mt-4">

</div>
                    </div>
                  
                      
                  </div>
                  </div>
           
                  </div>
                  </div>
  
                  </div>
                  </div>
                  </div>
                  <!-- Modal for changing status -->

<!-- Modal -->
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
            'url': "{{route('superadmin.wallet.payment_requset_historyajexview')}}",
            },
            'columns': [
                { data: 'id' },
                { data: 'oredrid' },
                { data: 'payment_request_id' },
                { data: 'transactionID' },
                { data: 'Amount' },
                { data: 'Date' },
                { data: 'status' },
    			{ data : 'action' },
            ]
        });



    });
    
    
    
    
</script>
         
                           
<script>
function isAnyFieldNotEmpty() {
        var inputs = document.getElementsByClassName('form-control');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].value.trim() !== '') {
                return true;
            }
        }
        return false;
    }

    document.addEventListener('DOMContentLoaded', function() {
  
        var clearFormButton = document.getElementById('clearForm');
        clearFormButton.disabled = !isAnyFieldNotEmpty();
        
   
        clearFormButton.addEventListener('click', function() {
     
            var inputs = document.getElementsByClassName('form-control');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }
            
  
            document.getElementById('transactionForm').submit();
        });

        var formInputs = document.getElementsByClassName('form-control');
        for (var i = 0; i < formInputs.length; i++) {
            formInputs[i].addEventListener('input', function() {
                clearFormButton.disabled = !isAnyFieldNotEmpty();
            });
        }
    });

</script>

                  
                  @endpush

@endsection