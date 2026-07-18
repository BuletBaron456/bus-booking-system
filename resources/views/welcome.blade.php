<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Bus Booking') }} - Book Your Trip</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-bus-front-fill"></i> BusBooking
            </a>
            <div class="ms-auto d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-book">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-book">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container text-center py-5">
            <i class="bi bi-bus-front-fill hero-icon"></i>
            <h1 class="display-4 fw-bold mt-3">Travel Smarter, Book Faster</h1>
            <p class="lead text-muted mb-4">
                Search bus schedules, pick your seat, and get your ticket confirmed in seconds.
            </p>
            <div class="d-flex justify-content-center gap-3">
                @auth
                    <a href="{{ route('schedules.index') }}" class="btn btn-book btn-lg">
                        <i class="bi bi-search"></i> Find a Bus
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-book btn-lg">Get Started</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <section class="container py-5">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="dashboard-card">
                    <i class="bi bi-calendar3 feature-icon"></i>
                    <h5 class="mt-3">Easy Scheduling</h5>
                    <p class="text-muted mb-0">Browse available trips by date using our interactive calendar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <i class="bi bi-grid-3x3-gap feature-icon"></i>
                    <h5 class="mt-3">Choose Your Seat</h5>
                    <p class="text-muted mb-0">Pick exactly where you sit with real-time seat availability.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <i class="bi bi-envelope-check feature-icon"></i>
                    <h5 class="mt-3">Instant Confirmation</h5>
                    <p class="text-muted mb-0">Get your ticket confirmed by email the moment you book.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-4 text-muted border-top">
        <small>&copy; {{ date('Y') }} BusBooking. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>