@extends('layouts.backend.agent.master')
@section('page_title','Courier Create')
@section('content')

<style>
    .error{
        margin:3px 0px !important;
        color:red !important;
    }
    
 
</style>
<div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Create Courier</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">
       
                            
                  <div class="card-body">
                   <form class="row g-3 " id="myForm">

    @csrf


    <div class="col-4">
        <label class="form-label" for="validationCustom02">Sender Pin Code(Origin Code)<span class="error">*</span></label>
        <input class="form-control" id="origin_code" type="number" placeholder="Enter Pin Code" name="origin_code" required="">
        <span>@error('origin_code') {{ $message }} @enderror</span>
    </div>

    <div class="col-4">
        <label class="form-label" for="validationCustom03">Reciver Pin Code(Destination Code)<span class="error">*</span></label>
        <input class="form-control" id="destination_code" type="number" placeholder="Enter Destination Code" name="destination_code" required="">
        <span>@error('destination_code') {{ $message }} @enderror</span>
    </div>
    
    
       <div class="col-4">
        <label class="form-label" for="validationCustom03">Booking Date<span class="error">*</span></label>
        <input class="form-control" id="datetime-local" type="number" placeholder="Enter Booking Date" name="booking_date" required="" >
        <span>@error('booking_date') {{ $message }} @enderror</span>
    </div>


    <div class="col-4">
        <label class="form-label" for="validationCustom04">No of Pieces<span class="error">*</span></label>
        <input class="form-control" id="pcs" type="number" placeholder="Enter no of pieces" name="pcs" required="">
        <span>@error('pcs') {{ $message }} @enderror</span>
    </div>
    
    
        <div class="col-4">
        <label class="form-label" for="validationCustom04">Weight(Kg)<span class="error">*</span></label>
        <input class="form-control" id="actual_weight" type="number" placeholder="Enter no of pieces" name="actual_weight" required="">
        <span>@error('actual_weight') {{ $message }} @enderror</span>
    </div>
    



    <div class="col-12 text-center" >
                 <button type="button" id="submitbutton" Class="btn btn-success">Proceed</button>
    </div>
</form>

            
                  </div>
                </div>
              </div>

                 </div>
                 </div>
                 </div>
                 
                 @push('scripts')
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
<script language="javascript" type="text/javascript">
                       $(document).on('click', '#submitbutton', function(e) {
                         e.preventDefault();
           
                                var origin_code = $('#origin_code').val();
                                var destination_code = $('#destination_code').val();
                                var datetime = $('#datetime-local').val();
                                var pcs = $('#pcs').val();
                                var actual_weight = $('#actual_weight').val();
                                var customer_code = $('#customer_code').val();
                                

                           $.ajax({
                        url: '{{route('aeps.courierproceed')}}', 
                        method: 'POST',
                        data: {
                            origin_code: origin_code,
                            destination_code: destination_code,
                            booking_date: datetime,
                            pcs: pcs,
                            actual_weight: actual_weight,
                            _token: '{{ csrf_token() }}' 
                        },
                        success: function(response) {
                       
                       if(response.status==true && response.response_code=='1'){
                           
                           window.location.href="{{route('agent.courier.courieprocceddata')}}"
                       }else{
                           alert('Something Went Wrong')
                       }
               

                        },
error: function(xhr, status, error) {
    

                        }
                    });
                        
                  
              
             
            });
                

                 </script>
                 
                 @endpush

@endsection