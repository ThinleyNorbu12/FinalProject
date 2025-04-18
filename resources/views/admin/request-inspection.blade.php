@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Request for Car Inspection</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Car Information --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Car Details</div>
        <div class="card-body">
            <p><strong>Maker:</strong> {{ $car->maker }}</p>
            <p><strong>Model:</strong> {{ $car->model }}</p>
            <p><strong>Registration Number:</strong> {{ $car->registration_no }}</p>
        </div>
    </div>

    {{-- Car Owner Information --}}
    <div class="car-owner-info mt-4">
        <h4>Registered By:</h4>
        @if($car->owner)
            <p><strong>Name:</strong> {{ $car->owner->name }}</p>
            <p><strong>Email:</strong> {{ $car->owner->email }}</p>
        @else
            <p>Unknown Owner</p>
        @endif
    </div>

    {{-- Inspection Request Form --}}
    <form action="{{ url('car-admin/submit-inspection-request/' . $car->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">Inspection Date:</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time">Inspection Time:</label>
            <select id="time" name="time" class="form-control" required>
                <option value="">-- Select Date First --</option>
            </select>
        </div>

        <div class="form-group">
            <label for="location">Inspection Location:</label>
            <input type="text" id="location" name="location" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="details">Additional Details:</label>
            <textarea id="details" name="details" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Inspection Request</button>
    </form>
</div>
{{-- Include jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#date').on('change', function () {
    const selectedDate = $(this).val();

    $.ajax({
        url: "{{ route('car-admin.getAvailableTimes') }}",
        type: "GET",
        data: { date: selectedDate },
        success: function (response) {
            let options = '<option value="">-- Select Time Slot --</option>';

            if (response.length === 0) {
                options += '<option disabled>No available time slots</option>';
            } else {
                response.forEach(slot => {
                    options += `<option value="${slot}">${slot}</option>`;
                });
            }

            $('#time').html(options);
        },
        error: function () {
            alert('Failed to load time slots. Please try again.');
            $('#time').html('<option value="">-- Select Date First --</option>');
        }
    });
});

</script>


@endsection
