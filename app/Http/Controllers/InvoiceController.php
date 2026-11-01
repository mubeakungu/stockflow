<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Invoice::class);
        
        $customers = Customer::all();
        $batches = Batch::where('rem_quantity', '>=', 1)->get();

        return view('invoices.create', compact('batches', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Invoice::class);

        $profit = 0;
        $current_date = Carbon::today();
        $invoice_count = Invoice::whereDate('created_at', $current_date)->count() + 1;

        $request->validate([
            "customer_id" => "required",
            "total" => "required",
            "due_amount" => "required",
            "products" => "required",
        ]);


        $products = $request['products'];
        foreach ($products as $key => $product) {
            $batch = Batch::find($product['batch_id']);
            $batch->rem_quantity -= $product['quantity'];
            $batch->update();
            $profit += $product['total'] - ($batch->purchase_price * $product['quantity']);
        };

        $invoice = new Invoice();
        $invoice->invoice_no = Carbon::now()->format('dmY') . '-' . $invoice_count;
        $invoice->customer_id = $request->customer_id;
        $invoice->total = $request->total;
        $invoice->due = $request->due_amount;

        // Automatically calculate status based on due amount
        if ($request->due_amount == 0) {
            $invoice->status = 'paid';
        } elseif ($request->due_amount == $request->total) {
            $invoice->status = 'due';
        } else {
            $invoice->status = 'partial';
        }

        $invoice->profit = $profit;
        $invoice->save();

        // Create invoice items
        foreach ($products as $product) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'batch_id' => $product['batch_id'],
                'name' => $product['name'],
                'serial_no' => $product['serial_no'] ?? null,
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total' => $product['total'],
            ]);
        }

        return redirect()->route('invoices.show', $invoice);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);
        
        $products = $invoice->items;
        return view('invoices.invoice', compact('invoice', 'products'));
    }

    /**
     * Download the specified invoice.
     */
    public function download(Invoice $invoice)
    {
        $this->authorize('view', $invoice);
        
        $products = $invoice->items;
        $html = view('invoices.invoice-download', compact('invoice', 'products'))->render();
        $filename = 'invoice-' . $invoice->invoice_no . '.html';

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => strlen($html),
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $this->authorize('update', $invoice);
        
        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);
        
        $invoice->due = $request->due_amount;

        // Automatically calculate status based on due amount
        if ($request->due_amount == 0) {
            $invoice->status = 'paid';
        } elseif ($request->due_amount == $invoice->total) {
            $invoice->status = 'due';
        } else {
            $invoice->status = 'partial';
        }

        $invoice->update();
        return redirect()->route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorize('delete', $invoice);
        
        foreach ($invoice->items as $item) {
            $batch = Batch::find($item->batch_id);
            $batch->rem_quantity += $item->quantity;
            $batch->update();
        };

        $invoice->delete();
        return redirect()->back();
    }
}
