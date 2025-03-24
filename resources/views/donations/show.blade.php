@extends('layouts.app')

@section('title', 'Detail Donasi')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <h1 class="text-center mb-4">Detail Donasi</h1>
                
                <div class="mb-3">
                    <h5 class="fw-bold">Nama Makanan:</h5>
                    <p class="card-text">{{ $donation->food_name }}</p>
                </div>
                
                <div class="mb-3">
                    <h5 class="fw-bold">Kategori:</h5>
                    <p class="card-text">{{ $donation->category->name }}</p>
                </div>

                <div class="mb-3">
                    <h5 class="fw-bold">Jumlah:</h5>
                    <p class="card-text">{{ $donation->quantity }}</p>
                </div>

                <div class="mb-3">
                    <h5 class="fw-bold">Lokasi:</h5>
                    <p class="card-text">{{ $donation->location }}</p>
                </div>

                <div class="mb-3">
                    <h5 class="fw-bold">Tanggal Kadaluarsa:</h5>
                    <p class="card-text">{{ date('d M Y, H:i', strtotime($donation->expiration)) }}</p>
                </div>

                <div class="mb-3">
                    <h5 class="fw-bold">Link Lokasi (Google Maps):</h5>
                    @if ($donation->maps)
                        <a href="{{ $donation->maps }}" target="_blank" class="card-text text-decoration-none">Lihat di Google Maps</a>
                    @else
                        <p class="card-text text-muted">Lokasi belum tersedia</p>
                    @endif
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('donations.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
