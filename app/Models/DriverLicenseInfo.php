<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverLicenseInfo extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driver_license_infos';

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
        'license_number', 
        'expiration', 
        'issue_state',
        'file_license',
        'file_medical'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the state associated with this model.
     */
    public function state(){
        return $this->belongsTo('App\Models\State', 'issue_state');
    }

    /**
     * Get the user who owns this record.
     */
    public function userDetails(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}