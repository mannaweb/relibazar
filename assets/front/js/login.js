/******************* Global variable for cms **************************/
var user_id_after_signup = '';

/******************* Added Chinmoy **************************/
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
    var resendB = $('#resendButton').val();
    if (distance20 < 0) {
        clearInterval(x20);
        $("#otpresendButton").html("Re-Send OTP  <span class='time' id='forget_otp_time'></span>");
        $("#otpresendButton").removeClass("disabled");

        $("#otpresendButtons").html(+resendB+"  <span class='time' id='forget_otp_time'></span>");
        $("#otpresendButtons").removeClass("disabled");
    }
}, 1000);
}
 $('.signupButton').prop('disabled',true);
$( "input" ).on( "click", function() {
  // for a specific one, but you can add a foreach cycle if you need more 
  if($('#chkval').is(":checked")){
     $('.signupButton').prop('disabled',false);
  }else {
       $('.signupButton').prop('disabled',true);
  }
});




function is_numaric(event){
  var keycode = event.keyCode;
  if(keycode > 47 && keycode < 58){
    return true;
  }
  return false;

}

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}

function loginData(){
 
  var formData = new FormData($("#signinForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'user/login',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){
      $('.signinButton').prop('disabled',true);
      $('.signinButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging...');
    },
    success:function(result){

      var data = jQuery.parseJSON(result);
      if(data.status == 1){

        $('.signinButton').html('Logged In');

        var url = document.referrer;
        var param = url.split('/');
        if( param[param.length - 1] && param[param.length - 1] == 'signin' || param[param.length - 1] == 'forget-password'){

          toastr.success(data.message, 'Login success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'user/profile'; }  });
          
        }else{
          toastr.success(data.message, 'Login success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = document.referrer; }  });
        }

        if ($('#remember').is(':checked')) {
          var email = $('#email').val();
          var password = $('#password').val();


          $.cookie('email', email, { expires: 20*365 });
          $.cookie('password', password, { expires: 20*365 });
          $.cookie('remember', true, { expires: 20*365 });    

        }else{

          $.cookie('email', null);
          $.cookie('password', null);
          $.cookie('remember', null);
        }

      } else if(data.status == 3) {
        $('.signinButton').prop('disabled',false);
        $('.signinButton').html('Login');
        $('#LoginMsgDiv').html(data.message);
        user_id_after_signup = data.user_id;
      } else {
        $('.signinButton').prop('disabled',false);
        $('.signinButton').html('Login');
        toastr.error(data.message, 'Login failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}

function loginOTP(){
   $.ajax({
      type: "POST",
      url: BASE_URL +'user/send-login-otp',
      data: {id:user_id_after_signup},
      beforeSend:function(){

      },
      success:function(result){
        var data = jQuery.parseJSON(result);
        if(data.status == 1){
          $('#LoginDiv').html('<div class="sec-page-header"><span>Enter Your OTP</span></div><div class="form-group"><div class="input-group"><span class="icon"><i class="fas fa-fw fa-user"></i></span><input type="number" class="form-control" id="otp" name="otp"></div></div><div class="login-text"><a href="javascript:void(0)" class="btn btn-login checkLoginOTPButton" onclick="checkLoginOTP()">Submit</a><a href="javascript:void(0)" id="otpresendButton" class="btn btn-reset-password">Re-Send OTP | <span class="time" id="forget_otp_time">00:59</span></a></div>');
          $("#otpresendButton").addClass("disabled");
          forgetOtpCounter();
          toastr.success(data.message, 'Email send success', {timeOut: 1000,progressBar:true});
        } else {
          toastr.error(data.message, 'Failed', {timeOut: 2000,closeButton:true,progressBar:true});
        }
      }
    });
}

function loginPhoneOTP(){
   $.ajax({
      type: "POST",
      url: BASE_URL +'user/send-phone-otp',
      data: {id:user_id_after_signup},
      beforeSend:function(){

      },
      success:function(result){
        var data = jQuery.parseJSON(result);
        if(data.status == 1){
          $('#LoginDiv').html('<div class="sec-page-header"><span>Enter Your OTP</span></div><div class="form-group"><div class="input-group"><span class="icon"><i class="fas fa-fw fa-user"></i></span><input type="number" class="form-control" id="otp" name="otp"></div></div><div class="login-text"><a href="javascript:void(0)" class="btn btn-login checkLoginOTPButton" onclick="checkPhoneLoginOTP()">Submit</a><a href="javascript:void(0)" id="otpresendButton" class="btn btn-reset-password">Re-Send OTP | <span class="time" id="forget_otp_time">00:59</span></a></div>');
          $("#otpresendButton").addClass("disabled");
          forgetOtpCounter();
          toastr.success(data.message, 'Successfully send otp your phone number', {timeOut: 1000,progressBar:true});
        } else {
          toastr.error(data.message, 'Failed', {timeOut: 2000,closeButton:true,progressBar:true});
        }
      }
    });
}

function checkLoginOTP(){
  var otp = $('#otp').val();
  if(otp){
    $.ajax({
      type: "POST",
      url: BASE_URL +'user/check-login-otp',
      data: {id:user_id_after_signup,email_verified_code:otp},
      beforeSend:function(){

        $('.checkLoginOTPButton').prop('disabled',true);
        $('.checkLoginOTPButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
      },
      success:function(result){

        var data = jQuery.parseJSON(result);
        if(data.status == 1){
          $('.checkLoginOTPButton').html('Submit');
          toastr.success(data.message, 'Email Verification success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL; }  });
        } else {
          $('.checkLoginOTPButton').prop('disabled',false);
          $('.checkLoginOTPButton').html('Submit');
          toastr.error(data.message, 'Email Verification failed', {timeOut: 2000,closeButton:true,progressBar:true});
        }
      }
    });
  } else {
    toastr.error('Please enter your OTP', 'Email Verification failed', {timeOut: 2000,closeButton:true,progressBar:true});
  }
}

function checkPhoneLoginOTP(){
  var otp = $('#otp').val();
  if(otp){
    $.ajax({
      type: "POST",
      url: BASE_URL +'user/check-phone-login-otp',
      data: {id:user_id_after_signup,phone_verified_code:otp},
      beforeSend:function(){
        $('.checkLoginOTPButton').prop('disabled',true);
        $('.checkLoginOTPButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
      },
      success:function(result){
        var data = jQuery.parseJSON(result);
        if(data.status == 1){
          $('.checkLoginOTPButton').html('Submit');
          toastr.success(data.message, 'Email Verification success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL; }  });
        } else {
          $('.checkLoginOTPButton').prop('disabled',false);
          $('.checkLoginOTPButton').html('Submit');
          toastr.error(data.message, 'Email Verification failed', {timeOut: 2000,closeButton:true,progressBar:true});
        }
      }
    });
  } else {
    toastr.error('Please enter your OTP', 'Email Verification failed', {timeOut: 2000,closeButton:true,progressBar:true});
  }
}




function saveSignupData(){

  var formData = new FormData($("#signupForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'user/signup',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){

      $('.signupButton').prop('disabled',true);
      $('.signupButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Signup Processing...');
    },
    success:function(result){
      var data = jQuery.parseJSON(result);
      if(data.status == 1){
        user_id_after_signup = data.user_id;
        $('.signupButton').html('Signed Up');
        // if(data.email!='' && data.phone!=''){
        //   $('#signupDiv').html('<div class="sec-page-header"><span>Enter Your OTP</span></div><div class="form-group"><div class="input-group"><span class="icon"><i class="fas fa-fw fa-user"></i></span><input type="number" class="form-control" id="otp" name="otp" placeholder="Enter email otp"></div><div class="input-group"><span class="icon"><i class="fas fa-fw fa-user"></i></span><input type="number" class="form-control" id="phone_otp" name="phone_otp" placeholder="Enter phone otp"></div></div><div class="login-text"><a href="javascript:void(0)" class="btn btn-login checkSignupOTPButton" onclick="checkSignupOTP()">Submit</a><a href="javascript:void(0)" id="otpresendButton" class="btn btn-reset-password">Re-Send OTP | <span class="time" id="forget_otp_time">00:59</span></a></div>');
        // }else if(data.email!='' && data.phone==''){
        //   $('#signupDiv').html('<div class="sec-page-header"><span>Enter Your OTP</span></div><div class="form-group"><div class="input-group"><span class="icon"><i class="fas fa-fw fa-user"></i></span><input type="number" class="form-control" id="otp" name="otp" placeholder="Enter email otp"></div></div><div class="login-text"><a href="javascript:void(0)" class="btn btn-login checkSignupOTPButton" onclick="checkSignupOTP()">Submit</a><a href="javascript:void(0)" id="otpresendButton" class="btn btn-reset-password">Re-Send OTP | <span class="time" id="forget_otp_time">00:59</span></a></div>');
        // }        
        // $("#otpresendButton").addClass("disabled");
        //   forgetOtpCounter();
        toastr.success(data.message, 'Signup success', {timeOut: 1000,progressBar:true  });
      } else {
        $('.signupButton').prop('disabled',false);
        $('.signupButton').html('Signup');
        toastr.error(data.message, 'Signup failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}

function checkSignupOTP(){
  var otp = $('#otp').val();
  var phone_otp = $('#phone_otp').val();
  if(otp =='' && phone_otp ==''){
    toastr.error('Please enter your Email  Phone OTP', 'Email Verification failed', {timeOut: 2000,closeButton:true,progressBar:true});
  }else{
    $.ajax({
      type: "POST",
      url: BASE_URL +'user/check-signup-otp',
      data: {id:user_id_after_signup,email_verified_code:otp,phone_verified_code:phone_otp},
      beforeSend:function(){
        $('.checkSignupOTPButton').prop('disabled',true);
        $('.checkSignupOTPButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
      },
      success:function(result){
        var data = jQuery.parseJSON(result);
        if(data.status == 1){
          $('.checkSignupOTPButton').html('Submit');
          toastr.success(data.message, 'Email Verification success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'signin'; }  });
        } else {
          $('.checkSignupOTPButton').prop('disabled',false);
          $('.checkSignupOTPButton').html('Submit');
          toastr.error(data.message, 'Email Verification failed', {timeOut: 2000,closeButton:true,progressBar:true});
        }
      }
    });
  }
}


function tremsVal(){
    if ($('#trems_condition').is(":checked")){
        return true;
    }else{
        return false;
    }
}


function sendotp(){
  var formData = new FormData($("#forgotPassForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'user-password-sendotp',
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
        $('#forgotForm').css('display','none');
        $('#otp_div').css('display','block');
        $('#otp_user_id').val(data.data);
        $("#otpresendButtons").addClass("disabled");
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
    url: BASE_URL +'user-password-checkotp',
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
        $('#forgotForm').css('display','none');
        $('#otp_div').css('display','none');
        $('#password_div').css('display','block');
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
    url: BASE_URL +'user-password-change',
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
         $('#forgotForm').css('display','none');
        $('#otp_div').css('display','none');
        $('#password_div').css('display','none');
        $('#passwordForm').css('display','block');
        toastr.success(data.msg, 'Success', {timeOut: 1000,progressBar:true,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'signin'; }});
      } else {
        $('.passwordButton').prop('disabled',false);
        $('.passwordButton').html('Change Password');
        toastr.error(data.msg, 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}

function saveContactData(){
  var formData = new FormData($("#contactForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'contact-save-data',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){

      $('.contactButton').prop('disabled',true);
      $('.contactButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Sending...');
    },
    success:function(result){

      var data = jQuery.parseJSON(result);
      if(data.status == 1){
        $('.contactButton').html('Saved');
        toastr.success(data.message, 'Send success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.reload(); }  });
      } else {
        $('.contactButton').prop('disabled',false);
        $('.contactButton').html('Send');
        toastr.error(data.message, 'Send failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}


function showPassword(type){

  if(type == 1){
    var x = document.getElementById("new_password");  
  if (x.type === "password") {
    x.type = "text";
    $('#showPassword1').html('<i class="fas fa-fw fa-eye"></i>');
  } else {
    x.type = "password";
    $('#showPassword1').html('<i class="fas fa-fw fa-eye-slash"></i>');
  }
  }else{
    var x = document.getElementById("new_cpassword");  
  if (x.type === "password") {
    x.type = "text";
    $('#showPassword2').html('<i class="fas fa-fw fa-eye"></i>');
  } else {
    x.type = "password";
    $('#showPassword2').html('<i class="fas fa-fw fa-eye-slash"></i>');
  }
  }
  
}

function showPassword1(type){

  if(type == 1){
    var x = document.getElementById("password1");  
  if (x.type === "password") {
    x.type = "text";
    $('#showPassword1').html('<i class="fas fa-fw fa-eye"></i>');
  } else {
    x.type = "password";
    $('#showPassword1').html('<i class="fas fa-fw fa-eye-slash"></i>');
  }
  }else{
    var x = document.getElementById("password");  
  if (x.type === "password") {
    x.type = "text";
    $('#showPassword2').html('<i class="fas fa-fw fa-eye"></i>');
  } else {
    x.type = "password";
    $('#showPassword2').html('<i class="fas fa-fw fa-eye-slash"></i>');
  }
  }
  
}

$(document).ready(function(){
  // var remember = $.cookie('remember');
  // if (remember == 'true'){
  //   var email = $.cookie('email');
  //   var password = $.cookie('password');
  //   $('#email').val(email);
  //   $('#password').val(password);
  // }

  $(".signinButton").click(function(){

    var enable = true;
    $( ".validate" ).each(function( index,element ) {
      if(jQuery.trim($(element).val()) == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
    });

    if(enable){
      loginData();
    }

  }); 

  $(".signupButton").click(function(){
    var enable = true;
    $( ".validate" ).each(function( index,element ) {
      if($(element).attr('name') == 'email' && $(element).val() != '' && IsEmail($(element).val())==false){
        toastr.error('Please Enter Valid Email', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
      if(jQuery.trim($(element).val()) == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
      
      var password = $("#password1").val();
      if (password !='' && password.length < 6) {
        toastr.error('Please enter password minimum 6 character', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;

      }

     

    });
    if(enable){
      saveSignupData();
    }
  }); 

$(".forgotButton").click(function(){
 
    var enable = true;
    $( ".validate" ).each(function( index,element ) {
      if($(element).attr('name') == 'email' && $(element).val() != '' && IsEmail($(element).val())==false){
        toastr.error('Please Enter Valid Email', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }

      if(jQuery.trim($(element).val()) == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
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
      if($(element).val() == ''){
        toastr.error($(element).data('validate-msg'), 'Error', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
    });
    if(enable){
      checkotp();
    }
  });


$('body').on('click','#otpresendButton',function(){
  if($("#otpresendButton").is(".disabled")){ 
    //alert("ohh no");
  }else{
    loginOTP();
  }
});

$('body').on('click','#otpresendButtons',function(){
  if($("#otpresendButtons").is(".disabled")){ 
    //alert("ohh no");
  }else{
    sendotp();
  }
});

$(".passwordButton").click(function(){

    var enable = true;
    $( ".validate_ps" ).each(function( index,element ) {
      
      if(jQuery.trim($(element).val()) == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }

      var password = $("#new_password").val();
      if (password !='' && password.length < 6){
        toastr.error('Please enter minimum 6 character', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
      
      var confirm_password = $("#new_cpassword").val();
      if (confirm_password != password){
        toastr.error('Please enter the same value again', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
    });

    if(enable){
      change_password();
    }

  }); 

$(".contactButton").click(function(){

 
    var enable = true;
    $( ".validate" ).each(function( index,element ) {
      if(jQuery.trim($(element).val()) == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }

      if($(element).attr('name') == 'email' && $(element).val() != '' && IsEmail($(element).val())==false){
        toastr.error('Please Enter Valid Email', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }

     
      var message = $("#message").val();
      if (message !='' && message.length < 100) {
        toastr.error('Please enter minimum 100 character', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;

      }
      
    });
    if(enable){
      if (grecaptcha.getResponse() == ""){
          toastr.error('Google captcha field is required.', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
      } else {
          saveContactData();
      }
      
    }
  });  


});


