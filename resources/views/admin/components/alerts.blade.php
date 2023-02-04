@if (Session::has('msg') || Session::has('success') || $errors->any())
    @if (Session::has('msg')) 
        @php 
        $alert=[
                'heading' => "Success!",
                'message' => Session::get('msg')
            ]  
        @endphp
        @include('admin.components.alert-success', $alert)
    @endif

    @if (Session::has('success')) 
        @php 
        $alert=[
                'heading' => "Success!",
                'message' => Session::get('success')
            ]  
        @endphp
        @include('admin.components.alert-success', $alert)
    @endif
    
    @if (Session::has('verify')) 
        @php 
        $alert=[
                'heading' => "Email sent !!",
                'message' => Session::get('verify')
            ]  
        @endphp
        @include('admin.components.alert-warning', $alert)
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
        
        @php 
        $alert=[
                'heading' => "Oops!",
                'message' => $error
            ]  
        @endphp
        @include('admin.components.alert-danger', $alert)
        @endforeach
    @endif
@endif