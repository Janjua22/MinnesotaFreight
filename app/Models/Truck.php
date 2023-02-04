<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trucks';

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
        'truck_number', 
        'type_id', 
        'ownership', 
        'city_id', 
        'last_inspection', 
        'vin_number', 
        'plate_number', 
        'note', 
        'is_deleted', 
        'status'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the trucks assigned for the this driver.
     */
    public function driverAssigned(){
        return $this->hasOne('App\Models\DriverDetail', 'truck_assigned');
    }

    /**
     * Get the city associated with this model.
     */
    public function city(){
        return $this->belongsTo('App\Models\City');
    }

    /**
     * Get the trucks assigned for the this driver.
     */
    public function fuelExpenses(){
        return $this->hasMany('App\Models\FuelExpense');
    }

    /**
     * Get the loads associated with this model.
     */
    public function loads(){
        return $this->hasMany('App\Models\LoadPlanner');
    }
}