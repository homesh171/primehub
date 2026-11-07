@extends('layouts.backend.master')
@section('page_title','Agent Permissions')
@section('content')
<style>
    span{
        color:red;
    }
    
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
                  <h4>Agent Permissions</h4>
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
                    <form class="row g-3 needs-validation custom-input"  novalidate="" method="POST"  enctype="multipart/form-data" action="{{url('superadmin/agent/updatepermissions')}}">
                        @csrf
                     <input type="hidden" value="{{$data->id}}" name="id" />

                      
                        <div class="col-6">
                        <label class="form-label" for="validationCustom01">Wallet Limit<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="text" placeholder="Enter Wallet Limit" name="wallet_limit" value="{{$data['wallet_limit']}}" required="">
                        <div class="invalid-feedback">Please enter valid Wallet Limit</div>
                        <span>@error('wallet_limit') {{ $message }} @enderror</span>
                      </div>
                      
                        <div class="col-6">
                        <label class="form-label" for="validationCustom01">Wallet Status<span>*</span></label>
                            <select class="form-control" name="wallet_status">
                            <option value="">--Select Status--</option>

                            <option value="1" {{($data->wallet_status)=='1' ? 'selected' : ''}}>Active</option>
                            <option value="0" {{($data->wallet_status)=='0' ? 'selected' : ''}}>Inactive</option>
                        </select>
                        <div class="invalid-feedback">Please select status</div>
                        <span>@error('name') {{ $message }} @enderror</span>
                      </div>
                      
                        <div class="col-6">
                        <label class="form-label" for="validationCustom01">Wallet Load Charge Type<span>*</span></label>
                                <select class="form-control" name="wallet_load_type">
                            <option value="">--Select Type--</option>

                            <option value="1" {{($data->wallet_load_type)=='1' ? 'selected' : ''}}>Percentage</option>
                            <option value="0" {{($data->wallet_load_type)=='0' ? 'selected' : ''}}>Amount</option>
                        </select>
                        <div class="invalid-feedback">Please select Wallet Load Type</div>
                        <span>@error('wallet_load_type') {{ $message }} @enderror</span>
                      </div>
                      
                        <div class="col-6">
                        <label class="form-label" for="validationCustom01">Wallet Load Charge<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Wallet Load Charge" name="wallet_load_charge" value="{{$data['wallet_load_charge']}}" required="">
                        <div class="invalid-feedback">Please enter valid Wallet Load Charge</div>
                        <span>@error('wallet_load_charge') {{ $message }} @enderror</span>
                      </div>
                      
                                 <div class="col-6">
                        <label class="form-label" for="validationCustom01">Payout Load Charge Type<span>*</span></label>
                                <select class="form-control" name="payout_type">
                            <option value="">--Select Type--</option>

                            <option value="1" {{($data->payout_type)=='1' ? 'selected' : ''}}>Percentage</option>
                            <option value="0" {{($data->payout_type)=='0' ? 'selected' : ''}}>Amount</option>
                        </select>
                        <div class="invalid-feedback">Please select Wallet Load Type</div>
                        <span>@error('payout_type') {{ $message }} @enderror</span>
                      </div>
                      
                        <div class="col-6">
                        <label class="form-label" for="validationCustom01">Payout Limit<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Payout Limit" name="payout_limit" value="{{$data['payout_limit']}}" required="">
                        <div class="invalid-feedback">Please enter valid Payout Limit</div>
                        <span>@error('payout_limit') {{ $message }} @enderror</span>
                      </div>
                      
                        <div class="col-6">
                        <label class="form-label" for="validationCustom01">Payout Default Charges<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Payout Charges" name="default_payout_changes" value="{{$data['default_payout_changes']}}" required="">
                        <div class="invalid-feedback">Please enter valid Payout Default Charges</div>
                        <span>@error('default_payout_changes') {{ $message }} @enderror</span>
                      </div>
                        
                        <div class="col-12">
                        <button class="btn btn-primary" type="submit">Update</button>
                      </div>
                        </form>



 <h4 class="my-3">Agent DMT Charges</h4>

    <form id="myform" method="POST" action="{{ route('superadmin.agent.agentdmtchrageupdate',['id'=>Crypt::encrypt($agent_id)]) }}">
        @csrf
        <table class="table table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <td>Start Price</td>
                    <td>End Price</td>
                    <td>Charge Amount</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="TextBoxContainer">
                @foreach($charges as $index => $charge)
                    <tr>
                        <td>
                            <input type="hidden" name="charges[{{ $index }}][id]" value="{{ $charge->id }}">
                            <input name="charges[{{ $index }}][start_price]" type="number" class="form-control" value="{{ $charge->start_price }}" required=""/>
                        </td>
                        <td>
                            <input name="charges[{{ $index }}][last_price]" type="number" class="form-control" value="{{ $charge->last_price }}" required=""/>
                        </td>
                        <td>
                            <input name="charges[{{ $index }}][charges_amount]" type="number" class="form-control" value="{{ $charge->charges_amount }}" required=""/>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove" data-id="{{ $charge->id }}"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">
                        <button id="btnAdd" type="button" class="btn btn-primary" data-toggle="tooltip" data-original-title="Add more controls">
                            <i class="fa fa-plus"></i>&nbsp; Add&nbsp;
                        </button>
                    </th>
                </tr>
            </tfoot>
        </table>
        <div>
        <input type="hidden" name="deleted_ids" id="deleted_ids" value="">
        <button type="submit" class="btn btn-success mt-2">Save Changes</button>
        </div>
    </form>
    
    
     <h4 class="my-3">Agent Payout Charges</h4>

    <form id="myform" method="POST" action="{{ route('superadmin.agent.agentpayouttchrageupdate',['id'=>Crypt::encrypt($agent_id)]) }}">
        @csrf
        <table class="table table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <td>Start Price</td>
                    <td>End Price</td>
                    <td>Charge Amount</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="TextBoxContainer1">
                @foreach($payoutcharges as $index => $charge)
                
         
                    <tr>
                        <td>
                            <input type="hidden" name="payoutcharges[{{ $index }}][id]" value="{{ $charge->id }}">
                            <input name="payoutcharges[{{ $index }}][start_price]" type="number" class="form-control" value="{{ $charge->start_price }}" required=""/>
                        </td>
                        <td>
                            <input name="payoutcharges[{{ $index }}][last_price]" type="number" class="form-control" value="{{ $charge->last_price }}" required=""/>
                        </td>
                        <td>
                            <input name="payoutcharges[{{ $index }}][charges_amount]" type="number" class="form-control" value="{{ $charge->charges_amount }}" required=""/>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove" data-id="{{ $charge->id }}"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">
                        <button id="btnAdd1" type="button" class="btn btn-primary" data-toggle="tooltip" data-original-title="Add more controls">
                            <i class="fa fa-plus"></i>&nbsp; Add&nbsp;
                        </button>
                    </th>
                </tr>
            </tfoot>
        </table>
        <div>
        <input type="hidden" name="deleted_ids" id="deleted_ids1" value="">
        <button type="submit" class="btn btn-success mt-2">Save Changes</button>
        </div>
    </form>
                            
               
<h4 class="my-3">Add/Update Beneficiary</h4>

<form id="beneficiaryid" method="POST" action="{{route('superadmin.agent.addAgentbeneficiariesaccount')}}">
    @csrf
<input type="hidden" name="account_number" value="{{$data->account_number}}"/>  
<input type="hidden" name="id" value="{{$data->id}}"/> 
<input type="hidden" name="address" value="{{$data->address}}"/>
<input type="hidden" name="ifsc_code" value="{{$data->ifsc_code}}"/>  
<input type="hidden" name="mobile" value="{{$data->mobile_number }}"/>   
<input type="hidden" name="name" value="{{$data->name}}"/>   
<input type="hidden" name="email" value="{{$data->email}}"/>   
<input type="hidden" name="vpa" value="{{$data->upi_id}}"/>  
<button class="btn btn-info" type="submit">Add/Update</button>
</form>
    
    
</div>




                        
                            </div>
              </div>
            </div>
          </div>
             </div>
          </div>
          
          @push('scripts')
                <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>        

<script>
$(function () {
    var cn = {{ $charges->count() }};
    var deletedIds = [];

    $("#btnAdd").bind("click", function () {
        var div = $("<tr />");
        div.html(GetDynamicTextBox("", cn));
        $("#TextBoxContainer").append(div);
        cn = cn + 1;
    });

    $("body").on("click", ".remove", function () {
        var id = $(this).data("id");
        if (id) {
            deletedIds.push(id);
            $('#deleted_ids').val(deletedIds.join(","));
        }
        $(this).closest("tr").remove();
    });

    $('#myform').validate({
        rules: {
            'charges[][start_price]': {
                required: true,
                number: true
            },
            'charges[][last_price]': {
                required: true,
                number: true
            },
            'charges[][charges_amount]': {
                required: true,
                number: true
            }
        }
    });
});

function GetDynamicTextBox(value, cn='') {
    return '<td><input name="charges[' + cn + '][start_price]" type="number" class="form-control" required=""/></td>'
        + '<td><input name="charges[' + cn + '][last_price]" type="number" value="' + value + '" class="form-control" required=""/></td>'
        + '<td><input name="charges[' + cn + '][charges_amount]" type="number" class="form-control" required=""/></td>'
        + '<td><button type="button" class="btn btn-danger remove"><i class="fa fa-trash-o"></i></button></td>';
}



$(function () {
    var cn = {{ $payoutcharges->count() }};
    var deletedIds1 = [];

    $("#btnAdd1").bind("click", function () {
        var div = $("<tr />");
        div.html(GetDynamicTextBox1("", cn));
        $("#TextBoxContainer1").append(div);
        cn = cn + 1;
    });

    $("body").on("click", ".remove", function () {
        var id = $(this).data("id");
        if (id) {
            deletedIds1.push(id);
            $('#deleted_ids1').val(deletedIds1.join(","));
        }
        $(this).closest("tr").remove();
    });

    $('#myform').validate({
        rules: {
            'payoutcharges[][start_price]': {
                required: true,
                number: true
            },
            'payoutcharges[][last_price]': {
                required: true,
                number: true
            },
            'payoutcharges[][charges_amount]': {
                required: true,
                number: true
            }
        }
    });
});

function GetDynamicTextBox1(value, cn='') {
    return '<td><input name="payoutcharges[' + cn + '][start_price]" type="number" class="form-control" required=""/></td>'
        + '<td><input name="payoutcharges[' + cn + '][last_price]" type="number" value="' + value + '" class="form-control" required=""/></td>'
        + '<td><input name="payoutcharges[' + cn + '][charges_amount]" type="number" class="form-control" required=""/></td>'
        + '<td><button type="button" class="btn btn-danger remove"><i class="fa fa-trash-o"></i></button></td>';
}

</script>

 
          
          @endpush

@endsection