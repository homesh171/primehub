@extends('layouts.backend.agent.master')
@section('page_title','BBPS')
@section('content')
<style>
span{
color:red;
}

td,tr,table{
padding:0px !important;
}

.shop-box {
width: 58px !important;
height: 58px  !important;
}

.category-title{
font-size:10px;
}

.card .card-header{
padding:10px !important;
}

.card .card-body {
padding:10px !important;
}

@media print {
.no-print {
display: none !important;
}
}


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
<h4>Bharat Bill Payment System</h4>
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

<div class="row">  
<div class="col-sm-6">  
<div class="card p-2">

<div class="row">
@foreach($data as $datas)
<div class="col-sm-2 col-3 mt-1">
<div class="category" data-category="{{$datas->id}}">
<a class="shop-box" href="#">
<img src="{{url('backend/uploads/BbpsCategory/'.$datas->image)}}" alt="{{$datas->category}}" width="30px">
</a>
<span class="m-t-10 category-title f-w-500 text-gray">{{$datas->category}}</span>
</div>
</div>
@endforeach
</div>

</div>

</div>
<div class="col-sm-6">
<div class="card p-2 cateparam" style="display:none;">
<div>

<form id="categoryForm" action="" method="POST" class="needs-validation custom-input"   novalidate=""></form>
<form id="parametersForm" action="" method="POST" class="needs-validation custom-input mt-1"   novalidate=""></form>
<div style="display: none;" id="paymentform" class="mt-1">
<div style="display: none;" id="thirdForm" class="mt-1">
</div>
<form id="payform" action="{{route('agent.bbps.billPayRequest')}}" class="needs-validation custom-input mt-1"   novalidate="" method="POST">@csrf</form>
</div>

<div id="error-message"></div>
<div>


</div>
</div>

</div>
</div>
</div>

</div>
</div>
</div>
</div>

<!-- Tooltips and popovers modal-->
<div class="modal fade" id="tooltipmodal" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Agent PIN</h5>
<button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form id="agentPinForm" method="post">
<div class="mb-3">
<label for="agentPin" class="form-label">Agent PIN:</label>
<input type="password" class="form-control" id="agentPin" name="agentPin">
</div>

<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
<button class="btn btn-primary" type="submit" id="submitAgentPIN">Submit</button>
</div>
</form>
</div>
</div>
</div>
<!--varying modal content-->


<div id="loader" style="display:none;">
  <div class="lds-hourglass"></div>
</div>

@push('scripts')

<script src="{{url('backend/assets/js/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{url('backend/assets/js/dashboard/dashboard_8.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

<script>
@if(session('success'))
swal(
'Success',
'{{ session('success') }}',
'success'
)
@endif


@if(session('error'))
swal(
'Error',
'{{ session('error') }}',
'error'
)
@endif
</script>
<script>
$(document).ready(function(){
var csrfToken = $('meta[name="csrf-token"]').attr('content');

$('.category').click(function(e){
e.preventDefault();
var category = $(this).data('category');

$.ajax({
url: '{{ route('agent.bbps.fetch_category') }}',
method: 'post',
headers: {
'X-CSRF-TOKEN': csrfToken 
},
data: { category: category },
success: function(response) {
$('#categoryForm').empty();
$('#parametersForm').empty();
$('#thirdForm').empty();
$('#payform').css('display', 'none');
$('#paymentform').css('display', 'none');
$('#pay').css('display', 'none');
$('#error-message').empty();
$('#loader').hide();
$('.cateparam').css('display', 'block');
var selectHtml = '<select class="form-control" id="parameterSelect" name="parameter">';
selectHtml += '<option value="">--Select Option--</option>';
response.forEach(function(parameter) {
selectHtml += '<option value="' + parameter.value + '">' + parameter.name + '</option>';
});
selectHtml += '</select>';

$('#categoryForm').append(selectHtml);
},
error: function(xhr, status, error) {

}
});

});

//var billerPaymentExactness;

$(document).on('change', '#parameterSelect', function(e) {
e.preventDefault();
var category = $(this).val();


$.ajax({
url: '{{ route('agent.bbps.fetch_parameters') }}',
method: 'post',
headers: {
'X-CSRF-TOKEN': csrfToken 
},
data: { category: category },
success: function(response) {
$('#parametersForm').empty();
$('#thirdForm').empty();
$('#payform').css('display', 'block');
$('#error-message').css('display', 'none');
$('#paymentform').css('display', 'none');
$('#pay').css('display', 'none');
$('#loader').hide();



$.each(response, function(paramName, paramValue) {



var inputHtml = '<div class="form-group mb-2">';
inputHtml += '<label for="' + paramName + '">' + paramName + ' <span>*</span></label>';


if (paramName === "Plan" || paramName === "Pack Name") {
inputHtml += '<select class="form-control" id="' + paramName + '" name="' + paramName + '" required>';
var planValues = paramValue.plans.split(",");
planValues.forEach(function(plan) {
var trimmedPlan = plan.trim();
inputHtml += '<option value="' + trimmedPlan + '"';
if (paramValue.paramValue && paramValue.paramValue === trimmedPlan) {
inputHtml += ' selected';
}
inputHtml += '>' + trimmedPlan + '</option>';
});
inputHtml += '</select>';
inputHtml += '<input type="hidden" class="form-control" id="billerPaymentModes" name="billerPaymentModes" ';
inputHtml += 'value="' + paramValue.billerPaymentModes + '" ';
inputHtml += 'required';
inputHtml += ' >';
$('#parametersForm').append(inputHtml);
}else {
inputHtml += '<input type="text" class="form-control" id="' + paramName + '" name="' + paramName + '" ';
inputHtml += 'placeholder="' + paramName + '" ';
inputHtml += 'minlength="' + paramValue.minLength + '" ';
inputHtml += 'maxlength="' + paramValue.maxLength + '" ';
// inputHtml += 'pattern="' + paramValue.regEx + '" ';
inputHtml += 'required';
inputHtml += ' >';
inputHtml += '</div>';
inputHtml += '<input type="hidden" class="form-control" id="billerPaymentModes" name="billerPaymentModes" ';
inputHtml += 'value="' + paramValue.billerPaymentModes + '" ';
inputHtml += 'required';
inputHtml += ' >';
$('#parametersForm').append(inputHtml);
}

billerPaymentExactness = paramValue.billerPaymentExactness;
});


if (Object.keys(response).length > 0) {
var hiideninput = '<input type="hidden" name="serviceid" value="' + category + '"/>';
$('#parametersForm').append(hiideninput);

var submitButtonHtml = '<button type="submit" class="btn btn-primary" id="submitbutton">Submit</button>';
$('#parametersForm').append(submitButtonHtml);
}
},
error: function(xhr, status, error) {

}
});
});

$(document).on('submit', '#parametersForm', function(e) {
e.preventDefault(); 
var formValues = $(this).serialize(); 

$('#loader').css('display', 'flex');
$('#error-message').empty();

$.ajax({
url: '{{route('agent.bbps.store_bbpstbillfetch')}}',
method: 'POST',
headers: {
'X-CSRF-TOKEN': csrfToken 
},
data: formValues,
success: function(response) {
    
    
if (response.billerResponse) {
$('#loader').hide();
var billerResponse = response.billerResponse;

if (billerResponse.customerName) {
$('#thirdForm').append('<span>Biller name: ' + billerResponse.customerName + '</span></br>');
}

if (billerResponse.billNumber) {
$('#thirdForm').append('<span>Bill Number: ' + billerResponse.billNumber+ '</span></br>');
}

if (billerResponse.billDate) {
$('#thirdForm').append('<span>Bill Date: ' + billerResponse.billDate+ '</span></br>');
}

if (billerResponse.dueDate) {
$('#thirdForm').append('<span>Due Date: ' + billerResponse.dueDate+ '</span></br>');
}

if (billerResponse.billAmount) {
var billAmount = (parseInt(billerResponse.billAmount) / 100).toFixed(2);
if (billerPaymentExactness === 'Exact') {
$('#payform').html('<span>Amount:</span><input type="number" class="form-control" placeholder="Enter Amount" name="amount" id="amountInput" value="' + billAmount + '" readonly/>');
} else if (billerPaymentExactness === 'Exact and above') {
$('#payform').html('<span>Amount:</span><input type="number" class="form-control" placeholder="Enter Amount" id="amountInput" name="amount" value="" required/>');
} else if (billerPaymentExactness === 'Exact and below') {
$('#payform').html('<span>Amount:</span><input type="number" class="form-control" placeholder="Enter Amount" id="amountInput" name="amount" value="" required/>');
} else {
$('#payform').html('<span>Amount:</span><input type="number" class="form-control" placeholder="Enter Amount" id="amountInput" name="amount" value="" required/>');
}
}

if (response.additionalInfo && response.additionalInfo.info) {
var additionalInfo = response.additionalInfo.info;
for (var i = 0; i < additionalInfo.length; i++) {
var infoName = additionalInfo[i].infoName;
var infoValue = additionalInfo[i].infoValue;
$('#thirdForm').append('<div>' + infoName + ': ' + infoValue + '</div>');
}
}

$(document).on('change', '#amountInput', function(e) {
var amount = $(this).val()*100;
constructXmlRequest(amount);
});

constructXmlRequest(parseInt(billerResponse.billAmount));
var hiideninput = '<input type="hidden" name="_token" value="' + csrfToken + '"/>';
$('#payform').append(hiideninput);
var hiideninput = '<input type="hidden" name="catid" value="' + selectedCategory + '"/>';
$('#payform').append(hiideninput);
var hiideninput = '<input type="hidden" name="billnumber" value="' + response.billerResponse.billNumber + '"/>';
$('#payform').append(hiideninput);
var hiideninput = '<input type="hidden" name="customerName" value="' + response.billerResponse.customerName + '"/>';
$('#payform').append(hiideninput);
var paybutton = '<button type="submit" class="btn btn-primary my-2" id="pay" >PAY</button>';
$('#payform').append(paybutton);
$('#thirdForm').css('display', 'block');
$('#submitbutton').css('display', 'none');
$('#paymentform').css('display', 'block');

function constructXmlRequest(amount) {

let billerPaymentModes = document.getElementById('billerPaymentModes').value;

var xmlRequest = '';
if (response.inputParams && response.inputParams.input) {
xmlRequest += '<inputParams>';
if (Array.isArray(response.inputParams.input)) {
for (var i = 0; i < response.inputParams.input.length; i++) {
var inputParam = response.inputParams.input[i];
xmlRequest += '<input><paramName>' + inputParam.paramName + '</paramName><paramValue>' + inputParam.paramValue + '</paramValue></input>';
}
} else if(response.inputParams.input){
var inputParam = response.inputParams.input;
xmlRequest += '<input><paramName>' + inputParam.paramName + '</paramName><paramValue>' + inputParam.paramValue + '</paramValue></input>';
}else{
xmlRequest += '<input><paramName></paramName><paramValue></paramValue></input>';
}
xmlRequest += '</inputParams>';
}

if(amount){
xmlRequest += '<billerResponse><billAmount>' + (response.billerResponse.billAmount || '') + '</billAmount><billDate>' + (response.billerResponse.billDate || '') + '</billDate><billNumber>' + (response.billerResponse.billNumber || '') + '</billNumber><billPeriod>' + (response.billerResponse.billPeriod || '') + '</billPeriod><customerName>' + (response.billerResponse.customerName || '') + '</customerName><dueDate>' + (response.billerResponse.dueDate || '') + '</dueDate></billerResponse>';
}else{
xmlRequest += '<billerResponse><billAmount>' + (response.billerResponse.billAmount || '') + '</billAmount><billDate>' + (response.billerResponse.billDate || '') + '</billDate><billNumber>' + (response.billerResponse.billNumber || '') + '</billNumber><billPeriod>' + (response.billerResponse.billPeriod || '') + '</billPeriod><customerName>' + (response.billerResponse.customerName || '') + '</customerName><dueDate>' + (response.billerResponse.dueDate || '') + '</dueDate></billerResponse>';
}

if (response.additionalInfo && response.additionalInfo.info) {
xmlRequest += '<additionalInfo>';
if (Array.isArray(response.additionalInfo.info)) {
for (var j = 0; j < response.additionalInfo.info.length; j++) {
var additionalInfo = response.additionalInfo.info[j];
xmlRequest += '<info><infoName>' + additionalInfo.infoName + '</infoName><infoValue>' + additionalInfo.infoValue + '</infoValue></info>';
}
} else if(response.additionalInfo.info) {
var additionalInfo = response.additionalInfo.info;
xmlRequest += '<info><infoName>' + additionalInfo.infoName + '</infoName><infoValue>' + additionalInfo.infoValue + '</infoValue></info>';
}else{
xmlRequest += '<info><infoName></infoName><infoValue></infoValue></info>';
}
xmlRequest += '</additionalInfo>';
}
if(amount){
xmlRequest += '<amountInfo><amount>' + (amount || '') + '</amount><currency>356</currency><custConvFee>0</custConvFee><amountTags></amountTags></amountInfo>';
}else{
xmlRequest += '<amountInfo><amount>' + (response.billerResponse.billAmount || '') + '</amount><currency>356</currency><custConvFee>0</custConvFee><amountTags></amountTags></amountInfo>';
}
if(!billerPaymentModes.includes('Cash')){
      xmlRequest += '<paymentMethod><paymentMode>UPI</paymentMode><quickPay>N</quickPay><splitPay>N</splitPay></paymentMethod>';
xmlRequest += '<paymentInfo><info><infoName>VPA</infoName><infoValue>9921393408@ybl</infoValue></info></paymentInfo>'; 
}else{
 xmlRequest += '<paymentMethod><paymentMode>Cash</paymentMode><quickPay>N</quickPay><splitPay>N</splitPay></paymentMethod>';
xmlRequest += '<paymentInfo><info><infoName>Remarks</infoName><infoValue>Received</infoValue></info></paymentInfo>';
}

$.ajax({
url: '{{route('agent.bbps.encrypt-xml')}}',
type: 'POST',
headers: {
'X-CSRF-TOKEN': csrfToken 
},
data: {xmlRequest: xmlRequest},
success: function(response) {
var encryptedXml = response.encryptedXml;
var hiddenInput = '<input type="hidden" name="xmlRequest" value="' + encryptedXml + '"/>';
$('#payform input[name="xmlRequest"]').remove();
$('#payform').append(hiddenInput);
},
error: function(xhr, status, error) {
console.error('Error encrypting XML data:', error);
}
});



$('#error-message').css('display', 'none');
}
} else if (response.errorInfo) {
$('#loader').hide();
var errorMessage = response.errorInfo.error.errorMessage;
$('#error-message').css('display', 'block');
$('#submitbutton').css('display', 'block');
$('#error-message').text(errorMessage);
} else {
$('#loader').hide();
$('#error-message').css('display', 'block');
$('#submitbutton').css('display', 'none');
$('#error-message').text('Unexpected response structure.');
}
},
error: function(xhr, status, error) {
$('#error-message').css('display', 'block');
$('#submitbutton').css('display', 'none');
$('#error-message').text('An error occurred: ' + error);
$('#loader').hide();
}
});
});


var selectedCategory; 

$(document).on('change', '#parameterSelect', function(e) {
e.preventDefault();
selectedCategory = $(this).val();
});



$('#payform').on('click', '#pay', function(e) {
e.preventDefault();
 var formValid = true;
        $('#payform').find('[required]').each(function() {
            if ($(this).val() === '') {
                formValid = false;
                return false; 
            }
        });
        
        if (formValid) {
            $('#tooltipmodal').modal('show'); 
        } else {
            alert('Please fill out all required fields.'); 
        }
});

$(document).on('submit', '#agentPinForm', function(e) {
e.preventDefault();
var agentPin = $('#agentPin').val();


$.ajax({
url: '{{ route('agent.bbps.agentPinVerify') }}',
type: 'POST',
headers: {
'X-CSRF-TOKEN': csrfToken 
},
data: { agentPin: agentPin },
success: function(response) {
if (response.success) {
$('#submitAgentPIN').text('Please Wait.....');
$('#payform').submit();
} else if (response.error) {
swal({
title: "Error",
text: response.error,
type: "error"
});
}
},
error: function(xhr, status, error) {
console.error('Error:', error);
}
});

});

});

</script>





@endpush
@endsection