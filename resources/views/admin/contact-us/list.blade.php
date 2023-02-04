@extends('layouts.admin.master')

@section('styles')
<style>
    .change-image-button{
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
        'title' => "Contact Us",
        'sub-title' => "List",
        'btn' => '',
        'url' => ''
    ];
    @endphp

    @include('admin.components.top-bar', $titles)
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            @include('admin.components.alerts')
        
            <div class="card card-flush">
                <div class="card-header mt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                {!! getSvg('gen021') !!}
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-modules-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Contacts" />
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_modules_table">
                        <thead>
                            <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-200px">Name</th>
                                <th class="min-w-125px">Subject</th>
                                <th class="min-w-125px">Message</th>
                                <th class="min-w-125px">Created Date</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                            @forelse ($contacts as $contact)
                            <tr @if($contact->read == 1) class="bg-light" @endif>
                                <td class="d-flex align-items-center">
                                    <div class="d-flex flex-column ms-2">
                                        <a href="javascript:void(0);" class="text-gray-800 text-hover-primary mb-1">{{$contact->name}} </a>
                                        <span>{{$contact->email}}</span>
                                    </div>
                                </td>
                                <td>
                                    {{$contact->subject}}
                                </td>
                                <td>
                                    {{textCrop($contact->message,60)}}
                                </td>
                                <td>{{\Carbon\Carbon::parse($contact->created_at)->toFormattedDateString()}}</td>
                                <td class="text-center">
                                    <button class="btn btn-icon @if($contact->read == 1)  btn-light-warning @endif btn-active-light-warning w-30px h-30px me-3" data-id="{{$contact->id}}" data-name="{{$contact->name}}"  data-email="{{$contact->email}}" data-subject="{{$contact->subject}}" data-message="{{$contact->message}}"  data-bs-toggle="modal" data-bs-target="#kt_modal_update_module" >
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen055.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            {!! getSvg('arr035') !!}
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                </td>
                            </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_update_module" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <!--begin::Modal title-->
                    <div class="ribbon-label fw-bolder">
                        View
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
                        <h2 class="fw-bolder">Contact Us</h2>
                    </div>
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_update_module_form" class="form"">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mb-2">
                                <span class="required">Name</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input readonly class="form-control form-control-solid" placeholder="Full name" name="name" id="name" required/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mb-2">
                                <span class="required">Email</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input readonly class="form-control form-control-solid" placeholder="Email" name="email" id="email" required/>
                            <!--end::Input-->
                        </div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <div class="col-lg-12">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mb-2">
                                    <span class="required">Subject</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input readonly class="form-control form-control-solid" placeholder="Subject" name="subject" id="subject" required/>
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mb-2">
                                <span class="required">message</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea readonly class="form-control form-control-solid" placeholder="message" name="message" id="message" required cols="30" rows="4"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection

@push('js')
<script src="{{asset('admin/assets/js/custom/apps/user-management/modules/list.js')}}"></script>
@endpush

@section('scripts')
<script>
    $(document).on('show.bs.modal', function (event) {
        // do something...
        var name = $(event.relatedTarget).attr('data-name');
        var email = $(event.relatedTarget).attr('data-email');
        var subject = $(event.relatedTarget).attr('data-subject');
        var message = $(event.relatedTarget).attr('data-message');
        console.log(message);
        $('#name').val(name);
        $('#email').val(email);
        $('#subject').val(subject);
        $('#message').html(message);
		
		var elem = event.relatedTarget;
        var id = $(event.relatedTarget).attr('data-id');
        $.ajax({
           type:'POST',
           url:"{{ route('admin.contacts.read') }}",
           data:{"id":id},
           success:function(data){
               if( data.success )
               {
					$(elem).parents('tr').addClass('bg-light');
               }
           }
        });
    });
</script>
<!-- Toaster Alerts -->
@include('admin.components.toaster')

@endsection