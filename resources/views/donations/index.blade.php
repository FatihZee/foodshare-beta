@extends('layouts.app')

@section('title', 'Daftar Donasi')

@section('content')
<h1>Daftar Donasi</h1>
<a href="{{ route('donations.create') }}" class="btn btn-primary mb-3">Tambah Donasi</a>

<table class="table">
    <thead>
        <tr>
            <th>Nama Makanan</th>
            <th>Jumlah</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($donations as $donation)
        <tr>
            <td>{{ $donation->food_name }}</td>
            <td>{{ $donation->quantity }}</td>
            <td>{{ $donation->location }}</td>
            <td>{{ ucfirst($donation->status) }}</td>
            <td>
                <a href="{{ route('donations.show', $donation) }}" class="btn btn-info btn-sm">Detail</a>
                @if (Auth::id() === $donation->donor_id)
                    <a href="{{ route('donations.edit', $donation) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('donations.destroy', $donation) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
