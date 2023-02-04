<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverAdditionalDeduction;
use App\Models\DeductionCategory;

class DeductionCategoryController extends Controller{
    /**
     * Show the application deduction-categories-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $categories = DeductionCategory::where('is_deleted', 0)->get();

        return view('admin.deduction-categories.deduction-categories-list', compact('categories'));
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
            'name' => 'required|string|max:150',
            'description' => 'max:255'
        ]);

        $deductionCategory = DeductionCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1
        ]);

        if($request->server('HTTP_X_REQUESTED_WITH')){
            return response()->json(['id' => $deductionCategory->id, 'name' => $deductionCategory->name], 200);
        } else{
            return redirect()->route('admin.deductionCategory')->with(['success' => 'A new deduction category has been added!']);
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
            'edt_name' => 'required|string|max:150',
            'edt_description' => 'max:255',
            'edt_status' => 'required|numeric'
        ]);
        
        
        DeductionCategory::where('id', $request->edt_id)->update([
            'name' => $request->edt_name,
            'description' => $request->edt_description,
            'status' =>  $request->edt_status
        ]);

        return redirect()->route('admin.deductionCategory')->with(['success' => 'Deduction category has been updated!']);
    }

    /**
     * Removes a specific record from the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request){
        $request->validate(['delete_trace' => 'required|numeric|min:1']);

        $deductions = DriverAdditionalDeduction::where('category_id', $request->delete_trace)->get();

        if($deductions->count()){
            return redirect()->back()->withErrors(['message' => 'Cannot delete this category. It is assigned to '.$deductions->count().'  driver settlement record(s)']);
        } else{
            $category = DeductionCategory::where('id', $request->delete_trace);
            $category->update(['is_deleted' => 1]);
            $category = $category->first();

            $html = "<h4><i class=\"bi bi-card-list fs-3 text-dark\"></i> Deduction Category</h4>
            <p>{$category->name}</p>";

            TrashController::create([
                'module_name' => 'DeductionCategory',
                'row_id' => $request->delete_trace,
                'description' => $html
            ]);

            return redirect()->back();
        }
    }

    /**
     * Removes a specific record from the database.
     *
     * @param int - $id
     * 
     * @return bool
     */
    public function permenantDelete(int $id): bool{
        DeductionCategory::where('id', $id)->delete();

        return true;
    }
}