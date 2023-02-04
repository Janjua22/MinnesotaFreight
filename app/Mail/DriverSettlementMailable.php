<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Truck;
use App\Models\LoadPlanner;
use App\Models\DriverSettlement;

class DriverSettlementMailable extends Mailable{
    use Queueable, SerializesModels;

    /**
     * Driver settlement ID
     * 
     * @var int
     */
    private int $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $id){
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        $driverSettlement = DriverSettlement::where('id', $this->id)->first();
        $loads = LoadPlanner::whereIn('id', explode(",", $driverSettlement->selected_trips))->get();
        $truckIds = array();

        foreach($loads as $load){
            if(!in_array($load->truck_id, $truckIds)){
                array_push($truckIds, $load->truck_id);
            }
        }

        $trucksUsed = Truck::whereIn('id', $truckIds)->get();

        return $this->view('admin.driver-settlements.driver-settlement-print', compact('driverSettlement', 'loads', 'trucksUsed'))->subject('Driver Settlement');
    }
}