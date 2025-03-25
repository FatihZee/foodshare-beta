@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4 text-primary fw-bold"><i class="fas fa-folder-plus"></i> Tambah Kategori</h2>
                    
                    <form action="{{ route('categories.store') }}" method="POST" id="categoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama kategori" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="button" class="btn btn-primary" id="saveCategoryButton">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('saveCategoryButton').addEventListener('click', function () {
        Swal.fire({
            title: "Konfirmasi Tambah Kategori",
            text: "Apakah Anda yakin ingin menambahkan kategori makanan ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Tambahkan"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Berhasil!",
                    text: "Kategori makanan telah berhasil ditambahkan.",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2000
                });

                setTimeout(() => {
                    document.getElementById('categoryForm').submit();
                }, 2000);
            }
        });
    });
</script>

@endsection