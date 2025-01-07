<?php
namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Http\Request;

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
    $invoice = Invoice::findOrFail($id); // Fetch billing data by ID
    return view('show-invoice', compact('invoice')); // Use 'invoice' as the variable name
}


}
