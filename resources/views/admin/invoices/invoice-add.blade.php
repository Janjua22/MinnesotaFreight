@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Invoice",
        'sub-title' => "Generate",
        'btn' => "Invoices List",
        'url' => route('admin.invoice')
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <div class="card">
                    <div class="card-body p-12">
                        <form action="{{ route('admin.invoice.create') }}" method="POST">
                            @csrf

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Generate Invoice</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Invoice Details</h4>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Invoice Number <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="Leave empty in-case of computer generated random number." data-bs-original-title="Leave empty in-case of computer generated random number."></i></label>
                                        <input type="text" name="invoice_number" class="form-control form-control-solid @error('invoice_number') is-invalid border-danger @enderror" placeholder="{{ (int)$lastInvoice->invoice_number + 1 }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Invoice Date <sup class="text-danger">*</sup></label>
                                        <input type="date" name="date" class="form-control form-control-solid @error('date') is-invalid border-danger @enderror" placeholder="Invoice Date..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Invoice Due Date <sup class="text-danger">*</sup></label>
                                        <input type="date" name="due_date" class="form-control form-control-solid @error('due_date') is-invalid border-danger @enderror" placeholder="Invoice Due Date..." required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>
                                            Forward To 
                                            <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="Select factoring company to forward this invoice to." data-bs-original-title="Select factoring company to forward this invoice to."></i>
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="factoring_id" class="form-control form-select form-select-solid @error('factoring_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Factoring Company" required>
                                            <option value="">Select Factoring Company</option>
                                        @foreach($factorings as $fact)
                                            <option value="{{ $fact->id }}">{{ $fact->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <h4 class="form-section mb-8 fs-2">Available Loads</h4>

                                <div id="availableLoads">
                                    @foreach($loads as $load)
                                    <input type="hidden" name="customer_ids[]" value="{{ $load->customer_id }}">
                                    <input type="hidden" name="load_ids[]" value="{{ $load->id }}">

                                    <div class="py-0" data-kt-customer-payment-method="row">
                                        <div class="py-3 d-flex flex-stack flex-wrap">
                                            <div class="d-flex align-items-center collapsible collapsed rotate" data-bs-toggle="collapse" href="#load_{{ $load->load_number }}" role="button" aria-expanded="false" aria-controls="load_{{ $load->load_number }}">
                                                <div class="me-3 rotate-90">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                                <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)" />
                                                            </g>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="me-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="text-gray-800 fw-bolder">Load# {{ $load->load_number }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="load_{{ $load->load_number }}" class="collapse fs-6 ps-10" data-bs-parent="#availableLoads">
                                            <div class="pb-5">
                                                <div class="row">
                                                    <div class="col-md-4 mb-7">
                                                        @foreach($load->destinations as $dest)
                                                            @if($dest->stop_number == 1)
                                                            <div class="card bg-light mb-7">
                                                                <div class="card-content">
                                                                    <div class="card-body">
                                                                        <h4 class="card-title">Pick Up:</h4>
                                                                        <p><b>{{$dest->location->name}}</b></p>
                                                                        <p><i class="fas fa-map-marker-alt text-danger"></i> {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}</p>
                                                                        <p><i class="fas fa-calendar text-warning"></i> {{date_format(new DateTime($dest->date), 'M-d-Y')}}</p>
                                                                        <p><i class="fas fa-clock text-info"></i> {{ ($dest->time)?date_format(new DateTime($dest->time), 'h:i, a') : 'n/a'}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                
                                                            @if($dest->stop_number == $load->destinations->count())
                                                            <div class="card bg-light">
                                                                <div class="card-content">
                                                                    <div class="card-body">
                                                                        <h4 class="card-title">Delivery:</h4>
                
                                                                        <p><b>{{$dest->location->name}}</b></p>
                                                                        <p><i class="fas fa-map-marker-alt text-danger"></i> {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}</p>
                                                                        <p><i class="fas fa-calendar text-warning"></i> {{date_format(new DateTime($dest->date), 'M-d-Y')}}</p>
                                                                        <p><i class="fas fa-clock text-info"></i> {{ ($dest->time)?date_format(new DateTime($dest->time), 'h:i, a') : 'n/a'}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-8 mb-7">
                                                        <div class="table-responsive">
                                                            <table class="table border border-dark">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="2" class="bg-light-primary fw-bold px-5">Charges</th>
                                                                    </tr>
                                                                </thead>
                                                                @php
                                                                    $primaryFee = 0;
                                                                    $totalMiles = 0;
                                                                    $titleText = '';
                                                                    $detention = $load->fee->detention ?? 0;
                                                                    $lumper = $load->fee->lumper ?? 0;
                                                                    $stopOff = ($load->destinations->count() -1) * ($load->fee->stop_off ?? 0);
                                                                    $tarpFee = $load->fee->tarp_fee ?? 0;
                                                                    $accessorialAmount = $load->fee->accessorial_amount ?? 0;
                                                                    $invoiceAdvance = $load->fee->invoice_advance ?? 0;
                                                                    
                                                                    // $totalMiles = round($totalMiles / 1609.344, 2);
                
                                                                    switch($load->fee->fee_type){
                                                                        case 'Flat Fee':
                                                                            $primaryFee = $load->fee->freight_amount ?? 0;
                                                                            $titleText = $load->fee->fee_type;
                                                                            break;
                                                                        case 'Per Mile':
                                                                            $primaryFee = $load->fee->freight_amount * $totalMiles ?? 0;
                                                                            $titleText = $load->fee->fee_type.". Total miles: ".$totalMiles.", Fee/Mile: $".$load->fee->freight_amount;
                                                                            break;
                                                                        case 'Per Hundred Weight (cwt)':
                                                                            $primaryFee = $load->fee->freight_amount ?? 0;
                                                                            $titleText = $load->fee->fee_type;
                                                                            break;
                                                                        case 'Per Ton':
                                                                            $primaryFee = $load->fee->freight_amount ?? 0;
                                                                            $titleText = $load->fee->fee_type;
                                                                            break;
                                                                        case 'Per Quantity':
                                                                            $primaryFee = $load->fee->freight_amount ?? 0;
                                                                            $titleText = $load->fee->fee_type;
                                                                            break;
                                                                        default:
                                                                            $primaryFee = $load->fee->freight_amount ?? 0;
                                                                            $titleText = 'Primary Fee';
                                                                            break;
                                                                    }
                
                                                                    $total = $primaryFee + $detention + $lumper + $stopOff + $tarpFee + $accessorialAmount;
                
                                                                    $grandTotal = $total - $invoiceAdvance;
                                                                @endphp
                                                                <tbody>
                                                                    <tr class="border border-dark">
                                                                        <th class="px-2">Primary Fee <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $titleText }}" data-bs-original-title="{{ $titleText }}"></i></th>
                                                                        <td>${{ ($primaryFee)? number_format($primaryFee, 2) : '00.00' }}</td>
                                                                    </tr>
                                                                    <tr class="border border-dark">
                                                                        <th class="px-2">Detention Fee</th>
                                                                        <td>${{$detention ?? '00.00' }}</td>
                                                                    </tr>
                                                                    <tr class="border border-dark">
                                                                        <th class="px-2">Lumper Fee</th>
                                                                        <td>${{$lumper ?? '00.00' }}</td>
                                                                    </tr>
                                                                    <tr class="border border-dark">
                                                                        <th class="px-2">Stop Off Fee</th>
                                                                        <td>${{$stopOff ?? '00.00' }}</td>
                                                                    </tr>
                                                                    <tr class="border border-dark">
                                                                        <th class="px-2">Tarp Fee</th>
                                                                        <td>${{$tarpFee ?? '00.00' }}</td>
                                                                    </tr>
                                                                    <tr class="border border-dark">
                                                                        <th class="px-2">Accessorial Amount</th>
                                                                        <td>${{$load->fee->accessorial_amount ?? '00.00' }}</td>
                                                                    </tr>
                                                                    <tr class="border border-dark">
                                                                        <th class="px-2">Invoice Advance</th>
                                                                        <td class="text-danger">-${{$invoiceAdvance ?? '00.00' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="bg-light-primary fw-bold px-5">Total</th>
                                                                        <th class="bg-light-primary fw-bold px-5">${{ number_format($grandTotal, 2) }}</th>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <a href="{{ route('admin.loadPlanner.details', ['id' => $load->id]) }}" target="_blank">
                                                                <u>View load details <i class="fas fa-external-link-alt text-primary"></i></u>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="separator separator-dashed"></div>
                                    @endforeach
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