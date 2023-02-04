<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\SiteSetting;
use App\Models\FactoringCompany;

class SiteSettingController extends Controller{
    /**
     * Show the application site-settings list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $settings = [];
        $site_settings = SiteSetting::all();
        $factoringCompanies = FactoringCompany::where('is_deleted', 0)->get();

        foreach($site_settings as $key => $setting){
            $settings[$setting->key] = $setting->value;
        }

        return view('admin.site-settings.list',compact('site_settings','settings','factoringCompanies'));
    }
    
    /**
     * Updates a site settings in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        if($request->logo){
            $path = Storage::putFile('public/img/logo', $request->logo);
            $logo = str_replace("public/", "", $path);
        } else{            
            $logo = $request->hidden_logo;
        }
        
        if($request->logo_white){
            $path_white = Storage::putFile('public/img/logo', $request->logo_white);
            $logo_white = str_replace("public/", "", $path_white);
        } else{            
            $logo_white = $request->hidden_logo_white;
        }

        if($request->auth_bg){
            $path_white = Storage::putFile('public/img/logo', $request->auth_bg);
            $auth_bg = str_replace("public/", "", $path_white);
        } else{            
            $auth_bg = $request->hidden_auth_bg;
        }

        if($request->auth_text_bg){
            $path_white = Storage::putFile('public/img/logo', $request->auth_text_bg);
            $auth_text_bg = str_replace("public/", "", $path_white);
        } else{            
            $auth_text_bg = $request->hidden_auth_text_bg;
        }

        if($request->contact_form_email){
            SiteSetting::where('key', 'contact_form_email')->update(['value' => 1]);
        } else{
            SiteSetting::where('key', 'contact_form_email')->update(['value' => 0]);
        }

        if($request->login){
            SiteSetting::where('key','login')->update(['value' => 1]);
        } else{
            SiteSetting::where('key','login')->update(['value' => 0]);
        }

        if($request->register){
            SiteSetting::where('key','register')->update(['value' => 1]);
        } else{
            SiteSetting::where('key','register')->update(['value' => 0]);
        }

        if($request->reset){
            SiteSetting::where('key','reset')->update(['value' => 1]);
        } else{
            SiteSetting::where('key','reset')->update(['value' => 0]);
        }
        
        foreach ($request->all() as $key => $value) {
            if($key == 'logo'){
                SiteSetting::where('key', $key)->update(['value' => $logo]);
            } else if ($key == 'logo_white'){
                SiteSetting::where('key', $key)->update(['value' => $logo_white]);
            } else if ($key == 'auth_bg'){
                SiteSetting::where('key', $key)->update(['value' => $auth_bg]);
            } else if ($key == 'auth_text_bg'){
                SiteSetting::where('key', $key)->update(['value' => $auth_text_bg]);
            } else{
                SiteSetting::where('key', $key)->update(['value' => $value]);
            }
        }
        
        return redirect()->back()->with(['msg' => 'Setting updated successfully!']);
    }
    
    /**
     * Removes a specific record from the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request){
        SiteSetting::where('id',$request->id)->delete();

        return redirect()->back()->with(['msg' => 'Setting deleted successfully!']);
    }
}