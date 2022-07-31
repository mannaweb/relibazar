function saveData(){
    var formData = new FormData($("#manageForm")[0]);
    tinyMCE.triggerSave();
    $( ".tinymce" ).each(function( index,element ) {
        var value = $(element).val();
        var reg = /\<body[^>]*\>([^]*)\<\/body/m;
        var content = $.trim(value.match( reg )[1]);
        formData.append($(element).attr('name'), content);
    });
    $.ajax({
        type: "POST",
        url: BASE_URL +'admin/faq-save-data',
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
                toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/faqs'; }   });
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
      var startEnd = $('#startEnd').val();
    $.ajax({
        type: 'POST',
        url: BASE_URL+'admin/faq-search-data/'+page_num,
        data:'page='+page_num+'&sortBy='+sortBy+'&sortByField='+sortByField+'&perPage='+perPage+'&status='+status+'&keyword='+keyword+'&category='+category+'&startEnd='+startEnd,
        beforeSend: function () {
            $('.preloader').addClass('active');
            $('.table-responsive').addClass('overflow-hidden');
        },
        success: function (html) {
            var data = jQuery.parseJSON(html);
            $('#faqslist').html(data.html);
            $('#paginationDiv').html(data.pagination);
            $('.ordering').keyup(myFunction);
            if(loadingType != 1){
                $('html, body').animate({scrollTop:$('#faqslist').offset().top - 200 }, 500);
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
            url: BASE_URL +'admin/save-faq-ordering',
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

function deletefaq(id){
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
        url: BASE_URL+'admin/delete-faq',
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

function statusChange(id,status){
    $.ajax({
        type: 'POST',
        url: BASE_URL+'admin/change-status-faq',
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
                  $('#status_a_'+id).attr('onclick', 'statusChange('+id+',0)');
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

// function tinymceValidation() {
//     var question = tinymce.get("question").getContent({format: 'text'});
//     var answer = tinymce.get("answer").getContent({format: 'text'});

//     var question = $(question).text().replace(/\s/g,"");
//     var answer = $(answer).text().replace(/\s/g,"");
//     if (question == "" || answer == "") {
//         return false;
//     } else {
//         return true;
//     }
// }

function categoryValidation() {
    var i = 0;
    $('.custom-input').each(function(){
        if($(this).is(':checked')){
            i++;
        }
    });
    if(i == 0){
        return false;
    }else{
        return true;
    }
}

$(document).ready(function(){
    var url = window.location.href;
    var param = url.split('/');
    if( param[param.length - 1] && param[param.length - 1] == 'faqs' ){
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
        tinyMCE.triggerSave();
        var enable = true;
        $( ".validate" ).each(function( index,element ) { 
            var value = $(element).val();
            var reg = /\<body[^>]*\>([^]*)\<\/body/m;
            var content = $.trim(value.match( reg )[1]);
            if(content == ''){
                toastr.error($(element).data('validate-msg'), 'Validation failed', {timeOut: 2000,closeButton:true,progressBar:true});
                enable = false;
                return false;
            }
        });

        if(enable){
            saveData();
        }
    });

    $(".cancelButton").click(function(){
        window.location.href=BASE_URL+"admin/faqs";
    });
});


$('body').on('change','.sub_cat',function(){
    var value = $(this).val();
    var main_cat_val = $(this).attr('main_cat_val');
    console.log(value+'/'+main_cat_val);

    if($(this).is(':checked')){
        $('.main_cat[value='+main_cat_val+']').prop('checked',true);
    }else{
        $('.main_cat[value='+main_cat_val+']').prop('checked',false);
    }
});

$('body').on('change','.main_cat',function(){
    var value = $(this).val();

    if($(this).is(':checked')){
        //$('.main_cat[value='+main_cat_val+']').prop('checked',true);
    }else{
        $('.sub_cat[main_cat_val='+value+']').prop('checked',false);
    }
});

$('body').on('click','.check_class',function(){
    var value = $(this).attr('cat_val');
        $('.main_cat[value='+value+']').prop('checked',true);
        $('.sub_cat[main_cat_val='+value+']').prop('checked',true);
    
});
