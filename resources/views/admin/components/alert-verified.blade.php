
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
            <h1 class="fw-bolder mb-5">Email Verified !!</h1>
            <div class="separator separator-dashed border-success opacity-25 mb-5"></div>
            <div class="mb-9">Your email is verified and now you can use all features of
                <strong>{{siteSetting('title')}}</strong>
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