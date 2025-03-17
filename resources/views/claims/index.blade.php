@extends('layouts.app')

@section('title', 'Daftar Klaim')

@section('content')
<h1>Daftar Klaim</h1>
<a href="{{ route('claims.create') }}" class="btn btn-primary mb-3">Buat Klaim</a>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Nomor Antrean</th>
            <th>Nama Mahasiswa</th>
            <th>Nama Makanan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($claims as $claim)
        <tr>
            <td>{{ $claim->queue_number }}</td>
            <td>{{ $claim->user ? $claim->user->name : 'Guest' }}</td>
            <td>{{ $claim->donation->food_name }}</td>
            <td>{{ ucfirst($claim->status) }}</td>
            <td>
                <a href="{{ route('claims.show', $claim) }}" class="btn btn-info btn-sm">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
