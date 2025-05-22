@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('assets/css/admin/cars.css') }}">

@section('content')
<div class="dashboard-content" id="dashboardContent">
    <!-- Breadcrumb Navigation -->
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fas fa-home"></i>
                <a href="{{ route('admin.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('cars.index') }}">Cars Management</a>
            </li>
            <li class="breadcrumb-item active">View Car</li>
        </ol>
    </nav>

    <!-- Car Details -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>{{ $car->maker }} {{ $car->model }}</h2>
            <div>
                <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Car
                </a>
                <a href="{{ route('cars.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Car Images -->
            <div class="row">
                <div class="col-md-12">
                    <h4>Car Images</h4>
                    <div class="car-images-gallery">
                        <?php
                        // Collect all images: primary + additional
                        $allImages = [];
                        
                        // Add primary image if exists
                        if ($car->car_image && !empty(trim($car->car_image))) {
                            $allImages[] = trim($car->car_image);
                        }
                        
                        // Add additional images from AdminCarImage table
                        if (isset($car->carImages)) {
                            foreach ($car->carImages as $carImage) {
                                if (!empty(trim($carImage->image_path))) {
                                    $allImages[] = trim($carImage->image_path);
                                }
                            }
                        }
                        ?>
                        
                        @if(!empty($allImages))
                            <!-- Main Image Display -->
                            <div class="main-image-container">
                                <img id="mainImage"
                                    src="{{ asset('admincar_images/' . $allImages[0]) }}"
                                    alt="{{ $car->maker ?? 'Car' }} {{ $car->model ?? '' }}"
                                    class="main-car-image"
                                    onerror="this.src='{{ asset('admincar_images/default-car.jpg') }}'; this.onerror=null;">
                                
                                <!-- Image counter -->
                                <div class="image-counter">
                                    <span id="currentImageIndex">1</span> / {{ count($allImages) }}
                                </div>
                            </div>

                            <!-- Thumbnail Gallery (show if more than 1 image) -->
                            @if(count($allImages) > 1)
                                <div class="thumbnail-images">
                                    <div class="thumbnail-scroll">
                                        @foreach($allImages as $index => $image)
                                            <div class="thumbnail-wrapper">
                                                <img src="{{ asset('admincar_images/' . $image) }}"
                                                    alt="Car Image {{ $index + 1 }}"
                                                    class="thumbnail-image {{ $index == 0 ? 'active' : '' }}"
                                                    data-index="{{ $index + 1 }}"
                                                    onclick="changeMainImage('{{ asset('admincar_images/' . $image) }}', this, {{ $index + 1 }})"
                                                    onerror="this.parentElement.style.display='none';">
                                                <div class="thumbnail-overlay">{{ $index + 1 }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Navigation arrows for mobile -->
                                <div class="image-navigation d-md-none">
                                    <button type="button" class="nav-btn prev-btn" onclick="navigateImage(-1)">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="nav-btn next-btn" onclick="navigateImage(1)">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            @endif

                            <!-- Image list for debugging (remove in production) -->
                            {{-- @if(config('app.debug'))
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <strong>Debug - Images found:</strong> {{ count($allImages) }}
                                        <br>
                                        <strong>Primary image:</strong> {{ $car->car_image ?? 'None' }}
                                        <br>
                                        <strong>Additional images:</strong> {{ isset($car->carImages) ? count($car->carImages) : 0 }}
                                        <br>
                                        @foreach($allImages as $index => $image)
                                            {{ $index + 1 }}. {{ $image }}<br>
                                        @endforeach
                                    </small>
                                </div>
                            @endif --}}
                        @else
                            <!-- No images found -->
                            <div class="no-image">
                                <img src="{{ asset('admincar_images/default-car.jpg') }}"
                                    alt="No Image Available"
                                    class="main-car-image"
                                    onerror="this.src='{{ asset('assets/images/no-image-placeholder.png') }}'; this.onerror=null;">
                                <p class="text-muted mt-2">No images available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Car Information -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <h4>Basic Information</h4>
                    <div class="car-details-grid">
                        <div class="detail-row">
                            <span class="detail-label">Car ID:</span>
                            <span class="detail-value">{{ $car->id }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Maker:</span>
                            <span class="detail-value">{{ $car->maker }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Model:</span>
                            <span class="detail-value">{{ $car->model }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Vehicle Type:</span>
                            <span class="detail-value">{{ $car->vehicle_type }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Condition:</span>
                            <span class="detail-value">{{ $car->car_condition }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Registration No:</span>
                            <span class="detail-value">{{ $car->registration_no }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Mileage:</span>
                            <span class="detail-value">{{ number_format($car->mileage) }} km</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Daily Rate:</span>
                            <span class="detail-value">${{ number_format($car->price, 2) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">
                                <?php
                                $statusClass = '';
                                switch (strtolower($car->status)) {
                                    case 'available':
                                        $statusClass = 'available';
                                        break;
                                    case 'booked':
                                    case 'rented':
                                        $statusClass = 'booked';
                                        break;
                                    case 'maintenance':
                                        $statusClass = 'maintenance';
                                        break;
                                    case 'inactive':
                                        $statusClass = 'inactive';
                                        break;
                                    default:
                                        $statusClass = '';
                                }
                                ?>
                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($car->status) }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h4>Technical Specifications</h4>
                    <div class="car-details-grid">
                        <div class="detail-row">
                            <span class="detail-label">Number of Doors:</span>
                            <span class="detail-value">{{ $car->number_of_doors }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Number of Seats:</span>
                            <span class="detail-value">{{ $car->number_of_seats }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Transmission:</span>
                            <span class="detail-value">{{ $car->transmission_type }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Fuel Type:</span>
                            <span class="detail-value">{{ $car->fuel_type }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Large Bags Capacity:</span>
                            <span class="detail-value">{{ $car->large_bags_capacity ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Small Bags Capacity:</span>
                            <span class="detail-value">{{ $car->small_bags_capacity ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <h4 class="mt-4">Features</h4>
                    <div class="car-features">
                        <div class="feature-item">
                            <i class="fas fa-snowflake"></i>
                            <span>Air Conditioning: {{ $car->air_conditioning ?? 'N/A' }}</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-camera"></i>
                            <span>Backup Camera: {{ $car->backup_camera ?? 'N/A' }}</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-bluetooth"></i>
                            <span>Bluetooth: {{ $car->bluetooth ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($car->description)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Description</h4>
                    <div class="car-description">
                        <p>{{ $car->description }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Car Statistics -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Additional Information</h4>
                    <div class="car-stats">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Added On</span>
                                <span class="stat-value">{{ $car->created_at ? $car->created_at->format('M d, Y') : 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Last Updated</span>
                                <span class="stat-value">{{ $car->updated_at ? $car->updated_at->format('M d, Y') : 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Monthly Rate</span>
                                <span class="stat-value">${{ number_format($car->price * 30, 2) }}</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-road"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Mileage Status</span>
                                <span class="stat-value">
                                    @if($car->mileage < 50000)
                                        <span class="text-success">Low Mileage</span>
                                    @elseif($car->mileage < 100000)
                                        <span class="text-warning">Medium Mileage</span>
                                    @else
                                        <span class="text-danger">High Mileage</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="action-buttons">
                        <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Car
                        </a>
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Back to Cars List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Image gallery functionality
    function changeMainImage(imageSrc, thumbnailElement) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = imageSrc;
        
        // Remove active class from all thumbnails
        document.querySelectorAll('.thumbnail-image').forEach(thumb => {
            thumb.classList.remove('active');
        });
        
        // Add active class to clicked thumbnail
        thumbnailElement.classList.add('active');
    }

    // Handle image loading errors
    function handleImageError(img) {
        img.style.display = 'none';
        console.log('Failed to load image: ' + img.src);
    }

    // Check if images exist and handle accordingly
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.car-images-gallery img');
        images.forEach(img => {
            img.addEventListener('error', function() {
                handleImageError(this);
            });
        });
    });
    let currentImages = [];
let currentImageIndex = 0;

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Collect all image sources
    const thumbnails = document.querySelectorAll('.thumbnail-image');
    currentImages = Array.from(thumbnails).map(thumb => thumb.src);
    currentImageIndex = 0;
});

function changeMainImage(imageSrc, thumbnailElement, imageIndex) {
    // Update main image
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.src = imageSrc;
    }
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-image').forEach(thumb => {
        thumb.classList.remove('active');
    });
    
    if (thumbnailElement) {
        thumbnailElement.classList.add('active');
    }
    
    // Update counter
    if (imageIndex) {
        currentImageIndex = imageIndex - 1;
        const counter = document.getElementById('currentImageIndex');
        if (counter) {
            counter.textContent = imageIndex;
        }
    }
}

function navigateImage(direction) {
    if (currentImages.length === 0) return;
    
    currentImageIndex += direction;
    
    // Loop around
    if (currentImageIndex >= currentImages.length) {
        currentImageIndex = 0;
    } else if (currentImageIndex < 0) {
        currentImageIndex = currentImages.length - 1;
    }
    
    // Update main image
    const mainImage = document.getElementById('mainImage');
    if (mainImage && currentImages[currentImageIndex]) {
        mainImage.src = currentImages[currentImageIndex];
    }
    
    // Update active thumbnail
    const thumbnails = document.querySelectorAll('.thumbnail-image');
    thumbnails.forEach((thumb, index) => {
        thumb.classList.toggle('active', index === currentImageIndex);
    });
    
    // Update counter
    const counter = document.getElementById('currentImageIndex');
    if (counter) {
        counter.textContent = currentImageIndex + 1;
    }
}

// Optional: Add keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') {
        navigateImage(-1);
    } else if (e.key === 'ArrowRight') {
        navigateImage(1);
    }
});

// Optional: Add swipe support for mobile
let startX = 0;
let endX = 0;

document.addEventListener('touchstart', function(e) {
    startX = e.changedTouches[0].screenX;
});

document.addEventListener('touchend', function(e) {
    endX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    const threshold = 50; // minimum distance for swipe
    const diff = startX - endX;
    
    if (Math.abs(diff) > threshold) {
        if (diff > 0) {
            navigateImage(1); // swipe left - next image
        } else {
            navigateImage(-1); // swipe right - previous image
        }
    }
}
</script>

<style>
    .car-images-gallery {
    margin-bottom: 20px;
}

.main-image-container {
    position: relative;
    text-align: center;
    margin-bottom: 15px;
}

.main-car-image {
    max-width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    cursor: pointer;
}

.image-counter {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
}

.thumbnail-images {
    margin-top: 15px;
}

.thumbnail-scroll {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding: 10px 0;
    scrollbar-width: thin;
}

.thumbnail-scroll::-webkit-scrollbar {
    height: 6px;
}

.thumbnail-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.thumbnail-scroll::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.thumbnail-wrapper {
    position: relative;
    flex-shrink: 0;
}

.thumbnail-image {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail-image:hover {
    border-color: #007bff;
    transform: scale(1.05);
}

.thumbnail-image.active {
    border-color: #007bff;
    box-shadow: 0 2px 8px rgba(0,123,255,0.3);
}

.thumbnail-overlay {
    position: absolute;
    top: 2px;
    left: 2px;
    background: rgba(0,0,0,0.7);
    color: white;
    font-size: 10px;
    padding: 2px 5px;
    border-radius: 2px;
    line-height: 1;
}

.image-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.nav-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.3s ease;
}

.nav-btn:hover {
    background: #0056b3;
}

.no-image {
    text-align: center;
    padding: 40px 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.no-image .main-car-image {
    height: 200px;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .main-car-image {
        height: 250px;
    }
    
    .thumbnail-image {
        width: 60px;
        height: 45px;
    }
}
    .car-images-gallery {
        margin-bottom: 2rem;
    }
    
    .main-image-container {
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .main-car-image {
        max-width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
    }
    
    .thumbnail-images {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .thumbnail-image {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }
    
    .thumbnail-image:hover,
    .thumbnail-image.active {
        border-color: #007bff;
        opacity: 0.8;
    }
    
    .car-details-grid {
        display: grid;
        gap: 0.5rem;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }
    
    .detail-label {
        font-weight: 600;
        color: #666;
    }
    
    .detail-value {
        color: #333;
    }
    
    .car-features {
        display: grid;
        gap: 0.5rem;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0;
    }
    
    .feature-item i {
        color: #007bff;
        width: 20px;
    }
    
    .car-description {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }
    
    .car-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .stat-card {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #dee2e6;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        background: #007bff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .stat-info {
        display: flex;
        flex-direction: column;
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: #666;
        margin-bottom: 0.25rem;
    }
    
    .stat-value {
        font-weight: 600;
        color: #333;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .no-image {
        text-align: center;
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 8px;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .status-badge.available {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-badge.booked {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-badge.maintenance {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .status-badge.inactive {
        background-color: #e2e3e5;
        color: #495057;
    }

    /* Loading placeholder for images */
    .main-car-image:not([src]),
    .thumbnail-image:not([src]) {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endsection