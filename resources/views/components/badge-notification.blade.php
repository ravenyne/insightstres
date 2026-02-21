@auth
    @php
        $badgeNotifications = auth()->user()->unreadNotifications()
            ->where('type', 'badge_earned')
            ->get();
    @endphp

    @if($badgeNotifications->count() > 0)
        <div id="badge-toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-4">
            @foreach($badgeNotifications as $notification)
                @php
                    $data = json_decode($notification->data, true);
                @endphp
                <div class="badge-toast transform transition-all duration-500 translate-x-full opacity-0 bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-4 flex items-center gap-4 border-l-4 border-teal-500 w-80"
                     data-id="{{ $notification->id }}">
                    <div class="flex-shrink-0 w-12 h-12 bg-teal-100 dark:bg-teal-900 rounded-full flex items-center justify-center text-2xl">
                        {{ $data['badge_icon'] ?? '🏆' }}
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 dark:text-white mb-1">Badge Unlocked!</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $data['badge_name'] ?? 'New Badge' }}</p>
                        <p class="text-xs text-teal-600 dark:text-teal-400 font-semibold mt-1">+{{ $data['points'] ?? 0 }} Points</p>
                    </div>
                    <button onclick="closeBadgeToast(this.closest('.badge-toast'))" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toasts = document.querySelectorAll('.badge-toast');
                
                toasts.forEach((toast, index) => {
                    setTimeout(() => {
                        // Show toast
                        toast.classList.remove('translate-x-full', 'opacity-0');
                        
                        // Mark as read via AJAX
                        const notificationId = toast.getAttribute('data-id');
                        markNotificationAsRead(notificationId);
                        
                        // Auto dismiss after 5 seconds
                        setTimeout(() => {
                            if (document.body.contains(toast)) {
                                closeBadgeToast(toast);
                            }
                        }, 5000 + (index * 1000));
                        
                    }, index * 1000); // Stagger appearance
                });
            });

            function closeBadgeToast(element) {
                element.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    element.remove();
                }, 500);
            }

            function markNotificationAsRead(id) {
                if (!id) return;
                
                fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => console.log('Notification marked as read'))
                .catch(error => console.error('Error marking notification as read:', error));
            }
        </script>
    @endif
@endauth
