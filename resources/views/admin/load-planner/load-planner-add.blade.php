@extends('layouts.admin.master')

@section('styles')

<style>
    .select2-container--bootstrap5 .select2-dropdown .select2-results__option.select2-results__option--disabled{
        color: #f1416c !important;
    }

	.selectize-control .selectize-input{
		height:auto;
		padding:10px 15px;
	}
</style>
@endsection

@section('content')
@php
    $titles=[
        'title' => "Load Planner",
        'sub-title' => "Add",
        'btn' => "Load Planners List",
        'url' => route('admin.loadPlanner')
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
                        <form action="{{ route('admin.loadPlanner.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Add Load Planner</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Basic Details</h4>
                                <div class="row">

                                    <div class="form-group col-md-6 mb-7">
                                        <label>Custom Load Number <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="Leave empty in-case of computer generated random number." data-bs-original-title="Leave empty in-case of computer generated random number."></i></label>
                                        <input type="text" id="load_number" name="load_number" value="{{ old('load_number') }}" class="form-control form-control-solid @error('load_number') is-invalid border-danger @enderror" placeholder="Custom Load Number...">
                                        <span id="load-error" class="text-danger"></span>
                                    </div>
                                    <div class="form-group col-md-6 mb-7 cus-loc">
                                        <label>
                                            Customer Name
                                            <sup class="text-danger">*</sup>
                                            <a href="javascript:void(0);" onclick="showRelatedModal('{{ route('admin.customer.create') }}', 'Customer', this);">
                                                <i class="fas fa-plus-circle text-primary"></i>
                                            </a>
                                        </label>

										<select name="customer_id" class="form-control form-select  form-select-solid new_customer_id @error('customer_id') is-invalid border-danger @enderror"   required>
										 <option value="">Select Customer</option>
                                            @forelse($customers as $customer)
                                                <option value="{{ $customer['id'] }}">{{ $customer['name'] . " (" .  $customer['city'] . " - " . $customer['state'] . ")" }}</option>
                                            @empty
                                            @endforelse
										</select>


                                        {{-- <input type="text" id="customerLocation" class="form-control form-control-solid" placeholder="Search Customer..." autocomplete="off" value="{{ old('customer_id') }}" required> --}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Truck <sup class="text-danger">*</sup></label>
                                        <select name="truck_id" id="truck_id" data-control="select2" class="form-control form-select form-select-solid @error('truck_id') is-invalid border-danger @enderror" onchange="fetchDriverByTruck(this);" required>
                                            <option value="">Select Truck</option>
                                            @foreach($trucks as $truck)
                                            <?php
                                                if(!$truck->driverAssigned){
                                                    $msgDrvr = '(driver not assigned)';
                                                    $disabledFlag = 'disabled="disabled"';
                                                } else{
                                                    $msgDrvr = null;
                                                    $drvrName = "{$truck->driverAssigned->userDetails->first_name} {$truck->driverAssigned->userDetails->last_name}";
                                                    $disabledFlag = 'data-driver-id="'.$truck->driverAssigned->id.'" data-driver-name="'.$drvrName.'"';
                                                }
                                            ?>
                                            <option value="{{ $truck->id }}" {!! $disabledFlag !!} @if(old('truck_id') == $truck->id) selected @endif>{{ $truck->truck_number }} {{ $msgDrvr }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Driver <sup class="text-danger">*</sup></label>
                                        <input type="hidden" name="driver_id" value="{{ old('driver_id') }}">
                                        <input type="text" name="dvr_name" value="{{ old('dvr_name') }}" class="form-control form-control-solid @error('driver_id') is-invalid border-danger @enderror" placeholder="Driver Name..." readonly>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>BOL</label>
                                        <input type="text" name="bol" class="form-control form-control-solid @error('bol') is-invalid border-danger @enderror" placeholder="Bill of Lading...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Customer Required Info</label>
                                        <input type="text" name="required_info" class="form-control form-control-solid @error('required_info') is-invalid border-danger @enderror" placeholder="Customer Required Info...">
                                    </div>
                                </div> --}}
                                <hr>
                                <h4 class="form-section mb-8 fs-2">Stopping Places</h4>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-between">
                                        <h4>Pickup</h4>
                                        <button type="button" class="btn btn-success text-right" onclick="addCloneRow('pickup')">
                                            <i class="la la-map-marker"></i> Add Pickup
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-7">
                                        <label>
                                            Shipper
                                            <sup class="text-danger">*</sup>
                                            <a href="javascript:void(0);" onclick="showRelatedModal('{{ route('admin.location.create') }}', 'Pickup', this);">
                                                <i class="fas fa-plus-circle text-primary"></i>
                                            </a>
                                        </label>
{{--										<span id="p_location_id_wrapper">--}}
											<select name="p_location_id[]" id="Shipper" class="form-control form-select form-select-solid p_location_id @error('p_location_id') is-invalid border-danger @enderror"   required>
											<option value="">Select Shipper</option>
											@forelse($locations as $location)
											<option value="{{ $location['id'] }}">{{ $location['name'] . " (" .  $location['city'] . " - " . $location['state'] . ")" }}</option>
                                                @empty
                                                @endforelse
                                            </select>
{{--										</span>--}}
                                        {{--<input type="text" class="form-control form-control-solid shipper-locations" placeholder="Search Shipper..." value="{{ old('p_location_id') }}" autocomplete="off" required>--}}
                                    </div>

									{{-- old('p_location_id') --}}
                                    <div class="col-md-4 mb-7">
                                        <div class="form-group mb-3">
                                            <label>Pickup Date <sup class="text-danger">*</sup></label>
                                            <input type="date" name="p_date[]" value="{{ old('p_date') ? old('p_date')[0] : '' }}" class="form-control form-control-solid" placeholder="Pickup Date..." required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-7">
                                        <div class="form-group mb-3">
                                            <label>Pickup Time</label>
                                            <input type="time" name="p_time[]" value="{{ old('p_time') ? old('p_time')[0] : '' }}" class="form-control form-control-solid" placeholder="Pickup Time...">
                                        </div>
                                    </div>
                                </div>
                                <div class="cloneTemplateShipper d-none">
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-between">
                                            <h4>Pickup</h4>
                                            <button type="button" class="btn btn-danger text-right text-white" onclick="removeClone(this,'.cloneTemplateShipper');">
                                                <i class="la la-close"></i> remove
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-7">
                                            <label>Shipper <sup class="text-danger">*</sup></label>
											<select name="p_location_id[]" class="form-control form-select form-select-solid p_location_id @error('p_location_id') is-invalid border-danger @enderror"  data-placeholder="Select Shipper" >
											<option value="">Select Shipper</option>

                                            @forelse($locations as $location)
                                                <option value="{{ $location['id'] }}">{{ $location['name'] . " (" .  $location['city'] . " - " . $location['state'] . ")" }}</option>


                                                @empty

                                                @endforelse

											</select>
                                            {{--<input type="text" class="form-control form-control-solid" placeholder="Search Shipper..." autocomplete="off">--}}
                                        </div>
                                        <div class="col-md-4 mb-7">
                                            <div class="form-group mb-3">
                                                <label>Pickup Date <sup class="text-danger">*</sup></label>
                                                <input type="date" name="p_date[]" class="form-control form-control-solid" placeholder="Pickup Date...">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-7">
                                            <div class="form-group mb-3">
                                                <label>Pickup Time</label>
                                                <input type="time" name="p_time[]" class="form-control form-control-solid" placeholder="Pickup Time...">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-between">
                                        <h4>Consignee</h4>
                                        <button type="button" class="btn btn-success text-right" onclick="addCloneRow('consignee')">
                                            <i class="la la-map-marker"></i> Add Consignee
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-7">
                                        <label>
                                            Consignee
                                            <sup class="text-danger">*</sup>
                                            <a href="javascript:void(0);" onclick="showRelatedModal('{{ route('admin.location.create') }}', 'Consignee', this);">
                                                <i class="fas fa-plus-circle text-primary"></i>
                                            </a>
                                        </label>

                                        <select name="c_location_id[]" class="form-control form-select form-select-solid c_location_id @error('c_location_id') is-invalid border-danger @enderror"  required>
											<option value="">Select Consignee</option>

                                            @forelse($locations as $location)
                                                <option value="{{ $location['id'] }}">{{ $location['name'] . " (" .  $location['city'] . " - " . $location['state'] . ")" }}</option>


                                                @empty

                                                @endforelse

											</select>


                                        <!-- <input type="text" class="form-control form-control-solid consignee-locations" placeholder="Search Consignee..." value="" autocomplete="off" required> -->
                                    </div>
									{{-- old('c_location_id') --}}
                                    <div class="col-md-4 mb-7">
                                        <div class="form-group mb-3">
                                            <label>Arrival Date <sup class="text-danger">*</sup></label>
                                            <input type="date" name="c_date[]" value="{{ old('c_date') ? old('c_date')[0] : '' }}" class="form-control form-control-solid" placeholder="Arrival Date..." required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-7">
                                        <div class="form-group mb-3">
                                            <label>Arrival Time</label>
                                            <input type="time" name="c_time[]" value="{{ old('c_time') ? old('c_time')[0] : '' }}" class="form-control form-control-solid" placeholder="Arrival Time...">
                                        </div>
                                    </div>
                                </div>
                                <div class="cloneTemplate d-none">
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-between">
                                            <h4>Consignee</h4>
                                            <button type="button" class="btn btn-danger text-right text-white" onclick="removeClone(this,'.cloneTemplate');">
                                                <i class="la la-close"></i> remove
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-7">
                                            <label>Consignee <sup class="text-danger">*</sup></label>

                                            <select name="c_location_id[]" class="form-control form-select form-select-solid c_location_id @error('c_location_id') is-invalid border-danger @enderror"  >
											<option value="">Select Shipper</option>

                                            @forelse($locations as $location)
                                                <option value="{{ $location['id'] }}">{{ $location['name'] . " (" .  $location['city'] . " - " . $location['state'] . ")" }}</option>


                                                @empty

                                                @endforelse

											</select>


                                            <!-- <input type="text" class="form-control form-control-solid" placeholder="Search Consignee..." autocomplete="off"> -->
                                        </div>
                                        <div class="col-md-4 mb-7">
                                            <div class="form-group mb-3">
                                                <label>Arrival Date <sup class="text-danger">*</sup></label>
                                                <input type="date" name="c_date[]" class="form-control form-control-solid" placeholder="Arrival Date...">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-7">
                                            <div class="form-group mb-3">
                                                <label>Arrival Time</label>
                                                <input type="time" name="c_time[]" class="form-control form-control-solid" placeholder="Arrival Time...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4 class="form-section mb-8 fs-2">Fees/Charges</h4>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Primary Fee Type <sup class="text-danger">*</sup></label>
                                        <select name="fee_type" class="form-control form-select form-select-solid @error('fee_type') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Primary Fee Type" required>
                                            <option value="">Select Primary Fee Type</option>
                                            <option value="Flat Fee" selected>Flat Fee</option>
                                            <option value="Per Mile">Per Mile</option>
                                            <option value="Per Hundred Weight (cwt)">Per Hundred Weight (cwt)</option>
                                            <option value="Per Ton">Per Ton</option>
                                            <option value="Per Quantity">Per Quantity</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Freight Amount <sup class="text-danger">*</sup></label>
                                        <input type="number" name="freight_amount" value="{{ old('freight_amount') }}" class="form-control form-control-solid @error('freight_amount') is-invalid border-danger @enderror" placeholder="Freight Amount..." min="0" step=".01" required>
                                    </div>
                                </div>

                                <h4 class="form-section mb-8 fs-2"> Additional Charges</h4>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Stop Off</label>
                                        <input type="number" name="stop_off" value="{{ old('stop_off') }}" class="form-control form-control-solid @error('stop_off') is-invalid border-danger @enderror" placeholder="Stop Off..." min="0" step=".01">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>TARP Fee</label>
                                        <input type="number" name="tarp_fee" value="{{ old('tarp_fee') }}" class="form-control form-control-solid @error('tarp_fee') is-invalid border-danger @enderror" placeholder="TARP Fee..." min="0" step=".01">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Invoice Advance</label>
                                        <input type="number" name="invoice_advance" value="{{ old('invoice_advance') }}" class="form-control form-control-solid @error('invoice_advance') is-invalid border-danger @enderror" placeholder="Invoice Advance..." min="0" step=".01">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Driver Advance</label>
                                        <input type="number" name="driver_advance" value="{{ old('driver_advance') }}" class="form-control form-control-solid @error('driver_advance') is-invalid border-danger @enderror" placeholder="Driver Advance..." min="0" step=".01">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-7">
                                        <label>Any Accessorial Charges?</label>
                                        <div class="row">
                                            <div class="form-group col-md-6 my-5">
                                                <label>
                                                    <input type="radio" name="accessorial_invoice" id="" value="1" @if(old('accessorial_invoice') == 1) checked @endif> Yes
                                                </label>
                                            </div>
                                            <div class="form-group col-md-6 my-5">
                                                <label>
                                                    <input type="radio" name="accessorial_invoice" id="" value="0" @if(old('accessorial_invoice') == 0) checked @endif> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-7 accessorialInvoice" @if(old('accessorial_invoice') == 0) style="display:none;" @endif>
                                        <label>Upload Accessorial Charges Invoice <sup class="text-danger">*</sup></label>
                                        <input type="file" name="file_accessorial_invoice" class="form-control @error('file_accessorial_invoice') is-invalid border-danger @enderror" accept=".png, .jpg, .jpeg">
                                    </div>
                                    <div class="form-group col-md-4 mb-7 accessorialInvoice" @if(old('accessorial_invoice') == 0) style="display:none;" @endif>
                                        <label>Accessorial Charges Amount <sup class="text-danger">*</sup></label>
                                        <input type="number" name="accessorial_amount" value="{{ old('accessorial_amount') }}" class="form-control form-control-solid @error('accessorial_amount') is-invalid border-danger @enderror" min="0" step="0.1" placeholder="150">
                                    </div>
                                </div>
                                <hr>
                                <h4 class="form-section mb-8 fs-2"> File Archives</h4>
                                <div class="row">
                                    <div class="form-group col-6 mb-2">
                                        <label for="rateConfirm" class="form-label">Upload Rate Confirmation</label>
                                        <input type="file" name="file_rate_confirm" class="form-control @error('file_rate_confirm') is-invalid border-danger @enderror" id="rateConfirm" accept=".pdf, .doc, .docx, .png, .jpg, .jpeg">
                                    </div>
                                    <div class="form-group col-6 mb-2">
                                        <label for="fileBol" class="form-label">Upload Bill of Lading</label>
                                        <input type="file" name="file_bol" class="form-control @error('file_bol') is-invalid border-danger @enderror" id="fileBol" accept=".pdf, .doc, .docx, .png, .jpg, .jpeg">
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

    <!-- Add Customer/Location Modal -->
    @include('admin.components.customer-add-modal')

    <!-- Edit City Modal -->
    <div class="modal fade" id="addCityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Add
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">City</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="{{ route('admin.stateCity.createCity') }}" method="POST" onsubmit="return addCity(this);">
                        @csrf

                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Name <sup class="text-danger">*</sup></label>
                                    <input type="text" name="city_name" class="form-control form-control-solid @error('city_name') is-invalid border-danger @enderror" placeholder="City Name..." required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>State <sup class="text-danger">*</sup></label>
                                    <select name="state_id" id="stateName" class="form-control form-select form-select-solid @error('state_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select State" required>
                                        <option value="">Select State</option>
                                    @foreach($STATES as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                                <span class="indicator-label">Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    let selectElement;

    let fetchDriverByTruck = elem => {


        let id = $(elem).find(":selected").attr('data-driver-id');
		//console.log(id)
        let name = $(elem).find(":selected").attr('data-driver-name');

        if(id && name){
            $('input[name=driver_id]').val(id);
            $('input[name=driver_id]').next().val(name);
        } else{
            toastr["error"]("The truck you selected has no driver assigned to it. Please assign a driver first!")
        }
    }
	var tempHeading;
    let showRelatedModal = (url, heading, btn)=>{
        selectElement = $(btn).parent().next('input');

        $('#modalRibbonLabel').html(`Add ${heading} <span class="ribbon-inner bg-success"></span>`);
		tempHeading = heading;
        $('#modalHeading').html(heading+" Details");
        $('#moduleNameForPP').html(heading);
        $('#modalForm').attr("action", url);

        $("#addCustomerModal").modal("show");
    }

    let addCloneRow = mod => {

        // callShipperSelect();
        let clone;

        switch(mod){
            case 'pickup':
                clone = addClone('.cloneTemplateShipper');

                // $(clone[0]).find('input[type=text]').liveSearch({
                //     name: 'p_location_id[]',
                //     url: "{{ route('admin.location.all') }}",
                // });

                break;
            case 'consignee':
                clone = addClone('.cloneTemplate');

                // $(clone[0]).find('input[type=text]').liveSearch({
                //     name: 'c_location_id[]',
                //     url: "{{ route('admin.location.all') }}",
                // });

                break;
            default:
                console.error('undefined module name!');
                break;
        }
    }

    let addCity = form => {
        $(form).find('button[type=submit]').html(`<i class="fas fa-spinner fa-pulse"></i>`);

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: {
                name: $(form).find('input[name=city_name]').val(),
                state_id: $(form).find('select[name=state_id]').val(),
                _token: $(form).find('input[name=_token]').val()
            },
            success: (res)=>{
                $('select[name=city_id]').append(`<option value="${ res.id }" selected>${ res.name }</option>`);

                $(form).trigger('reset');
            },
            error: (err)=>{
                console.error(err);
            },
            complete: ()=>{
                $(form).find('button[type=submit]').html(`<span class="indicator-label">Add</span>`);
                $("#addCityModal").modal("hide");
            }
        });

        return false;
    }

    $(()=>{
        $('select[name="state_id"]').select2({ dropdownParent: $('#addCustomerModal') });
        $('select[name="city_id"]').select2({ dropdownParent: $('#addCustomerModal') });
        $('#stateName').select2({ dropdownParent: $('#addCityModal') });

        $("#modalForm").on("submit", function(e){
            $('#modalForm .indicator-label').html(`<i class="fas fa-spinner fa-pulse"></i>`);

            $.ajax({
                url: $(e.target).attr('action'),
                type: 'POST',
                data: $(e.target).serialize(),
                success: (res)=>{
					// console.log("res->", res);
					// console.log($(e.target));
					// console.log($('#cityLocation').val());
					let temp_city = $('#cityLocation').val();
                    selectElement.val(res.name);
                    selectElement.next('.lvs-container').children('input').val(res.id);


					if(tempHeading == 'Customer'){
						$('select[name=customer_id]').append(`<option value='${res.id}' selected>${res.name} (${temp_city})</option>`).trigger('change');
                        callCustomerSelect();
					}
                    else if(tempHeading == 'Pickup'){
                        // $("select[name='p_location_id[]']").html('');
						$("select[name='p_location_id[]']").append(`<option value='${res.id}' selected>${res.name} (${temp_city})</option>`).trigger('change');
						$("select[name='p_location_id[]']:last").val('').trigger('change');
                        callShipperSelect();
					}
                    else{
						$("select[name='c_location_id[]']").append(`<option value='${res.id}' selected>${res.name} (${temp_city})</option>`).trigger('change');
						$("select[name='c_location_id[]']:last").val('').trigger('change');
                        callConsigneeSelect();
					}
                    e.target.reset();
					$('#cityLocation').val('');
                    // location.reload();


                },
                error: (err)=>{
                    // console.error(err);
                    selectElement = null;
                },
                complete: ()=>{
                    $('#modalForm .indicator-label').html(`Submit`);
                    $("#addCustomerModal").modal("hide");
                    selectElement = null;

                }
            });

            return false;
        });


        $('input[name=accessorial_invoice]').on('change', function(e){
            if(e.target.value == 0){
                if($('.accessorialInvoice').attr("style") != "display:none;"){
                    $('.accessorialInvoice').slideToggle('fast');
                    $('.accessorialInvoice > input').removeAttr("required");
                }
            } else{
                $('.accessorialInvoice').slideToggle('fast');
                $('.accessorialInvoice > input').attr("required", "required");
            }
        });






        $('#cityLocation').liveSearch({
            name: 'city_id',
            url: "{{ route('resource.search-city') }}"
        }, response => {
            return `${ response.city }, ${ response.state }`;
        });
    });


        // callShipperSelect();
        function callCustomerSelect(){
        $('.customer_id').empty().trigger("change");
        $.ajax({
            url: "{{ route('admin.customer.fetch_all') }}",
            type: 'GET',
            success: (res)=>{
                $('.customer_id').append(`<option value="">Select Customer</option>`);
                for(i=0; i <res.length; i++){
                    $('.customer_id').append(`<option value="${ res[i].id }">${ res[i].name } (${res[i].city} - ${res[i].state})</option>`);
                }

                $('.new_customer_id').select2();
                // $('.customer_id').selectize();
                // $('.selectize-input').addClass('form-control form-control-solid');

            },
            error: (err)=>{
                console.error(err);

            },
            complete: ()=>{

            }
        });
    }
		function callShipperSelect(){

            $('.p_location_id').empty().trigger("change");
            $.ajax({
			url: "{{ route('admin.location.fetch-all') }}",
			type: 'GET',
			success: (res)=>{
                $('.p_location_id').append(`<option value="">Select Shipper</option>`);
				for(i=0; i <res.length; i++){
                    $('.p_location_id').append(`<option value="${ res[i].id }">${ res[i].name } (${res[i].city} - ${res[i].state})</option>`);
                }
                $('.p_location_id').select2();
                // $('.p_location_id').selectize();
			},
			error: (err)=>{
				console.error(err);

			},
			complete: ()=>{

			}
		});
        }
		function callConsigneeSelect(){

			 $('.c_location_id').empty().trigger("change");
            $.ajax({
			url: "{{ route('admin.location.fetch-all') }}",
			type: 'GET',
			success: (res)=>{
                $('.c_location_id').append(`<option value="">Select Consignee</option>`);
				for(i=0; i <res.length; i++){
                    $('.c_location_id').append(`<option value="${ res[i].id }">${ res[i].name } (${res[i].city} - ${res[i].state})</option>`);
                }
				$('.c_location_id').select2();
				// $('.c_location_id').selectize();
			},
			error: (err)=>{
				console.error(err);

			},
			complete: ()=>{

			}
		});
        }

       $(document).ready(function() {

		  //$('#truck_id').selectize();

		  // $('.p_location_id').selectize();
		  // $('.customer_id').selectize();
		  $('.new_customer_id').selectize();
		  $('.c_location_id').selectize();

          $("#load-error").text("");
          $('#load_number').on('keyup', function () {
              $("#load-error").text("");
            //   $('#load_number').remove();
            let load_number = $(this).val();
            // alert(load_number);
            if (load_number.length > 1) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('admin.loadPlanner.checkLoadnumber') }}",
                    data: {
                        load_number: load_number,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        // alert(data.success);
                        if (data.success == false) {
                            $("#load-error").text("Load number is already exist.");
                            // alert("already exist");
                        } else {
                            $("#load-error").text("");
                            //  alert("ok");
                        }

                    }
                });
            }

            // else {
            //     $('#load_number').after('<div id="email-error" class="text-danger" <strong>load number can not be empty.<strong></div>');
            // }
        });





      });
</script>
@endsection
