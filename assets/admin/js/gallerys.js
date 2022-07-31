
$(document).ready(function(){
  var post_id = $('#post_id').val();
  var post_type = $('#post_type').val();

  $('#postDropzone').dropzone({
    url: BASE_URL+'admin/gallery-save-data',
    params: {post_id:post_id,post_type:post_type},
    addRemoveLinks: true,
    dictResponseError: 'Error uploading file!',
    dictRemoveFileConfirmation:  "Are you sure?",
    dictDefaultMessage: "<h3 class='title'>Drop files here or click to upload screenshot</h3><p class='text'> You have to upload the screenshot for your software to satisfy the customers </p>",
    acceptedFiles: ".jpeg,.jpg,.png",
    success: function (file, response) {
      var obj = jQuery.parseJSON( response );
      file.id = obj.id;
    },
    init: function(){
      thisDropzone = this;  

      $.get(BASE_URL+'admin/gallery-get-data/'+post_type+'/'+post_id,function (data){
        if(data == null){
          return;
        }
        
        $.each(JSON.parse(data), function (key, value){
          var mockFile = { name:value.image, size: value.file_size,id:value.id };

          thisDropzone.emit("addedfile", mockFile);
          thisDropzone.options.thumbnail.call(thisDropzone, mockFile, BASE_URL+'uploads/products/gallery/'+value.image);

          thisDropzone.emit("complete", mockFile);
        });
      });

      this.on("removedfile", function(file){
           $.ajax({
              type: 'POST',
              url: BASE_URL+'admin/gallery-remove-data/'+post_type,
              data: {id: file.id,post_id:post_id},
              dataType: 'html',
              success: function(data){
                var rep = JSON.parse(data);
                //file.previewElement.remove();
                if(rep.code == 200){

                }
              }
            });
      });

    }
  });
});


   
