@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <h1 class="text-center mb-4">Detail Pengguna</h1>
                
                <div class="mb-3">
                    <h5 class="fw-bold">Nama:</h5>
                    <p class="card-text">{{ $user->name }}</p>
                </div>

                <div class="mb-3">
                    <h5 class="fw-bold">Email:</h5>
                    <p class="card-text">{{ $user->email ?? 'Guest' }}</p>
                </div>

                <div class="mb-3">
                    <h5 class="fw-bold">Role:</h5>
                    <p class="card-text">{{ ucfirst($user->role) }}</p>
                </div>

                <div class="mb-3">
                    <h5 class="fw-bold">No. HP:</h5>
                    <p class="card-text">{{ $user->phone }}</p>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection