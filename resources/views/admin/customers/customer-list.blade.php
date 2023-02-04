@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Customers",
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
                        <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Customer" />
                    </div>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <a href="{{ route('admin.customer.add') }}" class="btn btn-success">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                    <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
                                </svg>
                            </span>
                            Add Customer
                        </a>
                        {{-- <a href="javascript:void(0);" class="btn btn-success ms-3" onclick="$('input[name=file_excel]').click();">
                            <i class="fas fa-upload"></i> 
                            Upload Sheet
                        </a>
                        <form action="{{ route('admin.import.customers') }}" method="POST" class="d-none" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file_excel" onchange="$(this).parent().submit();" accept=".xls,.xlsx,.csv">
                        </form> --}}
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="customersTbl">
                    <thead>
                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Company Name</th>
                            <th class="min-w-125px">Type</th>
                            <th class="min-w-125px">Street</th>
                            <th class="min-w-125px">City</th>
                            <th class="min-w-125px">State</th>
                            <th class="min-w-125px">Status</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                </table>

                <form action="{{ route('admin.customer.delete') }}" method="POST" class="d-none" id="deleteForm">
                    @csrf
                    <input type="hidden" name="delete_trace" value="">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let customerTable;

    let deleteConfirm = e => {
        let parent = $(e).parents('tr');
        let customerName = parent.children('td')[0].innerText;

        Swal.fire({
            text: "Are you sure you want to delete " + customerName + "?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function (result) {
            $('#deleteForm input[name=delete_trace]').val($(e).attr('data-id'));
            
            if (result.value) {
                Swal.fire({
                    text: "You have deleted " + customerName + "!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Close",
                    customClass: {
                        confirmButton: "btn fw-bold btn-success",
                    }
                }).then(function () {
                    datatable.row($(parent)).remove().draw();
                    $('#deleteForm').submit();
                }).then(function () {
                    // toggleToolbars();
                });
            } else if (result.dismiss === 'cancel') {
                Swal.fire({
                    text: customerName + " was not deleted.",
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

    $(()=>{
        $('input[data-kt-subscription-table-filter="search"]').keyup(e => {
            customerTable.search(e.target.value).draw();
        });

        customerTable = $('#customersTbl').DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.customer.ajax') }}",
            columns: [
                { data: "name", orderable: false },
                { 
                    data: "type", 
                    orderable: false,
                    render(tp, type, row){
                        return `<div class="badge badge-light">${ tp }</div>`;
                    }
                },
                { data: "street", orderable: false },
                { data: "city", orderable: false },
                { data: "state", orderable: false },
                { 
                    data: "status", 
                    orderable: false, 
                    render(status, type, row){
                        let htmlStruct;

                        if(status){
                            htmlStruct = `<div class="badge badge-light-success">Active</div>`;
                        } else{
                            htmlStruct = `<div class="badge badge-light-danger">Disabled</div>`;
                        }

                        return htmlStruct;
                    }
                },
                { 
                    data: "id", 
                    orderable: false,
                    className: 'text-end',
                    render(id, type, row){
                        let htmlStruct = `<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">Actions</button>

                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4 dropdown-menu">
                                <div class="menu-item px-3">
                                    <a href="{{ route('admin.customer.details') }}/${ id }" class="menu-link px-3">View</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="{{ route('admin.customer.edit') }}/${ id }" class="menu-link px-3">Edit</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="javascript:void(0);" data-id="${ id }" onclick="deleteConfirm(this);" class="menu-link px-3">Delete</a>
                                </div>
                            </div>
                        </div>`;

                        return htmlStruct;
                    }
                },
            ],
        });
    });
</script>
@endsection