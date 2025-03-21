<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - FoodShare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }
        .card {
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
        }
        .form-control {
            background-color: #f1f3f5;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
        }
        .btn-futuristic {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .btn-futuristic::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.3s ease-in-out;
        }

        .btn-futuristic::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 30%;
            height: 2px;
            background: white;
            transform: translateX(-50%);
            transition: width 0.3s ease-in-out;
        }

        .btn-futuristic:hover {
            color: #ffd700;
            transform: scale(1.05);
        }

        .btn-futuristic:hover::before {
            left: 0;
        }

        .btn-futuristic:hover::after {
            width: 80%;
        }
    </style>
</head>
<body>
    <div class="position-absolute top-0 start-0 m-3">
        <button onclick="window.location.href='{{ route('home') }}'" class="btn-futuristic">
            Home
        </button>
    </div>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="fs-4 text-center mb-3">Login</h1>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 mt-2">Login</button>
                            <div class="text-center mt-2">
                                <a href="{{ route('register') }}" class="text-decoration-none">Belum punya akun? Daftar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
