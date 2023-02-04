@extends('layouts.admin.master')

@section('styles')
<style>
    @-webkit-keyframes alertAnimate {
        0% {
            box-shadow: 0px 0px 0px 0px #f1416c;
        }
        25% {
            box-shadow: 0px 0px 4px 1px #f1416c;
        }
        50% {
            box-shadow: 0px 0px 8px 2px #f1416c;
        }
        75% {
            box-shadow: 0px 0px 4px 1px #f1416c;
        }
        100% {
            box-shadow: 0px 0px 0px 0px #f1416c;
        }
    }

    @keyframes alertAnimate {
        0% {
            box-shadow: 0px 0px 0px 0px #f1416c;
        }
        25% {
            box-shadow: 0px 0px 4px 1px #f1416c;
        }
        50% {
            box-shadow: 0px 0px 8px 2px #f1416c;
        }
        75% {
            box-shadow: 0px 0px 4px 1px #f1416c;
        }
        100% {
            box-shadow: 0px 0px 0px 0px #f1416c;
        }
    }

    .alert-animate{
        border-radius: 50%;
        padding: 0px;
        -webkit-animation-name: alertAnimate;
        animation-name: alertAnimate;
        -webkit-animation-duration: 0.5s;
        animation-duration: 0.5s;
        -webkit-animation-delay: 0s;
        animation-delay: 0s;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
    }
</style>
@endsection

@section('content')
@php 
    $titles=[
        'title' => "Load Planner",
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
                        <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Load" />
                    </div>
                </div>

                <div class="card-toolbar">
                      <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <a href="{{ route('admin.loadPlanner.showcheckLoads') }}" class="btn btn-success me-5">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                    <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
                                </svg>
                            </span>
                             All Completed
                        </a>
                    </div>
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <a href="{{ route('admin.loadPlanner.add') }}" class="btn btn-success">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                    <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
                                </svg>
                            </span>
                            Add Load
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                    <thead>
                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Load Number</th>
                            <th class="min-w-125px">Customer Name</th>
                            <th class="min-w-125px">Truck Number</th>
                            <th class="min-w-125px">Driver</th>
                            <th class="min-w-125px">Total Stops</th>
                            <th class="min-w-125px">Freight Amount</th>
                            <th class="min-w-125px">Status</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loads as $load)

                        @php
                            // (disabled the uneditable feature on the request of the client at 03-Mar-2022)
                            // 
                            // $editable = true;
                            
                            // if($load->invoice){
                            //     if($load->invoice->status != 2){
                            //         $editable = false;
                            //     }
                            // }
                        @endphp
						@if(!empty($load->customer->name) && !empty($load->truck->truck_number))
                        <tr>
                            <td>
                                {{-- @if(!$editable || $load->status == 1)
                                <i class="fas fa-lock me-3" data-bs-toggle="tooltip" title="This load is uneditable!" style="color:#787b87;"></i>
                                @endif --}}

                                {{ $load->load_number }}
                                @php
                                    if($load->file_rate_confirm == null && $load->file_bol == null){
                                        $alertMsg = "Bill of Lading and Rate of Confirmation files are missing from this load! Please attach them as soon as possible!";
                                    } elseif ($load->file_rate_confirm == null) {
                                        $alertMsg = "Rate of Confirmation file is missing, please attach it!";
                                    } elseif ($load->file_bol == null) {
                                        $alertMsg = "Bill of Lading file is missing, please attach it!";
                                    } else {
                                        $alertMsg = false;
                                    }
                                @endphp

                                @if($alertMsg)
                                <i class="fas fa-exclamation-circle text-danger fs-4 alert-animate" data-bs-toggle="tooltip" title="{{ $alertMsg }}"></i>
                                @endif
                            </td>
                            <td>{{ $load->customer->name }}</td>
                            <td>{{ $load->truck->truck_number }}</td>
                            <td>{{ $load->driver->userDetails->first_name ?? ''}} {{ $load->driver->userDetails->last_name ?? '' }}</td>
                            <td>{{ $load->destinations->count() }}</td>
                            <td>
                                ${{ $load->fee->freight_amount ?? 'N/A' }} 
                                <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $load->fee->fee_type }}" data-bs-original-title="{{ $load->fee->fee_type }}"></i>
                            </td>
                            <td>
                                @if($load->status == 1)
                                    <div class="badge badge-light-success">Completed</div>
                                @elseif($load->status == 2)
                                    <div class="badge badge-light-primary">New</div>
                                @elseif($load->status == 3)
                                    <div class="badge badge-light-warning">In progress</div>
                                @else
                                    <div class="badge badge-light-danger">Cancelled</div>
                                @endif

                                @if($load->invoiced)
                                    <div class="badge badge-light-info" data-bs-toggle="tooltip" title="This load is invoiced, editing this load also will make changes to the related invoice!">Invoiced</div>
                                @endif

                                @if($load->settlement)
                                    <div class="badge badge-light-dark" data-bs-toggle="tooltip" title="A settlement is generated for this load!">Settlement</div>
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
                                    @if($load->status != 1)
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3" onclick="populateForm({{ $load->id }});">Complete</a>
                                    </div>
                                    @endif
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.loadPlanner.details', ['id' => $load->id]) }}" class="menu-link px-3">View</a>
                                    </div>
                                    {{-- @if($load->status != 1 && $editable) --}}
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.loadPlanner.edit', ['id' => $load->id]) }}" class="menu-link px-3">Edit</a>
                                    </div>
                                    {{-- @endif --}}
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" data-id="{{ $load->id }}" onclick="removeRecord(this);" class="menu-link px-3">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
						@endif
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('admin.loadPlanner.delete') }}" method="POST" class="d-none" id="deleteForm">
                    @csrf
                    <input type="hidden" name="delete_trace" value="">
                </form>

                <form action="{{ route('admin.loadPlanner.completed') }}" method="POST" class="d-none" id="completeForm">
                    @csrf
                    <input type="hidden" name="id" value="">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let populateForm = id => {
        $('#completeForm input[name=id]').val(id);
        $('#completeForm').submit();
    }
</script>
@endsection