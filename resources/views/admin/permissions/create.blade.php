@extends('layouts.admin.master')
@section('styles')
<style>

</style>
@endsection
@section('content')

@php 
    $titles=[
            'title' => "Create",
            'sub-title' => "Permission",
            'btn' => "List",
            'url' => route('admin.permissions')
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
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <form action="{{route('admin.permissions.store')}}" class="form mb-15 fv-plugins-bootstrap5 fv-plugins-framework" method="post" enctype="multipart/form-data">
                @csrf
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="  mb-3">
                    
                        <div class="row mb-5">
                            
                            <div class="col-md-12 m-b-20">
                                <div class="row">
                                    <div class="col-md-2 m-b-20 mt-3">
                                        <label class=" float-start required fs-5 fw-bold" style="font-size:15px; font-weight: 400;">Role Title </label>
                                    </div>
                                    <div class="col-md-10 m-b-20">
                                        <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="Role Title..." required> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-10 d-flex  mb-3">
                            <div class="w-40 p-2 ">
                                <label class="h1 mb-2 text-danger" for="Module Name">Module Name</label>
                            </div>
                            <div class="w-20 p-2 ">
                                <label class="h1 mb-2 text-danger" for="Module Create">Create</label>
                            </div>
                            <div class="w-20 p-2 ">
                                <label class="h1 mb-2 text-danger" for="Module Read">Read</label>
                            </div>
                            <div class="w-20 p-2 ">
                                <label class="h1 mb-2 text-danger" for="Module Update">Update</label>
                            </div>
                            <div class="w-20 p-2 ">
                                <label class="h1 mb-2 text-danger" for="Module Delete">Delete</label>
                            </div>
                        </div>
                        <div class="row my-5">
                            @foreach ($modules as $module)
                            
                            <input type="hidden" name="modules[{{$module->id}}][module_id]" value="{{$module->id}}">
                            <div class="mb-10 d-flex bd-highlight mb-3">
                                <div class="w-40 p-2 bd-highlight">
                                    <div class="form-check form-switch form-check-custom form-check-success me-10">
                                        <input class="form-check-input h-40px w-60px" type="checkbox" style="border-radius: 3.25rem;" onclick="toggleAll(this,'toggleAll_{{$module->id}}')"     value="1" id="{{$module->id}}">
                                        <label class="form-check-label" for="{{$module->id}}">{{ $module->name}}</label>
                                    </div>
                                </div>
                                <div class="w-20  p-4 bd-highlight">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                        <input class="mx-auto form-check-input h-20px w-30px toggleAll_{{$module->id}}" type="checkbox"  name="modules[{{$module->id}}][permissions][create]"   value="1" id="create{{$module->id}}">
                                        <label class="form-check-label" for="create{{$module->id}}"></label>
                                    </div>
                                </div>
                                <div class="w-20 p-4 bd-highlight">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                        <input class="mx-auto form-check-input h-20px w-30px toggleAll_{{$module->id}}" type="checkbox"  name="modules[{{$module->id}}][permissions][read]"   value="1" id="read{{$module->id}}">
                                        <label class="form-check-label" for="read{{$module->id}}"></label>
                                    </div>
                                </div>
                                <div class="w-20 p-4 bd-highlight">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                        <input class="mx-auto form-check-input h-20px w-30px toggleAll_{{$module->id}}" type="checkbox"  name="modules[{{$module->id}}][permissions][update]"   value="1" id="update{{$module->id}}">
                                        <label class="form-check-label" for="update{{$module->id}}"></label>
                                    </div>
                                </div>
                                <div class="w-20 p-4 bd-highlight">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                        <input class="mx-auto form-check-input h-20px w-30px toggleAll_{{$module->id}}" type="checkbox"  name="modules[{{$module->id}}][permissions][delete]"   value="1" id="delete{{$module->id}}">
                                        <label class="form-check-label" for="delete{{$module->id}}"></label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                </div>
                <!--end::Details-->
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-success" id="kt_account_profile_details_submit">Create</button>
            </div>
        </form>
        </div>
        <!--end::Navbar-->
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
    
    function toggleAll(elem,className){

        if($(elem).prop("checked") == true){
            console.log("Checkbox is checked.");
        // $('.'+className).attr('checked',true);
        $('.'+className).prop("checked", true);
        }
        else if($(elem).prop("checked") == false){
            console.log("Checkbox is unchecked.");
        // $('.'+className).attr('checked',false);
        $('.'+className).prop("checked", false);
        }

        }
</script>

<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection