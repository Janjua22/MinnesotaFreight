@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Reports",
        'sub-title' => "Factoring Fee",
        'btn' => null,
        'url' => null
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <!--begin::Alert-->
        @include('admin.components.alerts')
        <!--end::Alert-->

        <div class="card">
            <div class="card-header border-0 pt-6 d-block">
                <div class="row">
                    <div class="col">
                        <h2>Factoring Fee</h2>
                        <p class="card-text">Generate a report of a truck's factoring fee in a defined period.</p>
                    </div>
                    @if(count($totalReports))
                        @if($totalReports['factoring_fees'])
                        <div class="col text-end">
                            @php
                                $url = route('admin.report.factoring.print', [
                                    'truck_id' => request()->truck_id, 
                                    'date_from' => request()->date_from, 
                                    'date_to' => request()->date_to
                                ]);
                            @endphp
                            <a href="{{ $url }}" class="btn btn-info btn-sm">
                                <i class="fas fa-download"></i> 
                                Download Report
                            </a>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="card-body pt-5">
                <form action="{{ route('admin.report.factoring') }}" method="GET">
                    <div class="row">
                        <div class="form-group col-4 mb-7">
                            <label>Truck Name <sup class="text-danger">*</sup></label>
                            <select name="truck_id" class="form-control form-select form-select-solid @error('truck_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Truck" required>
                                <option value="">Select Truck</option>
                            @foreach($trucks as $truck)
                                <option value="{{ $truck->id }}" @if(request()->truck_id == $truck->id) selected @endif>{{ $truck->truck_number }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-3 mb-7">
                            <label>Date from <sup class="text-danger">*</sup></label>
                            <input type="date" name="date_from" class="form-control form-control-solid" value="{{ request()->date_from }}" required>
                        </div>
                        <div class="form-group col-3 mb-7">
                            <label>Date to <sup class="text-danger">*</sup></label>
                            <input type="date" name="date_to" class="form-control form-control-solid" value="{{ request()->date_to }}" required>
                        </div>
                        <div class="form-group col-2 mb-7">
                            <button type="submit" class="btn btn-success w-100 mt-6">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>
            @if(count($totalReports))
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                    <thead>
                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Truck Number</th>
                            <th class="min-w-125px">Invoice Number</th>
                            <th class="min-w-125px">Load Number</th>
                            <th class="min-w-125px">Customer</th>
                            <th class="min-w-125px">Total Amount</th>
                            <th class="min-w-125px">Factoring Fee</th>
                            <th class="min-w-125px">Invoice Date</th>
                            <th class="min-w-125px">Paid Date</th>
                            <th class="min-w-125px">Invoice Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($totalReports['factoring_fees'] as $report)
                        <tr>
                            <td>{{ $report['truck_number'] }}</td>
                            <td>
                                <a href="{{ $report['invoice_url'] }}" target="_blank">
                                    {{ $report['invoice_number'] }} 
                                    <i class="bi bi-box-arrow-up-right text-primary" ></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ $report['load_url'] }}" target="_blank">
                                    {{ $report['load_number'] }}
                                    <i class="bi bi-box-arrow-up-right text-primary" ></i>
                                </a>
                            </td>
                            <td>{{ $report['name'] }}</td>
                            <td>${{ $report['total_amount'] }}</td>
                            <td>${{ $report['factoring_fee'] }} ({{ $report['factoring_percentage'] }}%)</td>
                            <td>{{ $report['date'] }}</td>
                            <td>{{ $report['paid_date'] }}</td>
                            <td>
                                @if($report['status'] == 0)
                                <span class="badge badge-light-danger">Canceled</span>
                                @endif
                                @if($report['status'] == 1)
                                <span class="badge badge-light-success">Paid</span>
                                @endif
                                @if($report['status'] == 2)
                                <span class="badge badge-light-warning">Open</span>
                                @endif
                                @if($report['status'] == 3)
                                <span class="badge badge-light-info">Unpaid</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-start fs-7 text-uppercase gs-0">
                            <th colspan="9">
                                Total Amount of Invoices: <b>${{ $totalReports['total_amount'] }}</b>
                            </th>
                        </tr>
                        <tr class="text-start fs-7 text-uppercase gs-0">
                            <th colspan="9">
                                Total Factoring Fee: <b>${{ $totalReports['total_factoring'] }}</b>
                            </th>
                        </tr>
                        <tr class="text-start fs-7 text-uppercase gs-0">
                            <th colspan="9">
                                Factoring Fee Paid: <b>${{ $totalReports['factoring_paid'] }}</b>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection