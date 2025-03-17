@extends('layouts.app')

@section('title', 'Tambah Donasi')

@section('content')
<h1>Tambah Donasi</h1>

<form method="POST" action="{{ route('donations.store') }}">
    @csrf
    <div class="mb-3">
        <label>Nama Makanan</label>
        <input type="text" name="food_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Jumlah</label>
        <input type="number" name="quantity" class="form-control" required min="1">
    </div>

    <div class="mb-3">
        <label>Lokasi</label>
        <input type="text" name="location" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Kadaluarsa</label>
        <input type="datetime-local" name="expiration" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection
