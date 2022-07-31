(function($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });
	
	//$('[data-toggle="tooltip"]').tooltip();

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
  });
	/*$(window).on('load', function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
  });*/
	if($(window).width() < 768){
		$("body").click(function(){
			$('.sidebar .collapse').collapse('hide');
    });
		$(window).on('load', function(){
			$('.sidebar .collapse').collapse('hide');
    });
	}

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

})(jQuery); // End of use strict

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}

function IsUrl(str){
  regexp =  /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
  if (regexp.test(str))
  {
    return true;
  }
  else
  {
    return false;
  }
}

function IsAlias(alias) {
  var regex = /^[a-zA-Z0-9_-]*$/;
  if(!regex.test(alias)) {
    return false;
  }else{
    return true;
  }
}

function jsUcfirst(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}


$('body').on('click','.checkAll',function(){
  if($(this).is(':checked')){
    $('.singleCheck').each(function(){
      var attr = $(this).attr('disabled');
      if (typeof attr !== typeof undefined && attr !== false) {

      }else{
        $(this).prop("checked", true);
      }
    });
  }else{
    $('.singleCheck').prop("checked", false);
  }
});



$('body').on('click','.singleCheck',function(){
  var single_check_count = $('.singleCheck').length;
  var checked_single_check_count = $('.singleCheck:checked').length;
  if(single_check_count == checked_single_check_count){
    $('.checkAll').prop("checked", true);
  }else{
    $('.checkAll').prop("checked", false);
  }
});


$('.select2').select2();
$(".select2-multiple").select2({
    placeholder: " - Select Category - "
});
$('.select2-nosearch').select2({
    minimumResultsForSearch: -1
});

	$('.permission-management .permission-item .btn-trigger').on('click', function(){
		$(this).parent('.item-header').toggleClass('active');
		$(this).parent('.item-header').siblings('.item-body').slideToggle(300);
	});




// ********************** TINYMCE ************************ //

tinymce.init({
  height: 400,
  selector: '.tinymce',
  plugins: 'image code print preview powerpaste fullpage searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount  a11ychecker imagetools textpattern help textcolor',
  toolbar: 'formatselect | styleselect fontselect fontsizeselect | bold italic strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | undo redo | link media image | code | print preview removeformat',
  /* enable title field in the Image dialog*/
  image_title: true,
  /* enable automatic uploads of images represented by blob or data URIs*/
  automatic_uploads: true,
  relative_urls : false,
  remove_script_host : false,
  convert_urls : false,
  valid_elements : '*[*]',
  /*
    URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
    images_upload_url: 'postAcceptor.php',
    here we add custom filepicker only to Image dialog
  */
  file_picker_types: 'file image media',

  /* and here's our custom image picker*/
  file_picker_callback: function (cb, value, meta) {

    if(meta.filetype == 'image'){

      var input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('accept', 'image/*');
      input.onchange = function () {
        var file = this.files[0];

        var reader = new FileReader();
        reader.onload = function () {

          var id = 'blobid' + (new Date()).getTime();
          var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
          var base64 = reader.result.split(',')[1];
          var blobInfo = blobCache.create(id, file, base64);
          blobCache.add(blobInfo);

          cb(blobInfo.blobUri(), { title: file.name });
        };
        reader.readAsDataURL(file);
      };

    }

    if(meta.filetype == 'media'){

      var input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('accept', 'video/*');
      input.onchange = function () {

        var files = this.files[0];
        var video = document.createElement('video');
        video.preload = 'metadata';

        video.onloadedmetadata = function() {
          console.log(video);
          var name = '';
          var blobCache = tinymce.activeEditor.editorUpload.blobCache;
          var blobInfo = blobCache.create(name, files, video);
          blobCache.add(blobInfo);
          cb(blobInfo.blobUri());
        }
        video.src = URL.createObjectURL(files);
      };

    }

    input.click();
  }
});


function show_details(list_id){
  $.ajax({
    type: "POST",
    url: BASE_URL +'listings/details',
    data: {list_id:list_id},
    success:function(result){
      var data = jQuery.parseJSON(result);
      $('#listModal').html(data.html);
    }
  });
};

function user_details(user_id){
  //alert(username);
  $.ajax({
    type: "POST",
    url: BASE_URL +'user/details',
    data: {user_id:user_id},
    success:function(result){
      var data = jQuery.parseJSON(result);
      $('#userModal').html(data.html);
      searchReview('',1);
    }
  });
};

