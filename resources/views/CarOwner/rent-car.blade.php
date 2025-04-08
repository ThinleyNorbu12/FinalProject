@extends('layouts.app')

@section('content')
    <h1>Rent a Car</h1>
    <link rel="stylesheet" href="{{ asset('assets/css/carowner/rent-car.css') }}">
    <form action="{{ route('carowner.storeRentCar') }}" method="POST" enctype="multipart/form-data">
        @csrf
    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@csrf
    <label for="maker">Maker:</label>
    <input type="text" name="maker" id="maker" value="{{ old('maker') }}">
    @error('maker')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <label for="model">Model:</label>
    <input type="text" name="model" id="model" value="{{ old('model') }}">
    @error('model')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <label for="vehicle_type">Vehicle Type:</label>
    <select name="vehicle_type" id="vehicle_type">
        <option value="">Select a vehicle type</option>
        <option value="Sedan" {{ old('vehicle_type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
        <option value="SUV" {{ old('vehicle_type') == 'SUV' ? 'selected' : '' }}>SUV</option>
        <option value="Hatchback" {{ old('vehicle_type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
        <option value="Pickup" {{ old('vehicle_type') == 'Pickup' ? 'selected' : '' }}>Pickup</option>
    </select>
    @error('vehicle_type')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <label for="car_condition">Condition:</label>
    <select name="car_condition" id="car_condition">
        <option value="">Select condition</option>
        <option value="New" {{ old('car_condition') == 'New' ? 'selected' : '' }}>New</option>
        <option value="Used" {{ old('car_condition') == 'Used' ? 'selected' : '' }}>Used</option>
    </select>
    @error('car_condition')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <label for="mileage">Mileage (in km):</label>
    <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}">
    @error('mileage')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <label for="price">Price per Day:</label>
    <input type="number" name="price" id="price" value="{{ old('price') }}">
    @error('price')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <label for="registration_no">Registration Number:</label>
    <input type="text" name="registration_no" id="registration_no" value="{{ old('registration_no') }}">
    @error('registration_no')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="">Select status</option>
        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
        <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
    </select>
    @error('status')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <label for="description">Description:</label>
    <textarea name="description" id="description">{{ old('description') }}</textarea>
    @error('description')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <label for="car_image">Car Image:</label>
    <input type="file" name="car_image" id="car_image">
    @error('car_image')
        <span style="color: red;">{{ $message }}</span>
    @enderror
    <br>

    <button type="submit">Submit</button>
</form>
@endsection
