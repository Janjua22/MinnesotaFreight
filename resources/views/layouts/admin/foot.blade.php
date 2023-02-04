<script src="{{asset('admin/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('admin/assets/js/scripts.bundle.js')}}"></script>
<script src="{{asset('admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{ asset('admin/assets/js/cropper.min.js') }}"> </script>
<script src="{{asset('admin/assets/js/custom/location.js')}}"></script>
<script src="{{asset('admin/assets/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
<script src="{{asset('admin/assets/plugins/custom/live-search/live-search.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ siteSetting('map_key') }}&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
</script>
<script src="{{asset('admin/assets/js/my-script.js')}}"></script>

@stack('js')
<!-- Custom code in footer from Site Settings -->
{!! siteSetting('custom_footer') !!}