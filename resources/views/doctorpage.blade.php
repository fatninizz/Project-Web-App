@extends('master.layout')
@section('content')

<main>
    <!--? Hero Start -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap hero-cap2 text-center">
                        <h2>Doctors</h2>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
    <!--? Team Start -->
    <div class="team-area section-padding30">
        <div class="container">
            <!-- Section Tittle -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">

                        {{-- <p>Click the button below to create a new invoice:</p>
                        <a href="{{ route('invoice') }}" class="btn btn-primary">New Billing</a><br><br> --}}
                        <span>Our Doctors</span>
                        <h2>Our Specialist</h2>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <a class="btn" href="/add-doctor" role="button">Add doctor</a>
            </div>
            <div>
                <table class="table">
                    <thead class="table-gray">
                        <tr>
                            <th scope="col">Doctor ID</th>
                            <th scope="col">Doctor Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Schedule</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Action</th>
                          </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $doctor)
                            <tr>
                                <td>{{$doctor->doctor_id}}</td>
                                <td>{{$doctor->doctor_name}}</td>
                                <td>{{$doctor->department}}</td>
                                <td>{{$doctor->email_address}}</td>
                                <td>{{$doctor->schedule}}</td>
                                <td>{{$doctor->contact_no}}</td>
                                <td>
                                    <a href="#" class="text-primary">✏️</a>
                                    <a href="#" class="text-danger">🗑️</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <!-- Team End -->
    </main>

@endsection

{{-- Create database Doctor, Update .env file, Create Migration file for doctors table, Create add-doctor.blade.php, Update DoctorController, doctorpage.blade.php, web.php --}}
