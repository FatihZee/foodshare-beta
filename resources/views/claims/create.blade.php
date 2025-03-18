@extends('layouts.app')

@section('title', 'Buat Klaim')

@section('content')
    <div class="d-flex justify-content-center align-items-center claim-container">
        <div class="col-md-6 col-lg-4">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4">Buat Klaim Makanan</h1>
                    <form method="POST" action="{{ route('claims.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="donation_id" class="form-label">Donasi Makanan</label>
                            <select name="donation_id" class="form-select form-select-lg" required>
                                <option value="">Pilih Makanan</option>
                                @foreach ($donations as $donation)
                                    <option value="{{ $donation->id }}">{{ $donation->food_name }} ({{ $donation->quantity }} pcs)</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 mt-3">Klaim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Pastikan container di tengah */
    .claim-container {
        height: calc(100vh - 160px); /* Mengurangi tinggi untuk navbar dan footer */
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush
