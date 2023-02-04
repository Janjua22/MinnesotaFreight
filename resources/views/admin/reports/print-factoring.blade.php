<!DOCTYPE html>
<html lang="en">

@php 
    $path = (config('app.env') == "production")? storage_path()."/app/public/" : public_path()."/storage/";
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Factoring Fee</title>
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
            font-size: 12px;
        }
        .tbl-border td, .tbl-border th{
            border: 1px solid #aa0724;
            padding: 5px;
        }
        .w-100{ width: 100%; }
        .header{
            background-image: url("{{ $path.'/img/pdf-headers/fr.png' }}"); 
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
            font-size: 9px !important;
        }
        .tbl-head{
            background-color: #aa0724; 
            color: #fff; 
            border: 1px solid #aa0724 !important;
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
<body style="margin:0; padding:0;">
    <table class="w-100" style="margin:0px; padding:0px;">
        <tr>
            <td class="header">
                <img src="{{ $path.siteSetting('logo') }}" alt="{{ siteSetting('title') }} logo" class="company-logo">
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100 tbl-border">
                    <tr>
                        <th colspan="9" class="tbl-head text-left" style="padding:10px;">
                            Factoring Fee Report From {{ $totalReports['date_from'] }} to {{ $totalReports['date_to'] }}
                        </th>
                    </tr>
                    <tr>
                        <th class="text-left">Truck Number</th>
                        <th class="text-left">Invoice Number</th>
                        <th class="text-left">Load Number</th>
                        <th class="text-left">Customer</th>
                        <th class="text-left">Total Amount</th>
                        <th class="text-left">Factoring Fee</th>
                        <th class="text-left">Invoice Date</th>
                        <th class="text-left">Paid Date</th>
                        <th class="text-left">Invoice Status</th>
                    </tr>

                    @foreach($totalReports['factoring_fees'] as $report)
                    <tr>
                        <td>{{ $report['truck_number'] }}</td>
                        <td>{{ $report['invoice_number'] }}</td>
                        <td>{{ $report['load_number'] }}</td>
                        <td>{{ $report['name'] }}</td>
                        <td>${{ $report['total_amount'] }}</td>
                        <td>${{ $report['factoring_fee'] }} ({{ $report['factoring_percentage'] }}%)</td>
                        <td>{{ $report['date'] }}</td>
                        <td>{{ $report['paid_date'] }}</td>
                        <td>
                            @if($report['status'] == 0)
                            <span class="text-danger">CANCELED</span>
                            @endif
                            @if($report['status'] == 1)
                            <span class="text-success">PAID</span>
                            @endif
                            @if($report['status'] == 2)
                            <span class="text-warning">OPEN</span>
                            @endif
                            @if($report['status'] == 3)
                            <span class="text-info">UNPAID</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    <tr>
                        <th class="text-left" colspan="8">Total Amount of Invoices</th>
                        <th>${{ $totalReports['total_amount'] }}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="8">Total Factoring Fee</th>
                        <th>${{ $totalReports['total_factoring'] }}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="8">Factoring Fee Paid</th>
                        <th>${{ $totalReports['factoring_paid'] }}</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>