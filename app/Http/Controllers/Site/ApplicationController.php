<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ApplicationDetail;
use App\Models\ApplicationAddress;
use App\Models\ApplicationDrugInfo;
use App\Models\ApplicationExperience;
use App\Models\ApplicationLogProgram;
use App\Models\ApplicationWorkHistory;
use App\Models\ApplicationEmergencyInfo;
use App\Models\ApplicationAccidentRecord;
use App\Models\ApplicationPhysicalHistory;
use App\Models\ApplicationExperienceVehicle;
use App\Models\ApplicationViolationCertificate;

class ApplicationController extends Controller{
    /**
     * Shows the application apply-now view.
     *
     * @return \Illuminate\View\View
     */
    public function index(){
        return view('site.apply-now');
    }

    /**
     * Creates a new entry in the database.
     * 
     * @param Illuminate\Http\Request - $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $applicationAddress = array();
        $experienceVehicle = array();

        $application = Application::create([
            'name' => $request->name,
            'date' => $request->date,
            'company_apply' => $request->company_apply,
            'position' => $request->position,
            'referred_by' => $request->referred_by,
            'ssn' => $request->ssn,
            'dob' => $request->dob,
            'address' => $request->full_address,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'cdl' => $request->cdl,
            'cdl_expiry' => $request->cdl_expiry,
            'home_phone' => $request->home_phone,
            'work_phone' => $request->work_phone,
            'cell_phone' => $request->cell_phone,
            'email' => $request->email
        ]);

        if(isset($request->address)){
            foreach($request->address as $i => $address){
                array_push($applicationAddress, [
                    'application_id' => $application->id,
                    'address' => $address,
                    'how_long' => $request->how_long[$i]
                ]);
            }
        }

        foreach($request->vehicle_name as $vehicleName){
            array_push($experienceVehicle, ['application_id' => $application->id, 'vehicle_name' => $vehicleName]);
        }
        
        ApplicationAccidentRecord::create([
            'application_id' => $application->id,
            'accident_records' => $request->accident_records,
            'traffic_convictions' => $request->traffic_convictions,
            'signed_at' => now()
        ]);

        ApplicationAddress::insert($applicationAddress);

        ApplicationDetail::create([
            'application_id' => $application->id,
            'right_to_work' => $request->right_to_work,
            'working' => $request->working,
            'since_job' => $request->since_job
        ]);
        
        ApplicationDrugInfo::create([
            'application_id' => $application->id,
            'q_id_number' => $request->q_id_number,
            'signed_at' => now()
        ]);

        ApplicationEmergencyInfo::create([
            'application_id' => $application->id,
            'em_name' => $request->em_name,
            'em_phone' => $request->em_phone
        ]);

        ApplicationExperience::create([
            'application_id' => $application->id,
            'license_lines' => $request->license_lines,
            'license_denied' => $request->license_denied,
            'license_revoked' => $request->license_revoked,
            'driver_since' => $request->driver_since,
            'years_experience' => $request->years_experience
        ]);

        ApplicationExperienceVehicle::insert($experienceVehicle);
        
        ApplicationLogProgram::create([
            'application_id' => $application->id,
            'lp_driver_name' => $request->lp_driver_name,
            'lp_cdl_num' => $request->lp_cdl_num,
            'lp_carrier' => $request->lp_carrier,
            'signed_at' => now()
        ]);
        
        ApplicationPhysicalHistory::create([
            'application_id' => $application->id,
            'physical_condition' => $request->physical_condition,
            'tested_drugs' => $request->tested_drugs,
            'year_tested' => $request->year_tested,
            'condition_explain' => $request->condition_explain
        ]);
        
        ApplicationViolationCertificate::create([
            'application_id' => $application->id,
            'cv_driver_name' => $request->cv_driver_name,
            'cv_ssn' => $request->cv_ssn,
            'cv_service_date' => $request->cv_service_date,
            'cv_license' => $request->cv_license,
            'cv_state_id' => $request->cv_state_id,
            'cv_expiration' => $request->cv_expiration,
            'cv_home_terminal' => $request->cv_home_terminal,
            'cv_any_violations' => $request->cv_any_violations,
            'cv_details' => $request->cv_details,
            'signed_at' => now()
        ]);
        
        ApplicationWorkHistory::create([
            'application_id' => $application->id,
            'his_name' => $request->his_name,
            'his_date' => $request->his_date,
            'his_company_apply' => $request->his_company_apply,
            'his_first_date' => $request->his_first_date,
            'his_date_from' => $request->his_date_from,
            'his_date_to' => $request->his_date_to,
            'subject_fmcsr' => $request->subject_fmcsr,
            'safety_sensitive' => $request->safety_sensitive,
            'his_company_name' => $request->his_company_name,
            'his_position_held' => $request->his_position_held,
            'his_address' => $request->his_address,
            'his_reason_leaving' => $request->his_reason_leaving,
            'his_supervisor' => $request->his_supervisor,
            'his_phone' => $request->his_phone,
            'his_fax' => $request->his_fax,
            'signed_at' => now()
        ]);

        if($application){
            return response()->json(['status' => true], 200);
        } else{
            return response()->json(['status' => false], 200);
        }
    }
}