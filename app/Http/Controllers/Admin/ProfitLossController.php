<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\DriverSettlement;

class ProfitLossController extends Controller{
    /**
     * Show the application profit-loss-view view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        $data = array();

        if(isset($request->date_from) && isset($request->date_to)){
            $invoices = Invoice::where('status', 1)->whereBetween('paid_date', [$request->date_from, $request->date_to])->get();

            // $loads = LoadPlanner::where(['is_deleted' => 0, 'status' => 1])->whereHas('destinations', function($query) use ($request){
            //     $query->where(type', 'pickup')->whereBetween('date', [$request->date_from, $request->date_to]);
            // })->get();

            $settlements = DriverSettlement::where('status', 1)->whereBetween('paid_date', [$request->date_from, $request->date_to])->get();

            $income = 0;
            $profit = 0;
            $expenses = 0;
            $factoringFees = 0;
            $paidDrivers = 0;
            $accessorialAmount = 0;
            $fuelExpenses = 0;

            foreach($invoices as $invoice){
                $income += $invoice->total_amount;
                $factoringFees += $invoice->total_amount - $invoice->total_w_factoring;
            }

            foreach($settlements as $settlement){
                $paidDrivers += $settlement->paid_amount;

                foreach($settlement->loads() as $load){
                    $fuelExpenses += $load->truck->fuelExpenses->sum('total');
                    $accessorialAmount += $load->fee->accessorial_amount ?? 0;
                }
            }

            $expenses = $factoringFees + $accessorialAmount + $paidDrivers + $fuelExpenses;

            $profit = $income - $expenses;

            $data = [
                'income' => $income,
                'expenses' => [
                    'factoring_fees' => round($factoringFees, 2),
                    'accessorial_amount' => round($accessorialAmount, 2),
                    'drivers' => round($paidDrivers, 2),
                    'fuel_expenses' => round($fuelExpenses, 2),
                    'total' => round($expenses, 2),
                ],
                'profit' => round($profit, 2)
            ];

            if(isset($request->print)){
                return view('admin.profit-and-loss.profit-loss-print', compact('data'));
            }
        }

        return view('admin.profit-and-loss.profit-loss-view', compact('data'));
    }
}