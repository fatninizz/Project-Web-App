<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function index()
{
    $drugs = Drug::all(); // Fetch all drugs from the database
    return view('pharmacy', compact('drugs')); // Pass data to the view
}

public function create()
{
    return view('add-drug');
}

public function edit($id)
{
    $drug = Drug::findOrFail($id); // Find the drug by its ID
    return view('edit-drug', compact('drug')); // Pass the drug data to the view
}

public function store(Request $request)
{
    $request->validate([
        'drug_name' => 'required|string|max:255',
        'manufacture_date' => 'required|date',
        'expiry_date' => 'required|date',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
    ]);

    Drug::create($request->all()); // Insert data into the database
    return redirect()->route('pharmacy')->with('success', 'Drug added successfully!');
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'drug_name' => 'required|string|max:255',
        'manufacture_date' => 'required|date',
        'expiry_date' => 'required|date',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
    ]);

    $drug = Drug::findOrFail($id);
    $drug->update($validated);

    return redirect()->route('pharmacy')->with('success', 'Drug updated successfully.');
}

public function destroy($id)
{
    $drug = Drug::findOrFail($id); // Find the drug by ID
    $drug->delete(); // Delete the drug
    return redirect()->route('pharmacy')->with('success', 'Drug deleted successfully.');
}
}
