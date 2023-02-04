<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trash;
use Auth;

class TrashController extends Controller{
    /**
     * Show the application trash-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $trashRecords = Trash::all();

        return view("admin.trash.trash-list", compact('trashRecords'));
    }

    /**
     * Creates a new record in the database.
     *
     * @param array - $data
     * 
     * @return bool
     */
    public static function create(array $data): bool{
        Trash::create([
            'module_name' => $data['module_name'],
            'row_id' => $data['row_id'],
            'description' => $data['description'],
            'created_by' => Auth::id(),
            'created_at' => now()
        ]);

        return true;
    }

    /**
     * Restores a specific record from the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request){
        $request->validate(['id' => 'required|numeric|min:1']);
        
        $trash = Trash::where('id', $request->id)->first();

        if($trash->module_name == "DriverApplication"){
            $MODEL = "App\\Models\\Application";
        } else if($trash->module_name == "Driver"){
            $MODEL = "App\\Models\\DriverDetail";
        } else{
            $MODEL = "App\\Models\\".$trash->module_name;
        }

        $obj = new $MODEL();

        $obj->where('id', $trash->row_id)->update(['is_deleted' => 0]);

        Trash::where('id', $request->id)->delete();

        return response()->json(["msg" => "Record has been restored!"]);
    }

    /**
     * Removes a specific record from the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request){
        // dd($request->id);
        $request->validate(['id' => 'required|numeric|min:1']);
        
        $trash = Trash::where('id', $request->id)->first();
        //  dd("App\\Http\\Controllers\\Admin\\".$trash->module_name."Controller");
        Trash::where('id', $request->id)->delete();
        $row_id = $trash->row_id;
        $CONTROLLER = "App\\Http\\Controllers\\Admin\\".$trash->module_name."Controller";
       
        $obj = new $CONTROLLER();

        $obj->permenantDelete($row_id);

        

        return response()->json(["msg" => "Record has been deleted permanently!"], 200);
    }

    /**
     * Removes all the records from the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function deleteAll(Request $request){
        $trashes = Trash::all();

        foreach($trashes as $trash){
            $CONTROLLER = "App\\Http\\Controllers\\Admin\\".$trash->module_name."Controller";
    
            $obj = new $CONTROLLER();
            $obj->permenantDelete($trash->row_id);
        }

        Trash::truncate();

        return response()->json(["msg" => "Trash has been emptied!"]);
    }
}