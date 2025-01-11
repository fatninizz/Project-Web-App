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
                        <h2>Pharmacy</h2>
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
                        <span>The Medicines</span>
                        <h2>KKM Certified</h2>
                    </div>
                </div>
            </div>
            <div>
                <table class="table">
                    <thead class="table-gray">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Drug Name</th>
                            <th scope="col">Manufacture Date</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity No</th>
                            <th scope="col">Action</th>
                          </tr>
                    </thead>
            <tbody>
                @foreach($drugs as $drug)
                <tr>
                    <td>{{ $drug->id }}</td>
                    <td>{{ $drug->drug_name }}</td>
                    <td>{{ $drug->manufacture_date }}</td>
                    <td>{{ $drug->expiry_date }}</td>
                    <td>{{ $drug->price }}</td>
                    <td>{{ $drug->quantity }}</td>
                    <td>
                        <!-- Add Edit and Delete functionality -->
                        <a href="#">Edit</a>
                        <form action="{{ route('drugs.destroy', $drug->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-end">
            <a class="btn" href="{{ route('') }}" role="button">Add New Drug</a>
        </div>

    </div>
</body>
</html>

@endsection
