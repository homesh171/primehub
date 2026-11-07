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
                    <form class="row g-3 custom-input" novalidate="" method="post" action="{{route('aeps.createcourier')}}" id="courierForm">
                        @csrf
                         <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip01">Courier Partner</label>
                        <select class="form-control" id="courier_partner"  required="" name="courier_partner">
                            <option value="" >--Select Courier Partner--</option>
                      @if(session('responseData'))
        @foreach(session('responseData') as $data)
            <option value="{{ $data['code'] }}">{{ $data['code'] }}</option>
        @endforeach
    @endif
                        </select>
                      </div>
                        
                      <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip01">Refid</label>
                        <input class="form-control" id="refid" type="text" value="{{ !empty(session('cusdata')) ? session('cusdata')[5] : ''}}" name="refid" readonly>
                      </div>
                      <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Origin Code</label>
                        <input class="form-control" id="origin_code" type="number" name="origin_code" value="{{ !empty(session('cusdata')) ? session('cusdata')[2] : ''}}" readonly>
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Product Code</label>
                        <input class="form-control" id="product_code" type="text"  name="product_code" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Destination Code</label>
                        <input class="form-control" id="destination_code" type="text" name="destination_code" value="{{ !empty(session('cusdata')) ? session('cusdata')[0] : ''}}" readonly>
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Booking Date</label>
                        <input class="form-control" id="datetime-local" type="date" name="booking_date" value="{{ !empty(session('cusdata')) ? session('cusdata')[1] : ''}}" readonly>
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Booking Time</label>
                        <input class="form-control" id="booking_time"  type="time" name="booking_time" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pcs</label>
                        <input class="form-control" id="pcs" type="number" name="pcs" value="{{ !empty(session('cusdata')) ? session('cusdata')[3] : ''}}">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipment Value</label>
                        <input class="form-control" id="shipment_value" type="number" name="shipment_value" readonly>
                      </div>

					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Actual Weight</label>
                        <input class="form-control" id="actual_weight" type="number" name="actual_weight" value="{{ !empty(session('cusdata')) ? session('cusdata')[4] : ''}}" readonly>
                      </div>
		
					  

					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipment Content</label>
                        <input class="form-control" id="shipment_content" type="text" name="shipment_content" required="">
                      </div>
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Remark</label>
                        <input class="form-control" id="remark" type="text" name="remark" required="">
                      </div>



					  

					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Name</label>
                        <input class="form-control" id="Shipper_name" type="text" name="Shipper_name" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Company Name</label>
                        <input class="form-control" id="shipper_company_name" type="text" name="shipper_company_name" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Contact No</label>
                        <input class="form-control" id="shipper_contect_no" type="text" name="shipper_contect_no" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Email</label>
                        <input class="form-control" id="shipper_email" type="email" name="shipper_email" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Address Line 1</label>
                        <textarea class="form-control" id="shipper_address_line_1" type="text" name="shipper_address_line_1" required=""> </textarea>
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Address Line 2</label>
                        <textarea class="form-control" id="shipper_address_line_2" type="text" name="shipper_address_line_2" required=""> </textarea>
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Address Line 3</label>
                        <textarea class="form-control" id="shipper_address_line_3" type="text" name="shipper_address_line_3" required=""> </textarea>
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper City</label>
                        <input class="form-control" id="shipper_city" type="text" name="shipper_city" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper State</label>
                        <input class="form-control" id="shipper_state" type="text" name="shipper_state" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Country</label>
                        <input class="form-control" id="shipper_country" type="text" name="shipper_country" required="">
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Zip Code</label>
                        <input class="form-control" id="shipper_zip_code" type="number" name="shipper_zip_code" required="">
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Gstin Type</label>
                        <input class="form-control" id="shipper_gstin_type" type="text" name="shipper_gstin_type" required="">
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Shipper Gstin No</label>
                        <input class="form-control" id="shipper_gstin_no" type="number" name="shipper_gstin_no" required="">
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Name</label>
                        <input class="form-control" id="consignee_name" type="text" name="consignee_name" required="">
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consigne Company Name</label>
                        <input class="form-control" id="consigne_company_name" type="text" name="consigne_company_name" required="">
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Contact No</label>
                        <input class="form-control" id="consignee_contact_no" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');" name="consignee_contact_no" required="" maxlength="10">	
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Email</label>
                        <input class="form-control" id="consignee_email" type="email" name="consignee_email" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Address Line 1</label>
                        <textarea class="form-control" id="consignee_address_line_1" type="text" name="consignee_address_line_1" required="">  </textarea>
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Address Line 2</label>
                        <textarea class="form-control" id="consignee_address_line_2" type="text" name="consignee_address_line_2" required="">  </textarea>
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Address Line 3</label>
                        <textarea class="form-control" id="consignee_address_line_3" type="text" name="consignee_address_line_3" required="">  </textarea>
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee City</label>
                        <input class="form-control" id="consignee_city" type="text" name="consignee_city" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee State</label>
                        <input class="form-control" id="consignee_state" type="text" name="consignee_state" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Country</label>
                        <input class="form-control" id="consignee_country" type="text" name="consignee_country" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Zip Code</label>
                        <input class="form-control" id="consignee_zip_code" type="number" name="consignee_zip_code" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Gstin Type</label>
                        <input class="form-control" id="consignee_gstin_type" type="text" name="consignee_gstin_type" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Consignee Gstin No</label>
                        <input class="form-control" id="consignee_gstin_no" type="number" name="consignee_gstin_no" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Name</label>
                        <input class="form-control" id="pickup_address_name" type="text" name="pickup_address_name" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Code</label>
                        <input class="form-control" id="pickup_address_code" type="text" name="pickup_address_code" required="">
                      </div>
					  					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address contact_no</label>
                        <input class="form-control" id="pickup_address_contact_no" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');" type="number" name="pickup_address_contact_no" required="" maxlength="10"  >
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Email</label>
                        <input class="form-control" id="pickup_address_email" type="email" name="pickup_address_email" required="">
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Address Line 1</label>
                        <textarea class="form-control" id="pickup_address_address_line_1" type="text" name="pickup_address_address_line_1" required="">  </textarea>
                      </div>
					  
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Address Line 2</label>
                        <textarea class="form-control" id="pickup_address_address_line_2" type="text" name="pickup_address_address_line_2" required=""> </textarea>
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Address Line 3</label>
                        <textarea class="form-control" id="pickup_address_address_line_3" type="text" name="pickup_address_address_line_3" required=""> </textarea>
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address City</label>
                        <input class="form-control" id="pickup_address_city" type="text" name="pickup_address_city" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02"> Pickup Address State</label>
                        <input class="form-control" id="pickup_address_state" type="text" name="pickup_address_state" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Country</label>
                        <input class="form-control" id="pickup_address_country" type="text" name="pickup_address_country" required="">
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Zip Code</label>
                        <input class="form-control" id="pickup_address_zip_code" type="text" name="pickup_address_zip_code" required="">
                      </div>
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Gstin Type</label>
                        <input class="form-control" id="pickup_address_gstin_type" type="text" name="pickup_address_gstin_type" required="">
                      </div>
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Pickup Address Gstin No</label>
                        <input class="form-control" id="pickup_address_gstin_no" type="number" name="pickup_address_gstin_no" required="">
                      </div>
					  
<div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Width</label>
                        <input class="form-control" id="width" type="text" name="width" required="">
                      </div>
					  
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Height</label>
                        <input class="form-control" id="height" type="text" name="height" required="">
                      </div>
					  
					  
					  
					  <div class="col-md-4 position-relative">
                        <label class="form-label" for="validationTooltip02">Number Of Boxes</label>
                        <input class="form-control" id="number_of_boxes" type="number" name="number_of_boxes" required="">
                      </div>
					  
					
					  
                      <div class="col-12">
                        <button class="btn btn-primary" type="submit" name="submit">Submit form</button>
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
                       $(document).on('change', '#courier_partner', function(e) {
                         e.preventDefault();
                         
                         
                                    var formData = $('#courierForm').serialize();
                                
                                      $.ajax({
                        url: '{{route('aeps.courierpartnerCheck')}}', 
                        method: 'POST',
                        data: { formData,
                            _token: '{{ csrf_token() }}' },
                        success: function(response) {
                       
    
               $('#shipment_value').val(response.curiorname.total);

                        },
error: function(xhr, status, error) {
    

                        }
                    });
                        
                  
              
             
            });
                

                 </script>
                 
                 @endpush

@endsection