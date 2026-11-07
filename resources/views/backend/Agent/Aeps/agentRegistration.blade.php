@extends('layouts.backend.agent.master')
@section('page_title','Agent Registration')
@section('content')

<div class="page-body">
               <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Agent Registration</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">


                                 


                  <div class="card-body">
                    <form class="row g-3 needs-validation custom-input">
                        @csrf
                   
                      <div class="col-4">
                        <label class="form-label" for="validationCustom01">Merchant Code<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="text" placeholder="Enter Merchant Code" name="amount" value="{{$user['agent_id']}}" required="" disabled>
                        <span>@error('amount') {{ $message }} @enderror</span>
                      </div>
     
                        <div class="col-4">
                        <label class="form-label" for="validationCustom01">Mobile Number<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Mobile Number" name="mobile_number" value="{{$user['mobile_number']}}" required="" disabled>
                        <span>@error('amount') {{ $message }} @enderror</span>
                        </div>
                        
                        
                        <div class="col-4">
                        <label class="form-label" for="validationCustom01">Aadhar Number<span>*</span></label>
                        <input class="form-control" id="validationCustom01" type="number" placeholder="Enter Aadhar Number" name="aadhar_number" value="{{$user['aadhar_number']}}" required="" disabled>
                        <span>@error('amount') {{ $message }} @enderror</span>
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
      
               
                      <div class="col-12 text-center" id="submitButtonHtml" >
         <button type="button" onclick="discoverAvdm(); CaptureAvdm();" id="capture" style="border: none; background: transparent;"><img src="{{url('backend/assets/fingerprint.png')}}" width="20%"/></button>
         
                      </div>
                  
                 
                      
                    </form>
            
                  </div>
                </div>
              </div>

                 </div>
                 </div>
                 </div>
                 
@push('scripts')
<script src="{{url('backend/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('backend/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

<script language="javascript" type="text/javascript">
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
                                var submitButtonHtml = '<button type="submit" class="btn btn-primary" id="submitbutton">Proceed to Registration</button>';
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
	           var submitButtonHtml = '<button type="submit" class="btn btn-primary" id="submitbutton">Proceed to Registration</button>';
                                $('#submitButtonHtml').append(submitButtonHtml);
                                $('#capture').css('display', 'none');
			}


            } else 
            {
                
	            console.log(xhr.response);

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
                if (navigator.geolocation) {
                    navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
                        if (result.state === 'granted') {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var latitude = position.coords.latitude;
                                var longitude = position.coords.longitude;
                                var xmlData = xmlString;
                                $.ajax({
                                    url: '{{route('aeps.AgentKycRegistration')}}',
                                    method: 'POST',
                                    data: {
                                        latitude: latitude,
                                        longitude: longitude,
                                        xmlData: xmlData,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        if (response.status == true) {
                                            swal({
                                                title: "Success",
                                                text: response.message,
                                                type: "success"
                                            }).then(function() {
                                                window.location.reload();
                                            });
                                        } else {
                                            swal({
                                                title: "Error",
                                                text: response.message,
                                                type: "error"
                                            }).then(function() {
                                                window.location.reload();
                                            });
                                        }
                                    },
                                    error: function() {}
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
@endpush
       @endsection