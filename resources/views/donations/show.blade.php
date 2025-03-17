@extends('layouts.app')

@section('title', 'Detail Donasi')

@section('content')
<h1>Detail Donasi</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Nama Makanan: {{ $donation->food_name }}</h5>
        <p class="card-text">Jumlah: {{ $donation->quantity }}</p>
        <p class="card-text">Lokasi: {{ $donation->location }}</p>
        <p class="card-text">Tanggal Kadaluarsa: {{ $donation->expiration }}</p>
    </div>
</div>

<a href="{{ route('donations.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection