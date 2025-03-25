@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Daftar Review</h2>
        <a href="{{ route('reviews.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Review
        </a>
    </div>

    @if ($reviews->isEmpty())
        <div class="alert alert-warning text-center">
            Belum ada review yang tersedia.
        </div>
    @else
        <div class="row">
            @foreach ($reviews as $review)
                <div class="col-md-6 col-lg-4 mb-4">
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
                                <div class="text-center">
                                    <img src="{{ $review->photo }}" alt="Review Photo" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                                </div>
                            @endif

                            <div class="mt-3 d-flex justify-content-between">
                                <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                @if (Auth::check() && Auth::id() === $review->user_id)
                                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
