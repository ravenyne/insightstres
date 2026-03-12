<aside id="admin-sidebar" class="w-64 bg-slate-800 border-r border-slate-700 flex flex-col fixed h-screen transition-all duration-300 z-50 -translate-x-full lg:translate-x-0 overflow-y-auto">
    
    <!-- Logo & Close Button -->
    <div class="flex items-center justify-between p-6 border-b border-slate-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-teal-500 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <span class="font-bold text-lg">{{ __('admin_panel') }}</span>
        </div>
        
        <!-- Close button (mobile only) -->
        <button id="admin-sidebar-close" class="lg:hidden p-2 rounded-lg hover:bg-slate-700/50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-500 text-white' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }} rounded-lg font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            {{ __('admin_dashboard') }}
        </a>

        <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.users') ? 'bg-teal-500 text-white' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }} rounded-lg font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            {{ __('admin_data_mahasiswa') }}
        </a>

        <a href="{{ route('admin.assessments') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.assessments') ? 'bg-teal-500 text-white' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }} rounded-lg font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            {{ __('admin_analitik') }}
        </a>

        <!-- Insight & Edukasi -->
        <a href="{{ route('admin.tips') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.tips*') ? 'bg-teal-500 text-white' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }} rounded-lg font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            {{ __('admin_insight_edukasi') }}
        </a>

        <a href="{{ route('admin.feedback') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.feedback') ? 'bg-teal-500 text-white' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }} rounded-lg font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            {{ __('admin_feedback') }}
        </a>

        <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.settings') ? 'bg-teal-500 text-white' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }} rounded-lg font-medium transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ __('admin_pengaturan') }}
        </a>
    </nav>

    <!-- Bottom: Language Switcher + Logout -->
    <div class="border-t border-slate-700">

        <!-- Language Switcher -->
        <div class="flex items-center gap-3 px-8 py-4">
            <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
            </svg>
            <div class="flex items-center gap-1">
                <a href="{{ route('lang.switch', 'id') }}"
                   class="px-2.5 py-1 text-xs font-bold rounded-md transition
                   {{ app()->getLocale() === 'id' ? 'bg-teal-500 text-white' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                    ID
                </a>
                <span class="text-xs text-slate-600">/</span>
                <a href="{{ route('lang.switch', 'en') }}"
                   class="px-2.5 py-1 text-xs font-bold rounded-md transition
                   {{ app()->getLocale() === 'en' ? 'bg-teal-500 text-white' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                    EN
                </a>
            </div>
        </div>

        <!-- Logout -->
        <form action="{{ route('admin.logout') }}" method="POST" class="px-4 pb-4">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-red-500/10 hover:text-red-400 rounded-lg font-medium transition w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                {{ __('admin_keluar') }}
            </button>
        </form>
    </div>

</aside>
