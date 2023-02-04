<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactController extends Controller{
    /**
     * Shows the application contact-us view.
     *
     * @return \Illuminate\View\View
     */
    public function index(){
        return view('site.contact-us');
    }

    /**
     * Creates a new entry in the database.
     * 
     * @param Illuminate\Http\Request - $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:50',
            'subject' => 'max:255',
            'message' => 'required|string'
        ]);

        $contact = ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'read' => 0
        ]);

        // send mail here...

        return response()->json(['msg' => 'Your message has been sent!'], 200);
    }
}