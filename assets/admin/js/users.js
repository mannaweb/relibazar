function saveData(){

  var formData = new FormData($("#manageForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'admin/user-save-data',
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
        toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/users'; }   });
      } else {
        $('.saveButton').prop('disabled',false);
        $('.saveButton').html('Save');
        toastr.error(data.msg, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}

function searchFilter(page_num,loadingType) {
   page_num = page_num?page_num:0;
  var sortBy = $('#sortBy').val();
  var sortByField = $('#sortByField').val();
  var perPage = $('#perPage').val();
  var status = $('#status').val(); 
  var keyword = $('#keyword').val();
  var startEnd = $('#startEnd').val();
  var role = $('#role').val();
  var email_verified = $('#email_verified').val();
  var phone_verified = $('#phone_verified').val();
    //alert(reservation);

  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/user-search-data/'+page_num,
    data:'page='+page_num+'&sortBy='+sortBy+'&sortByField='+sortByField+'&perPage='+perPage+'&status='+status+'&keyword='+keyword+'&startEnd='+startEnd+'&role='+role+'&email_verified='+email_verified+'&phone_verified='+phone_verified,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {
      var data = jQuery.parseJSON(html);
      $('#usersList').html(data.html);
      $('#paginationDiv').html(data.pagination);
      if(loadingType != 1){
        $('html, body').animate({scrollTop:$('#usersList').offset().top - 200 }, 500);
      }
      $('.preloader').removeClass('active');
      $('.table-responsive').removeClass('overflow-hidden');
    }
  });
}


function sortBy(field,sortByField,sortBy){
 $('#sortByField').val(sortByField);
  $('#sortBy').val(sortBy);
  $('.commonSorting').removeClass('active');
  $('.'+field+'_'+sortBy).addClass('active');
  $('.'+field).removeAttr('onclick');
  if(sortBy == 'ASC'){
    sortBy = 'DESC';
  } else {
    sortBy = 'ASC';
  }
  $('.'+field).attr('onclick', 'sortBy("'+field+'","'+sortByField+'","'+sortBy+'")');
  searchFilter();
}

function resetSearch(){
  location.reload();
}





function deleteUser(id,status){

  var ids = '';
  if(id == 'all'){
    $('.singleCheck').each(function(index,element){
      if($(this).prop("checked") == true){
        ids += $(this).val()+',';
      } 
    });
    ids = ids.replace(/,\s*$/, "");
  } else {
    ids = id;
  }
  if(ids){
    $('#deleteModal').find('#deleteData').val(ids);
    $('#deleteModal').find('#deleteStatus').val(status);
    $('#deleteModal').modal('show');
  } else {
    toastr.error('Please select atleast one data to delete', 'Delete failed', {timeOut: 2000,closeButton:true,progressBar:true});
  }
  
}

function deleteConfirm(){

  var ids = $('#deleteModal').find('#deleteData').val();
  var status = $('#deleteModal').find('#deleteStatus').val();
  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/delete-user',
    data:'ids='+ids+'&status='+status,
    beforeSend: function () {
      $('.deleteButton').prop('disabled',true);
      $('.deleteButton').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');
    },
    success: function (html) {

      var data = jQuery.parseJSON(html);
      if(data.status == 1){
        $('#deleteModal').modal('hide');
        $('.deleteButton').html('Confirm');
        $('#customCheckcheckAll').prop('checked',false);
        toastr.success(data.msg, 'Delete success', {timeOut: 1000,progressBar:true,closeButton:true  });
        searchFilter();
      } else {
        $('.deleteButton').prop('disabled',false);
        $('.deleteButton').html('Confirm');
        toastr.error(data.msg, 'Delete failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }

    }
  });

}


function statusEmail(id,email,status){
  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/change-status-email',
    data:'id='+id+'&email_verified='+status,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {

      $('.preloader').removeClass('active');
      $('.table-responsive').removeClass('overflow-hidden');
      var data = jQuery.parseJSON(html);
      if(data.status == 1){
        if(status == 1){
          $('#email_td_'+id).html(email+' <span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check-circle"></i></span></span>');
          $('#email_a_'+id).html('<i class="fas fa-fw fa-times-circle"></i> Email Unverified');
          $('#email_a_'+id).removeAttr('onclick');
          $('#email_a_'+id).attr('onclick', 'statusEmail('+id+',"'+email+'",2)');
        } else {
          $('#email_td_'+id).html(email+'<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times-circle"></i></span></span>');
          $('#email_a_'+id).html('<i class="fas fa-fw fa-check-circle"></i> Email Verified');
          $('#email_a_'+id).removeAttr('onclick');
          $('#email_a_'+id).attr('onclick', 'statusEmail('+id+',"'+email+'",1)');
        }
        
        toastr.success(data.msg, 'Status changed', {timeOut: 2000,progressBar:true,closeButton:true   });
      } else {
        toastr.error(data.msg, 'Status change failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });

}



function statusPhone(id,phn,status){
  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/change-status-phone',
    data:'id='+id+'&phone_verified='+status,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {

      $('.preloader').removeClass('active');
      $('.table-responsive').removeClass('overflow-hidden');
      var data = jQuery.parseJSON(html);
      if(data.status == 1){
        if(status == 1){
          $('#phone_td_'+id).html(phn+' <span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check-circle"></i></span></span>');
          $('#phone_a_'+id).html('<i class="fas fa-fw fa-times-circle"></i> Phone Unverified');
          $('#phone_a_'+id).removeAttr('onclick');
          $('#phone_a_'+id).attr('onclick', 'statusPhone('+id+','+phn+',2)');
        } else {
          $('#phone_td_'+id).html(phn+' <span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times-circle"></i></span></span>');
          $('#phone_a_'+id).html('<i class="fas fa-fw fa-check-circle"></i> Phone Verified');
          $('#phone_a_'+id).removeAttr('onclick');
          $('#phone_a_'+id).attr('onclick', 'statusPhone('+id+','+phn+',1)');
        }
        
        toastr.success(data.msg, 'Status changed', {timeOut: 2000,progressBar:true,closeButton:true   });
      } else {
        toastr.error(data.msg, 'Status change failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });

}

function statusChange(id,status){

  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/change-status-user',
    data:'id='+id+'&status='+status,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {

      $('.preloader').removeClass('active');
      $('.table-responsive').removeClass('overflow-hidden');
      var data = jQuery.parseJSON(html);
      if(data.status == 1){
        if(status == 1){
          $('#status_td_'+id).html('<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Active</span></span>');
          $('#status_a_'+id).html('<i class="fas fa-fw fa-times-circle"></i> Deactivate');
          $('#status_a_'+id).removeAttr('onclick');
          $('#status_a_'+id).attr('onclick', 'statusChange('+id+',2)');
        } else {
          $('#status_td_'+id).html('<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Inactive</span></span>');
          $('#status_a_'+id).html('<i class="fas fa-fw fa-check-circle"></i> Activate');
          $('#status_a_'+id).removeAttr('onclick');
          $('#status_a_'+id).attr('onclick', 'statusChange('+id+',1)');
        }
        
        toastr.success(data.msg, 'Status changed', {timeOut: 2000,progressBar:true,closeButton:true   });
      } else {
        toastr.error(data.msg, 'Status change failed', {timeOut: 2000,closeButton:true,progressBar:true});
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
    }else{
      toastr.error('You can upload only JPG, JPEG, PNG files.', 'Upload failed', {timeOut: 2000,closeButton:true,progressBar:true});
    }
  }
    reader.readAsDataURL(input.files[0]);
  }
}


$(document).ready(function(){





$(function () {
      $('.datepicker').datepicker();
  });
  
  var role = $('#role').val();

  var url = window.location.href;
  var param = url.split('/');
   //alert( param[param.length - 1]);
  //if( param[param.length - 1] && param[param.length - 1] == 'users' && role !='' ){
    searchFilter('',1);

    $('#startEnd').daterangepicker({ autoUpdateInput: false });

    $('#startEnd').on('apply.daterangepicker', function(ev, picker) {
 
  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    searchFilter('',1);
});

$('#startEnd').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
       searchFilter('',1);
  });
 // }

  $(".saveButton").click(function(){
    var enable = true;
    $( ".validate" ).each(function( index,element ) {

      if($(element).attr('name') == 'email' && jQuery.trim($(element).val()) != '' && IsEmail($(element).val())==false){
        toastr.error('Please enter a valid email.', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
       if(jQuery.trim($(element).val()) == '' && ($(element).hasClass("urlValidation") == false || $(element).hasClass("businessUrlValidation") == true)){
        toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
      if(IsUrl($(element).val())==false && $(element).hasClass("businessUrlValidation") == true){
        toastr.error('Please enter a valid url.', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
      if(jQuery.trim($(element).val()) != '' && IsUrl($(element).val())==false && $(element).hasClass("urlValidation") == true){
        toastr.error('Please enter a valid url.', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }
      var password = $("#password").val();
      if (password !='' && password.length < 6) {
        toastr.error('Please enter minimum 6 character', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;

      }
     
    });
    if(enable){
      saveData();
    }

  });

  $(".cancelButton").click(function(){
    window.location.href=BASE_URL+"admin/users";
  });

});