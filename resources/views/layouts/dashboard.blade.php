<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard - Insight Stress' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    
    <script>
        // Sync Laravel locale with JS localStorage
        const serverLocale = '{{ app()->getLocale() }}';
        if (localStorage.getItem('app_language') !== serverLocale) {
            localStorage.setItem('app_language', serverLocale);
            // Trigger storage event for other tabs/components
            window.dispatchEvent(new Event('storage'));
        }

        // Dark mode initialization - must run before page renders
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200">

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <div class="lg:ml-64 min-h-screen">
        {{-- Mobile Header with Hamburger --}}
        <header class="lg:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-3 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button id="mobile-menu-button" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-500 flex items-center justify-center">
                        <i data-lucide="brain" class="w-4 h-4 text-white"></i>
                    </div>
                    <span class="font-semibold text-gray-800 dark:text-white">Insight Stress</span>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="p-4 lg:p-8">
            @yield('content')
        </main>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const sidebarCloseButton = document.getElementById('sidebar-close');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        mobileMenuButton?.addEventListener('click', openSidebar);
        sidebarCloseButton?.addEventListener('click', closeSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);

        // Initialize Lucide icons
        lucide.createIcons();
    </script>

    {{-- Badge Notifications --}}
    @include('components.badge-notification')

</body>
</html>