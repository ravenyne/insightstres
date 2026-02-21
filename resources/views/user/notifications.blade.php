@extends('layouts.dashboard')

@section('title', 'Notifikasi')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-200 p-8">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Notifikasi</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Anda memiliki {{ $unreadCount }} notifikasi belum dibaca
                </p>
            </div>
            
            <div class="flex gap-3">
                @if($notifications->count() > 0)
                    <button onclick="markAllAsRead()" 
                            class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors flex items-center gap-2">
                        <i data-lucide="check-check" class="w-4 h-4"></i>
                        Tandai Semua Dibaca
                    </button>
                    <button onclick="deleteAll()" 
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors flex items-center gap-2">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        Hapus Semua
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
                                    <h3 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
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
                                
                                <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm">
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
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Belum Ada Notifikasi</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Notifikasi Anda akan muncul di sini
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
                // Remove the green dot indicator
                const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
                const indicator = card.querySelector('.unread-indicator');
                if (indicator) {
                    indicator.remove();
                }
                
                // Update unread count
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
                // Remove all green dot indicators
                document.querySelectorAll('.unread-indicator').forEach(el => el.remove());
                
                // Reload page to update count
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete single notification
    function deleteNotification(notificationId) {
        if (!confirm('Hapus notifikasi ini?')) return;
        
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
                // Remove the notification card
                const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
                card.style.opacity = '0';
                card.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    card.remove();
                    
                    // Check if no notifications left
                    if (document.querySelectorAll('.notification-card').length === 0) {
                        location.reload();
                    }
                }, 300);
                
                // Update unread count
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete all read notifications
    function deleteAll() {
        if (!confirm('Hapus semua notifikasi yang sudah dibaca?')) return;
        
        fetch('/notifications/delete-all', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Update unread count in the page
    function updateUnreadCount() {
        // This would ideally fetch the new count from the server
        // For now, we'll just reload the page after a short delay
        setTimeout(() => {
            location.reload();
        }, 500);
    }
</script>
@endsection