$(document).ready(function(){
	"use strict";
	
	var trigger = $('.menu-options .item-header > a');
	trigger.on('click', function(){
		var body = $(this).parent('.item-header').siblings('.item-body');
		$('.menu-options .item-body').not(body).removeClass('active').slideUp(300);
		$('.menu-options .item-header > a').not(this).removeClass('active');
		if(($(this).hasClass('active') === true) && (body.hasClass('active') === true)){
			$(this).removeClass('active');
			body.removeClass('active').slideUp(300);
		}else{
			$(this).addClass('active');
			body.addClass('active').slideDown(300);
		}
	});
	
	$('.sortable').nestedSortable({
		forcePlaceholderSize: true,
		items: 'li',
		handle: '.item',
		placeholder: 'menu-highlight',
		listType: 'ul',
		maxLevels: 2,
		opacity: 0.6,
	});

	$('.sortable').draggable();
	
});

function addToMenu(type){

	var menuname = $('.menuname').val();
	if(menuname){
		if(type != 'custom'){
			$('.'+type+' li').each(function(index){
				if($(this).find(".custom-input").prop("checked") == true){
					var count = parseInt($('#count').val()) + 1;
					$.ajax({
					    type: "POST",
					    url: BASE_URL +'admin/add-page-to-menu',
					    data: {text:$(this).find('.custom-label').text(),id:$(this).find(".custom-input").val(),title:$(this).find('.custom-label').text(),type:type,count:count},
					    beforeSend:function(){
					    	$('#count').val(parseInt(count) + 1);
					    },
					    success:function(result){
					      var data = jQuery.parseJSON(result);
					      $('.sortable').append(data.html);
					    }
					});
					$(this).find(".custom-input").prop("checked",false);
				}
			});
		} else {
			if($('.name').val() != ''){
				var count = parseInt($('#count').val()) + 1;
				$.ajax({
				    type: "POST",
				    url: BASE_URL +'admin/add-page-to-menu',
				    data: {text:$('.name').val(),title:$('.name').val(),type:'custom',href:$('.url').val(),type:type,count:count},
				    beforeSend:function(){
				    	$('#count').val(parseInt(count) + 1);
				    },
				    success:function(result){
				      	var data = jQuery.parseJSON(result);
					    $('.sortable').append(data.html);
				    }
				});
				$('.name').val('');
				$('.url').val('');
			} else {
				toastr.error('Title cannot be blank', 'Failed', {timeOut: 2000,closeButton:true,progressBar:true});
			}	
		}
	} else {
		toastr.error('Select the menu', 'Failed', {timeOut: 2000,closeButton:true,progressBar:true});
	}
}

function selectAll(type){
	$('.'+type+' li').each(function(index){
		$(this).find(".custom-input").prop('checked', true);
	});
}

function toggleMenu(This){
	$(This).parent('.item-title').toggleClass('active');
	$(This).parent('.item-title').siblings('.item-body').slideToggle(300);
}

function cancelMenu(This){
	$(This).parents('.item-body').siblings('.item-title').toggleClass('active');
	$(This).parents('.item-body').slideUp(300);
}

function removeMenu(This){
	$(This).parents('.item').parent('li').remove();
}

function searchData(filter,type) {

	filter = filter.toLowerCase();
	$('.'+type+' li').each(function(index){
		if ($(this).find('.custom-label').text().toLowerCase().indexOf(filter) > -1) {
            $(this).css('display','')
        } else {
            $(this).css('display','none')
        }
	});
}

function saveData(){
  
  var menuname = $('.menuname').val();
  var jsonDdata = [];
  var isTitleBlank = 2;
  $('.sortable > li').each(function(index){

  	if($(this).find('.title').val() == ''){
		isTitleBlank = 1;
	}
  	var children = [];
  	$(this).find('ul > li').each(function(index){

  		if($(this).find('.title').val() == ''){
  			isTitleBlank = 1;
  		}
  		children.push({type:$(this).find('.type').val(),id:$(this).find('.id').val(),title:$(this).find('.title').val(),href:$(this).find('.href').val(),class:$(this).find('.class').val()})
  	});
  	if(children){
  		jsonDdata.push({type:$(this).find('.type').val(),id:$(this).find('.id').val(),title:$(this).find('.title').val(),href:$(this).find('.href').val(),class:$(this).find('.class').val(),children:children})
  	} else {
  		jsonDdata.push({type:$(this).find('.type').val(),id:$(this).find('.id').val(),title:$(this).find('.title').val(),href:$(this).find('.href').val(),class:$(this).find('.class').val()})
  	}
  	

  });

  if(isTitleBlank == 2){
	  $.ajax({
	    type: "POST",
	    url: BASE_URL +'admin/menu-save-data',
	    data: {menu:menuname,jsonDdata:jsonDdata},
	    beforeSend:function(){

	      $('.btn-saveMenu').prop('disabled',true);
	      $('.btn-saveMenu').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
	    },
	    success:function(result){

	      var data = jQuery.parseJSON(result);
	      if(data.status == 1){
	        $('.btn-saveMenu').html('Saved');
	        toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/menu-settings'; }   });
	      } else {
	        $('.btn-saveMenu').prop('disabled',false);
	        $('.btn-saveMenu').html('Save');
	        toastr.error(data.msg, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
	      }
	    }
	  });
	} else {
		toastr.error('Title cannot be blank.', 'Failed', {timeOut: 2000,closeButton:true,progressBar:true});
	}
}

// function saveData(){
  
//   var menuname = $('.menuname').val();
//   var jsonDdata = [];
//   var isTitleBlank = 2;
// $('.sortable > li').each(function(index){
//   	var tot_t = {};
//   	if($(this).find('.title').val() == ''){
// 		isTitleBlank = 1;
// 	}
//   	var children = [];
//   	$(this).find('ul > li').each(function(index){

//   		if(!$(this).hasClass('nav-item')){
//   			if($(this).find('.title').val() == ''){
// 	  			isTitleBlank = 1;
// 	  		}
// 	  		var tot = {};
// 	  		$(this).find('.title').each(function(index){
// 	  			var lang = $(this).attr('lang');
// 	  			var val = $(this).val();
// 	  			if (!(lang in tot)) {
// 					tot[lang] = val;
// 				}
// 	  		});
	  		
// 	  		children.push({type:$(this).find('.type').val(),id:$(this).find('.id').val(),title:JSON.stringify(tot),href:$(this).find('.href').val(),class:$(this).find('.class').val()})
//   		}
//   	});
//   	$(this).find('.title').each(function(index){
//   		if (!$(this).hasClass('children')) {
//   			var lang_g = $(this).attr('lang');
// 			var val_l = $(this).val();
// 			if (!(lang_g in tot_t)) {
// 				tot_t[lang_g] = val_l;
// 			}
//   		}
// 	});
	
//   	if(children.length > 0){
//   		jsonDdata.push({type:$(this).find('.type').val(),id:$(this).find('.id').val(),title:JSON.stringify(tot_t),href:$(this).find('.href').val(),class:$(this).find('.class').val(),children:children})
//   	} else {
//   		jsonDdata.push({type:$(this).find('.type').val(),id:$(this).find('.id').val(),title:JSON.stringify(tot_t),href:$(this).find('.href').val(),class:$(this).find('.class').val()})
//   	}
  	

//   });

//   if(isTitleBlank == 2){
// 	  $.ajax({
// 	    type: "POST",
// 	    url: BASE_URL +'admin/menu-save-data',
// 	    data: {menu:menuname,jsonDdata:jsonDdata},
// 	    beforeSend:function(){

// 	      $('.btn-saveMenu').prop('disabled',true);
// 	      $('.btn-saveMenu').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
// 	    },
// 	    success:function(result){

// 	      var data = jQuery.parseJSON(result);
// 	      if(data.status == 1){
// 	        $('.btn-saveMenu').html('Saved');
// 	        toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/menu-settings'; }   });
// 	      } else {
// 	        $('.btn-saveMenu').prop('disabled',false);
// 	        $('.btn-saveMenu').html('Save');
// 	        toastr.error(data.msg, 'Save failed', {timeOut: 2000,closeButton:true,progressBar:true});
// 	      }
// 	    }
// 	  });
// 	} else {
// 		toastr.error('Title cannot be blank.', 'Failed', {timeOut: 2000,closeButton:true,progressBar:true});
// 	}
// }

function menuChange(menuname){

	$.ajax({
    type: "POST",
    url: BASE_URL +'admin/get-menu-data',
    data: {menu:menuname},
    beforeSend:function(){

      
    },
    success:function(result){

      var data = jQuery.parseJSON(result);
      $('.menu-list').html(data.html);
    }
  });
}