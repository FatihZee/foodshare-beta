@extends('layouts.app')

@section('title', 'Daftar Klaim')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <h1 class="text-center mb-4">Daftar Klaim</h1>
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('claims.create') }}" class="btn btn-primary">Buat Klaim</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>Nomor Antrean</th>
                                <th>Nama Mahasiswa</th>
                                <th>Nama Makanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($claims as $claim)
                                <tr class="text-center">
                                    <td>{{ $claim->queue_number }}</td>
                                    <td>{{ $claim->user ? $claim->user->name : 'Guest' }}</td>
                                    <td>{{ $claim->donation->food_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $claim->status === 'pending' ? 'warning' : ($claim->status === 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($claim->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('claims.show', $claim) }}" class="btn btn-info btn-sm">Detail</a>
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
