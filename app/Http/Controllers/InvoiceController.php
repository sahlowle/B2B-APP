<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::orderBy('created_at', 'desc');

        if ($request->user()->isVendor()) {
            $query->where('user_id', request()->user()->id);
        }

        $invoices = $query->paginate(15);

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('admin.invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|size:3',
            'total_amount' => 'required|numeric|min:1',
            'invoice_file' => 'required|file|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $invoice = new Invoice();
            $invoice->user_id = $request->user()->id;
            $invoice->invoice_number = Invoice::generateInvoiceNumber();
            $invoice->currency = $request->currency;
            $invoice->total_amount = $request->total_amount;

            if ($request->hasFile('invoice_file')) {
                $path = $request->file('invoice_file')->store('invoices', 'public');
                $invoice->invoice_file = $path;
            }

            $invoice->save();

            DB::commit();

            return redirect()->route('invoices.index')
                ->with('success', 'Invoice created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }

    public function show(Invoice $invoice)
    {
        $this->authorizeInvoiceAccess($invoice, 'view');
        
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $this->authorizeInvoiceAccess($invoice, 'edit');

        return view('admin.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->authorizeInvoiceAccess($invoice, 'edit');

        $request->validate([
            'currency' => 'required|string|size:3',
            'total_amount' => 'required|numeric|min:0',
            'invoice_file' => 'nullable|file|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $invoice->currency = $request->currency;
            $invoice->total_amount = $request->total_amount;

            if ($request->hasFile('invoice_file')) {
                // delete old file if exists
                if ($invoice->invoice_file && Storage::disk('public')->exists($invoice->invoice_file)) {
                    Storage::disk('public')->delete($invoice->invoice_file);
                }
                $path = $request->file('invoice_file')->store('invoices', 'public');
                $invoice->invoice_file = $path;
            }

            $invoice->save();

            DB::commit();

            return redirect()->route('invoices.index')
                ->with('success', 'Invoice updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    public function destroy(Invoice $invoice)
    {
        $this->authorizeInvoiceAccess($invoice, 'delete');
        
        try {
            if ($invoice->invoice_file && Storage::disk('public')->exists($invoice->invoice_file)) {
                Storage::disk('public')->delete($invoice->invoice_file);
            }
            $invoice->delete();
            return redirect()->route('invoices.index')
                ->with('success', 'Invoice deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')
                ->with('error', 'Error deleting invoice: ' . $e->getMessage());
        }
    }

    public function downlopadPdf(Invoice $invoice)
    {
        $this->authorizeInvoiceAccess($invoice, 'view');

        $file_path = $invoice->invoice_file;

        return Storage::disk('public')->download($file_path, 'invoice_' . $invoice->id . '.pdf');
        
    }

    public function print(Invoice $invoice)
    {
        $this->authorizeInvoiceAccess($invoice, 'view');

        $file_path = $invoice->invoice_file;

        return Storage::disk('public')->download($file_path, 'invoice_' . $invoice->id . '.pdf');
            
    }

    protected function authorizeInvoiceAccess(Invoice $invoice, string $action = 'access')
    {
        $user = auth()->user();
        
        if ($invoice->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, "You are not authorized to {$action} this invoice");
        }
    }
}
