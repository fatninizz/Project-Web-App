<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointment', function (Blueprint $table) {

                $table->id();
                $table->string('Appointment_id', 4);
                $table->string('Patient_id', 30);
                $table->string('doctor_id', 20);
                $table->string('Appointment_Date')->unique();
                $table->string('Appointment_Time', 30);
                $table->string('contact_no', 20);
                $table->timestamps();
        });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
    }
};

