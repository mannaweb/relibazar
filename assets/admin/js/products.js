function saveData(){
  var formData = new FormData($("#manageForm")[0]);
  formData.append('description', tinymce.get("description").getContent());
  $.ajax({
    type: "POST",
    url: BASE_URL +'admin/product-save-data',
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
        toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/products'; }   });
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
  var category = $('#category :selected').val();
  var keyword = $('#keyword').val();
  var featured = $('#featured').val();
  var startEnd = $('#startEnd').val();
  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/product-search-data/'+page_num,
    data:'page='+page_num+'&sortBy='+sortBy+'&sortByField='+sortByField+'&perPage='+perPage+'&status='+status+'&keyword='+keyword+'&category='+category+'&featured='+featured+'&startEnd='+startEnd,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {
      var data = jQuery.parseJSON(html);
      $('#productsList').html(data.html);
      $('#paginationDiv').html(data.pagination);
      $('.ordering').keyup(myFunction);
      if(loadingType != 1){
        $('html, body').animate({scrollTop:$('#productsList').offset().top - 200 }, 500);
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
  window.location.href=BASE_URL+"admin/products";
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


function deleteProduct(id){
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
    $('#deleteModal').modal('show');
  } else {
    toastr.error('Please select atleast one data to delete', 'Delete failed', {timeOut: 2000,closeButton:true,progressBar:true});
  }
  
}

function deleteConfirm(){
  var ids = $('#deleteModal').find('#deleteData').val();
  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/delete-product',
    data:'ids='+ids,
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
function getSubcat(id){
  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/get-subcategory',
    data:'id='+id,
   
    success: function (html) {
     var obj = jQuery.parseJSON(html);
 $('#subcat').html(obj.html);
    }
  });
}
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

function showTax(){
    var checkBox = document.getElementById("tax_status");
    if (checkBox.checked == true){
      $('#taxDiv').css('display','block');
    }else{
      $('#taxDiv').css('display','none');
    }
}


$(document).ready(function(){
  var url = window.location.href;
  var param = url.split('/');
  if( param[param.length - 1] && param[param.length - 1] == 'products' ){
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
   searchFilter('',1);

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

   var checkBox = document.getElementById("tax_status");
    if (checkBox.checked == true){
      $('#taxDiv').css('display','block');
    }else{
      $('#taxDiv').css('display','none');
    }
});

  function productFeatured(id,featured){
    $.ajax({
         type: 'POST',
         url: BASE_URL+'admin/change-featured-product',
         data:'id='+id+'&featured='+featured,
         beforeSend: function () {
           $('.preloader').addClass('active');
           $('.table-responsive').addClass('overflow-hidden');
         },
        success: function (html) {
          $('.preloader').removeClass('active');
          $('.table-responsive').removeClass('overflow-hidden');
          var data = jQuery.parseJSON(html);
          if(data.status == 1){
            if(featured == 1){
              $('#featured_td_'+id).html('<span class="btn btn-xs btn-success btn-icon-split"><span class="icon text-white-50"><i class="fas fa-check"></i></span><span class="text">Yes</span></span>');
              $('#featured_a_'+id).html('<i class="fas fa-fw fa-times-circle"></i> Non Featured');
              $('#featured_a_'+id).removeAttr('onclick');
              $('#featured_a_'+id).attr('onclick', 'productFeatured('+id+',2)');
            }else{
              $('#featured_td_'+id).html('<span class="btn btn-xs btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">No</span></span>');
              $('#featured_a_'+id).html('<i class="fas fa-fw fa-check-circle"></i> Featured');
              $('#featured_a_'+id).removeAttr('onclick');
              $('#featured_a_'+id).attr('onclick', 'productFeatured('+id+',1)');
            }
            toastr.success(data.msg, 'Product featured changed', {timeOut: 2000,progressBar:true,closeButton:true});
          } else {
            toastr.error(data.msg, 'Product featured change failed', {timeOut: 2000,closeButton:true,progressBar:true});
          }
        }
    });
  }


// $('body').on('change','.sub_cat',function(){
//     var value = $(this).val();
//     var main_cat_val = $(this).attr('main_cat_val');
//     console.log(value+'/'+main_cat_val);

//     if($(this).is(':checked')){
//         $('.main_cat[value='+main_cat_val+']').prop('checked',true);
//     }else{
//         $('.main_cat[value='+main_cat_val+']').prop('checked',false);
//     }
// });

// $('body').on('change','.main_cat',function(){
//     var value = $(this).val();

//     if($(this).is(':checked')){
       
//     }else{
//         $('.sub_cat[main_cat_val='+value+']').prop('checked',false);
//     }
// });

$('body').on('click','.check_class',function(){
    var value = $(this).attr('cat_val');
        $('.main_cat[value='+value+']').prop('checked',true);
        $('.sub_cat[main_cat_val='+value+']').prop('checked',true);
    
});


$(document).on('keyup','#title', function(){
  var title = $(this).val();
  $.ajax({
    url:BASE_URL+ 'admin/page-alias',
    method: 'post',
    data: { title : title},
    success:function(d){
      d= $.parseJSON(d);     
        $('#slug').val(d.alias);     
    }
  });

});


function product_type(type){
if(type == 3){
      $('.ajax').html('');
     $('#append_div').show();
      $('#price_div').hide();
     $('.piece_div').show();
      $('.weight_div').hide();
      $('#status_stock').hide();
     
}else if(type == 2){
$('.ajax').html('');
  $('.piece_div').hide();
      $('.weight_div').show();
    $('#price_div').hide();
     $('#append_div').show();
       $('#status_stock').hide();
   
  }else{
     $('#status_stock').show();
     $('#price_div').show();
      $('#append_div').hide();
       
  }
}


$(".addCF").click(function(){ 

 var ptype = $('#ptype').val();

var last_id=parseInt($(".row_count" ).val())+parseInt(1);
//alert(last_id);
$.ajax({
  type : 'POST',
  url : BASE_URL +'admin/ajax-price-div-load',
  data : {last_id:last_id,ptype:ptype},
  success :function(data){
       var json = jQuery.parseJSON(data);
    $("#append_div").append(json.html);
    $( ".row_count" ).val(last_id);   
  }
   })
});

function remove_div(id){
  $('#row_url_'+id).remove();
}


var target = $('#ptype option:selected').val();
if(target == 2){
$('.ajax').html('');
  $('.piece_div').hide();
      $('.weight_div').show();
    $('#price_div').hide();
     $('#append_div').show();
     
      $('#status_stock').hide();
   

}else if(target == 3){
       $('.ajax').html('');
     $('#append_div').show();
      $('#price_div').hide();
     $('.piece_div').show();
      $('.weight_div').hide();
      $('#status_stock').hide();
    
      }else{
         $('#status_stock').show();
     $('#price_div').show();
      $('#append_div').hide();
       
      }



      function cal_product_product(val,id){
         var tax = $('#tax').val();
         if(tax){
            var getVal =  (val*tax) / 100;
            var totVal =  parseFloat(val) + parseFloat(getVal);
           
             $('#price'+id).val(Math.round(totVal));   
         }else{
          $('#price'+id).val(val);              
         }
        

      }


      function product_product(val,id){
         var tax = $('#tax').val();
         if(tax){
            var getVal =  (val*tax) / 100;
            var totVal =  parseFloat(val) + parseFloat(getVal);
           
             $('#selling_price').val(Math.round(totVal));   
         }else{
          $('#selling_price').val(Math.round(val));             
         }
        

      }