@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "States & Cities",
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

        <div class="row">
            <div class="col-5">
                <div class="card mb-6">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">Add State</div>
                    </div>
        
                    <div class="card-body pt-0">
                        <form action="{{ route('admin.stateCity.createState') }}" method="POST">
                            @csrf
    
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-9">
                                        <label>State Name <sup class="text-danger">*</sup></label>
                                        <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="State Name..." required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button class="btn btn-success w-100 mt-6" type="submit">Add</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
                                <input type="text" data-kt-state-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search State" />
                            </div>
                        </div>
                    </div>
        
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="statesTable">
                            <thead>
                                <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">State Name</th>
                                    <th class="text-end min-w-70px">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <div class="card mb-6">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">Add City</div>
                    </div>
        
                    <div class="card-body pt-0">
                        <form action="{{ route('admin.stateCity.createCity') }}" method="POST">
                            @csrf
    
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label>City Name <sup class="text-danger">*</sup></label>
                                        <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="City Name..." required>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>City belongs to state <sup class="text-danger">*</sup></label>
                                        <select name="state_id" class="form-control form-select form-select-solid @error('state_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select State" required>
                                            <option value="">Select State</option>
                                        @foreach($STATES as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button class="btn btn-success w-100 mt-6" type="submit">Add</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
                                <input type="text" data-kt-city-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search City" />
                            </div>
                        </div>
                    </div>
        
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="cityTable">
                            <thead>
                                <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">City Name</th>
                                    <th class="min-w-125px">State</th>
                                    <th class="text-end min-w-70px">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit State Modal -->
    <div class="modal fade" id="edit_state" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Edit
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">State</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="{{ route('admin.stateCity.updateState') }}" method="POST">
                        @csrf
                        <input type="hidden" name="state_id">

                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-warning-circle text-warning"></i> Warning:</h4>
                            <p>Modifying the state name will take effect throughout the whole system. The old entries will also be affected.</p>
                            <hr>
                            <small class="mb-0 fst-italic">Proceed with caution!</small>
                        </div>

                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Name <sup class="text-danger">*</sup></label>
                                    <input type="text" name="state_name" class="form-control form-control-solid @error('state_name') is-invalid border-danger @enderror" placeholder="State Name..." required>
                                </div>
                            </div>
                        </div>
    
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                                <span class="indicator-label">Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit City Modal -->
    <div class="modal fade" id="edit_city" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Edit
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
                    <form action="{{ route('admin.stateCity.updateCity') }}" method="POST">
                        @csrf
                        <input type="hidden" name="city_id">

                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-warning-circle text-warning"></i> Warning:</h4>
                            <p>Modifying the city name and reassigning the state will take effect throughout the whole system. Old entries with this city will be affected and might show different state than selected one.</p>
                            <hr>
                            <small class="mb-0 fst-italic">Proceed only if you're certain what you are doing!</small>
                        </div>

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
                                    <select name="state_id" class="form-control form-select form-select-solid @error('state_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select State" required>
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
                                <span class="indicator-label">Update</span>
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
    let stateTable;
    let cityTable;
    

    let showEditModal = (prefix, obj)=>{
        if(prefix == 'state'){
            $(`#edit_${prefix} input[name=${prefix}_id]`).val(obj.id);
            $(`#edit_${prefix} input[name=${prefix}_name]`).val(obj.name);
        } else{
            $(`#edit_${prefix} input[name=${prefix}_id]`).val(obj.id);
            $(`#edit_${prefix} input[name=${prefix}_name]`).val(obj.name);
            $(`#edit_${prefix} select[name=state_id]`).val(obj.state_id);
            $(`#edit_${prefix} select[name=state_id]`).select2('val', obj.state_id);
        }


        $('#edit_'+prefix).modal('show');
    }

    $(()=>{
        $('input[data-kt-state-table-filter="search"]').keyup(e => {
            stateTable.search(e.target.value).draw();
        });
        $('input[data-kt-city-table-filter="search"]').keyup(e => {
            cityTable.search(e.target.value).draw();
        });

        stateTable = $('#statesTable').DataTable({
            searching: true,
            processing: true,
            bLengthChange: false,
            serverSide: true,
            ajax: "{{ route('admin.stateCity.ajaxState') }}",
            columns: [
                { data: "name", orderable: false },
                { 
                    data: "id", 
                    orderable: false,
                    className: 'text-end',
                    render(id, type, row){
                        let htmlStruct = `<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">Actions</button>

                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4 dropdown-menu">
                                <div class="menu-item px-3">
                                    <a href="javascript:void(0);" onclick="showEditModal('state', {id: ${row.id}, name: '${row.name}'});" class="menu-link px-3">Edit</a>
                                </div>
                            </div>
                        </div>`;

                        return htmlStruct;
                    }
                },
            ],
        });
        
        cityTable = $('#cityTable').DataTable({
            searching: true,
            processing: true,
            bLengthChange: false,
            serverSide: true,
            ajax: "{{ route('admin.stateCity.ajaxCity') }}",
            columns: [
                { data: "name", orderable: false },
                { data: "state_name", orderable: false },
                { 
                    data: "id", 
                    orderable: false,
                    className: 'text-end',
                    render(id, type, row){
                        let htmlStruct = `<div class="dropdown">
                            <button class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">Actions</button>

                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4 dropdown-menu">
                                <div class="menu-item px-3">
                                    <a href="javascript:void(0);" onclick="showEditModal('city', {id: ${row.id}, name: '${row.name}', state_id: ${row.state_id}, state_name: '${row.state_name}'});" class="menu-link px-3">Edit</a>
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