<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;

class StateCityController extends Controller{
    /**
     * Show the application invoice-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('admin.state-city.state-city-list');
    }

    /**
     * Fetches the records and format them for 
     * datatable pagination.
     * 
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\ResponseJson
     */
    public function fetchStatesJson(Request $request){
        $data = array();
        $search = $request->search['value'];

        $state = new State();

        $state = $state->where('country_id', 231);
        $recordsTotal = $state->count();
        
        if($search){
            $state = $state->where('name', 'LIKE', '%'.$search.'%');
        }

        $recordsFiltered = $state->count();

        $state = $state->skip($request->start)->take($request->length)->get();

        foreach($state as $st){
            array_push($data, ['id' => $st->id, 'name' => $st->name]);
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
     * Fetches the records and format them for 
     * datatable pagination.
     * 
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\ResponseJson
     */
    public function fetchCitiesJson(Request $request){
        $data = array();
        $search = $request->search['value'];

        $states = State::where('country_id', 231)->pluck('id');

        $cities = new City();

        $cities = $cities->whereIn('state_id', $states);
        $recordsTotal = $cities->count();
        
        if($search){
            $cities = $cities->where('name', 'LIKE', '%'.$search.'%');
        }

        $recordsFiltered = $cities->count();

        $cities = $cities->skip($request->start)->take($request->length)->get();

        foreach($cities as $city){
            array_push($data, [
                'id' => $city->id, 
                'name' => $city->name,
                'state_id' => $city->state_id,
                'state_name' => $city->state->name
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
     * Creates a new record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function createState(Request $request){
        $request->validate(['name' => 'required|string|max:255']);

        State::create(['name' => $request->name, 'country_id' => 231]);
        
        return redirect()->back()->with(['success' => 'A new state has been added!']);
    }

    /**
     * Creates a new record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function createCity(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|numeric|min:1'
        ]);

        $city = City::create(['name' => $request->name, 'state_id' => $request->state_id]);

        if($request->server('HTTP_X_REQUESTED_WITH')){
            return response()->json(['id' => $city->id, 'name' => $city->name], 200);
        } else{
            return redirect()->back()->with(['success' => 'A new city has been added!']);
        }
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function updateState(Request $request){
        $request->validate([
            'state_id' => 'required|numeric|min:1',
            'state_name' => 'required|string|max:255'
        ]);

        State::where('id', $request->state_id)->update(['name' => $request->state_name]);
        
        return redirect()->back()->with(['success' => 'State has been updated!']);
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function updateCity(Request $request){
        $request->validate([
            'city_id' => 'required|numeric|min:1',
            'city_name' => 'required|string|max:255',
            'state_id' => 'required|numeric|min:1'
        ]);

        City::where('id', $request->city_id)->update(['name' => $request->city_name, 'state_id' => $request->state_id]);
        
        return redirect()->back()->with(['success' => 'City has been updated!']);
    }
}