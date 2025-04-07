<div class="navbar d-flex justify-content-between align-items-center">
    <a href="{{ route('home') }}" class="fs-3 fw-bold text-primary text-uppercase text-decoration-none">
        FoodShare
    </a>

    <button class="btn btn-outline-dark toggle-btn d-md-none d-block" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="d-flex align-items-center gap-3">
        @auth
            <!-- 🔔 Bell Notification -->
            @include('partials.notification-dropdown')

            <!-- 👤 User Menu -->
            <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('users.edit', ['user' => Auth::user()->id]) }}">Edit Profile</a>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary" style="color: white;">Login</a>
        @endauth
    </div>
</div>