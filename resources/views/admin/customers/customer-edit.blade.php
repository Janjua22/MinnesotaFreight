@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Customer",
        'sub-title' => "Edit",
        'btn' => "Customer List",
        'url' => route('admin.customer')
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <div class="card">
                    <div class="card-body p-12">
                        <form action="{{ route('admin.customer.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $customer->id }}">
                            <input type="hidden" name="status" value="{{ $customer->status }}">
                            <input type="hidden" name="latitude" value="{{ $customer->lat }}">
                            <input type="hidden" name="longitude" value="{{ $customer->lng }}">

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Edit Customer</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Customer Details</h4>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-7">
                                        <label>Company Name <sup class="text-danger">*</sup></label>
                                        <input type="text" name="name" value="{{ $customer->name }}" class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="Company Name..." required>
                                    </div>
                                    {{-- <div class="form-group col-md-6 mb-7">
                                        <label>Type <sup class="text-danger">*</sup></label>
                                        <select name="type" class="form-control form-select form-select-solid @error('type') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Type" required>
                                            <option value="">Select Type</option>
                                            <option value="Direct" @if($customer->type == 'Direct') selected @endif>Direct</option>
                                            <option value="Broker" @if($customer->type == 'Broker') selected @endif>Broker</option>
                                            <option value="3PL" @if($customer->type == '3PL') selected @endif>3PL</option>
                                        </select>
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Street</label>
                                        <input type="text" name="street" value="{{ $customer->street }}" class="form-control form-control-solid @error('street') is-invalid border-danger @enderror" placeholder="Street...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Apt/Suite/Other</label>
                                        <input type="text" name="suite" value="{{ $customer->suite }}" class="form-control form-control-solid @error('suite') is-invalid border-danger @enderror" placeholder="Apt/Suite/Other...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>State <sup class="text-danger">*</sup></label>
                                        <select name="state_id" class="form-control form-select form-select-solid @error('state_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select State" onchange="fetchCitiesByState(this, 'city_id', '{{ url('/') }}')" required>
                                            <option value="">Select State</option>
                                            @foreach($STATES as $state)
                                            <option value="{{$state->id}}" @if($customer->state_id == $state->id) selected @endif>{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>City <sup class="text-danger">*</sup></label>
                                        <div></div>
                                        <select name="city_id" class="form-control form-select form-select-solid @error('city_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select City" required>
                                            <option value="{{ $customer->city_id }}" selected>{{ $customer->city ? $customer->city->name : "N/A" }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Zip</label>
                                        <input type="text" name="zip" value="{{ $customer->zip }}" class="form-control form-control-solid @error('zip') is-invalid border-danger @enderror" placeholder="Zip/Postal Code...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Phone</label>
                                        <input type="text" name="phone" value="{{ $customer->phone }}" class="form-control form-control-solid @error('phone') is-invalid border-danger @enderror" placeholder="Phone...">
                                    </div>
                                </div>

                                {{-- <h4 class="form-section mb-8 fs-2">Search Customer Pinpoint</h4>

                                <div class="row">
                                    <div class="form-group col-md-12 mb-7">
                                        <label>Search Location Of Customer</label>
                                        <input type="text" id="pac-input" class="form-control form-control-solid" placeholder="Search for a location...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col p-0">
                                        <div id="map-location" style="height:500px;"></div>
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="form-group mx-auto form-group col-12 mt-3 mb-2">
                                        <button type="submit" class="btn btn-info" id="kt_invoice_submit_button">
                                            Update
                                            <span class="svg-icon svg-icon-3">{!! getSvg('art005') !!}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection