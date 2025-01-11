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
                            <h2>Appointments</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments Section -->
    <div class="team-area section-padding30">
        <div class="container">
            <!-- Section Title -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">
                        <span>Manage Appointments</span>
                        <h2>Your Appointments</h2>
                    </div>
                </div>
            </div>

            <!-- Add Appointment Button -->
            <div class="text-end mb-3">
                <a class="btn btn-primary" href="{{ route('appointment.create') }}" role="button">Add Appointment</a>
            </div>

            <!-- Appointments Table -->
            <table class="table table-striped table-bordered">
                <thead class="table-gray">
                    <tr>
                        <th scope="col">Appointment ID</th>
                        <th scope="col">Patient Name</th>
                        <th scope="col">Doctor Name</th>
                        <th scope="col">Department</th>
                        <th scope="col">Appointment Date</th>
                        <th scope="col">Appointment Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->patient_name }}</td>
                            <td>{{ $appointment->doctor_name }}</td>
                            <td>{{ $appointment->department }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>{{ $appointment->appointment_time }}</td>
                            <td>
                                <!-- Edit Appointment -->
                                <a class="text-primary" href="{{ route('appointment.edit', $appointment->id) }}">✏️</a>

                                <!-- Delete Appointment -->
                                <form action="{{ route('appointment.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger" onclick="return confirm('Are you sure you want to delete this appointment?')">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No appointments available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</main>

@endsection
