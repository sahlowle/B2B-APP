<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $users = User::where('status', 'Active')->get();
        return view('admin.invoices.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'currency' => 'required|string|size:3',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $invoice = new Invoice();
            $invoice->invoice_number = Invoice::generateInvoiceNumber();
            $invoice->customer_name = $request->customer_name;
            $invoice->customer_email = $request->customer_email;
            $invoice->customer_phone = $request->customer_phone;
            $invoice->customer_address = $request->customer_address;
            $invoice->billing_address = $request->billing_address;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->due_date = $request->due_date;
            $invoice->tax_rate = $request->tax_rate ?? 0;
            $invoice->discount_amount = $request->discount_amount ?? 0;
            $invoice->notes = $request->notes;
            $invoice->terms_conditions = $request->terms_conditions;
            $invoice->currency = $request->currency;
            $invoice->status = $request->status ?? 'draft';
            $invoice->user_id = auth()->id();
            $invoice->save();

            // Add invoice items
            foreach ($request->items as $itemData) {
                $item = new InvoiceItem();
                $item->invoice_id = $invoice->id;
                $item->description = $itemData['description'];
                $item->quantity = $itemData['quantity'];
                $item->unit_price = $itemData['unit_price'];
                $item->calculateTotal();
                $item->save();
            }

            // Calculate totals
            $invoice->calculateTotals();
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
        $invoice->load('items');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $users = User::where('status', 'Active')->get();
        $invoice->load('items');
        return view('admin.invoices.edit', compact('invoice', 'users'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'currency' => 'required|string|size:3',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $invoice->customer_name = $request->customer_name;
            $invoice->customer_email = $request->customer_email;
            $invoice->customer_phone = $request->customer_phone;
            $invoice->customer_address = $request->customer_address;
            $invoice->billing_address = $request->billing_address;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->due_date = $request->due_date;
            $invoice->tax_rate = $request->tax_rate ?? 0;
            $invoice->discount_amount = $request->discount_amount ?? 0;
            $invoice->notes = $request->notes;
            $invoice->terms_conditions = $request->terms_conditions;
            $invoice->currency = $request->currency;
            $invoice->status = $request->status ?? 'draft';
            $invoice->save();

            // Delete existing items
            $invoice->items()->delete();

            // Add new invoice items
            foreach ($request->items as $itemData) {
                $item = new InvoiceItem();
                $item->invoice_id = $invoice->id;
                $item->description = $itemData['description'];
                $item->quantity = $itemData['quantity'];
                $item->unit_price = $itemData['unit_price'];
                $item->calculateTotal();
                $item->save();
            }

            // Calculate totals
            $invoice->calculateTotals();
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
        try {
            $invoice->delete();
            return redirect()->route('invoices.index')
                ->with('success', 'Invoice deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')
                ->with('error', 'Error deleting invoice: ' . $e->getMessage());
        }
    }

    public function pdf(Invoice $invoice)
    {
        $invoice->load('items');
        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('items');
        return view('admin.invoices.print', compact('invoice'));
    }
}
