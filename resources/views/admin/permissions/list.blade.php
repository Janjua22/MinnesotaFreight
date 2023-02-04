@extends('layouts.admin.master')
@section('styles')
<style>

</style>
@endsection
@section('content')

@php 
    $titles=[
            'title' => "Permission",
            'sub-title' => "List",
            'btn' => "Create",
            'url' => route('admin.permissions.create'),
            ];
            $check = [
            'status' => "view"
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
								<!--begin::Row-->
								<div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 g-5 g-xl-9">
                                    @forelse ($roles as $role)
                                        

									<!--begin::Col-->
									<div class="col-md-6">
                                        @include('admin.components.role-card', [$role , $check])
									</div>
									<!--end::Col-->
                                    @empty
                                        
                                    @endforelse
                                </div>
								<!--end::Row-->
                                
								<!--begin::Row-->
								<div class="row row-cols-1 row-cols-md-2 row-cols-xl-1 g-5 g-xl-9 mt-5">
									<!--begin::Add new card-->
									<div class="col-md-4">
										<!--begin::Card-->
										<div class="card h-md-100">
											<!--begin::Card body-->
											<div class="card-body d-flex flex-center">
												<!--begin::Button-->
												<a  class="btn btn-clear d-flex flex-column flex-center" href="{{route('admin.permissions.create')}}">
													<!--begin::Illustration-->
													<img src="assets/media/illustrations/unitedpalms-1/4.png" alt="" class="mw-100 mh-150px mb-7" />
													<!--end::Illustration-->
													<!--begin::Label-->
													<div class="fw-bolder fs-3 text-gray-600 text-hover-primary">Add New Role</div>
													<!--end::Label-->
												</a>
												<!--begin::Button-->
											</div>
											<!--begin::Card body-->
										</div>
										<!--begin::Card-->
									</div>
									<!--begin::Add new card-->
								</div>
								<!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->

@endsection
@push('js')
@endpush
@section('scripts')
<!-- Custom Functions -->
<script>
    
</script>

<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection