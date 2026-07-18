<x-guest-layout>
    <div class="auth-wrapper">
        <div class="auth-visual">
            <div class="auth-visual-content">
                <i class="bi bi-bus-front-fill auth-bus-icon"></i>
                <h2>BusBooking</h2>
                <p>Travel smarter. Book your seat in seconds, track your trips, and ride with confidence.</p>
                <ul class="auth-feature-list">
                    <li><i class="bi bi-check-circle-fill"></i> Real-time seat availability</li>
                    <li><i class="bi bi-check-circle-fill"></i> Instant booking confirmation</li>
                    <li><i class="bi bi-check-circle-fill"></i> Manage all your tickets in one place</li>
                </ul>
            </div>
        </div>

        <div class="auth-form-side">
            <div class="auth-form-box">
                <div class="text-center mb-4">
                    <i class="bi bi-bus-front-fill" style="font-size: 2.5rem; color: var(--primary);"></i>
                    <h3 class="mt-2 mb-0">Welcome Back</h3>
                    <p class="text-muted">Login to continue booking your trips</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               required autofocus autocomplete="username" placeholder="you@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required autocomplete="current-password" placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label" for="remember_me">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="small text-decoration-none" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-book w-100 mb-3">Login</button>

                    @if (Route::has('register'))
                        <p class="text-center text-muted mb-0">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Register</a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>