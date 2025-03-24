@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Detail Review</h2>
        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $review->user->name }}</h5>
            <p class="mb-1">
                <span class="text-warning">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                    @endfor
                </span> ({{ $review->rating }}/5)
            </p>
            <p class="text-muted">{{ $review->comment }}</p>
            
            @if ($review->photo)
                <div class="text-center my-3">
                    <img src="{{ $review->photo }}" alt="Review Photo" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                </div>
            @endif
            
            @if (Auth::check() && Auth::id() === $review->user_id)
                <div class="d-flex justify-content-end">
                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-outline-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
