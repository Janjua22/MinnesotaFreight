toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "500",
    "hideDuration": "500",
    "timeOut": "2000",
    "extendedTimeOut": "0",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
let ImgPlaceholder = null;
let ImgRatio = null;
let ImgPosition = null;
let ImgX = null;
let ImgY = null;
let ImgWidth = null;
let ImgHeight = null;
let table = document.getElementById('kt_subscriptions_table');
let datatable;
	
let renderImgCrop = (elem, placeholder, ratio , position)=>{
	ImgPlaceholder = placeholder;
	ImgRatio = ratio;
	ImgPosition = position;
	const inputs = $(elem).next();
	ImgX = inputs.find('.x');
	ImgY = inputs.find('.y');
	ImgWidth = inputs.find('.width');;
	ImgHeight = inputs.find('.height');;
	
	if(elem.files && elem.files[0]){
		var reader = new FileReader();
		
		reader.onload = function(e){
			$(placeholder).attr('src', e.target.result);
			$('#imageInModal').attr('src', e.target.result);
			// $('#imageField').val(placeholder);
			$('#renderImgRatio').val(ratio);
			$('#renderImgX').val(x);
			$('#renderImgY').val(y);
			$('#renderImgWidth').val(width);
			$('#renderImgHeight').val(height);
		}
		
		reader.readAsDataURL(elem.files[0]);
	}
    $('#featureModal').modal('show');
}
	
$('#featureModal').on('shown.bs.modal', function(){
    const image = document.getElementById('imageInModal');
    var ratio = ImgRatio;
    cropper = new Cropper(image, {
        aspectRatio: parseFloat(ratio),
        viewMode: 1,
        zoomable:false,
        crop(event) {
            $(ImgX).val(event.detail.x);
            $(ImgY).val(event.detail.y);
            $(ImgWidth).val(event.detail.width);
            $(ImgHeight).val(event.detail.height);
        },
    });
}).on('hidden.bs.modal', function(){
    if(ImgPosition == 'bg'){
        $(ImgPlaceholder).css("background-image", "url("+cropper.getCroppedCanvas().toDataURL()+")");
    } else{
        $(ImgPlaceholder).attr('src',cropper.getCroppedCanvas().toDataURL());
    }

    cropper.destroy();
    ImgPlaceholder = null;
    ImgRatio = null;
    ImgX = null;
    ImgY = null;
    ImgWidth = null;
    ImgHeight = null;
});
	
function formatText (icon) {
    return $('<span><i class="' + $(icon.element).data('icon') + ' fs-3"></i> ' + icon.text + '</span>');
};

$('.select2_icon').select2({
    // width: "50%",
    templateSelection: formatText,
    templateResult: formatText
});

function showPaymentFields(elem){
    for(let i=1; i<=4; i++){
        $(`#pay${i}`).addClass('d-none');
    }

    switch($(elem).val()){
        case '1':
            $('#pay1').removeClass('d-none');
            break;
        case '2':
            $('#pay2').removeClass('d-none');
            break;
        case '3':
            $('#pay3').removeClass('d-none');
            break;
        default:
            $('#pay4').removeClass('d-none');
            break;
    }
}

let handleSearch = ()=>{
    const filterSearch = document.querySelector('[data-kt-subscription-table-filter="search"]');

    filterSearch.addEventListener('keyup', function(e){
        datatable.search(e.target.value).draw();
    });
}

// Delete subscirption
/*let handleRowDeletion = ()=>{
    const deleteButtons = table.querySelectorAll('[data-kt-subscriptions-table-filter="delete_row"]');

    deleteButtons.forEach(d => {
        d.addEventListener('click', function (e) {
            e.preventDefault();

            const parent = e.target.closest('tr');
            const customerName = parent.querySelectorAll('td')[0].innerText;

            Swal.fire({
                text: "Are you sure you want to delete " + customerName + "?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                $('#deleteForm input[name=delete_trace]').val($(d).attr('data-id'));
                
                if (result.value) {
                    Swal.fire({
                        text: "You have deleted " + customerName + "!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Close",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function () {
                        datatable.row($(parent)).remove().draw();
                        $('#deleteForm').submit();
                    }).then(function () {
                        // toggleToolbars();
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: customerName + " was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
        })
    });
}*/

let removeRecord = e =>{
    const parent = e.closest('tr');
    const customerName = parent.querySelectorAll('td')[0].innerText;

    Swal.fire({
        text: "Are you sure you want to delete " + customerName + "?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Yes, delete!",
        cancelButtonText: "No, cancel",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    }).then(function (result) {
        $('#deleteForm input[name=delete_trace]').val($(e).attr('data-id'));
        
        if (result.value) {
            $('#deleteForm').submit();
            
            Swal.fire({
                text: "You have deleted " + customerName + "!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Close",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                }
            }).then(function () {
                datatable.row($(parent)).remove().draw();
            }).then(function () {
                // toggleToolbars();
            });
        } else if (result.dismiss === 'cancel') {
            Swal.fire({
                text: customerName + " was not deleted.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                }
            });
        }
    });
}

function addClone(identifier){
    let element =  $(identifier);
    let clone = element.filter(':first').clone();

    element.removeClass('d-none');
    clone.insertAfter(element.filter(':last'));

    let inputs = clone[0].querySelectorAll("input");

    for (i = 0; i < inputs.length; ++i) {
        inputs[i].value = "";
    }
}

function removeClone(e, identifier){
    e.closest(identifier).remove();
}

/**
 * Google maps init for location and customer module...
 */
 function initAutocomplete(){
    var map = new google.maps.Map(document.getElementById('map-location'), {
        center: {
            lat: 44.9706969720165,
            lng: -93.26147848324939
        },
        zoom: 6,
        mapTypeId: 'roadmap'
    });
    
    var marker;
    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');

    var searchBox = new google.maps.places.SearchBox(input);
    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];

    let setLat = $('input[name=latitude]').val();
    let setLng = $('input[name=longitude]').val();

    if(setLat && setLng){
        map.setCenter({lat: parseFloat(setLat), lng: parseFloat(setLng)});
        map.setZoom(12);

        marker = new google.maps.Marker({
            position: {lat: parseFloat(setLat), lng: parseFloat(setLng)},
            map: map,
        });
    }

    // Configure the click listener.
    map.addListener('click', function(mapsMouseEvent){
        if(marker) {
            marker.setPosition(mapsMouseEvent.latLng);
        } else {
            marker = new google.maps.Marker({
                position: mapsMouseEvent.latLng,
                map: map
            });
        }
        map.panTo(mapsMouseEvent.latLng);
        $('input[name=latitude]').val(mapsMouseEvent.latLng.lat());
        $('input[name=longitude').val(mapsMouseEvent.latLng.lng());
        console.log(mapsMouseEvent.latLng.lat());
    });

    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function(e) {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();

        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            // markers.push(new google.maps.Marker({
            //     map: map,
            //     icon: icon,
            //     title: place.name,
            //     position: place.geometry.location
            // }));

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);

        marker = new google.maps.Marker({
            position: {lat: bounds.getCenter().lat(), lng: bounds.getCenter().lng()},
            map: map
        });

        $('input[name=latitude]').val(bounds.getCenter().lat());
        $('input[name=longitude').val(bounds.getCenter().lng());
    });
}

$(function(){
    datatable = $(table).DataTable({
        "info": false,
        'order': [],
        "pageLength": 10,
        "lengthChange": false,
        "ordering": false
    });

    handleSearch();
    handleRowDeletion();
});