@extends('layouts.app')

@section('title', 'Detail Klaim')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Detail Klaim</h1>

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nama Mahasiswa:</strong> {{ $claim->user ? $claim->user->name : 'Guest' }}</li>
                    <li class="list-group-item"><strong>Makanan:</strong> {{ $claim->donation->food_name }}</li>
                    <li class="list-group-item"><strong>Nomor Antrean:</strong> {{ $claim->queue_number }}</li>
                    <li class="list-group-item">
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $claim->status === 'pending' ? 'warning' : ($claim->status === 'approved' ? 'success' : 'danger') }}">
                            {{ ucfirst($claim->status) }}
                        </span>
                    </li>
                </ul>
                <a href="{{ route('claims.index') }}" class="btn btn-secondary mt-4 w-100">Kembali</a>
            </div>
        </div>
    </div>
@endsection
