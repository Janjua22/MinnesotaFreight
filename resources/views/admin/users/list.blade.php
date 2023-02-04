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
'title' => "Users",
'sub-title' => "List",
'btn' => 'Create',
'url' => route('admin.users.create')
]
@endphp
@include('admin.components.top-bar', $titles)

<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Alert-->
        @include('admin.components.alerts')
        <!--end::Alert-->
        
								<!--begin::Card-->
								<div class="card">
									<!--begin::Card header-->
									<div class="card-header border-0 pt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1">
												<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
												<span class="svg-icon svg-icon-1 position-absolute ms-6">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
														<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->
												<input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Users" />
											</div>
											<!--end::Search-->
										</div>
										<!--begin::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar">
											<!--begin::Toolbar-->
											<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
												<!--begin::Filter-->
												<button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
												<!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->Filter</button>
												<!--begin::Menu 1-->
												<div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
													<!--begin::Header-->
													<div class="px-7 py-5">
														<div class="fs-5 text-dark fw-bolder">Filter Options</div>
													</div>
													<!--end::Header-->
													<!--begin::Separator-->
													<div class="separator border-gray-200"></div>
													<!--end::Separator-->
													<!--begin::Content-->
													<div class="px-7 py-5" data-kt-user-table-filter="form">
														<!--begin::Input group-->
														<div class="mb-10">
															<label class="form-label fs-6 fw-bold">Role:</label>
															<select class="form-select form-select-solid fw-bolder" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
																<option></option>
                                                                @forelse ($roles as $role)
																<option value="{{ $role->name }}">{{ $role->name }}</option>
                                                                @empty
                                                                @endforelse
															</select>
														</div>
														<!--end::Input group-->
														<!--begin::Actions-->
														<div class="d-flex justify-content-end">
															<button type="reset" class="btn btn-light btn-active-light-primary fw-bold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
															<button type="submit" class="btn btn-success fw-bold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
														</div>
														<!--end::Actions-->
													</div>
													<!--end::Content-->
												</div>
												<!--end::Menu 1-->
												<!--end::Filter-->
												<!--begin::Add user-->
												<a href="{{route('admin.users.create')}}" class="btn btn-success" >
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
														<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->Add User</a>
												<!--end::Add user-->
											</div>
											<!--end::Toolbar-->
											<!--begin::Group actions-->
											<div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
												<div class="fw-bolder me-5">
												<span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
												<button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
											</div>
											<!--end::Group actions-->
										</div>
										<!--end::Card toolbar-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Table-->
										<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
											<!--begin::Table head-->
											<thead>
												<!--begin::Table row-->
												<tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
													{{-- <th class="w-10px pe-2">
														<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
															<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
														</div>
													</th> --}}
													<th class="min-w-125px">User</th>
													<th class="min-w-125px">Role</th>
													{{-- <th class="min-w-125px">Role</th> --}}
													<th class="min-w-125px">Verified</th>
													<th class="min-w-125px">Joined Date</th>
													<th class="text-end min-w-100px">Actions</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody>
                                                @forelse ($users as $user)
                                                    
												<!--begin::Table row-->
												<tr>
													{{-- <!--begin::Checkbox-->
													<td>
														<div class="form-check form-check-sm form-check-custom form-check-solid">
															<input class="form-check-input" type="checkbox" value="1" />
														</div>
													</td>
													<!--end::Checkbox--> --}}
													<!--begin::Name=-->
                                                    <td class="d-flex align-items-center">
                                                        <!--begin:: Avatar -->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <a href="javascript:void(0);">
                                                                <div class="symbol-label">
                                                                    <img src="{{asset(Storage::url($user->image))}}" alt="{{$user->first_name}} {{$user->last_name}}" class="w-100" />
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::User details-->
                                                        <div class="d-flex flex-column">
                                                            <a href="javascript:void(0);" class="text-gray-800 text-hover-primary mb-1">{{$user->first_name}} {{$user->last_name}}</a>
                                                            <span>{{$user->email}}</span>
                                                        </div>
                                                        <!--begin::User details-->
													</td>
													<!--end::User=-->
													<!--begin::Role=-->
													<td>
                                                        <span  class="badge badge-light-success fs-7 m-1">
                                                            {{$user->role->name}}
                                                        </span>
                                                    </td>
                                                    <!--end::Role=-->
													{{-- <!--begin::Role=-->
													<td>
                                                        <a href="javascript:void(0);" class="badge badge-light-success fs-7 m-1">
                                                            {{$user->role->name}}
                                                        </a>
                                                    </td>
                                                    <!--end::Role=--> --}}
													<!--begin::Status=-->
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
                                                    <!--end::Status=-->
                                                    <!--begin::Created Date-->
                                                    <td>{{\Carbon\Carbon::parse($user->created_at)->toDayDateTimeString()}}</td>
                                                    <!--end::Created Date-->
													<!--begin::Action=-->
													<td class="text-end">
														<a href="javascript:void(0);" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">Actions
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon svg-icon-5 m-0">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
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
												<!--end::Table row-->
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


            <form id="deleteUser" action="{{route('admin.users.delete')}}" method="POST"class="form-horizontal form-material">
                @csrf
                <input type="hidden" name="id" id="id" required>
                <input type="hidden" name="name" id="name" required>
            </form>
@endsection
@push('js')
<script src="{{asset('admin/assets/js/custom/apps/user-management/users/list/table.js')}}"></script>
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
</script>

<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection
