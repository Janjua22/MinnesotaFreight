@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Driver Settlement",
        'sub-title' => "Add",
        'btn' => "Driver Settlements List",
        'url' => route('admin.driverSettlement')
    ];
    $grossPay = 0;
    $deductions = 0;
    $total = 0;
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <div class="card mb-10">
                    <div class="card-body p-12">
                        <form action="{{ route('admin.driverSettlement.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="driver_id" value="{{ $driver->user_id }}">
                            <input type="hidden" name="total_trips" value="{{ $loads->count() }}">

                            <div class="d-flex flex-column justify-content-between flex-xxl-row">
                                <div class="d-flex flex-center fw-row text-nowrap me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Driver Settlements</span>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-6">
                                    <img src="{{ asset(Storage::url(sitesetting('logo'))) }}" alt="Company Logo" style="width: 350px;">
                                    <h2 class="mt-2">{{ siteSetting('title') }}</h2>
                                    <p>{{ siteSetting('email') }}</p>
                                    <p>{{ siteSetting('contact') }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <h2 class="mt-9">{{ $driver->userDetails->first_name." ".$driver->userDetails->last_name }}</h2>
                                    <p>{{ $driver->userDetails->address ? $driver->userDetails->address : 'Address not available' }}</p>
                                    <p>{{ $driver->userDetails->email }}</p>
                                    <p>{{ $driver->userDetails->phone }}</p>
                                </div>
                            </div>

                            <div class="my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-0 fs-2">Earnings</h4>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table midrstbl table-hover align-middle fs-6 gy-5">
                                        <thead>
                                            <tr class="text-start bg-dark text-white fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-80px ps-3">Invoice#</th>
                                                <th>Truck#</th>
                                                <th style="min-width: 140px;">Load#</th>
                                                <th class="min-w-125px">Date</th>
                                                <th>Memo</th>
                                                <th class="min50px" style="min-width: 150px;">Freight Amount</th>
                                                <th class="min-w-150px pe-3">Payable Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($loads as $load)
                                            <tr>
                                                <td class="ps-4">
                                                    <a href="{{ route('admin.invoice.details', ['id' => $load->invoice->id]) }}" target="_blank">{{ $load->invoice->invoice_number }}</a>
                                                </td>
                                                <td>{{ $load->truck->truck_number }}</td>
                                                <td>
                                                    <input type="hidden" name="loads[]" value="{{ $load->id }}">
                                                    <a href="{{ route('admin.loadPlanner.details', ['id' => $load->id]) }}" target="_blank">{{ $load->load_number }}</a>
                                                </td>
                                                <td>{{ Carbon\Carbon::now()->format('M d, Y') }}</td>
                                                <td>
                                                @foreach($load->destinations as $i => $dest)
                                                    <span class="badge badge-{{ ($dest->type == 'pickup')? 'info' : 'success' }} me-2">{{ ucfirst($dest->type) }}</span>
                                                    <small>
                                                        <i class="fas fa-calendar text-warning" style="font-size:16px;"></i> {{ date_format(new DateTime($dest->date), "M d, Y") }} 
                                                        <i class="fas fa-map-marker-alt text-danger ms-2" style="font-size:16px;"></i> 
                                                        <b>{{$dest->location->name}}</b>, {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}
                                                    </small>

                                                    @if($load->destinations->count() > $i+1)
                                                        <div class="separator separator-dashed my-3"></div>
                                                    @endif
                                                @endforeach
                                                </td>
                                                <td>
                                                    ${{ $load->fee->freight_amount }} 
                                                    <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $load->fee->fee_type }}"></i>
                                                </td>
                                                <td>
                                                <?php
                                                    $paymentForTrip = 0;

                                                    switch ($driver->payment_type) {
                                                        // calculation for manual pay...
                                                        case 1:
                                                            $paymentForTrip = $driver->manual_pay;
                                                            break;
                                                        // calculation for pay per mile...
                                                        case 2:
                                                            $offLoadMiles = 0;
                                                            $onLoadMiles = 0;


                                                            // foreach($load->distanceCalculations as $offMiles){
                                                            //     $offLoadMiles += round($offMiles->distance /1609.344, 2);
                                                            // }

                                                            // foreach($load->stateCalculation as $onMiles){
                                                            //     $onLoadMiles += round($onMiles->distance /1609.344, 2);
                                                            // }

                                                            if($driver->off_mile_fee){
                                                                if($driver->off_mile_range){
                                                                    if($offLoadMiles > $driver->off_mile_range){
                                                                        $offLoadMiles = $offLoadMiles - $driver->off_mile_range;
                                                                        $paymentForTrip += $offLoadMiles * $driver->off_mile_fee;
                                                                    }
                                                                } else{
                                                                    $paymentForTrip += $offLoadMiles * $driver->off_mile_fee;
                                                                }
                                                            }

                                                            $paymentForTrip += $onLoadMiles * $driver->on_mile_fee;
                                                            break;
                                                        // calculation for load pay percent...
                                                        case 3:
                                                            $paymentForTrip = round(($load->invoice->total_amount * $driver->pay_percent) / 100, 2);
                                                            break;
                                                        default:
                                                            $paymentForTrip = 0;
                                                            break;
                                                    }

                                                    $grossPay += $paymentForTrip;
                                                ?>
                                                    ${{ number_format($paymentForTrip) }} 
                                                    <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ ($driver->payment_type == 1)? 'Manual Pay' : (($driver->payment_type == 2)? 'Pay Per Mile' : 'Load Pay Percent' ) }}"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                                <th class="ps-3" colspan="6">Total Earnings</th>
                                                <th class="text-end pe-3">${{ number_format($grossPay, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-between"> 
                                        <h4 class="form-section mb-0 fs-2">Deductions</h4>
                                        <button type="button" class="btn mt-n6 btn-success text-right" data-bs-toggle="modal" data-bs-target="#addDeductionModal">
                                            <i class="fas fa-plus"></i> New Deduction
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                {{-- <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="auto_deduct" type="checkbox" role="switch" id="autoDed" value="1" style="border-radius:1rem;">
                                            <label class="form-check-label" for="autoDed">Include recurring deductions</label>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="table-responsive"> 
                                    <table class="table midrstbl table-hover align-middle fs-6 gy-5" id="tblDeductions">
                                        <thead>
                                            <tr class="text-start bg-dark text-white fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="ps-3">Type</th>
                                                <th>Date</th>
                                                <th>Memo</th>
                                                <th class="pe-3">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($loads as $load)
                                            @if($load->fee->driver_advance != null || $load->fee->driver_advance != 0)
                                            <tr>
                                                <td class="ps-4">Driver Advance</td>
                                                <td>{{ Carbon\Carbon::now()->format('M-d-Y') }}</td>
                                                <td>
                                                    Load#: <a href="{{ route('admin.loadPlanner.details', ['id' => $load->id]) }}" target="_blank">{{ $load->load_number }}</a>
                                                    <br>
                                                    <small>
                                                    @foreach($load->destinations as $i => $dest)
                                                        <i class="fas fa-map-marker-alt text-danger" style="font-size:16px;"></i> <b>{{$dest->location->name}}</b>, {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}
                                                        @if($load->destinations->count() > $i+1)
                                                            <i class="fas fa-arrow-right mx-3 text-success" style="font-size:16px;"></i>
                                                        @endif
                                                    @endforeach
                                                    </small>
                                                </td>
                                                <td>${{ $load->fee->driver_advance }}</td>
                                                @php $deductions += $load->fee->driver_advance; @endphp
                                            </tr>
                                            @endif

                                            {{-- @foreach($load->fuelExpenses as $fuel)
                                                @if($fuel->include_on_driver == 1)
                                                <tr>
                                                    <td>{{ ucfirst($fuel->type) }} Expenses</td>
                                                    <td>{{ Carbon\Carbon::now()->format('M-d-Y') }}</td>
                                                    <td>
                                                        Trip#: <a href="{{ route('admin.trip.view', ['id' => $load->id]) }}" target="_blank">{{ $load->trip_number }}</a>
                                                        <br>
                                                        <small>
                                                        @foreach($load->destinations as $i => $dest)
                                                            <i class="fas fa-map-marker-alt text-danger" style="font-size:16px;"></i> <b>{{$dest->location->name}}</b>, {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}
                                                            @if($load->destinations->count() > $i+1)
                                                                <i class="fas fa-arrow-right mx-3 text-success" style="font-size:16px;"></i>
                                                            @endif
                                                        @endforeach
                                                        </small>
                                                    </td>
                                                    <td>${{ $fuel->deduction_amount }}</td>
                                                    @php $deductions += $fuel->deduction_amount; @endphp
                                                </tr>
                                                @endif
                                            @endforeach

                                            @foreach($load->truckExpenses as $truck)
                                                @if($truck->include_on_driver == 1)
                                                <tr>
                                                    <td>{{ ($truck->truck->type_id == 1)? 'Truck' : 'Trailer' }} Expenses</td>
                                                    <td>{{ Carbon\Carbon::now()->format('M-d-Y') }}</td>
                                                    <td>
                                                        Trip#: <a href="{{ route('admin.trip.view', ['id' => $load->id]) }}" target="_blank">{{ $load->trip_number }}</a>
                                                        <br>
                                                        <small>
                                                        @foreach($load->destinations as $i => $dest)
                                                            <i class="fas fa-map-marker-alt text-danger" style="font-size:16px;"></i> <b>{{$dest->location->name}}</b>, {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}
                                                            @if($load->destinations->count() > $i+1)
                                                                <i class="fas fa-arrow-right mx-3 text-success" style="font-size:16px;"></i>
                                                            @endif
                                                        @endforeach
                                                        </small>
                                                    </td>
                                                    <td>${{ $truck->deduction_amount }}</td>
                                                    @php $deductions += $truck->deduction_amount; @endphp
                                                </tr>
                                                @endif
                                            @endforeach --}}

                                            @foreach($trucksUsed as $truck)
                                                @php
                                                    $obj = array();
                                                    $fuelExpenseAmount = 0;

                                                    foreach ($truck->fuelExpenses as $expense){
                                                        if($expense->load_id == $load->id){
                                                            array_push($obj, [
                                                                'truck_number' => $truck->truck_number,
                                                                'date' => date_format(new DateTime($expense->date), "M d, Y"),
                                                                'state_code' => $expense->state_code,
                                                                'unit' => $expense->unit,
                                                                'volume' => $expense->volume,
                                                                'fuel_type' => $expense->fuel_type,
                                                                'amount' => $expense->amount
                                                            ]);
        
                                                            $fuelExpenseAmount += $expense->amount;
                                                        }
                                                    }
                                                    
                                                    $deductions += $fuelExpenseAmount;
                                                @endphp
                                                
                                                @if($fuelExpenseAmount)
                                                <tr>
                                                    <td class="ps-4">Fuel Expenses</td>
                                                    <td>{{ Carbon\Carbon::now()->format('M-d-Y') }}</td>
                                                    <td>
                                                        Load #{{ $load->load_number }}, 
                                                        Truck #{{ $truck->truck_number }}
                                                        <button type="button" class="btn btn-sm btn-outline-info ms-3" onclick="showExpenseModal({{ json_encode($obj) }});">View Expenses</button>
                                                    </td>
                                                    <td>${{ $fuelExpenseAmount }}</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                        @if($driver->auto_deduct)
                                            @foreach($driver->recurringDeductions as $recurring)
                                            <tr>
                                                <td class="ps-4">{{ $recurring->recurringDeduction->title }}</td>
                                                <td>{{ date_format(now(), 'M '.$driver->deduction_date.', Y') }}</td>
                                                <td>Automatic recurring deduction</td>
                                                <td>${{ $recurring->recurringDeduction->amount }}</td>
                                            </tr>
                                            @php
                                                $deductions += $recurring->recurringDeduction->amount;
                                            @endphp
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                                <th class="ps-3" colspan="3">Total Deductions</th>
                                                <th class="text-end pe-3">$<span id="dedAmtSub">{{ number_format($deductions, 2) }}</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <h4 class="form-section mb-8 fs-2">Settlement</h4>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table midrstbl table-hover align-middle fs-6 gy-5">
                                        <thead>
                                            <tr class="text-start bg-dark text-white fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="ps-3">Date Paid</th>
                                                <th>Gross Pay</th>
                                                <th>Deduction</th>
                                                <th class="pe-3">Net Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-4">{{ Carbon\Carbon::now()->format('M-d-Y') }}</td>
                                                <td>${{ $grossPay }}</td>
                                                <td>$<span id="dedAmt">{{ $deductions }}</span></td>
                                                <td>$<span id="ttAmt">{{ $total = $grossPay - $deductions }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-3 mx-auto">
                                    <input type="hidden" name="gross_amount" value="{{ $grossPay }}">
                                    <input type="hidden" name="deduction_amount" value="{{ $deductions }}">
                                    <input type="hidden" name="paid_amount" value="{{ $total }}">

                                    <button type="submit" class="btn btn-success mx-auto">
                                        Generate Settlement
                                        <span class="svg-icon svg-icon-3">{!! getSvg('gen016') !!}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Deduction Modal -->
    <div class="modal fade" id="addDeductionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Create
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">New Deduction</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="" method="POST" class="form" id="ddForm">
                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Deduction Category <sup class="text-danger">*</sup></label>
                                    <select id="dCategory" class="form-control form-select form-select-solid @error('category_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Deduction Category" required>
                                        <option value="">Select Deduction Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Deducting Amount <sup class="text-danger">*</sup></label>
                                    <input type="number" id="dAmount" class="form-control form-control-solid" placeholder="Deducting Amount..." min="0" step=".01" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Note <sup class="text-danger">*</sup></label>
                                    <textarea id="dNote" class="form-control form-control-solid" rows="3" placeholder="Deduction details..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>

                            <button type="button" class="btn btn-success" data-kt-modules-modal-action="submit" onclick="addDeduction();">
                                <span class="indicator-label">Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Deduction Category Modal -->
    <div class="modal fade" id="addDeductionCategory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Create
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Deduction Category</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="{{ route('admin.deductionCategory.create') }}" method="POST" onsubmit="return submitDeductionCategory(this);">
                        @csrf

                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Name <sup class="text-danger">*</sup></label>
                                    <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="Category Name..." required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control form-control-solid @error('description') is-invalid border-danger @enderror" rows="5" placeholder="Any details here..." maxlength="255"></textarea>
                                </div>
                            </div>
                        </div>
    
                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
    
                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Fuel Expenses Detail Modal -->
    <div class="modal fade" id="fuelExpensesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder fs-2">
                        <span id="expenseDetailTotal">List</span>
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Fuel Expenses Detail</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="expenses_table">
                        <thead>
                            <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Truck</th>
                                <th class="min-w-125px">Date</th>
                                <th class="min-w-125px">State Code</th>
                                <th class="min-w-125px">Quantity</th>
                                <th class="min-w-125px">Fuel Type</th>
                                <th class="min-w-125px">Amount</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var expenseTable;

    let addDeduction = ()=>{
        let category = $('#dCategory option:selected');
        let amount = parseFloat($('#dAmount').val());
        let note = $('#dNote').val();
        let totalDeductions = parseFloat($('#dedAmt').html());
        let totalPayable = parseFloat($('#ttAmt').html());

        if(category.val() == ''){
            toastr["error"]("Define deduction category");
        } else if(!amount){
            toastr["error"]("Please insert deduction amount");
        } else{
            $("#tblDeductions tbody").append(`<tr>
                <td class="ps-4">
                    ${category.text()}
                    <input type="hidden" name="category_id[]" value="${category.val()}">
                </td>
                <td>{{ Carbon\Carbon::now()->format('M-d-Y') }}</td>
                <td>
                    ${(note == '')? 'n/a' : note}
                    <input type="hidden" name="note[]" value="${note}">
                </td>
                <td>
                    $${amount} 
                    <i class="fas fa-times-circle text-danger cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="right" title="remove" onclick="removeDeduction(this, ${amount});"></i>
                    <input type="hidden" name="amount[]" value="${amount}">
                </td>
            </tr>`);

            totalDeductions = totalDeductions + amount;
            totalPayable = totalPayable - amount;

            $('#dedAmt').html(totalDeductions.toFixed(2));
            $('#dedAmtSub').html(totalDeductions.toFixed(2));
            $('#ttAmt').html(totalPayable.toFixed(2));

            $('input[name=deduction_amount]').val(totalDeductions.toFixed(2));
            $('input[name=paid_amount]').val(totalPayable.toFixed(2));

            $('#ddForm').trigger('reset');

            $('#addDeductionModal').modal('hide');

            toastr["success"]("Deduction added!");
        }
    }

    let removeDeduction = (elem, amount)=>{
        let totalDeductions = parseFloat($('#dedAmt').html());
        let totalPayable = parseFloat($('#ttAmt').html());
        let row = $(elem).parent().parent();

        totalDeductions = totalDeductions - amount;
        totalPayable = totalPayable + amount;

        $('#dedAmt').html(totalDeductions.toFixed(2));
        $('#dedAmtSub').html(totalDeductions.toFixed(2));
        $('#ttAmt').html(totalPayable.toFixed(2));

        $('input[name=deduction_amount]').val(totalDeductions.toFixed(2));
        $('input[name=paid_amount]').val(totalPayable.toFixed(2));

        row.remove();
    }

    let submitDeductionCategory = form => {
        $(form).find('.indicator-label').html(`<i class="fas fa-spinner fa-pulse"></i>`);

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(),
            success: (res)=>{
                $(`#dCategory`).append(`<option value="${res.id}" selected>${res.name}</option>`);

                form.reset();
            },
            error: (err)=>{
                console.error(err);
            },
            complete: ()=>{
                $(form).find('.indicator-label').html(`<i class="fas fa-spinner fa-pulse"></i>`);
                $("#addDeductionCategory").modal("hide");
            }
        });

        return false;
    }

    let showExpenseModal = data => {
        let tableBody = "";

        data.map(function(row){
            tableBody += `<tr>
                <td>${ row.truck_number }</td>
                <td>${ row.date }</td>
                <td>${ row.state_code }</td>
                <td>${ row.volume } ${ row.unit }</td>
                <td>${ row.fuel_type }</td>
                <td>$${ row.amount }</td>
            </tr>`;
        });

        $('#expenses_table tbody').html(tableBody);

        expenseTable = $('#expenses_table').DataTable({
            ordering: false,
            searching: false,
            lengthChange: false
        });

        $('#expenseDetailTotal').html('$'+$('#dedAmtSub').html());

        $('#fuelExpensesModal').modal('show');
    }

    $('#fuelExpensesModal').on('hide.bs.modal', ()=>{
        expenseTable.destroy();
        expenseDatatable = null;
    });
</script>
@stop