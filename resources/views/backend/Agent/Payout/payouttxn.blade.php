@extends('layouts.backend.agent.master')
@section('page_title','Payout History')
@section('content')

 <div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Payout History</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">

              <div class="col-xl-12">
                                    <div class="card height-equal">
                  <div class="card-body">
                      
                       
                       
         
                   <form class="row g-3 custom-input" method="GET" action="{{ route('agent.payout.payouttxn') }}" id="transactionForm">
                            <div class="col-6">
                                <label class="form-label">From Date</label>
                                <input class="form-control" id="datetime-local"  name="from_date" type="text" placeholder="From Date" value="{{ old('from_date', $old_input['from_date'] ?? '') }}">
                            </div>

                            <div class="col-6">
                                <label class="form-label">To Date</label>
                                <input class="form-control" id="datetime-local"  name="to_date" type="text" placeholder="To Date" value="{{ old('to_date', $old_input['to_date'] ?? '') }}">
                            </div>

                            <div class="col-6">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" value="{{old('status')}}">
                                    <option value="">--Select Status</option>
                                    <option value="success" {{ old('status', $old_input['status'] ?? '') == 'success' ? 'selected' : '' }}>Success</option>
                                     <option value="failed" {{ old('status', $old_input['status'] ?? '') == 'failed' ? 'selected' : '' }}>Failed</option>
                                     <option value="pending" {{ old('status', $old_input['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
     
                               
                            </div>

                            <div class="col-6">
                                <label class="form-label">Transaction ID</label>
                                <input class="form-control" name="transaction_id" type="text"  placeholder="Transaction ID" value="{{ old('transaction_id', $old_input['transaction_id'] ?? '') }}">
                            </div>

                            <div class="col-12">
                                <br><button class="btn btn-primary" type="submit">Search</button>
                                <button class="btn btn-danger" type="button" id="clearForm">Clear</button>
                            </div>
                        </form>
                  </div>
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
                   <table class="display" id="basic-1" style="width:100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <!--<th>Action</th>-->
                          </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            
                            @foreach($txnhistoy as $data)
                          <tr>
                             <td>{{$i++}}</td>
                            <td>{{$data->order_id}}</td>
                            <td>{{$data->transactionid}}</td>
                            <td>₹{{$data->amount}}</td>
                            <td>{{ date('j M Y H:i:s', strtotime($data->created_at)) }}</td>
                            <td>{!! ($data->payout_status)=='Success' ? '<span class="badge rounded-pill badge-success">Success</span>' : '<span class="badge rounded-pill badge-danger">Panding</span>' !!} </td>
                            <td> 
                              <ul class="action"> 
                            <!--    <li class="edit"> <a href="{{ route('superadmin.agent.edit', ['id' => $data->id]) }}"><i class="icon-pencil-alt"></i></a></li>-->
                                <!--<li class="delete"><a href="{{ route('agent.payout.transaction-history-data', ['id' => $data->id]) }}"><i class="icon-eye"></i></a></li>-->
                              </ul>
                            </td>
                          </tr>
                          @endforeach

                         </tbody>

                      </table>
                         <div class="container mt-4">
    <!-- Your paginated data goes here -->

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $txnhistoy->links('pagination::bootstrap-4') }}
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
@push('scripts')
         
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