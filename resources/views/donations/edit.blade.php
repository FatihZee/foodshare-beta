@extends('layouts.app')

@section('title', 'Edit Donasi')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <h1 class="text-center mb-4">Edit Donasi</h1>
                <form method="POST" action="{{ route('donations.update', $donation->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Makanan</label>
                        <input type="text" name="food_name" class="form-control" value="{{ $donation->food_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah</label>
                        <input type="number" name="quantity" class="form-control" value="{{ $donation->quantity }}" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi</label>
                        <input type="text" name="location" class="form-control" value="{{ $donation->location }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Kadaluarsa</label>
                        <input type="datetime-local" name="expiration" class="form-control" value="{{ date('Y-m-d\\TH:i', strtotime($donation->expiration)) }}" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('donations.index') }}" class="btn btn-secondary ms-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
