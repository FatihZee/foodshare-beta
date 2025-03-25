@extends('layouts.app')

@section('title', 'Buat Klaim')

@section('content')
<div class="container mt-5">
    <h1 class="text-center text-primary fw-bold mb-4"><i class="fas fa-utensils"></i> Klaim Makanan</h1>

    @if (session('error'))
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($donations as $donation)
        <div class="col">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">
                        <i class="fas fa-hamburger"></i> {{ $donation->food_name }}
                    </h5>

                    <p class="card-text text-muted">
                        <i class="fas fa-box"></i> Jumlah: {{ $donation->quantity }} pcs
                    </p>
                    
                    <p class="card-text">
                        <i class="fas fa-map-marker-alt"></i> {{ $donation->location }}
                    </p>
                    
                    <p class="card-text">
                        <i class="fas fa-calendar-alt"></i> Kadaluarsa: 
                        {{ date('d M Y, H:i', strtotime($donation->expiration)) }}
                    </p>

                    @if ($donation->maps)
                        <a href="{{ $donation->maps }}" target="_blank" class="btn btn-info btn-sm mb-2">
                            <i class="fas fa-map-marked-alt"></i> Lihat Lokasi
                        </a>
                    @endif
                    
                    @php
                        // Ambil klaim terbaru user
                        $claimed = $donation->claims->first();
                    @endphp

                    @if ($claimed)
                        @if ($claimed->status === 'collected')
                            <button class="btn btn-secondary w-100" disabled>
                                <i class="fas fa-check-circle"></i> Collected
                            </button>
                        @else
                            <button class="btn btn-warning w-100" disabled>
                                <i class="fas fa-hourglass-half"></i> Claimed (Menunggu Persetujuan)
                            </button>
                        @endif
                    @else
                        <form method="POST" action="{{ route('claims.store') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="donation_id" value="{{ $donation->id }}">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-hand-holding-heart"></i> Klaim Makanan
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

@endsection
