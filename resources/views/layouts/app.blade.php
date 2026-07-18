<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Bus Booking') }} - @yield('title', 'Home')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-bus-front-fill"></i> BusBooking
        </a>

        <ul class="navbar-nav flex-row flex-wrap gap-3 align-items-center mb-0">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            @auth
                <li class="nav-item"><a class="nav-link" href="{{ route('schedules.index') }}">Search Bus</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">My Tickets</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                @if(auth()->user()->isAdmin())
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.buses.index') }}">Manage Buses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.routes.index') }}">Manage Routes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.bookings.index') }}">Manage Bookings</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">{{ auth()->user()->name }} (Profile)</a></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="btn btn-cancel btn-sm" type="submit">Logout</button>
                    </form>
                </li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="btn btn-book btn-sm" href="{{ route('register') }}">Register</a></li>
            @endauth
        </ul>
    </div>
</nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>