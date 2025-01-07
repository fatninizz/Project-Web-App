<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('bill_date');
            $table->date('delivery_date');
            $table->date('payment_deadline');
            $table->string('patient_name');
            $table->string('billing_address');
            $table->string('contact_info');
            $table->string('email');
            $table->string('invoice_id')->unique();
            $table->json('description')->nullable();
            $table->json('quantity')->nullable();
            $table->json('price')->nullable();
            $table->json('vat')->nullable();
            $table->json('final_amount')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};

