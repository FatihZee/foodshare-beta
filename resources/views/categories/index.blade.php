@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center text-primary fw-bold mb-4"><i class="fas fa-utensils"></i> Daftar Kategori Makanan</h1>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <ul class="list-group">
                @foreach($categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-tag"></i> {{ $category->name }}</span>
                        <div>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline deleteCategoryForm">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm deleteCategoryButton">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.deleteCategoryButton').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            let form = this.closest("form");

            Swal.fire({
                title: "Konfirmasi Hapus Kategori",
                text: "Apakah Anda yakin ingin menghapus kategori ini? Aksi ini tidak dapat dibatalkan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Terhapus!",
                        text: "Kategori makanan telah berhasil dihapus.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000
                    });

                    setTimeout(() => {
                        form.submit();
                    }, 2000);
                }
            });
        });
    });
</script>

@endsection
