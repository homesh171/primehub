@extends('layouts.backend.agent.master')
@section('page_title','Billing History')
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
                  <h4>Billing History</h4>
                </div>
                <div class="col-6 text-end">
<img src="{{url('backend/assets/images/BBPS New Logo_1-01.jpg')}}" width="40px"/>
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
                            <th>CustomerName</th>        
                            <th>Transaction ID</th>
                            <th>Amount</th>
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
            'url': "{{route('agent.bbps.billhistoryajexview')}}",
            },
            'columns': [
                { data: 'id' },
                { data: 'customername' },
                { data: 'transactionID' },
                { data: 'Amount' },
                { data: 'Date' },
                { data: 'Receipt' },
                { data: 'status' },
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
    
    
        function printReceipt() {

        document.querySelector('.modal-body h4').innerText = "Payment Receipt";


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