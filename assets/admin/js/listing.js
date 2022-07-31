function searchFilter(page_num,loadingType) {
   page_num = page_num?page_num:0;
  var sortBy = $('#sortBy').val();
  var sortByField = $('#sortByField').val();
  var perPage = $('#perPage').val();
  var status = $('#status').val(); 
  var keyword = $('#keyword').val();
  var startEnd = $('#startEnd').val();
  var user_id = $('#user_id').val(); 
  var feature_status = $('#feature_status').val();
  var expired = $('#expired').val();
  var admin_paid_status = $('#admin_paid_status').val();
  var user_paid_status = $('#user_paid_status').val();

  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/listing-search-data/'+page_num,
    data:'page='+page_num+'&sortBy='+sortBy+'&sortByField='+sortByField+'&perPage='+perPage+'&status='+status+'&keyword='+keyword+'&startEnd='+startEnd+'&user_id='+user_id+'&feature_status='+feature_status+'&expired='+expired+'&admin_paid_status='+admin_paid_status+'&user_paid_status='+user_paid_status,
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


function statusChange(id,status){

  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/change-status-listing',
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
         window.location.reload();
        } else {
          window.location.reload();
        }
        
        toastr.success(data.msg, 'Status changed', {timeOut: 2000,progressBar:true,closeButton:true   });
      } else {
        toastr.error(data.msg, 'Status change failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });

}


function featureStatusChange(id,status){

  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/change-feature-listing',
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
         window.location.reload();
        } else {
          window.location.reload();
        }
        
        toastr.success(data.msg, 'Status changed', {timeOut: 2000,progressBar:true,closeButton:true   });
      } else {
        toastr.error(data.msg, 'Status change failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });

}


function resetSearch(){
  location.reload();
}


$(document).ready(function(){
$(function () {
      $('.datepicker').datepicker();
  });
  var url = window.location.href;
  var param = url.split('/');
  
  //if( param[param.length - 1] && param[param.length - 1] == 'listing'){
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


});