<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;

class GlobalResourcesController extends Controller{
    /**
     * This method fetches states by country_id provided 
     * by the request.
     * 
     * @param Illuminate\Http\Request - $request request's data
     * 
     * @return Illuminate\Contracts\Routing\ResponseFactory JSON
     */
    public function fetchStatesByCountry(Request $request){
        $states = State::where(['country_id' => $request->id])->get();

        return response()->json(['data' => $states]);
    }

    /**
     * This method fetches cities by state_id provided 
     * by the request.
     * 
     * @param Illuminate\Http\Request - $request request's data
     * 
     * @return Illuminate\Contracts\Routing\ResponseFactory JSON
     */
    public function fetchCitiesByState(Request $request){
        $cities = City::where(['state_id' => $request->id])->get();

        return response()->json(['data' => $cities]);
    }

    /**
     * Searches for a city in all the US states.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\ResponseJson
     */
    public function searchCityByKeyword(Request $request){
        $results = array();

        $states = State::where('country_id', 231)->select('id')->get();
        $cities = City::whereIn('state_id', $states)->where('name', 'LIKE', '%'.$request->q.'%')->get();

        foreach($cities as $city){
            array_push($results, [
                'id' => $city->id,
                'city' => $city->name, 
                'state' => $city->state->name
            ]);
        }
        
        return response()->json($results, 200);
    }
}