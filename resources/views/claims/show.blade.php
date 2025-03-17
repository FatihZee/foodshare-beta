@extends('layouts.app')

@section('title', 'Detail Klaim')

@section('content')
<h1>Detail Klaim</h1>
<p><strong>Nama Mahasiswa:</strong> {{ $claim->user ? $claim->user->name : 'Guest' }}</p>
<p><strong>Makanan:</strong> {{ $claim->donation->food_name }}</p>
<p><strong>Nomor Antrean:</strong> {{ $claim->queue_number }}</p>
<p><strong>Status:</strong> {{ ucfirst($claim->status) }}</p>

<a href="{{ route('claims.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
