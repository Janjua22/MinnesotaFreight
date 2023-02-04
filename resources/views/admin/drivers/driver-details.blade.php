@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Driver",
        'sub-title' => "Details",
        'btn' => null,
        'url' => null
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-column flex-xl-row">
            <div class="flex-column flex-lg-row-auto w-100 w-xl-400px mb-10">
                <div class="card mb-5 mb-xl-8">
                    <div class="card-body pt-0 pt-lg-1">
                        <div class="d-flex flex-center flex-column pt-12 p-9 px-0">
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <img src="{{ asset(Storage::url($driver->userDetails->image)) }}" alt="driver avatar">
                            </div>
                            <a href="{{ route('admin.driver.details', ['id' => $driver->id]) }}" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1">
                                {{ $driver->userDetails->first_name." ".$driver->userDetails->last_name }} 
                                <span class="svg-icon svg-icon-1 svg-icon-primary" data-bs-toggle="tooltip" title="Email Verified">{!! getSvg('gen026') !!}</span>
                            </a>
                            <div class="fs-5 fw-bold text-primary mb-6">{{ $driver->userDetails->email }}</div>
                        </div>
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse" href="#kt_customer_view_details" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">Basic Details
                                <span class="ms-2 rotate-180">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
                                            </g>
                                        </svg>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div id="kt_customer_view_details" class="collapse show">
                            <div class="py-5 fs-6">
                                @if($driver->userDetails->status == 1)
                                    <div class="badge badge-light-success">Active</div>
                                @endif
                                @if($driver->userDetails->status == 0)
                                    <div class="badge badge-light-danger">Disabled</div>
                                @endif

                                {{-- <div class="fw-bolder mt-5">First Name</div>
                                <div class="text-gray-600">{{ $driver->userDetails->first_name }}</div>

                                <div class="fw-bolder mt-5">Last Name</div>
                                <div class="text-gray-600">{{ $driver->userDetails->last_name }}</div>

                                <div class="fw-bolder mt-5">Email</div>
                                <div class="text-gray-600">
                                    <a href="mailto:{{ $driver->userDetails->email }}" class="text-gray-600 text-hover-primary">{{ $driver->userDetails->email }}</a>
                                </div> --}}
                                <div class="fw-bolder mt-5">Address</div>
                                <div class="text-gray-600">{{ $driver->userDetails->address ?? 'Not Provided' }}</div>

                                <div class="fw-bolder mt-5">Phone</div>
                                <div class="text-gray-600">{{ $driver->userDetails->phone }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-5 mb-xl-8">
                    <div class="card-header border-0">
                        <div class="card-title">
                            <h2 class="fw-bolder mb-0">Recurring Deduction Details</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="separator separator-dashed my-3"></div>
                        <div class="py-5 fs-6">
                            <div class="fw-bolder">Deduction Date</div>
                            <div class="text-gray-600">{{ $driver->deduction_date ?? 'None' }} of every month</div>

                            <div class="fw-bolder mt-5">Auto Deduct</div>
                            @if($driver->auto_deduct)
                                <div class="badge badge-light-info">Yes</div>
                            @else
                                <div class="badge badge-light-warning">No</div>
                            @endif

                            <div class="fw-bolder mt-5">Deductions List</div>
                            @forelse($driver->recurringDeductions as $deduction)
                            <div class="text-gray-600"><i class="fas fa-check"></i> {{ $deduction->recurringDeduction->title }}</div>
                            @empty
                            <div class="text-danger">No Deductions defined</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <div class="card pt-4 mb-6 mb-xl-9">
                    <div class="card-header border-0">
                        <div class="card-title">
                            <h2 class="fw-bolder mb-0">Driving Details</h2>
                        </div>
                    </div>
                    <div id="kt_customer_view_payment_method" class="card-body pt-0">
                        <div class="py-0" data-kt-customer-payment-method="row">
                            <div class="py-3 d-flex flex-stack flex-wrap">
                                <div class="d-flex align-items-center collapsible rotate" data-bs-toggle="collapse" href="#kt_driver_personal_details" role="button" aria-expanded="false" aria-controls="kt_driver_personal_details">
                                    <div class="me-3 rotate-90">
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="me-3">
                                        <div class="d-flex align-items-center">
                                            <div class="text-gray-800 fw-bolder">Personal Details</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="kt_driver_personal_details" class="collapse show fs-6 ps-10" data-bs-parent="#kt_customer_view_payment_method">
                                <div class="pb-5">
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-125px">Street</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->street }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-125px">Suite</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->suite }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-125px">State</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->state->name }}</div>
                                        <div class="symbol symbol-20px symbol-circle ms-2">
                                            <img src="{{ asset('admin/assets/media/flags/united-states.svg') }}" />
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-125px">City</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->city->name }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-125px">Zip Code</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->zip }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed"></div>

                        <div class="py-0" data-kt-customer-payment-method="row">
                            <div class="py-3 d-flex flex-stack flex-wrap">
                                <div class="d-flex align-items-center collapsible collapsed rotate" data-bs-toggle="collapse" href="#kt_driver_driving_details" role="button" aria-expanded="false" aria-controls="kt_driver_driving_details">
                                    <div class="me-3 rotate-90">
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="me-3">
                                        <div class="d-flex align-items-center">
                                            <div class="text-gray-800 fw-bolder">Driving Details</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="kt_driver_driving_details" class="collapse fs-6 ps-10" data-bs-parent="#kt_customer_view_payment_method">
                                <div class="pb-5">
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Payment Type</div>
                                        <div class="text-gray-800 fw-bold">
                                            @if($driver->payment_type == 1)
                                            <span class="badge badge-light">Manual Pay</span>
                                            @elseif($driver->payment_type == 2)
                                            <span class="badge badge-light">Pay Per Mile</span>
                                            @else
                                            <span class="badge badge-light">Load Pay Percent</span>
                                            @endif
                                        </div>
                                    </div>

                                @if($driver->payment_type == 1)
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Manual Pay</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->manual_pay }}</div>
                                    </div>
                                @elseif($driver->payment_type == 2)
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Off-Load Miles Fee</div>
                                        <div class="text-gray-800 fw-bold">${{ $driver->off_mile_fee }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Loaded Miles Fee</div>
                                        <div class="text-gray-800 fw-bold">${{ $driver->on_mile_fee }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Off-Load Miles Range</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->off_mile_range }} miles</div>
                                    </div>
                                @else
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Load Pay Percentage</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->pay_percent }}%</div>
                                    </div>
                                @endif

                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Truck Assigned</div>
                                        <div class="text-gray-800 fw-bold">
                                            @if($driver->truckAssigned)
                                            {{ $driver->truckAssigned->truck_number }}
                                            <span class="svg-icon svg-icon-2 svg-icon-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path d="M9.26193932,16.6476484 C8.90425297,17.0684559 8.27315905,17.1196257 7.85235158,16.7619393 C7.43154411,16.404253 7.38037434,15.773159 7.73806068,15.3523516 L16.2380607,5.35235158 C16.6013618,4.92493855 17.2451015,4.87991302 17.6643638,5.25259068 L22.1643638,9.25259068 C22.5771466,9.6195087 22.6143273,10.2515811 22.2474093,10.6643638 C21.8804913,11.0771466 21.2484189,11.1143273 20.8356362,10.7474093 L17.0997854,7.42665306 L9.26193932,16.6476484 Z" fill="#000000" fill-rule="nonzero" opacity="0.5" transform="translate(14.999995, 11.000002) rotate(-180.000000) translate(-14.999995, -11.000002)" />
                                                        <path d="M4.26193932,17.6476484 C3.90425297,18.0684559 3.27315905,18.1196257 2.85235158,17.7619393 C2.43154411,17.404253 2.38037434,16.773159 2.73806068,16.3523516 L11.2380607,6.35235158 C11.6013618,5.92493855 12.2451015,5.87991302 12.6643638,6.25259068 L17.1643638,10.2525907 C17.5771466,10.6195087 17.6143273,11.2515811 17.2474093,11.6643638 C16.8804913,12.0771466 16.2484189,12.1143273 15.8356362,11.7474093 L12.0997854,8.42665306 L4.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.999995, 12.000002) rotate(-180.000000) translate(-9.999995, -12.000002)" />
                                                    </g>
                                                </svg>
                                            </span>
                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Medical Card Renewal</div>
                                        <div class="text-gray-800 fw-bold">{{ date_format(new DateTime($driver->med_renewal), 'M d, Y') }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Hiring</div>
                                        <div class="text-gray-800 fw-bold">{{ date_format(new DateTime($driver->hired_at), 'M d, Y') }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Termination</div>
                                        <div class="text-gray-800 fw-bold">{{ date_format(new DateTime($driver->fired_at), 'M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed"></div>

                        <div class="py-0" data-kt-customer-payment-method="row">
                            <div class="py-3 d-flex flex-stack flex-wrap">
                                <div class="d-flex align-items-center collapsible collapsed rotate" data-bs-toggle="collapse" href="#kt_driver_license_details" role="button" aria-expanded="false" aria-controls="kt_driver_license_details">
                                    <div class="me-3 rotate-90">
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="me-3">
                                        <div class="d-flex align-items-center">
                                            <div class="text-gray-800 fw-bolder">License Details</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="kt_driver_license_details" class="collapse fs-6 ps-10" data-bs-parent="#kt_customer_view_payment_method">
                                <div class="pb-5">
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">License Number</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->licenseInfo->license_number }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">License Expiration</div>
                                        <div class="text-gray-800 fw-bold">{{ date_format(new DateTime($driver->licenseInfo->expiration), 'M d, Y') }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">License Issuing State</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->licenseInfo->state->name }}</div>
                                        <div class="symbol symbol-20px symbol-circle ms-2">
                                            <img src="{{ asset('admin/assets/media/flags/united-states.svg') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed"></div>

                        <div class="py-0" data-kt-customer-payment-method="row">
                            <div class="py-3 d-flex flex-stack flex-wrap">
                                <div class="d-flex align-items-center collapsible collapsed rotate" data-bs-toggle="collapse" href="#kt_customer_view_payment_method_3" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_3">
                                    <div class="me-3 rotate-90">
                                        <span class="svg-icon svg-icon-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="me-3">
                                        <div class="d-flex align-items-center">
                                            <div class="text-gray-800 fw-bolder">Emergency Details</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="kt_customer_view_payment_method_3" class="collapse fs-6 ps-10" data-bs-parent="#kt_customer_view_payment_method">
                                <div class="pb-5">
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Contact's Name</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->emergencyInfo ? $driver->emergencyInfo->name : 'N/A' }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary fw-bold w-150px">Contact's Phone</div>
                                        <div class="text-gray-800 fw-bold">{{ $driver->emergencyInfo ? $driver->emergencyInfo->phone : 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($driver->licenseInfo->file_license) || isset($driver->licenseInfo->file_medical))
                <div class="card pt-4 mb-6 mb-xl-9">
                    <div class="card-body">
                        <div class="row">
                            @if(isset($driver->licenseInfo->file_license))
                            <div class="col">
                                <div class="card-title">
                                    <h2 class="fw-bolder">License:</h2>
                                </div>

                                @if(pathinfo($driver->licenseInfo->file_license, PATHINFO_EXTENSION) == 'doc' || pathinfo($driver->licenseInfo->file_license, PATHINFO_EXTENSION) == 'docx' || pathinfo($driver->licenseInfo->file_license, PATHINFO_EXTENSION) == 'pdf')
                                <a href="{{ asset(Storage::url($driver->licenseInfo->file_license)) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="License Document. Click to download." data-bs-original-title="License Document. Click to download." download>
                                    <img src="{{ asset('admin/assets/media/file-icons/'.pathinfo($driver->licenseInfo->file_license, PATHINFO_EXTENSION).'.png') }}" alt="License Image" class="img-fluid">
                                </a>
                                @else
                                <img src="{{ asset(Storage::url($driver->licenseInfo->file_license)) }}" alt="License Image" class="img-fluid">
                                @endif
                            </div>
                            @endif
                            @if(isset($driver->licenseInfo->file_medical))
                            <div class="col">
                                <div class="card-title">
                                    <h2 class="fw-bolder">Medical Card:</h2>
                                </div>

                                @if(pathinfo($driver->licenseInfo->file_medical, PATHINFO_EXTENSION) == 'doc' || pathinfo($driver->licenseInfo->file_medical, PATHINFO_EXTENSION) == 'docx' || pathinfo($driver->licenseInfo->file_medical, PATHINFO_EXTENSION) == 'pdf')
                                <a href="{{ asset(Storage::url($driver->licenseInfo->file_medical)) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Medical Card Document. Click to download." data-bs-original-title="Medical Card Document. Click to download." download>
                                    <img src="{{ asset('admin/assets/media/file-icons/'.pathinfo($driver->licenseInfo->file_medical, PATHINFO_EXTENSION).'.png') }}" alt="Medical Card Image" class="img-fluid">
                                </a>
                                @else
                                <img src="{{ asset(Storage::url($driver->licenseInfo->file_medical)) }}" alt="License Image" class="img-fluid">
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection