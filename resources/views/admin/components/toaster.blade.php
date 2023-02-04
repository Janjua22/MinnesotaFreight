

<script>
    @if (Session::has('msg'))
        toastr.success("{!! Session::get('msg') !!}", "Success");				
    @endif
    
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}", "Error");
        @endforeach
    @endif
</script>