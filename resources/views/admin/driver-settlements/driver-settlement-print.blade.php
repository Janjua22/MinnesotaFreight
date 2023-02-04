<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Driver Settlement</title>
    <style>
        @page { margin: 0px; }
        body{
            font-family: Arial, Helvetica, sans-serif;
            color: #363636;
            margin: 0px;
        }
        table{
            border-collapse: collapse;
        }
        table td{
            font-size: 11px;
        }
        .tbl-border td, .tbl-border th{
            border: 1px solid #79ae38 ;
            padding: 5px;
        }
        .w-100{ width: 100%; }
        .header{
            background-image: url("{{ asset('admin/assets/media/placeholders/ds.png') }}"); 
            background-position: center; 
            background-repeat: no-repeat; 
            background-size: cover; 
            height: 140px;
        }
        .company-logo{
            width: 300px; 
            margin-left: 20px;
            margin-top: 20px;
        }
        .text-right{
            text-align: right !important;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left !important;
        }
        .pt-1{
            padding-top: 50px !important;
        }
        .col{
            padding: 10px 25px;
        }
        .txt-sm{
            font-size: 9px !important;
        }
        .tbl-head{
            background-color: #79ae38; 
            color: #fff; 
            border: 1px solid #79ae38 !important;
        }
        .page-break{
            page-break-after: always;
        }
        .tbl-charges{
            width: 100%; 
            margin-top: 100px; 
        }
    </style>
</head>
<body style="margin:0; padding:0 15px;" onload="window.print();">
    @php 
        $paymentForTrip = 0;
        $grossPay = 0;
        $deductions = 0;
        $fuel = 0;
    @endphp

    <table class="w-100" style="margin:0px; padding:0px;">
        <tr>
            <td class="header">
                <img src="{{ asset(Storage::url(siteSetting('logo'))) }}" alt="{{ asset(Storage::url(siteSetting('title'))) }} logo" class="company-logo">
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100">
                    <tr>
                        <td>
                            <p><b>{{ siteSetting('title') }}</b></p>
                            <p>{{ siteSetting('email') }}</p>
                            <p>{{ Auth::user()->city->name.", ".Auth::user()->state->name }}</p>
                        </td>
                        <td class="text-right">
                            <h2 style="margin-top:0px !important;">{{$driverSettlement->driver->userDetails->first_name." ".$driverSettlement->driver->userDetails->last_name}}</h2>
                            <p>{{$driverSettlement->driver->userDetails->phone}}</p>
                            <p>{{$driverSettlement->driver->street}}</p>
                            <p>{{$driverSettlement->driver->city->name.", ".$driverSettlement->driver->state->name}}</p>
                            <h5>Serial No. {{ $driverSettlement->id }}</h5>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100 tbl-border">
                    <tr>
                        <th colspan="7" class="tbl-head text-left" style="padding:10px;">Earnings</th>
                    </tr>
                    <tr>
                        <th class="text-left">Invoice Number</th>
                        <th class="text-left">Truck Number</th>
                        <th class="text-left">Load Number</th>
                        <th class="text-left">Date</th>
                        <th class="text-left">Memo</th>
                        <th class="text-left">Freight Amount</th>
                        <th class="text-left">Payable Amount</th>
                    </tr>

                @foreach($loads as $load)
                    <tr>
                        <td>{{ $load->invoice->invoice_number }}</td>
                        <td>{{ $load->truck->truck_number }}</td>
                        <td>{{ $load->load_number }}</td>
                        <td>{{ date_format($driverSettlement->created_at, 'M d, Y') }}</td>
                        <td style="padding:0px; border:none;">
                            <table class="w-100">
                                @foreach($load->destinations as $i => $dest)
                                    <tr>
                                        <td>{{ ucfirst($dest->type) }}</td>
                                        <td>{{ date_format(new DateTime($dest->date), "M d, Y") }} - <b>{{$dest->location->name}}</b>, {{ $dest->location->city ? $dest->location->city->name : "" }}, {{ $dest->location->state ? $dest->location->state->name : "" }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>${{ number_format($load->fee->freight_amount, 2) }}</td>
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
                                        $paymentForTrip = round(($load->invoice->total_amount * $load->driver->pay_percent) / 100, 2);
                                        break;
                                    default:
                                        $paymentForTrip = 0;
                                        break;
                                }

                                $grossPay += $paymentForTrip;
                            ?>

                            ${{ number_format($paymentForTrip, 2) }} 
                            <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ ($load->driver->payment_type == 1)? 'Manual Pay' : (($load->driver->payment_type == 2)? 'Pay Per Mile' : 'Load Pay Percent' ) }}"></i>
                        </td>
                    </tr>
                @endforeach

                    <tr>
                        <th class="text-left" colspan="6">Total Earnings</th>
                        <th class="text-left">${{ number_format($grossPay, 2) }}</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100 tbl-border">
                    <tr>
                        <th colspan="4" class="tbl-head text-left" style="padding:10px;">Deductions</th>
                    </tr>
                    <tr>
                        <th class="text-left">Type</th>
                        <th class="text-left">Date</th>
                        <th class="text-left">Memo</th>
                        <th class="text-left">Amount</th>
                    </tr>
                @foreach($loads as $load)
                    @if($load->fee->driver_advance != null || $load->fee->driver_advance != 0)
                    <tr>
                        <td>Driver Advance</td>
                        <td>{{ date_format($driverSettlement->created_at, 'M d, Y') }}</td>
                        <td>
                            Load#: {{ $load->load_number }}
                        </td>
                        <td>${{ $load->fee->driver_advance }}</td>
                        @php $deductions += $load->fee->driver_advance; @endphp
                    </tr>
                    @endif

                    @foreach($trucksUsed as $truck)
                        @php
                            $fuelExpenseAmount = 0;

                            foreach ($truck->fuelExpenses as $expense){
                                if($expense->load_id == $load->id){
                                    $fuelExpenseAmount += $expense->amount;
                                }
                            }

                            $deductions += $fuelExpenseAmount;
                            $fuel += $fuelExpenseAmount;
                        @endphp

                        @if($fuelExpenseAmount)
                        <tr>
                            <td>Fuel Expenses</td>
                            <td>{{ Carbon\Carbon::now()->format('M-d-Y') }}</td>
                            <td>Load #{{ $load->load_number }}, Truck #{{ $truck->truck_number }}</td>
                            <td>${{ $fuelExpenseAmount }}</td>
                        </tr>
                        @endif
                    @endforeach
                @endforeach

                @if($driverSettlement->driver->auto_deduct)
                    @foreach($driverSettlement->driver->recurringDeductions as $recurring)
                    <tr>
                        <td>{{ $recurring->recurringDeduction->title }}</td>
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
                        <td>{{ ucfirst($addStl->category->name) }}</td>
                        <td>{{ date_format(new DateTime($addStl->date), "M d, Y") }}</td>
                        <td>{{ $addStl->note ?? 'N/A' }}</td>
                        <td>
                            ${{ $addStl->amount }}
                        </td>
                        @php $deductions += $addStl->amount; @endphp
                    </tr>
                @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100 tbl-border">
                    <tr>
                        <th colspan="4" class="tbl-head text-left" style="padding:10px;">Settlement</th>
                    </tr>
                    <tr>
                        <th class="text-left">Date Paid</th>
                        <th class="text-left">Gross Pay</th>
                        <th class="text-left">Deduction</th>
                        <th class="text-left">Amount</th>
                    </tr>
                    <tr>
                        <td>{{ date_format(new DateTime($driverSettlement->paid_date), 'M d, Y') }}</td>
                        <td>${{ $grossPay }}</td>
                        <td>${{ $deductions }}</td>
                        <td>${{ $total = $grossPay - $deductions }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @if($fuel)
    <div class="page-break"></div>

    <table class="w-100" style="margin:0px; padding:0px;">
        <tr>
            <td class="header">
                <img src="{{ asset(Storage::url(siteSetting('logo'))) }}" alt="{{ asset(Storage::url(siteSetting('title'))) }} logo" class="company-logo">
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100">
                    <tr>
                        <td>
                            <p><b>{{ siteSetting('title') }}</b></p>
                            <p>{{ siteSetting('email') }}</p>
                            <p>{{ Auth::user()->city->name.", ".Auth::user()->state->name }}</p>
                        </td>
                        <td class="text-right">
                            <h2 style="margin-top:0px !important;">{{$driverSettlement->driver->userDetails->first_name." ".$driverSettlement->driver->userDetails->last_name}}</h2>
                            <p>{{$driverSettlement->driver->userDetails->phone}}</p>
                            <p>{{$driverSettlement->driver->street}}</p>
                            <p>{{$driverSettlement->driver->city->name.", ".$driverSettlement->driver->state->name}}</p>
                            <h5>Serial No. {{ $driverSettlement->id }}</h5>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100">
                    <tr>
                        <td>
                            <h3>Expenses Details</h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100 tbl-border">
                    <tr>
                        <th colspan="6" class="tbl-head text-left" style="padding:10px;">Fuel Expenses</th>
                    </tr>
                    <tr>
                        <th class="text-left">Truck</th>
                        <th class="text-left">Date</th>
                        <th class="text-left">State Code</th>
                        <th class="text-left">Quantity</th>
                        <th class="text-left">Fuel Type</th>
                        <th class="text-left">Amount</th>
                    </tr>
                    @foreach($trucksUsed as $truck)
                        @foreach($truck->fuelExpenses as $expense)
                        <tr>
                            <td>{{ $truck->truck_number }}</td>
                            <td>{{ date_format(new DateTime($expense->date), "M d, Y") }}</td>
                            <td>{{ $expense->state_code }}</td>
                            <td>{{ $expense->volume." ".$expense->unit }}</td>
                            <td>{{ $expense->fuel_type }}</td>
                            <td>${{ $expense->amount }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                    <tr>
                        <th class="text-left" colspan="5">Total Fuel Expense</th>
                        <th class="text-left">${{ number_format($fuel, 2) }}</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @endif
</body>
</html>