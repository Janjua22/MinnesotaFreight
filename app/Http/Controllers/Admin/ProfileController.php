<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;
use Image;
use File;

class ProfileController extends Controller{
    /**
     * Show the application profile view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        return view('admin.profile');
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function updateDetails(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'address' => ['required', 'string', 'max:255'],
            'country' => ['required', 'integer'],
            'state' => ['required', 'integer'],
            'city' => ['required', 'integer'],
        ]);

        User::where('id',Auth::id())->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
        ]);

        return  redirect()->back()->with('msg','Details updated successfully!');
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function updateEmail(Request $request){
        $request->validate([
            'confirmemailpassword' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())]
        ]);
        
        if(! Hash::check($request->confirmemailpassword, Auth::user()->password)){
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }

        User::where('id',Auth::id())->update(['email' => $request->email]);

        return  redirect()->back()->with('msg','Email updated successfully!');
    }
    
    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);
        
        if(! Hash::check($request->current_password, Auth::user()->password)){
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }

        User::where('id',Auth::id())->update(['password' => Hash::make($request->password)]);

        return  redirect()->back()->with('msg','Password updated successfully!');
    }
    
    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function updateImage(Request $request){
        $request->validate([
            'image' => ['required','mimes:jpg,jpeg,png,gif']
        ]);
        
        $img = Image::make($request->image)->crop(round($request->width), round($request->height), round($request->x), round($request->y));
        // $img->resize(200, 200);
        $hash = md5($img->__toString().now());
        $image = "img/user/".$hash.".".$request->image->extension();

        File::isDirectory(storage_path().'/app/public/img/user/') or File::makeDirectory(storage_path().'/app/public/img/user/', 0655, true, true);

        $img->save(storage_path().'/app/public/'.$image);

        User::where('id',Auth::id())->update(['image' => $image]);

        return  redirect()->back()->with('msg', 'Profile image updated successfully!');
    }
}