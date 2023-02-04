<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Invoice;
use App\Models\DriverDetail;
use App\Models\DriverLicenseInfo;
use App\Models\DriverSettlement;
use App\Models\LoadPlanner;
use App\Models\Customer;
use App\Models\ContactUs;
use Carbon\Carbon;

class HomeController extends Controller{
    /**
     * Show the application dashboard view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $from = date_format(Carbon::now(), 'Y-m-d');
        $to = date_format(Carbon::now()->addMonth(), 'Y-m-d');

        $data = [
            'drivers' => DriverDetail::all()->count(),
            'trucks' => Truck::all()->count(),
            'loads' => LoadPlanner::where('is_deleted', 0)->count(),
            'settlements' => DriverSettlement::all()->count(),
            'invoices' => Invoice::all()->count(),
            'customers' => Customer::all()->count(),
            'queries' => ContactUs::all()->count(),
            'missingFiles' => 0,
            'missingFileDrivers' => 0
        ];

        $loads = LoadPlanner::where('is_deleted', 0)->get();
        $drivers = DriverLicenseInfo::all();

        foreach($loads as $load){
            if($load->file_rate_confirm == null || $load->file_bol == null){
                $data['missingFiles']++;
            }
        }

        foreach($drivers as $driver){
            if($driver->file_license == null || $driver->file_medical == null){
                $data['missingFileDrivers']++;
            }
        }

        return view('admin.dashboard', compact('data', 'loads'));
    }
}