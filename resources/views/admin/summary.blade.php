@extends('layouts.admin.master')

@section('styles')
<style>
    .card-hover:hover{
        box-shadow: 0px 0px 25px 0px #d7d7d7;
        transform: scale(1.05);
        transition-duration: 0.2s;
    }
</style>
@endsection

@section('content')
@php 
$titles=[
    'title' => "Summary",
    'sub-title' => "",
    'btn' => '',
    'url' => '',
]  
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container">
        <div class="row gy-5 g-xl-8">
            <div class="col-xl-3 col-md-6">
                <div class="card mb-xl-8 animate__bounceIn">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bolder text-dark">Invoices Summary</span>
                            <span class="text-muted mt-1 fw-bold fs-7">Graphical representation of paid invoices</span>
                        </h3>
                    </div>
                    <div class="card-body pt-3">
                        <div id="invoiceDoughnut" data-kt-chart-color="success" data-percent="{{ $data['invoicesGraph']['percentage'] }}" style="height:280px"></div>
                        <div class="pt-2">
                            <p class="fs-6">
                                <span class="badge badge-light-danger fs-8">Note:</span>&nbsp; This graph represents the percentage of paid invoices out of all the invoices.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card mb-xl-8 animate__bounceIn">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bolder text-dark">Loads Summary</span>
                            <span class="text-muted mt-1 fw-bold fs-7">Graphical representation of settled loads.</span>
                        </h3>
                    </div>
                    <div class="card-body pt-3">
                        @php
                            $loadPercentage = $data['settledLoads'] ? ($data['settledLoads'] / $data['loads']) * 100 : 0;
                        @endphp
                        <div id="loadDoughnut" data-kt-chart-color="primary" data-percent="{{ round($loadPercentage, 2)  }}" style="height:280px"></div>
                        <div class="pt-2">
                            <p class="fs-6">
                                <span class="badge badge-light-danger fs-8">Note:</span>&nbsp; This is a percentage of settled down loads out of all the loads.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12">
                <div class="card card-xl-stretch mb-xl-8 animate__bounceIn">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bolder text-dark">Monthly Report</span>
                            <span class="text-muted mt-1 fw-bold fs-7">Monthly invoices and driver settlements report for this year.</span>
                        </h3>
                    </div>
                    <div class="card-body pt-3">
                        <div id="monthlyChart" style="height: 350px"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-5 g-xl-8 mb-8">
            <div class="col-xl-6">
                <div class="card card-xl-stretch mb-xl-8 animate__bounceIn">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bolder text-dark">License Expiration</span>
                            <span class="text-muted mt-1 fw-bold fs-7">Driver license expiration details</span>
                        </h3>
                    </div>
                    <div class="card-body pt-3">
                        @forelse($licenseExpirations as $license)
                        <div class="d-flex align-items-sm-center mb-7">
                            <div class="symbol symbol-60px me-4">
                                <a href="{{ route('admin.driver.details', ['id' => $license->userDetails->driverDetails->id]) }}">
                                    <div class="symbol-label" style="background-image: url({{ asset(Storage::url($license->userDetails->image)) }})"></div>
                                </a>
                            </div>
                            <div class="d-flex flex-row-fluid flex-wrap align-items-center">
                                <div class="flex-grow-1 me-2">
                                    <a href="{{ route('admin.driver.details', ['id' => $license->userDetails->driverDetails->id]) }}" class="text-gray-800 fw-bolder text-hover-primary fs-6">
                                        {{ $license->userDetails->first_name." ".$license->userDetails->last_name }}
                                    </a>
                                    <span class="text-muted fw-bold d-block pt-1">License Number: {{ $license->license_number }}</span>
                                    <span class="text-muted fw-bold d-block pt-1">Expiration Date: {{ date_format(new DateTime($license->expiration), 'M d, Y') }}</span>
                                </div>
                                <span class="badge badge-light-danger fs-8 fw-bolder my-2">{{ Carbon\Carbon::now()->diffInDays($license->expiration." 23:59:59") }} Days Remaining</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center">
                            <i class="fas fa-id-badge fa-5x text-muted mb-2"></i>
                            <h2 class="text-muted">All Good!</h2>
                            <p class="text-muted">There are no nearby license expirations.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card card-xl-stretch mb-xl-8 animate__bounceIn">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bolder text-dark">Medical Renewal</span>
                            <span class="text-muted mt-1 fw-bold fs-7">Driver medical card renewal details</span>
                        </h3>
                    </div>
                    <div class="card-body pt-3">
                        @forelse($medicalRenewals as $medical)
                        <div class="d-flex align-items-sm-center mb-7">
                            <div class="symbol symbol-60px me-4">
                                <a href="{{ route('admin.driver.details', ['id' => $medical->id]) }}">
                                    <div class="symbol-label" style="background-image: url({{ asset(Storage::url($medical->userDetails->image)) }})"></div>
                                </a>
                            </div>
                            <div class="d-flex flex-row-fluid flex-wrap align-items-center">
                                <div class="flex-grow-1 me-2">
                                    <a href="{{ route('admin.driver.details', ['id' => $medical->id]) }}" class="text-gray-800 fw-bolder text-hover-primary fs-6">
                                        {{ $medical->userDetails->first_name." ".$medical->userDetails->last_name }}
                                    </a>
                                    <span class="text-muted fw-bold d-block pt-1">Renewal Date: {{ date_format(new DateTime($medical->med_renewal), 'M d, Y') }}</span>
                                </div>
                                <span class="badge badge-light-danger fs-8 fw-bolder my-2">{{ Carbon\Carbon::now()->diffInDays($medical->med_renewal." 23:59:59") }} Days Remaining</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center">
                            <i class="fas fa-first-aid fa-5x text-muted mb-2"></i>
                            <h2 class="text-muted">Good News!</h2>
                            <p class="text-muted">No upcoming medical card renewals.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var data = {!! json_encode($data['invAndSett']) !!};

    let initChartsWidget = id => {
        let element = document.getElementById(id);

        let height = parseInt(KTUtil.css(element, 'height'));
        let labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        let borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        let incomeColor = KTUtil.getCssVariableValue('--bs-info');
        let expenseColor = KTUtil.getCssVariableValue('--bs-danger');
        let incomeArr = [];
        let expenseArr = [];
        let calendar = [];

        if (!element) {
            return false;
        }

        for(key in data){
            calendar.push(key); 
            incomeArr.push(data[key].income);
            expenseArr.push(data[key].expenses);
        }

        let options = {
            series: [
                {name: 'Invoices', data: incomeArr}, 
                {name: 'Settlements', data: expenseArr}
            ],
            chart: {
                fontFamily: 'inherit',
                type: 'bar',
                height: height,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['30%'],
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
                categories: calendar,
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
            colors: [incomeColor, expenseColor],
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

    let initDoughnutWidget = id => {
        let element = document.getElementById(id);
        let height = parseInt(KTUtil.css(element, 'height'));

        if(!element){
            return;
        }

        let color = element.getAttribute('data-kt-chart-color');

        let baseColor = KTUtil.getCssVariableValue('--bs-' + color);
        let lightColor = KTUtil.getCssVariableValue('--bs-light-' + color );
        let labelColor = KTUtil.getCssVariableValue('--bs-' + 'gray-700');

        let options = {
            series: [element.getAttribute('data-percent')],
            chart: {
                fontFamily: 'inherit',
                height: height,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: "65%"
                    },
                    dataLabels: {
                        showOn: "always",
                        name: {
                            show: false,
                            fontWeight: '700'
                        },
                        value: {
                            color: labelColor,
                            fontSize: "30px",
                            fontWeight: '700',
                            offsetY: 12,
                            show: true,
                            formatter: function (val) {
                                return val + '%';
                            }
                        },
                    },
                    track: {
                        background: lightColor,
                        strokeWidth: '100%'
                    }
                }
            },
            colors: [baseColor],
            stroke: {
                lineCap: "round",
            },
            labels: ["Paid Invoices"]
        };

        let chart = new ApexCharts(element, options);
        chart.render();      
    }
    
    $(function(){
        initChartsWidget("monthlyChart");
        initDoughnutWidget("invoiceDoughnut");
        initDoughnutWidget("loadDoughnut");
    });
</script>
@endsection