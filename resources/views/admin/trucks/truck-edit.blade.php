@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Truck",
        'sub-title' => "Edit",
        'btn' => "Trucks List",
        'url' => route('admin.truck')
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
                        <form action="{{ route('admin.truck.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $truck->id }}">

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Edit Truck</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Truck Details</h4>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Truck Number <sup class="text-danger">*</sup></label>
                                        <input type="text" name="truck_number" value="{{ $truck->truck_number }}" class="form-control form-control-solid @error('truck_number') is-invalid border-danger @enderror" placeholder="Truck Number..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Truck Type <sup class="text-danger">*</sup></label>
                                        <select name="truck_type" class="form-control form-select form-select-solid @error('truck_type') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Truck Type" required>
                                            <option value="">Select Truck Type</option>
                                            <option value="1" @if($truck->type_id == 1) selected @endif>Truck</option>
                                            <option value="2" @if($truck->type_id == 2) selected @endif>Trailer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Current Location <sup class="text-danger">*</sup></label>
                                        <input type="text" id="truckLocation" value="{{ $truck->city->name.', '.$truck->city->state->name }}" data-selected="{{ $truck->city->id }}" class="form-control form-control-solid" placeholder="Search City..." autocomplete="off" required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Last Inspection Date</label>
                                        <input type="date" name="last_inspection" value="{{ $truck->last_inspection }}" class="form-control form-control-solid @error('last_inspection') is-invalid border-danger @enderror">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>VIN</label>
                                        <input type="text" name="vin_number" value="{{ $truck->vin_number }}" class="form-control form-control-solid @error('vin_number') is-invalid border-danger @enderror" placeholder="Vehicle Identity Number...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Plate Number</label>
                                        <input type="text" name="plate_number" value="{{ $truck->plate_number }}" class="form-control form-control-solid @error('plate_number') is-invalid border-danger @enderror" placeholder="Plate Number...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Ownership Type</label>
                                        <select name="ownership" class="form-control form-select form-select-solid @error('ownership') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Ownership Type">
                                            <option value="">Select Ownership Type</option>
                                            <option value="Company Owned" @if($truck->ownership == 'Company Owned') selected @endif>Company Owned</option>
                                            <option value="Owner Operated" @if($truck->ownership == 'Owner Operated') selected @endif>Owner Operated</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Status <sup class="text-danger">*</sup></label>
                                        <select name="status" class="form-control form-select form-select-solid @error('status') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Status" required>
                                            <option value="">Select Status</option>
                                            <option value="1" @if($truck->status == 1) selected @endif>Active</option>
                                            <option value="0" @if($truck->status == 0) selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-7">
                                        <label>Note</label>
                                        <textarea name="note" class="form-control form-control-solid @error('note') is-invalid border-danger @enderror" rows="5" placeholder="Any details here..." maxlength="255">{!! $truck->note !!}</textarea>
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

<script>
    let pluginOptions = {
        name: 'city_id',
        url: "{{ route('resource.search-city') }}"
    };

    $(function(){
        $('#truckLocation').liveSearch(pluginOptions, response => {
            return `${ response.city }, ${ response.state }`;
        });
    });
</script>
@endsection