@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4 text-primary fw-bold"><i class="fas fa-edit"></i> Edit Kategori</h2>
                    
                    <form action="{{ route('categories.update', $category) }}" method="POST" id="editCategoryForm">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="button" class="btn btn-primary" id="updateCategoryButton">
                                <i class="fas fa-save"></i> Update
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
    document.getElementById('updateCategoryButton').addEventListener('click', function () {
        Swal.fire({
            title: "Konfirmasi Update Kategori",
            text: "Apakah Anda yakin ingin memperbarui kategori ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Update"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Berhasil!",
                    text: "Kategori makanan telah berhasil diperbarui.",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2000
                });

                setTimeout(() => {
                    document.getElementById('editCategoryForm').submit();
                }, 2000);
            }
        });
    });
</script>

@endsection
