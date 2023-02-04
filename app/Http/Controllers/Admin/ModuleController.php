<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Module;
use App\Models\Role;
use App\Models\Permission;

class ModuleController extends Controller{
    /**
     * Show the application contact-us list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $modules = Module::all();

        return view('admin.modules.list',compact('modules'));
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
            'name' => ['required', 'string',  'max:255', 'unique:modules'],
            'status' => ['required', 'integer'],
        ]);
        
        $name = $request->name;

        if(preg_match('/[^a-zA-Z]+/i', $name)){ 
            return redirect()->back()->withErrors(['error'=>'Invalid charaters in Module name']);
        }

        $policyName = $name.'Policy.php';
        $content = PolicyContent($name);
        $fp = fopen(public_path() . "/../app/Policies/".$policyName,"w");

        fwrite($fp,$content);
        fclose($fp);

        chmod(public_path() . "/../app/Policies/".$policyName, 0777); 

        $module = Module::create(['name' => $name, 'status' => $request->status]);
        $roles = Role::all();

        foreach($roles as $key => $role){
            Permission::create([
                'role_id' =>  $role->id,
                'module_id' =>  $module->id,
                'create' =>  0,
                'read' =>  1,
                'update' =>  0,
                'delete' =>  0
            ]);
        }

        return redirect()->back()->with(['msg'=>'Module added successfully and read permission allowed to all roles by default','name'=>$name]);
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
            'id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255', Rule::unique('modules')->ignore($request->id),],
            'status' => ['required', 'integer'],
        ]);
        
        $name = $request->name;
        $deleted = false;

        if(preg_match('/[^a-zA-Z]+/i', $name)){ 
            return redirect()->back()->withErrors(['error'=>'Invalid charaters in Module name']);
        }

        $module= Module::where('id',$request->id)->first();
        
        $oldPolicyName = $module->name.'Policy.php';
        $fp = public_path() . "/../app/Policies/".$oldPolicyName;

        //If the file exists and is writeable
        if(is_writable($fp)){
            $deleted = unlink($fp);
        }

        if($deleted){
            $policyName = $name.'Policy.php';
            $content = PolicyContent($name);
            $fp = fopen(public_path() . "/../app/Policies/".$policyName,"w");

            fwrite($fp,$content);
            fclose($fp);
            chmod(public_path() . "/../app/Policies/".$policyName, 0777); 
            
            Module::where('id',$request->id)->update(['name' => $request->name, 'status' => $request->status]);
        }

        return redirect()->back()->with(['msg'=>'Module updated successfully!']);
    }
}