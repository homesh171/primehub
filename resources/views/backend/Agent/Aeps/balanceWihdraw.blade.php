@extends('layouts.backend.agent.master')
@section('page_title','Balance Withdrawal')
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

.col-form-label span{
    color:red;
}
</style>
<div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Aeps Transaction </h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

<div class="card">
<div class="card-body p-4">
<form class="row justify-content-center" id="myForm">
<div class="col-md-12">
<div class="message">
<p><span class="error">Note:- As per guidelines of NPCI, There would be a gap of 30 minutes for every customer after one successful transactions of AEPS cash withdrawal.</span> <br>
<span class="error">Please try second transaction of same customer after 30 minutes</span></p> 
</div>    
 </div>   
    
<div class="col-md-12">

<div class="row mb-3">
<div class="col-sm-6">
<label class="col-form-label">Transaction Type<span>*</span></label>
</div>
<div class="col-sm-6">
        <select class="form-control" name="transactiontype" id="transactiontype" required>
            <option value="">--Select Type--</option>
            <option value="1" {{Cache::has('transactiontype')?Cache::get('transactiontype')=='1'?'selected':'':''}}>Cash Withdrawal</option>
            <option value="2" {{Cache::has('transactiontype')?Cache::get('transactiontype')=='2'?'selected':'':''}}>Mini Statement</option>
            <option value="3" {{Cache::has('transactiontype')?Cache::get('transactiontype')=='3'?'selected':'':''}}}>Balance Enquiry</option>

        </select>
        <span>@error('bank') {{ $message }} @enderror</span>
</div>
</div>

<div class="row mb-3">
<div class="col-sm-6">
<label class="col-form-label">Select Bank<span>*</span></label>
</div>
<div class="col-sm-6">
 <select class="form-control" name="bank" id="bank" required="">
            <option value="">--Select Bank--</option>
            @if(isset($responseData['banklist']['data']) && is_array($responseData['banklist']['data']))
                @foreach($responseData['banklist']['data'] as $bank)
                    <option value="{{ $bank['iinno'] }}" {{Cache::has('bank')?Cache::get('bank')==$bank['iinno']?'selected':'':''}}>{{ $bank['bankName'] }}</option>
                @endforeach
            @endif
        </select>
        <span>@error('bank') {{ $message }} @enderror</span>
</div>
</div>

<div class="row mb-3">
<div class="col-sm-6">
<label class="col-form-label">Customer Aadhar Number<span>*</span></label>
</div>
<div class="col-sm-6">
 <input class="form-control" id="adhaarnumber" type="number" placeholder="Enter Aadhar Number" name="adhaarnumber" value="{{Cache::has('adhaarnumber')?Cache::get('adhaarnumber'):''}}" required="">
        <span>@error('adhaarnumber') {{ $message }} @enderror</span>
</div>
</div>


<div class="row mb-3">
<div class="col-sm-6">
<label class="col-form-label">Customer Mobile Number<span>*</span></label>
</div>
<div class="col-sm-6">
<input class="form-control" id="mobilenumber" type="number" placeholder="Enter Mobile Number" name="mobilenumber" value="{{Cache::has('mobilenumber')?Cache::get('mobilenumber'):''}}" required="">
        <span>@error('mobilenumber') {{ $message }} @enderror</span>
</div>
</div>


<div class="row mb-3" id="amountcheck" style="display:{{ Cache::has('transactiontype') ? 'block' : 'none' }};;">
<div class="col-sm-6">
<label class="col-form-label">Select Fast Cash<span>*</span></label><br>
<div class="row align-item-center">

   <div class="col">
      <input type="radio" id="cash2" name="cash" value="500" {{Cache::has('cash')?Cache::get('cash')=='500'?'checked':'':''}}>
      <label for="cash2">500</label>
    </div>
    <div class="col">
      <input type="radio" id="cash3" name="cash" value="1000" {{Cache::has('cash')?Cache::get('cash')=='1000'?'checked':'':'checked'}}>
      <label for="cash3">1000</label>
    </div>
    <div class="col">
      <input type="radio" id="cash4" name="cash" value="2000" {{Cache::has('cash')?Cache::get('cash')=='2000'?'checked':'':''}}>
      <label for="cash4">2000</label>
    </div>
    <div class="col">
      <input type="radio" id="cash5" name="cash" value="3000" {{Cache::has('cash')?Cache::get('cash')=='3000'?'checked':'':''}}>
      <label for="cash5">3000</label>
    </div>
    <div class="col">
      <input type="radio" id="cash6" name="cash" value="5000" {{Cache::has('cash')?Cache::get('cash')=='5000'?'checked':'':''}}>
      <label for="cash6">5000</label>
    </div>
    <div class="col">
      <input type="radio" id="cash7" name="cash" value="10000" {{Cache::has('cash')?Cache::get('cash')=='10000'?'checked':'':''}}>
      <label for="cash7">10000</label>
    </div>
  
  </div>
</div>
<div class="col-sm-6">
        <input class="form-control" id="amount" type="number" placeholder="Enter Amount" name="amount" value="{{Cache::has('amount')?Cache::get('amount'):''}}" required="" min="50">

</div>

</div>

<div class="row mb-3">
<div class="col-sm-6">
<label class="col-form-label">Remark<span>*</span></label>
</div>
<div class="col-sm-6">
 <input class="form-control" id="remark" type="text" placeholder="Enter Remark" name="remark" value="{{Cache::has('remark')?Cache::get('remark'):''}}" required="">
        <span>@error('remark') {{ $message }} @enderror</span>
</div>
</div>


<div class="row mb-3">
<div class="col-sm-12">
<label class="col-form-label">Select Device Type<span>*</span></label><br>
<div class="row align-item-center">
<div class="col">    
<input type="radio" id="devicetran" name="device" value="morpho" {{Cache::has('devicetran')?Cache::get('devicetran')=='morpho'?'checked':'':''}}>
  <label for="device1">Morpho</label>
  </div>
  <div class="col">  
  <input type="radio" id="devicetran" name="device" value="mantra" {{Cache::has('devicetran')?Cache::get('devicetran')=='mantra'?'checked':'':''}}>
  <label for="device2">Mantra</label> 
  </div>
  
  </div>
</div>
 <input id="method" type="hidden" value="">
                       <input id="info" type="hidden" value="">
                       <input id="txtPidData" style="width: 100%; height: 150px;" class="form-control" type="hidden" />

    <div class="col-12 text-center mt-5" id="submitButtonHtml11"></div>

</div>

</div>
</form>
</div>
</div>              </div>

                 </div>
                 </div>
                 </div>
<div id="loader" style="display:none;">
  <div class="lds-hourglass"></div>
</div>
                       @push('scripts')
      
     <script src="{{url('backend/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
       <script>
  window.addEventListener('DOMContentLoaded', () => {
    const cashRadios = document.querySelectorAll('input[name="cash"]');
    const amountInput = document.getElementById('amount');

    const checkedRadio = document.querySelector('input[name="cash"]:checked');
    if (checkedRadio) {
      amountInput.value = checkedRadio.value;
    }

    cashRadios.forEach(radio => {
      radio.addEventListener('change', (event) => {
        amountInput.value = event.target.value;
      });
    });
  });
</script>
 
 

<script language="javascript" type="text/javascript">


 

    const captureUrl = @json(url('backend/assets/fingerprint.png'));
    
   $(document).ready(function () {
    const captureUrl = @json(url('backend/assets/fingerprint.png')); 
    const hasTransactionType = @json(Cache::has('transactiontype')); 
    const cachedTransactionType = @json(Cache::get('transactiontype')); 
    const hasAuthTxnId = @json(session()->has('MerAuthTxnId')); 
    const amount = @json(Cache::get('amount')); 
    const isExpired = @json(session()->has('MerAuthTxnId') && now()->gte(session('expires_at'))); 
    
    
 

    function updateSubmitButton() {
        let transactiontype;

        if (hasTransactionType) {
            transactiontype = cachedTransactionType; 
        } else {
            transactiontype = $('#transactiontype').val();
       
        }

  
        $('#amountcheck').toggle(transactiontype === '1');
        
        
        $('#submitButtonHtml11').empty();

        if (transactiontype === '2' || transactiontype === '3') {
        
            const fingerbtn = `
                <button type="button" id="capturetran" style="border: none; background: transparent;">
                    <img src="${captureUrl}" alt="Fingerprint" />
                </button>`;
            $('#submitButtonHtml11').append(fingerbtn);
        } else if (transactiontype === '1') {
            if (!hasAuthTxnId || isExpired) {
    
                const proceedbtn = `
                    <button type="button" id="MerAuthTxnId" style="border: none; background: transparent;" class="btn btn-danger">
                        Proceed
                    </button>`;
                $('#submitButtonHtml11').append(proceedbtn);
            } else {
  
                const fingerbtn = `
                    <button type="button" id="capturetran" style="border: none; background: transparent;">
                        <img src="${captureUrl}" alt="Fingerprint" />
                    </button>`;
                $('#submitButtonHtml11').append(fingerbtn);
            }
        }
    }

    if (hasTransactionType) {
      
        updateSubmitButton();
    } else {
        $('#amountcheck').hide();
    }


    $('#transactiontype').on('change', updateSubmitButton);
});

        

     





    
    



$(document).ready(function() {
    
    
  var transactiontype = $('#transactiontype').val();

            $("#myForm").validate({
      rules: {
                    bank: {
                        required: true
                    },
                    adhaarnumber: {
                        required: true,
                        number: true,
                        minlength:12,
                        maxlength:12
                    },
                    mobilenumber: {
                        required: true,
                        number: true,
                        minlength:10,
                        maxlength:10
                    },
                    remark: {
                        required: true
                    },
                 
                     transactiontype: {
                        required: true
                    }
                },
                messages: {
                    bank: {
                        required: "Please select the bank"
                    },
                    adhaarnumber: {
                        required: "Please enter Aadhar number",
                        number: "Please enter a valid Aadhar number"
                    },
                    mobilenumber: {
                        required: "Please enter mobile number",
                        number: "Please enter a valid mobile number"
                    },
                    remark: {
                        required: "Please enter remark"
                    },
                    transactiontype: {
                        required: "Please select the transaction type"
                    }
                },

            });
        });
        

     
$(document).on('click', '#MerAuthTxnId', function() {
    if ($("#myForm").valid()) {
         if (!$("input[name='device']:checked").val()) {
        alert("Please select a device.");
        return false; 
    }
   if (!$("input[name='amount']").val().trim()) {
    alert("Please Enter a Valid Amount.");
    return false; 
}
    $("#MerAuthTxnIdmodeal").modal('show');
    } else {
    console.log("Form is invalid.");
}
});


$(document).on('click', '#capturetran', function() {


    
                if ($("#myForm").valid()) {
 if (!$("input[name='device']:checked").val()) {
        alert("Please select a device.");
        return false; 
    }
   
                     discoverAvdm();
                    CaptureAvdm();
                } else {
                    console.log("Form is invalid.");
                }
            });

          
                
     var devices;
    var xmlString = '';
    
    $(document).on('change', '#devicetran', function(e) {
        deviceValue = $(this).val();
        performActionBasedOnDevice(deviceValue);
    });

    function performActionBasedOnDevice(deviceValue) {
      
        if (deviceValue == 'mantra') {
            discoverAvdm = function() {
                var GetCustomDomName = "127.0.0.1";
                var SuccessFlag = 0;
                var primaryUrl = "http://" + GetCustomDomName + ":";
                try {
                    var protocol = window.location.href;
                    if (protocol.indexOf("https") >= 0) {
                        primaryUrl = "https://" + GetCustomDomName + ":";
                    }
                } catch (e) {}
                url = "";
                SuccessFlag = 0;
                for (var i = 11100; i <= 11112; i++) {
                    var verb = "RDSERVICE";
                    var res;
                    $.support.cors = true;
                    var httpStaus = false;
                    $.ajax({
                        type: "RDSERVICE",
                        async: false,
                        crossDomain: true,
                        url: primaryUrl + i.toString(),
                        contentType: "text/xml; charset=utf-8",
                        processData: false,
                        cache: false,
                        success: function(data) {
                            httpStaus = true;
                            res = {
                                httpStaus: httpStaus,
                                data: data
                            };
                            $("#txtDeviceInfo").val(data);
                            finalUrl = primaryUrl + i.toString();
                            var $doc = $.parseXML(data);
                            var CmbData1 = $($doc).find('RDService').attr('status');
                            var CmbData2 = $($doc).find('RDService').attr('info');
                            if (new RegExp('\\b' + 'Mantra' + '\\b').test(CmbData2) == true) {
                                MethodCapture = $($doc).find('Interface').eq(0).attr('path');
                                MethodInfo = $($doc).find('Interface').eq(1).attr('path');
                                if (CmbData1 == 'READY' || CmbData1 == 'USED') {
                                    $('#method').val(finalUrl + MethodCapture);
                                    $('#info').val(finalUrl + MethodInfo);
                                    SuccessFlag = 1;
                                    alert("Device detected successfully");
                                    return false;
                                } else if (CmbData1 == 'NOTREADY') {
                                    alert("Device Not Discover");
                                    return false;
                                }
                            }
                        },
                        error: function() {
                            if (i == "8005") {
                                i = "11099";
                            }
                        },
                    });
                    if (SuccessFlag == 1) {
                        break;
                    }
                }
                if (SuccessFlag == 0) {
                    alert("Connection failed Please try again.");
                }
                $("select#ddlAVDM").prop('selectedIndex', 0);
                return res;
            };

            CaptureAvdm = function() {
 
                var DString = '';
                var device = deviceValue;
                var XML = '<?php echo '<?xml version="1.0"?>'; ?><PidOptions ver="1.0"> <Opts fCount="1" fType="2" iCount="0" pCount="0" format="0" pidVer="2.0" timeout="10000" posh="UNKNOWN" env="P" /> ' + DString + '<CustOpts><Param name="mantrakey" value="" /></CustOpts> </PidOptions>';
                var finUrl = $('#method').val();
                $.ajax({
                    type: "CAPTURE",
                    async: false,
                    crossDomain: true,
                    url: finUrl,
                    data: XML,
                    contentType: "text/xml; charset=utf-8",
                    processData: false,
                    success: function(data) {
                        xmlString = data;
                        var $doc = $.parseXML(data);
                        var Message = $($doc).find('Resp').attr('errInfo');
                        var errorcode = $($doc).find('Resp').attr('errCode');
                        if (errorcode == 0) {
                            alert(Message.trim());
                            if (Message.trim() === 'Success.') {
                     
                                  $('#submitButtonHtml11').empty();
                                var submitButtonHtml11 = `<button type="submit" class="btn btn-primary" id="submitbuttondata">Proceed</button>`;
                               
                                $('#submitButtonHtml11').append(submitButtonHtml11);
                               
                            }
                        } else {
                            $('#loaderbala').css("display", "none");
                            alert('Capture Failed');
                            window.location.reload();
                        }
                    },
                    error: function(jqXHR, ajaxOptions, thrownError) {
                        alert(thrownError);
                    },
                });
                return res;
            };

           
        } else if(deviceValue == 'morpho'){
            
            var count=0;
 discoverAvdm = function() {

  var url = "https://127.0.0.1:11100";

  var xhr;
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");

	if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) 
	{
		//IE browser
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		//other browser
		xhr = new XMLHttpRequest();
	}
        
	xhr.open('RDSERVICE', url, true);

	 xhr.onreadystatechange = function () {

    if (xhr.readyState == 4){
            var status = xhr.status;

            if (status == 200) {

             alert("Device detected successfully");
             

            } else {
                
	            console.log(xhr.response);

            }
			}

        };

	 /*setTimeout(function(){
	 xhr.send();},1000);*/
	 xhr.send();
}


CaptureAvdm = function()
{

 var url = "https://localhost:11100/capture";

   var PIDOPTS='<?php echo '<?xml version="1.0"?>'; ?><PidOptions ver=\"1.0\">'+'<Opts fCount=\"1\" fType=\"0\" iCount=\"\" iType=\"\" pCount=\"\" pType=\"\" format=\"0\" pidVer=\"2.0\" timeout=\"10000\" otp=\"\" wadh=\"\" posh=\"\"/>'+'</PidOptions>';
 
 var xhr;
			var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE ");

			if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) 
			{
			
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			} else {
			
				xhr = new XMLHttpRequest();
			}
        
        xhr.open('CAPTURE', url, true);
		xhr.setRequestHeader("Content-Type","text/xml");
		xhr.setRequestHeader("Accept","text/xml");

        xhr.onreadystatechange = function () {

if (xhr.readyState == 4){
            var status = xhr.status;
            //parser = new DOMParser();
            if (status == 200) {
            xmlString =xhr.responseText;
            var test2=xmlString.search("errCode");
			var test6=getPosition(xmlString, '"', 2);
			var test4=test2+9;
			var test5=xmlString.slice(test4, test6);
			if (test5>0)
			{
            alert('Capture timed out');
            window.location.reload();
			}
			else
			{
			    
		
			    
			alert("Captured Successfully");
			$('#submitButtonHtml11').empty();
	           var submitButtonHtml11 = '<button type="submit" class="btn btn-primary" id="submitbuttondata">Proceed</button>';
                                $('#submitButtonHtml11').append(submitButtonHtml11);
                                
			}


            } else 
            {
                
	            console.log(xhr.response);authencity

            }
			}

        };

  xhr.send(PIDOPTS);
     
	
}

function getPosition(string, subString, index) {
  return string.split(subString, index).join(subString).length;
}

function fakeCall(){
 var xhr1;
  var url = 'https://127.0.0.1:11100/getDeviceInfo';

			var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE ");

			if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer, return version number
			{
				//IE browser
				xhr1 = new ActiveXObject("Microsoft.XMLHTTP");
			} else {
				//other browser
				xhr1 = new XMLHttpRequest();
			}
        
        xhr1.open('DEVICEINFO', url, true);
		xhr1.send(); 
		count =1;
		xhr1.onreadystatechange = function () {
		if(xhr1.readyState == 4){
			xhr1.abort();
		}
		};
}
            
        }
    }
    
    
    
     $(document).on('click', '#submitbuttondata', function(e) {
                e.preventDefault();
 var transactiontype = $('#transactiontype').val();
                 $('#loader').show();
                if (navigator.geolocation) {
                    navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
                        if (result.state === 'granted') {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var latitude = position.coords.latitude;
                                var longitude = position.coords.longitude;
                                var xmlData = xmlString;
                                var bank = $('#bank').val();
                                var mobilenumber = $('#mobilenumber').val();
                                var adhaarnumber = $('#adhaarnumber').val();
                                var remark = $('#remark').val();
                                var amount = $('#amount').val();
                                
                                if(transactiontype=='1'){
                                      $.ajax({
                        url: '{{route('aeps.aepsbalancewihdraw')}}', 
                        method: 'POST',
                        data: {
                            latitude: latitude,
                            longitude: longitude,
                            xmlData: xmlData,
                            bank: bank,
                            mobilenumber: mobilenumber,
                            adhaarnumber: adhaarnumber,
                            remark: remark, 
                            amount: amount,
                            _token: '{{ csrf_token() }}' 
                        },
                        success: function(response) {
                       
                            $('#loader').hide();  
   if(response.status==true){
    

      swal({
title: "Success",
text: '₹' + response.amount + ' withdrawal successful',
type: "success"
}).then(function(){
    var link = document.createElement('a');
                                    link.href = response.pdf_url;
                                    link.download = response.filename;
                                    document.body.appendChild(link);
                                    link.click();
                                    document.body.removeChild(link);
                                     window.location.href='{{route('agent.aeps.Wihdrawhistory')}}';

}); 
   }else{
        $('#loader').hide();
swal({
title: "Error",
text: response.message,
type: "error"
}).then(function(){
    
  window.location.reload();
}); ; 
   }                  

                        },
error: function(xhr, status, error) {
    

                        }
                    });
                                }else if(transactiontype=='2'){
                                     $.ajax({
                        url: '{{route('aeps.aepsministatement')}}', 
                        method: 'POST',
                        data: {
                            latitude: latitude,
                            longitude: longitude,
                            xmlData: xmlData,
                            bank: bank,
                            mobilenumber: mobilenumber,
                            adhaarnumber: adhaarnumber,
                            remark: remark, 
                            _token: '{{ csrf_token() }}' 
                        },
                        success: function(response) {
                            
                        $('#loader').hide();
 
  if(response.status==true){
    
      var amount = response.balanceamount;
        $('#message').append(amount); 
        $('#alertmessage').css('display', 'block');
       
      swal({
title: "Success",
text: 'Ministatement generated successfully',
type: "success"
}).then(function(){
  var link = document.createElement('a');
                                    link.href = response.pdf_url;
                                    link.download = response.filename;
                                    document.body.appendChild(link);
                                    link.click();
                                    document.body.removeChild(link);
                                    window.location.reload();
}); 
  }else if(response.errorcode==0009 && response.response_code==0){
      $('#loader').hide();
swal({
title: "Warning",
text: response.message,
type: "warning"
}).then(function(){
  window.location.href='{{route('agent.aeps.agentAuthenticate')}}';
});
  }else{
          $('#loader').hide();
swal({
title: "Error",
text: response.message,
type: "error"
}).then(function(){
    
  window.location.reload();
}); ; 
  }                  

                        },
error: function(xhr, status, error) {
    

                        }
                    });
                                }else if(transactiontype=='3'){
                                       $.ajax({
                        url: '{{route('aeps.aepsbalanceenquiry')}}', 
                        method: 'POST',
                        data: {
                            latitude: latitude,
                            longitude: longitude,
                            xmlData: xmlData,
                            bank: bank,
                            mobilenumber: mobilenumber,
                            adhaarnumber: adhaarnumber,
                            remark: remark, 
                            _token: '{{ csrf_token() }}' 
                        },
                        success: function(response) {
                       
                        $('#loader').hide();
  if(response.status==true){
    
      var amount = response.balanceamount;
        $('#message').append(amount); 
        $('#alertmessage').css('display', 'block');
       
      swal({
title: "Success",
text: 'Your account balance is ₹' + response.balanceamount,
type: "success"
}).then(function(){
  var link = document.createElement('a');
                                    link.href = response.pdf_url;
                                    link.download = response.filename;
                                    document.body.appendChild(link);
                                    link.click();
                                    document.body.removeChild(link);
                                    window.location.reload();
}); 
  }else if(response.errorcode==0009 && response.response_code==0){
         $('#loader').hide();
swal({
title: "Warning",
text: response.message,
type: "warning"
}).then(function(){
  window.location.href='{{route('agent.aeps.agentAuthenticate')}}';
});
  }else{
      $('#loader').hide();  
swal({
title: "Error",
text: response.message,
type: "error"
}).then(function(){
    
  window.location.reload();
}); ; 
  }                  

                        },
error: function(xhr, status, error) {
    

                        }
                    });
                                }
                            });
                        } else {
                            var allowLocation = confirm('Location access is required for this operation. Do you want to allow access? If you deny access, you can enable it in your browser settings.');
                            if (allowLocation) {
                                alert('Please enable location access in your browser settings to proceed.');
                            }
                        }
                    });
                } else {
                    console.error('Geolocation is not supported by this browser.');
                }
            });
                


</script>



@php
    $id = Session::get('AGENT_ID');
@endphp

@if(!Cache::has('AGENTAuthKyc') || 
   (Cache::has('AGENTAuthKycId') && Crypt::decrypt(Cache::get('AGENTAuthKycId')) != $id))
    @include('layouts/backend/agent/aeps_footer')
@endif



@if (!session()->has('MerAuthTxnId') || (session()->has('MerAuthTxnId') && now()->gte(session('expires_at'))))
    @include('layouts.backend.agent.aeps_footer_check')
@endif






    @endpush
       @endsection