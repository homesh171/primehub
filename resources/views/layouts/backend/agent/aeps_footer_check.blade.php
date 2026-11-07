@php
    $id = Session::get('AGENT_ID');
@endphp

@if (!session()->has('MerAuthTxnId') || (session()->has('MerAuthTxnId') && now()->gte(session('expires_at'))))
 <script>

     $(document).on('click', '#back', function() {
          
            $("#MerAuthTxnIdmodeal").modal('hide');  
      })

</script>

@endif

<div class="modal fade" id="MerAuthTxnIdmodeal" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-xl">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agent Merchant Authencity</h5>
     <button class="btn btn-danger" id="back">Back</button>
      </div>
      <div class="modal-body">

<style>
    .error{
        margin:3px 0px !important;
        color:red !important;
    }
    

</style>
<div class="page-body">
      
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card height-equal">

                                 


                  <div class="card-body">
                    <form class="row g-3" id="myForm1">
                        @csrf
                   
                      <div class="col-4">
                        <label class="form-label" for="validationCustom01"><b>Merchant Code</b></label>
                        <p>{{$user['agent_id']}}</p>
                      </div>
     
                        <div class="col-4">
                        <label class="form-label" for="validationCustom01"><b>Mobile Number</b></label>
                        <p>{{$user['mobile_number']}}</p>
                        </div>
                        
                         <div class="col-4">
                        <label class="form-label" for="validationCustom01"><b>User Email</b></label>
                        <p>{{$user['email']}}</p>
                        </div>
                        
                          <div class="col-4">
                        <label class="form-label" for="validationCustom01"><b>UserName</b></label>
                        <p>{{$user['username']}}</p>
                        </div>
                        
                        <div class="col-4">
                        <label class="form-label" for="validationCustom01"><b>Aadhar Number</b></label>
                     <p>{{Str::mask($user['aadhar_number'],'X',0,-4)}}</p>
                        </div>
                        
                                <div class="col-4">
                        <label class="form-label" for="validationCustom01"><b>Device</b><span class="error">*</span></label><br>
                        <input type="radio" class="device123" value="morpho" name="device123" class="me-1" /> &nbsp; Morpho &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" class="device123" value="mantra" name="device123" class="me-1" /> &nbsp; Mantra 
                        </div>
                        
                        <!--        <div class="col-12">-->
                        <!--<label class="form-label" for="validationCustom01">Device<span class="error">*</span></label>-->
                        <!--<select class="form-control" id="device123" required>-->
                        <!--    <option value="">--Select Option--</option>-->
                        <!--    <option value="morpho">Morpho</option>-->
                        <!--    <option value="mantra">Mantra</option>-->
                        <!--</select>-->
                        <!--</div>-->
                        
                        <input id="method1" type="hidden" value="">
                       <input id="info1" type="hidden" value="">
                       <input id="txtPidData1" style="width: 100%; height: 150px;" class="form-control" type="hidden" />
      
               
                      <div class="col-12 text-center" id="submitButtonHtml123" >
         <button type="button" id="capture123" style="border: none; background: transparent;"><img src="{{url('backend/assets/fingerprint.png')}}" /></button>
         
                      </div>
                  
                 
                      
                    </form>
            
                  </div>
                </div>
              </div>

                 </div>
                 </div>
                 </div>
                 

<script language="javascript" type="text/javascript">

$(document).ready(function() {
            $("#myForm1").validate({
      rules: {
                     device: {
                        required: true
                    }
                },
                messages: {
                         device: {
                        required: "Please select the device"
                    }
                },

            });
        });

$("#capture123").click(function() {
      if (!$("input[name='device123']:checked").val()) {
        alert("Please select a device.");
        return false; 
    }

 
                     discoverAvdm();
                    CaptureAvdm();
              
            });
    
    var devices;
    var xmlString = '';
    
    $(document).on('click', '.device123', function(e) {
        deviceValue = $(this).val();
        performActionBasedOnDevice123(deviceValue);
    });

    function performActionBasedOnDevice123(deviceValue) {
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
                                    $('#method1').val(finalUrl + MethodCapture);
                                    $('#info1').val(finalUrl + MethodInfo);
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
                var finUrl = $('#method1').val();
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
                               $('#submitButtonHtml123').empty();
                                var submitButtonHtml123 = '<button type="submit" class="btn btn-primary" id="submitbutton1">Proceed to Authenticate</button>';
                                $('#submitButtonHtml123').append(submitButtonHtml123);
                                $('#capture123').css('display', 'none');
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
			 $('#submitButtonHtml123').empty();
	           var submitButtonHtml123 = '<button type="submit" class="btn btn-primary" id="submitbutton1">Proceed to Authenticate</button>';
                                $('#submitButtonHtml123').append(submitButtonHtml123);
                                $('#capture123').css('display', 'none');
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
    
    
    
     $(document).on('click', '#submitbutton1', function(e) {
                e.preventDefault();
                if (navigator.geolocation) {
                    navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
                        if (result.state === 'granted') {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var latitude = position.coords.latitude;
                                var longitude = position.coords.longitude;
                                var xmlData = xmlString;
                                var bank = $('#bank').val();
                                var adhaarnumber = $('#adhaarnumber').val();
                                var mobilenumber = $('#mobilenumber').val();
                                var amount = $('#amount').val();
                                var remark = $('#remark').val();
                                var cash = $('input[name="cash"]:checked').val();
                                var devicetran = $('.device123').val();
                                var transactiontype = $('#transactiontype').val();
            $.ajax({
                        url: '{{route('aeps.AgentKycmerchant_authencity')}}', 
                        method: 'POST',
                        data: {
                            latitude: latitude,
                            longitude: longitude,
                            xmlData: xmlData,
                            bank: bank,
                            adhaarnumber: adhaarnumber,
                            mobilenumber: mobilenumber,
                            amount: amount,
                            remark: remark,
                            cash: cash,
                            devicetran: devicetran,
                            transactiontype: transactiontype,
                            _token: '{{ csrf_token() }}' 
                        },
                        success: function(response) {
                        //console.log(response)
   if(response.status==true){
       const captureUrl = @json(url('backend/assets/fingerprint.png'));
      swal({
title: "Success",
text: response.message,
type: "success"
}).then(function(){
 $("#MerAuthTxnIdmodeal").modal('hide');
 window.location.reload();
// $('#submitButtonHtml11').empty();
//   var fingerbtn = `<button type="button" id="capturetran" style="border: none; background: transparent;"><img src="${captureUrl}" alt="Fingerprinta"/></button>`;
   
//         $('#submitButtonHtml11').append(fingerbtn);




});
   }else if(response.status==false && response.response_code==0){
       
swal({
title: "Warning",
text: response.message,
type: "warning"
}).then(function(){
   window.location.reload();
});
   }else{
       
       swal({
title: "Error",
text: response.message,
type: "error"
}).then(function(){
  window.location.reload(); 
});
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

 
      </div>

    </div>
  </div>
</div>



