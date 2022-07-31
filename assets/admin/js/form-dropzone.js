var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {  
            Dropzone.options.myDropzone = {                
                init: function() {
                  
                  //var self = this;
                    console.log(this);
                    this.on("addedfile", function(file) {

                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");
                        
                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });

                    this.on('success',function(data,data1){
                      data1 = JSON.parse(data1);
                      if(data1.success)
                      {
                        var input = Dropzone.createElement('<input class="screenimage" type="hidden" name="screenimage" value="' + data1.message + '"/>');
                        data.previewElement.appendChild(input);
                      }
                      else
                      {
                        toastr['error'](data1.message,'Error');
                        this.removeFile(data);
                      }
                      
                    })
                }            
            }
        }
    };
}();

jQuery(document).ready(function() {    
   FormDropzone.init();
});