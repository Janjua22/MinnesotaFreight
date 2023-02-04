<div class="toolbar border-top" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{$titles['title']}} {{$titles['sub-title']}}</h1>
            <span class="h-20px border-gray-200 border-start mx-4"></span>
            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}" class="text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">{{$titles['title']}}</li>
                @if($titles['sub-title'])
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-dark">{{$titles['sub-title']}}</li>
                @endif
            </ul>
        </div>
        @if($titles['btn'] && $titles['url'] )
        <div class="d-flex align-items-center py-1">
            <a href="{{$titles['url']}}" class="btn btn-sm btn-success" >{{$titles['btn']}}</a>
        </div>
        @endif
    </div>
</div>
@if (auth()->user()->hasVerifiedEmail() && intval (Request::get('verified')) == 1)
    @include('admin.components.alert-verified')
@endif