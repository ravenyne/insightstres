<div id="sidebar" class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 h-screen fixed top-0 left-0 flex flex-col transition-all duration-300 z-50 -translate-x-full lg:translate-x-0 overflow-y-auto">

    {{-- LOGO & Close Button --}}
    <div class="flex items-center justify-between gap-3 p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-teal-500 flex items-center justify-center">
                <i data-lucide="brain" class="w-6 h-6 text-white"></i>
            </div>
            <span class="text-xl font-semibold text-gray-800 dark:text-white">Insight Stress</span>
        </div>
        
        {{-- Close button (mobile only) --}}
        <button id="sidebar-close" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors
           {{ request()->is('dashboard') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="layout-dashboard"
               class="w-5 h-5 {{ request()->is('dashboard') ? 'text-white' : 'text-gray-500 dark:text-gray-400' }}"></i>
            Dashboard
        </a>

        {{-- Assessment --}}
        <a href="{{ route('user.assessment') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors
           {{ request()->is('assessment*') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="clipboard-list"
               class="w-5 h-5 {{ request()->is('assessment*') ? 'text-white' : 'text-gray-500 dark:text-gray-400' }}"></i>
            Penilaian Stress
        </a>

        {{-- Hasil Analisis --}}
        <a href="{{ route('user.analysis') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors
           {{ request()->is('analysis') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="bar-chart-3"
               class="w-5 h-5 {{ request()->is('analysis') ? 'text-white' : 'text-gray-500 dark:text-gray-400' }}"></i>
            Hasil Analisis
        </a>

        {{-- Riwayat --}}
        <a href="{{ route('user.history') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors
           {{ request()->is('history') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="history"
               class="w-5 h-5 {{ request()->is('history') ? 'text-white' : 'text-gray-500 dark:text-gray-400' }}"></i>
            Riwayat Penilaian
        </a>

        {{-- Notifikasi --}}
        <a href="{{ route('user.notifications') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors relative
           {{ request()->is('notifications') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="bell"
               class="w-5 h-5 {{ request()->is('notifications') ? 'text-white' : 'text-gray-500 dark:text-gray-400' }}"></i>
            Notifikasi
            @php
                $unreadCount = Auth::user()->unread_notification_count ?? 0;
            @endphp
            @if($unreadCount > 0)
                <span class="absolute top-2 left-8 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif
        </a>

        {{-- Tips & Artikel --}}
        <a href="{{ route('user.tips') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors
           {{ request()->is('tips*') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="book-open"
               class="w-5 h-5 {{ request()->is('tips*') ? 'text-white' : 'text-gray-500 dark:text-gray-400' }}"></i>
            Insight & Edukasi
        </a>

        {{-- Latihan Pernapasan --}}
        <a href="{{ route('user.breathing') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors
           {{ request()->is('breathing') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="wind"
               class="w-5 h-5 {{ request()->is('breathing') ? 'text-white' : 'text-gray-500 dark:text-gray-400' }}"></i>
            Latihan Pernapasan
        </a>

        {{-- Profil --}}
        <a href="{{ route('user.profile') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors
           {{ request()->is('profile') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="user"
               class="w-5 h-5 {{ request()->is('profile') ? 'text-white' : 'text-gray-500 dark:text-gray-400' }}"></i>
            Profil
        </a>

    </nav>

    {{-- DARK MODE TOGGLE --}}
    <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
        <button id="darkModeToggle" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 w-full transition-colors">
            <i data-lucide="moon" class="w-5 h-5 text-gray-500 dark:text-gray-400 dark-mode-icon"></i>
            <i data-lucide="sun" class="w-5 h-5 text-gray-500 dark:text-gray-400 light-mode-icon hidden"></i>
            <span class="dark-mode-text">Mode Gelap</span>
            <span class="light-mode-text hidden">Mode Terang</span>
        </button>
    </div>

    {{-- LOGOUT --}}
    <form action="{{ route('logout') }}" method="POST" class="px-4 pb-4">
        @csrf
        <button type="submit"
                class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 w-full transition-colors">
            <i data-lucide="log-out" class="w-5 h-5 text-red-600 dark:text-red-400"></i>
            Keluar
        </button>
    </form>

</div>

<script>
    lucide.createIcons();
    
    // Dark mode toggle functionality
    const darkModeToggle = document.getElementById('darkModeToggle');
    const html = document.documentElement;
    
    // Update toggle button appearance
    function updateToggleButton() {
        const isDark = html.classList.contains('dark');
        document.querySelectorAll('.dark-mode-icon, .dark-mode-text').forEach(el => {
            el.classList.toggle('hidden', isDark);
        });
        document.querySelectorAll('.light-mode-icon, .light-mode-text').forEach(el => {
            el.classList.toggle('hidden', !isDark);
        });
        lucide.createIcons();
    }
    
    // Toggle dark mode
    darkModeToggle.addEventListener('click', () => {
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            html.classList.add('dark');
            localStorage.theme = 'dark';
        }
        updateToggleButton();
    });
    
    // Initialize button state
    updateToggleButton();
</script>