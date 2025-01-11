<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DrugController;

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

Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor.index');
Route::get('/add-doctor', [DoctorController::class, 'create'])->name('doctor.create');
Route::post('/add-doctor', [DoctorController::class, 'store'])->name('doctor.store');
Route::get('/doctor/{id}/edit', [DoctorController::class, 'edit'])->name('doctor.edit');
Route::put('/doctor/{id}', [DoctorController::class, 'update'])->name('doctor.update');
Route::delete('/doctor/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
// Route::resource('doctor', DoctorController::class);
// Route::resource('doctor', DoctorController::class);
// Route::get('/add-doctor', function () {
//     return view('add-doctor');
// });
Route::get('/pharmacy', [DrugController::class, 'index'])->name('pharmacy.index');
Route::post('/drugs', [DrugController::class, 'store'])->name('drugs.store');
Route::put('/drugs/{id}', [DrugController::class, 'update'])->name('drugs.update');
Route::delete('/drugs/{id}', [DrugController::class, 'destroy'])->name('drugs.destroy');
