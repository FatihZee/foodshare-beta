@extends('layouts.app')

@section('title', 'Daftar Donasi')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <h1 class="text-center mb-4">Daftar Donasi</h1>

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('donations.create') }}" class="btn btn-primary">Tambah Donasi</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>Nama Makanan</th>
                                <th>Jumlah</th>
                                <th>Lokasi</th>
                                <th>Donatur</th> <!-- Tambahan Kolom Donatur -->
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donations as $donation)
                                <tr class="text-center">
                                    <td>{{ $donation->food_name }}</td>
                                    <td>{{ $donation->quantity }}</td>
                                    <td>{{ $donation->location }}</td>
                                    <td>
                                        @if ($donation->donor_id)
                                            {{ $donation->donor->name }} <!-- Nama user login -->
                                        @else
                                            {{ $donation->donor_name }} <!-- Nama guest -->
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $donation->status === 'pending' ? 'warning' : ($donation->status === 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('donations.show', $donation) }}" class="btn btn-info btn-sm">Detail</a>
                                        @if (Auth::id() === $donation->donor_id)
                                            <a href="{{ route('donations.edit', $donation) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('donations.destroy', $donation) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus donasi ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
