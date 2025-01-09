<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = DB::table('doctors')
        ->orderBy('updated_at', 'asc')
        ->get();

        return view('doctorpage', ['doctors'=>$doctors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $doctor= new Doctor();
        $doctor->doctor_id=$request->doctor_id;
        $doctor->doctor_name=$request->doctor_name;
        $doctor->department=$request->department;
        $doctor->email_address=$request->email;
        $doctor->schedule=$request->schedule;
        $doctor->contact_no=$request->contact_no;
        $doctor->created_at=today();
        $doctor->updated_at=today();
        $doctor->save();
        return redirect('doctorpage');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
