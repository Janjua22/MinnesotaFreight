@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Invoice",
        'sub-title' => "Edit",
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
                        <form action="{{ route('admin.invoice.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $invoice->id }}">

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Edit Invoice</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Invoice Details</h4>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Invoice Number <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="Leave empty in-case of computer generated random number." data-bs-original-title="Leave empty in-case of computer generated random number."></i></label>
                                        <input type="text" name="invoice_number" value="{{ $invoice->invoice_number }}" class="form-control form-control-solid @error('invoice_number') is-invalid border-danger @enderror" placeholder="Invoice Number...">
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Invoice Date <sup class="text-danger">*</sup></label>
                                        <input type="date" name="date" value="{{ $invoice->date }}" class="form-control form-control-solid @error('date') is-invalid border-danger @enderror" placeholder="Invoice Date..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Invoice Due Date <sup class="text-danger">*</sup></label>
                                        <input type="date" name="due_date" value="{{ $invoice->due_date }}" class="form-control form-control-solid @error('due_date') is-invalid border-danger @enderror" placeholder="Invoice Due Date..." required>
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
                                            <option value="{{ $fact->id }}" @if($fact->id == $invoice->factoring_id) selected @endif>{{ $fact->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <h4 class="form-section mb-8 fs-2">
                                    Load# 
                                    <a href="{{ route('admin.loadPlanner.details', ['id' => $invoice->loadPlanner->id]) }}" target="_blank">{{ $invoice->loadPlanner->load_number }}</a>
                                </h4>

                                <div class="row">
                                    <div class="col-md-4 mb-7">
                                        @foreach($invoice->loadPlanner->destinations as $dest)
                                            @if($dest->type == 'pickup')
                                            <div class="card bg-light mb-7">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Pick Up:</h4>
                                                        <p><b>{{$dest->location->name}}</b></p>
                                                        <p><i class="fas fa-map-marker-alt text-danger"></i> {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}</p>
                                                        <p><i class="fas fa-calendar text-warning"></i> {{ date_format(new DateTime($dest->date), 'M-d-Y') }}</p>
                                                        <p><i class="fas fa-clock text-info"></i> {{ ($dest->time)? date_format(new DateTime($dest->time), 'h:i, a') : 'n/a' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($dest->type == 'consignee')
                                            <div class="card bg-light mb-7">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Delivery:</h4>

                                                        <p><b>{{$dest->location->name}}</b></p>
                                                        <p><i class="fas fa-map-marker-alt text-danger"></i> {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}</p>
                                                        <p><i class="fas fa-calendar text-warning"></i> {{ date_format(new DateTime($dest->date), 'M-d-Y')}}</p>
                                                        <p><i class="fas fa-clock text-info"></i> {{ ($dest->time)? date_format(new DateTime($dest->time), 'h:i, a') : 'n/a' }}</p>
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
                                                    $detention = $invoice->loadPlanner->fee->detention ?? 0;
                                                    $lumper = $invoice->loadPlanner->fee->lumper ?? 0;
                                                    $stopOff = ($invoice->loadPlanner->destinations->count() -1) * ($invoice->loadPlanner->fee->stop_off ?? 0);
                                                    $tarpFee = $invoice->loadPlanner->fee->tarp_fee ?? 0;
                                                    $accessorialAmount = $load->fee->accessorial_amount ?? 0;
                                                    $invoiceAdvance = $invoice->loadPlanner->fee->invoice_advance ?? 0;
                                                    
                                                    // $totalMiles = round($totalMiles / 1609.344, 2);

                                                    switch($invoice->loadPlanner->fee->fee_type){
                                                        case 'Flat Fee':
                                                            $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
                                                            $titleText = $invoice->loadPlanner->fee->fee_type;
                                                            break;
                                                        case 'Per Mile':
                                                            $primaryFee = $invoice->loadPlanner->fee->freight_amount * $totalMiles ?? 0;
                                                            $titleText = $invoice->loadPlanner->fee->fee_type.". Total miles: ".$totalMiles.", Fee/Mile: $".$invoice->loadPlanner->fee->freight_amount;
                                                            break;
                                                        case 'Per Hundred Weight (cwt)':
                                                            $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
                                                            $titleText = $invoice->loadPlanner->fee->fee_type;
                                                            break;
                                                        case 'Per Ton':
                                                            $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
                                                            $titleText = $invoice->loadPlanner->fee->fee_type;
                                                            break;
                                                        case 'Per Quantity':
                                                            $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
                                                            $titleText = $invoice->loadPlanner->fee->fee_type;
                                                            break;
                                                        default:
                                                            $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
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
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mx-auto form-group col-12 mt-3 mb-2">
                                        <button type="submit" class="btn btn-info" id="kt_invoice_submit_button">
                                            Update
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