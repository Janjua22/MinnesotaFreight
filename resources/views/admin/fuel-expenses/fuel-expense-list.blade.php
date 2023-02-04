@extends('layouts.admin.master')

@section('styles')
<style>
    .btn-revert:hover i{
        display: inline-block;
        transform: rotate(-90deg) 0.3s;
        -webkit-transform: rotate(-90deg);
        transition-duration: 0.3s;
        -webkit-transition-duration: 0.3s;
    }
</style>
@endsection

@section('content')
@php 
    $titles=[
        'title' => "Fuel Expense",
        'sub-title' => "List",
        'btn' => null,
        'url' => null
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
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
                        <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search fuel expenses" />
                    </div>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <a href="javascript:void(0);" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addExpense">
                            <i class="bi bi-cloud-upload fs-3"></i>
                            Import Fuel Expense
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                    <thead>
                        <th class="min-w-125px">Sheet Name</th>
                        <th class="min-w-125px">Truck</th>
                        <th class="min-w-125px">Driver</th>
                        <th class="min-w-125px">Load Number</th>
                        <th class="min-w-125px">Amount</th>
                        <th class="min-w-125px">Import Date</th>
                        <th class="min-w-125px">Action</th>
                    </thead>
                    <tbody>
                        @forelse($sheets as $sheet)
                        <tr>
                            <td class="fw-bold">
                                {{ $sheet->title }}
                                @if(!$sheet->deletable)
                                <i class="bi bi-info-circle-fill fs-3 text-primary" data-bs-toggle="tooltip" title="The data from this sheet is settled, therefore it can not be reverted!"></i>
                                @endif
                            </td>
                            <td>{{ $sheet->expenses[0]->truck->truck_number }}</td>
                            <td>{{ $sheet->expenses[0]->loadPlanner->driver->userDetails->first_name." ".$sheet->expenses[0]->loadPlanner->driver->userDetails->last_name }}</td>
                            <td>
                                <a href="{{ route('admin.loadPlanner.details', ['id' => $sheet->expenses[0]->loadPlanner->id]) }}" target="_blank">
                                    {{ $sheet->expenses[0]->loadPlanner->load_number }} <i class="bi bi-box-arrow-up-right text-primary"></i>
                                </a>
                            </td>
                            <td>${{ $sheet->expenses->sum('total') }}</td>
                            <td>{{ date_format($sheet->created_at, "h:ia, M d, Y") }}</td>
                            <td>
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
                                    <div class="menu-item px-3">
                                    @php
                                        $obj = array('total' => 0, 'expenses' => array());

                                        foreach($sheet->expenses as $expense){
                                            array_push($obj['expenses'], [
                                                'truck_number' => $expense->truck->truck_number,
                                                'date' => date_format(new DateTime($expense->date), "M d, Y"),
                                                'state_code' => $expense->state_code,
                                                'fee' => '$'.$expense->fee,
                                                'unit_price' => '$'.$expense->unit_price,
                                                'volume' =>  $expense->volume." Gallons",
                                                'fuel_type' => $expense->fuel_type,
                                                'amount' => '$'.$expense->amount,
                                                'total' => '$'.$expense->total,
                                                'settled' => $expense->settled
                                            ]);
                                        }

                                        $obj['total'] = "$".number_format($sheet->expenses->sum('total'), 2);
                                        $obj = json_encode($obj);
                                    @endphp
                                        <a href="javascript:void(0);" onclick="showExpenseDetails({{ $obj }});" class="menu-link px-3">View</a>
                                    </div>
                                    @if($sheet->deletable)
                                    <div class="menu-item px-3">
                                        <form action="{{ route('admin.fuelExpense.delete') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="sheet" value="{{ $sheet->id }}">
                                            <a href="javascript:void(0);" class="menu-link px-3" onclick="$(this).parent().submit();">Revert</a>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <h2 class="card-title">Import History</h2>
                    </div>
                    <div class="card-body pt-0">
                        @forelse($sheets as $sheet)
                        <div class="d-flex justify-content-between">
                            <span>
                                <p class="mb-0 fw-bold">{{ $sheet->title }}</p>
                                <small><i class="bi bi-clock-history text-primary me-3" data-bs-toggle="tooltip" title="Time of Import"></i> {{ date_format($sheet->created_at, "h:ia, M d, Y") }}</small>
                                <br>
                                <small><i class="bi bi-cash-coin text-primary me-3" data-bs-toggle="tooltip" title="Total Expense"></i> ${{ $sheet->expenses->sum('total') }}</small>
                                <br>
                                <small><i class="bi bi-truck text-primary me-3" data-bs-toggle="tooltip" title="Truck Number"></i> {{ $sheet->expenses[0]->truck->truck_number }}</small>
                            </span>
                            @if($sheet->deletable)
                            <form action="{{ route('admin.fuelExpense.delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="sheet" value="{{ $sheet->id }}">
                                <a href="javascript:void(0);" class="btn-revert" data-bs-toggle="tooltip" title="Revert This Import" onclick="$(this).parent().submit();">
                                    <i class="bi bi-arrow-counterclockwise p-0 fs-2 text-warning"></i>
                                </a>
                            </form>
                            @else
                            <i class="bi bi-info-circle-fill fs-3 text-primary" data-bs-toggle="tooltip" title="The data from this sheet is settled, therefore it can not be reverted!"></i>
                            @endif
                        </div>
                        <div class="separator separator-dashed my-2"></div>
                        @empty
                        <div class="text-center">
                            <i class="bi bi-calendar2-x fs-2"></i> 
                            <p class="text-muted">No Importing History</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-md-9">
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
                                <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search fuel expenses" />
                            </div>
                        </div>
        
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                                <a href="javascript:void(0);" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addExpense">
                                    <i class="bi bi-cloud-upload fs-3"></i>
                                    Import Fuel Expense
                                </a>
                            </div>
                        </div>
                    </div>
        
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                            <thead>
                                <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Truck</th>
                                    <th class="min-w-125px">Date</th>
                                    <th class="min-w-125px">State Code</th>
                                    <th class="min-w-125px">Fees</th>
                                    <th class="min-w-125px">Unit Price</th>
                                    <th class="min-w-125px">Quantity</th>
                                    <th class="min-w-125px">Fuel Type</th>
                                    <th class="min-w-125px">Amount</th>
                                    <th class="min-w-125px">Total</th>
                                    <th class="min-w-125px">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->truck->truck_number }}</td>
                                    <td>{{ date_format(new DateTime($expense->date), "M d, Y") }}</td>
                                    <td>{{ $expense->state_code }}</td>
                                    <td>${{ $expense->fee }}</td>
                                    <td>${{ $expense->unit_price }}</td>
                                    <td>{{ $expense->volume." Gallons" }}</td>
                                    <td>{{ $expense->fuel_type }}</td>
                                    <td>${{ $expense->amount }}</td>
                                    <td>${{ $expense->total }}</td>
                                    <td>
                                        @if($expense->settled == 1)
                                            <div class="badge badge-light-success">Settled</div>
                                        @endif
                                        @if($expense->settled == 0)
                                            <div class="badge badge-light-warning">Due</div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                    <th colspan="8">Expense Grand Total</th>
                                    <th colspan="2">${{ $expenses->sum('total') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Add Fuel Expense Modal -->
    <div class="modal fade" id="addExpense" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Import
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Fuel Expense</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="{{ route('admin.fuelExpense.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-body">
                            <p>
                                Before importing the sheet, please make sure that the sheet matches the required format to import. 
                                You can <a href="{{ asset(Storage::url('files/demo-template.xlsx')) }}" download><i class="bi bi-file-earmark-arrow-down-fill text-primary"></i> download a sample sheet</a> 
                                and reformat your sheet according to that template.
                            </p>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Truck <sup class="text-danger">*</sup></label>
                                    <select name="truck" class="form-control form-select form-select-solid @error('truck') is-invalid border-danger @enderror" onchange="fetchLoadsByTruck('{{ route('admin.truck.loads') }}');" required>
                                        <option value="">Select Truck...</option>
                                        @foreach($trucks as $truck)
                                        <option value="{{ $truck->id }}">{{ $truck->truck_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Active Loads <sup class="text-danger">*</sup></label>
                                    {{-- <div></div>
                                    <select name="load_id" class="form-control form-select form-select-solid @error('load_id') is-invalid border-danger @enderror" required>
                                        <option value="">Select Load...</option>
                                    </select> --}}

                                    <div class="row mt-2" id="activeLoadsPanel">
                                        <div class="col">
                                            <p><i class="fas fa-arrow-up text-dark"></i> Select a truck above to see its active loads</p>
                                        </div>
                                    </div>
                                    <i class="fas fa-info-circle"></i> <i>You only select one load per sheet!</i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Excel Sheet to Import</label>
                                    <input type="file" name="file" class="form-control form-control-solid" accept=".xls, .xlsx" required>
                                </div>
                            </div>
                        </div>
    
                        <div class="text-center pt-5">
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

    <!-- Show Fuel Expense Modal -->
    <div class="modal fade" id="showExpense" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder fs-2">
                        <span id="totalAmountExpense"></span>
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Fuel Expense</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="fuelExpRows">
                        <thead>
                            <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Truck</th>
                                <th class="min-w-125px">Date</th>
                                <th class="min-w-125px">State Code</th>
                                <th class="min-w-125px">Fees</th>
                                <th class="min-w-125px">Unit Price</th>
                                <th class="min-w-125px">Quantity</th>
                                <th class="min-w-125px">Fuel Type</th>
                                <th class="min-w-125px">Amount</th>
                                <th class="min-w-125px">Total</th>
                                <th class="min-w-125px">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let showDetailsModal = obj => {
        for(key in obj){
            $(`#mdl-data-${key}`).html(obj[key]);
        }

        $('#viewExpense').modal('show');
    }

    let showEditModal = obj => {
        $('input[name=edt_id]').val(obj.id);
        $('input[name=edt_name]').val(obj.name);
        $('textarea[name=edt_description]').html(obj.description);
        $('select[name=edt_status]').val((obj.status == 'Enabled')? 1 : 0);

        $('#editExpense').modal('show');
    }

    let showExpenseDetails = obj => {
        let html = ``;
        let badge;

        obj.expenses.map(row => {
            if(row.settled == 1){
                badge = `<div class="badge badge-light-success">Settled</div>`;
            } else{
                badge = `<div class="badge badge-light-warning">Due</div>`;
            }

            html += `<tr>
                <td>${ row.truck_number }</td>
                <td>${ row.date }</td>
                <td>${ row.state_code }</td>
                <td>${ row.fee }</td>
                <td>${ row.unit_price }</td>
                <td>${ row.volume } Gallons</td>
                <td>${ row.fuel_type }</td>
                <td>${ row.amount }</td>
                <td>${ row.total }</td>
                <td>${ badge }</td>
            </tr>`;
        });
        
        $('#totalAmountExpense').html(obj.total);
        $('#fuelExpRows > tbody').html(html);
        $('#showExpense').modal('show');
    }

    let fetchLoadsByTruck = url => {
        $('#activeLoadsPanel').html(`<div class="col">
            <p><i class="fas fa-spinner fa-pulse"></i> Loading...</p>
        </div>`);
        
        $.ajax({
            url,
            type: 'GET',
            data: { truck_id: $('select[name=truck]').val() },
            success: res => {
                console.log(res);
                let _html = '';
    
                res.forEach(obj => {
                    _html += `<div class="col-6 mb-4">
                        <div class="form-check">
                            <input type="radio" name="load_id" class="form-check-input" id="inlineRadio${obj.id}" value="${obj.id}">
                            <label class="form-check-label" for="inlineRadio${obj.id}">${obj.load_number}</label>
                        </div>
                    </div>`;
                });
    
                $('#activeLoadsPanel').html(_html);
            },
            error: err => {
                $('#activeLoadsPanel').html(`<b style="color:red">* something went wrong!</b>`);
                console.error(err);
            }
        });
    }
</script>
@endsection