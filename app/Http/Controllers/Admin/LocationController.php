<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Truck;
use App\Models\City;

class LocationController extends Controller{
    /**
     * Show the application location-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('admin.locations.location-list');
    }

    /**
     * Fetches the records and format them for 
     * datatable pagination.
     * 
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\ResponseJson
     */
    public function fetchAjax(Request $request){
        $data = array();
        $search = $request->search['value'];

        $locations = new Location();

        $recordsTotal = $locations->count();
        
        if($search){
            $locations = $locations->where('name', 'LIKE', '%'.$search.'%');
        }

        $recordsFiltered = $locations->count();

        $locations = $locations->where('is_deleted', 0)->skip($request->start)->take($request->length)->get();

        foreach($locations as $location){
            array_push($data, [
                'id' => $location->id,
                'name' => $location->name,
                'type' => $location->type,
                'city' => $location->city_id ? $location->city->name : '',
                'state' => $location->state_id ? $location->state->name : '',
                'zip' => $location->zip,
                'status' => $location->status
            ]);
        }

        $response = [
            'draw' => (int) $request->draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    /**
     * Fetches all the locations and send them
     * formatted into json response.
     * 
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\ResponseJson
     */
    public function fetchLocations(Request $request){
        $data = array();
        $locations = new Location();
        $locations = $locations->where(['status' => 1, 'is_deleted' => 0]);

        if(isset($request->q)){
            $locations = $locations->where('name', 'LIKE', '%'.$request->q.'%');
        }
        
        $locations = $locations->get();

        foreach($locations as $location){
            array_push($data, [
                'id' => $location->id, 
                'name' => $location->name,
                'city' => $location->city_id ? $location->city->name : '',
                'state' => $location->state_id ? $location->state->name : '',
            ]);
        }

        return response()->json($data, 200);
    }
	
	
	public function fetchAllLocations(){
        $data = array();
        $locations = new Location();
        $locations = $locations->where(['status' => 1, 'is_deleted' => 0]);

        // if(isset($request->q)){
            // $locations = $locations->where('name', 'LIKE', '%'.$request->q.'%');
        // }
        
        $locations = $locations->get();

        foreach($locations as $location){
            array_push($data, [
                'id' => $location->id, 
                'name' => $location->name,
                'city' => $location->city_id ? $location->city->name : '',
                'state' => $location->state_id ? $location->state->name : '',
            ]);
        }

        return response()->json($data, 200);
    }

    /**
     * Show the application location-add view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(){
        return view('admin.locations.location-add');
    }

    /**
     * Show the application location-details view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDetails($id){
        $location = Location::where('id', $id)->first();

        return view('admin.locations.location-details', compact('location'));
    }

    /**
     * Show the application location-edit view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $location = Location::where('id', $id)->first();

        return view('admin.locations.location-edit', compact('location'));
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
            'name' => 'required|string|max:255',
            'state_id' => 'nullable|numeric|min:1',
            'city_id' => 'nullable|numeric|min:1'
        ]);

        $state = City::where('id', $request->city_id)->select('state_id')->first();

        $location = Location::create([
            'name' => $request->name,
            'type' => 'Direct',
            'street' => $request->street,
            'suite' => $request->suite,
            'state_id' => $request->state_id ? $request->state_id : ($state ? $state->state_id : null),
            'city_id' => $request->city_id,
            'zip' => $request->zip,
            'lat' => $request->latitude,
            'lng' => $request->longitude,
            'phone' => $request->phone,
            'status' => 1
        ]);

        if($request->server('HTTP_X_REQUESTED_WITH')){
            return response()->json(['id' => $location->id, 'name' => $location->name], 200);
        } else{
            return redirect()->route('admin.location')->with(['success' => 'A new location has been added!']);
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
            'name' => 'required|string|max:255',
            'state_id' => 'required|numeric|min:1',
            'city_id' => 'required|numeric|min:1'
        ]);

        Location::where('id', $request->id)->update([
            'name' => $request->name,
            'type' => 'Direct',
            'street' => $request->street,
            'suite' => $request->suite,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'zip' => $request->zip,
            'lat' => $request->latitude,
            'lng' => $request->longitude,
            'phone' => $request->phone,
            'status' => ($request->status == '1' || $request->status == 'true')? 1 : 0
        ]);

        return redirect()->route('admin.location')->with(['success' => 'Location has been updated!']);
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

        Location::where('id', $request->delete_trace)->delete();

        $location = Location::where('id', $request->delete_trace);
        $location->update(['is_deleted' => 1]);
        $location = $location->first();

        $html = "<h4><i class=\"bi bi-geo-alt fs-3 text-dark\"></i> Location</h4>
        <p>{$location->name} | ".($location->city_id ? $location->city->name : "").", ".($location->state_id ? $location->state->name : "")." | {$location->street}</p>";

        TrashController::create([
            'module_name' => 'Location',
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
        Location::where('id', $id)->delete();

        return true;
    }

    /**
     * Fetches details about the location.
     * 
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\ResponseJson
     */
    public function fetchLocation(Request $request){
        $locationArr = array();
        $locations = Location::where('is_deleted', 0)->whereIn('id', $request->id)->get();

        foreach($locations as $location){
            array_push($locationArr, [
                'id' => $location->id,
                'name' => $location->name,
                'lat' => $location->lat,
                'lng' => $location->lng
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $locationArr
        ], 200);
    }

    /**
     * Import's and Creates new records in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    // public function importSheet(Request $request){
    //     $allLocations = Location::all();
    //     $excelSheet = null;

    //     if($request->hasFile('file_excel')){
    //         $path = \Storage::putFile('public/temp', $request->file_excel);
    //         $excelSheet = str_replace("public/", "", $path); 
    //     }

    //     \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\LocationImport($allLocations), $path);

    //     unlink(public_path().'/storage/'.$excelSheet);

    //     return redirect()->back()->with(['success' => 'Excel sheet has been imported!']);
    // }
}