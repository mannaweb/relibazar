function saveData(){

  var formData = new FormData($("#manageForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'admin/twofactor-save-data',
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
        toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/two-factor'; }   });
      } else {
        $('.saveButton').prop('disabled',false);
        $('.saveButton').html('Save');
        toastr.error(data.msg, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}














$(document).ready(function(){


  $(".saveButton").click(function(){
    var enable = true;
    $( ".validate" ).each(function( index,element ) {

       if(jQuery.trim($(element).val()) == '' && ($(element).hasClass("urlValidation") == false || $(element).hasClass("businessUrlValidation") == true)){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
      
   
     
    });
    if(enable){
      saveData();
    }

  });

  $(".cancelButton").click(function(){
    window.location.href=BASE_URL+"admin/alerts";
  });

});