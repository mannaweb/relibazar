

function searchFilter(page_num,loadingType) {
    page_num = page_num?page_num:0;
    var sortBy = $('#sortBy').val();
    var sortByField = $('#sortByField').val();
    var perPage = $('#perPage').val();
   
    var keyword = $('#keyword').val();
    $.ajax({
        type: 'POST',
        url: BASE_URL+'admin/contact-search-data/'+page_num,
        data:'page='+page_num+'&sortBy='+sortBy+'&sortByField='+sortByField+'&perPage='+perPage+'&keyword='+keyword,
        beforeSend: function () {
            $('.preloader').addClass('active');
            $('.table-responsive').addClass('overflow-hidden');
        },
        success: function (html) {
            var data = jQuery.parseJSON(html);
            $('#contactlist').html(data.html);
            $('#paginationDiv').html(data.pagination);
            $('.ordering').keyup(myFunction);
            if(loadingType != 1){
                $('html, body').animate({scrollTop:$('#contactlist').offset().top - 200 }, 500);
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
    $("#status").val('').trigger('change');
    $("#category").val('').trigger('change');
    $('#keyword').val('');
    searchFilter();
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
            url: BASE_URL +'admin/save-contact-ordering',
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










$(document).ready(function(){
    searchFilter('',1)
    
});



