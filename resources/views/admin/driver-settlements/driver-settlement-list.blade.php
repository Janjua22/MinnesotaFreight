@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Driver Settlements",
        'sub-title' => "List",
        'btn' => null,
        'url' => null
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Alert-->
        @include('admin.components.alerts')
        <!--end::Alert-->

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                            </svg>
                        </span>
                        <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Settlement" />
                    </div>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <!--<a href="javascript:void(0);" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generateSettlmentModal">-->
                        <a class="btn btn-success" href="{{ route('admin.driverSettlement.addsettlememt') }}" >
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                    <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
                                </svg>
                            </span>
                            Add Driver Settlement
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                    <thead>
                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">S.no.</th>
                            <th class="min-w-125px">Driver</th>
                            <th class="min-w-125px">Load(s)</th>
                            <th class="min-w-125px">Paid Date</th>
                            <th class="min-w-125px">Gross Payment</th>
                            <th class="min-w-125px">Deducted Amount</th>
                            <th class="min-w-125px">Amount Paid</th>
                            <th class="min-w-125px">Status</th>
                            <th class="text-end min-w-70px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settlements as $settlement)
						@if(!empty($settlement->driver->userDetails->first_name))
                        <tr>
                            <td>{{ $settlement->id }}</td>
                            <td>{{ $settlement->driver->userDetails->first_name }} {{ $settlement->driver->userDetails->last_name }}</td>
                            <td>
                            @foreach($settlement->loads() as $i => $load)
                                <a href="{{ route('admin.loadPlanner.details', ['id' => $load->id]) }}" target="_blank">{{ $load->load_number }}</a>
                                @if($settlement->loads()->count() > $i+1) <br> @endif
                            @endforeach
                            </td>
                            <td>{{ $settlement->paid_date ? date_format(new DateTime($settlement->paid_date), 'M d, Y') : 'N/A' }}</td>
                            <td>${{ number_format($settlement->gross_amount, 2) }}</td>
                            <td>${{ number_format($settlement->deduction_amount, 2) }}</td>
                            <td>${{ number_format($settlement->paid_amount, 2) }}</td>
                            <td>
                                @if($settlement->status == 1)
                                    <div class="badge badge-light-success">Paid</div>
                                @endif
                                @if($settlement->status == 0)
                                    <div class="badge badge-light-warning">Due</div>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                    Actions
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                    @if($settlement->status == 0)
                                    <div class="menu-item px-3">
                                        <form action="{{ route('admin.driverSettlement.markPaid') }}" method="POST" id="formMarkPaid-{{ $settlement->id }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $settlement->id }}">
                                        </form>
                                        <a href="javascript:void(0);" class="menu-link px-3" onclick="confirmPaid('formMarkPaid-{{ $settlement->id }}', 'settlement');">Mark as Paid</a>
                                    </div>
                                    @endif
                                    @if($settlement->status == 1)
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.driverSettlement.print', ['id' => $settlement->id]) }}" class="menu-link px-3" target="_blank">Print</a>
                                    </div>
                                    @endif
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.driverSettlement.details', ['id' => $settlement->id]) }}" class="menu-link px-3">View</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.driverSettlement.edit', ['id' => $settlement->id]) }}" class="menu-link px-3">Edit</a>
                                    </div>
									@if(!$settlement->is_disabled)
										<div class="menu-item px-3">
											<a href="{{route('admin.driverSettlement.mail', ['id' => $settlement->id]) }}" class="menu-link px-3" target="_blank"> Send Mail</a>
										</div>
									@endif
									
                                    @if($settlement->status == 0)
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" data-id="{{ $settlement->id }}" onclick="removeRecord(this);" class="menu-link px-3">Delete</a>
                                    </div>
                                    @endif
									
									
                                </div>
                            </td>
                        </tr>
						@endif
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('admin.driverSettlement.delete') }}" method="POST" class="d-none" id="deleteForm">
                    @csrf
                    <input type="hidden" name="delete_trace" value="">
                </form>
            </div>
        </div>
    </div>

    <!-- Generate Settlement Modal -->
    <div class="modal fade" id="generateSettlmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
                        <h2 class="fw-bolder">Generate Settlement</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="{{ route('admin.driverSettlement.checkTrips') }}" method="POST" onsubmit="return generateSettlement(this);">
                        @csrf

                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-info-circle text-info"></i> Quick Info:</h4>
                            <p>Only the <span class="badge badge-success">completed</span> loads of the selected driver will show up in the list.</p>
                            <hr>
                            <small class="mb-0 fst-italic">If you have just created a new load it will not be available to settle down till you mark it as completed!</small>
                        </div>

                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Driver <sup class="text-danger">*</sup></label>
                                    <select name="driver_id" class="form-control form-select form-select-solid @error('driver_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Driver" required>
                                        <option value="">Select Driver</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->userDetails->first_name }} {{ $driver->userDetails->last_name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Date From <sup class="text-danger">*</sup></label>
                                    <input type="date" name="date_from" class="form-control form-control-solid @error('date_from') is-invalid border-danger @enderror" placeholder="Date From..." required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Date to <sup class="text-danger">*</sup></label>
                                <input type="date" name="date_to" class="form-control form-control-solid @error('date_to') is-invalid border-danger @enderror" placeholder="Date From..." required>
                                </div>
                            </div> --}}
                        </div>

                        <div class="text-center pt-8">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
    
                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Select Trpis Modal -->
    <div class="modal fade" id="selectTripsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Select
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Loads of <b id="drvrNmHead"></b></h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 my-7">
                    <form action="{{ route('admin.driverSettlement.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="driver_id" value="" id="drvrId">

                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 table-hover" id="sel-trips">
                                <thead>
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-125px">Load Number</th>
                                        <th class="min-w-125px">Truck Number</th>
                                        <th class="min-w-125px">Pickups</th>
                                        <th class="min-w-125px">Consignees</th>
                                        <th class="min-w-125px">Freight Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-bold"></tbody>
                            </table>
                        </div>
    
                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
    
                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                                <span class="indicator-label">Generate</span>
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
    let generateSettlement = elem => {
        let btn = $('button[type=submit]');
        let _html = btn.html();
        
        btn.html(`<i class="fas fa-spinner fa-pulse"></i> Checking Records...`);
        btn.attr('disabled', true);
        
        $.ajax({
            url: $(elem).attr('action'),
            type: 'POST',
            data: $(elem).serialize(),
            success: (res)=>{
                if(res.status){
                    $('#generateSettlmentModal').modal('hide');

                    let tbody = $('#sel-trips').find('tbody');

                    tbody.html('');

                    if(res.data.loads.length){
                        res.data.loads.map(function(arr){
                            tbody.append(`<tr>
                                <td>
                                    <input type="checkbox" name="loads[]" value="${arr.load_id}">
                                </td>
                                <td>
                                    <a href="${arr.load_url}" target="_blank">${arr.load_number}</a>
                                </td>
                                <td>
                                    ${arr.truck_number}
                                </td>
                                <td>
                                    ${(arr.pickups.length > 1)? arr.pickups[0]+', <small class=\"text-warning\">+'+ (arr.pickups.length-1) +' more</small>' : arr.pickups[0]}
                                </td>
                                <td>
                                    ${(arr.consignees.length > 1)? arr.consignees[0]+', <small class=\"text-warning\">+'+ (arr.consignees.length-1) +' more</small>' : arr.consignees[0]}
                                </td>
                                <td>
                                    $${arr.freight_amount} <span class="badge badge-light-primary fw-light">${arr.freight_type}</span>
                                </td>
                            </tr>`);
                        });
                    } else{
                        tbody.append(`<tr>
                            <td colspan="6" class="text-center">The reason you're not seeing any data because, loads are available but not invoiced yet!</td>
                        </tr>`);
                    }

                    $('#drvrId').val(res.data.driver_id);
                    $('#drvrNmHead').html(res.data.driver_name);

                    $('#selectTripsModal').modal('show');
                } else{
                    toastr["error"]("No un-settled loads found for this driver!");
                }
            },
            error: (err)=>{
                if(err.status == 422){
                    let msgHtml = `<p>${err.responseJSON.message}</p><br><ul>`;
    
                    let obj =  err.responseJSON.errors;
    
                    for (var i in obj) {
                        if (obj.hasOwnProperty(i)) {
                            msgHtml += `<li>${obj[i]}</li>`;
                        }
                    }
    
                    msgHtml += `</ul>`;

                    toastr["error"](msgHtml)
                } else{
                    toastr["error"]("An unknown error occured while submitting your form.");
                }
    
                console.error(err);
            },
            complete: ()=>{
                btn.html(_html);
                btn.attr('disabled', false);
            }
        });

        return false;
    }

    let confirmPaid = formId => {
        Swal.fire({
            text: "You're about to mark this settlement as paid?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, it's paid!",
            cancelButtonText: "No, leave it",
            customClass: {
                confirmButton: "btn fw-bold btn-success",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function (result) {
            if (result.value) {
                $(`#${formId}`).trigger('submit');
            } else if (result.dismiss === 'cancel') {
                Swal.fire({
                    text: "The settlement is not paid!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-success",
                    }
                });
            }
        });
    }

    @if(Session::has('status'))
        @if(Session::get('status') == 'paid')
            toastr["success"]("Settlement has been paid");
        @endif

        @if(Session::get('status') == 'generated')
            toastr["success"]("Settlement has been generated");
        @endif
    @endif
</script>
@stop