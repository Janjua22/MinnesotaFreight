<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Archive;
use Storage;

class ArchiveController extends Controller{
    /**
     * Show the application archives-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $dates = Archive::all()->groupBy('date');

        return view('admin.archives.archive-list', compact('dates'));
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
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,png,jpg,jpeg'
        ]);

        $path = Storage::putFile('public/files/archives', $request->file);

        Archive::create([
            'title' => $request->title,
            'path' => str_replace("public/", "", $path),
            'date' => Carbon::now()->format('Y-m-d')
        ]);

        return redirect()->route('admin.archive')->with(['success' => "File has been added on today's date!"]);
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        $request->validate(['id' => 'required|numeric|min:1']);

        Archive::where('id', $request->id)->update(['status' => 1]);

        return response()->json(["success" => "File has been marked as completed!"], 200);
    }

    /**
     * Updates a specific record in the database.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request){
        $request->validate(['delete_trace' => 'required|numeric|min:1']);

        $archive = Archive::where('id', $request->delete_trace);

        $row = $archive->first();

        Storage::delete('public/'.$row->path);
        $archive->delete();

        return redirect()->route('admin.archive')->with(['success' => "File has been deleted!"]);
    }
}