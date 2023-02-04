@extends('layouts.admin.master')
@section('styles')
<style>
    .change-image-button {
        cursor: pointer;
        position: absolute;
        right: -10px;
        top: -10px;
    }

</style>
@endsection
@section('content')

@php
$titles=[
'title' => "Modules",
'sub-title' => "List",
'btn' => '',
'url' => ''
]
@endphp
@include('admin.components.top-bar', $titles)

<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Alert-->
        @include('admin.components.alerts')
		@if (Session::has('name')) 
			@php 
			$alert= ['name' => Session::get('name')]
			@endphp
			@include('admin.components.alert-module-policy',$alert)
		@endif
		
        <!--end::Alert-->
        
								<!--begin::Card-->
								<div class="card card-flush">
									<!--begin::Card header-->
									<div class="card-header mt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1 me-5">
												<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
												<span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                    {!! getSvg('gen021') !!}
												</span>
												<!--end::Svg Icon-->
												<input type="text" data-kt-modules-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Modules" />
											</div>
											<!--end::Search-->
										</div>
										<!--end::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar">
											<!--begin::Button-->
											<button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_module">
											<!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
											<span class="svg-icon svg-icon-3">
												
                                                {!! getSvg('gen035') !!}
											</span>
											<!--end::Svg Icon-->Add Module</button>
											<!--end::Button-->
										</div>
										<!--end::Card toolbar-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Table-->
										<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_modules_table">
											<!--begin::Table head-->
											<thead>
												<!--begin::Table row-->
												<tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
													<th class="min-w-200px">Name</th>
													<th class="min-w-125px">Status</th>
													<th class="min-w-125px">Created Date</th>
													<th class="text-end min-w-100px">Actions</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="fw-bold text-gray-600">
                                                @forelse ($modules as $module)
												<tr>
													<!--begin::Name=-->
													<td>
														<span href="javascript:void(0);" class="badge badge-light-primary fs-3 m-1">
                                                            {{$module->name}}
                                                        </span>
													</td>
													<!--end::Name=-->
													<!--begin::Status=-->
													<td>
                                                            @if ($module->status == 1)
                                                                <span href="javascript:void(0);" class="badge badge-light-success fs-7 m-1">
                                                                    Active
                                                                </span>
                                                            @else
                                                                <span href="javascript:void(0);" class="badge badge-light-danger fs-7 m-1">
                                                                    Deactivated
                                                                </span>
                                                            @endif
													</td>
													<!--end::Status=-->
													<!--begin::Created Date-->
													<td>{{\Carbon\Carbon::parse($module->created_at)->toDayDateTimeString()}}</td>
													<!--end::Created Date-->
													<!--begin::Action=-->
													<td class="text-end">
														<!--begin::Update-->
														<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3" data-id="{{$module->id}}" data-name="{{$module->name}}" data-status="{{$module->status}}"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_module" >
															<!--begin::Svg Icon | path: icons/duotune/general/gen055.svg-->
															<span class="svg-icon svg-icon-3">
																{!! getSvg('gen055') !!}
															</span>
															<!--end::Svg Icon-->
														</button>
														<!--end::Update-->
													</td>
													<!--end::Action=-->
												</tr>
                                                    
                                                @empty
                                                    
                                                @endforelse
											</tbody>
											<!--end::Table body-->
										</table>
										<!--end::Table-->
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->

								<!--begin::Modals-->
								<!--begin::Modal - Add modules-->
								<div class="modal fade" id="kt_modal_add_module" tabindex="-1" aria-hidden="true">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
                                            <!--begin::Modal header-->
                                            <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                                                <!--begin::Modal title-->
                                                <div class="ribbon-label fw-bolder">
                                                    Create
                                                    <span class="ribbon-inner bg-success"></span>
                                                </div>
                                                <!--end::Modal title-->
                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end"  data-bs-dismiss="modal">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                    <span class="svg-icon svg-icon-1">
                                                        {!! getSvg('arr061') !!}
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                                                    <h2 class="fw-bolder">Add Module</h2>
                                                </div>
                                            </div>
                                            <!--end::Modal header-->
											<!--begin::Modal body-->
											<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
												<!--begin::Form-->
												<form id="kt_modal_add_module_form" class="form" method="POST" action="{{route('admin.modules.store')}}">
                                                    @csrf
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="fs-6 fw-bold form-label mb-2">
															<span class="required">Module Name</span>
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Module names is required to be unique & use only A-Z characters"></i>
														</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="Enter a module name and use only A - Z characters" name="name" required/>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="form-label fw-bold required">Status:</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <div>
                                                            <select  name="status" aria-label="Select a Status"  data-control="select2" data-placeholder="Select a status..." class="form-select form-select-solid form-select-lg fw-bold"  data-allow-clear="true" required>
                                                                <option ></option>
                                                                <option value="1">Active</option>
                                                                <option value="0">Deactivated</option>
                                                            </select>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->
													<!--begin::Actions-->
													<div class="text-center pt-15">
														<button type="reset" class="btn btn-light me-3"   data-bs-dismiss="modal">Discard</button>
														<button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
															<span class="indicator-label">Submit</span>
															<span class="indicator-progress">Please wait...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
														</button>
													</div>
													<!--end::Actions-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Modal body-->
										</div>
										<!--end::Modal content-->
									</div>
									<!--end::Modal dialog-->
								</div>
								<!--end::Modal - Add modules-->
								<!--begin::Modal - Update modules-->
								<div class="modal fade" id="kt_modal_update_module" tabindex="-1" aria-hidden="true">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
                                            <!--begin::Modal header-->
                                            <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                                                <!--begin::Modal title-->
                                                <div class="ribbon-label fw-bolder">
                                                    Update
                                                    <span class="ribbon-inner bg-danger"></span>
                                                </div>
                                                <!--end::Modal title-->
                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end"  data-bs-dismiss="modal">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                    <span class="svg-icon svg-icon-1">
                                                        {!! getSvg('arr061') !!}
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                                                    <h2 class="fw-bolder">Update Module</h2>
                                                </div>
                                            </div>
                                            <!--end::Modal header-->
											<!--begin::Modal body-->
											<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
												<!--begin::Notice-->
												<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
													<!--begin::Icon-->
													<!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
													<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                                        {!! getSvg('gen044') !!}
													</span>
													<!--end::Svg Icon-->
													<!--end::Icon-->
													<!--begin::Wrapper-->
													<div class="d-flex flex-stack flex-grow-1">
														<!--begin::Content-->
														<div class="fw-bold">
															<div class="fs-6 text-gray-700">
															<strong class="me-1">Warning!</strong>By editing the module name, you might break the system <strong class="me-1 text-danger">Access Management Functionality!</strong>. Please ensure you're absolutely certain before proceeding.</div>
														</div>
														<!--end::Content-->
													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Notice-->
												<!--begin::Form-->
												<form id="kt_modal_update_module_form" class="form" method="POST" action="{{route('admin.modules.update')}}">
                                                    @csrf
                                                    <input type="hidden" name="id" id="edit_id">
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="fs-6 fw-bold form-label mb-2">
															<span class="required">Module Name</span>
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Module names is required to be unique & use only A-Z characters"></i>
														</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="Enter a module name and use only A - Z characters" name="name" id="edit_name" required/>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
                                            
                                                    <!--begin::Input group-->
                                                    <div class="fv-row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="form-label fw-bold required">Status:</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <div>
                                                            <select  id="edit_status" name="status" aria-label="Select a Status"  data-control="select2" data-placeholder="Select a status..." class="form-select form-select-solid form-select-lg fw-bold"  data-allow-clear="true" required>
                                                                <option ></option>
                                                                <option value="1">Active</option>
                                                                <option value="0">Deactivated</option>
                                                            </select>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->

													<!--begin::Actions-->
													<div class="text-center pt-15">
														<button type="reset" class="btn btn-light me-3"   data-bs-dismiss="modal">Discard</button>
														<button type="submit" class="btn btn-danger" data-kt-modules-modal-action="submit">
															<span class="indicator-label">Update</span>
															<span class="indicator-progress">Please wait...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
														</button>
													</div>
													<!--end::Actions-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Modal body-->
										</div>
										<!--end::Modal content-->
									</div>
									<!--end::Modal dialog-->
								</div>
								<!--end::Modal - Update modules-->
								<!--end::Modals-->
@endsection
@push('js')
<script src="{{asset('admin/assets/js/custom/apps/user-management/modules/list.js')}}"></script>
<script src="{{asset('admin/assets/js/custom/apps/user-management/modules/add-module.js')}}"></script>
<script src="{{asset('admin/assets/js/custom/apps/user-management/modules/update-module.js')}}"></script>
@endpush
@section('scripts')
<!-- Custom Functions -->
<script>
    
    // const editModal = document.getElementById('kt_modal_update_module');
    // const updateModal = new bootstrap.Modal(editModal);
    // let editModule = (id, name, status ) => {
    //     console.log(id);
    //     $('#edit_id').val(id);
    //     $('#edit_name').val(name);
    //     $('#edit_status').val(status);
    //     updateModal.show();
    //     // var myModalEl = document.getElementById('kt_modal_update_module');
    //     // myModalEl.show();
    // }
    

    $(document).on('show.bs.modal', function (event) {
        // do something...
        var id = $(event.relatedTarget).attr('data-id');
        var name = $(event.relatedTarget).attr('data-name');
        var status = $(event.relatedTarget).attr('data-status');
        
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $("#edit_status").select2("val", status);
        // $('#edit_status').val(status);
        // console.log('dfgh');
    });
</script>

<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection
