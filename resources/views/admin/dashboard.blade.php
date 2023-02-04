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
    'title' => "Dashboard",
    'sub-title' => "",
    'btn' => '',
    'url' => '',
]  
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container">
        <div class="row">
            <div class="col-12">
                <div class="row gy-5 g-xl-8 mb-8">
                    <div class="col-xxl-4">
                        <div class="card card-hover animate__bounceIn">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ route('admin.driverSettlement') }}" class="text-dark">
                                        <img src="{{ asset('admin/assets/media/icons/settlement.png') }}" alt="element 06" width="120" class="float-right mt-6">
                                        <h1 class="text-dark display-3 mb-1">{{ $data['settlements'] }}</h1>
                                        <p class="fw-bolder fs-2 mb-2">Driver Settlements</p>
                                        <p class="fw-bold">See all driver settlements</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="card card-hover animate__bounceIn">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ route('admin.truck') }}" class="text-dark">
                                        <img src="{{ asset('admin/assets/media/icons/truck.png') }}" alt="element 06" width="120" class="float-right mt-6">
                                        <h1 class="text-dark display-3 mb-1">{{ $data['trucks'] }}</h1>
                                        <p class="fw-bolder fs-2 mb-2">Trucks</p>
                                        <p class="fw-bold">View all the trucks</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="card card-hover animate__bounceIn">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ route('admin.loadPlanner') }}" class="text-dark">
                                        <img src="{{ asset('admin/assets/media/icons/load.png') }}" alt="element 06" width="120" class="float-right mt-6">
                                        <h1 class="text-dark display-3 mb-1">{{ $data['loads'] }}</h1>
                                        <p class="fw-bolder fs-2 mb-2">All Loads</p>
                                        <p class="fw-bold">Manage all the loads</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="card card-hover animate__bounceIn">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ $data['missingFiles'] ? route('admin.loadPlanner.missingFiles') : 'javascript:void(0);' }}" class="text-dark">
                                        <img src="{{ asset('admin/assets/media/icons/missing.png') }}" alt="element 06" width="120" class="float-right mt-6">
                                        <h1 class="text-dark display-3 mb-1">{{ $data['missingFiles'] }}</h1>
                                        <p class="fw-bolder fs-2 mb-2">Missing Files</p>
                                        <p class="fw-bold">Resolve the missing files</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="card card-hover animate__bounceIn">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ route('admin.invoice') }}" class="text-dark">
                                        <img src="{{ asset('admin/assets/media/icons/invoice.png') }}" alt="element 06" width="120" class="float-right mt-6">
                                        <h2 class="text-dark display-3 mb-1">{{ $data['invoices'] }}</h2>
                                        <p class="fw-bolder fs-2 mb-2">Total Invoices</p>
                                        <p class="fw-bold">List of all the invoices</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="card card-hover animate__bounceIn">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ route('admin.contacts') }}" class="text-dark">
                                        <img src="{{ asset('admin/assets/media/icons/online.png') }}" alt="element 06" width="120" class="float-right mt-6">
                                        <h1 class="text-dark display-3 mb-1">{{ $data['queries'] }}</h1>
                                        <p class="fw-bolder fs-2 mb-2">Online Queries</p>
                                        <p class="fw-bold">View all contact queries</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="card card-hover animate__bounceIn">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ route('admin.driver') }}" class="text-dark">
                                        <img src="{{ asset('admin/assets/media/icons/driver.png') }}" alt="element 06" width="120" class="float-right mt-6">
                                        <h1 class="display-3 mb-1">{{ $data['drivers'] }}</h1>
                                        <p class="fw-bolder fs-2 mb-2">Drivers</p>
                                        <p class="fw-bold">List of all Drivers</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="card card-hover animate__bounceIn">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ route('admin.customer') }}" class="text-dark">
                                        <img src="{{ asset('admin/assets/media/icons/location.png') }}" alt="element 06" width="120" class="float-right mt-6">
                                        <h2 class="text-dark display-3 mb-1">{{ $data['customers'] }}</h2>
                                        <p class="fw-bolder fs-2 mb-2">Customers</p>
                                        <p class="fw-bold">View all the customers</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="card card-hover animate__bounceIn">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="{{ $data['missingFileDrivers'] ? route('admin.driver.missingFiles') : 'javascript:void(0);' }}" class="text-dark">
                                        <img src="{{ asset('admin/assets/media/icons/missing-license.png') }}" alt="element 06" width="120" class="float-right mt-6">
                                        <h1 class="text-dark display-3 mb-1">{{ $data['missingFileDrivers'] }}</h1>
                                        <p class="fw-bolder fs-2 mb-2">Missing Files</p>
                                        <p class="fw-bold">Missing files of drivers</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-5 g-xl-8">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card mb-xl-8 animate__bounceIn">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bolder text-dark">Loads Breakdown</span>
                            <span class="text-muted mt-1 fw-bold fs-7">List of most recent loads</span>
                        </h3>
                    </div>
                    <div class="card-body pt-3">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                            <thead>
                                <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Load Number</th>
                                    <th class="min-w-125px">Date</th>
                                    <th class="min-w-125px">Route</th>
                                    <th class="min-w-125px text-center">BoL</th>
                                    <th class="min-w-125px">Rate Confirmation</th>
                                    <th class="min-w-125px text-end">Freight Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loads as $load)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.loadPlanner.details', ['id' => $load->id]) }}" target="_blank">
                                            {{ $load->load_number }} <i class="bi bi-box-arrow-up-right text-primary"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{ date_format(new DateTime($load->destinations[0]->date), 'M d, Y') }}
                                    </td>
                                    <td>
                                    @foreach($load->destinations as $i => $dest)
                                        {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}

                                        @if($load->destinations->count() > $i+1)
                                        -
                                        @endif
                                    @endforeach
                                    </td>
                                    <td class="text-center">
                                    @if(isset($load->file_bol))
                                        <a href="{{ asset(Storage::url($load->file_bol)) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bill of Lading attachment. Click to download." data-bs-original-title="Rate confirmation attachment. Click to download." download>
                                            <i class="fas fa-file-invoice fs-1 text-dark"></i>
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                    </td>
                                    <td class="text-center">
                                    @if(isset($load->file_rate_confirm))
                                        <a href="{{ asset(Storage::url($load->file_rate_confirm)) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Rate confirmation attachment. Click to download." data-bs-original-title="Rate confirmation attachment. Click to download." download>
                                            <i class="fas fa-file-invoice-dollar fs-1 text-dark"></i>
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                    </td>
                                    <td class="text-end">${{ $load->fee->freight_amount ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection