@extends('layouts.app')

@section('title', 'Buat Klaim')

@section('content')
<h1>Buat Klaim Makanan</h1>

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('claims.store') }}">
    @csrf
    <div class="mb-3">
        <label>Donasi Makanan</label>
        <select name="donation_id" class="form-control" required>
            <option value="">Pilih Makanan</option>
            @foreach ($donations as $donation)
                <option value="{{ $donation->id }}">{{ $donation->food_name }} ({{ $donation->quantity }} pcs)</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Klaim</button>
</form>
@endsection
