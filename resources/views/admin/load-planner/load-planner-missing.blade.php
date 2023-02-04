@extends('layouts.admin.master')

@section('styles')
<style>
    .table-error > :not(:last-child) > :last-child > *, 
    .table-error.table-row-dashed tr{
        border-bottom-color: #f1416c;
    }
    .missing-files-panel .table-error td{
        color: #f1416c;
    }
    .missing-files-panel .table-error th, 
    .missing-files-panel h1,
    .missing-files-panel h1 > i{
        color: #b7002d;
    }
    .missing-files-panel .subtxt{
        font-size: 11px;
    }
</style>
@endsection

@section('content')
@php 
    $titles=[
        'title' => "Load Planner",
        'sub-title' => "Files Missing",
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

        <div class="row gy-5 g-xl-8 mb-8 missing-files-panel">
            <div class="col">
                <div class="border border-dashed border-danger bg-light-danger p-5">
                    <h1><i class="bi bi-exclamation-triangle-fill fs-1"></i> FILES MISSING!</h1>
                    <p class="text-danger mb-0">The <b>Rate of Confirmation</b> or <b>Bill of Lading</b> files missing from the below mentioned loads. Please upload them as soon as possible!</p>
                    <i class="subtxt text-danger">Many of the system functions are dependant on those files, the system may miscalculate or malfunction in case of missing files.</i>
    
                    <table class="table table-error align-middle table-row-dashed border-danger fs-6 gy-5">
                        <thead>
                            <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Load Number</th>
                                <th class="min-w-125px">Customer Name</th>
                                <th class="min-w-125px">Truck Number</th>
                                <th class="min-w-125px">Driver</th>
                                <th class="min-w-125px">Total Stops</th>
                                <th class="min-w-125px">Freight Amount</th>
                                <th class="min-w-125px">Status</th>
                                <th class="min-w-70px">Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($missingFiles as $missingFile)
                            <tr>
                                <td>{{ $missingFile['load_number'] }}</td>
                                <td>{{ $missingFile['customer_name'] }}</td>
                                <td>{{ $missingFile['truck_number'] }}</td>
                                <td>{{ $missingFile['driver_name'] }}</td>
                                <td>{{ $missingFile['stops'] }}</td>
                                <td>
                                    ${{ $missingFile['freight_amount'] }}
                                    <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $missingFile['fee_type'] }}" data-bs-original-title="{{ $missingFile['fee_type'] }}"></i>
                                </td>
                                <td>
                                    @if($missingFile['status'] == 1)
                                        <div class="badge badge-light-success mb-1">Completed</div>
                                    @elseif($missingFile['status'] == 2)
                                        <div class="badge badge-light-primary mb-1">New</div>
                                    @elseif($missingFile['status'] == 3)
                                        <div class="badge badge-light-warning mb-1">In progress</div>
                                    @else
                                        <div class="badge badge-light-danger mb-1">Cancelled</div>
                                    @endif

                                    @if($missingFile['invoiced'])
                                    <div class="badge badge-light-info mb-1">Invoiced</div>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="showUplodModal({{ json_encode($missingFile) }});">Edit</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Load Missing Files Modal -->
    <div class="modal fade" id="editLoadFileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Upload
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Missing Files</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 mb-7">
                    <p>Provide the missing files of this load...</p>
                    <form action="{{ route('admin.loadPlanner.uploadMissingFiles') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="load_id" value="">
                        <div class="form-body">
                            <div class="row d-none" id="fileRC">
                                <div class="form-group col-12 mb-7">
                                    <label for="rateConfirm" class="form-label">Upload Rate Confirmation <sup class="text-danger">*</sup></label>
                                    <input type="file" name="file_rate_confirm" class="form-control @error('file_rate_confirm') is-invalid border-danger @enderror" id="rateConfirm" accept=".pdf, .doc, .docx, .png, .jpg, .jpeg">
                                </div>
                            </div>
                            <div class="row d-none" id="fileBL">
                                <div class="form-group col-12 mb-2">
                                    <label for="fileBol" class="form-label">Upload Bill of Lading <sup class="text-danger">*</sup></label>
                                    <input type="file" name="file_bol" class="form-control @error('file_bol') is-invalid border-danger @enderror" id="fileBol" accept=".pdf, .doc, .docx, .png, .jpg, .jpeg">
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-5">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
                            
                            <button type="submit" class="btn btn-success">
                                <span class="indicator-label">Upload</span>
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
    let showUplodModal = data => {
        if(data.upload_bol){
            $('#fileBL').removeClass('d-none');
        }
        if(data.upload_rc){
            $('#fileRC').removeClass('d-none');
        }

        $('input[name=load_id]').val(data.load_id);

        $('#editLoadFileModal').modal('show');
    }

    $(()=>{
        $('#editLoadFileModal').on('hidden.bs.modal', evt => {
            $('#fileBL').addClass('d-none');
            $('#fileRC').addClass('d-none');
        });
    });
</script>
@endsection