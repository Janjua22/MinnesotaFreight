<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadPlanner extends Model{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'load_planners';

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
        'load_number', 
        'customer_id', 
        'truck_id', 
        'driver_id', 
        'bol', 
        'required_info', 
        'file_rate_confirm', 
        'file_bol', 
        'invoiced', 
        'is_deleted', 
        'settlement', 
        'status'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the destinations assigned for the this load.
     */
    public function destinations(){
        return $this->hasMany('App\Models\LoadPlannerDestination', 'load_id');
    }

    /**
     * Get the customer associated with the this load.
     */
    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    /**
     * Get the fee record assigned to this load.
     */
    public function fee(){
        return $this->hasOne('App\Models\LoadPlannerFee', 'load_id');
    }

    /**
     * Get the invoice associated with the this load.
     */
    public function invoice(){
        return $this->hasOne('App\Models\Invoice', 'load_id');
    }

    /**
     * Get the truck associated with the this load.
     */
    public function truck(){
        return $this->belongsTo('App\Models\Truck', 'truck_id');
    }

    /**
     * Get the driver associated with the this load.
     */
    public function driver(){
        return $this->belongsTo('App\Models\DriverDetail', 'driver_id');
    }
}