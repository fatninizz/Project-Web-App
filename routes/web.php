<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DoctorController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/billing-list', [InvoiceController::class, 'index'])->name('billing-list');
Route::get('/create-invoice', [InvoiceController::class, 'create'])->name('create-invoice');
Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
Route::post('/invoice/{id}/update', [InvoiceController::class, 'update'])->name('invoice.update');
Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');

Route::get('/doctorpage', [DoctorController::class, 'index'])->name('doctorpage');
Route::resource('adddoctor', DoctorController::class);
Route::get('/add-doctor', function () {
    return view('add-doctor');
});