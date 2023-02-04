<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Module;
use App\Models\Role;
use App\Models\Permission;
use Auth;

class PermissionController extends Controller{
    /**
     * Show the application permission list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $roles = Role::all();

        return view('admin.permissions.list', compact('roles'));
    }

    /**
     * Show the application permission create view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(){
        $modules = Module::where('status', 1)->get();
        
        return view('admin.permissions.create', compact('modules'));
    }

    /**
     * Show the application permissions view view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDetails($id){
        $role = Role::where('id',$id)->first();

        return view('admin.permissions.view', compact('role'));
    }

    /**
     * Show the application permissions edit view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $modules = Module::where('status', 1)->get();
        $role = Role::where('id',$id)->first();
        return view('admin.permissions.edit', compact('role','modules'));
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
            'name' => 'required'
        ]);

        $modules = $request->modules;

        $role = Role::create([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if($role){
            foreach($modules as $module){
                if(!isset($module['permissions']['create'])){
                    $create = 0;
                } else{
                    $create = $module['permissions']['create'];
                }

                if(!isset($module['permissions']['read'])){
                    $read = 0;
                } else{
                    $read = $module['permissions']['read'];
                }

                if(!isset($module['permissions']['update'])){
                    $update = 0;
                } else{
                    $update = $module['permissions']['update'];
                }

                if(!isset($module['permissions']['delete'])){
                    $delete = 0;
                } else{
                    $delete = $module['permissions']['delete'];
                }

                $role_permission_id = Permission::create([
                    'module_id' => $module['module_id'],
                    'create' =>  $create,
                    'read' =>  $read,
                    'update' =>  $update,
                    'delete' =>  $delete,
                    'role_id' =>  $role->id
                ]);
            }

            return redirect()->back()->with('msg', 'Role has been created!');
        } else{
            return redirect()->back()->with('error', 'Role not created!');
        }
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
            'name' => 'required'
        ]);

        $role = Role::where('id',$request->role_id)->update(['name' => $request->name, 'updated_at' => now()]);
        $modules = $request->modules;

        Permission::where('role_id',$request->role_id)->delete();

        foreach($modules as $module){
            if(!isset($module['permissions']['create'])){
                $create = 0;
            } else{
                $create = $module['permissions']['create'];
            }

            if(!isset($module['permissions']['read'])){
                $read = 0;
            } else{
                $read = $module['permissions']['read'];
            }

            if(!isset($module['permissions']['update'])){
                $update = 0;
            } else{
                $update = $module['permissions']['update'];
            }

            if(!isset($module['permissions']['delete'])){
                $delete = 0;
            } else{
                $delete = $module['permissions']['delete'];
            }

            $role_permission_id = Permission::create([
                'role_id' =>  $request->role_id,
                'module_id' =>  $module['module_id'],
                'create' =>  $create,
                'read' =>  $read,
                'update' =>  $update,
                'delete' =>  $delete
            ]);
        }

        return redirect()->back()->with('msg', 'Role has been updated!');
    }

    /**
     * Removes a specific record from the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request){
        $request->validate([
            'id' => ['required'],
            'name' => ['required'],
        ]);

        Role::where('id',$request->id)->delete();
        Permission::where('role_id',$request->id)->delete();
        
        return redirect()->route('admin.permissions')->with(['success' => $request->name .' has been deleted!']);
    }
}