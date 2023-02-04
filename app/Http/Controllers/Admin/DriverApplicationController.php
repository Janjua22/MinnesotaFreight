<?php

namespace App\Http\Controllers\Admin;

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

class DriverApplicationController extends Controller{
    /**
     * Shows the application driver-application view.
     *
     * @return \Illuminate\View\View
     */
    public function index(){
        $applications = Application::where('is_deleted', 0)->get();

        return view('admin.driver-applications.driver-application-list', compact('applications'));
    }

    /**
     * Show the application driver-application-details view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDetails($id){
        $application = Application::where('id', $id)->first();

        return view('admin.driver-applications.driver-application-details', compact('application'));
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request){
        $request->validate(['delete_trace' => 'required|numeric|min:1']);

        $application = Application::where('id', $request->delete_trace);
        $application->update(['is_deleted' => 1]);

        $application = $application->first();

        $html = "<h4><i class=\"bi bi-chat-right-text fs-3 text-dark\"></i>Driver Application</h4>
        <p>{$application->name} | {$application->email} | {$application->cell_phone}</p>";

        TrashController::create([
            'module_name' => 'DriverApplication',
            'row_id' => $request->delete_trace,
            'description' => $html
        ]);

        return redirect()->back();
    }

    /**
     * Removes a specific record from the database.
     *
     * @param int - $id
     * 
     * @return bool
     */
    public function permenantDelete(int $id): bool{
        ApplicationAccidentRecord::where('application_id', $id)->delete();
        ApplicationAddress::where('application_id', $id)->delete();
        ApplicationDetail::where('application_id', $id)->delete();
        ApplicationDrugInfo::where('application_id', $id)->delete();
        ApplicationEmergencyInfo::where('application_id', $id)->delete();
        ApplicationExperience::where('application_id', $id)->delete();
        ApplicationExperienceVehicle::where('application_id', $id)->delete();
        ApplicationLogProgram::where('application_id', $id)->delete();
        ApplicationPhysicalHistory::where('application_id', $id)->delete();
        ApplicationViolationCertificate::where('application_id', $id)->delete();
        ApplicationWorkHistory::where('application_id', $id)->delete();

        Application::where('id', $id)->delete();

        return true;
    }
}