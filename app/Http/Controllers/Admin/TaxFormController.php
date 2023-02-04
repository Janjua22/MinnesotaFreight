<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverSettlement;
use App\Models\User;

class TaxFormController extends Controller{
    /**
     * Show the application 1099-form view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        $drivers = User::where(['role_id' => 2, 'status' => 1])->get();
        $taxData = null;

        if($request->driver && $request->year){
            $from = $request->year.'-01-01';
            $to = $request->year.'-12-31';
            
            $settlements = DriverSettlement::where(['driver_id' => $request->driver, 'status' => 1])->whereBetween('paid_date', [$from, $to])->get();

            if($settlements->count()){
                $taxData = [
                    'settlement' => 0,
                    'name' => $settlements[0]->driver->userDetails->first_name." ".$settlements[0]->driver->userDetails->last_name,
                    'street' => $settlements[0]->driver->street,
                    'address' => $settlements[0]->driver->city->name.", ".$settlements[0]->driver->state->name.", ".$settlements[0]->driver->zip
                ];

                foreach($settlements as $settlement){
                    $taxData['settlement'] += $settlement->paid_amount;
                }
            }
        }

        return view('admin.1099-form.1099-form', compact('drivers', 'taxData'));
    }
}