@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Archives",
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
                    <h1>Archive Details</h1>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        <a href="{{ route('admin.customer.add') }}" class="btn btn-success" data-bs-target="#addFileModal" data-bs-toggle="modal">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                    <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
                                </svg>
                            </span>
                            Add File
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                @forelse($dates->reverse() as $date => $archives)
                <div class="card-title mt-5" role="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ date_format(new DateTime($date), "M-d") }}" aria-expanded="true" aria-controls="collapse{{ date_format(new DateTime($date), "M-d") }}">
                    <h3 class="fw-bolder">{{ date_format(new DateTime($date), "M d, Y") }}</h3>
                </div>
                <div id="collapse{{ date_format(new DateTime($date), "M-d") }}" class="collapse mb-3 show">
                    <div class="row my-2">
                        @foreach($archives as $archive)
                        <div class="col-2">
                            <a href="{{ asset(Storage::url($archive->path)) }}" target="_blank" class="fw-bolder mb-5 d-block">
                                {{-- <img src="{{ asset(($archive->status == 0)? 'admin/assets/media/archive.png' : 'admin/assets/media/archive-completed.png') }}" alt="archive file" class="img-fluid"> --}}
                                <img src="{{ asset('admin/assets/media/file-icons/new/'.pathinfo($archive->path, PATHINFO_EXTENSION).'.png') }}" alt="archive file" class="img-fluid">
                            </a>
                            <a href="{{ asset(Storage::url($archive->path)) }}" target="_blank" class="fw-bolder mb-5 d-block {{ $archive->status ? 'text-decoration-line-through' : null }}">
                                {{ $archive->title }}
                                @if($archive->status)
                                <span class="badge badge-success">completed</span>
                                @endif
                            </a>
                            <div class="btn-group btn-group d-flex" role="group" aria-label="Basic example">
                                <a href="{{ asset(Storage::url($archive->path)) }}" type="button" class="btn btn-success w-100" download data-bs-toggle="tooltip" title="Download this file" data-bs-placement="bottom">
                                    <i class="bi bi-cloud-download fs-2"></i>
                                </a>
                                @if($archive->status == 0)
                                    <button type="button" class="btn btn-success w-100" onclick="markAsComplete(this, {{ $archive->id }}, '{{ route('admin.archive.update') }}');" data-bs-toggle="tooltip" title="Mark as completed!" data-bs-placement="bottom">
                                        <i class="bi bi-check2-all fs-2"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-danger w-100" onclick="deleteFile(this, {{ $archive->id }});" data-bs-toggle="tooltip" title="Delete" data-bs-placement="bottom">
                                        <i class="bi bi-trash fs-2"></i>
                                    </button>
                                @endif
                              </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="separator separator-dashed my-2"></div>
                @empty
                <div class="row">
                    <div class="col text-center">
                        <i class="bi bi-archive display-1"></i>
                        <h3 class="text-muted">Archive Empty!</h3>
                        <p class="text-muted">There are no files in the archive. Please upload new files.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Add Files Modal -->
    <div class="modal fade" id="addFileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Create
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Add New Archive</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="{{ route('admin.archive.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Title <sup class="text-danger">*</sup></label>
                                    <input type="text" name="title" class="form-control form-control-solid @error('title') is-invalid border-danger @enderror" placeholder="File Title..." required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>File <sup class="text-danger">*</sup></label>
                                    <input type="file" name="file" class="form-control form-control-solid @error('file') is-invalid border-danger @enderror" accept=".pdf, .png, .jpg, .jpeg" required>
                                </div>
                            </div>
                        </div>
    
                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
    
                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                                <span class="indicator-label">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.archive.delete') }}" method="POST" class="d-none" id="deleteForm">
        @csrf
        <input type="hidden" name="delete_trace" value="">
    </form>
</div>
@endsection

@section('scripts')
<script>
    let markAsComplete = (btn, id, url)=>{
        $(btn).html(`<i class="fas fa-spinner fa-pulse p-0 fs-3"></i>`);

        let imgSrc = $(btn).parents('.col-2').find('img').attr('src');

        $(btn).attr('disabled', true);

        $.ajax({
            url,
            type: 'POST',
            data: {
                id, 
                _token: $('input[name=_token]').val()
            },
            success: res => {
                // $(btn).parents('.col-2').find('img').attr('src', imgSrc.replace('archive', 'archive-completed'));

                let titleTxt = $(btn).parent().prev().html();
                $(btn).parent().prev().html(`${titleTxt} <span class="badge badge-success">completed</span>`);
                $(btn).parent().prev().addClass('text-decoration-line-through');

                $(btn).html(`<i class="bi bi-trash fs-2"></i>`);
                $(btn).toggleClass('btn-success btn-danger');
                $(btn).attr("title", "delete");
                $(btn).attr("onclick", `deleteFile(this, ${id})`);

                $(btn).removeAttr('disabled');
            },
            error: err => {
                console.error(err);

                $(btn).html(`<i class="bi bi-check2-all fs-2"></i>`);
                $(btn).removeAttr('disabled');
            }
        });
    }

    let deleteFile = (btn, id)=>{
        $(btn).html(`<i class="fas fa-spinner fa-pulse p-0 fs-3"></i>`);

        $('#deleteForm > input[name=delete_trace]').val(id);
        $('#deleteForm').submit();
    }
</script>
@endsection