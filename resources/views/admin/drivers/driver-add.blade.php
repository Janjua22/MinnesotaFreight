@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Driver",
        'sub-title' => "Add",
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
                        <form action="{{ route('admin.driver.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Add Driver</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Personal Details</h4>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>First Name <sup class="text-danger">*</sup></label>
                                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control form-control-solid @error('first_name') is-invalid border-danger @enderror" placeholder="First Name..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Last Name <sup class="text-danger">*</sup></label>
                                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control form-control-solid @error('last_name') is-invalid border-danger @enderror" placeholder="Last Name..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-7">
                                        <label>Street</label>
                                        <input type="text" name="street" value="{{ old('street') }}" class="form-control form-control-solid @error('street') is-invalid border-danger @enderror" placeholder="Street...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>
                                            Truck 
                                            <sup class="text-danger">*</sup>
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addTruck">
                                                <i class="fas fa-plus-circle text-primary"></i>
                                            </a>
                                        </label>
                                        <select name="truck_id" class="form-control form-select form-select-solid @error('truck_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Truck" required>
                                            @foreach($trucks as $truck)
                                            <option value="{{ $truck->id }}" @if(old('truck_id') == $truck->id) selected @endif>{{ $truck->truck_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Apt/Suite/Other</label>
                                        <input type="text" name="suite" value="{{ old('suite') }}" class="form-control form-control-solid @error('suite') is-invalid border-danger @enderror" placeholder="Apt/Suite/Other...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>State <sup class="text-danger">*</sup></label>
                                        <select name="state_id" class="form-control form-select form-select-solid @error('state_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select State" onchange="fetchCitiesByState(this, 'city_id', '{{ url('/') }}')" required>
                                            <option value="">Select State</option>
                                            @foreach($STATES as $state)
                                            <option value="{{ $state->id }}" @if(old('state_id') == $state->id) selected @endif>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>City <sup class="text-danger">*</sup></label>
                                        <div></div>
                                        <select name="city_id" class="form-control form-select form-select-solid @error('city_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select City" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Zip/Postal Code</label>
                                        <input type="text" name="zip" value="{{ old('zip') }}" class="form-control form-control-solid @error('zip') is-invalid border-danger @enderror" placeholder="Zip/Postal Code...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Phone/Mobile <sup class="text-danger">*</sup></label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control form-control-solid @error('phone') is-invalid border-danger @enderror" placeholder="Phone/Mobile..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Email <sup class="text-danger">*</sup></label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-solid @error('email') is-invalid border-danger @enderror" placeholder="Email..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Password <sup class="text-danger">*</sup></label>
                                        <input type="password" name="password" id="drvrPass" class="form-control form-control-solid @error('password') is-invalid border-danger @enderror" placeholder="Password..." minlength="6" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Default Payment Type <sup class="text-danger">*</sup></label>
                                        <select name="payment_type" class="form-control form-select form-select-solid @error('payment_type') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Default Payment Type" onchange="showPaymentFields(this);" required>
                                            <option value="">Select Default Payment Type</option>
                                            <option value="1" @if(old('payment_type') == "1") selected @endif>Manual Pay</option>
                                            <option value="2" @if(old('payment_type') == "2") selected @endif>Pay Per Mile</option>
                                            <option value="3" @if(old('payment_type') == "3") selected @endif>Load Pay Percent</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <div class="row {{ (old('payment_type') == 1)? null : 'd-none' }}" id="pay1">
                                            <div class="form-group col mb-2">
                                                <label>
                                                    Manual Pay 
                                                    <i class="la la-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter fixed amount to be paid to driver for each trip"></i>
                                                </label>
                                                <input type="number" name="manual_pay" value="{{ old('manual_pay') }}" class="form-control form-control-solid @error('manual_pay') is-invalid border-danger @enderror" placeholder="Manual Pay...">
                                                <span id="pay1error" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="row {{ (old('payment_type') == 2)? null : 'd-none' }}" id="pay2">
                                            <div class="form-group col-md-4 mb-2">
                                                <label>Loaded Miles Fee</label>
                                                <input type="number" name="on_mile_fee" value="{{ old('on_mile_fee') }}" class="form-control form-control-solid @error('on_mile_fee') is-invalid border-danger @enderror" placeholder="Loaded Miles Fee..." min="0" step=".01">
                                            </div>
                                            <div class="form-group col-md-4 mb-2">
                                                <label>
                                                    Empty Miles Fee 
                                                    <i class="la la-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter amount to be charged for off-load miles. Insert '0' for no charge."></i>
                                                </label>
                                                <input type="number" name="off_mile_fee" value="{{ old('off_mile_fee') }}" class="form-control form-control-solid @error('off_mile_fee') is-invalid border-danger @enderror" placeholder="Empty Miles Fee..." min="0" step=".01">
                                            </div>
                                            <div class="form-group col-md-4 mb-2">
                                                <label>
                                                    Empty Miles Range 
                                                    <i class="la la-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Define range how much miles should be excluded from off-load charge. Leave empty or insert '0' to apply charge on all off-load miles."></i>
                                                </label>
                                                <input type="number" name="off_mile_range" value="{{ old('off_mile_range') }}" class="form-control form-control-solid @error('off_mile_range') is-invalid border-danger @enderror" placeholder="Empty Miles Range...">
                                            </div>
                                            <span id="pay2error" class="text-danger"></span>
                                        </div>

                                        <div class="row {{ (old('payment_type') == 3)? null : 'd-none' }}" id="pay3">
                                            <div class="form-group col mb-2">
                                                <label>
                                                    Load Pay Percent 
                                                    <i class="la la-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter percentage to be paid to driver against each trip"></i>
                                                </label>
                                                <input type="number" name="pay_percent" value="{{ old('pay_percent') }}" class="form-control form-control-solid @error('pay_percent') is-invalid border-danger @enderror" placeholder="Load Pay Percent..." min="0" step=".01">
                                               <span id="pay3error" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="row {{ (old('payment_type') == 1 || old('payment_type') == 2 || old('payment_type') == 3)? 'd-none' : null }}" id="pay4">
                                            <div class="form-group col my-2">
                                                <label class="text-danger mt-5 pt-2"><i class="fas fa-arrow-left"></i> Please select a default payment type...</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>License Number <sup class="text-danger">*</sup></label>
                                        <input type="text" name="license_number" value="{{ old('license_number') }}" class="form-control form-control-solid @error('license_number') is-invalid border-danger @enderror" placeholder="License Number..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>License Expiration <sup class="text-danger">*</sup></label>
                                        <input type="date" name="expiration" value="{{ old('expiration') }}" class="form-control form-control-solid @error('expiration') is-invalid border-danger @enderror" placeholder="License Expiration..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>License Issuing State/Jurisdiction</label>
                                        <select name="issue_state" class="form-control form-select form-select-solid @error('issue_state') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select License issuing state/jurisdiction">
                                            <option value="">Select State</option>
                                            @foreach($STATES as $state)
                                            <option value="{{ $state->id }}" @if(old('issue_state') == $state->id) selected @endif>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Medical Card Renewal <sup class="text-danger">*</sup></label>
                                        <input type="date" name="med_renewal" value="{{ old('med_renewal') }}" class="form-control form-control-solid @error('med_renewal') is-invalid border-danger @enderror" placeholder="Medical Card Renewal..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Hire Date</label>
                                        <input type="date" name="hired_at" value="{{ old('hired_at') }}" class="form-control form-control-solid @error('hired_at') is-invalid border-danger @enderror" placeholder="Hire Date...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Termination Date</label>
                                        <input type="date" name="fired_at" value="{{ old('fired_at') }}" class="form-control form-control-solid @error('fired_at') is-invalid border-danger @enderror" placeholder="Termination Date...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6 mb-7">
                                        <label for="fileLicense" class="form-label">Upload License</label>
                                        <input type="file" name="file_license" class="form-control @error('file_license') is-invalid border-danger @enderror" id="fileLicense" accept=".png, .jpg, .jpeg, .pdf, .doc, .docx">
                                    </div>
                                    <div class="form-group col-6 mb-7">
                                        <label for="fileMedical" class="form-label">Upload Medical Card</label>
                                        <input type="file" name="file_medical" class="form-control @error('file_medical') is-invalid border-danger @enderror" id="fileMedical" accept=".png, .jpg, .jpeg, .pdf, .doc, .docx">
                                    </div>
                                </div>

                                <div class="separator separator-dashed my-5"></div>

                                <h4 class="form-section mb-8 fs-2">Emergency Contact Details</h4>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Emergency Contact Name</label>
                                        <input type="text" name="em_name" value="{{ old('em_name') }}" class="form-control form-control-solid @error('em_name') is-invalid border-danger @enderror" placeholder="Emergency Contact Name...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Emergency Contact Phone</label>
                                        <input type="text" name="em_phone" value="{{ old('em_phone') }}" class="form-control form-control-solid @error('em_phone') is-invalid border-danger @enderror" placeholder="Emergency Contact Phone...">
                                    </div>
                                </div>

                                <h4 class="form-section mb-8 fs-2">Recurring Deductions</h4>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Deduction Date <sup class="text-danger">*</sup></label>
                                        <input type="number" name="deduction_date" value="{{ old('deduction_date') }}" class="form-control form-control-solid @error('deduction_date') is-invalid border-danger @enderror" placeholder="Deduction Date like 10 or 15" min="1" max="31" step="1" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2">
                                        <label class="form-label">Select deductions to include when settling down driver's payment: <sup class="text-danger">*</sup></label>
                                    </div>
                                    @foreach($recurrings as $recurring)
                                    <div class="form-group col-md-3 mb-7">
                                        <div class="form-check">
                                            <input type="checkbox" name="recurring_id[]" class="form-check-input" value="{{ $recurring->id }}" id="recurring-{{ $recurring->id }}">
                                            <label class="form-check-label" for="recurring-{{ $recurring->id }}">{{ $recurring->title }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                    <span id="recurrerror" class="text-danger"></span>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" name="auto_deduct" role="switch" id="autoDed" value="1" style="border-radius:1rem;" @if(old('auto_deduct') == 1) checked @endif>
                                            <label class="form-check-label" for="autoDed">Automatically include above checked deductions in every settlement</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group mx-auto form-group col-12 mt-3 mb-2">
                                        <button type="submit" class="btn btn-success" id="kt_invoice_submit_button">
                                            Submit
                                            <span class="svg-icon svg-icon-3">{!! getSvg('gen016') !!}</span>
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

    <!-- Add Truck Modal -->
    <div class="modal fade" id="addTruck" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Create
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Truck</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="{{ route('admin.truck.create') }}" method="POST" id="modalForm">
                        @csrf

                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-6 mb-7">
                                    <label>Truck Number <sup class="text-danger">*</sup></label>
                                    <input type="text" name="truck_number" class="form-control form-control-solid @error('truck_number') is-invalid border-danger @enderror" placeholder="Truck Number..." required>
                                </div>
                                <div class="form-group col-md-6 mb-7">
                                    <label>Truck Type <sup class="text-danger">*</sup></label>
                                    <select name="truck_type" class="form-control form-select form-select-solid @error('truck_type') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Truck Type" required>
                                        <option value="">Select Truck Type</option>
                                        <option value="1">Truck</option>
                                        <option value="2">Trailer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mb-7">
                                    <label>Current Location <sup class="text-danger">*</sup></label>
                                    <input type="text" id="truckLocation" class="form-control form-control-solid" placeholder="Search City..." autocomplete="off" required>
                                </div>
                                <div class="form-group col-md-6 mb-7">
                                    <label>Last Inspection Date</label>
                                    <input type="date" name="last_inspection" class="form-control form-control-solid @error('last_inspection') is-invalid border-danger @enderror">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mb-7">
                                    <label>VIN</label>
                                    <input type="text" name="vin_number" class="form-control form-control-solid @error('vin_number') is-invalid border-danger @enderror" placeholder="Vehicle Identity Number...">
                                </div>
                                <div class="form-group col-md-6 mb-7">
                                    <label>Plate Number</label>
                                    <input type="text" name="plate_number" class="form-control form-control-solid @error('plate_number') is-invalid border-danger @enderror" placeholder="Plate Number...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mb-7">
                                    <label>Ownership Type</label>
                                    <select name="ownership" class="form-control form-select form-select-solid @error('ownership') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Ownership Type">
                                        <option value="">Select Ownership Type</option>
                                        <option value="Company Owned" selected>Company Owned</option>
                                        <option value="Owner Operated">Owner Operated</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 mb-7">
                                    <label>Status <sup class="text-danger">*</sup></label>
                                    <select name="status" class="form-control form-select form-select-solid @error('status') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Status" required>
                                        <option value="">Select Status</option>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Note</label>
                                    <textarea name="note" class="form-control form-control-solid @error('note') is-invalid border-danger @enderror" rows="5" placeholder="Any details here..." maxlength="255"></textarea>
                                </div>
                            </div>
                            <div class="text-center pt-15">
                                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
        
                                <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                                    <span class="indicator-label">Save</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Toaster Alerts -->
@include('admin.components.toaster')

<script>

     $(document).ready(function(){  
      $("#kt_invoice_submit_button").on("click", function(e){
         
        //   alert();
          if($('#payment_type').val() == 1 ){
              if($('#manual_pay').val().length == 0){
                  e.preventDefault();
                  $('#pay1error').text("Please fill out manual pay");
                  $('#manual_pay').get(0).focus();
              }
              else{
                  $('#pay1error').text("");
              }
              
          }
          else if($('#payment_type').val() == 2){
              if($('#on_mile_fee').val().length == 0){
                  e.preventDefault();
                   $('#pay2error').text("Please fill out loaded miles fee");
                     $('#on_mile_fee').get(0).focus();
                //   alert("on_mile_fee empty");
              }
              else{
                   $('#pay2error').text("");
              }
          }
          else if($('#payment_type').val() == 3){
              if($('#pay_percent').val().length == 0){
                  e.preventDefault();
                   $('#pay3error').text("Please fill out load pay percent");
                     $('#pay_percent').get(0).focus();
                //   alert("pay_percent empty");
              }
              else{
                  $('#pay3error').text("");
              }
              
          }
          var values=[];
          $('input[name="recurring_id[]"]:checked').each(function () {
              values[values.length] = (this.checked ? $(this).val() : "");
            });
            var check = jQuery.isEmptyObject(values);
           
           if(check == true){
                e.preventDefault();
                $('#recurrerror').text("Please select deductions");
                $('#recurrerror').get(0).focus();
           }
           if(check == false){
               $('#recurrerror').text("");
           }
           
          
         

      });
      
});



    let pluginOptions = {
        name: 'city_id',
        url: "{{ route('resource.search-city') }}"
    };
    
    $(()=>{
        $('#modalForm select').select2({ dropdownParent: $('#addTruck') });

        $("#modalForm").on("submit", function(e){
            $('#modalForm .indicator-label').html(`<i class="fas fa-spinner fa-pulse"></i>`);

            $.ajax({
                url: $(e.target).attr('action'),
                type: 'POST',
                data: $(e.target).serialize(),
                success: (res)=>{
                    $('select[name=truck_id]').append(`<option value="${res.id}" selected>${res.name}</option>`);

                    e.target.reset();
                },
                error: (err)=>{
                    console.error(err);
                },
                complete: ()=>{
                    $('#modalForm .indicator-label').html(`Submit`);
                    $("#addTruck").modal("hide");
                }
            });

            return false;
        });

        $('#truckLocation').liveSearch(pluginOptions, response => {
            return `${ response.city }, ${ response.state }`;
        });
    });
</script>
@endsection