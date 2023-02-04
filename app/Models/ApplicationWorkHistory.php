<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationWorkHistory extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'application_work_histories';

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
        'application_id', 
        'his_name', 
        'his_date', 
        'his_company_apply', 
        'his_first_date', 
        'his_date_from', 
        'his_date_to', 
        'subject_fmcsr', 
        'safety_sensitive', 
        'his_company_name', 
        'his_position_held', 
        'his_address', 
        'his_reason_leaving', 
        'his_supervisor', 
        'his_phone', 
        'his_fax', 
        'signed_at'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = ['signed_at' => 'datetime'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}