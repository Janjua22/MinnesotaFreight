@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Factoring Company",
        'sub-title' => "Add",
        'btn' => "Factoring Companies List",
        'url' => route('admin.factoringCompanies')
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <div class="card">
                    <div class="card-body p-12">
                        <form action="{{ route('admin.factoringCompanies.create') }}" method="POST">
                            @csrf

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Add Factoring Company</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Factoring Company Details</h4>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Factoring Company Name <sup class="text-danger">*</sup></label>
                                        <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="Factoring Company Name..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Street</label>
                                        <input type="text" name="street" class="form-control form-control-solid @error('street') is-invalid border-danger @enderror" placeholder="Street...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-7">
                                        <label>Zip <sup class="text-danger">*</sup></label>
                                        <input type="text" name="zip" class="form-control form-control-solid @error('zip') is-invalid border-danger @enderror" placeholder="Zip/Postal Code..." required>
                                    </div>
                                    <div class="form-group col-md-4 mb-7">
                                        <label>State <sup class="text-danger">*</sup></label>
                                        <select name="state_id" class="form-control form-select form-select-solid @error('state_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select State" onchange="fetchCitiesByState(this, 'city_id', '{{ url('/') }}')" required>
                                            <option value="">Select State</option>
                                            @foreach($STATES as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 mb-7">
                                        <label>City <sup class="text-danger">*</sup></label>
                                        <div></div>
                                        <select name="city_id" class="form-control form-select form-select-solid @error('city_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select City" required></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Phone <sup class="text-danger">*</sup></label>
                                        <input type="text" name="phone" class="form-control form-control-solid @error('phone') is-invalid border-danger @enderror" placeholder="Phone..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Email <sup class="text-danger">*</sup></label>
                                        <input type="text" name="email" class="form-control form-control-solid @error('email') is-invalid border-danger @enderror" placeholder="Email..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Website</label>
                                        <input type="text" name="website" class="form-control form-control-solid @error('website') is-invalid border-danger @enderror" placeholder="Website...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Tax ID (EIN#)</label>
                                        <input type="text" name="tax_id" class="form-control form-control-solid @error('tax_id') is-invalid border-danger @enderror" placeholder="Tax ID (EIN#)...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-7">
                                        <label>Note</label>
                                        <textarea name="note" class="form-control form-control-solid @error('note') is-invalid border-danger @enderror" rows="5" placeholder="Any details here..." maxlength="255"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mx-auto form-group col-12 mt-3 mb-2">
                                        <button type="submit" class="btn btn-success" id="kt_invoice_submit_button">
                                            Submit
                                            <span class="svg-icon svg-icon-3">{!! getSvg('gen016') !!}</span>
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