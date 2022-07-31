function saveData(){

  var formData = new FormData($("#manageForm")[0]);
  $.ajax({
    type: "POST",
    url: BASE_URL +'admin/store-save-data',
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
        toastr.success(data.msg, 'Saved', {timeOut: 1000,progressBar:true,onHidden:function() { window.location.href = BASE_URL+'admin/stores'; }   });
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
  var keyword = $('#keyword').val();
  var popular = $('#popular').val();
  var startEnd = $('#startEnd').val();

  $.ajax({
    type: 'POST',
    url: BASE_URL+'admin/store-search-data/'+page_num,
    data:'page='+page_num+'&sortBy='+sortBy+'&sortByField='+sortByField+'&perPage='+perPage+'&status='+status+'&keyword='+keyword+'&popular='+popular+'&startEnd='+startEnd,
    beforeSend: function () {
      $('.preloader').addClass('active');
      $('.table-responsive').addClass('overflow-hidden');
    },
    success: function (html) {
      var data = jQuery.parseJSON(html);
      $('#storesList').html(data.html);
      $('#paginationDiv').html(data.pagination);
      if(loadingType != 1){
        $('html, body').animate({scrollTop:$('#storesList').offset().top - 200 }, 500);
      }
      $('.preloader').removeClass('active');
      $('.table-responsive').removeClass('overflow-hidden');
    }
  });
}


function sortBy(field,sortByField,sortBy){
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


function deleteStore(id){

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
    url: BASE_URL+'admin/delete-store',
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
    url: BASE_URL+'admin/change-status-store',
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







$(document).ready(function(){


  var url = window.location.href;
  var param = url.split('/');
  if( param[param.length - 1] && param[param.length - 1] == 'stores' ){
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
  
  }else{
    $(function() {
  $('#expire_date').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');
    //alert("You are " + years + " years old!");
  });
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
     
     
    });
    if(enable){
      saveData();
    }

  });


  

  $(".cancelButton").click(function(){
    window.location.href=BASE_URL+"admin/stores";
  });

});




if (typeof google === 'object' && typeof google.maps === 'object') {

  

    initMap();

} else {

    var script = document.createElement("script");

    script.type = "text/javascript";

    script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDzyb77sOPwJdR8WINUuDX5EG51--WJDJ4&libraries=places&callback=initMap";

    document.body.appendChild(script);

}

 var componentForm = {

        locality: 'long_name',

        administrative_area_level_1: 'long_name',

        country: 'long_name',

        postal_code: 'short_name'

    };







    var input = document.getElementById('autocomplete');

    

    function initMap() {

        var latitude = parseFloat(document.getElementById('latitude').value);

        var longitude = parseFloat(document.getElementById('longitude').value);

        var geocoder;

        var autocomplete;



        geocoder = new google.maps.Geocoder();

        // var map = new google.maps.Map(document.getElementById('map'), {

        //     center: {

        //         lat: latitude,

        //         lng: longitude

        //     },

        //     zoom: 15

        // });

        // var card = document.getElementById('locationField');

        // autocomplete = new google.maps.places.Autocomplete(input);

        // autocomplete.bindTo('bounds', map);

        // var infowindow = new google.maps.InfoWindow();

        // var infowindowContent = document.getElementById('infowindow-content');

        // infowindow.setContent(infowindowContent);

        // var marker = new google.maps.Marker({

        //     map: map,

        //     anchorPoint: new google.maps.Point(0, -29),

        //     draggable: true

        // });



        autocomplete.addListener('place_changed', function() {

            infowindow.close();

            marker.setVisible(false);

            var place = autocomplete.getPlace();

            console.log(place);



            if (!place.geometry) {

                window.alert("No details available for input: '" + place.name + "'");

                return;

            }



            if (place.geometry.viewport) {

                map.fitBounds(place.geometry.viewport);

            } else {

                map.setCenter(place.geometry.location);

                map.setZoom(17);

            }

            marker.setPosition(place.geometry.location);

            marker.setVisible(true);



            var address = '';

            if (place.address_components) {

                address = [

                    (place.address_components[0] && place.address_components[0].short_name || ''),

                    (place.address_components[1] && place.address_components[1].short_name || ''),

                    (place.address_components[2] && place.address_components[2].short_name || '')

                ].join(' ');

            }



            //infowindowContent.children['place-icon'].src = place.icon;

            //infowindowContent.children['place-name'].textContent = place.name;

           // infowindowContent.children['place-address'].textContent = address;

            //infowindow.open(map, marker);

            fillInAddress();



        });



        function fillInAddress(new_address) {

            if (typeof new_address == 'undefined') {

                var place = autocomplete.getPlace(input);

            } else {

                place = new_address;

            }

           

            for (var component in componentForm) {

                document.getElementById(component).value = '';

                document.getElementById(component).disabled = false;

            }

            var address = document.getElementById('autocomplete').value;

            findlatlong(address);

           

            for (var i = 0; i < place.address_components.length; i++) {

                var addressType = place.address_components[i].types[0];

                if (componentForm[addressType]) {

                    var val = place.address_components[i][componentForm[addressType]];

                    document.getElementById(addressType).value = val;

                }

            }

        }

        function findlatlong(address){

        var geocoder = new google.maps.Geocoder();

        geocoder.geocode( { 'address': address}, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {

                var latitude = results[0].geometry.location.lat();

                var longitude = results[0].geometry.location.lng();

                document.getElementById('latitude').value = latitude;

                document.getElementById('longitude').value = longitude;

            } 

        }); 

    }



        // google.maps.event.addListener(marker, 'dragend', function() {

        //     geocoder.geocode({

        //         'latLng': marker.getPosition()

        //     }, function(results, status) {

        //         if (status == google.maps.GeocoderStatus.OK) {

        //             if (results[0]) {

        //                 console.log(autocomplete);

        //                 $('#autocomplete').val(results[0].formatted_address);

        //                 $('#latitude').val(marker.getPosition().lat());

        //                 $('#longitude').val(marker.getPosition().lng());

        //                 //infowindow.setContent(results[0].formatted_address);

        //                // infowindow.open(map, marker);

        //                 // google.maps.event.trigger(autocomplete, 'place_changed');

        //                 fillInAddress(results[0]);

        //             }

        //         }

        //     });

        // });

    }
