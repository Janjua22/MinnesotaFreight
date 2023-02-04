<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications';

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
        'date', 
        'company_apply', 
        'position', 
        'referred_by', 
        'ssn', 
        'dob', 
        'address', 
        'state_id', 
        'city_id', 
        'cdl', 
        'cdl_expiry', 
        'home_phone', 
        'work_phone', 
        'cell_phone', 
        'email',
        'is_deleted'
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

    /**
     * Get the emergency info assigned for this application.
     */
    public function emergencyInfo(){
        return $this->hasOne('App\Models\ApplicationEmergencyInfo');
    }

    /**
     * Get the addresses info assigned for this application.
     */
    public function addresses(){
        return $this->hasMany('App\Models\ApplicationAddress');
    }

    /**
     * Get the details assigned for this application.
     */
    public function details(){
        return $this->hasOne('App\Models\ApplicationDetail');
    }

    /**
     * Get the physical history assigned for this application.
     */
    public function physicalHistory(){
        return $this->hasOne('App\Models\ApplicationPhysicalHistory');
    }

    /**
     * Get the experience assigned for this application.
     */
    public function experience(){
        return $this->hasOne('App\Models\ApplicationExperience');
    }

    /**
     * Get the experienceVehicles info assigned for this application.
     */
    public function experienceVehicles(){
        return $this->hasMany('App\Models\ApplicationExperienceVehicle');
    }

    /**
     * Get the accident record assigned for this application.
     */
    public function accidentRecord(){
        return $this->hasOne('App\Models\ApplicationAccidentRecord');
    }

    /**
     * Get the work history assigned for this application.
     */
    public function workHistory(){
        return $this->hasOne('App\Models\ApplicationWorkHistory');
    }

    /**
     * Get the log program assigned for this application.
     */
    public function logProgram(){
        return $this->hasOne('App\Models\ApplicationLogProgram');
    }

    /**
     * Get the violation certificate assigned for this application.
     */
    public function violationCertificate(){
        return $this->hasOne('App\Models\ApplicationViolationCertificate');
    }

    /**
     * Get the drug info assigned for this application.
     */
    public function drugInfo(){
        return $this->hasOne('App\Models\ApplicationDrugInfo');
    }
}