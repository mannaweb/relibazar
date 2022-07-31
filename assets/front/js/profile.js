
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
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
        $(".resend").html("Re-Send OTP  <span class='time' id='forget_otp_time'></span>");
        $(".resend").removeClass("disabled");
    }
}, 1000);
}

function saveChangeEmail2(email){
  $.ajax({
    type: "POST",
    url: BASE_URL +'email-verify',
    data: {chnage_email:email,type:1},
    beforeSend:function(){
      $('.changeEmail2').prop('disabled',true);
      $('.changeEmail2').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

    },

    success:function(result){
      var data = jQuery.parseJSON(result);

      if(data.status == 1){
        $('.changeEmail2').html('Not Verified');
         toastr.success(data.message, 'Save success', {timeOut: 1000,progressBar:true});
          $('#new_email').val(data.new_email);
          $('#emailform').hide();
          $('#otpform').show();
        $('#emailchange').modal('show');
      } else {
        $('.changeEmail2').prop('disabled',false);
        $('.changeEmail2').html('Not Verified');
        toastr.error(data.message, 'Save failed', {timeOut: 2000,progressBar:true});

      }
    }

  });

}

function saveChangeEmail(){
  var formData = new FormData($("#manageEmail")[0]);
  formData.append('type',2);
  $.ajax({
    type: "POST",
    url: BASE_URL +'email-verify',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){
      $('.changeEmail').prop('disabled',true);
      $('.changeEmail').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

    },

    success:function(result){
      var data = jQuery.parseJSON(result);
   
      if(data.status == 1){
        $('.changeEmail').html('Resend');
         toastr.success(data.message, 'Save success', {timeOut: 1000,progressBar:true});
          $('#new_email').val(data.new_email);
          $('#emailform').hide();
          $('#otpform').show();
      } else {
        $('.changeEmail').prop('disabled',false);
        $('.changeEmail').html('Send');
        toastr.error(data.message, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});

      }
    }

  });

}

function saveChangePhone2(phone){
  var not_verified = $('#not_verified').val();
  $.ajax({
    type: "POST",
    url: BASE_URL +'phone-verify',
    data: {new_phone:phone,type:1},
    beforeSend:function(){
      $('.changePhone2').prop('disabled',true);
      $('.changePhone2').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
    },

    success:function(result){
      var data = jQuery.parseJSON(result);
      if(data.success == 'true'){
        $('.changePhone2').html(not_verified);
         toastr.success(data.msg, 'Save success', {timeOut: 1000,progressBar:true});
          $('#new_phone').val(data.new_phone);
          $('#phoneform').hide();
          $('#phoneotpform').show();
          $('#phonechange').modal('show');
      }else{
        $('.changePhone2').prop('disabled',false);
        $('.changePhone2').html(not_verified);
        toastr.error(data.msg, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }

    }

  });

}


function saveChangePhone(){
  var formData = new FormData($("#managePhone")[0]);
  formData.append('type',2);
  $.ajax({
    type: "POST",
    url: BASE_URL +'phone-verify',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){
      $('.changeEmail').prop('disabled',true);
      $('.changeEmail').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
    },

    success:function(result){
      var data = jQuery.parseJSON(result);
      if(data.success == 'true'){
        $('.changeEmail').html('Resend');
         toastr.success(data.msg, 'Save success', {timeOut: 1000,progressBar:true});
          $('#new_phone').val(data.new_phone);
          $('#phoneform').hide();
          $('#phoneotpform').show();
      }else{
        $('.changeEmail').prop('disabled',false);
        $('.changeEmail').html('Send');
        toastr.error(data.msg, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }

    }

  });

}


function checkOTP(){
  var formData = new FormData($("#manageOtp")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'otp-change-email',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){
      $('.OTP').prop('disabled',true);
      $('.OTP').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

    },
    success:function(result){
      var data = jQuery.parseJSON(result);
      if(data.status == 1){
        $('.OTP').html('Submit');
          toastr.success(data.message, 'Save success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'user/profile'; }  });
         
      } else {
        $('.OTP').prop('disabled',false);
        $('.OTP').html('Submit');
        toastr.error(data.message, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}



function checkPhoneOTP(){
  var formData = new FormData($("#managephoneOtp")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'otp-check-phone',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){
      $('.OTP').prop('disabled',true);
      $('.OTP').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

    },

    success:function(result){
      var data = jQuery.parseJSON(result);
      if(data.status == 1){
        $('.OTP').html('Send');
          toastr.success(data.message, 'Save success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'user/profile'; }  });
         
      } else {
        $('.OTP').prop('disabled',false);
        $('.OTP').html('Send');
        toastr.error(data.message, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}




function saveData(){
  var formData = new FormData($("#manageForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'edit-profile-save',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){
      $('.saveButton').prop('disabled',true);
      $('.saveButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

    },

    success:function(result){
      var data = jQuery.parseJSON(result);
      if(data.status == 1){
        $('.saveButton').html('Saved');
        toastr.success(data.message, 'Save success');

      } else {
        $('.saveButton').prop('disabled',false);
        $('.saveButton').html('Save');
        toastr.error(data.message, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}


function saveAccountButton(){
  var formData = new FormData($("#manageAccountForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'user-account-save',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){
      $('.saveButton').prop('disabled',true);
      $('.saveButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

    },

    success:function(result){
      var data = jQuery.parseJSON(result);
      if(data.status == 1){
        $('.saveButton').html('Saved');
        toastr.success(data.message, 'Save success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'user/profile'; }  });

      } else {
        $('.saveButton').prop('disabled',false);
        $('.saveButton').html('Save');
        toastr.error(data.message, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}

function showPass(type){

  if(type == 1){
    var x = document.getElementById("oldpassword");  
  if (x.type === "password") {
    x.type = "text";
    $('#showPass1').html('<i class="fas fa-fw fa-eye"></i>');
  } else {
    x.type = "password";
    $('#showPass1').html('<i class="fas fa-fw fa-eye-slash"></i>');
  }
  }else if(type == 2){
    var x = document.getElementById("password");  
  if (x.type === "password") {
    x.type = "text";
    $('#showPass2').html('<i class="fas fa-fw fa-eye"></i>');
  } else {
    x.type = "password";
    $('#showPass2').html('<i class="fas fa-fw fa-eye-slash"></i>');
  }
  }else{
    var x = document.getElementById("confirmpassword");  
  if (x.type === "password") {
    x.type = "text";
    $('#showPass3').html('<i class="fas fa-fw fa-eye"></i>');
  } else {
    x.type = "password";
    $('#showPass3').html('<i class="fas fa-fw fa-eye-slash"></i>');
  }
  }
  
}




function savePasswordData(){
  var formData = new FormData($("#changePasswordForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'change-password-save',
    data: formData,
    enctype:'multipart/form-data',
    contentType : false,
    processData : false,
    beforeSend:function(){
      $('.savePasswordButton').prop('disabled',true);
      $('.savePasswordButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

    },
    success:function(result){
      var data = jQuery.parseJSON(result);
      if(data.status == 1){
        $('.savePasswordButton').html('Seved');
        toastr.success(data.message, 'Save success', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'user/change-password'; }  });

      } else {
        $('.savePasswordButton').prop('disabled',false);
        $('.savePasswordButton').html('Save');
        toastr.error(data.message, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });

}



function readURL(input) {
  if (input.files && input.files[0]) {
    var ext = input.files[0].name;
    extension = ext.substring(ext.lastIndexOf('.')+1);
    var reader = new FileReader();
    reader.onload = function (e) {
      if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'JPG' || extension == 'JPEG' || extension == 'PNG'){
      $('.upic').attr('src', e.target.result);
       $('#avatar_id').val('');
       $('.avatars').prop('checked',false);

    }else{
      toastr.error('You can upload only JPG, JPEG, PNG files.', 'Upload failed', {timeOut: 2000,closeButton:true,progressBar:true});
    }
  }
    reader.readAsDataURL(input.files[0]);

  }

}







$(document).ready(function(){
$('#manageForm input').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {

  $('.saveButton').click();
    return false;
 }
});

$('#changePasswordForm input').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {

  $('.savePasswordButton').click();
    return false;
 }
});


  $(".saveButton").click(function(){
    var enable = true;
    $( ".validate" ).each(function( index,element ) {
      if($(element).val() == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }    
    });
    if(enable){
      saveData();
    }
  });  
});



$(document).ready(function(){
  $(".savePasswordButton").click(function(){
    var enable = true;
    $( ".validate" ).each(function( index,element ) {
      if($(element).val() == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }


      var password = $("#password").val();
      var confirmPassword = $("#confirmpassword").val();
      if (password !='' && password.length < 6) {
        toastr.error('Please enter minimum 6 character', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;

      }

      if (password != confirmPassword) {
        toastr.error('Password does not match', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }

    });

    if(enable){
      savePasswordData();
    }

  });  

});


$(document).ready(function(){
  var valid_email = $('#validEmail').val();
  $(".changeEmail").click(function(){
    var enable = true;
    $( ".validate_email" ).each(function( index,element ) {
      if($(element).val() == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }

       if($(element).attr('name') == 'chnage_email' && $(element).val() != '' && IsEmail($(element).val())==false){
        toastr.error(valid_email, 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
 });

    if(enable){
      saveChangeEmail();
    }
  });  
});


$(document).ready(function(){
  $(".OTP").click(function(){
    var enable = true;
    $( ".otp" ).each(function( index,element ) {
      if($(element).val() == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
 });

    if(enable){
      checkOTP();
    }

  });  

});




$(document).ready(function(){
  $(".changePhone").click(function(){
    var enable = true;
    $( ".phone_validate" ).each(function( index,element ) {
      if($(element).val() == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }    
 });
    if(enable){
      saveChangePhone();
    }

  });  

});


$(document).ready(function(){
  $(".phoneOTP").click(function(){
    var enable = true;
    $( ".phoneotp_validate" ).each(function( index,element ) {
      if($(element).val() == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
 });
    if(enable){
      checkPhoneOTP();

    }

  });  

$(".saveAccountButton").click(function(){
    var enable = true;
    $( ".acc_validate" ).each(function( index,element ) {
      if($(element).val() == ''){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
 });
    if(enable){
      saveAccountButton();

    }

  });  


});

if (typeof google === 'object' && typeof google.maps === 'object') { 
  initAutocomplete();
} else {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDzyb77sOPwJdR8WINUuDX5EG51--WJDJ4&libraries=places&callback=initAutocomplete";

  document.body.appendChild(script);
}

var componentForm = {
  locality: 'long_name',
  administrative_area_level_1: 'long_name',
  country: 'long_name',
  postal_code: 'short_name'
};

var options = {
  types: ['geocode']
};

var inputs = '';
inputs = document.getElementsByClassName('locations');
var autocompletes = [];

function initAutocomplete() {

  for (var i = 0; i < inputs.length; i++) {
    var autocomplete = new google.maps.places.Autocomplete(inputs[i], options);
    autocomplete.inputId = inputs[i].id;
    autocomplete.addListener('place_changed', fillInAddress);
    autocompletes.push(autocomplete);
  }
}
function fillInAddress() {
  var place = this.getPlace();
  var input_id = this.inputId;
  for (var component in componentForm) {
    document.getElementById(input_id+'_'+component).value = '';
    document.getElementById(input_id+'_'+component).disabled = false;
  }
  var address = document.getElementById(input_id).value;
  findlatlong(address,input_id);
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(input_id+'_'+addressType).value = val;
    }
  }
}
function findlatlong(address,input_id){
  var geocoder = new google.maps.Geocoder();
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var latitude = results[0].geometry.location.lat();
      var longitude = results[0].geometry.location.lng();
      document.getElementById(input_id+'_latitude').value = latitude;
      document.getElementById(input_id+'_longitude').value = longitude;
    } 
  }); 
}