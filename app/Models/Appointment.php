<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //use HasFactory;

    use HasFactory;

    protected $fillable = [
        'patient_name',
        'doctor_name',
        'department',
        'appointment_date',
        'appointment_time',
    ];
}

