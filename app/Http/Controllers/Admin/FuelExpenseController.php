<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FuelExpenseImport;
use App\Models\FuelExpenseSheet;
use App\Models\FuelExpense;
use App\Models\Truck;
use Storage;

class FuelExpenseController extends Controller{
    /**
     * Show the application fuel-expense-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $expenses = FuelExpense::all()->sortByDesc('id');
        $sheets = FuelExpenseSheet::all()->sortByDesc('id');
        $trucks = Truck::where('status', 1)->get();

        return view('admin.fuel-expenses.fuel-expense-list', compact('expenses', 'trucks', 'sheets'));
    }

    /**
     * Import's and Creates new records in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function import(Request $request){
        $request->validate([
            'truck' => 'required|numeric|min:1', 
            'load_id' => 'required|numeric|min:1', 
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $excelSheet = null;
        $absolutePath = (config('app.env') == "production")? storage_path()."/app/public/" : public_path()."/storage/";

        if($request->hasFile('file')){
            $path = Storage::putFile('public/temp', $request->file);
            $excelSheet = str_replace("public/", "", $path); 
        }

        $sheet = FuelExpenseSheet::create(['title' => $request->file->getClientOriginalName()]);

        Excel::import(new FuelExpenseImport($request->truck, $request->load_id, $sheet->id), $path);

        unlink($absolutePath.$excelSheet);

        return redirect()->route('admin.fuelExpense')->with(['success' => 'Excel sheet has been imported!']);
    }

    /**
     * Removes a specific record from the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request){
        $sheet = FuelExpenseSheet::where(['id' => $request->sheet, 'deletable' => 1]);

        if($sheet->first()){
            FuelExpense::where('sheet_id', $request->sheet)->delete();
            FuelExpenseSheet::where('id', $request->sheet)->delete();

            return redirect()->back()->with(['success' => 'Sheet reverted successfully!']);
        } else{
            return redirect()->back()->withErrors(['message' => 'Could not revert this sheet!']);
        }
    }
}