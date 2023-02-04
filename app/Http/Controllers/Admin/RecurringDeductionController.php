<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecurringDeduction;
use App\Models\DriverRecurringDeduction;

class RecurringDeductionController extends Controller{
    /**
     * Show the application recurring-deduction-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $recurrings = RecurringDeduction::all();

        return view('admin.recurring-deductions.recurring-deduction-list', compact('recurrings'));
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
            'title' => 'required|string|max:150',
            'amount' => 'required|numeric|min:0',
            // 'date' => 'required|string|max:150',
            'status' => 'required|numeric|min:0'
        ]);

        $recurringDeduction = RecurringDeduction::create([
            'title' => $request->title,
            'amount' => $request->amount,
            // 'date' => $request->date,
            'status' => $request->status
        ]);

        if($request->server('HTTP_X_REQUESTED_WITH')){
            return response()->json(['id' => $recurringDeduction->id, 'title' => $recurringDeduction->title], 200);
        } else{
            return redirect()->route('admin.recurringDeduction')->with(['success' => 'A new recurring deduction has been added!']);
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
            'edt_title' => 'required|string|max:150',
            'edt_amount' => 'required|numeric|min:0',
            // 'edt_date' => 'required|string|max:150',
            'edt_status' => 'required|numeric|min:0'
        ]);
        
        RecurringDeduction::where('id', $request->edt_id)->update([
            'title' => $request->edt_title,
            'amount' => $request->edt_amount,
            // 'date' => $request->edt_date,
            'status' => $request->edt_status
        ]);

        return redirect()->route('admin.recurringDeduction')->with(['success' => 'Recurring deduction has been updated!']);
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

        $recordExist = DriverRecurringDeduction::where('recurring_id', $request->delete_trace)->first();

        if($recordExist){
            return redirect()->back()->withErrors(['msg' => 'The deduction you are trying to delete is not independent. There are driver records who are dependent on this deduction.']);
        } else{
            RecurringDeduction::where('id', $request->delete_trace)->delete();

            return redirect()->back();
        }
    }
}