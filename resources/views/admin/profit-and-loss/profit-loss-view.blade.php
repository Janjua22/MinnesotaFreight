@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Profit & Loss",
        'sub-title' => "",
        'btn' => null,
        'url' => null
    ];
@endphp

@include('admin.components.top-bar', $titles)

@php
    $currentFullMonth = Carbon\Carbon::now()->englishMonth;
@endphp

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row mb-5">
            <div class="col-xl-12">
                <div class="card card-xl-stretch">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Profit &amp; Loss Report</span>
                            <span class="text-muted fw-bold fs-7">Generate profit and loss statement for a specific period.</span>
                        </h3>

                        @if(isset(request()->date_from) && isset(request()->date_to))
                        <button class="btn btn-success my-3" onclick="printReport();">Print</button>
                        @endif
                    </div>
                    <div class="card-body">
                        <form method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-5 mb-7">
                                        <label>From Date <sup class="text-danger">*</sup></label>
                                        <input type="date" name="date_from" value="{{ isset(request()->date_from) ? request()->date_from : null }}" class="form-control form-control-solid @error('date_from') is-invalid border-danger @enderror" required>
                                    </div>
                                    <div class="form-group col-md-5 mb-7">
                                        <label>To <sup class="text-danger">*</sup></label>
                                        <input type="date" name="date_to" value="{{ isset(request()->date_to) ? request()->date_to : null }}" class="form-control form-control-solid @error('date_to') is-invalid border-danger @enderror" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-success w-100 mt-6">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($data != [])
        <div class="row mb-5" id="test">
            <div class="col-xl-7">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">
                                Statement From: 
                                {{ date_format(new DateTime(request()->date_from), "M d, Y") }} to {{ date_format(new DateTime(request()->date_to), "M d, Y") }}
                            </span>
                            <span class="text-muted fw-bold fs-7">Details of profit and loss statement for selected period</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <h2>Income</h2>
                        <table class="table table-bordered align-middle fs-6 gy-5 border border-dark border-bottom">
                            <tbody>
                                <tr>
                                    <th class="px-3 py-4 fw-bold min-w-150px">Revenue</th>
                                    <td class="text-end px-3 py-4">${{ number_format($data['income']) }}</td>
                                    <td class="px-3 py-4"></td>
                                </tr>
                                <tr class="border-top border-dark bg-light">
                                    <th class="px-3 py-4 fw-bold min-w-125px">Total Income</th>
                                    <td class="px-3 py-4"></td>
                                    <td class="text-end px-3 py-4" colspan="2">${{ number_format($data['income'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2 class="mt-10">Expenses</h2>
                        <table class="table table-bordered align-middle fs-6 gy-5 border border-dark border-bottom">
                            <tbody>
                                <tr class="bg-light">
                                    <th class="px-3 py-4 fw-bold">Drivers</th>
                                    <td class="text-end px-3 py-4">${{ number_format($data['expenses']['drivers'], 2) }}</td>
                                    <td class="px-3 py-4"></td>
                                </tr>
                                <tr class="border-top border-dark">
                                    <th class="px-3 py-4 fw-bold">Accessorial Charges</th>
                                    <td class="text-end px-3 py-4">${{ number_format($data['expenses']['accessorial_amount'], 2) }}</td>
                                    <td class="px-3 py-4"></td>
                                </tr>
                                <tr class="bg-light border-top border-dark">
                                    <th class="px-3 py-4 fw-bold">Factoring Fee</th>
                                    <td class="text-end px-3 py-4">${{ number_format($data['expenses']['factoring_fees'], 2) }}</td>
                                    <td class="px-3 py-4"></td>
                                </tr>
                                <tr class="border-top border-dark">
                                    <th class="px-3 py-4 fw-bold">Fuel Expenses</th>
                                    <td class="text-end px-3 py-4">${{ number_format($data['expenses']['fuel_expenses'], 2) }}</td>
                                    <td class="px-3 py-4"></td>
                                </tr>
                                <tr class="border-top border-dark bg-light">
                                    <th class="px-3 py-4 fw-bold">Total Expenses</th>
                                    <td class="px-3 py-4"></td>
                                    <td class="text-end px-3 py-4">${{ number_format($data['expenses']['total'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered align-middle fs-6 gy-5 border border-dark border-bottom mt-10">
                            <tbody>
                                <tr>
                                    <th class="px-3 py-4 fw-bold min-w-150px">Profit/Loss</th>
                                    <td class="px-3 py-4 min-w-70px"></td>
                                    <td class="text-end px-3 py-4">${{ number_format($data['profit'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Profit &amp; Loss Summary</span>
                            <span class="text-muted fw-bold fs-7">Graphical representation of statement from selected period</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="reportBreakdown" style="height: 510px;"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
@if($data != [])
<script>
    let printReport = ()=>{
        let printWindow = window.open('{!! route("admin.profitLoss", ["date_from" => request()->date_from, "date_to" => request()->date_to, "print" => true]) !!}', 'PRINT', 'height=700,width=950');
        
        printWindow.document.close(); // necessary for IE >= 10
        printWindow.focus(); // necessary for IE >= 10

        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 2800);
    }

    let initChartsWidget = ()=>{
        let element = document.getElementById('reportBreakdown');

        let height = parseInt(KTUtil.css(element, 'height'));
        let labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        let borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        let incomeColor = KTUtil.getCssVariableValue('--bs-info');
        let expenseColor = KTUtil.getCssVariableValue('--bs-danger');
        let profitColor = KTUtil.getCssVariableValue('--bs-warning');

        if(!element){
            return false;
        }

        let options = {
            series: [{ 
                name: 'Total', 
                data: [
                    {{ $data['income'] }}, 
                    {{ $data['expenses']['total'] }}, 
                    {{ $data['profit'] }}
                ],
            }],
            chart: {
                fontFamily: 'inherit',
                type: 'bar',
                height: height,
                toolbar: {
                    show: false
                }
            },
            colors: [incomeColor, expenseColor, profitColor],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['50%'],
                    distributed: true,
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: true
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Income', 'Expenses', 'Profit/Loss'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                y: {
                    formatter: function (val) {
                        return "$"+val
                    }
                }
            },
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        let chart = new ApexCharts(element, options);
        chart.render();   
    }
    
    $(()=>{
        initChartsWidget();
    });
</script>
@endif
@endsection