<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FactoringCompany;

class FactoringCompanyController extends Controller{
    /**
     * Show the application factoring-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $factoringCompanies = FactoringCompany::where('is_deleted', 0)->get();

        return view('admin.factoring.factoring-list', compact('factoringCompanies'));
    }

    /**
     * Show the application factoring-add view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(){
        return view('admin.factoring.factoring-add');
    }

    /**
     * Show the application factoring-edit view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $factoringCompany = FactoringCompany::where('id', $id)->first();

        return view('admin.factoring.factoring-edit', compact('factoringCompany'));
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
            'name' => 'required|string|max:255',
            'zip' => 'required|string|max:50',
            'state_id' => 'required|numeric|min:1',
            'city_id' => 'required|numeric|min:1',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'logo' => 'nullable|mimes:png,jpg,jpeg',
            'note' => 'max:255'
        ]);

        if($request->hasFile('logo')){
            $path = Storage::putFile('public/img/logo/factoring', $request->logo);
            $fileAccessorial = str_replace("public/", "", $path); 
        } else{
            $path = siteSetting('logo');
        }

        FactoringCompany::create([
            'name' => $request->name,
            'street' => $request->street,
            'zip' => $request->zip,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'logo' => $path,
            'website' => $request->website,
            'tax_id' => $request->tax_id,
            'note' => $request->note,
            'status' => 1
        ]);
        
        return redirect()->route('admin.factoringCompanies')->with(['success' => 'A new factoring compay has been added!']);
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
            'name' => 'required|string|max:255',
            'zip' => 'required|string|max:50',
            'state_id' => 'required|numeric|min:1',
            'city_id' => 'required|numeric|min:1',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'note' => 'max:255'
        ]);

        FactoringCompany::where('id', $request->id)->update([
            'name' => $request->name,
            'street' => $request->street,
            'zip' => $request->zip,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'tax_id' => $request->tax_id,
            'note' => $request->note,
            'status' => ($request->status == '1' || $request->status == 'true')? 1 : 0
        ]);
        
        return redirect()->route('admin.factoringCompanies')->with(['success' => 'Factoring compay has been updated!']);
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

        $factoring = FactoringCompany::where('id', $request->delete_trace);
        $factoring->update(['is_deleted' => 1]);
        $factoring = $factoring->first();

        $html = "<h4><i class=\"bi bi-building fs-3 text-dark\"></i> Factoring Company</h4>
        <p>{$factoring->name}</p>";

        TrashController::create([
            'module_name' => 'FactoringCompany',
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
        FactoringCompany::where('id', $id)->delete();

        return true;
    }
}