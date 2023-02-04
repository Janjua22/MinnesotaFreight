<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Location;
use App\Models\State;
use App\Models\City;

class TruckController extends Controller{
    /**
     * Show the application truck-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $trucks = Truck::where('is_deleted', 0)->get();

        return view('admin.trucks.truck-list', compact('trucks'));
    }

    /**
     * Show the application truck-add view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(){
        return view('admin.trucks.truck-add');
    }

    /**
     * Show the application truck-edit view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $truck = Truck::where(['id' => $id, 'is_deleted' => 0])->first();

        if(!$truck){
            abort(404);
        }

        return view('admin.trucks.truck-edit', compact('truck'));
    }

    /**
     * Fetch the active loads of a truck.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTruckLoads(Request $request){
        $truck = Truck::where('id', $request->truck_id)->first();
        $activeLoads = array();

        foreach($truck->loads as $load){
            if($load->settlement == 0){
                array_push($activeLoads, [
                    'id' => $load->id,
                    'load_number' => $load->load_number
                ]);
            }
        }

        return response()->json($activeLoads, 200);
    }

    /**
     * Creates a new record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){
        $request->validate([
            'truck_number' => 'required|string|max:100|unique:trucks',
            'truck_type' => 'required|numeric|min:1',
            'city_id' => 'required|numeric|min:1',
            'vin_number' => 'nullable|string|max:100',
            'plate_number' => 'nullable|string|max:100',
            'status' => 'required|numeric',
            'note' => 'max:255'
        ]);

        $truck = Truck::create([
            'truck_number' => $request->truck_number,
            'type_id' => $request->truck_type,
            'ownership' => $request->ownership,
            'city_id' => $request->city_id,
            'last_inspection' => $request->last_inspection,
            'vin_number' => $request->vin_number,
            'plate_number' => $request->plate_number,
            'note' => $request->note,
            'status' => $request->status
        ]);

        if($request->server('HTTP_X_REQUESTED_WITH')){
            return response()->json(['id' => $truck->id, 'name' => $truck->truck_number], 200);
        } else{
            return redirect()->route('admin.truck')->with(['success' => 'A new truck has been added!']);
        }
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
            'truck_type' => 'required|numeric|min:1',
            'city_id' => 'required|numeric|min:1',
            'vin_number' => 'nullable|string|max:100',
            'plate_number' => 'nullable|string|max:100',
            'status' => 'required|numeric',
            'note' => 'max:255'
        ]);

        Truck::where('id', $request->id)->update([
            'type_id' => $request->truck_type,
            'ownership' => $request->ownership,
            'city_id' => $request->city_id,
            'last_inspection' => $request->last_inspection,
            'vin_number' => $request->vin_number,
            'plate_number' => $request->plate_number,
            'note' => $request->note,
            'status' => $request->status
        ]);

        return redirect()->route('admin.truck')->with(['success' => 'Truck has been updated!']);
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

        $truck = Truck::where('id', $request->delete_trace);

        $data = $truck->first();

        if($data->driverAssigned){
            return redirect()->back()->withErrors(['message' => 'Cannot delete this truck. It is assigned to a driver!']);
        } else{
            $truck->update(['is_deleted' => 1]);
            $truck = $truck->first();

            $html = "<h4><i class=\"bi bi-truck-flatbed fs-3 text-dark\"></i> Truck</h4>
            <p>truck # {$truck->truck_number} | VIN: {$truck->vin_number} | {$truck->city->name}, {$truck->city->state->name}</p>";

            TrashController::create([
                'module_name' => 'Truck',
                'row_id' => $request->delete_trace,
                'description' => $html
            ]);

            return redirect()->back();
        }
    }

    /**
     * Removes a specific record from the database.
     *
     * @param int - $id
     * 
     * @return bool
     */
    public function permenantDelete(int $id): bool{
        Truck::where('id', $id)->delete();

        return true;
    }

    /**
     * Import's and Creates new records in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    // public function importSheet(Request $request){
    //     $excelSheet = null;

    //     if($request->hasFile('file_excel')){
    //         $path = \Storage::putFile('public/temp', $request->file_excel);
    //         $excelSheet = str_replace("public/", "", $path); 
    //     }

    //     \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\TruckImport(), $path);

    //     unlink(public_path().'/storage/'.$excelSheet);

    //     return redirect()->back()->with(['success' => 'Excel sheet has been imported!']);
    // }
}