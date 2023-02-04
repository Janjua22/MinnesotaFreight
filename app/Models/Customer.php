<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

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
        'name', 
        'type', 
        'street', 
        'suite', 
        'state_id', 
        'city_id', 
        'zip', 
        'lat',
        'lng',
        'phone', 
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
}