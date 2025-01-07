@extends('master.layout')
@section('content')

<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-8 text-center">New Invoice</h1>

        <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
            <!-- Hospital Info -->
            <div class="flex items-center mb-8">
                <img src="{{ asset('path/to/logo.png') }}" alt="Medical Logo" class="h-12 mr-4">
                <div>
                    <h2 class="text-xl font-bold">Hospital Kuala Lumpur</h2>
                    <p>No. 123, Jalan Kesihatan, 50450 Kuala Lumpur, Malaysia</p>
                    <p>+60-1-1234-5678</p>
                    <p>billing@kl@moh.gov.my</p>
                </div>
            </div>

            <form action="{{ route('billing.store') }}" method="POST">
                @csrf
                <!-- Invoice Details -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block mb-2">Bill Date</label>
                        <input type="date" name="bill_date" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block mb-2">Delivery Date</label>
                        <input type="date" name="delivery_date" class="w-full border rounded p-2">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2">Payment Deadline</label>
                    <input type="date" name="payment_deadline" class="w-full border rounded p-2">
                    <p class="text-sm text-gray-600 mt-1">Within 15 days</p>
                </div>

                <!-- Patient Info -->
                <div class="mb-6">
                    <label class="block mb-2">Patient Name</label>
                    <select name="patient_name" class="w-full border rounded p-2">
                        <option value="">Select patient name</option>
                        <!-- Add your patient options here -->
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block mb-2">Billing Address</label>
                    <textarea name="billing_address" class="w-full border rounded p-2" rows="3"></textarea>
                </div>

                <div class="mb-6">
                    <label class="block mb-2">Contact</label>
                    <input type="text" name="contact" class="w-full border rounded p-2">
                </div>

                <div class="mb-6">
                    <label class="block mb-2">Invoice ID</label>
                    <input type="text" name="invoice_id" class="w-full border rounded p-2">
                </div>

                <!-- Invoice Items -->
                <table class="w-full mb-6">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">NO.</th>
                            <th class="text-left py-2">DESCRIPTION</th>
                            <th class="text-right py-2">QUANTITY</th>
                            <th class="text-right py-2">PRICE (MYR)</th>
                            <th class="text-right py-2">VAT</th>
                            <th class="text-right py-2">FINAL AMOUNT (MYR)</th>
                            <th class="text-center py-2">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-items">
                        <tr>
                            <td>1</td>
                            <td><input type="text" name="items[0][description]" class="w-full border rounded p-1"></td>
                            <td><input type="number" name="items[0][quantity]" class="w-full border rounded p-1"></td>
                            <td><input type="number" step="0.01" name="items[0][price]" class="w-full border rounded p-1"></td>
                            <td><input type="number" step="0.01" name="items[0][vat]" class="w-full border rounded p-1"></td>
                            <td class="final-amount">0.00</td>
                            <td class="text-center">
                                <button type="button" class="text-red-500 delete-row">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" id="add-row" class="bg-blue-500 text-white px-4 py-2 rounded mb-6">
                    Add row
                </button>

                <!-- Totals -->
                <div class="flex justify-end space-x-4 mb-6">
                    <div>
                        <p>Subtotal</p>
                        <p>VAT (%)</p>
                        <p class="font-bold">Total Amount</p>
                    </div>
                    <div class="text-right">
                        <p>MYR <span id="subtotal">0.00</span></p>
                        <p>MYR <span id="total-vat">0.00</span></p>
                        <p class="font-bold">MYR <span id="total-amount">0.00</span></p>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2">Payment Status</label>
                    <select name="payment_status" class="w-full border rounded p-2">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" class="bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const invoiceItems = document.getElementById('invoice-items');
        const addRowButton = document.getElementById('add-row');

        // Add new row
        addRowButton.addEventListener('click', function() {
            const newRow = document.createElement('tr');
            const rowCount = invoiceItems.children.length;
            newRow.innerHTML = `
                <td>${rowCount + 1}</td>
                <td><input type="text" name="items[${rowCount}][description]" class="w-full border rounded p-1"></td>
                <td><input type="number" name="items[${rowCount}][quantity]" class="w-full border rounded p-1"></td>
                <td><input type="number" step="0.01" name="items[${rowCount}][price]" class="w-full border rounded p-1"></td>
                <td><input type="number" step="0.01" name="items[${rowCount}][vat]" class="w-full border rounded p-1"></td>
                <td class="final-amount">0.00</td>
                <td class="text-center">
                    <button type="button" class="text-red-500 delete-row">Delete</button>
                </td>
            `;
            invoiceItems.appendChild(newRow);
            updateCalculations();
        });

        // Delete row
        invoiceItems.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-row')) {
                e.target.closest('tr').remove();
                updateCalculations();
            }
        });

        // Update calculations when inputs change
        invoiceItems.addEventListener('input', updateCalculations);

        function updateCalculations() {
            let subtotal = 0;
            let totalVat = 0;

            document.querySelectorAll('#invoice-items tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
                const price = parseFloat(row.querySelector('input[name*="[price]"]').value) || 0;
                const vat = parseFloat(row.querySelector('input[name*="[vat]"]').value) || 0;

                const rowTotal = quantity * price;
                const rowVat = rowTotal * (vat / 100);
                const finalAmount = rowTotal + rowVat;

                row.querySelector('.final-amount').textContent = finalAmount.toFixed(2);
                subtotal += rowTotal;
                totalVat += rowVat;
            });

            const totalAmount = subtotal + totalVat;

            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('total-vat').textContent = totalVat.toFixed(2);
            document.getElementById('total-amount').textContent = totalAmount.toFixed(2);
        }
    });
</script>
@endpush

@endsection
