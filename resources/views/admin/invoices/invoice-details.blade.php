<!DOCTYPE html>
<html lang="en">

@php
    $path = (config('app.env') == "production")? storage_path()."/app/public/" : public_path()."/storage/";
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
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
            font-size: 14px;
        }
        .tbl-border td, .tbl-border th{
            border: 1px solid #79ae38;
            padding: 5px;
        }
        .w-100{ width: 100%; }
        .header{
            background-image: url("{{ $path.'/img/pdf-headers/in.png' }}"); 
            background-position: center; 
            background-repeat: no-repeat; 
            background-size: cover; 
            height: 140px;
        }
        .company-logo{
            width: 155px; 
            margin-left: 50px;
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
            font-size: 11px;
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
<body style="margin:0; padding:0;" onload="window.print();">
    @php
        $primaryFee = 0;
        $totalMiles = 0;
        $factoringFee = 0;
        $titleText = $invoice->loadPlanner->fee->fee_type;
        $detention = $invoice->loadPlanner->fee->detention ?? 0;
        $lumper = $invoice->loadPlanner->fee->lumper ?? 0;
        $stopOff = ($invoice->loadPlanner->destinations->count() -1) * ($invoice->loadPlanner->fee->stop_off ?? 0);
        $tarpFee = $invoice->loadPlanner->fee->tarp_fee ?? 0;
        $accessorialAmount = $invoice->loadPlanner->fee->accessorial_amount ?? 0;
        $invoiceAdvance = $invoice->loadPlanner->fee->invoice_advance ?? 0;

        switch($invoice->loadPlanner->fee->fee_type){
            case 'Flat Fee':
                $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
                break;
            case 'Per Mile':
                $primaryFee = $invoice->loadPlanner->fee->freight_amount * $totalMiles ?? 0;
                break;
            case 'Per Hundred Weight (cwt)':
                $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
                break;
            case 'Per Ton':
                $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
                break;
            case 'Per Quantity':
                $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
                break;
            default:
                $primaryFee = $invoice->loadPlanner->fee->freight_amount ?? 0;
                $titleText = 'Primary Fee';
                break;
        }

        if($invoice->include_factoring){
            $factoringFee = ($primaryFee * siteSetting('factoring')) / 100;
        }
        
        $grandTotal = $invoice->include_factoring ? $invoice->total_w_factoring : $invoice->total_balance;

        $bolExt = pathinfo($invoice->loadPlanner->file_bol, PATHINFO_EXTENSION);
        $rcExt = pathinfo($invoice->loadPlanner->file_rate_confirm, PATHINFO_EXTENSION);
        $accExt = pathinfo($invoice->loadPlanner->fee->file_accessorial_invoice, PATHINFO_EXTENSION);
    @endphp

    <table class="w-100" style="margin:0px; padding:0px;">
        <tr>
            <td class="header">
                <img src="{{ $path.siteSetting('logo') }}" alt="{{ siteSetting('title') }} logo" class="company-logo">
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100">
                    <tr>
                        <td>
                            <h2><b>Invoice#: </b>{{ $invoice->invoice_number }}</h2>
                            <p><b>Date: </b>{{ date_format(new DateTime($invoice->date), 'M d, Y') }}</p>
                            <p><b>Due Date: </b>{{ date_format(new DateTime($invoice->due_date), 'M d, Y') }}</p>
                            <p><b>Paid Date: </b>{{ $invoice->paid_date ? date_format(new DateTime($invoice->paid_date), 'M d, Y') : 'n/a' }}</p>
                        </td>
                        <td class="text-right">
                            <p><b>Forward to: </b>{{ $invoice->factoring->name }}</p>
                            <p><b>Customer: </b>{{ $invoice->customer->name }}</p>
                            @if($invoice->status == 1)
                            <img src="{{ $path.'img/paid-watermark.png' }}" alt="badge" style="width: 100px;">
                            @else
                            <img src="{{ $path.'img/unpaid-watermark.png' }}" alt="badge" style="width: 100px;">
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100 tbl-border">
                    <tr>
                        <th colspan="6" class="tbl-head text-left" style="padding:10px;">
                            <b>Load Details:</b> {{ $invoice->loadPlanner->load_number }}
                        </th>
                    </tr>
                    <tr>
                        <th class="text-left">Location</th>
                        <th class="text-left">City</th>
                        <th class="text-left">State</th>
                        <th class="text-left">Type</th>
                        <th class="text-left">Date</th>
                        <th class="text-left">Time</th>
                    </tr>
                    @foreach($invoice->loadPlanner->destinations as $dest)
                    <tr>
                        <td class="txt-sm">{{ $dest->location->name }}</td>
                        <td class="txt-sm">{{ $dest->location->city ? $dest->location->city->name : "N/A" }}</td>
                        <td class="txt-sm">{{ $dest->location->state ? $dest->location->state->name : "N/A" }}</td>
                        <td class="txt-sm">{{ ($dest->stop_number == 1)? 'Pickup' : 'Consignee' }}</td>
                        <td class="txt-sm">{{ date_format(new DateTime($dest->date), "M d, Y") }}</td>
                        <td class="txt-sm">{{ date_format(new DateTime($dest->time), "h:i a") }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100 tbl-border">
                    <tr>
                        <th class="text-left tbl-head" colspan="2" style="padding:10px;">Charges</th>
                    </tr>
                    <tr>
                        <th class="text-left">Primary Fee <i style="font-size:11px;">({{ $titleText }})</i></th>
                        <td>${{ ($primaryFee)? number_format($primaryFee, 2) : '00.00' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Detention Fee</th>
                        <td>${{ $detention ?? '00.00' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Lumper Fee</th>
                        <td>${{ $lumper ?? '00.00' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Stop Off Fee</th>
                        <td>${{ $stopOff ?? '00.00' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Tarp Fee</th>
                        <td>${{ $tarpFee ?? '00.00' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Accessorial Amount</th>
                        <td>${{ $accessorialAmount ?? '00.00' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Factoring Fee</th>
                        <td style="color:red;">-${{ round($factoringFee, 2) ?? '00.00' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Invoice Advance</th>
                        <td style="color:red;">-${{ $invoiceAdvance ?? '00.00' }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Total</th>
                        <th class="text-left">${{ number_format($grandTotal, 2) }}</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @if($bolExt == 'jpg' || $bolExt == 'jpeg' || $bolExt == 'png')
    <div class="page-break"></div>

    <div class="w-100" style="padding:20px;">
        <h3>Bill of Lading (BL):</h3>
        <img src="{{ $path.$invoice->loadPlanner->file_bol }}" alt="Bill of lading" class="w-100">
    </div>
    @endif
    
    @if($rcExt == 'jpg' || $rcExt == 'jpeg' || $rcExt == 'png')
    <div class="page-break"></div>
    
    <div class="w-100" style="padding:20px;">
        <h3>Rate Confirmation:</h3>
        <img src="{{ $path.$invoice->loadPlanner->file_rate_confirm }}" alt="rate confirmation" class="w-100">
    </div>
    @endif

    @if($accExt == 'jpg' || $accExt == 'jpeg' || $accExt == 'png')
    <div class="page-break"></div>
    
    <div class="w-100" style="padding:20px;">
        <h3>Accessorial Charges: ${{ $invoice->loadPlanner->fee->accessorial_amount }}</h3>
        <img src="{{ $path.$invoice->loadPlanner->fee->file_accessorial_invoice }}" alt="accessorial charges" class="w-100">
    </div>
    @endif
</body>
</html>