function searchFilter(page_num,loadingType) {
   page_num = page_num?page_num:0;
  var sortBy = $('#sortBy').val();
  var sortByField = $('#sortByField').val();
  var perPage = $('#perPage').val();
  var status = $('#status').val(); 
  var product_id = $('#product_id :selected').val();
  var keyword = $('#keyword').val();
  var user_id = $('#user_id :selected').val();
  var user_phone = $('#user_phone :selected').val();
  var startEnd = $('#startEnd').val();
  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/order-search-data/'+page_num,
    data:'page='+page_num,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {
      var data = jQuery.parseJSON(html);
      $('#ordersList').html(data.html);
      $('#paginationDiv').html(data.pagination);
      //$('.ordering').keyup(myFunction);
      // if(loadingType != 1){
      //   $('html, body').animate({scrollTop:$('#ordersList').offset().top - 200 }, 500);
      // }
      $('.preloader').removeClass('active');
      $('.table-responsive').removeClass('overflow-hidden');
    }
  });
}

$(document).ready(function(){
  searchFilter();
  });

function order_manage(order_id){
  //alert(order_id);
  $.ajax({
    type: "POST",
    url: BASE_URL +'order/manage',
    data: {order_id:order_id},
    success:function(result){
      var data = jQuery.parseJSON(result);
      $('#orderMaintance').html(data.html);    
    }
  });
};

function order_details(order_id){
  //alert(order_id);
  $.ajax({
    type: "POST",
    url: BASE_URL +'order/details',
    data: {order_id:order_id},
    success:function(result){
      var data = jQuery.parseJSON(result);
      $('#orderModal').html(data.html);    
    }
  });
};
