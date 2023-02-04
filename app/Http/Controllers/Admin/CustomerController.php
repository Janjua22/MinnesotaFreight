<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\LoadPlanner;
use App\Models\City;

class CustomerController extends Controller{
    /**
     * Show the application customer-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $customers = Customer::where('is_deleted', 0)->get();

        return view('admin.customers.customer-list', compact('customers'));
    }

    /**
     * Fetches the records and format them for
     * datatable pagination.
     *
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\ResponseJson
     */
    public function fetchAjax(Request $request){
        $data = array();
        $search = $request->search['value'];

        $customers = new Customer();

        $recordsTotal = $customers->count();

        if($search){
            $customers = $customers->where('name', 'LIKE', '%'.$search.'%');
        }

        $recordsFiltered = $customers->count();

        $customers = $customers->where('is_deleted', 0)->skip($request->start)->take($request->length)->get();

        foreach($customers as $customer){
            array_push($data, [
                'id' => $customer->id,
                'name' => $customer->name,
                'type' => $customer->type,
                'street' => $customer->street,
                'city' => $customer->city_id ? $customer->city->name : '',
                'state' => $customer->state_id ? $customer->state->name : '',
                'status' => $customer->status
            ]);
        }

        $response = [
            'draw' => (int) $request->draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    /**
     * Fetches all the customers and send them
     * formatted into json response.
     *
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\ResponseJson
     */
    public function fetchCustomers(Request $request){
        $data = array();
        $customers = new Customer();
        $customers = $customers->where(['status' => 1, 'is_deleted' => 0]);

        if(isset($request->q)){
            $customers = $customers->where('name', 'LIKE', '%'.$request->q.'%');
        }

        $customers = $customers->get();

        foreach($customers as $customer){
            array_push($data, [
                'id' => $customer->id,
                'name' => $customer->name,
                'city' => $customer->city_id ? $customer->city->name : '',
                'state' => $customer->state_id ? $customer->state->name : ''
            ]);
        }

        return response()->json($data, 200);
    }

	  public function fetchAllCustomers(){
        $data = array();
        $customers = new Customer();
        $customers = $customers->where(['status' => 1, 'is_deleted' => 0]);

        // if(isset($request->q)){
            // $customers = $customers->where('name', 'LIKE', '%'.$request->q.'%');
        // }

        $customers = $customers->get();

        foreach($customers as $customer){
            array_push($data, [
                'id' => $customer->id,
                'name' => $customer->name,
                'city' => $customer->city_id ? $customer->city->name : '',
                'state' => $customer->state_id ? $customer->state->name : ''
            ]);
        }

        return response()->json($data, 200);
    }

    /**
     * Show the application customer-add view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(){
        return view('admin.customers.customer-add');
    }

    /**
     * Show the application customer-details view.
     *
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDetails($id){
        $customer = Customer::where('id', $id)->first();

        return view('admin.customers.customer-details', compact('customer'));
    }

    /**
     * Show the application customer-edit view.
     *
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $customer = Customer::where('id', $id)->first();

        return view('admin.customers.customer-edit', compact('customer'));
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
            'state_id' => 'nullable|numeric|min:1',
            'city_id' => 'nullable|numeric|min:1'
        ]);

        $state = City::where('id', $request->city_id)->select('state_id')->first();

        $customer = Customer::create([
            'name' => $request->name,
            'type' => 'Direct',
            'street' => $request->street,
            'suite' => $request->suite,
            'state_id' => $request->state_id ? $request->state_id : ($state ? $state->state_id : null),
            'city_id' => $request->city_id,
            'zip' => $request->zip,
            'lat' => $request->latitude,
            'lng' => $request->longitude,
            'phone' => $request->phone,
            'status' => 1
        ]);

        if($request->server('HTTP_X_REQUESTED_WITH')){
            return response()->json(['id' => $customer->id, 'name' => $customer->name], 200);
        }
        else{
            return redirect()->route('admin.customer')->with(['success' => 'A new customer has been added!']);
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
            'name' => 'required|string|max:255',
            'state_id' => 'required|numeric|min:1',
            'city_id' => 'required|numeric|min:1'
        ]);

        Customer::where('id', $request->id)->update([
            'name' => $request->name,
            'street' => $request->street,
            'suite' => $request->suite,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'zip' => $request->zip,
            'lat' => $request->latitude,
            'lng' => $request->longitude,
            'phone' => $request->phone,
            'status' => ($request->status == '1' || $request->status == 'true')? 1 : 0
        ]);

        return redirect()->route('admin.customer')->with(['success' => 'customer has been updated!']);
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

        $loads = LoadPlanner::where('customer_id', $request->delete_trace)->get();

        if($loads->count()){
            return redirect()->back()->withErrors(['message' => 'Cannot delete this customer. It is assigned to '.$loads->count().' load(s)']);
        } else{
            $customer = Customer::where('id', $request->delete_trace);
            $customer->update(['is_deleted' => 1]);
            $customer = $customer->first();

            $html = "<h4><i class=\"bi bi-pin-map fs-3 text-dark\"></i> Customer</h4>
            <p>{$customer->name} | ".($customer->city_id ? $customer->city->name : "").", ".($customer->state_id ? $customer->state->name : "")." | {$customer->street}</p>";

            TrashController::create([
                'module_name' => 'Customer',
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
        Customer::where('id', $id)->delete();

        return true;
    }

    /**
     * Import's and Creates new records in the database.
     *
     * @param Illuminate\Http\Request - $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    // public function importSheet(Request $request){
    //     $excelSheet = null;

    //     if($request->hasFile('file_excel')){
    //         $path = \Storage::putFile('public/temp', $request->file_excel);
    //         $excelSheet = str_replace("public/", "", $path);
    //     }

    //     \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\CustomerImport(), $path);

    //     unlink(public_path().'/storage/'.$excelSheet);

    //     return redirect()->back()->with(['success' => 'Excel sheet has been imported!']);
    // }
}
