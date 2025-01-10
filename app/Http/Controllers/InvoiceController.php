<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;


class InvoiceController extends Controller
{
    public function create()
    {
        return view('create-invoice');
    }

    public function index()
    {
        $invoices = Invoice::all();
        return view('billing-list', compact('invoices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|string|unique:invoices,invoice_id',
            'bill_date' => 'required|date',
            'delivery_date' => 'required|date',
            'payment_deadline' => 'required|date',
            'patient_name' => 'required|string',
            'billing_address' => 'required|string',
            'contact_info' => 'required|string',
            'email' => 'required|email',
            'payment_status' => 'required|in:PAID,UNPAID'
        ]);

        try {
            $invoice = Invoice::create([
                'invoice_id' => $request->invoice_id,
                'bill_date' => $request->bill_date,
                'delivery_date' => $request->delivery_date,
                'payment_deadline' => $request->payment_deadline,
                'patient_name' => $request->patient_name,
                'billing_address' => $request->billing_address,
                'contact_info' => $request->contact_info,
                'email' => $request->email,
                'description' => $request->input('description')[0], // Getting first item
                'quantity' => $request->input('quantity')[0],
                'price' => $request->input('price')[0],
                'vat' => $request->input('vat')[0],
                'final_amount' => $request->input('final_amount')[0],
                'payment_status' => $request->payment_status
            ]);

            return redirect()->route('billing-list')->with('success', 'Invoice created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to create invoice: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        return view('show-invoice', compact('invoice'));
    }

    public function edit($id)
    {
    $invoice = Invoice::with('items')->findOrFail($id);
    return view('edit-invoice', compact('invoice'));
    }


    public function update(Request $request, $id)
{
    // Step 1: Validate input data
    $validated = $request->validate([
        'description' => 'required|array', // Ensure 'description' is an array
        'description.*' => 'string', // Each item in the 'description' array must be a string
        'quantity' => 'required|array', // Ensure 'quantity' is an array
        'quantity.*' => 'numeric', // Each item in the 'quantity' array must be numeric
        'price' => 'required|array', // Ensure 'price' is an array
        'price.*' => 'numeric', // Each item in the 'price' array must be numeric
        'final_amount' => 'required|array', // Ensure 'final_amount' is an array
        'final_amount.*' => 'numeric', // Each item in the 'final_amount' array must be numeric
    ]);

    // Step 2: Retrieve the invoice
    $invoice = Invoice::findOrFail($id);

    // Step 3: Update the invoice details
    $invoice->update([
        'bill_date' => $request->bill_date,
        'delivery_date' => $request->delivery_date,
        'payment_deadline' => $request->payment_deadline,
        'patient_name' => $request->patient_name,
        'billing_address' => $request->billing_address,
        'contact_info' => $request->contact_info,
        'email' => $request->email,
        'invoice_id' => $request->invoice_id,
        'subtotal' => $request->subtotal,
        'vat_total' => $request->vat_total,
        'total_amount' => $request->total_amount,
        'payment_status' => $request->payment_status,
    ]);

    // Step 4: Delete old invoice items
    $invoice->items()->delete();

    // Step 5: Insert new items, with checks for null or empty fields
    if (!empty($request->description) && !empty($request->quantity) && !empty($request->price) && !empty($request->final_amount)) {
        foreach ($request->description as $index => $desc) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $desc,
                'quantity' => $request->quantity[$index] ?? 0, // Default to 0 if quantity is missing
                'price' => $request->price[$index] ?? 0, // Default to 0 if price is missing
                'vat' => $request->vat[$index] ?? 0, // Default to 0 if vat is missing
                'final_amount' => $request->final_amount[$index] ?? 0, // Default to 0 if final_amount is missing
            ]);
        }
    } else {
        return redirect()->back()->with('error', 'Invoice items are required.');
    }

    // Step 6: Redirect to the billing list with success message
    return redirect()->route('billing-list')->with('success', 'Invoice updated successfully!');
    }

    public function destroy($id)
    {
    // Find the invoice
    $invoice = Invoice::findOrFail($id);

    // Delete associated items first
    $invoice->items()->delete();

    // Delete the invoice itself
    $invoice->delete();

    return response()->json([
        'success' => true,
        'message' => 'Invoice deleted successfully!',
    ]);
    }

}