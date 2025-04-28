@extends('layouts.app')

@section('content')
    <h1>Rent a Car</h1>
    <link rel="stylesheet" href="{{ asset('assets/css/carowner/rent-car.css') }}">
    <form action="{{ route('carowner.storeRentCar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

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

        {{-- NEW FEATURES START HERE --}}

        <h3>Car Features</h3>

        <label for="number_of_doors">Number of Doors:</label>
        <input type="number" name="number_of_doors" id="number_of_doors" value="{{ old('number_of_doors') }}">
        @error('number_of_doors')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="number_of_seats">Number of Seats:</label>
        <input type="number" name="number_of_seats" id="number_of_seats" value="{{ old('number_of_seats') }}">
        @error('number_of_seats')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="transmission_type">Transmission Type:</label>
        <select name="transmission_type" id="transmission_type">
            <option value="">Select transmission</option>
            <option value="Automatic" {{ old('transmission_type') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
            <option value="Manual" {{ old('transmission_type') == 'Manual' ? 'selected' : '' }}>Manual</option>
        </select>
        @error('transmission_type')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="large_bags_capacity">Large Bags Capacity:</label>
        <input type="number" name="large_bags_capacity" id="large_bags_capacity" value="{{ old('large_bags_capacity') }}">
        @error('large_bags_capacity')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="small_bags_capacity">Small Bags Capacity:</label>
        <input type="number" name="small_bags_capacity" id="small_bags_capacity" value="{{ old('small_bags_capacity') }}">
        @error('small_bags_capacity')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

         <!-- Fuel Type Field Added -->
         <label for="fuel_type">Fuel Type:</label>
         <select name="fuel_type" id="fuel_type">
             <option value="">Select fuel type</option>
             <option value="Petrol" {{ old('fuel_type') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
             <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
             <option value="Electric" {{ old('fuel_type') == 'Electric' ? 'selected' : '' }}>Electric</option>
             <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
         </select>
         @error('fuel_type')
             <span style="color: red;">{{ $message }}</span>
         @enderror
         <br>
        <!-- Air Conditioning -->
        <label for="air_conditioning">Air Conditioning:</label><br>
        <input type="radio" name="air_conditioning" value="Yes" 
            {{ old('air_conditioning') == 'Yes' ? 'checked' : '' }}> Yes
        <input type="radio" name="air_conditioning" value="No" 
            {{ old('air_conditioning') == 'No' ? 'checked' : '' }}> No
        @error('air_conditioning')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        <!-- Backup Camera -->
        <label for="backup_camera">Backup Camera:</label><br>
        <input type="radio" name="backup_camera" value="Yes" 
            {{ old('backup_camera') == 'Yes' ? 'checked' : '' }}> Yes
        <input type="radio" name="backup_camera" value="No" 
            {{ old('backup_camera') == 'No' ? 'checked' : '' }}> No
        @error('backup_camera')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        <!-- Bluetooth -->
        <label for="bluetooth">Bluetooth:</label><br>
        <input type="radio" name="bluetooth" value="Yes" 
            {{ old('bluetooth') == 'Yes' ? 'checked' : '' }}> Yes
        <input type="radio" name="bluetooth" value="No" 
            {{ old('bluetooth') == 'No' ? 'checked' : '' }}> No
        @error('bluetooth')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>




        {{-- NEW FEATURES END HERE --}}

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
