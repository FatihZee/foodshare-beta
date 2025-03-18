<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Aplikasi Pengguna')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light text-dark">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-primary bg-primary">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ route('users.index') }}">FoodShare</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('users.index') }}">Users</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('users.create') }}">Tambah User</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('donations.index') }}">Donasi</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('donations.create') }}">Tambah Donasi</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('claims.index') }}">Klaim</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('claims.create') }}">Buat Klaim</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        <!-- Dropdown Profil -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="navbarProfile" role="button" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff" alt="Profile" class="rounded-circle me-2" width="32" height="32">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><span class="dropdown-item-text"><strong>{{ Auth::user()->name }}</strong></span></li>
                                <li><span class="dropdown-item-text text-muted">{{ Auth::user()->email }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-light btn-sm">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>    

    <!-- Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-4 fixed-bottom">
        &copy; {{ date('Y') }} Aplikasi Pengguna
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
