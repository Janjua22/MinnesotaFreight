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
		'title' => "View",
		'sub-title' => "User",
		'btn' => 'List',
		'url' => route('admin.users'),
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
													<img src="{{asset(Storage::url($user->image))}}" alt="image" />
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
															<a href="javascript:void(0);" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{$user->first_name}} {{$user->last_name}} </a>
															@if($user->hasVerifiedEmail())
															<a href="javascript:void(0);"  data-bs-toggle="tooltip" title="You are a verified user">
																<!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
																<span class="svg-icon svg-icon-1 svg-icon-primary">
                                                                {!! getSvg('gen026') !!}
																</span>
																<!--end::Svg Icon-->
															</a>
															@endif
															<a href="javascript:void(0);" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3">{{$user->role->name}}</a>
														</div>
														<!--end::Name-->
														<!--begin::Info-->
														<div class="flex-wrap fw-bold fs-6 mb-4 pe-2">
															<a href="javascript:void(0);" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
															<!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
															<span class="svg-icon svg-icon-4 me-1">
																{!! getSvg('com011') !!}
															</span>
															<!--end::Svg Icon-->{{$user->role->name}}</a>
                                                            <br>
															<a href="javascript:void(0);" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
															<!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
															<span class="svg-icon svg-icon-4 me-1">
	                                                            {!! getSvg('gen018') !!}
															</span>
															<!--end::Svg Icon-->{{$user->address}} </a>
                                                            <br>
															<a href="javascript:void(0);" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
															<!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
															<span class="svg-icon svg-icon-4 me-1">
																{!! getSvg('com006') !!}
															</span>
															<!--end::Svg Icon-->{{$user->email}}</a>
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
										<form id="kt_account_profile_details_form" class="form" >
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
																<input type="text" readonly name="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="{{$user->first_name}}" />
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col-lg-6 fv-row">
																<input type="text" readonly name="last_name" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="{{$user->last_name}}" />
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
														<input type="tel" readonly name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="{{$user->phone}}" />
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
														<input type="tel" readonly name="address" class="form-control form-control-lg form-control-solid" placeholder="Apt#123 , NewYork , United States..." value="{{$user->address}}" />
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
                                                        
														<input type="text" readonly name="country" class="form-control form-control-lg form-control-solid" placeholder="{{$user->country->name}}" value="{{$user->country->name}}" />
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
														<input type="text" readonly name="state" class="form-control form-control-lg form-control-solid" placeholder="@if($user->state()->exists()) {{$user->state->name}} @else N/A @endif" value="@if($user->state()->exists()) {{$user->state->name}} @else N/A @endif" />
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
														<input type="text" readonly name="city" class="form-control form-control-lg form-control-solid" placeholder="@if($user->city()->exists()) {{$user->city->name}} @else N/A @endif" value="@if($user->city()->exists()) {{$user->city->name}} @else N/A @endif" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
											</div>
											<!--end::Card body-->
										</form>
										<!--end::Form-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Basic info-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
@endsection

@push('js')
@endpush
@section('scripts')
    <script>

    </script>
<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection