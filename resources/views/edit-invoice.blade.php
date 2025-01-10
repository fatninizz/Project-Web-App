@extends('master.layout')
@section('title', 'Edit Invoice')
@section('content')

<div class="container">
    <h2>Edit Invoice</h2>

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="invoice-form" action="{{ route('invoice.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-section">
            <div>
                <label for="bill_date">Bill Date:</label>
                <input type="date" id="bill_date" name="bill_date" value="{{ old('bill_date', $invoice->bill_date) }}" required>
            </div>
            <div>
                <label for="delivery_date">Delivery Date:</label>
                <input type="date" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $invoice->delivery_date) }}" required>
            </div>
            <div>
                <label for="payment_deadline">Payment Deadline:</label>
                <input type="date" id="payment_deadline" name="payment_deadline" value="{{ old('payment_deadline', $invoice->payment_deadline) }}" required>
            </div>
        </div>

        <div class="form-section">
            <div>
                <label for="patient_name">Patient Name:</label>
                <input type="text" id="patient_name" name="patient_name" value="{{ old('patient_name', $invoice->patient_name) }}" required>
            </div>
            <div>
                <label for="billing_address">Billing Address:</label>
                <input type="text" id="billing_address" name="billing_address" value="{{ old('billing_address', $invoice->billing_address) }}" required>
            </div>
            <div>
                <label for="contact_info">Contact Number:</label>
                <input type="text" id="contact_info" name="contact_info" value="{{ old('contact_info', $invoice->contact_info) }}" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $invoice->email) }}" required>
            </div>
            <div>
                <label for="invoice_id">Invoice ID:</label>
                <input type="text" id="invoice_id" name="invoice_id" value="{{ old('invoice_id', $invoice->invoice_id) }}" required>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price (MYR)</th>
                    <th>VAT</th>
                    <th>Final Amount (MYR)</th>
                    <th>Actions</th>
                </tr>
            </thead>
           <tbody id="invoice-items">
    @if(!empty($invoice->items) && $invoice->items->count())
        @foreach($invoice->items as $item)
            <tr>
                <td><input type="text" name="description[]" value="{{ $item->description }}" /></td>
                <td><input type="number" name="quantity[]" value="{{ $item->quantity }}" /></td>
                <td><input type="number" step="0.01" name="price[]" value="{{ $item->price }}" /></td>
                <td><input type="number" step="0.01" name="vat[]" value="{{ $item->vat }}" /></td>
                <td><input type="number" step="0.01" name="final_amount[]" value="{{ $item->final_amount }}" /></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">No items found.</td>
        </tr>
    @endif
</tbody>

        </table>
        <button type="button" class="btn" onclick="addRow()">Add Row</button>

        <div class="summary-section">
            <p>Subtotal: <input type="number" step="0.01" id="subtotal" name="subtotal" value="{{ old('subtotal', $invoice->subtotal) }}" readonly></p>
            <p>VAT Total: <input type="number" step="0.01" id="vat-total" name="vat_total" value="{{ old('vat_total', $invoice->vat_total) }}" readonly></p>
            <p>Total Amount: <input type="number" step="0.01" id="total-amount" name="total_amount" value="{{ old('total_amount', $invoice->total_amount) }}" readonly></p>

            <label for="payment_status">Payment Status:</label>
            <select name="payment_status" id="payment_status" required>
                <option value="PAID" {{ old('payment_status', $invoice->payment_status) == 'PAID' ? 'selected' : '' }}>PAID</option>
                <option value="UNPAID" {{ old('payment_status', $invoice->payment_status) == 'UNPAID' ? 'selected' : '' }}>UNPAID</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Invoice</button>
        <button type="button" class="btn btn-cancel" onclick="window.location.href='{{ route('billing-list') }}'">Cancel</button>
    </form>

    <script>
        // document.getElementById('invoice-form').addEventListener('submit', function(e) {
        //     e.preventDefault();

            // Collect items data
            const items = [];
            document.querySelectorAll('#invoice-items tr').forEach(row => {
                items.push({
                    description: row.querySelector('input[name="description[]"]').value,
                    quantity: row.querySelector('input[name="quantity[]"]').value,
                    price: row.querySelector('input[name="price[]"]').value,
                    vat: row.querySelector('input[name="vat[]"]').value,
                    final_amount: row.querySelector('input[name="final_amount[]"]').value
                });
            });

            // Add hidden input for items
            const itemsInput = document.createElement('input');
            itemsInput.type = 'hidden';
            itemsInput.name = 'items';
            itemsInput.value = JSON.stringify(items);
            this.appendChild(itemsInput);

            // Submit the form
            this.submit();
        });

        function calculateFinalAmount(element) {
            const row = element.closest('tr');
            const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
            const price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
            const vat = parseFloat(row.querySelector('input[name="vat[]"]').value) || 0;

            const finalAmount = quantity * price;
            const vatTotal = finalAmount * (vat / 100);
            const totalAmount = finalAmount + vatTotal;

            row.querySelector('input[name="final_amount[]"]').value = finalAmount.toFixed(2);

            updateSummary();
        }

        function updateSummary() {
            const rows = document.querySelectorAll('#invoice-items tr');
            let subtotal = 0;
            let vatTotal = 0;
            let totalAmount = 0;

            rows.forEach(row => {
                const finalAmount = parseFloat(row.querySelector('input[name="final_amount[]"]').value) || 0;
                const vat = parseFloat(row.querySelector('input[name="vat[]"]').value) || 0;

                subtotal += finalAmount;
                vatTotal += finalAmount * (vat / 100);
            });

            totalAmount = subtotal + vatTotal;

            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('vat-total').value = vatTotal.toFixed(2);
            document.getElementById('total-amount').value = totalAmount.toFixed(2);
        }

        function addRow() {
            const table = document.getElementById('invoice-items');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" name="description[]" placeholder="Enter treatment/service received" required></td>
                <td><input type="number" name="quantity[]" value="0" required oninput="calculateFinalAmount(this)"></td>
                <td><input type="number" step="0.01" name="price[]" value="0.00" required oninput="calculateFinalAmount(this)"></td>
                <td><input type="number" step="0.01" name="vat[]" value="0.00" oninput="calculateFinalAmount(this)"></td>
                <td><input type="number" step="0.01" name="final_amount[]" value="0.00" readonly></td>
                <td><button type="button" onclick="removeRow(this)">Remove</button></td>
            `;
            table.appendChild(row);
        }

        function removeRow(button) {
            const row = button.closest('tr');
            row.remove();
            updateSummary();
        }
    </script>
</div>
@endsection

