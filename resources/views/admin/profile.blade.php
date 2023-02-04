@extends('layouts.admin.master')
@section('styles')
    <style>
		.image-container button {
		  position: absolute;
		  top: 60%;
		  left: 50%;
		  transform: translate(-50%, -50%);
		  -ms-transform: translate(-50%, -50%);
		  opacity:0;
		} 
		.image-container:hover button {   
		  opacity: .8;
		}
		.img-change {
			margin-top: 27% !important;
			width: 100%;
		}

    </style>
@endsection
@section('content')
    
@php 
$titles=[
		'title' => "Account",
		'sub-title' => "Settings",
		'btn' => '',
		'url' => '',
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
								<div class="card mb-5 mb-xl-10">
									<div class="card-body pt-9 pb-0">
										<!--begin::Details-->
										<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
											<!--begin: Pic-->
											<div class="me-7 mb-4">
												<div class="symbol image-container symbol-100px symbol-lg-160px symbol-fixed position-relative">
													<img src="{{asset(Storage::url(Auth::user()->image))}}" alt="image" />
													<button class="btn btn-success img-change"  onclick='$("#hiddenImage").click();'>Change Image</button>
													
													<input type="hidden" name="profile_image"  id="profile_image"   style="cursor: pointer"/>
													<div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
												</div>
											</div>
											<!--end::Pic-->
											<!--begin::Info-->
											<div class="flex-grow-1">
												<!--begin::Title-->
												<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
													<!--begin::User-->
													<div class="d-flex flex-column">
														<!--begin::Name-->
														<div class="d-flex align-items-center mb-2">
															<a href="javascript:void(0);" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{Auth::user()->first_name}} {{Auth::user()->last_name}} </a>
															@if(auth()->user()->hasVerifiedEmail())
															<a href="javascript:void(0);"  data-bs-toggle="tooltip" title="You are a verified user">
																<!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
																<span class="svg-icon svg-icon-1 svg-icon-primary">
                                                                {!! getSvg('gen026') !!}
																</span>
																<!--end::Svg Icon-->
															</a>
															@endif
															<a href="javascript:void(0);" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3">{{Auth::user()->role->name}}</a>
														</div>
														<!--end::Name-->
														<!--begin::Info-->
														<div class="flex-wrap fw-bold fs-6 mb-4 pe-2">
															<a href="javascript:void(0);" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
															<!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
															<span class="svg-icon svg-icon-4 me-1">
																{!! getSvg('com011') !!}
															</span>
															<!--end::Svg Icon-->{{Auth::user()->role->name}}</a>
                                                            <br>
															<a href="javascript:void(0);" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
															<!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
															<span class="svg-icon svg-icon-4 me-1">
	                                                            {!! getSvg('gen018') !!}
															</span>
															<!--end::Svg Icon-->{{Auth::user()->address}} </a>
                                                            <br>
															<a href="javascript:void(0);" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
															<!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
															<span class="svg-icon svg-icon-4 me-1">
																{!! getSvg('com006') !!}
															</span>
															<!--end::Svg Icon-->{{Auth::user()->email}}</a>
														</div>
														<!--end::Info-->
													</div>
													<!--end::User-->
												</div>
												<!--end::Title-->
                                            </div>
											<!--end::Info-->
										</div>
										<!--end::Details-->
										<!--begin::Navs-->
										<div class="d-flex overflow-auto h-55px">
											<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
												<!--begin::Nav item-->
												<li class="nav-item">
													<a class="nav-link text-active-primary me-6 active" href="javascript:void(0);">Details</a>
												</li>
												<!--end::Nav item-->
											</ul>
										</div>
										<!--begin::Navs-->
									</div>
								</div>
								<!--end::Navbar-->
								<!--begin::Basic info-->
								<div class="card mb-5 mb-xl-10">
									<!--begin::Card header-->
									<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
										<!--begin::Card title-->
										<div class="card-title m-0">
											<h3 class="fw-bolder m-0">Profile Details</h3>
										</div>
										<!--end::Card title-->
									</div>
									<!--begin::Card header-->
									<!--begin::Content-->
									<div id="kt_account_profile_details" class="collapse show">
										<!--begin::Form-->
										<form id="kt_account_profile_details_form" class="form" method="POST" action="{{route('admin.users.profile-update-details')}}">
                                            @csrf
											<!--begin::Card body-->
											<div class="card-body border-top p-9">
												<!--begin::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Full Name</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8">
														<!--begin::Row-->
														<div class="row">
															<!--begin::Col-->
															<div class="col-lg-6 fv-row">
																<input type="text" name="first_name" class=" @error('first_name') is-invalid border-danger @enderror form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="{{auth()->user()->first_name}}" />
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col-lg-6 fv-row">
																<input type="text" name="last_name" class=" @error('last_name') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" placeholder="Last name" value="{{auth()->user()->last_name}}" />
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
													<label class="col-lg-4 col-form-label fw-bold fs-6">
														<span class="required">Contact Phone</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="tel" name="phone" class=" @error('phone') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{auth()->user()->phone}}" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label fw-bold fs-6">
														<span class="required">Address</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Current complete address"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="tel" name="address" class=" @error('address') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" placeholder="Apt#123 , NewYork , United States..." value="{{auth()->user()->address}}" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label fw-bold fs-6">
														<span class="required">Country</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Country of origination"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="country" aria-label="Select a Country" data-control="select2" data-placeholder="Select a country..." class=" @error('country') is-invalid border-danger @enderror form-select form-select-solid form-select-lg fw-bold" onchange="fetchStatesByCountry(this, 'state', '{{ url('/') }}');" required>
															<option value="">Select a Country...</option>
                                                            @forelse ($COUNTRIES as $country)
                                                            <option value="{{$country->id}}"  @if(auth()->user()->country_id == $country->id ) selected @endif>{{$country->name}}</option>
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
													<label class="col-lg-4 col-form-label fw-bold fs-6">
														<span class="required">State</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="State of origination"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="state" aria-label="Select a State" data-control="select2" data-placeholder="Select a state..." class=" @error('state') is-invalid border-danger @enderror form-select form-select-solid form-select-lg fw-bold" onchange="fetchCitiesByState(this, 'city', '{{ url('/') }}');" required>
                                                            @if (auth()->user()->state_id)
                                                                <option  value="{{auth()->user()->state_id}}">{{auth()->user()->state->name}}</option>
                                                            @else
                                                                <option value="">Select Country First...</option>
                                                            @endif
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label fw-bold fs-6">
														<span class="required">City</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="City of origination"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="city" aria-label="Select a City" data-control="select2" data-placeholder="Select a city..." class=" @error('city') is-invalid border-danger @enderror form-select form-select-solid form-select-lg fw-bold"   required>

                                                            @if (auth()->user()->city_id)
                                                                <option  value="{{auth()->user()->city_id}}">{{auth()->user()->city->name}}</option>
                                                            @else
                                                                <option value="">Select State First...</option>
                                                            @endif
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
											</div>
											<!--end::Card body-->
											<!--begin::Actions-->
											<div class="card-footer d-flex justify-content-end py-6 px-9">
												<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
												<button type="submit" class="btn btn-success" id="kt_account_profile_details_submit">Save Changes</button>
											</div>
											<!--end::Actions-->
										</form>
										<!--end::Form-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Basic info-->
								<!--begin::Sign-in Method-->
								<div class="card mb-5 mb-xl-10">
									<!--begin::Card header-->
									<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
										<div class="card-title m-0">
											<h3 class="fw-bolder m-0">Sign-in Method</h3>
										</div>
									</div>
									<!--end::Card header-->
									<!--begin::Content-->
									<div id="kt_account_signin_method" class="collapse show">
										<!--begin::Card body-->
										<div class="card-body border-top p-9">
											<!--begin::Email Address-->
											<div class="d-flex flex-wrap align-items-center">
												<!--begin::Label-->
												<div id="kt_signin_email">
													<div class="fs-6 fw-bolder mb-1">Email Address</div>
													<div class="fw-bold text-gray-600">{{auth()->user()->email}}</div>
												</div>
												<!--end::Label-->
												<!--begin::Edit-->
												<div id="kt_signin_email_edit" class="flex-row-fluid d-none">
													<!--begin::Form-->
													<form id="kt_signin_change_email" class="form" novalidate="novalidate" method="POST" action="{{route('admin.users.profile-update-email')}}" >
                                                        @csrf
														<div class="row mb-6">
															<div class="col-lg-6 mb-4 mb-lg-0">
																<div class="fv-row mb-0">
																	<label for="emailaddress" class="form-label fs-6 fw-bolder mb-3">Enter New Email Address</label>
																	<input type="email" class=" @error('email') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" id="emailaddress" placeholder="Email Address" name="email" value="{{auth()->user()->email}}" required />
																</div>
															</div>
															<div class="col-lg-6">
																<div class="fv-row mb-0">
																	<label for="confirmemailpassword" class="form-label fs-6 fw-bolder mb-3">Confirm Password</label>
																	<input type="password" class=" @error('password') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" name="confirmemailpassword" id="confirmemailpassword" required/>
																</div>
															</div>
														</div>
														<div class="d-flex">
															<button id="kt_signin_submit" type="submit" class="btn btn-success me-2 px-6">Update Email</button>
															<button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
														</div>
													</form>
													<!--end::Form-->
												</div>
												<!--end::Edit-->
												<!--begin::Action-->
												<div id="kt_signin_email_button" class="ms-auto">
													<button class="btn btn-light btn-active-light-primary">Change Email</button>
												</div>
												<!--end::Action-->
											</div>
											<!--end::Email Address-->
											<!--begin::Separator-->
											<div class="separator separator-dashed my-6"></div>
											<!--end::Separator-->
											<!--begin::Password-->
											<div class="d-flex flex-wrap align-items-center mb-10">
												<!--begin::Label-->
												<div id="kt_signin_password">
													<div class="fs-6 fw-bolder mb-1">Password</div>
													<div class="fw-bold text-gray-600">************</div>
												</div>
												<!--end::Label-->
												<!--begin::Edit-->
												<div id="kt_signin_password_edit" class="flex-row-fluid d-none">
													<!--begin::Form-->
													<form id="kt_signin_change_password" class="form" novalidate="novalidate" method="POST" action="{{route('admin.users.profile-update-password')}}">
                                                        @csrf
														<div class="row mb-1">
															<div class="col-lg-4">
																<div class="fv-row mb-0">
																	<label for="currentpassword" class="form-label fs-6 fw-bolder mb-3">Current Password</label>
																	<input type="password" class=" @error('current_password') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" name="current_password" id="currentpassword" required />
																</div>
															</div>
															<div class="col-lg-4">
																<div class="fv-row mb-0">
																	<label for="newpassword" class="form-label fs-6 fw-bolder mb-3">New Password</label>
																	<input type="password" class=" @error('password') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" name="password" id="newpassword" required/>
																</div>
															</div>
															<div class="col-lg-4">
																<div class="fv-row mb-0">
																	<label for="confirmpassword" class="form-label fs-6 fw-bolder mb-3">Confirm New Password</label>
																	<input type="password" class=" @error('password_confirmation') is-invalid border-danger @enderror form-control form-control-lg form-control-solid" name="password_confirmation" id="confirmpassword" required />
																</div>
															</div>
														</div>
														<div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>
														<div class="d-flex">
															<button id="kt_password_submit" type="button" class="btn btn-success me-2 px-6">Update Password</button>
															<button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
														</div>
													</form>
													<!--end::Form-->
												</div>
												<!--end::Edit-->
												<!--begin::Action-->
												<div id="kt_signin_password_button" class="ms-auto">
													<button class="btn btn-light btn-active-light-primary">Reset Password</button>
												</div>
												<!--end::Action-->
											</div>
											<!--end::Password-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Sign-in Method-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->

						
		<!--begin::Modal - Invite Friends-->
		<div class="modal fade"  id="profileModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="profileModal" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog mw-500px ">
				<!--begin::Modal content-->
				
				<form action="{{route('admin.users.profile-update-image')}}" id="imageUploadForm" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header pb-0 border-0 justify-content-end">
							<!--begin::Close-->
							<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
								<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
								<span class="svg-icon svg-icon-1">
									{!! getSvg('arr061') !!}
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--end::Close-->
						</div>
						<!--begin::Modal header-->
						<!--begin::Modal body-->
						<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-5">
							<!--begin::Heading-->
							<div class="text-center mb-13">
								<!--begin::Title-->
								<h1 class="mb-3">Update Profile Image</h1>
								<!--end::Title-->
								<!--begin::Description-->
								<div class="text-muted fw-bold fs-5">you can upload full image if image has a ratio of 1:1 otherwise you need to crop it.
								</div>
								<!--end::Description-->
							</div>
							<!--end::Heading-->
							<div class=" mb-8">
								<input  required autocomplete="off"  type="file" name="image"  accept="image/*" id="hiddenImage" class="d-none form-control-file">
								<img  id="preview" src="" alt="your image" class="img-fluid  me-3" />
								<input type="hidden" name="x" id="x" value="" class="form-control"  required>
								<input type="hidden" name="y" id="y" value="" class="form-control"  required>
								<input type="hidden" name="width" id="width" value="" class="form-control"  required>
								<input type="hidden" name="height" id="height" value="" class="form-control"  required>
							</div>
						</div>
						<!--end::Modal body-->
						<!--begin::Modal footer-->
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success">Upload</button>
						</div>
						<!--end::Modal footer-->
					</div>
				</form>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - Invite Friend--> 
@endsection
@push('js')
<script src="{{asset('admin/assets/js/custom/account/settings/signin-methods.js')}}"></script>
<script src="{{asset('admin/assets/js/custom/account/settings/profile-details.js')}}"></script>
@endpush
@section('scripts')
    <script>


$("#hiddenImage").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
            $('#preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(this.files[0]); // convert to base64 string
        } 
    
        $('#profileModal').modal('show');
    });
    
    $('#profileModal').on('shown.bs.modal', function(){
        const image = document.getElementById('preview');
    
        // console.log(image);
        cropper = new Cropper(image, {
            aspectRatio: 1/1,
            viewMode: 1,
            zoomable:false,
            crop(event) {
                $("#x").val(event.detail.x);
                $("#y").val(event.detail.y);
                $("#width").val(event.detail.width);
                $("#height").val(event.detail.height);
            },
        });
    }).on('hidden.bs.modal', function(){
        var croppedimage = cropper.getCroppedCanvas().toDataURL("image/png");
        
        // $('#imagetToShow').attr('src', croppedimage);
        cropper.destroy();
        $('.progress-bar').css('width', '0%').attr('aria-valuenow', 0); 
    });

		
    </script>
<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection