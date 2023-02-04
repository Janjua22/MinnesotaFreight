<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelExpense extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fuel_expenses';

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
        'sheet_id', 
        'truck_id', 
        'load_id', 
        'date', 
        'state_code', 
        'location_name', 
        'fee', 
        'unit_price', 
        'volume', 
        'fuel_type',
        'amount',
        'total',
        'settled'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = ['settled_at' => 'datetime'];

    /**
     * Get the truck associated with this model.
     */
    public function truck(){
        return $this->belongsTo('App\Models\Truck');
    }

    /**
     * Get the load associated with this model.
     */
    public function loadPlanner(){
        return $this->belongsTo('App\Models\LoadPlanner', 'load_id');
    }
}