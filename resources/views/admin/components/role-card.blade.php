
										<!--begin::Card-->
										<div class="card card-flush h-md-100">
											<!--begin::Card header-->
											<div class="card-header justify-content-end ribbon ribbon-start ribbon-clip">
												<!--begin::Card title-->
                                                <div class="ribbon-label">
                                                    {{$role->name}}
                                                    <span class="ribbon-inner bg-success"></span>
                                                </div>
												<div class="card-title">
													
												<div class="fw-bolder text-gray-600 mb-5" style="font-size: 1rem"> Total users with this role: <span style="font-size: 1.75rem">{{$role->users->count()}}</span></div>
												</div>
												<!--end::Card title-->
											</div>
											<!--end::Card header-->
											<!--begin::Card body-->
											<div class="card-body pt-1">
												<!--begin::Users-->
												{{-- <div class="fw-bolder text-gray-600 mb-5">Total users with this role: {{$role->users->count()}}</div> --}}
												<!--end::Users-->
												<!--begin::Permissions-->
												<div class="d-flex flex-column text-gray-600">
                                                    <div class="d-flex align-items-center py-2">
                                                        <div class="w-40  p-2">
                                                            <h5>Module</h5>
                                                        </div>
                                                        <div class="w-20  p-2">
                                                            <h5>C</h5>
                                                        </div>
                                                        <div class="w-20  p-2">
                                                            <h5>R</h5>
                                                        </div>
                                                        <div class="w-20  p-2">
                                                            <h5>U</h5>
                                                        </div>
                                                        <div class="w-20  p-2">
                                                            <h5>D</h5>
                                                        </div>
                                                    </div>
                                                    @forelse ($role->permissions as $key => $permission)
                                                        @if ($key < 3)
                                                            <div class="d-flex align-items-center ">
                                                                <div class="w-40  p-2">
                                                                    {{$permission->module->name }} 
                                                                </div>
                                                                <div class="w-20  p-2">
                                                                    @if ($permission->create == 1) <i class="bi bi-check-lg text-success"></i> @else  <i class="bi bi-x-lg text-danger"></i> @endif
                                                                </div>
                                                                <div class="w-20  p-2">
                                                                    @if ($permission->read == 1) <i class="bi bi-check-lg text-success"></i> @else  <i class="bi bi-x-lg text-danger"></i> @endif
                                                                </div>
                                                                <div class="w-20  p-2">
                                                                    @if ($permission->update == 1) <i class="bi bi-check-lg text-success"></i> @else  <i class="bi bi-x-lg text-danger"></i> @endif
                                                                </div>
                                                                <div class="w-20  p-2">
                                                                    @if ($permission->delete == 1) <i class="bi bi-check-lg text-success"></i> @else  <i class="bi bi-x-lg text-danger"></i> @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @empty
                                                        
                                                    @endforelse
                                                    @if($role->permissions->count() > 3)
													<div class='d-flex align-items-center py-2'>
														<em>and {{$role->permissions->count() - 3}} more...</em>
													</div>
                                                    @endif
												</div>
												<!--end::Permissions-->
											</div>
											<!--end::Card body-->
											<!--begin::Card footer-->
											<div class="card-footer flex-wrap pt-0">
                                                @if($check['status'] == 'delete')
												<a onclick="deleteRole({{$role->id}},'{{$role->name}}')" class="btn btn-danger   my-1 me-2">Delete Role</a>
												<a href="{{route('admin.permissions.edit',['id'=>$role->id])}}" class="btn btn-light btn-active-light-primary my-1" >Edit Role</a>
												<button type="button" class="btn btn-primary btn-active-primary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">View Role</button>
                                                @else
												<a href="{{route('admin.permissions.view',['id'=>$role->id])}}" class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
												<a href="{{route('admin.permissions.edit',['id'=>$role->id])}}" class="btn btn-light btn-active-light-primary my-1" >Edit Role</a>
                                                @endif
											</div>
											<!--end::Card footer-->
										</div>
										<!--end::Card-->