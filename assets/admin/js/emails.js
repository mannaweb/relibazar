function saveData(){

  var formData = new FormData($("#manageForm")[0]);
  formData.append('content', tinymce.get("content").getContent());
  $.ajax({
    type: "POST",
    url: BASE_URL +'admin/email-save-data',
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
        toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/emails'; }   });
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
  var keyword = $('#keyword').val();
     var startEnd = $('#startEnd').val();

  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/edit-search-data/'+page_num,
    data:'page='+page_num+'&sortBy='+sortBy+'&sortByField='+sortByField+'&perPage='+perPage+'&status='+status+'&keyword='+keyword+'&startEnd='+startEnd,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {
      var data = jQuery.parseJSON(html);
      $('#emailsList').html(data.html);
      $('#paginationDiv').html(data.pagination);
      if(loadingType != 1){
        $('html, body').animate({scrollTop:$('#emailsList').offset().top - 200 }, 500);
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





$(document).ready(function(){

  var url = window.location.href;
  var param = url.split('/');
  if( param[param.length - 1] && param[param.length - 1] == 'emails' ){
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
  }

  $(".saveButton").click(function(){
    var enable = true;
    $( ".validate" ).each(function( index,element ) {  
       if(jQuery.trim($(element).val()) == ''){
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
    window.location.href=BASE_URL+"admin/emails";
  });

});