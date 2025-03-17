<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Aplikasi Pengguna')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            {{-- Brand --}}
            <a class="navbar-brand" href="{{ route('users.index') }}">FoodShare</a>

            {{-- Button for mobile view --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menu Items --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    {{-- User Menu --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.create') }}">Tambah User</a></li>

                    {{-- Donation Menu --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('donations.index') }}">Donasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('donations.create') }}">Tambah Donasi</a></li>
                    
                    {{-- Claim Menu --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('claims.index') }}">Klaim</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('claims.create') }}">Buat Klaim</a></li>
                </ul>

                {{-- Auth Menu --}}
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a></li>
                    @endauth
                </ul>
            </div>            
        </div>
    </nav>

    {{-- Content --}}
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 fixed-bottom">
        &copy; {{ date('Y') }} Aplikasi Pengguna
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
