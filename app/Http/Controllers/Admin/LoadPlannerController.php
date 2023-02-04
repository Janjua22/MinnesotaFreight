<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Customer;
use App\Models\LoadPlanner;
use App\Models\LoadPlannerFee;
use App\Models\LoadPlannerDestination;
use App\Models\State;
use App\Models\Truck;
use App\Models\Invoice;
use Carbon\Carbon;
use Storage;
use DB;

class LoadPlannerController extends Controller{
    /**
     * Show the application load-planner view.
     *
     * @param Illuminate\Http\Request - $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        $arr = array();

        $customers = Customer::where('is_deleted', 0)->get();

        if($request->all()){
            $filters = array(['is_deleted' => 0]);

            if(isset($request->ld)){
                array_push($filters, ['load_number', 'LIKE', "%".$request->ld."%"]);
            }

            if(isset($request->cu)){
                array_push($filters, ['customer_id', '=', $request->cu]);
            }

            if(isset($request->st)){
                array_push($filters, ['status', '=', $request->st]);
            }

            $loads = LoadPlanner::where($filters)->orderBy('created_at', 'DESC')->get();
        } else{
            $loads = LoadPlanner::where('is_deleted', 0)->orderBy('created_at', 'DESC')->get();
        }


        return view('admin.load-planner.load-planner-list', compact('loads', 'customers'));
    }

    /**
     * Show the application load-planner-add view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(){
        $customers = array();
        $trucks = Truck::where(['is_deleted' => 0, 'status' => 1])->get();
        $fetch_customers = Customer::where(['status' => 1, 'is_deleted' => 0])->get();

        foreach($fetch_customers as $fetch_customer){
            array_push($customers, [
                'id' => $fetch_customer->id,
                'name' => $fetch_customer->name,
                'city' => $fetch_customer->city_id ? $fetch_customer->city->name : '',
                'state' => $fetch_customer->state_id ? $fetch_customer->state->name : ''
            ]);
        }


		$locations = array();
        $fetch_locations = new Location();
        $fetch_locations = $fetch_locations->where(['status' => 1, 'is_deleted' => 0]);

        // if(isset($request->q)){
            // $locations = $locations->where('name', 'LIKE', '%'.$request->q.'%');
        // }

        $fetch_locations = $fetch_locations->get();

        foreach($fetch_locations as $location){
            array_push($locations, [
                'id' => $location->id,
                'name' => $location->name,
                'city' => $location->city_id ? $location->city->name : '',
                'state' => $location->state_id ? $location->state->name : '',
            ]);
        }




        return view('admin.load-planner.load-planner-add', compact('trucks', 'locations', 'customers'));
    }


     public function checkLoads(Request $request){
        // dd($request->driver_id);


        // $loads = LoadPlanner::where(['driver_id' => $request->driver_id,'status' => 2])->get();
        $loads = DB::table('load_planners')
        ->join('customers', 'customers.id', '=', 'load_planners.customer_id')
        ->join('trucks', 'trucks.id', '=', 'load_planners.truck_id')
        ->join('driver_details', 'driver_details.id', '=', 'load_planners.driver_id')
        ->join('users', 'users.id', '=', 'driver_details.user_id')
        ->where('load_planners.driver_id', $request->driver_id)
        ->where('load_planners.status', 2)
        ->where('load_planners.is_deleted', 0)
        ->select('load_planners.*', 'customers.name','users.first_name','users.last_name','trucks.truck_number')
        ->get();
        //  dd($loads);
        if($loads->count() > 0){


            return response()->json([
                'status' => true,
                'data' => ['loads' => $loads, 'driver_id' => $request->driver_id]
            ], 200);
        } else{
            return response()->json(['status' => false, 'msg' => 'No loads found!'], 200);
        }
    }



     public function showcheckLoads(){
            //  dd("test");

             $drivers = DB::table('driver_details')
        ->join('users', 'users.id', '=', 'driver_details.user_id')
        ->where('driver_details.is_deleted', 0)
        ->select('driver_details.*','users.first_name','users.last_name')
        ->orderBy('users.first_name', 'ASC')
        ->get();
        //   dd($drivers);
            return view('admin.load-planner.load-planner-checkloads', compact('drivers'));
        }



     public function markAllCompleted(Request $request){
        // $request->validate(['loads' => 'required']);
        // dd($request->loads);

        LoadPlanner::whereIn('id', $request->loads)->update(['status' => 1]);

        return redirect()->route('admin.loadPlanner')->with(['success' => 'Loads has been marked as completed!']);
    }












    /**
     * Show the application load-planner-details view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDetails($id){
        $load = LoadPlanner::where('id', $id)->first();

        if($load){
            return view('admin.load-planner.load-planner-details', compact('load'));
        } else{
            abort(404);
        }
    }
    public function checkLoadnumber(Request $request){
        // dd($request->load_number);


        $loads = LoadPlanner::where('load_number', $request->load_number)->first();

        //  dd($loads);
        if($loads->count() > 0){
             return response()->json([
                'success' => false,
                'message' => 'The load is unavailable',
            ]);

        } else{
            return response()->json([
                'success' => true,
                'message' => 'The load is available'
            ]);

        }
    }

    /**
     * Show the application load-planner-edit view.
     *
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $load = LoadPlanner::where(['id' => $id, 'is_deleted' => 0])->first();
        $locations = Location::where(['is_deleted' => 0, 'status' => 1])->get();
        $trucks = Truck::where(['is_deleted' => 0, 'status' => 1])->get();



		$locations_dropdown = array();
        $fetch_locations = new Location();
        $fetch_locations = $fetch_locations->where(['status' => 1, 'is_deleted' => 0]);

        // if(isset($request->q)){
            // $locations = $locations->where('name', 'LIKE', '%'.$request->q.'%');
        // }

        $fetch_locations = $fetch_locations->get();

        foreach($fetch_locations as $location){
            array_push($locations_dropdown, [
                'id' => $location->id,
                'name' => $location->name,
                'city' => $location->city_id ? $location->city->name : '',
                'state' => $location->state_id ? $location->state->name : '',
            ]);
        }

        if(!$load){
            return abort(404);
        }

        return view('admin.load-planner.load-planner-edit', compact('load', 'locations', 'locations_dropdown', 'trucks'));
    }

    /**
     * Show the application load-planner-missing view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showMissingFiles(){
        $loads = LoadPlanner::where('is_deleted', 0)->get();

        $missingFiles = array();

        foreach($loads as $load){
            if($load->file_rate_confirm == null || $load->file_bol == null){
                array_push($missingFiles, [
                    'load_id' => $load->id,
                    'load_number' => $load->load_number,
                    'customer_name' => $load->customer->name,
                    'truck_number' => $load->truck->truck_number,
                    'driver_name' => $load->driver->userDetails->first_name." ".$load->driver->userDetails->last_name,
                    'stops' => $load->destinations->count(),
                    'freight_amount' => $load->fee->freight_amount ?? 'N/A',
                    'fee_type' => $load->fee->fee_type,
                    'status' => $load->status,
                    'invoiced' => $load->invoiced,
                    'upload_bol' => $load->file_bol ? false : true,
                    'upload_rc' => $load->file_rate_confirm ? false : true
                ]);
            }
        }

        return view('admin.load-planner.load-planner-missing', compact('missingFiles'));
    }

    /**
     * Creates a new record in the database.
     *
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){

// 		dd($request->all());
        $request->validate([
            'customer_id' => 'required|numeric|min:1',
            'truck_id' => 'required|numeric|min:1',
            'driver_id' => 'required|numeric|min:1',
            'p_location_id' => 'required',
            'p_date' => 'required',
            'p_time' => 'required',
            'fee_type' => 'required|string|max:100',
            'freight_amount' => 'required|numeric|min:0',
            'stop_off' => 'min:0',
            'tarp_fee' => 'min:0',
            'invoice_advance' => 'min:0',
            'driver_advance' => 'min:0',
            'file_accessorial_invoice' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg',
            'file_rate_confirm' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg',
            'file_bol' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg'
        ]);

        if($request->p_location_id[0] == null && $request->c_location_id[0] == null){
            return redirect()->back()->withErrors(['message' => 'Please define pickup and atleast one consignee location.']);
        } else if($request->p_location_id[0] == null){
            return redirect()->back()->withErrors(['message' => 'Please select a pickup location.']);
        } else if($request->c_location_id[0] == null){
            return redirect()->back()->withErrors(['message' => 'Please select a consignee location.']);
        }

        $destinations = array('pickup' => array(), 'consignee' => array());
        $fileRate = null;
        $fileBol = null;
        $fileAccessorial = null;

        if(isset($request->load_number)){
            $loadNumber = $request->load_number;
        } else{
            $loadNumber = "L-".Carbon::now()->timestamp;
        }

        if($request->hasFile('file_accessorial_invoice')){
            $path = Storage::putFile('public/files/load_planners', $request->file_accessorial_invoice);
            $fileAccessorial = str_replace("public/", "", $path);
        }

        if($request->file_rate_confirm){
            $path = Storage::putFile('public/files/load_planners', $request->file_rate_confirm);
            $fileRate = str_replace("public/", "", $path);
        }

        if($request->file_bol){
            $path = Storage::putFile('public/files/load_planners', $request->file_bol);
            $fileBol = str_replace("public/", "", $path);
        }

        $load = LoadPlanner::create([
            'load_number' => $loadNumber,
            'customer_id' => $request->customer_id,
            'truck_id' => $request->truck_id,
            'driver_id' => $request->driver_id,
            // 'bol' => $request->bol,
            // 'required_info' => $request->required_info,
            'file_rate_confirm' => $fileRate,
            'file_bol' => $fileBol,
            'invoiced' => 1,
            'settlement' => 0,
            'status' => 2
        ]);

        LoadPlannerFee::insert([
            'load_id' => $load->id,
            'freight_amount' => $request->freight_amount,
            'fee_type' => $request->fee_type,
            'file_accessorial_invoice' => $fileAccessorial,
            'accessorial_amount' => $request->accessorial_amount,
            'stop_off' => $request->stop_off,
            'tarp_fee' => $request->tarp_fee,
            'invoice_advance' => $request->invoice_advance,
            'driver_advance' => $request->driver_advance,
        ]);

        foreach($request->c_location_id as $i => $locationIdConsignee){
            if($locationIdConsignee){
                $date = Carbon::parse($request->c_date[$i])->year."-".Carbon::parse($request->c_date[$i])->month."-".Carbon::parse($request->c_date[$i])->day;
                $time = Carbon::parse($request->c_time[$i])->hour.":".Carbon::parse($request->c_time[$i])->minute.":".Carbon::parse($request->c_time[$i])->second;

                array_push($destinations['consignee'], [
                    'load_id' => $load->id,
                    'location_id' => $locationIdConsignee,
                    'date' => $date,
                    'time' => $request->c_time[$i] ? $time : null,
                    'stop_number' => $i+1,
                    'type' => 'consignee'
                ]);
            }
        }

        foreach($request->p_location_id as $i => $locationIdPickup){
            if($locationIdPickup){
                $date = Carbon::parse($request->p_date[$i])->year."-".Carbon::parse($request->p_date[$i])->month."-".Carbon::parse($request->p_date[$i])->day;
                $time = Carbon::parse($request->p_time[$i])->hour.":".Carbon::parse($request->p_time[$i])->minute.":".Carbon::parse($request->p_time[$i])->second;

                array_push($destinations['pickup'], [
                    'load_id' => $load->id,
                    'location_id' => $locationIdPickup,
                    'date' => $date,
                    'time' => $request->p_time[$i] ? $time : null,
                    'stop_number' => $i+1,
                    'type' => 'pickup'
                ]);
            }
        }

        LoadPlannerDestination::insert($destinations['pickup']);
        LoadPlannerDestination::insert($destinations['consignee']);

        if($load->file_rate_confirm == null && $load->file_bol == null){
            $successMsg = "A new load has been created, but the Bill of Lading and Rate of Confirmation files are missing from this load! Please attach them as soon as possible!";
        } elseif ($load->file_rate_confirm == null) {
            $successMsg = "A new load has been created, but the Rate of Confirmation file is missing, please attach it!";
        } elseif ($load->file_bol == null) {
            $successMsg = "A new load has been created, but the Bill of Lading file is missing, please attach it!";
        } else {
            $successMsg = 'A new load has been created!';
        }


        // generating invoice...
        $lastInvoice = Invoice::orderBy('id', 'DESC')->first();

        if($lastInvoice){
            $invoiceNumber = (int)$lastInvoice->invoice_number + 1;
        } else{
            $invoiceNumber = (int)siteSetting('invoice_start');
        }

        $invController = new InvoiceController();
        $calculations = $invController->calculateTotals($load);

        Invoice::insert([
            'customer_id' => $load->customer_id,
            'factoring_id' => siteSetting('default_factoring'),
            'load_id' => $load->id,
            'invoice_number' => $invoiceNumber,
            'total_amount' => $calculations['total'],
            'total_balance' => $calculations['grandTotal'],
            'date' => Carbon::now()->toDateString(),
            'due_date' => Carbon::now()->addDays(15)->toDateString(),
            'created_at' => Carbon::now(),
            'status' => 2
        ]);

        return redirect()->route('admin.loadPlanner')->with(['success' => $successMsg]);
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        $request->validate([
            'customer_id' => 'required|numeric|min:1',
            'truck_id' => 'required|numeric|min:1',
            'driver_id' => 'required|numeric|min:1',
            'p_location_id' => 'required',
            'p_date' => 'required',
            'p_time' => 'required',
            'fee_type' => 'required|string|max:100',
            'freight_amount' => 'required|numeric|min:0',
            'stop_off' => 'min:0',
            'tarp_fee' => 'min:0',
            'invoice_advance' => 'min:0',
            'driver_advance' => 'min:0',
            'file_accessorial_invoice' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg',
            'file_rate_confirm' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg',
            'file_bol' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg'
        ]);

        $load = LoadPlanner::where(['id' => $request->id, 'is_deleted' => 0])->first();
        $destinations = array('pickup' => array(), 'consignee' => array());
        $fileRate = $load->file_rate_confirm;
        $fileBol = $load->file_bol;
        $fileAccessorial = $load->fee->file_accessorial_invoice;

        if(isset($request->load_number)){
            $loadNumber = $request->load_number;
        } else{
            $loadNumber = "L".Carbon::now()->timestamp;
        }

        if($request->hasFile('file_accessorial_invoice')){
            $path = Storage::putFile('public/files/load_planners', $request->file_accessorial_invoice);
            $fileAccessorial = str_replace("public/", "", $path);
        }

        if($request->file_rate_confirm){
            $path = Storage::putFile('public/files/load_planners', $request->file_rate_confirm);
            $fileRate = str_replace("public/", "", $path);
        }

        if($request->file_bol){
            $path = Storage::putFile('public/files/load_planners', $request->file_bol);
            $fileBol = str_replace("public/", "", $path);
        }

        foreach($request->p_location_id as $i => $locationIdPickup){
            if($locationIdPickup){
                $date = Carbon::parse($request->p_date[$i])->year."-".Carbon::parse($request->p_date[$i])->month."-".Carbon::parse($request->p_date[$i])->day;
                $time = Carbon::parse($request->p_time[$i])->hour.":".Carbon::parse($request->p_time[$i])->minute.":".Carbon::parse($request->p_time[$i])->second;

                array_push($destinations['consignee'], [
                    'load_id' => $load->id,
                    'location_id' => $locationIdPickup,
                    'date' => $date,
                    'time' => $request->p_time[$i] ? $time : null,
                    'stop_number' => $i+1,
                    'type' => 'pickup'
                ]);
            }
        }

        foreach($request->c_location_id as $i => $locationIdConsignee){
            if($locationIdConsignee){
                $date = Carbon::parse($request->c_date[$i])->year."-".Carbon::parse($request->c_date[$i])->month."-".Carbon::parse($request->c_date[$i])->day;
                $time = Carbon::parse($request->c_time[$i])->hour.":".Carbon::parse($request->c_time[$i])->minute.":".Carbon::parse($request->c_time[$i])->second;

                array_push($destinations['consignee'], [
                    'load_id' => $load->id,
                    'location_id' => $locationIdConsignee,
                    'date' => $date,
                    'time' => $request->c_time[$i] ? $time : null,
                    'stop_number' => $i+1,
                    'type' => 'consignee'
                ]);
            }
        }

        LoadPlanner::where('id', $request->id)->update([
            'load_number' => $loadNumber,
            'customer_id' => $request->customer_id,
            'truck_id' => $request->truck_id,
            'driver_id' => $request->driver_id,
            // 'bol' => $request->bol,
            // 'required_info' => $request->required_info,
            'file_rate_confirm' => $fileRate,
            'file_bol' => $fileBol,
            'status' => $request->status
        ]);

        LoadPlannerFee::where('load_id', $request->id)->update([
            'freight_amount' => $request->freight_amount,
            'fee_type' => $request->fee_type,
            'file_accessorial_invoice' => $fileAccessorial,
            'accessorial_amount' => $request->accessorial_amount,
            'stop_off' => $request->stop_off,
            'tarp_fee' => $request->tarp_fee,
            'invoice_advance' => $request->invoice_advance,
            'driver_advance' => $request->driver_advance
        ]);

        LoadPlannerDestination::where('load_id', $request->id)->delete();

        LoadPlannerDestination::insert($destinations['pickup']);
        LoadPlannerDestination::insert($destinations['consignee']);

        $load = LoadPlanner::where(['id' => $request->id, 'is_deleted' => 0])->first();

        $invController = new InvoiceController();
        $calculations = $invController->calculateTotals($load);

        $invoice = Invoice::where('load_id', $load->id);
        $invoiceDetails = $invoice->first();

        if($invoiceDetails->factoring_fee){
            $deductFactoring = ($inv->total_balance * siteSetting('factoring')) / 100;

            $dataArray = [
                'total_amount' => $calculations['total'],
                'total_balance' => $calculations['grandTotal'],
                'total_w_factoring' => $calculations['grandTotal'] - $deductFactoring,
            ];
        } else{
            $dataArray = [
                'total_amount' => $calculations['total'],
                'total_balance' => $calculations['grandTotal']
            ];
        }

        $invoice->update($dataArray);

        return redirect()->route('admin.loadPlanner')->with(['success' => 'Load has been updated!']);
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function uploadMissingFiles(Request $request){
        $request->validate([
            'load_id' => 'required|numeric|min:1',
            'file_rate_confirm' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg',
            'file_bol' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg'
        ]);

        if($request->file_rate_confirm){
            $pathRC = Storage::putFile('public/files/load_planners', $request->file_rate_confirm);
            $fileRate = str_replace("public/", "", $pathRC);
        }

        if($request->file_bol){
            $pathBL = Storage::putFile('public/files/load_planners', $request->file_bol);
            $fileBol = str_replace("public/", "", $pathBL);
        }

        LoadPlanner::where('id', $request->load_id)->update([
            'file_rate_confirm' => $fileRate,
            'file_bol' => $fileBol
        ]);

        return redirect()->back()->with(['success' => 'Files have been attached to the load. It is now removed from the missing files alert!']);
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

        $load = LoadPlanner::where('id', $request->delete_trace);
        $load->update(['is_deleted' => 1]);
        $load = $load->first();

        $html = "<a href=\"".route('admin.loadPlanner.details', ['id' => $request->delete_trace])."\" class=\"text-dark\" target=\"_blank\">
        <h4><i class=\"bi bi-truck fs-3 text-dark\"></i> Load Planner</h4>
        <p>{$load->load_number} | {$load->customer->name} | $".$load->fee->freight_amount."</p></a>";

        TrashController::create([
            'module_name' => 'LoadPlanner',
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
        Invoice::where('load_id', $id)->delete();
        LoadPlanner::where('id', $id)->delete();

        return true;
    }

    /**
     * Updates a specific record from the database.
     *
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function markAsCompleted(Request $request){
        $request->validate(['id' => 'required|numeric|min:1']);

        LoadPlanner::where('id', $request->id)->update(['status' => 1]);

        return redirect()->route('admin.loadPlanner')->with(['success' => 'Load has been marked as completed!']);
    }
}
