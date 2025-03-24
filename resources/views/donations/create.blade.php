@extends('layouts.app')

@section('title', 'Tambah Donasi')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <h1 class="text-center mb-4">Tambah Donasi</h1>
                <form method="POST" action="{{ route('donations.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Makanan</label>
                        <input type="text" name="food_name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori Makanan</label>
                        <select name="category_id" class="form-select">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah</label>
                        <input type="number" name="quantity" class="form-control" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Waktu Kadaluarsa</label>
                        <p class="form-text text-muted">
                            Waktu kadaluarsa otomatis diatur <b>30 menit setelah donasi dibuat</b>.
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Donatur (kosongkan untuk Hamba Allah)</label>
                        <input type="text" name="donor_name" class="form-control" 
                               placeholder="Masukkan nama atau kosongkan jika ingin anonim">
                    </div>
                    
                    <div class="mb-3">
                        <label for="maps" class="form-label fw-bold">Link Lokasi (Google Maps)</label>
                        <input type="url" name="maps" id="maps" class="form-control" placeholder="Masukkan link lokasi di Google Maps">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
