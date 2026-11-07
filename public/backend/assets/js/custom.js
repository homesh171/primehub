jQuery('#frmLogin').submit(function(e){
jQuery('#login_msg').html("");
e.preventDefault();
jQuery.ajax({
url:'login_process',
data:jQuery('#frmLogin').serialize(),
type:'post',
success:function(result){
if(result.status=="error"){
jQuery('#login_msg').html(result.msg);
}

if(result.status=="success"){
window.location.href='verify'
//jQuery('#frmLogin')[0].reset();
//jQuery('#thank_you_msg').html(result.msg);
}
}
});
});


let timer;
let countdown = 60; // Set the countdown duration in seconds

function startResendTimer() {
    // Disable the button during the countdown
    document.getElementById('resendBtn').disabled = true;

    // Start the countdown
    timer = setInterval(updateTimer, 1000);
}

function updateTimer() {
    const timerElement = document.getElementById('timer');
    
    if (countdown > 0) {
        timerElement.textContent = `Resend in ${countdown} seconds`;
        countdown--;
    } else {
        // Enable the button when the countdown reaches zero
        document.getElementById('resendBtn').disabled = false;
        timerElement.textContent = '';
        
        // Reset countdown for the next attempt
        countdown = 60;
        
        // Stop the timer
        clearInterval(timer);
    }
}



$(document).ready(function() {
    // Attach a click event listener to the button
    $('#resendBtn').click(function() {
      
        $.ajax({
            type: 'POST',
            url: 'ResendOTP',  // Adjust the URL based on your routes
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
            
                swal(
				'Success',
				'OTP Sent Successfully!',
				'success'
			)  
            },
            error: function(error) {
              
                alert('Error sending OTP');  
            }
        });
    });
});


 function validateForm() {
        return true;
    }

    function checkEnter(event) {
        if (event.key === 'Enter') {
            event.preventDefault();

            document.forms[0].submit();
        }
    }
    
    
function getStates() {
    var countryId = document.getElementById('countries').value;

    axios.get('/superadmin/agent/get-states', { params: { country_id: countryId } })
        .then(function (response) {
            var statesSelect = document.getElementById('states');
            var citiesSelect = document.getElementById('cities');

            // Reset states and cities dropdowns
            statesSelect.innerHTML = '<option value="">Select State</option>';
            citiesSelect.innerHTML = '<option value="">Select City</option>';

            response.data.forEach(function (state) {
                var option = document.createElement('option');
                option.value = state.id;
                option.text = state.name;
                statesSelect.appendChild(option);
            });
        })
        .catch(function (error) {
            console.log(error);
        });
}

function getCities() {
    var stateId = document.getElementById('states').value;

    axios.get('/superadmin/agent/get-cities', { params: { state_id: stateId } })
        .then(function (response) {
            var citiesSelect = document.getElementById('cities');

            // Reset cities dropdown
            citiesSelect.innerHTML = '<option value="">Select City</option>';

            response.data.forEach(function (city) {
                var option = document.createElement('option');
                option.value = city.id;
                option.text = city.name;
                citiesSelect.appendChild(option);
            });
        })
        .catch(function (error) {
            console.log(error);
        });
}

    
    /************************************************************/
    jQuery('#agentfrmLogin').submit(function(e){
jQuery('#login_msg').html("");
e.preventDefault();
jQuery.ajax({
url:'login_process',
data:jQuery('#agentfrmLogin').serialize(),
type:'post',
success:function(result){
if(result.status=="error"){
jQuery('#login_msg').html(result.msg);
}

if(result.status=="success"){
window.location.href='verify'
//jQuery('#frmLogin')[0].reset();
//jQuery('#thank_you_msg').html(result.msg);
}
}
});
});
    
    
    
    
    
    
    
    


