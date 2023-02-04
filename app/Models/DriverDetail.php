<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverDetail extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driver_details';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'street', 
        'suite', 
        'state_id', 
        'city_id', 
        'zip', 
        'payment_type', 
        'manual_pay', 
        'off_mile_fee',
        'on_mile_fee',
        'off_mile_range',
        'pay_percent',
        'med_renewal',
        'hired_at',
        'fired_at',
        'truck_assigned',
        'auto_deduct', 
        'deduction_date', 
        'is_deleted'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the city associated with this model.
     */
    public function city(){
        return $this->belongsTo('App\Models\City');
    }

    /**
     * Get the state associated with this model.
     */
    public function state(){
        return $this->belongsTo('App\Models\State');
    }
    
    /**
     * Get the user who owns this record.
     */
    public function userDetails(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Get the emergency info assigned for the this driver.
     */
    public function emergencyInfo(){
        return $this->hasOne('App\Models\DriverEmergencyInfo', 'user_id', 'user_id');
    }

    /**
     * Get thelicense info assigned for the this driver.
     */
    public function licenseInfo(){
        return $this->hasOne('App\Models\DriverLicenseInfo', 'user_id', 'user_id');
    }

    /**
     * Get the trucks assigned for the this driver.
     */
    public function truckAssigned(){
        return $this->belongsTo('App\Models\Truck', 'truck_assigned');
    }

    /**
     * Get the emergency info assigned for the this driver.
     */
    public function recurringDeductions(){
        return $this->hasMany('App\Models\DriverRecurringDeduction', 'user_id', 'user_id');
    }
}