@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Invoice",
        'sub-title' => "Batch",
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
                <div class="card-title">Invoice Batches</div>
            </div>

            <div class="card-body pt-0">
                @forelse ($batches as $batch)

                @php
                    $arr = array();
                    $factoringAmount = 0;

                    foreach($batch->downloads->sortDesc() as $download){
                        array_push($arr, [
                            'user' => $download->userDetails->first_name." ".$download->userDetails->last_name,
                            'time' => date_format($download->downloaded_at, 'h:ia, M d, Y')
                        ]);
                    }

                    foreach($batch->invoices as $inv){
                        if($inv->include_factoring){
                            $factoringAmount += ($inv->total_balance * $inv->factoring_fee) / 100;
                        }
                    }

                    $json_obj = json_encode(['batch' => $batch->batch_number, 'data' => $arr]);
                @endphp

                <div class="card-title mt-5 bg-light p-3" role="button" data-bs-toggle="collapse" data-bs-target="#batch{{ $batch->id }}" aria-expanded="true" aria-controls="batch{{ $batch->id }}">
                    <div class="row">
                        <div class="col-2">
                            <h3 class="fw-bolder"><i class="bi bi-box-seam fs-4 text-dark"></i> Batch #{{ $batch->batch_number }}</h3>
                            <p class="mb-0">Click to expand</p>
                        </div>
                        <div class="col-2">
                            <h3 class="fw-bolder">No. of Invoices</h3>
                            <p class="mb-0">{{ $batch->invoices->count() }} invoice(s)</p>
                        </div>
                        <div class="col-2">
                            <h3 class="fw-bolder">Post Date</h3>
                            <p class="mb-0">{{ date_format($batch->created_at, 'M d, Y') }}</p>
                        </div>
                        <div class="col-2">
                            <h3 class="fw-bolder">Invoice Amount</h3>
                            <p class="mb-0 text-info">${{ number_format($batch->invoices->sum('total_amount'), 2) }}</p>
                        </div>
                        <div class="col-2">
                            <h3 class="fw-bolder">Expected Amount</h3>
                            <p class="mb-0 text-danger">${{ number_format($factoringAmount, 2) }}</p>
                        </div>
                        <div class="col-2">
                            <h3 class="fw-bolder">Downloads</h3>
                            <p class="mb-0">Downloaded {{ $batch->downloads->count() }} times</p>
                        </div>
                    </div>
                </div>
                <div id="batch{{ $batch->id }}" class="collapse mb-3">
                    <div class="row my-5">
                        <div class="col d-flex align-items-center">
                            <a href="javascript:void(0);" onclick="viewLogs({{ $json_obj }});">View Download Logs</a>
                        </div>
                        <div class="col text-end">
                            <button type="button" class="btn btn-sm btn-success" onclick="downloadBatch({{ $batch->id }});">Download Batch File</button>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-2"></div>
                    <table class="table align-middle table-row-dashed fs-6">
                        <thead>
                            <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Invoice Number</th>
                                <th class="min-w-125px">Load Number</th>
                                <th class="min-w-125px">Customer Name</th>
                                <th class="min-w-125px">Total Amount</th>
                                <th class="min-w-125px">Invoice Date</th>
                                <th class="min-w-125px">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batch->invoices as $inv)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.invoice.print', ['id' => $inv->id]) }}" target="_blank">
                                        {{ $inv->invoice_number }} <i class="bi bi-box-arrow-up-right text-primary"></i>
                                    </a>
                                </td>
                                <td>{{ $inv->loadPlanner->load_number }}</td>
                                <td>{{ $inv->customer->name }}</td>
                                <td>
                                    ${{ number_format($inv->total_amount, 2) }} 
                                    @if($inv->include_factoring)
                                    <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="Factoring Fee: -{{ $inv->factoring_fee }}%" data-bs-original-title="Factoring Fee: -{{ $inv->factoring_fee }}%"></i>
                                    @endif
                                </td>
                                <td>{{ ($inv->date)? date_format(new DateTime($inv->date), "M d, Y") : 'N/A' }}</td>
                                <td>
                                    @if($inv->status == 0)
                                    <span class="badge badge-light-danger">Canceled</span>
                                    @endif
                                    @if($inv->status == 1)
                                    <span class="badge badge-light-success">Paid</span>
                                    @endif
                                    @if($inv->status == 2)
                                    <span class="badge badge-light-warning">Open</span>
                                    @endif
                                    @if($inv->status == 3)
                                    <span class="badge badge-light-info">Unpaid</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @empty
                <div class="col text-center py-5">
                    <i class="fas fa-box-open fa-5x text-muted"></i>
                    <h2 class="text-muted">No Batch Found</h2>
                    <p class="text-muted">There are no batches of invoice in the system.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <form action="{{ route('admin.invoiceBatch.download') }}" method="POST" name="download" class="d-none">
        @csrf
        <input type="hidden" name="batch_id" value="">
    </form>

    <!-- Download Logs Modal -->
    <div class="modal fade" id="downloadLogsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Logs
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder" id="headingModal"></h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5" style="max-height: 500px;">
                    @for($i = 0; $i < 50; $i++)
                    <div class="row">
                        <div class="col">
                            <p><b>Super Admin</b> has downloaded this file at <b>12:45pm, Feb 22, 2022</b></p>
                            <div class="separator separator-dashed my-2"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let downloadBatch = id => {
        $('input[name=batch_id]').val(id);
        $('form[name=download]').submit();
    }

    let viewLogs = obj => {
        let html = '';
        $('#headingModal').html("Batch #"+obj.batch);

        obj.data.map(row => {
            html += `<div class="row">
                <div class="col">
                    <p><b>${ row.user }</b> has downloaded this file at <b>${ row.time }</b></p>
                    <div class="separator separator-dashed my-2"></div>
                </div>
            </div>`;
        });

        $('.modal-body').html(html);

        $('#downloadLogsModal').modal('show');
    }
</script>
@endsection