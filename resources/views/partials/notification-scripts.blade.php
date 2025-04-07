<script>
    async function loadNotifications() {
        const list = document.getElementById('notif-list');
        const count = document.getElementById('notif-count');
        const footer = document.getElementById('notif-footer');
    
        try {
            const res = await fetch('{{ route('notifications.index') }}');
            const data = await res.json();
    
            list.innerHTML = '';
    
            if (data.length === 0) {
                list.innerHTML = `
                    <li class="list-group-item text-center py-4">
                        <i class="fas fa-bell-slash text-muted mb-2" style="font-size: 1.5rem;"></i>
                        <p class="text-muted mb-0">Tidak ada notifikasi</p>
                    </li>`;
                count.style.display = 'none';
                footer.style.display = 'none';
            } else {
                let unreadCount = 0;
    
                data.forEach((notif, index) => {
                    if (!notif.is_read) unreadCount++;
                    
                    const timestamp = notif.created_at ? new Date(notif.created_at) : null;
                    const timeStr = timestamp ? formatTimeAgo(timestamp) : '';
    
                    list.innerHTML += `
                        <li class="list-group-item p-2 notification-item ${notif.is_read ? '' : 'unread'}" 
                            data-id="${notif.id || index}">
                            <div class="d-flex">
                                <div class="me-2">
                                    <div class="notification-indicator ${notif.is_read ? 'bg-light' : 'bg-primary'}" 
                                        style="width: 10px; height: 10px; border-radius: 50%; margin-top: 6px;"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-1 ${notif.is_read ? 'text-muted' : 'fw-bold'}">${notif.message}</p>
                                    </div>
                                    <small class="text-muted">${timeStr}</small>
                                </div>
                                ${!notif.is_read ? `
                                <button class="btn btn-sm mark-read border-0" data-id="${notif.id || index}">
                                    <i class="fas fa-check text-muted" style="font-size: 0.8rem;"></i>
                                </button>` : ''}
                            </div>
                        </li>
                    `;
                });
    
                if (unreadCount > 0) {
                    count.textContent = unreadCount;
                    count.style.display = 'inline';
                } else {
                    count.style.display = 'none';
                }
                
                footer.style.display = 'block';
                
                document.querySelectorAll('.mark-read').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        markNotificationRead(btn.dataset.id);
                    });
                });
                
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.addEventListener('click', () => {
                        if (!item.classList.contains('unread')) return;
                        
                        markNotificationRead(item.dataset.id);
                    });
                });
            }
        } catch (err) {
            console.error('Gagal memuat notifikasi:', err);
            list.innerHTML = `
                <li class="list-group-item text-center py-3">
                    <i class="fas fa-exclamation-circle text-danger mb-2" style="font-size: 1.5rem;"></i>
                    <p class="text-danger mb-0">Gagal memuat notifikasi</p>
                </li>`;
        }
    }
    
    function formatTimeAgo(date) {
        const now = new Date();
        const diffMs = now - date;
        const diffSec = Math.floor(diffMs / 1000);
        const diffMin = Math.floor(diffSec / 60);
        const diffHour = Math.floor(diffMin / 60);
        const diffDay = Math.floor(diffHour / 24);
    
        if (diffDay > 0) {
            return diffDay === 1 ? '1 hari yang lalu' : `${diffDay} hari yang lalu`;
        } else if (diffHour > 0) {
            return diffHour === 1 ? '1 jam yang lalu' : `${diffHour} jam yang lalu`;
        } else if (diffMin > 0) {
            return diffMin === 1 ? '1 menit yang lalu' : `${diffMin} menit yang lalu`;
        } else {
            return 'Baru saja';
        }
    }
    
    async function markNotificationRead(id) {
        try {
            await fetch('{{ route('notifications.read') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            });
            
            loadNotifications();
        } catch (err) {
            console.error('Gagal menandai notifikasi sebagai dibaca:', err);
        }
    }
    
    async function markAllNotificationsRead() {
        try {
            await fetch('{{ route('notifications.read') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            
            loadNotifications();
            document.getElementById('notif-count').style.display = 'none';
        } catch (err) {
            console.error('Gagal menandai semua notifikasi sebagai dibaca:', err);
        }
    }

    document.getElementById('notifDropdown').addEventListener('click', () => {
        loadNotifications();
    });
    
    document.getElementById('mark-all-read').addEventListener('click', (e) => {
        e.preventDefault();
        markAllNotificationsRead();
    });
    
    window.addEventListener('load', () => {
        fetch('{{ route('notifications.index') }}')
            .then(res => res.json())
            .then(data => {
                const unread = data.filter(notif => !notif.is_read);
                if (unread.length > 0) {
                    const count = document.getElementById('notif-count');
                    count.textContent = unread.length;
                    count.style.display = 'inline';
                }
            });
    });
</script>