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
        'sub-title' => "Edit",
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
                        <form action="{{ route('admin.loadPlanner.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $load->id }}">

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Edit Load Planner</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                @if($load->invoiced)
                                <div class="alert alert-warning border-dashed border-warning" role="alert">
                                    <i class="fas fa-exclamation-triangle" style="color:inherit;"></i> <b>Warning:</b>
                                    This load is marked with <span class="badge badge-light-info">Invoiced</span> tag, editing this load will also change the related invoice!
                                </div>
                                @endif
                                
                                <h4 class="form-section mb-8 fs-2">Basic Details</h4>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Custom Load Number <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="Leave empty in-case of computer generated random number." data-bs-original-title="Leave empty in-case of computer generated random number."></i></label>
                                        <input type="text" name="load_number" value="{{ $load->load_number }}" class="form-control form-control-solid @error('load_number') is-invalid border-danger @enderror" placeholder="Custom Load Number...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Customer Name <sup class="text-danger">*</sup></label>
										{{--<input type="text" id="customerLocation" value="{{ $load->customer->name }}" data-selected="{{ $load->customer->id }}" class="form-control form-control-solid" placeholder="Search Customer..." autocomplete="off" required> --}} 
										
										<select name="customer_id" class="form-control form-select form-select-solid @error('customer_id') is-invalid border-danger @enderror"   required>
										<option value="">Select Customer</option>
										
										</select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Truck <sup class="text-danger">*</sup></label>
                                        <select name="truck_id" class="form-control form-select form-select-solid @error('truck_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Truck" onchange="fetchDriverByTruck(this);" required>
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
                                            <option value="{{ $truck->id }}" {!! $disabledFlag !!} @if($truck->id == $load->truck_id) selected @endif>{{ $truck->truck_number }} {{ $msgDrvr }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Driver <sup class="text-danger">*</sup></label>
                                        <input type="hidden" name="driver_id" value="{{ $load->driver_id }}">
                                        <input type="text" value="{{ $load->driver->userDetails->first_name ?? '' }} {{$load->driver->userDetails->last_name ?? '' }}" class="form-control form-control-solid @error('driver_id') is-invalid border-danger @enderror" placeholder="Driver Name..." >
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>BOL</label>
                                        <input type="text" name="bol" value="{{ $load->bol }}" class="form-control form-control-solid @error('bol') is-invalid border-danger @enderror" placeholder="Bill of Lading...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Customer Required Info</label>
                                        <input type="text" name="required_info" value="{{ $load->required_info }}" class="form-control form-control-solid @error('required_info') is-invalid border-danger @enderror" placeholder="Customer Required Info...">
                                    </div>
                                </div> --}}
                                <hr>
                                <h4 class="form-section mb-8 fs-2">Stopping Places</h4>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-between"> 
                                        <h4>Pickup</h4>
                                        <button type="button" class="btn btn-success text-right" onclick="addCloneRow('pickup');">
                                            <i class="la la-map-marker"></i> Add Pickup
                                        </button>
                                    </div>
                                </div>
                            @foreach($load->destinations as $dest)
                                @if($dest->type == 'pickup')
                                <div class="row" @if($dest->stop_number > 1) id="removeTemplateShipper" @endif>
                                    @if($dest->stop_number > 1)
                                    <div class="col-md-12 d-flex justify-content-between"> 
                                        <h4>Pickup</h4>
                                        <button type="button" class="btn btn-danger text-right text-white" onclick="removeClone(this,'#removeTemplateShipper');">
                                            <i class="la la-close"></i> remove
                                        </button>
                                    </div>
                                    @endif               
                                    <div class="form-group col-md-4 mb-7">
                                        <label>Shipper <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" value="{{ $dest->location->name }}" data-selected="{{ $dest->location->id }}" class="form-control form-control-solid shipper-locations" placeholder="Search Shipper..." autocomplete="off" required> --}}
										
										<select name="p_location_id[]" class="form-control form-select form-select-solid p_location_id @error('p_location_id') is-invalid border-danger @enderror"   required>
											<option value="">Select Shipper</option>
											@forelse($locations_dropdown as $location)
											<option value="{{ $location['id'] }}" @if($dest->location->id == $location['id']) Selected @endif>{{ $location['name'] . " (" .  $location['city'] . " - " . $location['state'] . ")" }}</option>


											@empty

                                        @endforelse


										
										</select>
                                    </div>
                                    <div class="col-md-4 mb-7">
                                        <div class="form-group mb-3">
                                            <label>Pickup Date <sup class="text-danger">*</sup></label>
                                            <input type="date" name="p_date[]" value="{{ $dest->date }}" class="form-control form-control-solid" placeholder="Pickup Date...">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-7">
                                        <div class="form-group mb-3">
                                            <label>Pickup Time</label>
                                            <input type="time" name="p_time[]" value="{{ $dest->time }}" class="form-control form-control-solid" placeholder="Pickup Time...">
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach

							

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
                                            {{--<input type="text" class="form-control form-control-solid" placeholder="Search Shipper..." autocomplete="off">--}}
											
											<select name="p_location_id[]" class="form-control form-select form-select-solid p_location_id @error('p_location_id') is-invalid border-danger @enderror"  >
											<option value="">Select Shipper</option>

                                            @forelse($locations_dropdown as $location)
                                                <option value="{{ $location['id'] }}">{{ $location['name'] . " (" .  $location['city'] . " - " . $location['state'] . ")" }}</option>


                                                @empty

                                                @endforelse
											
											</select>
											
											
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
                                        <h4 class="form-section mb-8 fs-2">Consignee</h4>
                                        <button type="button" class="btn btn-success text-right" onclick="addCloneRow('consignee');">
                                            <i class="la la-map-marker"></i> Add Consignee
                                        </button>
                                    </div>
                                </div>

                            @foreach($load->destinations as $dest)
                                @if($dest->type == 'consignee')
                                <div class="row" @if($dest->stop_number > 1) id="removeTemplate" @endif>
                                    @if($dest->stop_number > 1)
                                    <div class="col-md-12 d-flex justify-content-between">
                                        <h4>Consignee</h4>
                                        <button type="button" class="btn btn-danger text-right text-white" onclick="removeClone(this,'#removeTemplate');">
                                            <i class="la la-close"></i> remove
                                        </button>
                                    </div>
                                    @endif               
                                    <div class="form-group col-md-4 mb-7">
                                        <label>Consignee <sup class="text-danger">*</sup></label>
                                        {{--<input type="text" value="{{ $dest->location->name }}" data-selected="{{ $dest->location->id }}" class="form-control form-control-solid consignee-locations" placeholder="Search Consignee..." autocomplete="off" required>--}}
										
										<select name="c_location_id[]" class="form-control form-select form-select-solid c_location_id @error('c_location_id') is-invalid border-danger @enderror"   required>
											<option value="">Select Shipper</option>
											@forelse($locations_dropdown as $location)
											<option value="{{ $location['id'] }}" @if($dest->location->id == $location['id']) Selected @endif>{{ $location['name'] . " (" .  $location['city'] . " - " . $location['state'] . ")" }}</option>


											@empty

                                        @endforelse
										
										</select>
										
                                    </div>
                                    <div class="col-md-4 mb-7">
                                        <div class="form-group mb-3">
                                            <label>Arrival Date <sup class="text-danger">*</sup></label>
                                            <input type="date" name="c_date[]" value="{{ $dest->date }}" class="form-control form-control-solid" placeholder="Arrival Date...">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-7">
                                        <div class="form-group mb-3">
                                            <label>Arrival Time</label>
                                            <input type="time" name="c_time[]" value="{{ $dest->time }}" class="form-control form-control-solid" placeholder="Arrival Time...">
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                                <div class="cloneTemplate d-none">
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-between"> 
                                            <h4>Consignee</h4>
                                            <button type="button" class="btn btn-danger text-right text-white" onclick="removeClone(this, '.cloneTemplate');">
                                                <i class="la la-close"></i> remove
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-7">
                                            <label>Consignee <sup class="text-danger">*</sup></label>
                                            {{-- <input type="text" class="form-control form-control-solid" placeholder="Search Consignee..." autocomplete="off">--}}
											
											<select name="c_location_id[]" class="form-control form-select form-select-solid c_location_id @error('c_location_id') is-invalid border-danger @enderror"  >
											<option value="">Select Shipper</option>

                                            @forelse($locations_dropdown as $location)
                                                <option value="{{ $location['id'] }}">{{ $location['name'] . " (" .  $location['city'] . " - " . $location['state'] . ")" }}</option>


                                                @empty

                                                @endforelse
											
											</select>
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
                                            <option value="Flat Fee" @if($load->fee->fee_type == 'Flat Fee') selected @endif>Flat Fee</option>
                                            <option value="Per Mile" @if($load->fee->fee_type == 'Per Mile') selected @endif>Per Mile</option>
                                            <option value="Per Hundred Weight (cwt)" @if($load->fee->fee_type == 'Per Hundred Weight (cwt)') selected @endif>Per Hundred Weight (cwt)</option>
                                            <option value="Per Ton" @if($load->fee->fee_type == 'Per Ton') selected @endif>Per Ton</option>
                                            <option value="Per Quantity" @if($load->fee->fee_type == 'Per Quantity') selected @endif>Per Quantity</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Freight Amount <sup class="text-danger">*</sup></label>
                                        <input type="number" name="freight_amount" value="{{ $load->fee->freight_amount }}" class="form-control form-control-solid @error('freight_amount') is-invalid border-danger @enderror" placeholder="Freight Amount..." min="0" step=".01" required>
                                    </div>
                                </div>

                                <h4 class="form-section mb-8 fs-2"> Additional Charges</h4>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Stop Off</label>
                                        <input type="number" name="stop_off" value="{{ $load->fee->stop_off }}" class="form-control form-control-solid @error('stop_off') is-invalid border-danger @enderror" placeholder="Stop Off..." min="0" step=".01">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>TARP Fee</label>
                                        <input type="number" name="tarp_fee" value="{{ $load->fee->tarp_fee }}" class="form-control form-control-solid @error('tarp_fee') is-invalid border-danger @enderror" placeholder="TARP Fee..." min="0" step=".01">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Invoice Advance</label>
                                        <input type="number" name="invoice_advance" value="{{ $load->fee->invoice_advance }}" class="form-control form-control-solid @error('invoice_advance') is-invalid border-danger @enderror" placeholder="Invoice Advance..." min="0" step=".01">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Driver Advance</label>
                                        <input type="number" name="driver_advance" value="{{ $load->fee->driver_advance }}" class="form-control form-control-solid @error('driver_advance') is-invalid border-danger @enderror" placeholder="Driver Advance..." min="0" step=".01">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Any Accessorial Charges?</label>
                                        <div class="row">
                                            <div class="form-group col-md-6 my-5">
                                                <label>
                                                    <input type="radio" name="accessorial_invoice" id="" value="1" @if($load->fee->file_accessorial_invoice) checked @endif> Yes
                                                </label>
                                            </div>
                                            <div class="form-group col-md-6 my-5">
                                                <label>
                                                    <input type="radio" name="accessorial_invoice" id="" value="0" @if($load->fee->file_accessorial_invoice == null) checked @endif> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-7 accessorialInvoice" @if($load->fee->file_accessorial_invoice == null) style="display:none;" @endif>
                                        <label>Upload Accessorial Charges Invoice <sup class="text-danger">*</sup></label>
                                        <input type="file" name="file_accessorial_invoice" class="form-control @error('file_accessorial_invoice') is-invalid border-danger @enderror" accept=".pdf, .doc, .docx, .png, .jpg, .jpeg">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Status <sup class="text-danger">*</sup></label>
                                        <select name="status" class="form-control form-select form-select-solid @error('status') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Status" required>
                                            <option value="">Select Status</option>
                                            <option value="2" @if($load->status == 2) selected @endif>New</option>
                                            <option value="3" @if($load->status == 3) selected @endif>In Progress</option>
                                            <option value="1" @if($load->status == 1) selected @endif>Completed</option>
                                            <option value="0" @if($load->status == 0) selected @endif>Canceled</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7 accessorialInvoice" @if($load->fee->accessorial_amount == null) style="display:none;" @endif>
                                        <label>Accessorial Charges Amount <sup class="text-danger">*</sup></label>
                                        <input type="number" name="accessorial_amount" value="{{ $load->fee->accessorial_amount }}" class="form-control form-control-solid @error('accessorial_amount') is-invalid border-danger @enderror" min="0" step="0.1" placeholder="150">
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
<script>
    // function removeExisting(elem){
    //     let row = $(elem).parent().parent();
    //     row.remove();
    // }
	$('.p_location_id').selectize();
	$('.c_location_id').selectize();
	 $(document).ready(function() {
		 
		  //$('#truck_id').selectize();
		
	 });

    let selectElement;

    let fetchDriverByTruck = elem => {
        let id = $(elem).find(":selected").attr('data-driver-id');
        let name = $(elem).find(":selected").attr('data-driver-name');

        if(id && name){
            $('input[name=driver_id]').val(id);
            $('input[name=driver_id]').next().val(name);
        } else{
            toastr["error"]("The truck you selected has no driver assigned to it. Please assign a driver first!")
        }
    }

    let showRelatedModal = (url, heading, btn)=>{
        selectElement = $(btn).parent().next('input');

        $('.modal-header > .ribbon-label').html(`Add ${heading} <span class="ribbon-inner bg-success"></span>`);
        $('#modalHeading').html(heading+" Details");
        $('#moduleNameForPP').html(heading);
        $('#modalForm').attr("action", url);

        $("#addCustomerModal").modal("show");
    }

    let toggleDeduction = (elem, value)=>{
        let group = $(elem).parent().next().find('.form-group');

        if(elem.value == value){
            if(group.attr("style") != "display: none;"){
                group.toggle('fast');
            }
        } else{
            group.toggle('fast');
        }
    }

    let addCloneRow = mod => {
        let clone;
        
        switch(mod){
            case 'pickup':
                clone = addClone('.cloneTemplateShipper');
        
                $(clone[0]).find('input[type=text]').liveSearch({
                    name: 'p_location_id[]',
                    url: "{{ route('admin.location.all') }}",
                });
				
				

                break;
            case 'consignee':
                clone = addClone('.cloneTemplate');

                $(clone[0]).find('input[type=text]').liveSearch({
                    name: 'c_location_id[]',
                    url: "{{ route('admin.location.all') }}",
                });

                break;
            default:
                console.error('undefined module name!');
                break;
        }
		
		
    }

    $(()=>{
        $('select[name="state_id"]').select2({ dropdownParent: $('#addCustomerModal') });
        $('select[name="city_id"]').select2({ dropdownParent: $('#addCustomerModal') });

        $("#modalForm").on("submit", function(e){
            $('#modalForm .indicator-label').html(`<i class="fas fa-spinner fa-pulse"></i>`);

            $.ajax({
                url: $(e.target).attr('action'),
                type: 'POST',
                data: $(e.target).serialize(),
                success: (res)=>{
                    selectElement.val(res.name);
                    selectElement.next('.lvs-container').children('input').val(res.id);
                    
                    e.target.reset();
                },
                error: (err)=>{
                    console.error(err);
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

        // $('#customerLocation').liveSearch({
            // name: 'customer_id',
            // url: "{{ route('admin.customer.all') }}",
        // });
			var load_customer_id = "{{$load->customer->id}}";
		$.ajax({
			url: "{{ route('admin.customer.fetch_all') }}",
			type: 'GET',
			// data: $(e.target).serialize(),
			success: (res)=>{
				//console.log(res);
				
				for(i=0; i <res.length; i++){
					let selected = null;
					if(load_customer_id == res[i].id ){
							selected = "Selected";
					}
					$('select[name=customer_id]').append(`<option value="${ res[i].id }" ${selected}>${ res[i].name } (${res[i].city} - ${res[i].state})</option>`);
				}
				$('select[name=customer_id]').selectize();
				$('.selectize-input').addClass('form-control form-control-solid');
					 	
				
			},
			error: (err)=>{
				console.error(err);
				
			},
			complete: ()=>{
				
			}
		});
		

        $('.shipper-locations').liveSearch({
            name: 'p_location_id[]',
            url: "{{ route('admin.location.all') }}",
        });

        $('.consignee-locations').liveSearch({
            name: 'c_location_id[]',
            url: "{{ route('admin.location.all') }}",
        });
    });
</script>
@endsection