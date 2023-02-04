@extends('layouts.admin.master')
@section('styles')
<style>
    .change-image-button
    {
        cursor: pointer;
        position: absolute;
        right: -10px;
        top: -10px;
    }
</style>
@endsection
@section('content')

@php 
    $titles=[
            'title' => "Create",
            'sub-title' => "User",
            'btn' => "List",
            'url' => route('admin.users')
        ]  
@endphp
@include('admin.components.top-bar', $titles)

<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Alert-->
        @include('admin.components.alerts')
        <!--end::Alert-->
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10" id="kt_modal_add_user">
            <form action="{{route('admin.users.store')}}" id="kt_modal_add_user_form" class="form mb-15 fv-plugins-bootstrap5 fv-plugins-framework" method="post" enctype="multipart/form-data">
                @csrf
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="  mb-3">
                    
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row row mb-7">
                            <div class="col-lg-3">
                                
                                <!--begin::Label-->
                                <label class="d-block fw-bold fs-6 mb-5">Avatar</label>
                                <!--end::Label-->
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{asset(Storage::url('img/user.png'))}})">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset(Storage::url('img/user.png'))}});"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow change-image-button"  data-kt-image-input-action="change"  data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="bi bi-pencil-fill "></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="avatar" class="d-none" accept=".jpg,.png,.jpeg,.gif"  onchange="renderImgCrop(this, '.image-input-wrapper' ,1/1,'bg');">
                                        
                                        <div class="d-none">
                                            <input type="hidden" name="x" id="x" value="" class="x"  >
                                            <input type="hidden" name="y" id="y" value="" class="y"  >
                                            <input type="hidden" name="width" id="width" value="" class="width"  >
                                            <input type="hidden" name="height" id="height" value="" class="height"  >

                                        </div>
                                        
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    {{-- <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Remove--> --}}
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                <!--end::Hint-->

                            </div>
                            <div class="col-lg-9">
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-3 col-form-label fw-bold fs-6">
                                        <span class="required">Email </span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email must be valid and unique"></i>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-9 fv-row">
                                        <input type="email" name="email" class=" @error('email') is-invalid border-danger @enderror form-control form-control-solid mb-3 mb-lg-0" placeholder="johndoe@gmail.com" required />
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-bold fs-6">
                                        <span class="required">Password</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Password must be 8 digits long"></i>
                                    </label>
                                    <div class="col-lg-9 fv-row">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row" data-kt-password-meter="true">
                                            <!--begin::Wrapper-->
                                            <div class="mb-1">
                                                <!--begin::Input wrapper-->
                                                <div class="position-relative mb-3">
                                                    <input class=" @error('password') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" type="password" placeholder="*******" name="password" autocomplete="off" required/>
                                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                        <i class="bi bi-eye-slash fs-2"></i>
                                                        <i class="bi bi-eye fs-2 d-none"></i>
                                                    </span>
                                                </div>
                                                <!--end::Input wrapper-->
                                                <!--begin::Meter-->
                                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                                </div>
                                                <!--end::Meter-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Hint-->
                                            <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
                                            <!--end::Hint-->
                                        </div>
                                        <!--end::Input group=-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-3 col-form-label fw-bold fs-6">
                                        <span class="required">Role</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="All role have different permissions"></i>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-9 fv-row">
                                        <!--begin::Roles-->
                                        <div class="  @error('role') is-invalid border-danger @enderror  row">
                                        @forelse ($roles as $key => $role)
                                            
                                        <!--begin::Input row-->
                                            <!--begin::Radio-->
                                            <div class="col-lg-3 form-check form-check-custom form-check-solid px-5 my-5">
                                                <span class=" border-danger border-2 border-start-dotted ps-2">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input me-3" name="role" type="radio" value="{{$role->id}}" id="kt_modal_update_role_option_{{$key}}" required @if($key == 0) checked @endif />
                                                    <!--end::Input-->
                                                    <!--begin::Label-->
                                                    <label class="form-check-label px-2" for="kt_modal_update_role_option_{{$key}}">
                                                        <div class="fw-bolder text-gray-800">{{$role->name}}</div>
                                                    </label>
                                                    <!--end::Label-->

                                                </span>
                                            </div>
                                            <!--end::Radio-->
                                        <!--end::Input row-->
                                        @empty
                                            
                                        @endforelse
                                    </div>
                                        
                                        <!--end::Roles-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-3 col-form-label required fw-bold fs-6">Full Name</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-9">
														<!--begin::Row-->
														<div class="row">
															<!--begin::Col-->
															<div class="col-lg-6 fv-row">
																<input type="text" name="first_name" class=" @error('first_name') is-invalid border-danger @enderror form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name"  />
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col-lg-6 fv-row">
																<input type="text" name="last_name" class=" @error('last_name') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" placeholder="Last name"  />
															</div>
															<!--end::Col-->
														</div>
														<!--end::Row-->
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-3 col-form-label fw-bold fs-6">
														<span class="required">Contact Phone</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-9 fv-row">
														<input type="tel" name="phone" class=" @error('phone') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{auth()->user()->phone}}" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-3 col-form-label fw-bold fs-6">
														<span class="required">Address</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Current complete address"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-9 fv-row">
														<input type="text" name="address" class=" @error('address') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" placeholder="Apt#123 , NewYork , United States..." value="{{auth()->user()->address}}" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-3 col-form-label fw-bold fs-6">
														<span class="required">Country</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Country of origination"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-9 fv-row">
														<select name="country" aria-label="Select a Country" data-control="select2" data-placeholder="Select a country..." class=" @error('country') is-invalid border-danger @enderror form-select form-select-solid form-select-lg fw-bold" onchange="fetchStatesByCountry(this, 'state', '{{ url('/') }}');" required>
															<option value="">Select a Country...</option>
                                                            @forelse ($COUNTRIES as $country)
                                                            <option value="{{$country->id}}" >{{$country->name}}</option>
                                                            @empty
                                                            @endforelse
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-3 col-form-label fw-bold fs-6">
														<span class="required">State</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="State of origination"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-9 fv-row">
														<select name="state" aria-label="Select a State" data-control="select2" data-placeholder="Select a state..." class=" @error('state') is-invalid border-danger @enderror form-select form-select-solid form-select-lg fw-bold" onchange="fetchCitiesByState(this, 'city', '{{ url('/') }}');" required>
                                                                <option value="">Select Country First...</option>
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-3 col-form-label fw-bold fs-6">
														<span class="required">City</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="City of origination"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-9 fv-row">
														<select name="city" aria-label="Select a City" data-control="select2" data-placeholder="Select a city..." class=" @error('city') is-invalid border-danger @enderror form-select form-select-solid form-select-lg fw-bold"   required>

                                                                <option value="">Select State First...</option>
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-end pt-15">
                        <button type="submit" class="btn btn-success" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                        
                </div>
                <!--end::Details-->
            </div>
        </form>
        </div>
        <!--end::Navbar-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->

<!--include::Cropper Modal-->  
@php 
$modal=[
        'title' => "Set User's Image",
        'ratio' => "1:1"
    ]  
@endphp
@include('admin.components.cropper-modal',$modal)  
@endsection
@push('js')

<script src="{{asset('admin/assets/js/custom/apps/user-management/users/list/add.js')}}"></script>
@endpush
@section('scripts')
<!-- Custom Functions -->
<script>

</script>

<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection