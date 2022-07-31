

function searchFilter(page_num,loadingType) {
   page_num = page_num?page_num:0;
  var sortBy = $('#sortBy').val();
  var sortByField = $('#sortByField').val();
  var perPage = $('#perPage').val();
  var status = $('#status').val(); 
  var keyword = $('#keyword').val();
  var startEnd = $('#startEnd').val();
  var user_id = $('#user_id').val(); 
  var listing_id = $('#listing_id').val(); 
  var pay_for = $('#pay_for').val(); 

  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/transactions-search-data/'+page_num,
    data:'page='+page_num+'&sortBy='+sortBy+'&sortByField='+sortByField+'&perPage='+perPage+'&status='+status+'&keyword='+keyword+'&startEnd='+startEnd+'&user_id='+user_id+'&listing_id='+listing_id+'&pay_for='+pay_for,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {
      var data = jQuery.parseJSON(html);
      $('#transactionsList').html(data.html);
      $('#paginationDiv').html(data.pagination);
      if(loadingType != 1){
        $('html, body').animate({scrollTop:$('#transactionsList').offset().top - 200 }, 500);
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



function payStatusModal(id){
  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/transactions-pay',
    data:{id:id},
    
    success: function (result) {
      var data = jQuery.parseJSON(result);
      $('#payModal').html(data.html).modal('show');
      
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
  
  //if( param[param.length - 1] && param[param.length - 1] == 'transactions'){
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
  //}


});