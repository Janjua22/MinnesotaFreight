<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\DriverDetail;
use App\Models\DriverLicenseInfo;
use App\Models\DriverSettlement;
use App\Models\LoadPlanner;
use Carbon\Carbon;

class SummaryController extends Controller{
    /**
     * Show the application summary view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $from = date_format(Carbon::now(), 'Y-m-d');
        $to = date_format(Carbon::now()->addMonth(), 'Y-m-d');

        $data = [
            'loads' => LoadPlanner::where('is_deleted', 0)->count(),
            'settledLoads' => LoadPlanner::where('settlement', 1)->count(),
            'invoicesGraph' => $this->calculateInvoices(),
            'invAndSett' => $this->calculateInvoicesAndSettlements()
        ];

        $medicalRenewals = DriverDetail::whereBetween('med_renewal', [$from, $to])->get();
        $licenseExpirations = DriverLicenseInfo::whereBetween('expiration', [$from, $to])->get();

        return view('admin.summary', compact('data', 'licenseExpirations', 'medicalRenewals'));
    }

    /**
     * Fetch and calculates paid, unpaid and total paid 
     * invoices percentage.
     * 
     * @return array - $invoices
     */
    private function calculateInvoices(): array{
        $invoices = Invoice::all();

        $paid = 0;
        $unpaid = 0;

        foreach($invoices as $inv){
            if($inv->status == 1){
                $paid++;
            } else{
                $unpaid++;
            }
        }

        return [
            'paid' => $paid,
            'unpaid' => $unpaid,
            'percentage' => ($paid)? round($paid / $invoices->count() * 100) : 0
        ];
    }

    /**
     * Calculates the amount of invoices and driver
     * settlements for current year distributed in months.
     * 
     * @return array - $monthlyData
     */
    private function calculateInvoicesAndSettlements(): array{
        $invoices = Invoice::where('status', 1)->get();
        $settlements = DriverSettlement::where('status', 1)->get();

        $months = array();
        $monthlyData = array();

        for($i = 1; $i <= 12; $i++){
            $now = Carbon::now()->year."-".$i."-01 00:00:00";
            array_push($months, Carbon::create($now)->shortEnglishMonth);
        }

        foreach($months as $mon){
            $income = 0;
            $factoringFee = 0;
            $paidDrivers = 0;
            $deductions = 0;

            foreach($invoices as $invoice){
                if(Carbon::parse($invoice->date)->year == Carbon::now()->year && Carbon::parse($invoice->date)->shortEnglishMonth == $mon){
                    $income += $invoice->total_amount;
                }
            }

            foreach($settlements as $settlement){
                if(Carbon::parse($settlement->paid_date)->year == Carbon::now()->year && Carbon::parse($settlement->date)->shortEnglishMonth == $mon){
                    $paidDrivers += $settlement->paid_amount;
                }
            }

            $monthlyData[$mon] = [
                'income' => round($income, 2),
                'expenses' => round($paidDrivers, 2)
            ];
        }

        return $monthlyData;
    }
}