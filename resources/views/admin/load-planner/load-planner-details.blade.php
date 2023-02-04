@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Load Planner",
        'sub-title' => "Details",
        'btn' => "List",
        'url' => route('admin.loadPlanner')
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        @if($load->is_deleted)
        <div class="row">
            <div class="col">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Warning!</h4>
                    <p>This load has been deleted and no action can be performed on it. However you can restore this record from the trash and perform available actions.</p>
                    <hr>
                    <small class="mb-0 fst-italic">You can only view details of the deleted load on this page.</small>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-8">
                <div class="row mb-6">
                    <div class="col-6">
                        @if($load->settlement)
                        <div class="alert alert-primary mb-6" role="alert">
                            <i class="fas fa-info-circle text-primary"></i> This load is part of a driver settlement!
                        </div>
                        @endif

                        <div class="card">
                            <div class="row g-0">
                                <div class="card-body">
                                    <h4 class="form-section mb-8 fs-2">Basic Details</h4>
                
                                    <div class="d-flex mb-3">
                                        <div class="fw-bold w-150px">Load Number</div>
                                        <div class="text-info fw-bold">{{ $load->load_number }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="fw-bold w-150px">Customer Name</div>
                                        <div class="text-info fw-bold">{{ $load->customer->name }}</div>
                                    </div>
                                    {{-- <div class="d-flex mb-3">
                                        <div class="fw-bold w-150px">Bill of Lading</div>
                                        <div class="text-info fw-bold">{{ $load->bol ?? 'N/A' }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="fw-bold w-150px">Customer Required Info</div>
                                        <div class="text-info fw-bold">{{ $load->required_info ?? 'N/A' }}</div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="row g-0">
                                <div class="card-body">
                                    <h4 class="form-section mb-8 fs-2">Additional Charges</h4>
                
                                    <div class="d-flex mb-3">
                                        <div class="fw-bold w-200px">Stop Off</div>
                                        <div class="text-info fw-bold">{{ $load->fee->stop_off ? '$'.$load->fee->stop_off : 'N/A' }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="fw-bold w-200px">TARP Fee</div>
                                        <div class="text-info fw-bold">{{ $load->fee->tarp_fee ? '$'.$load->fee->tarp_fee : 'N/A' }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="fw-bold w-200px">Invoice Advance</div>
                                        <div class="text-info fw-bold">{{ $load->fee->invoice_advance ? '$'.$load->fee->invoice_advance : 'N/A' }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="fw-bold w-200px">Driver Advance</div>
                                        <div class="text-info fw-bold">{{ $load->fee->driver_advance ? '$'.$load->fee->driver_advance : 'N/A' }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="fw-bold w-200px">Accessorial Charge</div>
                                        <div class="text-info fw-bold">{{ $load->fee->accessorial_amount ? '$'.$load->fee->accessorial_amount : 'N/A' }}</div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="fw-bold w-200px">Accessorial Charges Invoice</div>
                                        <div class="text-info fw-bold">
                                            @if(isset($load->fee->file_accessorial_invoice))
                                                <a href="{{ asset(Storage::url($load->fee->file_accessorial_invoice)) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Accessorial charges invoice attachment. Click to download." data-bs-original-title="Accessorial charges invoice attachment. Click to download." download>
                                                    <img src="{{ asset('admin/assets/media/file-icons/'.pathinfo($load->fee->file_accessorial_invoice, PATHINFO_EXTENSION).'.png') }}" alt="thumbnail-img">
                                                </a>
                                            @else
                                                <span class="badge badge-light-danger">Not Available</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    @foreach($load->destinations as $dest)
                    <div class="col-4">
                        <div class="card text-white box-shadow-3 bg-gradient-directional-secondary text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <p class="fw-bold fs-5">{{ $dest->location->name }}</p>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt"></i> 
                                        {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}
                                    </p>
                                    <p class="card-text">
                                        <i class="fas fa-clock"></i> 
                                        {{ (isset($dest->time))? date_format(new DateTime($dest->time), "h:i a") : '--:--' }}, {{ date_format(new DateTime($dest->date), "M-d-Y") }}
                                    </p>
                                    <p class="card-text">
                                        <i class="fas fa-phone"></i> 
                                        {{ $dest->location->phone }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="row g-0">
                        <div class="card-body">
                            <h4 class="form-section mb-8 fs-2">Fees/Charges</h4>
        
                            <div class="d-flex mb-3">
                                <div class="fw-bold w-150px">Primary Fee Type</div>
                                <div class="text-info fw-bold">{{ $load->fee->fee_type ?? 'N/A' }}</div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="fw-bold w-150px">Freight Amount</div>
                                <div class="text-info fw-bold">${{ $load->fee->freight_amount ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-6">
                    <div class="row g-0">
                        <div class="card-body">
                            <h4 class="form-section mb-8 fs-2">File Archives</h4>
        
                            <div class="d-flex mb-3">
                                <div class="fw-bold w-150px">Rate Confirmation</div>
                                <div class="text-info fw-bold">
                                    @if(isset($load->file_rate_confirm))
                                        <a href="{{ asset(Storage::url($load->file_rate_confirm)) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Rate confirmation attachment. Click to download." data-bs-original-title="Rate confirmation attachment. Click to download." download>
                                            <img src="{{ asset('admin/assets/media/file-icons/'.pathinfo($load->file_rate_confirm, PATHINFO_EXTENSION).'.png') }}" alt="thumbnail-img">
                                        </a>
                                    @else
                                        <span class="badge badge-light-danger">Not Available</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="fw-bold w-150px">Bill of Lading</div>
                                <div class="text-info fw-bold">
                                    @if(isset($load->file_bol))
                                        <a href="{{ asset(Storage::url($load->file_bol)) }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Rate confirmation attachment. Click to download." data-bs-original-title="Rate confirmation attachment. Click to download." download>
                                            <img src="{{ asset('admin/assets/media/file-icons/'.pathinfo($load->file_bol, PATHINFO_EXTENSION).'.png') }}" alt="thumbnail-img">
                                        </a>
                                    @else
                                        <span class="badge badge-light-danger">Not Available</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection