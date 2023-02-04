<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Invoices</title>
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
            border: 1px solid #aa0724;
            padding: 5px;
        }
        .w-100{ width: 100%; }
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
            font-size: 8px;
        }
        .tbl-head{
            background-color: #aa0724; 
            color: #fff; 
            border: 1px solid #aa0724 !important;
        }
        .page-break{
            page-break-after: always;
        }
        td.tbl-btm-panel{
            width: 100px; 
            height: 35px;
        }
        th.tbl-btm-panel{
            width: 80px; 
            height: 35px;
        }
    </style>
</head>
<body style="margin:0; padding:0;">
    <?php
        $path = (config('app.env') == "production")? storage_path()."/app/public/" : public_path()."/storage/";
    ?>
    <table class="w-100" style="margin-top:15px; padding:0px;">
        <tr>
            <td>
                <img src="{{ $path.$allInvoices[0]->factoring->logo }}" alt="{{ $allInvoices[0]->factoring->name }} logo" class="company-logo">
            </td>
        </tr>
        <tr>
            <td style="padding: 15px;">
                <table class="w-100 tbl-border">
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Inv. No.</th>
                        <th>P.O. No.</th>
                        <th style="width:300px;">Debtor's Name</th>
                        <th>Amount</th>
                    </tr>
                    @foreach($allInvoices as $i => $invoice)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ date_format(new DateTime($invoice->date), "M d, Y") }}</td>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->loadPlanner->load_number }}</td>
                        <td>{{ $invoice->customer->name }}</td>
                        <td class="text-right">${{ $invoice->total_amount }}</td>
                    </tr>
                    @endforeach
                </table>
                <table class="w-100 tbl-border">
                    <tr>
                        <th colspan="2">Specific Invoice Adjusments</th>
                        <td class="text-right tbl-btm-panel">Total</td>
                        <th class="text-right tbl-btm-panel">${{ $allInvoices->sum('total_amount') }}</th>
                    </tr>
                    <tr>
                        <th colspan="2"></th>
                        <td class="text-right tbl-btm-panel">Fee Z4020</td>
                        <th class="text-right tbl-btm-panel"></th>
                    </tr>
                    <tr>
                        <th colspan="2"></th>
                        <td class="text-right tbl-btm-panel">Delivery Charge Z5016</td>
                        <th class="text-right tbl-btm-panel"></th>
                    </tr>
                    <tr>
                        <th colspan="2"></th>
                        <td class="text-right tbl-btm-panel">ESCROW Reserve X2035</td>
                        <th class="text-right tbl-btm-panel"></th>
                    </tr>
                    <tr>
                        <td>Schedule No.:</td>
                        <td>Check Number:</td>
                        <td class="text-right tbl-btm-panel">Client Reserve Release X2035</td>
                        <th class="text-right tbl-btm-panel"></th>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="2">
                            <small>
                                For valuable consideration, receipt of which is hereby acknowledged, the undersigned hereby sells, 
                                assigns, sets over and transfers to <b>{{ $allInvoices[0]->factoring->name }}</b>, its successors or 
                                assigns, all its right, title, and interest in and to the accounts above named, including all monies 
                                due or to become due thereon, all in accordance with and pursuant to that certain Factoring Agreement 
                                now existing by and between the undersigned and <b>{{ $allInvoices[0]->factoring->name }}</b>, the 
                                conditions, representations, warranties, and agreements of which are made part of this sale and assignments 
                                and incorporated herein by reference. This is to certify that the parties named above are indebted to 
                                the undersigned in the sums set opposite their respective names for merchandise sold and delivered or for 
                                work and labor done and accepted.
                            </small>
                        </td>
                        <td class="text-right tbl-btm-panel">Adjustments A1010</td>
                        <th class="text-right tbl-btm-panel"></th>
                    </tr>
                    <tr>
                        <td class="text-right tbl-btm-panel">Cash Payments</td>
                        <th class="text-right tbl-btm-panel"></th>
                    </tr>
                </table>
                <table class="w-100">
                    <tr>
                        <td class="text-right" style="width:50px; height:35px; padding-right:10px;">Date</td>
                        <td style="border-bottom:1px solid #000;">{{ date_format(now(), "M d, Y") }}</td>
                        <td class="text-right" style="width:100px; height:35px; padding-right:10px;">Seller/Company</td>
                        <td style="border-bottom:1px solid #000;">{{ siteSetting('title') }}</td>
                        <td class="text-right" style="width:50px; height:35px; padding-right:10px;">By</td>
                        <td style="border-bottom:1px solid #000; width:200px;"> </td>
                    </tr>
                </table>
                <table class="w-100" style="border-bottom:2px solid #aa0724;">
                    <tr>
                        <td colspan="5" style="padding-top:10px; padding-bottom:10px;">Please indicate how you would like your payment delivered:</td>
                    </tr>
                    <tr>
                        <td style="padding-bottom:10px;">
                            Wire 
                            <span style="padding:0px 4px; border:1px solid #000; margin-left:5px;">&nbsp;</span>
                        </td>
                        <td style="padding-bottom:10px;">
                            Mail Check 
                            <span style="padding:0px 4px; border:1px solid #000; margin-left:5px;">&nbsp;</span>
                        </td>
                        <td style="padding-bottom:10px;">
                            ACH 
                            <span style="padding:0px 4px; border:1px solid #000; margin-left:5px;">&nbsp;</span>
                        </td>
                        <td style="padding-bottom:10px;">
                            Over Night 
                            <span style="padding:0px 4px; border:1px solid #000; margin-left:5px;">&nbsp;</span>
                        </td>
                        <td style="padding-bottom:10px;">
                            Pickup 
                            <span style="padding:0px 4px; border:1px solid #000; margin-left:5px;">&nbsp;</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- <div class="page-break"></div> --}}
</body>
</html>