@extends('layouts.admin.master')
@section('styles')
<style>

</style>
@endsection
@section('content')

@php 
    $titles=[
            'title' => "Permissions" ,
            'sub-title' => $role->name,
            'btn' => "List",
            'url' => route('admin.permissions'),
            ];
            $check = [
            'status' => "delete"
            ];
@endphp
@include('admin.components.top-bar', $titles)

<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Alert-->
        @include('admin.components.alerts')
        <!--end::Alert-->
        
								<!--begin::Layout-->
								<div class="d-flex flex-column flex-xl-row">
									<!--begin::Sidebar-->
									<div class="flex-column flex-lg-row-auto w-100 w-lg-300px mb-10">
                                        @include('admin.components.role-card', [$role , $check])
									</div>
									<!--end::Sidebar-->
									<!--begin::Content-->
									<div class="flex-lg-row-fluid ms-lg-10">
										<!--begin::Card-->
										<div class="card card-flush mb-6 mb-xl-9">
											<!--begin::Card header-->
											<div class="card-header pt-5">
												<!--begin::Card title-->
												<div class="card-title">
													<h2 class="d-flex align-items-center">Users Assigned
													<span class="text-gray-600 fs-6 ms-1">({{$role->users->count()}})</span></h2>
												</div>
												<!--end::Card title-->
												<!--begin::Card toolbar-->
												<div class="card-toolbar">
													<!--begin::Search-->
													<div class="d-flex align-items-center position-relative my-1" data-kt-view-roles-table-toolbar="base">
														<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
														<span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                            {!! getSvg('gen021') !!}
														</span>
														<!--end::Svg Icon-->
														<input type="text" data-kt-roles-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Users" />
													</div>
													<!--end::Search-->
													<!--begin::Group actions-->
													<div class="d-flex justify-content-end align-items-center d-none" data-kt-view-roles-table-toolbar="selected">
														<div class="fw-bolder me-5">
														<span class="me-2" data-kt-view-roles-table-select="selected_count"></span>Selected</div>
														<button type="button" class="btn btn-danger" data-kt-view-roles-table-select="delete_selected">Delete Selected</button>
													</div>
													<!--end::Group actions-->
												</div>
												<!--end::Card toolbar-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body pt-0">
												<!--begin::Table-->
												<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_roles_view_table">
													<!--begin::Table head-->
													<thead>
														<!--begin::Table row-->
														<tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
															{{-- <th class="w-10px pe-2">
																<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																	<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_roles_view_table .form-check-input" value="1" />
																</div>
															</th> --}}
															<th class="min-w-150px">User</th>
															<th class="min-w-75px">Verified</th>
															<th class="min-w-125px">Joined Date</th>
															<th class="text-end min-w-100px">Actions</th>
														</tr>
														<!--end::Table row-->
													</thead>
													<!--end::Table head-->
													<!--begin::Table body-->
													<tbody class="fw-bold text-gray-600">
                                                        @forelse ($role->users as $user)
                                                            
														<tr>
															{{-- <!--begin::Checkbox-->
															<td>
																<div class="form-check form-check-sm form-check-custom form-check-solid">
																	<input class="form-check-input" type="checkbox" value="1" />
																</div>
															</td>
															<!--end::Checkbox--> --}}
															<!--begin::User=-->
															<td class="d-flex align-items-center">
																<!--begin:: Avatar -->
																<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																	<a href="{{route('admin.users.view',['id' => $user->id])}}">
																		<div class="symbol-label">
																			<img src="{{asset(Storage::url($user->image))}}" alt="{{$user->first_name}} {{$user->last_name}}" class="w-100" />
																		</div>
																	</a>
																</div>
																<!--end::Avatar-->
																<!--begin::User details-->
																<div class="d-flex flex-column">
																	<a href="{{route('admin.users.view',['id' => $user->id])}}" class="text-gray-800 text-hover-primary mb-1">{{$user->first_name}} {{$user->last_name}}</a>
																	<span>{{$user->email}}</span>
																</div>
																<!--begin::User details-->
															</td>
															<!--end::user=-->
															<td>
																@if($user->hasVerifiedEmail())
																<span class="svg-icon svg-icon-2tx svg-icon-success">
																	{!! getSvg('gen048') !!}
																</span>
																@else
																<span class="svg-icon svg-icon-2tx svg-icon-danger">
																	{!! getSvg('gen050') !!}
																</span>
																@endif
															</td>
															<!--begin::Joined date=-->
															<td>{{\Carbon\Carbon::parse($user->created_at)->toDayDateTimeString()}}</td>
															<!--end::Joined date=-->
															<!--begin::Action=-->
															<td class="text-end">
																<a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">Actions
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
																<span class="svg-icon svg-icon-5 m-0">
																	{!! getSvg('arr072') !!}
																</span>
																<!--end::Svg Icon--></a>
																<!--begin::Menu-->
																<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<a href="{{route('admin.users.view',['id' => $user->id])}}" class="menu-link px-3">View</a>
																	</div>
																	<!--end::Menu item-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<a href="{{route('admin.users.edit',['id' => $user->id])}}" class="menu-link px-3">Edit</a>
																	</div>
																	<!--end::Menu item-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<a onclick="deleteUser({{$user->id}},'{{$user->first_name}} {{$user->last_name}}')" class="menu-link px-3" >Delete</a>
																	</div>
																	<!--end::Menu item-->
																</div>
																<!--end::Menu-->
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
									<!--end::Content-->
								</div>
								<!--end::Layout-->
                                
										<!--begin::Modal - Update role-->
										<div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
											<!--begin::Modal dialog-->
											<div class="modal-dialog modal-dialog-centered mw-750px">
												<!--begin::Modal content-->
												<div class="modal-content">
													<!--begin::Modal header-->
													<div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
														<!--begin::Modal title-->
                                                        <div class="ribbon-label fw-bolder">
                                                            {{$role->name}}
                                                            <span class="ribbon-inner bg-success"></span>
                                                        </div>
														<!--end::Modal title-->
														<!--begin::Close-->
														<div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end"  class="btn-close" data-bs-dismiss="modal" aria-label="Close">
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
															<span class="svg-icon svg-icon-1">
																{!! getSvg('arr061') !!}
															</span>
															<!--end::Svg Icon-->
														</div>
														<!--end::Close-->
                                                        <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                                                            <h2 class="fw-bolder">Role Permissions</h2>
                                                        </div>
													</div>
													<!--end::Modal header-->
													<!--begin::Modal body-->
													<div class="modal-body scroll-y mx-5 my-7">
															<!--begin::Scroll-->
															<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">

																<!--begin::Permissions-->
																<div class="fv-row">
																	<!--begin::Table wrapper-->
																	<div class="table-responsive">
																		<!--begin::Table-->
																		<table class="table align-middle table-row-dashed fs-6 gy-5">
                                                                            <thead class="text-gray-900 fw-bolder">
                                                                                <th class="h5"> Module </th>
                                                                                <th class="h5"> 
                                                                                    <div class="d-flex align-items-center ">
                                                                                        <div class="w-25  p-2">
                                                                                            C
                                                                                        </div>
                                                                                        <div class="w-25  p-2">
                                                                                            R
                                                                                        </div>
                                                                                        <div class="w-25  p-2">
                                                                                            U
                                                                                        </div>
                                                                                        <div class="w-25  p-2">
                                                                                            D
                                                                                        </div>
                                                                                    </div>
                                                                                </th>
                                                                            </thead>
																			<!--begin::Table body-->
																			<tbody>
                                                                                @forelse ($role->permissions as $key => $permission)
																				<!--begin::Table row-->
																				<tr>
																					<!--begin::Label-->
																					<td class="text-gray-600">
                                                                                        {{$permission->module->name }} 
                                                                                    </td>
																					<!--end::Label-->
																					<!--begin::Input group-->
																					<td>
																						<!--begin::Wrapper-->
                                                                                        <div class="d-flex align-items-center ">
                                                                                            <div class="w-25  p-2">
                                                                                                @if ($permission->create == 1) <i class="bi bi-check-lg text-success"></i> @else  <i class="bi bi-x-lg text-danger"></i> @endif
                                                                                            </div>
                                                                                            <div class="w-25  p-2">
                                                                                                @if ($permission->read == 1) <i class="bi bi-check-lg text-success"></i> @else  <i class="bi bi-x-lg text-danger"></i> @endif
                                                                                            </div>
                                                                                            <div class="w-25  p-2">
                                                                                                @if ($permission->update == 1) <i class="bi bi-check-lg text-success"></i> @else  <i class="bi bi-x-lg text-danger"></i> @endif
                                                                                            </div>
                                                                                            <div class="w-25  p-2">
                                                                                                @if ($permission->delete == 1) <i class="bi bi-check-lg text-success"></i> @else  <i class="bi bi-x-lg text-danger"></i> @endif
                                                                                            </div>
                                                                                        </div>
																						<!--end::Wrapper-->
																					</td>
																					<!--end::Input group-->
																				</tr>
																				<!--end::Table row-->
                                                                                    
                                                                                @empty
                                                                                    
                                                                                @endforelse
																			</tbody>
																			<!--end::Table body-->
																		</table>
																		<!--end::Table-->
																	</div>
																	<!--end::Table wrapper-->
																</div>
																<!--end::Permissions-->
															</div>
															<!--end::Scroll-->
													</div>
													<!--end::Modal body-->
												</div>
												<!--end::Modal content-->
											</div>
											<!--end::Modal dialog-->
										</div>
										<!--end::Modal - Update role-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->


<form id="deleteUser" action="{{route('admin.permissions.delete')}}" method="POST"class="form-horizontal form-material">
	@csrf
	<input type="hidden" name="id" id="id" required>
	<input type="hidden" name="name" id="name" required>
</form>
@endsection
@push('js')
<script src="{{asset('admin/assets/js/custom/apps/user-management/roles/view/view.js')}}"></script>
@endpush
@section('scripts')
<!-- Custom Functions -->
<script>
    
    function deleteUser(id,name)
	{
        $('#id').val(id);
        $('#name').val(name);
		// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
		Swal.fire({
			text: "Are you sure you want to delete " + name + "?",
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
			if (result.value) {

				$("#deleteUser").submit();
			} else if (result.dismiss === 'cancel') {
				Swal.fire({
					text: name + " was not deleted.",
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
    
    function deleteRole(id,name)
	{
        $('#id').val(id);
        $('#name').val(name);
		
		// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
		if({{$role->users->count()}} > 0)
		{

			Swal.fire({
					text: name + " is related to some user/users.. kindly change their role than you'll be able to delete this role !!",
					icon: "error",
					buttonsStyling: false,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn fw-bold btn-success",
					}
				});
		}
		else
		{
		Swal.fire({
			text: "Are you sure you want to delete " + name + "?",
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
			if (result.value) {

				$("#deleteUser").submit();
			} else if (result.dismiss === 'cancel') {
				Swal.fire({
					text: name + " was not deleted.",
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
	}
</script>

<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection