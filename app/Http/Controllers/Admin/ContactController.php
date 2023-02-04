<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactController extends Controller{
    /**
     * Show the application contact-us list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $contacts = ContactUs::all();

        return view('admin.contact-us.list', compact('contacts'));
    }

    /**
     * Mark a record as read
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\ResponseJson
     */
    public function read(Request $request){
        ContactUs::where('id',$request->id)->update(['read'=> 1]);

        return response()->json(['success' => true], 200);
    }
}