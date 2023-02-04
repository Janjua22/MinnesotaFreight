@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Location",
        'sub-title' => "Details",
        'btn' => "List",
        'url' => route('admin.location')
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <input type="hidden" name="latitude" value="{{ $location->lat }}">
                            <input type="hidden" name="longitude" value="{{ $location->lng }}">
                            
                            <div class="rounded-start" id="map-location" style="height:100%;"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h4 class="form-section mb-8 fs-2">Location Details</h4>

                                <div class="d-flex mb-3">
                                    <div class="text-gray-400 fw-bold w-150px">Company Name</div>
                                    <div class="text-gray-800 fw-bold">{{ $location->name }}</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="text-gray-400 fw-bold w-150px">Type</div>
                                    <div class="text-gray-800 fw-bold">{{ $location->type }}</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="text-gray-400 fw-bold w-150px">Street</div>
                                    <div class="text-gray-800 fw-bold">{{ $location->street }}</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="text-gray-400 fw-bold w-150px">Apt/Suite</div>
                                    <div class="text-gray-800 fw-bold">{{ $location->suite }}</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="text-gray-400 fw-bold w-150px">State</div>
                                    <div class="text-gray-800 fw-bold">{{ $location->state ? $location->state->name : "N/A" }}</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="text-gray-400 fw-bold w-150px">City</div>
                                    <div class="text-gray-800 fw-bold">{{ $location->city ? $location->city->name : "N/A" }}</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="text-gray-400 fw-bold w-150px">Zip</div>
                                    <div class="text-gray-800 fw-bold">{{ $location->zip }}</div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="text-gray-400 fw-bold w-150px">Phone</div>
                                    <div class="text-gray-800 fw-bold">{{ $location->phone }}</div>
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