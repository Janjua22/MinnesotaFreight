<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'expenses';

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
        'category_id', 
        'date', 
        'amount', 
        'truck_id', 
        'load_id', 
        'gallons', 
        'odometer', 
        'note',
        'is_deleted'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the expense category associated with this model.
     */
    public function category(){
        return $this->belongsTo('App\Models\ExpenseCategory', 'category_id');
    }

    /**
     * Get the truck associated with this model.
     */
    public function truck(){
        return $this->belongsTo('App\Models\Truck', 'truck_id');
    }

    /**
     * Get the load associated with this model.
     */
    public function loadPlanner(){
        return $this->belongsTo('App\Models\LoadPlanner', 'load_id');
    }
}
