@extends('layouts.app')

@section('title', 'Edit Donasi')

@section('content')
<h1>Edit Donasi</h1>

<form method="POST" action="{{ route('donations.update', $donation->id) }}">
    @csrf
    @method('PUT') <!-- Method Spoofing untuk update -->

    <div class="mb-3">
        <label>Nama Makanan</label>
        <input type="text" name="food_name" class="form-control" value="{{ $donation->food_name }}" required>
    </div>

    <div class="mb-3">
        <label>Jumlah</label>
        <input type="number" name="quantity" class="form-control" value="{{ $donation->quantity }}" required min="1">
    </div>

    <div class="mb-3">
        <label>Lokasi</label>
        <input type="text" name="location" class="form-control" value="{{ $donation->location }}" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Kadaluarsa</label>
        <input type="datetime-local" name="expiration" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($donation->expiration)) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('donations.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection