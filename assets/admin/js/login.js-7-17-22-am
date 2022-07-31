var add_minutes2 =  function (dt2, minutes2) {
    return new Date(dt2.getTime() + minutes2*60000);
}
function forgetOtpCounter(){
    var count_time5 = add_minutes2(new Date(), 1).toLocaleString('en-US', { timeZone: 'Africa/Johannesburg' });
    var count_time20 = new Date(count_time5).getTime();
    var x20 = setInterval(function() {
    var timezone20 = new Date().toLocaleString('en-US', { timeZone: 'Africa/Johannesburg' });
    var now20 = new Date(timezone20).getTime();
    var distance20 = count_time20 - now20;
    var days20 = Math.floor(distance20 / (1000 * 60 * 60 * 24));
    var hours20 = Math.floor((distance20 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes20 = Math.floor((distance20 % (1000 * 60 * 60)) / (1000 * 60));
    var seconds20 = Math.floor((distance20 % (1000 * 60)) / 1000);
    // Output the result in an element with id="demo"
    document.getElementById("forget_otp_time").innerHTML =  ('0'+minutes20).slice(-2) + ":" + ('0'+seconds20).slice(-2);
    // If the count down is over, write some text 
    if (distance20 < 0) {
        clearInterval(x20);
        $("#otpresendButton").html("Re-Send OTP  <span class='time' id='forget_otp_time'></span>");
        $("#otpresendButton").removeClass("disabled");
    }
}, 1000);
}

function factorloginData(){

  var formData = new FormData($("#twofactForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'admin/twofactor-login',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){
      $('.factorButton').prop('disabled',true);
      $('.factorButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging...');
    },
    success:function(result){

      var data = jQuery.parseJSON(result);
      if(data.status == 1){

        $('.factorButton').html('Logged In');

          toastr.success(data.message, 'Login success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/dashboard'; }  });
      }else {
        $('.factorButton').prop('disabled',false);
        $('.factorButton').html('Login');
        toastr.error(data.message, 'Login failed', {timeOut: 4000,closeButton:true,progressBar:true});
      }
    }
  });
}


$(document).ready(function(){



    $(".factorButton").click(function(){

    var enable = true;
    $( ".validate" ).each(function( index,element ) {
      if($(element).attr('name') == 'email' && $(element).val() != '' && IsEmail($(element).val())==false){
        toastr.error('Please enter valid email', 'Validation failed', {timeOut: 4000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
      if(jQuery.trim($(element).val()) == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 4000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
    });

    if(enable){
      factorloginData();
    }

  }); 

$('#loginForm input').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {

  $('.loginButton').click();
    return false;
 }
});
	

$('#forgotForm input').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {

  $('.forgotButton').click();
    return false;
 }
});

	$(".loginButton").click(function(){
		var enable = true;
		$( ".validate" ).each(function( index,element ) {
			if($(element).val() == ''){
				toastr.error($(element).data('validate-msg'), 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
				enable = false;
				return false;
			}
		});
		if(enable){
			Login();
		}
	});

	$(".forgotButton").click(function(){
		var enable = true;
		$( ".validate_fp" ).each(function( index,element ) {
			if($(element).val() == ''){

				toastr.error('Please enter email or username.', 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
				enable = false;
				return false;
			}
		});
		if(enable){
			sendotp();
		}
	});

	$(".otpButton").click(function(){
		var enable = true;
		$( ".validate_otp" ).each(function( index,element ) {
			if($(element).attr('name') == 'otp' && $(element).val() == ''){
				toastr.error('please enter an OTP.', 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
				enable = false;
				return false;
			}
		});
		if(enable){
			checkotp();
		}
	});

	$(".passwordButton").click(function(){
		var enable = true;
		if($('input[name=new_password]').val() == '' || $('input[name=new_cpassword]').val() == '' || $('input[name=new_password]').val() != $('input[name=new_cpassword]').val()){
			toastr.error('please enter Your new password in both field.', 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
			enable = false;
			return false;
		}
		if(enable){
			change_password();
		}
	});



	    var remember = $.cookie('remember');
        if (remember == 'true') 
        {
            var email = $.cookie('email');
            var password = $.cookie('password');
            // autofill the fields
            $('#email').val(email);
            $('#password').val(password);
        }


    $(".loginButton").click(function() {
        if ($('#remember').is(':checked')) {
            var email = $('#email').val();
            var password = $('#password').val();

            // set cookies to expire in 20*365 days
            $.cookie('email', email, { expires: 20*365 });
            $.cookie('password', password, { expires: 20*365 });
            $.cookie('remember', true, { expires: 20*365 });                
        }
        else
        {
            // reset cookies
            $.cookie('email', null);
            $.cookie('password', null);
            $.cookie('remember', null);
        }
  });

});

$('body').on('click','#forget_ps',function(){
	$('#sign_in_div').hide();
	$('#forgot_ps_div').show();
});

$('body').on('click','#sign_in',function(){
	$('#forgot_ps_div').hide();
	$('#sign_in_div').show();
});

$('body').on('click','#otpresendButton',function(){
	sendotp();
});


function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}

function Login(){
	var formData = new FormData($("#loginForm")[0]);
	$.ajax({
		type: "POST",
		url: BASE_URL +'admin/login',
		data: formData,
		enctype:'multipart/form-data',
		contentType : false,
		processData : false,
		beforeSend:function(){

			$('.loginButton').prop('disabled',true);
			$('.loginButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging...');
		},
		success:function(result){
			
			var data = jQuery.parseJSON(result);
			if(data.status == 1){
				$('.loginButton').html('Logged In');
				toastr.success(data.msg, 'Success', {timeOut: 500,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/dashboard'; }   });
			} else if(data.status == 3) {
					$('.loginButton').html('Logged In');
                toastr.success(data.msg, ' Success', {timeOut: 500,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin'; }  });
			}else{
				$('.loginButton').prop('disabled',false);
				$('.loginButton').html('Login');
				toastr.error(data.msg, 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
			}
		}
	});
}

function sendotp(){
	var formData = new FormData($("#forgotForm")[0]);
	$.ajax({
		type: "POST",
		url: BASE_URL +'admin/sendotp',
		data: formData,
		enctype:'multipart/form-data',
		contentType : false,
		processData : false,
		beforeSend:function(){
			$('.forgotButton').prop('disabled',true);
			$('.forgotButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending OTP...');
		},
		success:function(result){
			var data = jQuery.parseJSON(result);
			if(data.status == 1){
				$('.forgotButton').prop('disabled',false);
				$('.forgotButton').html('Send');
				$('#forgot_ps_div').hide();
				$('#otp_div').show();
				$('#otp_user_id').val(data.data);
				$("#otpresendButton").addClass("disabled");
        		forgetOtpCounter();
				toastr.success(data.msg, 'Success', {timeOut: 1000,progressBar:true,progressBar:true});
			} else {
				$('.forgotButton').prop('disabled',false);
				$('.forgotButton').html('Send');
				toastr.error(data.msg, 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
			}
		}
	});
}


function checkotp(){
	var formData = new FormData($("#otpForm")[0]);
	$.ajax({
		type: "POST",
		url: BASE_URL +'admin/checkotp',
		data: formData,
		enctype:'multipart/form-data',
		contentType : false,
		processData : false,
		beforeSend:function(){
			$('.otpButton').prop('disabled',true);
			$('.otpButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking OTP...');
		},
		success:function(result){
			var data = jQuery.parseJSON(result);
			if(data.status == 1){
				$('.otpButton').prop('disabled',false);
				$('.otpButton').html('Submit');
				$('#otp_div').hide();
				$('#password_div').show();
				$('#ps_user_id').val(data.user_id);
				$('#user_otp').val(data.otp);
				toastr.success(data.msg, 'Success', {timeOut: 1000,progressBar:true,progressBar:true});
			} else {
				$('.otpButton').prop('disabled',false);
				$('.otpButton').html('Submit');
				toastr.error(data.msg, 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
			}
		}
	});
}

function change_password(){
	var formData = new FormData($("#passwordForm")[0]);
	$.ajax({
		type: "POST",
		url: BASE_URL +'admin/change_pass',
		data: formData,
		enctype:'multipart/form-data',
		contentType : false,
		processData : false,
		beforeSend:function(){
			$('.passwordButton').prop('disabled',true);
			$('.passwordButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Changing password...');
		},
		success:function(result){
			var data = jQuery.parseJSON(result);
			if(data.status == 1){
				$('.passwordButton').prop('disabled',false);
				$('.passwordButton').html('Change Password');
				$('#password_div').hide();
				$('#sign_in_div').show();
				toastr.success(data.msg, 'Success', {timeOut: 1000,progressBar:true,progressBar:true});
			} else {
				$('.passwordButton').prop('disabled',false);
				$('.passwordButton').html('Change Password');
				toastr.error(data.msg, 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
			}
		}
	});
}