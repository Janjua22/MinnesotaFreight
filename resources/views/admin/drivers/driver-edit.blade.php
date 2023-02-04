@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Driver",
        'sub-title' => "Edit",
        'btn' => "Drivers List",
        'url' => route('admin.driver')
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Alert-->
        @include('admin.components.alerts')
        <!--end::Alert-->

        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <div class="card">
                    <div class="card-body p-12">
                        <form action="{{ route('admin.driver.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $driver->userDetails->id ?? ''}}">
                            <input type="hidden" name="status" value="{{ $driver->userDetails->status ?? '' }}">

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Update Driver</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Personal Details</h4>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>First Name <sup class="text-danger">*</sup></label>
                                        <input type="text" name="first_name" value="{{ $driver->userDetails->first_name ?? ''}}" class="form-control form-control-solid @error('first_name') is-invalid border-danger @enderror" placeholder="First Name..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Last Name <sup class="text-danger">*</sup></label>
                                        <input type="text" name="last_name" value="{{ $driver->userDetails->last_name ?? ''}}" class="form-control form-control-solid @error('last_name') is-invalid border-danger @enderror" placeholder="Last Name..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-7">
                                        <label>Street</label>
                                        <input type="text" name="street" value="{{ $driver->street ?? ''}}" class="form-control form-control-solid @error('street') is-invalid border-danger @enderror" placeholder="Street...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Truck <sup class="text-danger">*</sup></label>
                                        <select name="truck_id" class="form-control form-select form-select-solid @error('truck_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Truck" required>
                                            @foreach($trucks as $truck)
												@if($truck && isset($driver->truck_assigned))
                                            <option value="{{ $truck->id }}" @if($driver->truck_assigned == $truck->id) selected @endif>{{ $truck->truck_number }}</option>
										@endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Apt/Suite/Other</label>
                                        <input type="text" name="suite" value="{{ $driver->suite  ?? ''}}" class="form-control form-control-solid @error('suite') is-invalid border-danger @enderror" placeholder="Apt/Suite/Other...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>State <sup class="text-danger">*</sup></label>
                                        <select name="state_id" class="form-control form-select form-select-solid @error('state_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select State" onchange="fetchCitiesByState(this, 'city_id', '{{ url('/') }}')" required>
                                            <option value="">Select State</option>
                                            @foreach($STATES as $state)
											@if( isset($driver->state_id))
												<option value="{{ $state->id ?? ''}}" @if($driver->state_id == $state->id) selected @endif>{{ $state->name }}</option>
											@endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>City <sup class="text-danger">*</sup></label>
                                        <div></div>
                                        <select name="city_id" class="form-control form-select form-select-solid @error('city_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select City" required>
                                            <option value="{{ $driver->city_id ?? ''}}" selected>{{ $driver->city->name ?? ''}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Zip/Postal Code</label>
                                        <input type="text" name="zip" value="{{ $driver->zip ?? ''}}" class="form-control form-control-solid @error('zip') is-invalid border-danger @enderror" placeholder="Zip/Postal Code...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Phone/Mobile <sup class="text-danger">*</sup></label>
                                        <input type="text" name="phone" value="{{ $driver->userDetails->phone ?? ''}}" class="form-control form-control-solid @error('phone') is-invalid border-danger @enderror" placeholder="Phone/Mobile..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Email <sup class="text-danger">*</sup></label>
                                        <input type="email" name="email" value="{{ $driver->userDetails->email ?? ''}}" class="form-control form-control-solid @error('email') is-invalid border-danger @enderror" placeholder="Email..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Password <sup class="text-danger">*</sup></label>
                                        <input type="password" name="password" id="drvrPass" class="form-control form-control-solid @error('password') is-invalid border-danger @enderror" placeholder="Password..." minlength="6">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Default Payment Type <sup class="text-danger">*</sup></label>
                                        <select name="payment_type" class="form-control form-select form-select-solid @error('payment_type') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Default Payment Type" onchange="showPaymentFields(this);" required>
                                            <option value="">Select Default Payment Type</option>
                                            
											@if(isset($driver->payment_type))
												<option value="1" @if($driver->payment_type == 1) selected @endif>Manual Pay</option>
												<option value="2" @if($driver->payment_type == 2) selected @endif>Pay Per Mile</option>
												<option value="3" @if($driver->payment_type == 3) selected @endif>Load Pay Percent</option>
											@endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <div class="row {{ (($driver->payment_type ?? '') == 1)? null : 'd-none' }}" id="pay1">
                                            <div class="form-group col mb-2">
                                                <label>
                                                    Manual Pay 
                                                    <i class="la la-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter fixed amount to be paid to driver for each trip"></i>
                                                </label>
                                                <input type="number" name="manual_pay" value="{{ $driver->manual_pay ?? ''}}" class="form-control form-control-solid @error('manual_pay') is-invalid border-danger @enderror" placeholder="Manual Pay...">
                                            </div>
                                        </div>

                                        <div class="row {{ (($driver->payment_type ?? '') == 2)? null : 'd-none' }}" id="pay2">
                                            <div class="form-group col-md-4 mb-2">
                                                <label>Loaded Miles Fee</label>
                                                <input type="number" name="on_mile_fee" value="{{ $driver->on_mile_fee ?? ''}}" class="form-control form-control-solid @error('on_mile_fee') is-invalid border-danger @enderror" placeholder="Loaded Miles Fee..." min="0" step=".01">
                                            </div>
                                            <div class="form-group col-md-4 mb-2">
                                                <label>
                                                    Empty Miles Fee 
                                                    <i class="la la-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter amount to be charged for off-load miles. Insert '0' for no charge."></i>
                                                </label>
                                                <input type="number" name="off_mile_fee" value="{{ $driver->off_mile_fee ?? ''}}" class="form-control form-control-solid @error('off_mile_fee') is-invalid border-danger @enderror" placeholder="Empty Miles Fee..." min="0" step=".01">
                                            </div>
                                            <div class="form-group col-md-4 mb-2">
                                                <label>
                                                    Empty Miles Range 
                                                    <i class="la la-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Define range how much miles should be excluded from off-load charge. Leave empty or insert '0' to apply charge on all off-load miles."></i>
                                                </label>
                                                <input type="number" name="off_mile_range" value="{{ $driver->off_mile_range ?? ''}}" class="form-control form-control-solid @error('off_mile_range') is-invalid border-danger @enderror" placeholder="Empty Miles Range...">
                                            </div>
                                        </div>

                                        <div class="row {{ (($driver->payment_type  ?? '') == 3)? null : 'd-none' }}" id="pay3">
                                            <div class="form-group col mb-2">
                                                <label>
                                                    Load Pay Percent 
                                                    <i class="la la-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter percentage to be paid to driver against each trip"></i>
                                                </label>
                                                <input type="number" name="pay_percent" value="{{ $driver->pay_percent  ?? ''}}" class="form-control form-control-solid @error('pay_percent') is-invalid border-danger @enderror" placeholder="Load Pay Percent..." min="0" step=".01">
                                            </div>
                                        </div>

                                        <div class="row d-none" id="pay4">
                                            <div class="form-group col my-2">
                                                <label class="text-danger mt-5 pt-2"><i class="fas fa-arrow-left"></i> Please select a default payment type...</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>License Number <sup class="text-danger">*</sup></label>
                                        <input type="text" name="license_number" value="{{ $driver->licenseInfo->license_number  ?? ''}}" class="form-control form-control-solid @error('license_number') is-invalid border-danger @enderror" placeholder="License Number..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>License Expiration <sup class="text-danger">*</sup></label>
                                        <input type="date" name="expiration" value="{{ $driver->licenseInfo->expiration  ?? ''}}" class="form-control form-control-solid @error('expiration') is-invalid border-danger @enderror" placeholder="License Expiration..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>License Issuing State/Jurisdiction</label>
                                        <select name="issue_state" class="form-control form-select form-select-solid @error('issue_state') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select License issuing state/jurisdiction">
                                            <option value="">Select State</option>
                                            @foreach($STATES as $state)
											
											
                                            <option value="{{ $state->id }}" @if(($driver->licenseInfo->issue_state  ?? '') == $state->id) selected @endif>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Medical Card Renewal <sup class="text-danger">*</sup></label>
                                        <input type="date" name="med_renewal" value="{{ $driver->med_renewal  ?? ''}}" class="form-control form-control-solid @error('med_renewal') is-invalid border-danger @enderror" placeholder="Medical Card Renewal..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Hire Date</label>
                                        <input type="date" name="hired_at" value="{{ $driver->hired_at ?? ''}}" class="form-control form-control-solid @error('hired_at') is-invalid border-danger @enderror" placeholder="Hire Date...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Termination Date</label>
                                        <input type="date" name="fired_at" value="{{ $driver->fired_at ?? ''}}" class="form-control form-control-solid @error('fired_at') is-invalid border-danger @enderror" placeholder="Termination Date...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6 mb-7">
                                        <label for="fileLicense" class="form-label">Upload License <sup class="text-danger">*</sup></label>
                                        <input type="file" name="file_license" class="form-control @error('file_license') is-invalid border-danger @enderror" id="fileLicense" accept=".png, .jpg, .jpeg, .pdf, .doc, .docx">
                                    </div>
                                    <div class="form-group col-6 mb-7">
                                        <label for="fileMedical" class="form-label">Upload Medical Card <sup class="text-danger">*</sup></label>
                                        <input type="file" name="file_medical" class="form-control @error('file_medical') is-invalid border-danger @enderror" id="fileMedical" accept=".png, .jpg, .jpeg, .pdf, .doc, .docx">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6 mb-7">
                                        <label>Status</label>
                                        <select name="status" class="form-control form-select form-select-solid @error('status') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Status">
                                            <option value="">Select Status</option>
                                            <option value="1" @if(($driver->userDetails->status ?? '') == 1) selected @endif>Enabled</option> 
                                            <option value="0" @if(($driver->userDetails->status ?? '') == 0) selected @endif>Disabled</option>
                                        </select>
                                    </div>
                                </div>

                                <h4 class="form-section mb-8 fs-2">Emergency Contact Details</h4>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Emergency Contact Name</label>
                                        <input type="text" name="em_name" value="{{ ($driver->emergencyInfo ?? '') ? ($driver->emergencyInfo->name ?? '') : null }}" class="form-control form-control-solid @error('em_name') is-invalid border-danger @enderror" placeholder="Emergency Contact Name...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Emergency Contact Phone</label>
                                        <input type="text" name="em_phone" value="{{ ($driver->emergencyInfo ?? '') ? ($driver->emergencyInfo->phone ?? ''): null }}" class="form-control form-control-solid @error('em_phone') is-invalid border-danger @enderror" placeholder="Emergency Contact Phone...">
                                    </div>
                                </div>

                                <h4 class="form-section mb-8 fs-2">Recurring Deductions</h4>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Deduction Date <sup class="text-danger">*</sup></label>
                                        <input type="number" name="deduction_date" value="{{ $driver->deduction_date ?? ''}}" class="form-control form-control-solid @error('deduction_date') is-invalid border-danger @enderror" placeholder="Deduction Date like 10 or 15" min="1" max="31" step="1" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2">
                                        <label class="form-label">Select deductions to include when settling down driver's payment: <sup class="text-danger">*</sup></label>
                                    </div>
                                    @foreach($recurrings as $recurring)
                                    <?php
                                        $checked = null;
										if(isset($driver->recurringDeductions)){
											foreach($driver->recurringDeductions as $deduction){
												if($deduction->recurring_id == $recurring->id){
													$checked = 'checked';
												}
											}
										}
                                    ?>
                                    <div class="form-group col-md-3 mb-7">
                                        <div class="form-check">
                                            <input type="checkbox" name="recurring_id[]" class="form-check-input" value="{{ $recurring->id }}" id="recurring-{{ $recurring->id }}" {{ $checked }}>
                                            <label class="form-check-label" for="recurring-{{ $recurring->id }}">{{ $recurring->title }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="auto_deduct" type="checkbox" role="switch" id="autoDed" value="1" style="border-radius:1rem;" @if(($driver->auto_deduct ?? '')) checked @endif>
                                            <label class="form-check-label" for="autoDed">Automatically include above checked deductions in every settlement</label>
                                          </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group mx-auto form-group col-12 mt-3 mb-2">
                                        <button type="submit" class="btn btn-info" id="kt_invoice_submit_button">
                                            Update
                                            <span class="svg-icon svg-icon-3">{!! getSvg('art005') !!}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                  </div>
               </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection