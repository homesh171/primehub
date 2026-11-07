@extends('layouts.backend.agent.master')
@section('page_title','Mini Statement')
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
                  <h4>Mini Statement</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">


                  <div class="card-body">
                   <form class="row g-3" id="myForm">

    @csrf

    <div class="col-4">
        <label class="form-label" for="validationCustom01">Bank<span>*</span></label>
        <select class="form-control" name="bank" id="bank" required>
            <option value="">--Select Bank--</option>
            @if(isset($responseData['banklist']['data']) && is_array($responseData['banklist']['data']))
                @foreach($responseData['banklist']['data'] as $bank)
                    <option value="{{ $bank['iinno'] }}">{{ $bank['bankName'] }}</option>
                @endforeach
            @endif
        </select>
        <span>@error('bank') {{ $message }} @enderror</span>
    </div>

    <div class="col-4">
        <label class="form-label" for="validationCustom02">Aadhar Number<span>*</span></label>
        <input class="form-control" id="adhaarnumber" type="number" placeholder="Enter Aadhar Number" name="adhaarnumber" required=""  >
        <span>@error('adhaarnumber') {{ $message }} @enderror</span>
    </div>

    <div class="col-4">
        <label class="form-label" for="validationCustom03">Mobile Number<span>*</span></label>
        <input class="form-control" id="mobilenumber" type="number" placeholder="Enter Mobile Number" name="mobilenumber" required="">
        <span>@error('mobilenumber') {{ $message }} @enderror</span>
    </div>

    <div class="col-4">
        <label class="form-label" for="validationCustom04">Remark<span>*</span></label>
        <input class="form-control" id="remark" type="text" placeholder="Enter Remark" name="remark" required="">
        <span>@error('remark') {{ $message }} @enderror</span>
    </div>

                  <div class="col-4">
                        <label class="form-label" for="validationCustom01">Device<span>*</span></label>
                        <select class="form-control" id="device" required>
                            <option value="">--Select Option</option>
                            <option value="morpho">Morpho</option>
                            <option value="mantra">Mantra</option>
                        </select>
                        </div>
                        
                        <input id="method" type="hidden" value="">
                       <input id="info" type="hidden" value="">
                       <input id="txtPidData" style="width: 100%; height: 150px;" class="form-control" type="hidden" />

    <div class="col-12 text-center" id="submitButtonHtml">
<button type="button"  id="capture" style="border: none; background: transparent;"><img src="{{url('backend/assets/fingerprint.png')}}" width="20%"/></button>
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
      
     <script src="{{url('backend/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
<script language="javascript" type="text/javascript">

$(document).ready(function() {
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
                     device: {
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
                         device: {
                        required: "Please select the device"
                    }
                },

            });
        });

$("#capture").click(function() {
                if ($("#myForm").valid()) {
                     discoverAvdm();
                    CaptureAvdm();
                } else {
                    console.log("Form is invalid.");
                }
            });
    
    var devices;
    var xmlString = '';
    
    $(document).on('change', '#device', function(e) {
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
                                var submitButtonHtml = '<button type="submit" class="btn btn-primary" id="submitbutton">Proceed to Mini Statement</button>';
                                $('#submitButtonHtml').append(submitButtonHtml);
                                $('#capture').css('display', 'none');
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
	           var submitButtonHtml = '<button type="submit" class="btn btn-primary" id="submitbutton">Proceed to Mini Statement</button>';
                                $('#submitButtonHtml').append(submitButtonHtml);
                                $('#capture').css('display', 'none');
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
    
    
    
     $(document).on('click', '#submitbutton', function(e) {
                e.preventDefault();
                $('#loader').show();
                if (navigator.geolocation) {
                    navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
                        if (result.state === 'granted') {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var latitude = position.coords.latitude;
                                var longitude = position.coords.longitude;
                                var xmlData = xmlString;
                                var mobilenumber = $('#mobilenumber').val();
                                var adhaarnumber = $('#adhaarnumber').val();
                                var remark = $('#remark').val();
                                var bank = $('#bank').val();
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

@if(!Cache::has('AGENTAuthKyc'))
@include('layouts/backend/agent/aeps_footer')
@elseif(Cache::has('AGENTAuthKycId') && Crypt::decrypt(Cache::get('AGENTAuthKycId')) != $id)
@include('layouts/backend/agent/aeps_footer')
@endif
    @endpush
       @endsection