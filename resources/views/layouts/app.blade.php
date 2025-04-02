<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System</title>
    
    <!-- Link CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

</head>
<body>

     <!-- Include Header -->
    @include('layouts.header')

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Include Footer -->
    @include('layouts.footer')

</body>
</html>
