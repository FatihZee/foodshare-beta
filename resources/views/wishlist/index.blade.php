@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center"><i class="fas fa-heart"></i> Wishlist Saya</h2>

    @if($wishlists->isEmpty())
        <p class="text-center text-muted">Belum ada makanan di wishlist.</p>
    @else
        <ul class="list-group">
            @foreach($wishlists as $wishlist)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $wishlist->donation->food_name }} (Lokasi: {{ $wishlist->donation->location }})
                    <form action="{{ route('wishlist.destroy', $wishlist->donation->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
