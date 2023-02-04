
<div class="alert alert-dismissible bg-success d-flex flex-column flex-sm-row w-100 p-5 mb-10">
    <!--begin::Icon-->
    <!--begin::Svg Icon | path: icons/duotune/art/gen048.svg-->
    <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
        {!! getSvg('gen048') !!}
    </span>
    <!--end::Svg Icon-->
    <!--end::Icon-->
    <!--begin::Content-->
    <div class="d-flex flex-column text-light pe-0 pe-sm-10">
        <h4 class="mb-2 text-light">{{$alert['heading']}}</h4>
        <span> {{$alert['message']}}</span>
    </div>
    <!--end::Content-->
    <!--begin::Close-->
    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
        <span class="svg-icon svg-icon-2x svg-icon-light">
            {!! getSvg('arr061') !!}
        </span>
        <!--end::Svg Icon-->
    </button>
    <!--end::Close-->
</div>