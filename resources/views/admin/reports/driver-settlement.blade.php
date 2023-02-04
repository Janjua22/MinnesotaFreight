@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Reports",
        'sub-title' => "Driver Settlements",
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
                        <h2>Driver's Settlement</h2>
                        <p class="card-text">Generate a report of a single driver's paid settlements for a defined period.</p>
                    </div>
                    @if(count($totalReports))
                        @if($totalReports['settlements'])
                        <div class="col text-end">
                            @php
                                $url = route('admin.report.settlement.print', [
                                    'driver_id' => request()->driver_id, 
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
                <form action="{{ route('admin.report.settlement') }}" method="GET">
                    <div class="row">
                        <div class="form-group col-4 mb-7">
                            <label>Driver Name <sup class="text-danger">*</sup></label>
                            <select name="driver_id" class="form-control form-select form-select-solid @error('driver_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Driver" required>
                                <option value="">Select Driver</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->user_id }}" @if(request()->driver_id == $driver->user_id) selected @endif>{{ $driver->userDetails->first_name." ".$driver->userDetails->last_name }}</option>
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
                            <th class="min-w-125px">Total Amount</th>
                            <th class="min-w-125px">Deductions</th>
                            <th class="min-w-125px">Paid Amount</th>
                            <th class="min-w-125px">Paid Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($totalReports['settlements'] as $report)
                        <tr>
                            <td>${{ $report['gross_amount'] }}</td>
                            <td>${{ $report['deduction_amount'] }}</td>
                            <td>${{ $report['paid_amount'] }}</td>
                            <td>{{ $report['paid_date'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-start fs-7 text-uppercase gs-0">
                            <th colspan="2">
                                Total Loads Delivered: <b>{{ $totalReports['total_loads'] }}</b>
                            </th>
                            <th colspan="2">
                                Total Amount Paid: <b>${{ $totalReports['driver_pay'] }}</b>
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