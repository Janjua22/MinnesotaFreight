<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\InvoiceBatch;
use App\Models\InvoiceBatchDownload;
use App\Models\LoadPlanner;
use App\Models\FactoringCompany;
use PDF;
use PDFMerger;
use Auth;

class InvoiceController extends Controller{
    /**
     * Path of storage for production or local
     * 
     * @var string
     */
    private $path;

    /**
     * Constructor for Invoice Controller.
     */
    public function __construct(){
        $this->path = (config('app.env') == "production")? storage_path()."/app/public/" : public_path()."/storage/";
    }

    /**
     * Show the application invoice-list view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $allInvoices = Invoice::where('is_deleted', 0)->get();
        $allInvoices = $allInvoices->sortDesc();
        $notBatchedInvoices = $allInvoices->where('batch_id', null);

        return view('admin.invoices.invoice-list', compact('allInvoices', 'notBatchedInvoices'));
    }

    /**
     * Show the application invoice-add view.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showAddForm(){
        $loads = LoadPlanner::where(['is_deleted' => 0, 'invoiced' => 0])->get();
        $factorings = FactoringCompany::where(['is_deleted' => 0, 'status' => 1])->get();
        $lastInvoice = Invoice::orderBy('id', 'DESC')->first();

        if($loads->count()){
            return view('admin.invoices.invoice-add', compact('factorings', 'loads', 'lastInvoice'));
        } else{
            return redirect()->back()->withErrors(['error' => 'No loads are available for invoice!']);
        }
    }

    /**
     * Show the application invoice-details view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDetails($id){
        $invoice = Invoice::where('id', $id)->first();

        if($invoice){
            return view('admin.invoices.invoice-details', compact('invoice'));
        } else{
            abort(404);
        }
    }

    /**
     * Show the application invoice-edit view.
     * 
     * @param int - $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showEditForm($id){
        $invoice = Invoice::where(['id' => $id, 'is_deleted' => 0])->first();
        $factorings = FactoringCompany::where(['is_deleted' => 0, 'status' => 1])->get();

        if($invoice){
            return view('admin.invoices.invoice-edit', compact('invoice', 'factorings'));
        } else{
            abort(404);
        }
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
            'date' => 'required',
            'due_date' => 'required',
            'factoring_id' => 'required|numeric|min:1'
        ]);
        
        if(isset($request->invoice_number)){
            $invoiceNumber = $request->invoice_number;
        } else{
            // $invoiceNumber = "I-".Carbon::now()->timestamp;
            $lastInvoice = Invoice::orderBy('id', 'DESC')->first();

            if($lastInvoice){
                $invoiceNumber = (int)$lastInvoice->invoice_number + 1;
            } else{
                $invoiceNumber = (int)siteSetting('invoice_start');
            }
        }

        foreach($request->load_ids as $i => $load_id){
            $loadPlanner = LoadPlanner::where('id', $load_id);
        
            $load = $loadPlanner->first();

            $calculations = $this->calculateTotals($load);

            Invoice::insert([
                'customer_id' => $request->customer_ids[$i],
                'factoring_id' => $request->factoring_id,
                'load_id' => $load_id,
                'invoice_number' => $invoiceNumber,
                'total_amount' => $calculations['total'],
                'total_balance' => $calculations['grandTotal'],
                'date' => $request->date,
                'due_date' => $request->due_date,
                'created_at' => Carbon::now(),
                'status' => 2
            ]);

            $loadPlanner->update(['invoiced' => 1]);

            $invoiceNumber++;
        }

        return redirect()->route('admin.invoice')->with(['success' => "The invoices have been generated for loads!"]);
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
            'id' => 'required|numeric|min:1',
            'date' => 'required',
            'due_date' => 'required',
            'factoring_id' => 'required|numeric|min:1'
        ]);
        
        Invoice::where('id', $request->id)->update([
            'factoring_id' => $request->factoring_id,
            'invoice_number' => $request->invoice_number,
            'date' => $request->date,
            'due_date' => $request->due_date
        ]);
        
        return redirect()->route('admin.invoice')->with(['success' => "Invoice has been updated."]);
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

        $invoice = Invoice::where('id', $request->delete_trace);
        $invoice->update(['is_deleted' => 1]);
        $invoice = $invoice->first();

        $html = "<a href=\"".route('admin.invoice.details', ['id' => $request->delete_trace])."\" class=\"text-dark\" target=\"_blank\">
        <h4><i class=\"bi bi-receipt fs-3 text-dark\"></i> Invoice</h4>
        <p>{$invoice->invoice_number} | {$invoice->customer->name} | $".$invoice->total_amount."</p></a>";

        TrashController::create([
            'module_name' => 'Invoice',
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
        $invoice = Invoice::where('id', $id);
        $invoiceTrace = $invoice->first();
        
        LoadPlanner::where('id', $invoiceTrace->load_id)->update(['invoiced' => 0]);

        $invoice->delete();

        return true;
    }

    /**
     * Finalize the remaining details about an invoice.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function finalizeInvoice(Request $request){
        $request->validate(['f_id' => 'required']);

        $factoring = siteSetting('factoring');
        $invoiceInst = Invoice::where(['id' => $request->f_id, 'is_deleted' => 0, 'status' => 2]);

        $inv = $invoiceInst->first();

        if($inv){
            $deductFactoring = ($inv->total_balance * $factoring) / 100;

            $invoiceInst->update([
                'factoring_fee' => $factoring,
                'total_w_factoring' => $inv->total_balance - $deductFactoring,
                'include_factoring' => $request->include_factoring ?? 0,
                'status' => 3
            ]);
    
            // send email to customer and factoring here...

            return redirect()->route('admin.invoice')->with(['success' => "Generated final invoice. It is now uneditable."]);
        } else{
            abort(403);
        }
    }

    /**
     * Updates the status of an invoice to paid.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function markPaid(Request $request){
        $marked = Invoice::where(['id' => $request->id, 'is_deleted' => 0])->update(['paid_date' => Carbon::now()->toDateString(), 'status' => 1]);
        
        return redirect()->route('admin.invoice')->with(['success' => "Invoice has been paid"]);
    }

    /**
     * Resposible for generating a PDF file of the invoice. This
     * method checks for extension types of bol and rate_confirmation 
     * files, if both the files are images, returns for download 
     * without any process. If one or both the files are .pdf or 
     * .doc or .docx, it merges the .pdf extension file and if the 
     * extension is .doc or .docx, first it converts to pdf then merge. 
     * After merging, removes temporary files from the /temp directory 
     * and returns.
     *
     * @param int - $id  - [optional] Invoice id
     * @param bool - $download  - Make the file downloadable
     * @param int - $index  - [optional] index number of array
     * 
     * @return LynX39\LaraPdfMerger\Facades\PdfMerger - save() instance
     */
    public function print(int $id, bool $download = true, int $index = 0){
        $invoice = Invoice::where('id', $id)->first();
        $bolExt = $invoice->loadPlanner->file_bol ? pathinfo($invoice->loadPlanner->file_bol, PATHINFO_EXTENSION) : 'jpg';
        $rcExt = $invoice->loadPlanner->file_rate_confirm ? pathinfo($invoice->loadPlanner->file_rate_confirm, PATHINFO_EXTENSION) : 'jpg';

        $pdf = PDF::loadView('admin.invoices.invoice-details', compact('invoice'));

        if(($bolExt == 'jpg' || $bolExt == 'jpeg' || $bolExt == 'png') && ($rcExt == 'jpg' || $rcExt == 'jpeg' || $rcExt == 'png')){
            // in-case both the files are images...
            if($download){
                return $pdf->download('invoice.pdf');
            } else{
                return $pdf->save($this->path."temp-bulk/invoices/inv_temp-{$index}.pdf");
            }
        } else{
            // in-case if one or both the files are .pdf, .doc or .docx...
            $merger = new PDFMerger();
            $merger = $merger::init();
            $domPdfPath = realpath(config('constant.phpword_base_dir').'/../vendor/dompdf/dompdf');

            // setting up dompdf path for telling php which pdf renderer to use
            Settings::setPdfRendererPath($domPdfPath);
            Settings::setPdfRendererName('DomPDF');
            
            $pdf->save($this->path.'temp/init_inv_temp-'.$invoice->id.'.pdf');
            $merger->addPDF($this->path.'temp/init_inv_temp-'.$invoice->id.'.pdf', 'all');

            if($bolExt == 'pdf'){
                $merger->addPDF($this->path.$invoice->loadPlanner->file_bol, 'all');
            }

            if($rcExt == 'pdf'){
                $merger->addPDF($this->path.$invoice->loadPlanner->file_rate_confirm, 'all');
            }

            if($bolExt == 'doc' || $bolExt == 'docx'){
                $fileName = $this->path.$invoice->loadPlanner->file_bol;

                $reader = IOFactory::createReader();
                $phpWord = $reader->load($fileName);

                $writer = IOFactory::createWriter($phpWord, 'PDF');
                $writer->save($this->path.'temp/bol_doc-'.$invoice->id.'.pdf');

                $merger->addPDF($this->path.'temp/bol_doc-'.$invoice->id.'.pdf', 'all');
            }

            if($rcExt == 'doc' || $rcExt == 'docx'){
                $fileName = $this->path.$invoice->loadPlanner->file_rate_confirm;

                $reader = IOFactory::createReader();
                $phpWord = $reader->load($fileName);

                $writer = IOFactory::createWriter($phpWord, 'PDF');
                $writer->save($this->path.'temp/rc_doc-'.$invoice->id.'.pdf');

                $merger->addPDF($this->path.'temp/rc_doc-'.$invoice->id.'.pdf', 'all');
            }
    
            $merger->merge();

            unlink($this->path.'temp/init_inv_temp-'.$invoice->id.'.pdf');

            if($bolExt == 'doc' || $bolExt == 'docx'){
                unlink($this->path.'temp/bol_doc-'.$invoice->id.'.pdf');
            }

            if($rcExt == 'doc' || $rcExt == 'docx'){
                unlink($this->path.'temp/rc_doc-'.$invoice->id.'.pdf');
            }

            if($download){
                return $merger->save('invoice.pdf', 'download');
            } else{
                $merger->save($this->path."temp-bulk/invoices/inv_temp-{$index}.pdf");
                $merger = true;

                return $merger;
            }
        }
    }

    /**
     * Extract the invoice ids of requested date range.
     * Then create a pdf file including all the records of the 
     * available invoices in a date range. Also, creates separate 
     * single invoice files and temporarily save them. Lastly merge 
     * all the created single invoices into one file and deletes all
     * the temporary files.
     *
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function exportBulk(Request $request){
        // $request->validate(['from' => 'required', 'to' => 'required']); // the system was first exported from a date range directly here.

        if(!$request->invoices){
            return redirect()->back()->withErrors(['error' => 'No invoice is selected to export!']);
        }

        // $allInvoices = Invoice::whereBetween('date', [$request->from, $request->to])->get();
        $allInvoices = Invoice::whereIn('id', $request->invoices)->get();
        $lastBatch = InvoiceBatch::orderBy('id', 'DESC')->first();
        $invArr = array();
        
        if($lastBatch){
            $batchNumber = (int)$lastBatch->batch_number + 1;
        } else{
            $batchNumber = '1';
        }
        
        $pdf = PDF::loadView('admin.invoices.invoice-bulk', compact('allInvoices'));
        $pdf->save($this->path.'temp-bulk/blk-inv_temp.pdf');
        
        foreach($allInvoices as $i => $invoice){
            $temp = $this->print($invoice->id, false, $i);

            array_push($invArr, $this->path."temp-bulk/invoices/inv_temp-{$i}.pdf");
        }

        $bulkMerger = new PDFMerger();
        $bulkMerger = $bulkMerger::init();

        $bulkMerger->addPDF($this->path."temp-bulk/blk-inv_temp.pdf", 'all');

        foreach($invArr as $inv){
            $bulkMerger->addPDF($inv, 'all');
        }

        $bulkMerger->merge();

        setcookie('download_token', true, time()+3);

        $fileName = 'Schedule-of-accounts_batch#'.$batchNumber.'.pdf';

        $bulkMerger->save($this->path.'files/batches/'.$fileName);
        $bulkMerger->save($fileName, 'download');

        foreach($allInvoices as $i => $invoice){
            unlink($this->path."temp-bulk/invoices/inv_temp-{$i}.pdf");
        }

        unlink($this->path."temp-bulk/blk-inv_temp.pdf");

        $batch = InvoiceBatch::create([
            'batch_number' => $batchNumber,
            'file_path' => 'files/batches/'.$fileName,
            'created_by' => Auth::id()
        ]);

        Invoice::whereIn('id', $request->invoices)->update(['batch_id' => $batch->id]);

        InvoiceBatchDownload::create([
            'batch_id' => $batch->id,
            'user_id' => Auth::id(),
            'downloaded_at' => now()
        ]);

        return true;
    }

    /**
     * Counts the total number of invoices in a given timeperiod.
     * 
     * @param Illuminate\Http\Request - $request
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function invoicesCount(Request $request){
        $allInvoices = Invoice::where('is_deleted', 0)->whereBetween('date', [$request->from, $request->to]);

        if($request->count == '1'){
            return response()->json(['count' => $allInvoices->count()], 200);
        } else{
            $invoicesArr = array();

            foreach ($allInvoices->get() as $invoice){
                array_push($invoicesArr, [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'load_number' => $invoice->loadPlanner->load_number,
                    'customer_name' => $invoice->customer->name,
                    'date' => ($invoice->date)? date_format(new Carbon($invoice->date), "M d, Y") : 'N/A'
                ]);
            }

            return response()->json(['status' => true, 'data' => $invoicesArr], 200);
        }
    }

    /**
     * Calculates the total amount with all the fees and 
     * invoice advance.
     * 
     * @param object - $load
     * 
     * @return array - $totals
     */
    public function calculateTotals(object $load): array{
        $primaryFee = 0;
        $totalMiles = 0;
        $titleText = '';
        $detention = $load->fee->detention ?? 0;
        $lumper = $load->fee->lumper ?? 0;
        $stopOff = ($load->destinations->count() -1) * ($load->fee->stop_off ?? 0);
        $tarpFee = $load->fee->tarp_fee ?? 0;
        $accessorialAmount = $load->fee->accessorial_amount ?? 0;
        $invoiceAdvance = $load->fee->invoice_advance ?? 0;

        switch($load->fee->fee_type){
            case 'Flat Fee':
                $primaryFee = $load->fee->freight_amount ?? 0;
                $titleText = $load->fee->fee_type;
                break;
            case 'Per Mile':
                $primaryFee = $load->fee->freight_amount * $totalMiles ?? 0;
                $titleText = $load->fee->fee_type.". Total miles: ".$totalMiles.", Fee/Mile: $".$load->fee->freight_amount;
                break;
            case 'Per Hundred Weight (cwt)':
                $primaryFee = $load->fee->freight_amount ?? 0;
                $titleText = $load->fee->fee_type;
                break;
            case 'Per Ton':
                $primaryFee = $load->fee->freight_amount ?? 0;
                $titleText = $load->fee->fee_type;
                break;
            case 'Per Quantity':
                $primaryFee = $load->fee->freight_amount ?? 0;
                $titleText = $load->fee->fee_type;
                break;
            default:
                $primaryFee = $load->fee->freight_amount ?? 0;
                $titleText = 'Primary Fee';
                break;
        }

        $total = $primaryFee + $detention + $lumper + $stopOff + $tarpFee + $accessorialAmount;

        $grandTotal = $total - $invoiceAdvance;

        return array('total' => $total, 'grandTotal' => $grandTotal);
    }
}