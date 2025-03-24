@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center text-primary fw-bold mb-4"><i class="fas fa-utensils"></i> Daftar Kategori Makanan</h1>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Kategori</a>
    </div>
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <ul class="list-group">
                @foreach($categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-tag"></i> {{ $category->name }}</span>
                        <div>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm me-2"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection