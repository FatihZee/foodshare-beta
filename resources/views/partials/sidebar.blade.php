<div class="sidebar">
    @auth
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('users.index') }}">
                <i class="fas fa-users fa-fw"></i>
                <span>Users</span>
            </a>
        @endif
        <a href="{{ route('articles.index') }}">
            <i class="fas fa-newspaper fa-fw"></i>
            <span>Artikel</span>
        </a>
        <a href="{{ route('categories.index') }}">
            <i class="fas fa-list-alt fa-fw"></i>
            <span>Kategori Makanan</span>
        </a>
        <a href="{{ route('donations.index') }}">
            <i class="fas fa-hand-holding-heart fa-fw"></i>
            <span>Donasi</span>
        </a>
        <a href="{{ route('claims.index') }}">
            <i class="fas fa-receipt fa-fw"></i>
            <span>Klaim</span>
        </a>
        <a href="{{ route('reviews.index') }}">
            <i class="fas fa-star fa-fw"></i>
            <span>Review</span>
        </a>
        <a href="{{ route('wishlist.index') }}">
            <i class="fas fa-heart fa-fw"></i>
            <span>Wishlist</span>
        </a>
    @else
        <a href="{{ route('articles.index') }}">
            <i class="fas fa-newspaper fa-fw"></i>
            <span>Artikel</span>
        </a>
        <a href="{{ route('categories.index') }}">
            <i class="fas fa-list-alt fa-fw"></i>
            <span>Kategori Makanan</span>
        </a>
        <a href="{{ route('donations.index') }}">
            <i class="fas fa-hand-holding-heart fa-fw"></i>
            <span>Donasi</span>
        </a>
        <a href="{{ route('claims.index') }}">
            <i class="fas fa-receipt fa-fw"></i>
            <span>Klaim</span>
        </a>
        <a href="{{ route('reviews.index') }}">
            <i class="fas fa-star fa-fw"></i>
            <span>Review</span>
        </a>
        <a href="{{ route('wishlist.index') }}">
            <i class="fas fa-heart fa-fw"></i>
            <span>Wishlist</span>
        </a>
    @endauth
</div>