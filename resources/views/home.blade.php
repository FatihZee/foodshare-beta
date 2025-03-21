@extends('layouts.app')

@section('title', 'Home - FoodShare')

@section('content')
<div class="container py-5">
    <h1 class="text-primary mb-4 text-center">Selamat Datang di FoodShare</h1>
    <div class="row g-4 justify-content-center">
        @auth
            @if (Auth::user()->role == 'admin')
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">Kelola Pengguna</h5>
                            <p class="card-text">Lihat dan tambahkan pengguna yang berkontribusi dalam berbagi makanan.</p>
                            <a href="{{ route('users.index') }}" class="btn btn-primary">Lihat Pengguna</a>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Kelola Donasi</h5>
                    <p class="card-text">Pantau donasi makanan yang masuk dan tambahkan donasi baru.</p>
                    <a href="{{ route('donations.index') }}" class="btn btn-success">Lihat Donasi</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning">Kelola Klaim</h5>
                    <p class="card-text">Lacak klaim donasi yang telah dibuat dan tambahkan klaim baru.</p>
                    <a href="{{ route('claims.index') }}" class="btn btn-warning">Lihat Klaim</a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <h3 class="text-muted">Mari Berbagi Kebaikan, Satu Donasi pada Satu Waktu</h3>
    </div>
</div>
@endsection
