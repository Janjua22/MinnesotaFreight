<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\DriverSettlementMailable;
use App\Models\LoadPlanner;
use App\Models\DriverDetail;
use App\Models\DriverSettlement;
use App\Models\DriverAdditionalDeduction;
use App\Models\DeductionCategory;
use App\Models\Truck;
use App\Models\User;
use App\Models\FuelExpenseSheet;
use App\Models\FuelExpense;
use App\Models\DriverReimbursement;
use PDF;
use DB;

class DriverSettlementController extends Controller{
    /**
     * Show the application driver-settlement-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
	
        $drivers = DriverDetail::where('is_deleted', 0)->get();
        $settlements = DriverSettlement::where('is_deleted', 0)->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->get();
        return view('admin.driver-settlements.driver-settlement-list', compact('drivers', 'settlements'));
    }
    
    public function addsettlememt(){
        // $drivers = DriverDetail::where('is_deleted', 0)->get();
        $drivers = DB::table('driver_details')
        ->join('users', 'users.id', '=', 'driver_details.user_id')
        ->where('driver_details.is_deleted', 0)
        ->select('driver_details.*','users.first_name','users.last_name')
        ->orderBy('users.first_name', 'ASC')
        ->get();
        $settlements = DriverSettlement::where('is_deleted', 0)->orderBy('created_at', 'DESC')->get();
        // dd($drivers);

        return view('admin.driver-settlements.driver-settlement-addsettlememt', compact('drivers', 'settlements'));
    }

    /**
     * Show the application driver-settlement-add view.
     * 
     * @param Illuminate\Http\Request - $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(Request $request){
        if(!isset($request->loads)){
            return redirect()->back()->withErrors(['message' => "Select at aleast one load to generate settlement for."]);
        }

        $truckIds = array();
        $loads = LoadPlanner::where(['driver_id' => $request->driver_id, 'settlement' => 0, 'is_deleted' => 0])->whereIn('id', $request->loads)->get();
        $driver = DriverDetail::where('id', $request->driver_id)->first();
        $categories = DeductionCategory::where(['is_deleted' => 0, 'status' => 1])->get();

        foreach($loads as $load){
            if(!in_array($load->truck_id, $truckIds)){
                array_push($truckIds, $load->truck_id);
            }
        }

        $trucksUsed = Truck::whereIn('id', $truckIds)->get();

        return view('admin.driver-settlements.driver-settlement-add', compact('driver', 'loads', 'categories', 'trucksUsed'));
    }

    /**
     * Show the application driver-settlement-detail view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDetails($id){
        $driverSettlement = DriverSettlement::where('id', $id)->first();

        $loads = $driverSettlement->loads();

        $truckIds = array();

        foreach($loads as $load){
            if(!in_array($load->truck_id, $truckIds)){
                array_push($truckIds, $load->truck_id);
            }
        }

        $trucksUsed = Truck::whereIn('id', $truckIds)->get();

        return view('admin.driver-settlements.driver-settlement-details', compact('loads', 'driverSettlement', 'trucksUsed'));
    }

    /**
     * Show the application driver-settlement-edit view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $truckIds = array();
        $driverSettlement = DriverSettlement::where(['id' => $id, 'is_deleted' => 0])->first();
        $loads = LoadPlanner::whereIn('id', explode(",", $driverSettlement->selected_trips))->get();
        $categories = DeductionCategory::where(['is_deleted' => 0, 'status' => 1])->get();

        foreach($loads as $load){
            if(!in_array($load->truck_id, $truckIds)){
                array_push($truckIds, $load->truck_id);
            }
        }

        $trucksUsed = Truck::whereIn('id', $truckIds)->get();

        return view('admin.driver-settlements.driver-settlement-edit', compact('loads', 'driverSettlement', 'categories', 'trucksUsed'));
    }

    /**
     * Fetches the trips between two dates.
     * 
     * @param Illuminate\Http\Request - $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkTrips(Request $request){
        // This was the mechanism to select driver's loads by a date range, it's been turned off due to client's demand...
        // $from = $request->date_from." 00:00:00";
        // $to = $request->date_to." 23:59:59";
        // $loads = LoadPlanner::where(['driver_id' => $request->driver_id, 'settlement' => 0, 'status' => 1])->whereBetween('created_at', [$from, $to])->get();
        $loads = LoadPlanner::where(['driver_id' => $request->driver_id, 'settlement' => 0, 'status' => 1])->get();
        $driverSettlements = DriverSettlement::all();

        if($loads->count() > 0){
            $loadsArr = array();
            $status = false;
            
            foreach ($loads as $load){
                if($load->invoiced == 1){
                    $loadNotSettled = true;

                    foreach($driverSettlements as $settlement){
                        $ids = explode(",", $settlement->selected_trips);

                        if(in_array($load->id, $ids)){
                            $loadNotSettled = false;
                        }
                    }

                    if($loadNotSettled){
                        $pickup = array();
                        $consignee = array();
            
                        foreach($load->destinations as $dest){
                            if($dest->type == 'pickup'){
                                array_push($pickup, $dest->location->name);
                            } else{
                                array_push($consignee, $dest->location->name);
                            }
                        }
    
                        array_push($loadsArr, [
                            'load_id' => $load->id,
                            'load_number' => $load->load_number,
                            'pickups' => $pickup,
                            'consignees' => $consignee,
                            'load_url' => route('admin.loadPlanner.details', ['id' => $load->id]),
                            'truck_number' => $load->truck->truck_number,
                            'freight_amount' => $load->fee->freight_amount ?? 'n/a',
                            'freight_type' => $load->fee->fee_type ?? 'n/a'
                        ]);

                        $status = true;
                    }
                }
                
                $driverName = $load->driver->userDetails->first_name." ".$load->driver->userDetails->last_name;
            }

            return response()->json([
                'status' => $status,
                'data' => ['loads' => $loadsArr, 'driver_id' => $request->driver_id, 'driver_name' => $driverName]
            ], 200);
        } else{
            return response()->json(['status' => false, 'msg' => 'No unpaid loads found in the defined period for this driver. Make sure the load you\'re trying to settle down is marked as completed!'], 200);
        }
    }

    /**
     * Creates a new record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){
        $loads = LoadPlanner::where(['driver_id' => $request->driver_id, 'settlement' => 0])->whereIn('id', $request->loads)->update(['settlement' => 1]);

        $settlement = DriverSettlement::create([
            'driver_id' => $request->driver_id,
            'selected_trips' => implode(",", $request->loads),
            'total_trips' => $request->total_trips,
            'paid_date' => null,
            'gross_amount' => $request->gross_amount,
            'deduction_amount' => $request->deduction_amount,
            'paid_amount' => $request->paid_amount,
            'updated_at' => null,
            'status' => 0
        ]);

        if(isset($request->amount)){
            $dedArr = array();
            
            foreach($request->amount as $i => $amount){
                array_push($dedArr, [
                    'settlement_id' => $settlement->id,
                    'category_id' => $request->category_id[$i],
                    'amount' => $amount,
                    'note' => $request->note[$i],
                    'date' => Carbon::now()->toDateString()
                ]);
            }

            DriverAdditionalDeduction::insert($dedArr);
        }

        // Mail::to($settlement->driverdriver-settlement->userDetails->email)->send(new DriverSettlementMailable($settlement->id));
        
        return redirect()->route('admin.driverSettlement')->with(['success' => 'Settlement has been generated!']);
    }

    /**
     * Updates an existing record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        DriverSettlement::where('id', $request->id)->update([
            'gross_amount' => $request->gross_amount,
            'deduction_amount' => $request->deduction_amount,
            'paid_amount' => $request->paid_amount,
        ]);

        if(isset($request->amount)){
            $dedArr = array();
            
            foreach($request->amount as $i => $amount){
                array_push($dedArr, [
                    'settlement_id' => $request->id,
                    'category_id' => $request->category_id[$i], 
                    'amount' => $amount,
                    'note' => $request->note[$i],
                    'date' => Carbon::now()->toDateString()
                ]);
            }
            
            DriverAdditionalDeduction::insert($dedArr);
        }

        if(isset($request->reimbursement)){
            $rimArr = array();

            foreach($request->reimbursement['load_id'] as $i => $load_id){
                $load = LoadPlanner::where('id', $load_id)->select('truck_id')->first();

                array_push($rimArr, [
                    'truck_id' => $load->truck_id,
                    'load_id' => $load_id,
                    'settlement_id' => $request->id,
                    'date' => $request->reimbursement['date'][$i],
                    'description' => $request->reimbursement['memo'][$i],
                    'amount' => $request->reimbursement['amount'][$i]
                ]);
            }

            DriverReimbursement::where('settlement_id', $request->id)->delete();
            DriverReimbursement::insert($rimArr);
        }

        return redirect()->route('admin.driverSettlement')->with(['success' => 'Settlement has been updated!']);
    }

    /**
     * Removes a specific record from the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request){
        $request->validate(['delete_trace' => 'required|numeric|min:1']);

        $driverSettlement = DriverSettlement::where('id', $request->delete_trace);
        $driverSettlement->update(['is_deleted' => 1]);
        $driverSettlement = $driverSettlement->first();

        $html = "<a href=\"".route('admin.driverSettlement.details', ['id' => $request->delete_trace])."\" class=\"text-dark\" target=\"_blank\">
        <h4><i class=\"bi bi-clipboard-check fs-3 text-dark\"></i> Driver Settlement</h4>
        <p>{$driverSettlement->driver->userDetails->first_name} {$driverSettlement->driver->userDetails->last_name} | $$driverSettlement->paid_amount | ". ($driverSettlement->status ? "Paid" : "Due") ."</p></a>";

        TrashController::create([
            'module_name' => 'DriverSettlement',
            'row_id' => $request->delete_trace,
            'description' => $html
        ]);

        return redirect()->back();
    }

    /**
     * Removes a specific record from the database.
     *
     * @param int - $id
     * 
     * @return bool
     */
    public function permenantDelete(int $id): bool{
        $settlement = DriverSettlement::where('id', $id)->first();
        
        $selectedLoads = explode(",", $settlement->selected_trips);

        $selectedLoads = LoadPlanner::whereIn('id', $selectedLoads)->update(['settlement' => 0]);

        DriverAdditionalDeduction::where('settlement_id', $id)->delete();
        DriverSettlement::where('id', $id)->delete();

        return true;
    }

    /**
     * Updates the status of a record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function markPaid(Request $request){
        $settlement = DriverSettlement::where('id', $request->id);
        $settlement->update(['paid_date' => Carbon::now()->toDateString(), 'status' => 1]);
        $settlementRow = $settlement->first();
        
        $loads = LoadPlanner::whereIn('id', explode(",", $settlementRow->selected_trips))->get();
        $truckIds = array();

        foreach($loads as $load){
            if(!in_array($load->truck_id, $truckIds)){
                array_push($truckIds, $load->truck_id);
            }
        }
        
        LoadPlanner::whereIn('id', explode(",", $settlementRow->selected_trips))->update([
            'settlement' => 1
        ]);

        $allFuelExpenses = FuelExpense::where('settled', 0)->whereIn('truck_id', $truckIds);

        $parentSheets = $allFuelExpenses->get()->groupBy('sheet_id');

        $allFuelExpenses->update(['settled_at' => now(), 'settled' => 1]);

        foreach($parentSheets as $i => $parentId){
            FuelExpenseSheet::where('id', $i)->update(['deletable' => 0]);
        }

        return redirect()->back()->with(['status' => 'paid']);
    }

    /**
     * Removes a record from driver_additional_deductions 
     * table in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function removeDeduction(Request $request){
        $settlement = DriverSettlement::where('id', $request->settlement_id)->first();
        $deduction = DriverAdditionalDeduction::where('id', $request->additional_deduction_id)->first();

        DriverSettlement::where('id', $request->settlement_id)->update([
            'deduction_amount' => $settlement->deduction_amount - $deduction->amount,
            'paid_amount' => $settlement->paid_amount + $deduction->amount
        ]);

        DriverAdditionalDeduction::where('id', $request->additional_deduction_id)->delete();

        return response()->json([
            'status' => true, 
            'msg' => 'Deduction has been removed!',
            'amount' => $deduction->amount
        ], 200);
    }
    
    /**
     * Removes a record from driver_reimbursements 
     * table in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function removeReimbursement(Request $request){
        $settlement = DriverSettlement::where('id', $request->settlement_id)->first();
        $reimbursement = DriverReimbursement::where('id', $request->reimbursement_id)->first();

        DriverSettlement::where('id', $request->settlement_id)->update([
            'gross_amount' => $settlement->gross_amount - $reimbursement->amount,
            'paid_amount' => $settlement->paid_amount - $reimbursement->amount
        ]);

        DriverReimbursement::where('id', $request->reimbursement_id)->delete();

        return response()->json([
            'status' => true, 
            'msg' => 'Reimbursement has been removed!',
            'amount' => $reimbursement->amount
        ], 200);
    }



public function mail($id){
       
        $Loadnumber = array();
        $driverSettlement = DriverSettlement::where('id', $id)->first();
       
        $driverdetail = User::where('id', $driverSettlement->driver_id)->first();
        // dd($driverdetail);
        $loads = LoadPlanner::whereIn('id', explode(",", $driverSettlement->selected_trips))->get();
        $truckIds = array();
        
          //dd driversettlement for checking email and name of driver
        foreach($loads as $load){
            if(!in_array($load->truck_id, $truckIds)){
                array_push($truckIds, $load->truck_id);
            }
             if(!in_array($load->load_number, $Loadnumber)){
                array_push($Loadnumber, $load->load_number);
            }
        }
         
        $trucksUsed = Truck::whereIn('id', $truckIds)->get();
       
        $fuelexpenseTotal = 0;
        $fuelexpenseLoads = NULL;
        $fuelsheet = 0;
        $fuelexpDate = 0;
        $fuelexpense = FuelExpense::whereIn('truck_id', $truckIds)->get();
        
         foreach($fuelexpense as $fuel){
            //  dd($Loadnumber);
            //  dd(json_decode($fuel->load_id));
             if( $Loadnumber == json_decode($fuel->load_id) ){
                 $fuelexpenseTotal = $fuelexpenseTotal + $fuel->total;
                //  dd('test');
                if($fuelexpenseLoads == NULL ){
                 $fuelexpenseLoads = $fuel->load_id;
                //  dd('test');
             }
             if($fuelsheet == 0){
                 $fuelsheet = $fuel->sheet_id;
             }
             }
         }
          $sheets = 0;
         
        $trucksUsed = Truck::whereIn('id', $truckIds)->get();
         
        $fuelsheet = FuelExpenseSheet::where('id', $fuelsheet)->first();
       
        if($fuelsheet){
            $fuelexpDate = date('d-m-Y', strtotime($fuelsheet->created_at));
            $sheets = FuelExpense::where('sheet_id', $fuelsheet->id)->orderBy('id', 'DESC')->get();
             
            
            
        }
        $data["driveremail"] = $driverdetail->email; //value set of driver email
      
        $data["title"] = "Driver Settlement File";
        $data["drivername"] = $driverdetail->first_name;  // value set for driver name
         
        // $pdf = PDF::loadView('admin.accounting.print-driver-settlement', compact('driverSettlement', 'trips'));

        // return $pdf->download('driver-settlement.pdf');
       
        $pdf = PDF::loadView('admin.driver-settlements.driver-settlement-print', compact('driverSettlement','Loadnumber','sheets','fuelexpense','fuelexpDate','fuelexpenseTotal','fuelexpenseLoads', 'loads', 'trucksUsed'));
        
        $pdf->save("/home/minneso6/public_html/storage/temp-attach/attachment.pdf");
        //  dd("test again");
         Mail::send('emails.mailtodriver', $data, function($message)use($data) {
            $message->to($data["driveremail"], $data["driveremail"])
                    ->subject($data["title"]);
                    $message->attach("/home/minneso6/public_html/storage/temp-attach/attachment.pdf");
            
            
        });
         unlink("/home/minneso6/public_html/storage/temp-attach/attachment.pdf");
        // return view('admin.driver-settlements.driver-settlement-print', compact('driverSettlement','Loadnumber','sheets','fuelexpense','fuelexpDate','fuelexpenseTotal','fuelexpenseLoads', 'loads', 'trucksUsed'));
         return view('mailsent');

    
    
}


    /**
     * Resposible for generating a PDF file of the driver settlement.
     *
     * @param string - $id
     * 
     * @return LynX39\LaraPdfMerger\Facades\PdfMerger - save() instance
     */
    public function print($id){
        $driverSettlement = DriverSettlement::where('id', $id)->first();
        $loads = LoadPlanner::whereIn('id', explode(",", $driverSettlement->selected_trips))->get();
        $truckIds = array();

        foreach($loads as $load){
            if(!in_array($load->truck_id, $truckIds)){
                array_push($truckIds, $load->truck_id);
            }
        }

        $trucksUsed = Truck::whereIn('id', $truckIds)->get();

        // $pdf = PDF::loadView('admin.accounting.print-driver-settlement', compact('driverSettlement', 'trips'));

        // return $pdf->download('driver-settlement.pdf');
        return view('admin.driver-settlements.driver-settlement-print', compact('driverSettlement', 'loads', 'trucksUsed'));
    }
}