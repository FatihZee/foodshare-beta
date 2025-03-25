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
                <form method="POST" action="{{ route('donations.update', $donation->id) }}" id="editDonationForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Makanan</label>
                        <input type="text" name="food_name" class="form-control" value="{{ $donation->food_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori Makanan</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $donation->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
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
                        <input type="datetime-local" name="expiration" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($donation->expiration)) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="maps" class="form-label fw-bold">Link Lokasi (Google Maps)</label>
                        <input type="url" name="maps" id="maps" class="form-control" placeholder="Masukkan link lokasi di Google Maps" value="{{ old('maps', $donation->maps) }}">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" id="updateButton">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                        <a href="{{ route('donations.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.getElementById('updateButton').addEventListener('click', function () {
            Swal.fire({
                title: "Konfirmasi Perubahan",
                text: "Apakah Anda yakin ingin menyimpan perubahan ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Simpan"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Berhasil Diperbarui!",
                        text: "Donasi telah berhasil diperbarui.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000
                    });
    
                    setTimeout(() => {
                        document.getElementById('editDonationForm').submit();
                    }, 2000);
                }
            });
        });
    </script>
@endsection