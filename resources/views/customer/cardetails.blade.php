<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $car->maker }} {{ $car->model }} - Car Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            text-decoration: none;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .car-details-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .car-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .car-title {
            font-size: 3rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .car-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .price-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.5rem;
            font-weight: bold;
            backdrop-filter: blur(10px);
        }

        .car-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 40px;
        }

        .car-image-section {
            position: relative;
        }

        .car-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .status-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .status-available {
            background: #27ae60;
            color: white;
        }

        .status-rented {
            background: #e74c3c;
            color: white;
        }

        .status-maintenance {
            background: #f39c12;
            color: white;
        }

        .car-info-section {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        .info-card i {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #3498db;
        }

        .info-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .features-section {
            grid-column: 1 / -1;
            margin-top: 20px;
        }

        .section-title {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%);
            border-radius: 10px;
            border-left: 4px solid #27ae60;
        }

        .feature-item.unavailable {
            background: linear-gradient(135deg, #ffe8e8 0%, #fff0f0 100%);
            border-left-color: #e74c3c;
            opacity: 0.7;
        }

        .feature-item i {
            color: #27ae60;
            font-size: 1.2rem;
        }

        .feature-item.unavailable i {
            color: #e74c3c;
        }

        .description-section {
            grid-column: 1 / -1;
            margin-top: 20px;
        }

        .description-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 30px;
            border-radius: 15px;
            border-left: 5px solid #3498db;
        }

        .description-text {
            line-height: 1.6;
            color: #495057;
            font-size: 1.1rem;
        }

        .action-buttons {
            grid-column: 1 / -1;
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .btn {
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
            flex: 1;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);
        }

        @media (max-width: 768px) {
            .car-content {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 20px;
            }

            .car-title {
                font-size: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url()->previous() }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Cars
        </a>

        <div class="car-details-container">
            <div class="car-header">
                <h1 class="car-title">{{ $car->maker }} {{ $car->model }}</h1>
                <p class="car-subtitle">{{ $car->vehicle_type }} • {{ $car->car_condition }}</p>
                <div class="price-badge">
                    ${{ number_format($car->price, 2) }}/day
                </div>
            </div>

            <div class="car-content">
                <div class="car-image-section">
                    @if($car->car_image)
                        <img src="{{ asset('storage/' . $car->car_image) }}" alt="{{ $car->maker }} {{ $car->model }}" class="car-image">
                    @else
                        <div class="car-image" style="background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <i class="fas fa-car"></i>
                        </div>
                    @endif
                    
                    <div class="status-badge 
                        @if($car->status == 'available') status-available 
                        @elseif($car->status == 'rented') status-rented 
                        @else status-maintenance @endif">
                        {{ ucfirst($car->status) }}
                    </div>
                </div>

                <div class="car-info-section">
                    <div class="info-grid">
                        <div class="info-card">
                            <i class="fas fa-id-card"></i>
                            <div class="info-label">Registration No</div>
                            <div class="info-value">{{ $car->registration_no }}</div>
                        </div>

                        <div class="info-card">
                            <i class="fas fa-tachometer-alt"></i>
                            <div class="info-label">Mileage</div>
                            <div class="info-value">{{ number_format($car->mileage) }} km</div>
                        </div>

                        <div class="info-card">
                            <i class="fas fa-gas-pump"></i>
                            <div class="info-label">Fuel Type</div>
                            <div class="info-value">{{ ucfirst($car->fuel_type) }}</div>
                        </div>

                        <div class="info-card">
                            <i class="fas fa-cog"></i>
                            <div class="info-label">Transmission</div>
                            <div class="info-value">{{ ucfirst($car->transmission_type) }}</div>
                        </div>

                        <div class="info-card">
                            <i class="fas fa-users"></i>
                            <div class="info-label">Seating Capacity</div>
                            <div class="info-value">{{ $car->number_of_seats }} seats</div>
                        </div>

                        <div class="info-card">
                            <i class="fas fa-door-open"></i>
                            <div class="info-label">Number of Doors</div>
                            <div class="info-value">{{ $car->number_of_doors }} doors</div>
                        </div>

                        <div class="info-card">
                            <i class="fas fa-suitcase"></i>
                            <div class="info-label">Large Bags</div>
                            <div class="info-value">{{ $car->large_bags_capacity }}</div>
                        </div>

                        <div class="info-card">
                            <i class="fas fa-shopping-bag"></i>
                            <div class="info-label">Small Bags</div>
                            <div class="info-value">{{ $car->small_bags_capacity }}</div>
                        </div>
                    </div>
                </div>

                <div class="features-section">
                    <h3 class="section-title">
                        <i class="fas fa-star"></i>
                        Features & Amenities
                    </h3>
                    <div class="features-grid">
                        <div class="feature-item {{ $car->air_conditioning ? '' : 'unavailable' }}">
                            <i class="fas fa-snowflake"></i>
                            <span>Air Conditioning {{ $car->air_conditioning ? '✓' : '✗' }}</span>
                        </div>

                        <div class="feature-item {{ $car->backup_camera ? '' : 'unavailable' }}">
                            <i class="fas fa-video"></i>
                            <span>Backup Camera {{ $car->backup_camera ? '✓' : '✗' }}</span>
                        </div>

                        <div class="feature-item {{ $car->bluetooth ? '' : 'unavailable' }}">
                            <i class="fab fa-bluetooth"></i>
                            <span>Bluetooth {{ $car->bluetooth ? '✓' : '✗' }}</span>
                        </div>
                    </div>
                </div>

                @if($car->description)
                <div class="description-section">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Description
                    </h3>
                    <div class="description-box">
                        <p class="description-text">{{ $car->description }}</p>
                    </div>
                </div>
                @endif

                <div class="action-buttons">
                    @if($car->status == 'available')
                        <a href="{{ route('customer.book-car', $car->id) }}" class="btn btn-success">
                            <i class="fas fa-calendar-check"></i>
                            Book This Car Now
                        </a>
                    @else
                        <button class="btn btn-primary" disabled style="opacity: 0.6; cursor: not-allowed;">
                            <i class="fas fa-ban"></i>
                            Currently {{ ucfirst($car->status) }}
                        </button>
                    @endif
                    
                    {{-- <a href="{{ route('customer.cars') }}" class="btn btn-primary"> --}}
                        <i class="fas fa-search"></i>
                        Browse More Cars
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>