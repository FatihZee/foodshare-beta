<div class="nav-item dropdown">
    <a class="nav-link position-relative" href="#" id="notifDropdown" data-bs-toggle="dropdown">
        <i class="fas fa-bell"></i>
        <span class="visually-hidden">Notifikasi</span>
        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="notif-count" style="display: none;">0</span>
    </a>
    <div 
        class="dropdown-menu dropdown-menu-end shadow-sm" 
        id="notif-container" 
        aria-labelledby="notifDropdown"
        style="max-height: 400px; overflow-y: auto; width: 320px; max-width: 90vw; padding: 0;"
    >
        <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
            <h6 class="m-0">Notifikasi</h6>
            <button id="mark-all-read" class="btn btn-sm text-primary border-0" style="font-size: 0.8rem;">Tandai semua dibaca</button>
        </div>
        <ul id="notif-list" class="list-group list-group-flush m-0">
            <li class="list-group-item text-center py-3">
                <div class="spinner-border spinner-border-sm text-secondary" role="status">
                    <span class="visually-hidden">Memuat...</span>
                </div>
                <p class="text-muted mb-0 mt-2">Memuat notifikasi...</p>
            </li>
        </ul>
        <div class="p-2 text-center border-top" id="notif-footer" style="display: none;">
            <a href="#" class="text-decoration-none">Lihat semua notifikasi</a>
        </div>
    </div>
</div>