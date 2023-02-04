@php
    $name = $alert['name'];
@endphp
<div class="container-xxl">
    <div class="rounded border-success border border-2 border-dashed s p-10 pb-0 d-flex flex-column flex-center card alert alert-dismissible  d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
        <!--begin::Close-->
        <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-success" data-bs-dismiss="alert">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                {!! getSvg('arr061') !!}
            </span>
            <!--end::Svg Icon-->
        </button>
        <!--end::Close-->
        <!--begin::Icon-->
        <!--begin::Svg Icon | path: icons/duotune/general/arr086.svg-->
        <span class="svg-icon svg-icon-5tx svg-icon-success mb-5">
            {!! getSvg('arr086') !!}
        </span>
        <!--end::Svg Icon-->
        <!--end::Icon-->
        <!--begin::Content-->
        <div class="text-center text-dark">
            <h1 class="fw-bolder mb-5"> <strong class="text-danger"> {{$name}}'s </strong> Module & Policy created !!</h1>
            <div class="separator separator-dashed border-success opacity-25 mb-5"></div>
            <div class="mb-9">You can use it in your blade template as 
				<br>
				<code>    &#64;can('create-{{$name}}') {!! '<span class="pre"> Yes - If you have permission to <span class="text-danger h5">create </span> '.$name.' </span>' !!}  &#64;endcan</code>
				<br>
				<code>    &#64;can('read-{{$name}}') {!! '<span class="pre"> Yes - If you have permission to  <span class="text-danger h5">read </span>  '.$name.' </span>' !!}  &#64;endcan</code>
				<br>
				<code>    &#64;can('update-{{$name}}') {!! '<span class="pre"> Yes - If you have permission to  <span class="text-danger h5">update </span>  '.$name.' </span>' !!}  &#64;endcan</code>
				<br>
				<code>    &#64;can('delete-{{$name}}') {!! '<span class="pre"> Yes - If you have permission to  <span class="text-danger h5">delete </span>  '.$name.' </span>' !!}  &#64;endcan</code>
				<br>
				
				or in routes as<code>  {!! "Route::get('/', function () { return view('welcome'); })->name('home')->middleware('<span class='text-danger h5'>can:read-$name' </span>);" !!} </code>
            </div>
            <!--begin::Buttons-->
            <div class="d-flex flex-center flex-wrap">
                <a href="javascript:void(0);" class="btn btn-success m-2"  data-bs-dismiss="alert">Ok, I got it</a>
            </div>
            <!--end::Buttons-->
        </div>
        <!--end::Content-->
    </div>
</div>