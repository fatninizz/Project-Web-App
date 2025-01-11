@extends('master.layout')
@section('content')

<main>
    <!-- Hero Section -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 text-center">
                            <h2>Add Appointment</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Appointment Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Create New Appointment</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display validation errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Appointment Form -->
                        <form action="{{ route('appointment.store') }}" method="POST">
                            @csrf

                            <!-- Patient Name -->
                            <div class="mb-3">
                                <label for="patient_name" class="form-label">Patient Name</label>
                                <input type="text" name="patient_name" id="patient_name" class="form-control" placeholder="Enter patient name" value="{{ old('patient_name') }}" required>
                            </div>

                            <!-- Doctor Name -->
                            <div class="mb-3">
                                <label for="doctor_name" class="form-label">Doctor Name</label>
                                <select name="doctor_name" id="doctor_name" class="form-control" required>
                                    <option value="" disabled selected>Select a doctor</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->name }}" {{ old('doctor_name') == $doctor->name ? 'selected' : '' }}>
                                            {{ $doctor->name }} - {{ $doctor->department }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Department -->
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select name="department" id="department" class="form-control" required>
                                    <option value="" disabled selected>Select a department</option>
                                    <option value="Cardiology" {{ old('department') == 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                                    <option value="Neurology" {{ old('department') == 'Neurology' ? 'selected' : '' }}>Neurology</option>
                                    <option value="Orthopedics" {{ old('department') == 'Orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                                    <option value="Pediatrics" {{ old('department') == 'Pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                                </select>
                            </div>

                            <!-- Appointment Date -->
                            <div class="mb-3">
                                <label for="appointment_date" class="form-label">Appointment Date</label>
                                <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ old('appointment_date') }}" required>
                            </div>

                            <!-- Appointment Time -->
                            <div class="mb-3">
                                <label for="appointment_time" class="form-label">Appointment Time</label>
                                <input type="time" name="appointment_time" id="appointment_time" class="form-control" value="{{ old('appointment_time') }}" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Add Appointment</button>
                                <a href="{{ route('appointment.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
