@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Trash",
        'sub-title' => "Records List",
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
            <div class="card-header border-0 pt-6 d-block">
                <div class="row">
                    <div class="col">
                        <h2 class="card-title">Deleted Records</h2>
                        <p>Total {{ $trashRecords->count() }} item(s) in trash</p>
                    </div>
                    @if($trashRecords->count())
                    <div class="col text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#emptyConfirmationModal">
                            <i class="fas fa-trash-alt"></i>
                            Empty Trash
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-body pt-0">
                @forelse($trashRecords as $trash)
                <div class="row my-2">
                    <div class="col-md-1">
                        <img src="{{ asset('admin/assets/media/placeholders/trash.jpg') }}" alt="" class="img-fluid">
                    </div>
                    <div class="col-md-9">
                        {!! $trash->description !!}
                        <small class="fst-italic text-muted">
                            Deleted by {{ $trash->user->first_name." ".$trash->user->last_name }} at {{ date_format($trash->created_at, "h:i a, M d, Y") }}
                        </small>
                    </div>
                    <div class="col-md-2 d-flex align-items-center justify-content-end">
                        <button class="btn btn-success py-4 px-5 m-1" title="Restore Record" onclick="removeRow(this, '{{ route('admin.trash.restore') }}', {{ $trash->id }});">
                            <i class="fas fa-recycle p-0 fs-3"></i>
                        </button>
                        <button class="btn btn-danger py-4 px-5 m-1" title="Permanently Delete" onclick="removeRow(this, '{{ route('admin.trash.delete') }}', {{ $trash->id }});">
                            <i class="far fa-trash-alt p-0 fs-3"></i>
                        </button>
                    </div>
                    <div class="separator separator-dashed"></div>
                </div>
                @empty
                <div class="row mb-2">
                    <div class="col text-center">
                        <img src="https://cdn1.vectorstock.com/i/thumb-large/52/40/cartoon-trash-can-with-lid-open-vector-22755240.jpg" alt="">
                        <h1 class="display-2 text-success">Hoorah!</h1>
                        <p>There are no items in your trash area. All clean!</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="emptyConfirmationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body scroll-y mx-5 my-7 text-center">
                    <i class="fas fa-exclamation-triangle text-danger display-1"></i>
                    <h1>Are You Sure?</h1>
                    <p>You're about to empty the trash folder, all the records will permanently be deleted!</p>
                    <small>
                        <i class="fas fa-info-circle text-primary"></i> 
                        <i class="text-primary">This will take a few seconds to several minutes depending on the total records.</i>
                    </small>

                    <div class="text-center pt-6">
                        <form action="{{ route('admin.trash.deleteAll') }}" class="d-inline" method="POST" onsubmit="return emptyTrash(this);">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <span class="indicator-label">Empty</span>
                            </button>
                        </form>
                        
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center" style="background-color: #fff; color: #363636;">
                    <img src="{{ asset('admin/assets/media/empty.gif') }}" alt="loading..." class="img-fluid">
                    <h2 style="color: #363636;">Emptying Trash...</h2>
                    <p>Removing records from the trash folder. Please wait!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let removeRow = (elem, url, id)=>{
        let _html = $(elem).html();

        $(elem).html(`<i class="fas fa-spinner fa-pulse p-0 fs-3"></i>`);
        $(elem).attr("disabled", "disabled");

        $.ajax({
            url,
            type: 'POST',
            data: {
                id,
                _token: '{{ csrf_token() }}'
            },
            success: res => {
                $(elem).parents('.row').remove();

                toastr["success"](res.msg);
            }, 
            error: err =>{
                $(elem).html(_html);
                $(elem).removeAttr("disabled");
                
                // toastr["error"](res.msg);
                console.log(err);
            }
        });
    }

    let emptyTrash = form => {
        $('#emptyConfirmationModal').modal('hide');
        $('#loadingModal').modal('show');

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: $(form).serializeArray(),
            success: res => {
                toastr["success"](res.msg);

                location.reload();
            }, 
            error: err =>{
                // toastr["error"](res.msg);
                console.log(err);
            },
            complete: ()=>{
                $('#loadingModal').modal('hide');
            }
        });

        return false;
    }
</script>
@endsection