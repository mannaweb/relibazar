
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
    data:'page='+page_num+'&sortBy='+sortBy+'&sortByField='+sortByField+'&perPage='+perPage+'&status='+status+'&keyword='+keyword+'&product_id='+product_id+'&user_id='+user_id+'&user_phone='+user_phone+'&startEnd='+startEnd,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {
      var data = jQuery.parseJSON(html);
      $('#ordersList').html(data.html);
      $('#paginationDiv').html(data.pagination);
      $('.ordering').keyup(myFunction);
      if(loadingType != 1){
        $('html, body').animate({scrollTop:$('#ordersList').offset().top - 200 }, 500);
      }
      $('.preloader').removeClass('active');
      $('.table-responsive').removeClass('overflow-hidden');
    }
  });
}


function sortBy(field,sortByField,sortBy){
  if(field == 'ordering'){
    sortableEnable();
  }
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

function sortableEnable(){
  $( "tbody" ).sortable({
    placeholder : "ui-state-highlight",
    cursor: "move",
    update  : function(event, ui){
      $('tbody tr').each(function(index){
        $(this).find(".ordering").val(parseInt(index)+parseInt($('#start').val()));
      });
    }
  });
}


var myFunction = function() {
  var start = $('#start').val();
  var end = $('#end').val();
  if( parseInt($(this).val()) >= parseInt(start) && parseInt($(this).val()) <= parseInt(end) ){
    $('.sorting_a').prop('disabled',false);
    return true;
  } else {
    $('.sorting_a').prop('disabled',true);
    toastr.error('Ranking only allow between '+start+' to '+end, 'Ranking failed', {timeOut: 2000,closeButton:true,progressBar:true});
    return false;
  }
}

$(".sorting_a").click(function(){
  $('.preloader').addClass('active');
  $('.table-responsive').addClass('overflow-hidden');
  
  var ordering = [];
  var ids = [];
  var isDuplicate = 2;
  $('tbody tr').each(function(index){

    if(ordering.indexOf(parseInt($(this).find(".ordering").val())) == -1) {
      ordering.push(parseInt($(this).find(".ordering").val()));
      ids.push($(this).find(".ids").val());
    } else {
      isDuplicate = 1;
    }
    
  });

  if(isDuplicate == 1){
    $('.preloader').removeClass('active');
    $('.table-responsive').removeClass('overflow-hidden');
    toastr.error('Ranking must be unique.', 'Ranking failed', {timeOut: 2000,closeButton:true,progressBar:true});
    return false;
  } else {
    $.ajax({
    type: "POST",
    url: BASE_URL +'admin/save-product-ordering',
    data: {ids:ids,ordering:ordering},
    beforeSend: function () {
      
    },
    success:function(result){
      $('.preloader').removeClass('active');
      $('.table-responsive').removeClass('overflow-hidden');
      toastr.success('Ranking updated successfully', 'Ranking updated', {timeOut: 2000,closeButton:true,progressBar:true});
    }
  });
  }
  
});

function statusChange(id,status){
  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/change-status-product',
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
                var image = new Image();
                image.src = e.target.result;
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if(width < 350 || height < 250){
                        toastr.error('Choose a file with minimum 350x250 Dimensions. ', 'Upload failed', {timeOut: 2000,closeButton:true,progressBar:true});
                        $('#image').val('');
                    }else{
                        $('.upic').attr('src', e.target.result);
                    }
                }
            }else{
                toastr.error('You can upload only JPG, JPEG, PNG files.', 'Upload failed', {timeOut: 2000,closeButton:true,progressBar:true});
                $('#image').val('');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function tinymceValidation() {
    var description = tinymce.get("description").getContent({format: 'text'});
    var short_description =  $('#short_description').val();

    var description = $(description).text().replace(/\s/g,"");

    if (description == "" || short_description == "") {
        return false;
    } else {
        return true;
    }
}


$(document).ready(function(){
  var url = window.location.href;
  var param = url.split('/');
  if( param[param.length - 1] && param[param.length - 1] == 'orders' ){
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
    if($(element).attr('name') == 'alias' && jQuery.trim($(element).val()) != '' && IsAlias($(element).val())==false){
        toastr.error('Alias only allow number,character,underscore and dash.', 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
        enable = false;
        return false;
      }  

      if(jQuery.trim($(element).val()) == ''){
          toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
          enable = false;
          return false;
      }

      var valid_tinymce = tinymceValidation();
      
      if(valid_tinymce == false){
          toastr.error('Short Description and Description feilds are required.','Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
          enable = false;
          return false;
      }
    });

    if(enable){
      saveData();
    }

  });

  $(".cancelButton").click(function(){
    window.location.href=BASE_URL+"admin/products";
  });
});


$('body').on('click','.check_class',function(){
    var value = $(this).attr('cat_val');
        $('.main_cat[value='+value+']').prop('checked',true);
        $('.sub_cat[main_cat_val='+value+']').prop('checked',true);
    
});


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


function change_status(){
  //alert(order_id);
  $('.preloader').addClass('active');
  $('.saveBtn').html('Updating..');
   $('.saveBtn').prop('disabled',true);
     $('#orderMaintance').modal('hide');
  var order_id = $('#order_id').val();
  var order_status = $('#order_status').val();
    var msg = $('#msg').val();
  $.ajax({
    type: "POST",
    url: BASE_URL +'order/saveStatus',
    data: {order_status:order_status,order_id:order_id,msg:msg},
    success:function(result){
     // alert(result);

     $('.preloader').removeClass('active');
          $('.saveBtn').html('Update');
           $('.saveBtn').prop('disabled',false);
           
               searchFilter('',1);
    }
  });
};


