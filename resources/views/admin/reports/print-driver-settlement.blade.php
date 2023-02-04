<!DOCTYPE html>
<html lang="en">

@php 
    $path = (config('app.env') == "production")? storage_path()."/app/public/" : public_path()."/storage/";
@endphp

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
            font-size: 14px;
        }
        .tbl-border td, .tbl-border th{
            border: 1px solid #aa0724 ;
            padding: 5px;
        }
        .w-100{ width: 100%; }
        .header{
            background-image: url("{{ $path.'/img/pdf-headers/ds.png' }}"); 
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
                <table class="w-100">
                    <tr>
                        <td>
                            <p><b>{{ siteSetting('title') }}</b></p>
                            <p>{{ siteSetting('email') }}</p>
                            <p>{{ Auth::user()->city->name.", ".Auth::user()->state->name }}</p>
                        </td>
                        <td class="text-right">
                            <h2 style="margin-top:0px !important;">{{$driver->userDetails->first_name." ".$driver->userDetails->last_name}}</h2>
                            <p>{{$driver->userDetails->phone}}</p>
                            <p>{{$driver->street}}</p>
                            <p>{{$driver->city->name.", ".$driver->state->name}}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="col">
                <table class="w-100 tbl-border">
                    <tr>
                        <th colspan="4" class="tbl-head text-left" style="padding:10px;">All Paid Settlements From {{ $totalReports['date_from'] }} to {{ $totalReports['date_to'] }}</th>
                    </tr>
                    <tr>
                        <th class="text-left">Paid Date</th>
                        <th class="text-left">Total Amount</th>
                        <th class="text-left">Deductions</th>
                        <th class="text-left">Paid Amount</th>
                    </tr>

                    @foreach($totalReports['settlements'] as $report)
                    <tr>
                        <td>{{ $report['paid_date'] }}</td>
                        <td>${{ $report['gross_amount'] }}</td>
                        <td>${{ $report['deduction_amount'] }}</td>
                        <td>${{ $report['paid_amount'] }}</td>
                    </tr>
                    @endforeach

                    <tr>
                        <th class="text-left" colspan="3">Total Loads Delivered</th>
                        <th class="text-left">{{ $totalReports['total_loads'] }} load(s)</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="3">Total Amount Paid</th>
                        <th class="text-left">${{ number_format($totalReports['driver_pay'], 2) }}</th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>