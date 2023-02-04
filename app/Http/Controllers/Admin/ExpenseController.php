<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Truck;
use App\Models\LoadPlanner;

class ExpenseController extends Controller{
    /**
     * Show the application expense-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $expenses = Expense::where('is_deleted', 0)->get();

        return view('admin.expenses.expenses-list', compact('expenses'));
    }

    /**
     * Show the application expenses-add view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(){
        $categories = ExpenseCategory::where(['is_deleted' => 0, 'status' => 1])->get();
        $trucks = Truck::where(['is_deleted' => 0, 'status' => 1])->get();
        $loads = LoadPlanner::where(['is_deleted' => 0, 'status' => 2])->get();

        return view('admin.expenses.expenses-add', compact('categories', 'trucks', 'loads'));
    }

    /**
     * Show the application expense-edit view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $expense = Expense::where('id', $id)->first();
        $categories = ExpenseCategory::where(['is_deleted' => 0, 'status' => 1])->get();
        $trucks = Truck::where(['is_deleted' => 0, 'status' => 1])->get();
        $loads = LoadPlanner::where(['is_deleted' => 0, 'status' => 2])->get();

        return view('admin.expenses.expenses-edit', compact('expense', 'categories', 'trucks', 'loads'));
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
            'category_id' => 'required|numeric|min:1',
            'truck_id' => 'required|numeric|min:1',
            'date' => 'required',
            'amount' => 'required|numeric|min:0',
            'note' => 'max:255'
        ]);

        Expense::create([
            'category_id' => $request->category_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'truck_id' => $request->truck_id,
            'load_id' => $request->load_id,
            'gallons' => $request->gallons,
            'odometer' => $request->odometer,
            'note' => $request->note
        ]);

        return redirect()->route('admin.expenses')->with(['success' => 'A new expense has been added!']);
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
            'category_id' => 'required|numeric|min:1',
            'truck_id' => 'required|numeric|min:1',
            'date' => 'required',
            'amount' => 'required|numeric|min:0',
            'note' => 'max:255'
        ]);

        Expense::where('id', $request->id)->update([
            'date' => $request->date,
            'amount' => $request->amount,
            'truck_id' => $request->truck_id,
            'load_id' => $request->load_id,
            'gallons' => $request->gallons,
            'odometer' => $request->odometer,
            'note' => $request->note
        ]);

        return redirect()->route('admin.expenses')->with(['success' => 'Expense has been updated!']);
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

        $expense = Expense::where('id', $request->delete_trace);
        $expense->update(['is_deleted' => 1]);
        $expense = $expense->first();

        $html = "<h4><i class=\"bi bi-cash-coin fs-3 text-dark\"></i> Expense</h4>
        <p>{$expense->category->name} | ${$expense->amount} | truck # {$expense->truck->truck_number}</p>";

        TrashController::create([
            'module_name' => 'Expense',
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
        Expense::where('id', $id)->delete();

        return true;
    }
}