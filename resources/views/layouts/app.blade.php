<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>

<body>
    <!-- Sidebar -->
    @include('partials.sidebar')

    <div class="d-flex flex-column w-100">
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Main Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('partials.footer')
    </div>

    <!-- Scripts -->
    @include('partials.scripts')
</body>
</html>