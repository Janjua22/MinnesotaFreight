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
                @if($driverSettlement->is_deleted)
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Warning!</h4>
                    <p>This settlement has been deleted and no action can be performed on it. However you can restore this record from the trash and perform available actions.</p>
                    <hr>
                    <small class="mb-0 fst-italic">You can only view details of the deleted settlement on this page.</small>
                </div>
                @endif

                <div class="card">
                    <div class="card-body p-12">
                        <div class="d-flex flex-column justify-content-between flex-xxl-row">
                            <div class="d-flex flex-center fw-row text-nowrap me-4">
                                <span class="fs-2x fw-bolder text-gray-800">Driver Settlements</span>
                            </div>

                            @if(!$driverSettlement->is_deleted)
                            <a href="{{ route('admin.driverSettlement.print', ['id' => $driverSettlement->id]) }}" class="btn btn-sm btn-success pt-3" target="_blank"><i class="bi bi-printer"></i> Print</a>
                            @endif
                            
                            {{-- @if(!$driverSettlement->is_deleted)
								<a href="{{ route('admin.driverSettlement.mail', ['id' => $driverSettlement->id]) }}" class="btn btn-sm btn-success" target="_blank" ><i class="bi bi-envelope"></i> Send Mail</a>
                            @endif --}}
							dd
                        </div>

                        <div class="row mt-5">
                            <div class="col-6">
                                <img src="{{ asset(Storage::url(sitesetting('logo'))) }}" alt="Company Logo" style="width: 350px;">
                                <h2 class="mt-2">{{ siteSetting('title') }}</h2>
                                <p>{{ siteSetting('email') }}</p>
                                <p>{{ siteSetting('contact') }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <h2 class="mt-9">{{ $driverSettlement->driver->userDetails->first_name." ".$driverSettlement->driver->userDetails->last_name }}</h2>
                                <p>{{ $driverSettlement->driver->userDetails->address ? $driverSettlement->driver->userDetails->address : 'Address not available' }}</p>
                                <p>{{ $driverSettlement->driver->userDetails->email }}</p>
                                <p>{{ $driverSettlement->driver->userDetails->phone }}</p>
                                <h5>Serial No. {{ $driverSettlement->id }}</h5>
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
                                                <th >Memo</th>
                                                <th class="min50px" style="min-width: 150px;">Freight Amount</th>
                                                <th class="min-w-150px pe-3">Payable Amount</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                    @foreach($loads as $load)
                                        <tr>
                                            <td class="ps-4">
                                                @if($load->invoice)
                                                <a href="{{ route('admin.invoice.details', ['id' => $load->invoice->id]) }}" target="_blank">{{ $load->invoice->invoice_number }}</a>
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                            <td>{{ $load->truck->truck_number }}</td>
                                            <td>
                                                <a href="{{ route('admin.loadPlanner.details', ['id' => $load->id]) }}" target="_blank">{{ $load->load_number }}</a>
                                            </td>
                                            <td>{{ date_format($driverSettlement->created_at, 'M d, Y') }}</td>
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

                                                    switch ($load->driver->payment_type) {
                                                        case 1:
                                                            $paymentForTrip = $load->driver->manual_pay;
                                                            break;
                                                        case 2:
                                                            $offLoadMiles = 0;
                                                            $onLoadMiles = 0;

                                                            if($load->driver->off_mile_fee){
                                                                if($load->driver->off_mile_range){
                                                                    if($offLoadMiles > $load->driver->off_mile_range){
                                                                        $offLoadMiles = $offLoadMiles - $load->driver->off_mile_range;
                                                                        $paymentForTrip += $offLoadMiles * $load->driver->off_mile_fee;
                                                                    }
                                                                } else{
                                                                    $paymentForTrip += $offLoadMiles * $load->driver->off_mile_fee;
                                                                }
                                                            }

                                                            $paymentForTrip += $onLoadMiles * $load->driver->on_mile_fee;
                                                            break;
                                                        case 3:
                                                            $paymentForTrip = $load->invoice ? round(($load->invoice->total_amount * $load->driver->pay_percent) / 100, 2) : 0;
                                                            break;
                                                        default:
                                                            $paymentForTrip = 0;
                                                            break;
                                                    }

                                                    $grossPay += $paymentForTrip;
                                                ?>

                                                ${{ number_format($paymentForTrip) }} 
                                                <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ ($load->driver->payment_type == 1)? 'Manual Pay' : (($load->driver->payment_type == 2)? 'Pay Per Mile' : 'Load Pay Percent' ) }}"></i>
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
                                </div>
                            </div>
                            <hr>
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
                                            <td>{{ date_format($driverSettlement->created_at, 'M d, Y') }}</td>
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

                                    @if($driverSettlement->driver->auto_deduct)
                                        @foreach($driverSettlement->driver->recurringDeductions as $recurring)
                                        <tr>
                                            <td class="ps-4">{{ $recurring->recurringDeduction->title }}</td>
                                            <td>{{ date_format(now(), 'M '.$driverSettlement->driver->deduction_date.', Y') }}</td>
                                            <td>Automatic recurring deduction</td>
                                            <td>${{ $recurring->recurringDeduction->amount }}</td>
                                        </tr>
                                        @php
                                            $deductions += $recurring->recurringDeduction->amount;
                                        @endphp
                                        @endforeach
                                    @endif

                                    @foreach($driverSettlement->additionalSettlements as $addStl)
                                        <tr>
                                            <td class="ps-4">{{ ucfirst($addStl->category->name) }}</td>
                                            <td>{{ date_format(new DateTime($addStl->date), "M d, Y") }}</td>
                                            <td>{{ $addStl->note ?? 'N/A' }}</td>
                                            <td>
                                                ${{ $addStl->amount }}
                                            </td>
                                            @php $deductions += $addStl->amount; @endphp
                                        </tr>
                                    @endforeach
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
                                            <td class="ps-4">{{ date_format(new DateTime($driverSettlement->paid_date), 'M d, Y') }}</td>
                                            <td>${{ $grossPay }}</td>
                                            <td>$<span id="dedAmt">{{ $deductions }}</span></td>
                                            <td>$<span id="ttAmt">{{ $total = $grossPay - $deductions }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                        <span class="svg-icon svg-icon-1">{!! getSvg('arr061') !!}</span>
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
    var expenseDatatable;

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

        expenseDatatable = $('#expenses_table').dataTable({
            ordering: false,
            searching: false,
            lengthChange: false
        });

        $('#expenseDetailTotal').html('$'+$('#dedAmtSub').html());

        $('#fuelExpensesModal').modal('show');
    }

    $('#fuelExpensesModal').on('hidden.bs.modal', function(event){
        expenseDatatable.destroy();
        expenseDatatable = null;
    });
</script>
@stop