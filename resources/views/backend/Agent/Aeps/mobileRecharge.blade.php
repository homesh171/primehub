@extends('layouts.backend.agent.master')
@section('page_title','Mobile Recharge')
@section('content')
<style>
    .error{
        margin:3px 0px !important;
        color:red !important;
    }
    
    
        #loader {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: white;
  z-index: 9999;
  opacity:0.7;
}

.lds-hourglass {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}

.lds-hourglass:after {
  content: " ";
  display: block;
  border-radius: 50%;
  width: 0;
  height: 0;
  margin: 6px;
  box-sizing: border-box;
  border: 26px solid #333;
  border-color: orange transparent orange transparent; 
  animation: lds-hourglass 1.2s infinite;
}

@keyframes lds-hourglass {
  0% {
    transform: rotate(0);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
  }
  50% {
    transform: rotate(900deg);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
  }
  100% {
    transform: rotate(1800deg);
  }
}
</style>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Mobile Recharge</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card height-equal">
                    <div class="card-body">
                        <form class="row g-3 needs-validation custom-input" novalidate="" method="POST" enctype="multipart/form-data" action="{{route('agent.mobileRecharge.dorecharge')}}">
                            @csrf
                            @include('layouts.flash-message')
                         

                            <div class="col-4">
                                <label class="form-label" for="validationCustom01">Mobile Number<span>*</span></label>
                                <input class="form-control" id="mobile_number" type="number" placeholder="Enter Mobile Number" name="mobile_number" value="" required="">
                                
                                <span>@error('mobile_number') {{ $message }} @enderror</span>
                            </div>
                            
                            <div class="col-4">
                                <label class="form-label" for="validationCustom01">Operator<span>*</span></label>
                                <select class="form-control" name="operator" id="operator">
                                    <option value="">--Select Operator--</option>
                                    @if(isset($responseData['data']) && is_array($responseData['data']))
                                        @foreach($responseData['data']  as $operator)
                                            @if($operator['category'] == 'Prepaid')
                                                <option value="{{ $operator['id'] }}">{{ $operator['name'] }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">Please select a valid Operator</div>
                                <span>@error('operator') {{ $message }} @enderror</span>
                            </div>
                            
                            <div class="col-4">
                                <label class="form-label" for="validationCustom01">Plan<span>*</span></label>
                                <select class="form-control" name="amount" id="plans">
                                   
                                </select>
                                <div class="invalid-feedback">Please enter a valid Amount</div>
                                <span>@error('amount') {{ $message }} @enderror</span>
                            </div>

                            <div class="col-12 text-center">
                                <button class="btn btn-danger" type="submit">Proceed</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loader" style="display:none;">
  <div class="lds-hourglass"></div>
</div>
@push('scripts')
<script>

$(document).ready(function(){
 
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $(document).on('change', '#mobile_number', function(e) {
        e.preventDefault();
        var mobile_number = $(this).val();
        
        $('#mobile_number').removeClass('is-invalid');
        $('#mobile_number-error').remove();


        if (mobile_number.length !== 10 || !/^\d+$/.test(mobile_number)) {
           
            $('#mobile_number').addClass('is-invalid');
            $('<div id="mobile_number-error" class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>').insertAfter('#mobile_number');
            return;
        }

    $('#loader').show();
        $.ajax({
            url: '{{ route('agent.mobileRecharge.hlrcheck') }}',
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken 
            },
            data: { mobile_number: mobile_number },
            success: function(response) {
  
                var circle = response.info.circle;
                var op = response.info.operator;
                
                $('#operator option').each(function() {
                    if ($(this).text() == op) {
                        $(this).prop('selected', true);
                    }
                });
         
                $.ajax({
                    url: '{{ route('agent.mobileRecharge.browseplan') }}',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken 
                    },
                    data: { circle: circle, op: op },
                    success: function(browseplanResponse) {
                         $('#loader').hide();
                        $('#plans').empty();
                        $('#plans').append('<option>--Select plan--</option>');
                        $.each(browseplanResponse.info, function(type, plans) {
                            $.each(plans, function(index, plan) {
                                
                                $('#plans').append($('<option>', {
                                    value: plan.rs,
                                    text: plan.rs + ' - ' + plan.desc
                                }));
                            });
                        });
                    },
                    error: function(xhr, status, error) {
                     
                    }
                });
            },
            error: function(xhr, status, error) {
            
            }
        });
    });
});

</script>
@endpush

@endsection
