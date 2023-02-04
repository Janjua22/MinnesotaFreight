@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Truck",
        'sub-title' => "Add",
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
                        <form action="{{ route('admin.truck.create') }}" method="POST">
                            @csrf

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Add Truck</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Truck Details</h4>

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
                                        <input type="text" id="truckLocation" class="form-control form-control-solid" placeholder="Search Location..." autocomplete="off" required>
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

    let showRelatedModal = (url, heading, className)=>{
        selectElement = className;

        $('.modal-header > .ribbon-label').html(`Add ${heading} <span class="ribbon-inner bg-success"></span>`);
        $('#modalHeading').html(heading+" Details");
        $('#moduleNameForPP').html(heading);
        $('#modalForm').attr("action", url);

        $("#addCustomerModal").modal("show");
    }

    $(()=>{
        // $.ajax({
        //     url: "{{ route('admin.location.all') }}",
        //     type: 'GET',
        //     success: res => {
        //         let options;

        //         $('#locationLoader').addClass('d-none');
                
        //         res.map(location => {
        //             options += `<option value="${ location.id }">${ location.name } - ${ location.city }, ${ location.state }</option>`;
        //         });

        //         $('select[name=current_location]').html(options);
        //         $('select[name=current_location]').removeClass('d-none');

        //         $('select[name=current_location]').select2({
        //             placeholder: 'Select a Location'
        //         });
        //     }, 
        //     error: err => {
        //         console.log(err);
        //         $('#locationLoader').html('* Unable to load the locations, please refresh and try again!');
        //         $('#locationLoader').addClass('text-danger');
        //     }
        // });

        $('#truckLocation').liveSearch(pluginOptions, response => {
            return `${ response.city }, ${ response.state }`;
        });
    });
</script>
@endsection