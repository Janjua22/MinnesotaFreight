<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverDetail;
use App\Models\DriverSettlement;
use App\Models\Truck;
use App\Models\Invoice;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller{
    /**
     * Show the application report.driver-settlement view
     * with relevent data.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function driverSettlement(Request $request){
        $drivers = DriverDetail::where('is_deleted', 0)->get();
        $totalReports = array();

        if(isset($request->driver_id)){
            $totalReports = $this->calculateSettlement($request->driver_id, $request->date_from, $request->date_to);
        }
        
        return view('admin.reports.driver-settlement',compact('drivers', 'totalReports'));
    }
    
    /**
     * Converts the view to PDF and download it.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function printDriverSettlement(Request $request){
        if(isset($request->driver_id)){
            $driver = DriverDetail::where(['id' => $request->driver_id, 'is_deleted' => 0])->first();
            $totalReports = $this->calculateSettlement($request->driver_id, $request->date_from, $request->date_to);

            $pdf = PDF::loadView('admin.reports.print-driver-settlement', compact('driver', 'totalReports'));
            return $pdf->download('settlement-report.pdf');
        } else{
            return redirect()->back()->withErrors(['message' => 'Unable to download the report now!']);
        }
    }

    /**
     * Show the application report.factoring view
     * with relevent data.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function factoringFee(Request $request){
        $trucks = Truck::where('is_deleted', 0)->get();
        $totalReports = array();

        if(isset($request->truck_id)){
            $totalReports = $this->calculateFactoring($request->truck_id, $request->date_from, $request->date_to);
        }

        return view('admin.reports.factoring', compact('trucks', 'totalReports'));
    }

    /**
     * Converts the view to PDF and download it.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function printfactoringFee(Request $request){
        if(isset($request->truck_id)){
            $totalReports = $this->calculateFactoring($request->truck_id, $request->date_from, $request->date_to);

            $pdf = PDF::loadView('admin.reports.print-factoring', compact('totalReports'));
            return $pdf->download('factoring-report.pdf');
        } else{
            return redirect()->back()->withErrors(['message' => 'Unable to download the report now!']);
        }
    }

    /**
     * Calculates the driver settlements of a single driver 
     * in a date range.
     * 
     * @param int - $driver_id
     * @param string - $date_from
     * @param string - $date_to
     * 
     * @return array
     */
    private function calculateSettlement(int $driver_id, string $date_from, string $date_to): array{
        $settlementsData = array();
        $totalTrips = 0;
        $driverPaid = 0;

        $settlements = DriverSettlement::where(['is_deleted' => 0, 'driver_id' => $driver_id, 'status' => 1]);

        if($date_from && $date_to){
            $settlements->whereBetween('paid_date', [$date_from, $date_to]);
        }

        $settlements = $settlements->get();

        foreach($settlements as $settlement){
            $totalTrips += $settlement->total_trips;
            $driverPaid += $settlement->paid_amount;
            
            if($settlement->driver->truckAssigned->status){
                $truckId = $settlement->driver->truckAssigned->id;
                $truckNumber = $settlement->driver->truckAssigned->truck_number;
                $truckType = ($settlement->driver->truckAssigned->type_id == 1)? 'Truck' : 'Trailer';
            }

            array_push($settlementsData, [
                'paid_amount' => $settlement->paid_amount,
                'deduction_amount' => $settlement->deduction_amount,
                'gross_amount' => $settlement->gross_amount,
                'paid_date' => date_format(Carbon::parse($settlement->paid_date), 'M d, Y')
            ]);
        }

        return [
            'date_from' => date_format(Carbon::parse($date_from), 'M d, Y'),
            'date_to' => date_format(Carbon::parse($date_to), 'M d, Y'),
            'driver_pay' => $driverPaid,
            'total_loads' => $totalTrips,
            'settlements' => $settlementsData
        ];
    }

    /**
     * Calculates the factoring fee of a single truck 
     * in a date range.
     * 
     * @param int - $truck_id
     * @param string - $date_from
     * @param string - $date_to
     * 
     * @return array
     */
    private function calculateFactoring(int $truck_id, string $date_from, string $date_to): array{
        $factoringData = array();
        $totalAmount = 0;
        $totalFactoring = 0;
        $factoringPaid = 0;

        $factoring = Invoice::where(['is_deleted' => 0, 'include_factoring' => 1]);

        if($date_from && $date_to){
            $factoring->whereBetween('date', [$date_from, $date_to]);
        }

        $factoring->whereHas('loadPlanner', function($q) use ($truck_id){
            $q->where('truck_id', $truck_id);
        });

        $factorings = $factoring->get();

        foreach($factorings as $factoring){
            $totalAmount += $factoring->total_amount;
            $totalFactoring += ($factoring->total_amount - $factoring->total_w_factoring);

            if($factoring->status == 1){
                $factoringPaid += ($factoring->total_amount - $factoring->total_w_factoring);
            }

            array_push($factoringData, [
                'invoice_number' => $factoring->invoice_number,
                'invoice_url' => route('admin.invoice.print', ['id' => $factoring->id]),
                'load_number' => $factoring->loadPlanner->load_number,
                'load_url' => route('admin.loadPlanner.details', ['id' => $factoring->loadPlanner->id]),
                'truck_number' => $factoring->loadPlanner->truck->truck_number,
                'name' => $factoring->customer->name,
                'total_amount' => number_format($factoring->total_amount, 2),
                'factoring_fee' => ($factoring->total_amount - $factoring->total_w_factoring),
                'factoring_percentage' => $factoring->factoring_fee,
                'date' => date_format(Carbon::parse($factoring->date), 'M d, Y'),
                'paid_date' => $factoring->paid_date ? date_format(Carbon::parse($factoring->paid_date), 'M d, Y') : 'N/A',
                'status' => $factoring->status
            ]);
        }

        return [
            'date_from' => date_format(Carbon::parse($date_from), 'M d, Y'),
            'date_to' => date_format(Carbon::parse($date_to), 'M d, Y'),
            'total_amount' => number_format($totalAmount, 2),
            'total_factoring' => number_format($totalFactoring, 2),
            'factoring_paid' => number_format($factoringPaid, 2),
            'factoring_fees' => $factoringData
        ];
    }
}