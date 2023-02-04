<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DriverDetail;
use App\Models\DriverLicenseInfo;
use App\Models\DriverEmergencyInfo;
use App\Models\DriverRecurringDeduction;
use App\Models\RecurringDeduction;
use App\Models\Location;
use App\Models\Truck;
use Carbon\Carbon;
use Storage;
use Image;

class DriverController extends Controller{
    /**
     * Show the application driver-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $drivers = DriverDetail::where('is_deleted', 0)->get();

        return view('admin.drivers.driver-list', compact('drivers'));
    }

    /**
     * Show the application driver-add view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(){
        $trucks = Truck::where(['is_deleted' => 0, 'status' => 1])->get();
        $locations = Location::where(['is_deleted' => 0, 'status' => 1])->get();
        $recurrings = RecurringDeduction::all();

        return view('admin.drivers.driver-add', compact('trucks', 'locations', 'recurrings'));
    }

    /**
     * Show the application driver-details view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDetails($id){
        $driver = DriverDetail::where(['id' => $id, 'is_deleted' => 0])->first();

        if(!$driver){
            abort(404);
        }

        return view('admin.drivers.driver-details', compact('driver'));
    }

    /**
     * Show the application driver-edit view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $driver = DriverDetail::where('id', $id)->first();
        $trucks = Truck::where(['is_deleted' => 0, 'status' => 1])->get();
        $recurrings = RecurringDeduction::all();

        return view('admin.drivers.driver-edit', compact('driver', 'trucks', 'recurrings'));
    }

    /**
     * Show the application driver-missing view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showMissingFiles(){
        $drivers = DriverLicenseInfo::all();

        $missingFiles = array();

        foreach($drivers as $driver){
            if($driver->file_license == null || $driver->file_medical == null){
                array_push($missingFiles, [
                    'image' => asset(Storage::url($driver->userDetails->image)),
                    'name' => $driver->userDetails->first_name." ".$driver->userDetails->last_name,
                    'email' => $driver->userDetails->email,
                    'phone' => $driver->userDetails->phone,
                    'license_number' => $driver->license_number,
                    'created_at' => date_format($driver->userDetails->created_at, "M d, Y"),
                    'status' => $driver->userDetails->status,
                    'url' => route('admin.driver.edit', ['id' => $driver->userDetails->id])

                ]);
            }
        }

        return view('admin.drivers.driver-missing', compact('missingFiles'));
    }

    /**
     * Creates a new record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'truck_id' => 'required|numeric|min:1',
            'state_id' => 'required|numeric|min:1',
            'city_id' => 'required|numeric|min:1',
            'phone' => 'required|string|max:100',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|min:8',
            'payment_type' => 'required|numeric|min:1',
            'license_number' => 'required|string|max:100',
            'expiration' => 'required|string|max:100',
            'med_renewal' => 'required|string|max:100',
            'file_license' => 'nullable|mimes:png,jpg,jpeg,doc,docx,pdf',
            'file_medical' => 'nullable|mimes:png,jpg,jpeg,doc,docx,pdf',
            'em_name' => 'nullable|string|max:100',
            'em_phone' => 'nullable|string|max:100',
            'deduction_date' => 'required|numeric|min:1|max:31'
        ]);

        $now = Carbon::now()->toDateTimeString();
        $userImage = 'img/user/drivers/default.jpg';
        $recurring_deductions = array();
        $fileLicense = null;
        $fileMedical = null;

        if(!isset($request->recurring_id)){
            return redirect()->back()->withErrors(['msg' => "Please select at least one recurring deduction!"]);
        }

        if($request->hasFile('image')){
            $img = Image::make($request->image)->crop(round($request->width), round($request->height), round($request->x), round($request->y));

            $img->resize(300, 300);

            $hash = md5($img->__toString().$now);

            $userImage = "img/users/drivers/".$hash.".jpg";
            
            $img->save(public_path("storage/".$path));
        }

        if($request->hasFile('file_license')){
            $path = Storage::putFile('public/img/user/drivers/licenses', $request->file_license);
            $fileLicense = str_replace("public/", "", $path); 
        }

        if($request->hasFile('file_medical')){
            $path = Storage::putFile('public/img/user/drivers/licenses', $request->file_medical);
            $fileMedical = str_replace("public/", "", $path); 
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'image' => $userImage,
            'role_id' => 2,
            'status' => 1
        ]);

        foreach($request->recurring_id as $recurring_id){
            array_push($recurring_deductions, ['user_id' => $user->id, 'recurring_id' => $recurring_id]);
        }

        DriverDetail::create([
            'user_id' => $user->id,
            'street' => $request->street,
            'suite' => $request->suite,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'zip' => $request->zip,
            'payment_type' => $request->payment_type,
            'manual_pay' => $request->manual_pay,
            'on_mile_fee' => $request->on_mile_fee,
            'off_mile_fee' => $request->off_mile_fee,
            'off_mile_range' => $request->off_mile_range,
            'pay_percent' => $request->pay_percent,
            'med_renewal' => $request->med_renewal,
            'hired_at' => $request->hired_at,
            'fired_at' => $request->fired_at,
            'truck_assigned' => $request->truck_id,
            'auto_deduct' => $request->auto_deduct ?? 0,
            'deduction_date' => $request->deduction_date
        ]);

        DriverLicenseInfo::create([
            'user_id' => $user->id,
            'license_number' => $request->license_number,
            'expiration' => $request->expiration,
            'issue_state' => $request->issue_state,
            'file_license' => $fileLicense,
            'file_medical' => $fileMedical
        ]);

        DriverEmergencyInfo::create([
            'user_id' => $user->id,
            'name' => $request->em_name,
            'phone' => $request->em_phone
        ]);
        
        DriverRecurringDeduction::insert($recurring_deductions);

        if($request->file_license == null && $request->file_medical == null){
            $successMsg = "A new driver has been added, but the Driving License and Medical Card documents are missing from this new entry! Please attach them as soon as possible!";
        } elseif ($request->file_license == null) {
            $successMsg = "A new driver has been added, but the Driving License document is missing, please attach it!";
        } elseif ($request->file_medical == null) {
            $successMsg = "A new driver has been added, but the Medical Card document is missing, please attach it!";
        } else {
            $successMsg = 'A new driver has been added!';
        }

        return redirect()->route('admin.driver')->with(['success' => $successMsg]);
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'truck_id' => 'required|numeric|min:1',
            'state_id' => 'required|numeric|min:1',
            'city_id' => 'required|numeric|min:1',
            'phone' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'payment_type' => 'required|numeric|min:1',
            'license_number' => 'required|string|max:100',
            'expiration' => 'required|string|max:100',
            'med_renewal' => 'required|string|max:100',
            'file_license' => 'nullable|mimes:png,jpg,jpeg,doc,docx,pdf',
            'file_medical' => 'nullable|mimes:png,jpg,jpeg,doc,docx,pdf',
            'em_name' => 'nullable|string|max:100',
            'em_phone' => 'nullable|string|max:100',
            'deduction_date' => 'required|numeric|min:1|max:31'
        ]);

        $driver = DriverDetail::where('user_id', $request->user_id)->first();
        $fileLicense = $driver->licenseInfo->file_license;
        $fileMedical = $driver->licenseInfo->file_medical;
        $recurring_deductions = array();

        if(!isset($request->recurring_id)){
            return redirect()->back()->withErrors(['msg' => "Please select at least one recurring deduction!"]);
        }

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => ($request->status == '1' || $request->status == 'true')? 1 : 0
        ];

        $driverDetails = [
            'street' => $request->street,
            'suite' => $request->suite,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'zip' => $request->zip,
            'payment_type' => $request->payment_type,
            'manual_pay' => $request->manual_pay,
            'on_mile_fee' => $request->on_mile_fee,
            'off_mile_fee' => $request->off_mile_fee,
            'off_mile_range' => $request->off_mile_range,
            'pay_percent' => $request->pay_percent,
            'med_renewal' => $request->med_renewal,
            'hired_at' => $request->hired_at,
            'fired_at' => $request->fired_at,
            'auto_deduct' => $request->auto_deduct ?? 0,
            'deduction_date' => $request->deduction_date
        ];

        if(isset($request->password)){
            $userData += ['password' => Hash::make($request->password)];
        }

        if($request->truck_id != $driver->truck_assigned){
            $driverDetails['truck_assigned'] = $request->truck_id;
        }

        if($request->hasFile('file_license')){
            $path = Storage::putFile('public/img/user/drivers/licenses', $request->file_license);
            $fileLicense = str_replace("public/", "", $path); 
        }

        if($request->hasFile('file_medical')){
            $path = Storage::putFile('public/img/user/drivers/licenses', $request->file_medical);
            $fileMedical = str_replace("public/", "", $path); 
        }

        foreach($request->recurring_id as $recurring_id){
            array_push($recurring_deductions, ['user_id' => $request->user_id, 'recurring_id' => $recurring_id]);
        }

        User::where('id', $request->user_id)->update($userData);

        DriverDetail::where('user_id', $request->user_id)->update($driverDetails);

        DriverLicenseInfo::where('user_id', $request->user_id)->update([
            'license_number' => $request->license_number,
            'expiration' => $request->expiration,
            'issue_state' => $request->issue_state,
            'file_license' => $fileLicense,
            'file_medical' => $fileMedical
        ]);

        DriverEmergencyInfo::where('user_id', $request->user_id)->update([
            'name' => $request->em_name,
            'phone' => $request->em_phone
        ]);

        DriverRecurringDeduction::where('user_id', $request->user_id)->delete();
        DriverRecurringDeduction::insert($recurring_deductions);

        return redirect()->route('admin.driver')->with(['success' => 'Driver has been updated!']);
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

        $driver = DriverDetail::where('id', $request->delete_trace)->first();

        $driver = DriverDetail::where('id', $request->delete_trace);
        $driver->update(['is_deleted' => 1]);
        $driver = $driver->first();

        $html = "<h4><i class=\"bi bi-file-person fs-3 text-dark\"></i> Driver</h4>
        <p>{$driver->userDetails->first_name} {$driver->userDetails->first_name} | {$driver->userDetails->email} | {$driver->userDetails->phone}</p>";

        TrashController::create([
            'module_name' => 'Driver',
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
        $driver = DriverDetail::where('id', $id)->first();

        User::where('id', $driver->user_id)->delete();
        DriverDetail::where('id', $id)->delete();
        DriverLicenseInfo::where('user_id', $driver->user_id)->delete();
        DriverEmergencyInfo::where('user_id', $driver->user_id)->delete();
        DriverRecurringDeduction::where('user_id', $request->user_id)->delete();
        return true;
    }

    /**
     * Crops and store driver's image in database and 
     * updates record.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function uploadImage(Request $request){
        $now = Carbon::now()->toDateTimeString();

        if($request->hasFile('image')){
            $img = Image::make($request->image)->crop(round($request->width), round($request->height), round($request->x), round($request->y));

            $img->resize(300, 300);

            $hash = md5($img->__toString().$now);

            $path = "img/users/drivers/".$hash.".jpg";
            
            $img->save(public_path("storage/".$path));

            User::where('id', $request->driver_id)->update(['image' => $path]);
        }

        return response()->json(['url' => asset('storage/'.$path)], 200);
    }

    /**
     * Replace the driver's image with default driver image.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request){
        $path = 'img/users/drivers/default.jpg';

        User::where('id', $request->driver_id)->update(['image' => $path]);

        return response()->json(['url' => asset(Storage::url($path))], 200);
    }

    /**
     * Import's and Creates new records in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    // public function importSheet(Request $request){
    //     $excelSheet = null;

    //     if($request->hasFile('file_excel')){
    //         $path = Storage::putFile('public/temp', $request->file_excel);
    //         $excelSheet = str_replace("public/", "", $path); 
    //     }

    //     \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\DriverImport(), $path);

    //     unlink(public_path().'/storage/'.$excelSheet);

    //     return redirect()->back()->with(['success' => 'Excel sheet has been imported!']);
    // }
}