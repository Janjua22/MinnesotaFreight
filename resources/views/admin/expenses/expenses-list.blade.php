@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Expenses",
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
                        <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Expense" />
                    </div>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <a href="{{ route('admin.expenses.add') }}" class="btn btn-success">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                    <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
                                </svg>
                            </span>
                            Add Expenses
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                    <thead>
                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Expense Category</th>
                        <th class="min-w-125px">Amount</th>
                        <th class="min-w-125px">Date</th>
                        <th class="min-w-125px">Truck Number</th>
                        <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->category->name }}</td>
                            <td>${{ $expense->amount }}</td>
                            <td>{{ date_format(new DateTime($expense->date), 'M d, Y') }}</td>
                            <td>{{ $expense->truck->truck_number }}</td>
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
                                    <div class="menu-item px-3">
                                        @php
                                            $obj = json_encode([
                                                'category' => $expense->category->name,
                                                'date' => date_format(new DateTime($expense->date), 'M d, Y'),
                                                'amount' => '$'.$expense->amount,
                                                'truck' => $expense->truck->truck_number,
                                                'load' => $expense->loadPlanner->load_number,
                                                'gallons' => $expense->gallons,
                                                'odometer' => number_format($expense->odometer).' mi',
                                                'note' => $expense->note ?? 'N/A'
                                            ]);   
                                        @endphp
                                        <a href="javascript:void(0);" onclick="showDetailsModal({{ $obj }});" class="menu-link px-3">View</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.expenses.edit', ['id' => $expense->id]) }}" class="menu-link px-3">Edit</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" data-id="{{ $expense->id }}" onclick="removeRecord(this);" class="menu-link px-3">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('admin.expenses.delete') }}" method="POST" class="d-none" id="deleteForm">
                    @csrf
                    <input type="hidden" name="delete_trace" value="">
                </form>
            </div>
        </div>
    </div>

    <!-- View Expense Ctegory Details Modal -->
    <div class="modal fade" id="viewExpense" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Details
                        <span class="ribbon-inner bg-info"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Expense Details</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Expense Category</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-category"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Date</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-date"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Amount</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-amount"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Truck/Unit</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-truck"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Load Number</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-load"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Gallons</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-gallons"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Odometer</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-odometer"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Note</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-note"></div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
                    </div>
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
</script>
@endsection