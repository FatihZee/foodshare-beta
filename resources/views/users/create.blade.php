@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <h1 class="text-center mb-4">Tambah Pengguna</h1>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nama (Opsional)</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email (Opsional)</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password (Opsional)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="donatur">Donatur</option>
                            <option value="sr">SR</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. HP (Opsional)</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection