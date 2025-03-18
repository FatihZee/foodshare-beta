@extends('layouts.app')
@section('title', 'Register')
@section('content')
<style>
    .login-container {
        height: calc(100vh - 160px); /* Mengurangi tinggi untuk navbar dan footer */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .container.mt-4 {
        margin-top: 0 !important;
    }
</style>

<div class="login-container">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-3">
                <h1 class="fs-4 text-center mb-2">Register</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" id="name" name="name" class="form-control bg-light text-dark border-0 rounded-3" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control bg-light text-dark border-0 rounded-3" required>
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control bg-light text-dark border-0 rounded-3" required>
                    </div>
                    <div class="mb-2">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control bg-light text-dark border-0 rounded-3" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 mt-2 rounded-3">Daftar</button>
                    <div class="text-center mt-2">
                        <a href="{{ route('login') }}" class="text-decoration-none text-primary">Sudah punya akun? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection