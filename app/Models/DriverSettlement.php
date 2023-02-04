<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverSettlement extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driver_settlements';

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
        'driver_id', 
        'selected_trips',
        'total_trips', 
        'paid_date',
        'gross_amount',
        'deduction_amount',
        'paid_amount',
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
     * Get the driver associated with the this record.
     */
    public function driver(){
        return $this->belongsTo('App\Models\DriverDetail', 'driver_id', 'user_id');
    }

    /**
     * Get the driver associated with the this record.
     */
    public function additionalSettlements(){
        return $this->hasMany('App\Models\DriverAdditionalDeduction', 'settlement_id');
    }

    /**
     * Fetches all the loads belongs to this record.
     * 
     * @return object
     */
    public function loads(): object{
        return LoadPlanner::whereIn('id', explode(",", $this->selected_trips))->get();
    }
}