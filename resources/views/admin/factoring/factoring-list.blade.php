@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Factoring Companies",
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
                        <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Company" />
                    </div>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <a href="{{ route('admin.factoringCompanies.add') }}" class="btn btn-success">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                    <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
                                </svg>
                            </span>
                            Add Factoring Company
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                    <thead>
                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Factoring Name</th>
                        <th class="min-w-125px">Tax ID</th>
                        <th class="min-w-125px">Phone</th>
                        <th class="min-w-125px">City</th>
                        <th class="min-w-125px">State</th>
                        <th class="min-w-125px">Added On</th>
                        <th class="min-w-125px">Status</th>
                        <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factoringCompanies as $company)
                        <tr>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->tax_id }}</td>
                            <td>{{ $company->phone }}</td>
                            <td>{{ $company->city->name }}</td>
                            <td>{{ $company->state->name }}</td>
                            <td>{{ date_format($company->created_at, "M d, Y") }}</td>
                            <td>
                                @if($company->status == 1)
                                    <div class="badge badge-light-success">Active</div>
                                @endif
                                @if($company->status == 0)
                                    <div class="badge badge-light-danger">Disabled</div>
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
                                    <div class="menu-item px-3">
                                        @php
                                            $obj = json_encode([
                                                'name' => $company->name,
                                                'street' => $company->street,
                                                'zip' => $company->zip,
                                                'state' => $company->state->name,
                                                'city' => $company->city->name,
                                                'phone' => $company->phone,
                                                'email' => $company->email,
                                                'website' => $company->website,
                                                'tax' => $company->tax_id,
                                                'note' => $company->note ?? 'N/A',
                                                'status' => $company->status ? 'Active' : 'Inactive'
                                            ]);
                                        @endphp

                                        <a href="javascript:void(0);" onclick="showDetailsModal({{ $obj }});" class="menu-link px-3">View</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.factoringCompanies.edit', ['id' => $company->id]) }}" class="menu-link px-3">Edit</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" data-id="{{ $company->id }}" onclick="removeRecord(this);" class="menu-link px-3">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('admin.factoringCompanies.delete') }}" method="POST" class="d-none" id="deleteForm">
                    @csrf
                    <input type="hidden" name="delete_trace" value="">
                </form>
            </div>
        </div>
    </div>

    <!-- View Factoring Company Details Modal -->
    <div class="modal fade" id="viewFactoring" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Details
                        <span class="ribbon-inner bg-info"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end"  data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">View Factoring Company</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Company Name</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-name"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Street</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-street"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">City</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-city"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">State</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-state"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Zip</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-zip"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Phone</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-phone"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Email</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-email"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Website</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-website"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Tax ID (EIN#)</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-tax"></div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="text-gray-400 fw-bold w-150px">Status</div>
                        <div class="text-gray-800 fw-bold" id="mdl-data-status"></div>
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

        $('#viewFactoring').modal('show');
    }
</script>
@endsection