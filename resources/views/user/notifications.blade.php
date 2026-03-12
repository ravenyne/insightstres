@extends('layouts.dashboard')

@section('title', __('Notifications'))

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-200 p-8">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white" data-i18n="page_title">{{ __('Notifications') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1" data-i18n="page_subtitle" data-count="{{ $unreadCount }}">
                    {{ __('You have :count unread notifications', ['count' => $unreadCount]) }}
                </p>
            </div>
            
            <div class="flex gap-3">
                @if($notifications->count() > 0)
                    <button onclick="markAllAsRead()" 
                            class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors flex items-center gap-2">
                        <i data-lucide="check-check" class="w-4 h-4"></i>
                        <span data-i18n="btn_mark_all">{{ __('Mark All as Read') }}</span>
                    </button>
                    <button onclick="deleteAll()" 
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors flex items-center gap-2">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        <span data-i18n="btn_delete_all">{{ __('Delete All') }}</span>
                    </button>
                @endif
            </div>
        </div>

        {{-- Notifications List --}}
        @if($notifications->count() > 0)
            <div class="space-y-3" id="notifications-container">
                @foreach($notifications as $notification)
                    <div class="notification-card bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-200 relative"
                         data-notification-id="{{ $notification->id }}"
                         onclick="markAsRead({{ $notification->id }})">
                        
                        {{-- Icon Badge --}}
                        <div class="flex items-start gap-4">
                            @php
                                $iconColors = [
                                    'info' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
                                    'success' => 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400',
                                    'warning' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400',
                                    'error' => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400',
                                ];
                                $colorClass = $iconColors[$notification->type] ?? $iconColors['info'];
                                
                                $icons = [
                                    'info' => 'info',
                                    'success' => 'check-circle',
                                    'warning' => 'alert-triangle',
                                    'error' => 'alert-circle',
                                ];
                                $iconName = $notification->icon ?? $icons[$notification->type] ?? 'bell';
                            @endphp
                            
                            <div class="w-12 h-12 rounded-full {{ $colorClass }} flex items-center justify-center flex-shrink-0">
                                <i data-lucide="{{ $iconName }}" class="w-6 h-6"></i>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2 notification-title"
                                        data-title-id="{{ $notification->title }}"
                                        data-title-en="{{ $notification->title_en ?? $notification->title }}">
                                        {{ $notification->title }}
                                        @if(!$notification->is_read)
                                            <span class="w-2 h-2 bg-green-500 rounded-full unread-indicator"></span>
                                        @endif
                                    </h3>
                                    
                                    {{-- Delete Button --}}
                                    <button onclick="event.stopPropagation(); deleteNotification({{ $notification->id }})" 
                                            class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                
                                <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm notification-msg"
                                   data-message-id="{{ $notification->message }}"
                                   data-message-en="{{ $notification->message_en ?? $notification->message }}">
                                    {{ $notification->message }}
                                </p>
                                
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-12 text-center border border-gray-200 dark:border-gray-700">
                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="bell-off" class="w-10 h-10 text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2" data-i18n="empty_title">{{ __('No Notifications Yet') }}</h3>
                <p class="text-gray-600 dark:text-gray-400" data-i18n="empty_desc">
                    {{ __('Your notifications will appear here') }}
                </p>
            </div>
        @endif

    </div>
</div>

<script>
    lucide.createIcons();

    // Mark single notification as read
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
                const indicator = card.querySelector('.unread-indicator');
                if (indicator) indicator.remove();
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Mark all notifications as read
    function markAllAsRead() {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.unread-indicator').forEach(el => el.remove());
                const lang = (localStorage.getItem('app_language') || 'id').toLowerCase();
                const t = i18nNotif[lang] || i18nNotif['id'];
                const subtitle = document.querySelector('[data-i18n="page_subtitle"]');
                if (subtitle) {
                    subtitle.setAttribute('data-count', '0');
                    subtitle.textContent = t['page_subtitle_zero'];
                }
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete single notification
    function deleteNotification(notificationId) {
        if (!confirm(window.confirmDeleteMsg || 'Delete this notification?')) return;
        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
                card.style.opacity = '0';
                card.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    card.remove();
                    if (document.querySelectorAll('.notification-card').length === 0) location.reload();
                }, 300);
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete all notifications
    function deleteAll() {
        if (!confirm(window.confirmDeleteAllMsg || 'Delete all read notifications?')) return;
        fetch('/notifications/delete-all', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => { if (data.success) location.reload(); })
        .catch(error => console.error('Error:', error));
    }

    // Update sidebar badge via AJAX (no page reload)
    function updateUnreadCount() {
        fetch('/notifications/unread-count', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        })
        .then(response => response.json())
        .then(data => {
            const count = data.count ?? 0;
            if (typeof window.updateSidebarNotifBadge === 'function') window.updateSidebarNotifBadge(count);
            const lang = (localStorage.getItem('app_language') || 'id').toLowerCase();
            const t = i18nNotif[lang] || i18nNotif['id'];
            const subtitle = document.querySelector('[data-i18n="page_subtitle"]');
            if (subtitle) {
                subtitle.setAttribute('data-count', count);
                subtitle.textContent = (count === 0 && t['page_subtitle_zero'])
                    ? t['page_subtitle_zero']
                    : t['page_subtitle'].replace('{count}', count);
            }
        })
        .catch(error => console.error('Error fetching count:', error));
    }

    // ===== i18n — static UI labels only =====
    const i18nNotif = {
        id: {
            page_title:         'Notifikasi',
            page_subtitle:      'Anda memiliki {count} notifikasi belum dibaca',
            page_subtitle_zero: 'Tidak ada notifikasi baru',
            btn_mark_all:       'Tandai Semua Dibaca',
            btn_delete_all:     'Hapus Semua',
            empty_title:        'Belum Ada Notifikasi',
            empty_desc:         'Notifikasi Anda akan muncul di sini',
            confirm_delete:     'Hapus notifikasi ini?',
            confirm_delete_all: 'Hapus semua notifikasi yang sudah dibaca?',
        },
        en: {
            page_title:         'Notifications',
            page_subtitle:      'You have {count} unread notifications',
            page_subtitle_zero: 'You have no new notifications',
            btn_mark_all:       'Mark All as Read',
            btn_delete_all:     'Delete All',
            empty_title:        'No Notifications Yet',
            empty_desc:         'Your notifications will appear here',
            confirm_delete:     'Delete this notification?',
            confirm_delete_all: 'Delete all read notifications?',
        }
    };

    function applyNotificationI18n() {
        const lang = (localStorage.getItem('app_language') || 'id').toLowerCase();
        const t = i18nNotif[lang] || i18nNotif['id'];

        // Static UI labels
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (key === 'page_subtitle') {
                const count = parseInt(el.getAttribute('data-count') || '0', 10);
                el.textContent = (count === 0 && t['page_subtitle_zero'])
                    ? t['page_subtitle_zero']
                    : t[key].replace('{count}', count);
            } else if (t[key] !== undefined) {
                el.textContent = t[key];
            }
        });

        // Dynamic notification TITLES — from DB via data-attrs
        document.querySelectorAll('.notification-title').forEach(el => {
            const titleId = el.getAttribute('data-title-id');
            const titleEn = el.getAttribute('data-title-en');
            const indicator = el.querySelector('.unread-indicator');
            const text = (lang === 'en' && titleEn) ? titleEn : (titleId || '');
            if (text) {
                el.textContent = text;
                if (indicator) el.appendChild(indicator);
            }
        });

        // Dynamic notification MESSAGES — from DB via data-attrs
        document.querySelectorAll('.notification-msg').forEach(el => {
            const msgId = el.getAttribute('data-message-id');
            const msgEn = el.getAttribute('data-message-en');
            const text = (lang === 'en' && msgEn) ? msgEn : (msgId || '');
            if (text) el.textContent = text;
        });

        document.title = t['page_title'] + ' - Insight Stress';
        window.confirmDeleteMsg    = t['confirm_delete'];
        window.confirmDeleteAllMsg = t['confirm_delete_all'];
    }

    applyNotificationI18n();

    window.addEventListener('storage', function(e) {
        if (e.key === 'app_language') applyNotificationI18n();
    });
</script>
@endsection