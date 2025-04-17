@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Inspection Date & Time</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('inspection.updatedatetime', $request->id) }}">
        @csrf
        {{-- Removed @method('PUT') to match the POST route --}}
        
        <div class="mb-3">
            <label for="inspection_date">Inspection Date:</label>
            <input type="date" name="inspection_date" id="inspection_date" class="form-control"
                   value="{{ $request->inspection_date }}" required>
        </div>
        
        <div class="mb-3">
            {{-- Show currently chosen time slot (read-only) --}}
            <p><strong>Current Time Chosen by Admin:</strong> {{ $request->inspection_time }}</p>
            <label for="inspection_time">Inspection Time:</label>
            <select name="inspection_time" id="inspection_time" class="form-control" required>
                <option selected disabled>Select Time Slot</option>
                @foreach($timeSlots as $slot)
                    <option value="{{ $slot }}" {{ $slot == $request->inspection_time ? 'selected' : '' }}>{{ $slot }}</option>
                @endforeach
            </select>
        </div>
        
        {{-- Include jQuery if not already --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script>
            $('#inspection_date').on('change', function () {
                let date = $(this).val();
                let id = {{ $request->id }}; // pass current request ID to exclude from query
        
                $.ajax({
                    url: '{{ route('inspection.available-slots') }}',
                    method: 'GET',
                    data: { date: date, id: id },
                    success: function (slots) {
                        let dropdown = $('#inspection_time');
                        dropdown.empty();
                        if (slots.length > 0) {
                            dropdown.append('<option disabled selected>Select Time Slot</option>');
                            slots.forEach(function (slot) {
                                dropdown.append(`<option value="${slot}">${slot}</option>`);
                            });
                        } else {
                            dropdown.append('<option disabled selected>No slots available</option>');
                        }
                    },
                    error: function () {
                        alert('Failed to load time slots.');
                    }
                });
            });
        </script>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection





