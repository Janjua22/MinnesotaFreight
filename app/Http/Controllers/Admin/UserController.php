<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Role;
use Image;
use File;
use Auth;

class UserController extends Controller{
    public function index(){
        $users = User::all();
        $roles = Role::all();

        return view('admin.users.list',compact('users','roles'));
    }

    public function create(){
        $roles = Role::all();

        return view('admin.users.create',compact('roles'));
    }

    public function view($id){
        $user = User::where('id',$id)->first();
        $roles = Role::all();
        
        return view('admin.users.view',compact('roles','user'));
    }

    public function edit($id){
        $user = User::where('id',$id)->first();
        $roles = Role::all();
        
        return view('admin.users.edit',compact('roles','user'));
    }

    public function store(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::min(8)],
            'role' => [ 'required','integer'],
            'phone' => ['required'],
            'address' => [ 'string', 'max:255'],
            'country' => [ 'integer'],
            'state' => [ 'integer'],
            'city' => [ 'integer'],
            'avatar' => ['mimes:jpg,jpeg,png,gif'],
        ]);

        $avatar = '';

        if($request->avatar){
            $img = Image::make($request->avatar)->crop(round($request->width), round($request->height), round($request->x), round($request->y));
            // $img->resize(200, 200);
            $hash = md5($img->__toString().now());
            $avatar = "img/user/".$hash.".".$request->avatar->extension();
            File::isDirectory(storage_path().'/app/public/img/user/') or File::makeDirectory(storage_path().'/app/public/img/user/', 0655, true, true);
            $img->save(storage_path().'/app/public/'.$avatar);
        } else{
            $avatar = 'img/user.png';
        }
        
        $user = User::create([
            'first_name' =>$request->first_name,
            'last_name' =>$request->last_name,
            'email' =>$request->email,
            'password' =>Hash::make($request->password),
            'phone' =>$request->phone,
            'image' =>$avatar,
            'role_id' =>$request->role,
            'country_id' =>$request->country, 
            'state_id' =>$request->state, 
            'city_id' =>$request->city, 
            'address' =>$request->address
        ]);

        // event(new Registered($user));
        return redirect()->back()->with(['success' => $user->role->name .' has been created!','verify' => 'Kindly verify your email address !!']);
    }
    
    public function update(Request $request){
        $request->validate([
            'id' => ['required'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id),],
            'password' => ['nullable','min:8'],
            'role' => [ 'required','integer'],
            'phone' => ['required'],
            'address' => [ 'string', 'max:255'],
            'country' => [ 'integer'],
            'state' => [ 'integer'],
            'city' => [ 'integer'],
            'avatar' => ['mimes:jpg,jpeg,png,gif'],
        ]);
        
        $user = User::where('id',$request->id)->first();
        $avatar = '';
        $password = '';

        if($request->avatar){
            $img = Image::make($request->avatar)->crop(round($request->width), round($request->height), round($request->x), round($request->y));
            // $img->resize(200, 200);
            $hash = md5($img->__toString().now());
            $avatar = "img/user/".$hash.".".$request->avatar->extension();


            File::isDirectory(storage_path().'/app/public/img/user/') or File::makeDirectory(storage_path().'/app/public/img/user/', 0655, true, true);

            $img->save(storage_path().'/app/public/'.$avatar);
        } else{
            $avatar = $request->hidden_avatar;
        }

        if($request->password){
            $password = Hash::make($request->password);
        } else{
            $password = $user->password;
        }

        $user = User::updateOrCreate(['id' => $request->id], [
            'first_name' =>$request->first_name,
            'last_name' =>$request->last_name,
            'email' =>$request->email,
            'password' =>$password,
            'phone' =>$request->phone,
            'image' =>$avatar,
            'role_id' =>$request->role,
            'country_id' =>$request->country, 
            'state_id' =>$request->state, 
            'city_id' =>$request->city, 
            'address' =>$request->address
        ]);

        return redirect()->back()->with(['success' => $user->role->name .' has been updated!']);
    }

    public function delete(Request $request){
        $request->validate([
            'id' => ['required'],
            'name' => ['required'],
        ]);

        User::where('id',$request->id)->delete();
        
        return redirect()->back()->with(['success' => $request->name .' has been deleted!']);
    }
}