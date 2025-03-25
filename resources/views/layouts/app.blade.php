<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Aplikasi Modern')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/e0c2ef87df.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: #f8f9fa;
            color: #212529;
        }

        .navbar {
            background: white;
            padding: 12px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            color: #212529;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: #0d6efd;
        }

        .sidebar {
            width: 250px;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: fixed;
            top: 70px;
            left: 0;
            z-index: 998;
            transition: left 0.3s ease;
            overflow-y: auto;
            bottom: 40px; /* Adjust this value to match your footer height */
            height: auto; /* Remove the fixed height */
        }

        .sidebar a {
            display: block;
            color: #212529;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .sidebar a:hover {
            background: #2470db;
            color: white;
        }

        .content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 20px;
            min-height: calc(100vh - 110px); /* Adjust for navbar and footer heights */
            padding-bottom: 50px; /* Add padding at the bottom to prevent content from being hidden behind footer */
        }

        .footer {
            background: white;
            text-align: center;
            padding: 10px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            position: fixed; /* Make footer fixed */
            bottom: 0;
            width: 100%;
            height: 40px; /* Define a fixed height */
            z-index: 999; /* Ensure it stays above other content */
        }

        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                top: 70px;
                left: -200px;
                bottom: 40px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
                min-height: calc(100vh - 110px);
            }

            .navbar {
                padding: 8px 15px;
            }

            .sidebar a {
                font-size: 14px;
            }

            .footer {
                font-size: 12px;
            }

            .navbar .toggle-btn {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                padding: 10px 15px;
            }

            .sidebar {
                width: 100%;
                left: -100%;
                top: 70px;
                bottom: 40px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
                margin-top: 70px;
                padding: 15px;
            }
            
            .content.shifted {
                margin-left: 0;
            }

            .footer {
                font-size: 10px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        @auth
            @if (Auth::user()->role == 'admin')
                <a href="{{ route('users.index') }}">
                    <i class="fas fa-users fa-fw"></i>
                    <span>Users</span>
                </a>
            @endif
            <a href="{{ route('articles.index') }}">
                <i class="fas fa-newspaper fa-fw"></i>
                <span>Artikel</span>
            </a>
            <a href="{{ route('categories.index') }}">
                <i class="fas fa-list-alt fa-fw"></i>
                <span>Kategori Makanan</span>
            </a>
            <a href="{{ route('donations.index') }}">
                <i class="fas fa-hand-holding-heart fa-fw"></i>
                <span>Donasi</span>
            </a>
            <a href="{{ route('claims.index') }}">
                <i class="fas fa-receipt fa-fw"></i>
                <span>Klaim</span>
            </a>
            <a href="{{ route('reviews.index') }}">
                <i class="fas fa-star fa-fw"></i>
                <span>Review</span>
            </a>
            <a href="{{ route('wishlist.index') }}">
                <i class="fas fa-heart fa-fw"></i>
                <span>Wishlist</span>
            </a>
        @else
            <a href="{{ route('articles.index') }}">
                <i class="fas fa-newspaper fa-fw"></i>
                <span>Artikel</span>
            </a>
            <a href="{{ route('categories.index') }}">
                <i class="fas fa-list-alt fa-fw"></i>
                <span>Kategori Makanan</span>
            </a>
            <a href="{{ route('donations.index') }}">
                <i class="fas fa-hand-holding-heart fa-fw"></i>
                <span>Donasi</span>
            </a>
            <a href="{{ route('claims.index') }}">
                <i class="fas fa-receipt fa-fw"></i>
                <span>Klaim</span>
            </a>
            <a href="{{ route('reviews.index') }}">
                <i class="fas fa-star fa-fw"></i>
                <span>Review</span>
            </a>
            <a href="{{ route('wishlist.index') }}">
                <i class="fas fa-heart fa-fw"></i>
                <span>Wishlist</span>
            </a>
        @endauth
    </div>    

    <div class="d-flex flex-column w-100">
        <div class="navbar d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="fs-3 fw-bold text-primary text-uppercase text-decoration-none">
                FoodShare
            </a>

            <button class="btn btn-outline-dark toggle-btn d-md-none d-block" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <div>
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('users.edit', ['user' => Auth::user()->id]) }}">Edit Profile</a></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        </ul>
                    </div>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary" style="color: white; display: flex; justify-content: center; align-items: center;">Login</a>
                @endauth
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Aplikasi Modern
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.content').classList.toggle('shifted');
        });

    </script>
</body>

</html>
