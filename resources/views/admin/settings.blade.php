<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Insight Stress</title>
    @vite('resources/css/app.css')
    <style>
        /* Custom Toggle Switch */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #f97316;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #f97316;
        }
        .toggle-checkbox:checked + .toggle-label:before {
            transform: translateX(100%);
        }
        
        .toggle-label {
            width: 44px;
            height: 24px;
            position: relative;
            display: block;
            background: #334155;
            border-radius: 9999px;
            cursor: pointer;
            transition: 0.3s;
        }
        .toggle-label:before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            transition: 0.3s;
        }
    </style>
</head>
<body class="bg-slate-900 text-white">

    <div class="flex min-h-screen">
        
        <!-- Sidebar - FIXED -->
        @include('admin.partials.sidebar')

        {{-- Mobile Overlay --}}
        <div id="admin-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto lg:ml-64">
            
                        {{-- Mobile Header with Hamburger --}}
            <header class="lg:hidden bg-slate-800/30 border-b border-slate-700 px-4 py-3 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button id="admin-mobile-menu-button" class="p-2 rounded-lg hover:bg-slate-700/50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-orange-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-white">Admin Panel</span>
                    </div>
                </div>
            </header>
            

            
            <!-- Header -->
            <header class="hidden lg:block bg-slate-800/30 border-b border-slate-700 px-4 lg:px-8 py-4 lg:py-6">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Menu (Mobile Only) -->
                    <button id="admin-sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-slate-700/50 transition">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold">Pengaturan</h1>
                        <p class="text-slate-400 mt-1 text-sm lg:text-base">Kelola pengaturan sistem dan profil admin</p>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-8 space-y-6">

                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Profil Admin -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <h2 class="text-xl font-bold">Profil Admin</h2>
                        </div>
                        <p class="text-slate-400 mb-6 text-sm">Kelola informasi akun administrator</p>

                        <form action="{{ route('admin.settings.profile') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-slate-400 text-sm mb-2">Nama</label>
                                <input type="text" name="name" value="{{ $admin->name }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-orange-500 text-white">
                            </div>
                            <div>
                                <label class="block text-slate-400 text-sm mb-2">Email</label>
                                <input type="email" name="email" value="{{ $admin->email }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-orange-500 text-white">
                            </div>
                            <div>
                                <label class="block text-slate-400 text-sm mb-2">No. Telepon</label>
                                <input type="text" name="phone" value="{{ $admin->phone }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-orange-500 text-white">
                            </div>
                            <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2 mt-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Simpan Profil
                            </button>
                        </form>
                    </div>

                    <form action="{{ route('admin.settings.system') }}" method="POST" class="contents">
                        @csrf
                        @method('PUT')

                        <!-- Notifikasi -->
                        <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <h2 class="text-xl font-bold">Notifikasi</h2>
                            </div>
                            <p class="text-slate-400 mb-6 text-sm">Atur preferensi notifikasi</p>

                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">Notifikasi Email</p>
                                        <p class="text-xs text-slate-400">Terima notifikasi via email</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="notif_email" id="notif_email" class="hidden toggle-checkbox" {{ ($admin->settings['notif_email'] ?? false) ? 'checked' : '' }}>
                                        <label for="notif_email" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">Pengingat Assessment</p>
                                        <p class="text-xs text-slate-400">Kirim pengingat ke mahasiswa</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="notif_reminder" id="notif_reminder" class="hidden toggle-checkbox" {{ ($admin->settings['notif_reminder'] ?? false) ? 'checked' : '' }}>
                                        <label for="notif_reminder" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">Laporan Mingguan</p>
                                        <p class="text-xs text-slate-400">Terima ringkasan mingguan</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="notif_report" id="notif_report" class="hidden toggle-checkbox" {{ ($admin->settings['notif_report'] ?? false) ? 'checked' : '' }}>
                                        <label for="notif_report" class="toggle-label"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Keamanan -->
                        <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <h2 class="text-xl font-bold">Keamanan</h2>
                            </div>
                            <p class="text-slate-400 mb-6 text-sm">Pengaturan keamanan sistem</p>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-slate-400 text-sm mb-2">Minimal Panjang Password</label>
                                    <input type="number" name="min_password_length" value="{{ $systemSettings['min_password_length'] ?? 8 }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-orange-500 text-white">
                                </div>
                                <div>
                                    <label class="block text-slate-400 text-sm mb-2">Session Timeout (menit)</label>
                                    <input type="number" name="session_timeout" value="{{ $systemSettings['session_timeout'] ?? 30 }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-orange-500 text-white">
                                </div>
                                <div>
                                    <label class="block text-slate-400 text-sm mb-2">Max Login Attempts</label>
                                    <input type="number" name="max_login_attempts" value="{{ $systemSettings['max_login_attempts'] ?? 5 }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-orange-500 text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Sistem -->
                        <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                                <h2 class="text-xl font-bold">Sistem</h2>
                            </div>
                            <p class="text-slate-400 mb-6 text-sm">Pengaturan sistem dan database</p>

                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">Auto Backup</p>
                                        <p class="text-xs text-slate-400">Backup otomatis harian</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="auto_backup" id="sys_backup" class="hidden toggle-checkbox" {{ ($systemSettings['auto_backup'] ?? '0') == '1' ? 'checked' : '' }}>
                                        <label for="sys_backup" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">Mode Maintenance</p>
                                        <p class="text-xs text-slate-400">Nonaktifkan akses mahasiswa</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="maintenance_mode" id="sys_maintenance" class="hidden toggle-checkbox" {{ ($systemSettings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                                        <label for="sys_maintenance" class="toggle-label"></label>
                                    </div>
                                </div>
                                
                                <button type="submit" form="backup-form" class="w-full py-3 bg-white hover:bg-gray-100 text-slate-900 font-semibold rounded-lg transition flex items-center justify-center gap-2 mt-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                    </svg>
                                    Backup Manual
                                </button>
                            </div>
                        </div>

                        <!-- Save All Button -->
                        <div class="col-span-1 lg:col-span-2 flex justify-end mt-8">
                            <button type="submit" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition flex items-center gap-2 shadow-lg shadow-orange-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2-2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Simpan Semua Pengaturan
                            </button>
                        </div>
                    </form>

                    <!-- Hidden Backup Form -->
                    <form id="backup-form" action="{{ route('admin.settings.backup') }}" method="POST" class="hidden">
                        @csrf
                    </form>

                </div>

            </div>

        </main>

    </div>


    <script>
        // Admin sidebar toggle functionality
        const adminMobileMenuButton = document.getElementById('admin-mobile-menu-button');
        const adminSidebar = document.getElementById('admin-sidebar');
        const adminSidebarOverlay = document.getElementById('admin-sidebar-overlay');
        const adminSidebarClose = document.getElementById('admin-sidebar-close');

        function openAdminSidebar() {
            adminSidebar.classList.remove('-translate-x-full');
            adminSidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAdminSidebar() {
            adminSidebar.classList.add('-translate-x-full');
            adminSidebarOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        adminMobileMenuButton?.addEventListener('click', openAdminSidebar);
        adminSidebarClose?.addEventListener('click', closeAdminSidebar);
        adminSidebarOverlay?.addEventListener('click', closeAdminSidebar);
    </script>

</body>
</html>
