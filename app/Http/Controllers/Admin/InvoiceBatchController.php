<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceBatch;
use App\Models\InvoiceBatchDownload;
use Auth;

class InvoiceBatchController extends Controller{
    /**
     * Show the application batch view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $batches = InvoiceBatch::all();

        return view('admin.invoice-batches.batch', compact('batches'));
    }

    /**
     * Insert a new record in the database and downloads
     * the requested file.
     * 
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function download(Request $request){
        $request->validate(['batch_id' => 'required|numeric|min:1']);

        $batch = InvoiceBatch::where('id', $request->batch_id)->first();

        InvoiceBatchDownload::insert([
            'batch_id' => $request->batch_id,
            'user_id' => Auth::id(),
            'downloaded_at' => now()
        ]);

        return response()->download(storage_path("/app/public/".$batch->file_path), '', [
            'Content-Type' => 'application/pdf'
        ]);
    }
}