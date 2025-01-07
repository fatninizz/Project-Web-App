<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'bill_date',
        'delivery_date',
        'payment_deadline',
        'patient_name',
        'billing_address',
        'contact_info',
        'email',
        'invoice_id',
        'description',
        'quantity',
        'price',
        'vat',
        'final_amount'
    ];

    protected $dates = [
        'bill_date',
        'delivery_date',
        'payment_deadline'
    ];
}
