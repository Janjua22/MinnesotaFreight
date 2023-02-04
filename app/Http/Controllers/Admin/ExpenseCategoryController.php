<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller{
    /**
     * Show the application expense-categories-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $categories = ExpenseCategory::where('is_deleted', 0)->get();

        return view('admin.expense-categories.expense-categories-list', compact('categories'));
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

        $expenseCategory = ExpenseCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1
        ]);

        if($request->server('HTTP_X_REQUESTED_WITH')){
            return response()->json(['id' => $expenseCategory->id, 'name' => $expenseCategory->name], 200);
        } else{
            return redirect()->route('admin.expenseCategory')->with(['success' => 'A new expense category has been added!']);
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
        
        
        ExpenseCategory::where('id', $request->edt_id)->update([
            'name' => $request->edt_name,
            'description' => $request->edt_description,
            'status' =>  $request->edt_status
        ]);

        return redirect()->route('admin.expenseCategory')->with(['success' => 'Expense category has been updated!']);
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

        $expense = Expense::where('category_id', $request->delete_trace)->get();

        if($expense->count()){
            return redirect()->back()->withErrors(['message' => 'Cannot delete this category. It is assigned to '.$expense->count().'  expense record(s)']);
        } else{
            $category = ExpenseCategory::where('id', $request->delete_trace);
            $category->update(['is_deleted' => 1]);
            $category = $category->first();

            $html = "<h4><i class=\"bi bi-bar-chart-steps fs-3 text-dark\"></i> Expense Category</h4>
            <p>{$category->name}</p>";

            TrashController::create([
                'module_name' => 'ExpenseCategory',
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
        ExpenseCategory::where('id', $id)->delete();

        return true;
    }
}