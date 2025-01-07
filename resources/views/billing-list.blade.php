@extends('master.layout')
@section('content')

<!DOCTYPE html>
<div class="container">
    <h1>Billing List</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Invoice ID</th>
                <th>Date</th>
                <th>Patient</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->invoice_id }}</td>
                    <td>{{ $invoice->bill_date }}</td> <!-- Corrected from 'date' -->
                    <td>{{ $invoice->patient_name }}</td> <!-- Corrected from 'patient' -->
                    <td>MYR {{ number_format($invoice->total_amount, 2) }}</td>
                    <td>
                        <span class="{{ $invoice->payment_status === 'PAID' ? 'text-success' : 'text-danger' }}">
                            {{ $invoice->payment_status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('invoice.show', $invoice->id) }}" class="text-info" title="View Invoice">👁️</a>
                        <a href="#" class="text-primary">✏️</a>
                        <a href="#" class="text-danger">🗑️</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('create-invoice') }}" class="btn btn-primary">Add new billing</a>
</div>

@endsection
