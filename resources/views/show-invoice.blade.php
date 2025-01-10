@extends('master.layout')
@section('content')
<!DOCTYPE html>
<div class="container">
    <h1>Invoice Details</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="invoice-details">
        <h2>Invoice ID: {{ $invoice->invoice_id }}</h2>
        <p><strong>Bill Date:</strong> {{ $invoice->bill_date }}</p>
        <p><strong>Delivery Date:</strong> {{ $invoice->delivery_date }}</p>
        <p><strong>Payment Deadline:</strong> {{ $invoice->payment_deadline }}</p>
        <p><strong>Terms of Payment:</strong> Within 15 Days</p>
        <h3>Patient Details</h3>
        <p><strong>Patient Name:</strong> {{ $invoice->patient_name }}</p>
        <p><strong>Billing Address:</strong> {{ $invoice->billing_address }}</p>
        <p><strong>Contact Info:</strong> {{ $invoice->contact_info }}</p>
        <p><strong>Email:</strong> {{ $invoice->email }}</p>
        <h3>Invoice Items</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price (MYR)</th>
                    <th>VAT (%)</th>
                    <th>Final Amount (MYR)</th>
                </tr>
            </thead>
            <tbody>
                @if($invoice->items && count($invoice->items) > 0)
                    @foreach($invoice->items as $item)
                        <tr>
                            <td>{{ $item['description'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'], 2) }}</td>
                            <td>{{ number_format($item['vat'], 2) }}</td>
                            <td>{{ number_format($item['final_amount'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No items found for this invoice.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <h3>Summary</h3>
        <p><strong>Subtotal:</strong> MYR {{ number_format($invoice->subtotal, 2) }}</p>
        <p><strong>VAT Total:</strong> MYR {{ number_format($invoice->vat_total, 2) }}</p>
        <p><strong>Total Amount:</strong> MYR {{ number_format($invoice->total_amount, 2) }}</p>
        <p><strong>Payment Status:</strong>
            <span class="{{ $invoice->payment_status === 'PAID' ? 'text-success' : 'text-danger' }}">
                {{ $invoice->payment_status }}
            </span>
        </p>
    </div>
    <a href="{{ route('billing-list') }}" class="btn btn-secondary">Back to Billing List</a>
</div>
@endsection