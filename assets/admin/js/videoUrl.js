function saveData(){
  var formData = new FormData($("#manageForm")[0]);
  //formData.append('description', tinymce.get("description").getContent());
  $.ajax({
    type: "POST",
    url: BASE_URL +'admin/video-save-data',
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
        toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/blogs'; }   });
      } else {
        $('.saveButton').prop('disabled',false);
        $('.saveButton').html('Save');
        toastr.error(data.msg, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
      }
    }
  });
}

$(".addCF").click(function(){ 
var last_id=parseInt($(".row_count" ).val())+parseInt(1);
//alert(last_id);
$.ajax({
	type : 'POST',
	url : BASE_URL +'admin/ajax-video-div-load',
	data : {last_id:last_id},
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

function ytVidId(url){
    var p = /^(http:\/\/|https:\/\/)(vimeo\.com|youtu\.be|www\.youtube\.com)\/([\w\/]+)([\?].*)?$/;
    //var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
    return (url.match(p)) ? RegExp.$1 : false;
}

function checkUrl(url,key){
 if(ytVidId(url) != false){
   //toastr.success('', 'Saved', {timeOut: 1000,progressBar:true,closeButton:true,});
 }else{
   toastr.error('Url should be youtube or vimeo', 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
   $('#url_data_'+key).val('');
 }
}

$(document).ready(function(){
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
     
     
    });
    if(enable){
      saveData();
    }

  });
  // $(".cancelButton").click(function(){
  //   window.location.href=BASE_URL+"admin/articles";
  // });
});