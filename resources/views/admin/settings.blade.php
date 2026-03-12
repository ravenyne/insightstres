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
            border-color: #14b8a6;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #14b8a6;
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
                        <div class="w-8 h-8 rounded-lg bg-teal-500 flex items-center justify-center">
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
                        <h1 class="text-2xl lg:text-3xl font-bold" data-i18n="page_title">{{ __('admin_pengaturan') }}</h1>
                        <p class="text-slate-400 mt-1 text-sm lg:text-base" data-i18n="page_subtitle">{{ __('admin_pengaturan_subtitle') }}</p>
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
                            <h2 class="text-xl font-bold" data-i18n="sec_admin_profile">Profil Admin</h2>
                        </div>
                        <p class="text-slate-400 mb-6 text-sm" data-i18n="sec_admin_profile_sub">Kelola informasi akun administrator</p>

                        <form action="{{ route('admin.settings.profile') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-slate-400 text-sm mb-2" data-i18n="lbl_name">Nama</label>
                                <input type="text" name="name" value="{{ $admin->name }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-teal-500 text-white">
                            </div>
                            <div>
                                <label class="block text-slate-400 text-sm mb-2" data-i18n="lbl_email">Email</label>
                                <input type="email" name="email" value="{{ $admin->email }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-teal-500 text-white">
                            </div>
                            <div>
                                <label class="block text-slate-400 text-sm mb-2" data-i18n="lbl_phone">No. Telepon</label>
                                <input type="text" name="phone" value="{{ $admin->phone }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-teal-500 text-white">
                            </div>
                            <button type="submit" class="w-full py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2 mt-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                <span data-i18n="btn_save_profile">{{ __('Simpan Profil') }}</span>
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
                                <h2 class="text-xl font-bold" data-i18n="sec_notifications">Notifikasi</h2>
                            </div>
                            <p class="text-slate-400 mb-6 text-sm" data-i18n="sec_notifications_sub">Atur preferensi notifikasi</p>

                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="notif_email_label">Notifikasi Email</p>
                                        <p class="text-xs text-slate-400" data-i18n="notif_email_desc">Terima notifikasi via email</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="notif_email" id="notif_email" class="hidden toggle-checkbox" {{ ($admin->settings['notif_email'] ?? false) ? 'checked' : '' }}>
                                        <label for="notif_email" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="notif_reminder_label">Pengingat Assessment</p>
                                        <p class="text-xs text-slate-400" data-i18n="notif_reminder_desc">Kirim pengingat ke mahasiswa</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="notif_reminder" id="notif_reminder" class="hidden toggle-checkbox" {{ ($admin->settings['notif_reminder'] ?? false) ? 'checked' : '' }}>
                                        <label for="notif_reminder" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="notif_report_label">Laporan Mingguan</p>
                                        <p class="text-xs text-slate-400" data-i18n="notif_report_desc">Terima ringkasan mingguan</p>
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
                                <h2 class="text-xl font-bold" data-i18n="sec_security">Keamanan</h2>
                            </div>
                            <p class="text-slate-400 mb-6 text-sm" data-i18n="sec_security_sub">Pengaturan keamanan sistem</p>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-slate-400 text-sm mb-2" data-i18n="lbl_min_password">Minimal Panjang Password</label>
                                    <input type="number" name="min_password_length" value="{{ $systemSettings['min_password_length'] ?? 8 }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-teal-500 text-white">
                                </div>
                                <div>
                                    <label class="block text-slate-400 text-sm mb-2" data-i18n="lbl_session_timeout">Session Timeout (menit)</label>
                                    <input type="number" name="session_timeout" value="{{ $systemSettings['session_timeout'] ?? 30 }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-teal-500 text-white">
                                </div>
                                <div>
                                    <label class="block text-slate-400 text-sm mb-2" data-i18n="lbl_max_login">Max Login Attempts</label>
                                    <input type="number" name="max_login_attempts" value="{{ $systemSettings['max_login_attempts'] ?? 5 }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-teal-500 text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Sistem -->
                        <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                                <h2 class="text-xl font-bold" data-i18n="sec_system">Sistem</h2>
                            </div>
                            <p class="text-slate-400 mb-6 text-sm" data-i18n="sec_system_sub">Pengaturan sistem dan database</p>

                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="sys_backup_label">Auto Backup</p>
                                        <p class="text-xs text-slate-400" data-i18n="sys_backup_desc">Backup otomatis harian</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="auto_backup" id="sys_backup" class="hidden toggle-checkbox" {{ ($systemSettings['auto_backup'] ?? '0') == '1' ? 'checked' : '' }}>
                                        <label for="sys_backup" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="sys_maintenance_label">Mode Maintenance</p>
                                        <p class="text-xs text-slate-400" data-i18n="sys_maintenance_desc">Nonaktifkan akses mahasiswa</p>
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
                                    <span data-i18n="btn_manual_backup">Backup Manual</span>
                                </button>
                            </div>
                        </div>

                        <!-- ====== MONITORING KESEHATAN MENTAL ====== -->
                        <div class="bg-slate-800/50 border border-teal-500/30 rounded-2xl p-6 col-span-1 lg:col-span-2">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-teal-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold" data-i18n="sec_mh_monitoring">Pengaturan Monitoring Kesehatan Mental</h2>
                                    <p class="text-slate-400 text-sm" data-i18n="sec_mh_monitoring_sub">Konfigurasi sistem pemantauan kondisi stress mahasiswa</p>
                                </div>
                            </div>
                            <div class="border-t border-slate-700 mt-4 pt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-slate-300 text-sm font-medium mb-2" data-i18n="lbl_assessment_interval">Interval Pengingat Assessment</label>
                                    <p class="text-xs text-slate-500 mb-3" data-i18n="hint_assessment_interval">Seberapa sering mahasiswa akan diingatkan untuk melakukan assessment stress</p>
                                    <select name="assessment_reminder_interval" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-teal-500 text-white">
                                        <option value="7" {{ ($systemSettings['assessment_reminder_interval'] ?? '14') == '7' ? 'selected' : '' }} data-i18n="opt_7days">7 Hari (Mingguan)</option>
                                        <option value="14" {{ ($systemSettings['assessment_reminder_interval'] ?? '14') == '14' ? 'selected' : '' }} data-i18n="opt_14days">14 Hari (Dua Mingguan)</option>
                                        <option value="30" {{ ($systemSettings['assessment_reminder_interval'] ?? '14') == '30' ? 'selected' : '' }} data-i18n="opt_30days">30 Hari (Bulanan)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-slate-300 text-sm font-medium mb-2" data-i18n="lbl_distress_threshold">Ambang Batas Distress Alert <span class="text-teal-400 font-normal">(Skor 0–100)</span></label>
                                    <p class="text-xs text-slate-500 mb-3" data-i18n="hint_distress_threshold">Skor stress di atas angka ini akan diklasifikasikan sebagai kondisi Distress (Risiko Tinggi)</p>
                                    <input type="number" name="distress_threshold" min="1" max="100" value="{{ $systemSettings['distress_threshold'] ?? 70 }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-teal-500 text-white">
                                </div>
                            </div>
                        </div>

                        <!-- ====== REKOMENDASI AI ====== -->
                        <div class="bg-slate-800/50 border border-indigo-500/30 rounded-2xl p-6 col-span-1 lg:col-span-2">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-indigo-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold" data-i18n="sec_ai_recs">Pengaturan Rekomendasi AI</h2>
                                    <p class="text-slate-400 text-sm" data-i18n="sec_ai_recs_sub">Konfigurasi mesin rekomendasi konten dan analitik berbasis AI</p>
                                </div>
                            </div>
                            <div class="border-t border-slate-700 mt-4 pt-6 space-y-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="ai_auto_rec_label">Aktifkan Rekomendasi Konten Otomatis</p>
                                        <p class="text-xs text-slate-400" data-i18n="ai_auto_rec_desc">Sistem akan merekomendasikan artikel dan tips sesuai kondisi stress mahasiswa</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="ai_auto_recommend" id="ai_auto_recommend" class="hidden toggle-checkbox" {{ ($systemSettings['ai_auto_recommend'] ?? '1') == '1' ? 'checked' : '' }}>
                                        <label for="ai_auto_recommend" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="ai_distress_priority_label">Prioritaskan Konten untuk Mahasiswa Distress</p>
                                        <p class="text-xs text-slate-400" data-i18n="ai_distress_priority_desc">Mahasiswa dengan kondisi Distress akan mendapat rekomendasi konten pemulihan lebih intensif</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="ai_prioritize_distress" id="ai_prioritize_distress" class="hidden toggle-checkbox" {{ ($systemSettings['ai_prioritize_distress'] ?? '1') == '1' ? 'checked' : '' }}>
                                        <label for="ai_prioritize_distress" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-slate-300 text-sm font-medium mb-2" data-i18n="lbl_analysis_freq">Frekuensi Analisis Data</label>
                                    <p class="text-xs text-slate-500 mb-3" data-i18n="hint_analysis_freq">Seberapa sering sistem melakukan analisis data kesehatan mental secara menyeluruh</p>
                                    <select name="ai_analysis_frequency" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-indigo-500 text-white md:w-1/2">
                                        <option value="daily" {{ ($systemSettings['ai_analysis_frequency'] ?? 'daily') == 'daily' ? 'selected' : '' }} data-i18n="opt_daily">Harian</option>
                                        <option value="weekly" {{ ($systemSettings['ai_analysis_frequency'] ?? 'daily') == 'weekly' ? 'selected' : '' }} data-i18n="opt_weekly">Mingguan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ====== WELLBEING KAMPUS ====== -->
                        <div class="bg-slate-800/50 border border-purple-500/30 rounded-2xl p-6">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold" data-i18n="sec_wellbeing">Konfigurasi Wellbeing Kampus</h2>
                                    <p class="text-slate-400 text-sm" data-i18n="sec_wellbeing_sub">Ambang batas dan peringatan untuk tim kesehatan kampus</p>
                                </div>
                            </div>
                            <div class="border-t border-slate-700 mt-4 pt-6 space-y-4">
                                <div>
                                    <label class="block text-slate-300 text-sm font-medium mb-2" data-i18n="lbl_distress_alert">Jumlah Mahasiswa Distress untuk Alert Admin</label>
                                    <p class="text-xs text-slate-500 mb-3" data-i18n="hint_distress_alert">Admin akan mendapat peringatan otomatis jika jumlah mahasiswa Distress mencapai atau melebihi angka ini</p>
                                    <input type="number" name="distress_alert_count" min="1" value="{{ $systemSettings['distress_alert_count'] ?? 10 }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg focus:outline-none focus:border-purple-500 text-white">
                                </div>
                                <div class="bg-purple-500/10 border border-purple-500/20 rounded-lg p-3">
                                    <p class="text-xs text-purple-300"><span class="font-semibold" data-i18n="note_label">Catatan:</span> <span data-i18n="wellbeing_note">Peringatan dikirimkan melalui notifikasi dashboard dan email admin jika fitur notifikasi email aktif.</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- ====== PRIVASI DATA ====== -->
                        <div class="bg-slate-800/50 border border-emerald-500/30 rounded-2xl p-6">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold" data-i18n="sec_privacy">Privasi Data Mahasiswa</h2>
                                    <p class="text-slate-400 text-sm" data-i18n="sec_privacy_sub">Pengelolaan etika dan privasi data kesehatan mental</p>
                                </div>
                            </div>
                            <div class="border-t border-slate-700 mt-4 pt-6 space-y-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="privacy_anon_label">Anonimisasi Data Mahasiswa</p>
                                        <p class="text-xs text-slate-400" data-i18n="privacy_anon_desc">Data identitas mahasiswa di laporan analitik akan diganti dengan ID anonim</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="privacy_anonymize" id="privacy_anonymize" class="hidden toggle-checkbox" {{ ($systemSettings['privacy_anonymize'] ?? '0') == '1' ? 'checked' : '' }}>
                                        <label for="privacy_anonymize" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="privacy_stats_label">Izinkan Analisis Statistik Anonim</p>
                                        <p class="text-xs text-slate-400" data-i18n="privacy_stats_desc">Data agregat anonim dapat digunakan untuk laporan statistik universitas</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="privacy_allow_stats" id="privacy_allow_stats" class="hidden toggle-checkbox" {{ ($systemSettings['privacy_allow_stats'] ?? '1') == '1' ? 'checked' : '' }}>
                                        <label for="privacy_allow_stats" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium" data-i18n="privacy_restrict_label">Batasi Akses Data Sensitif</p>
                                        <p class="text-xs text-slate-400" data-i18n="privacy_restrict_desc">Hanya admin dengan izin khusus yang dapat mengakses detail data kesehatan mental individu</p>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="privacy_restrict_sensitive" id="privacy_restrict_sensitive" class="hidden toggle-checkbox" {{ ($systemSettings['privacy_restrict_sensitive'] ?? '1') == '1' ? 'checked' : '' }}>
                                        <label for="privacy_restrict_sensitive" class="toggle-label"></label>
                                    </div>
                                </div>
                                <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-lg p-3">
                                    <p class="text-xs text-emerald-300"><span class="font-semibold" data-i18n="privacy_commitment_label">Komitmen Privasi:</span> <span data-i18n="privacy_commitment_text">Platform ini berkomitmen menjaga kerahasiaan data kesehatan mental mahasiswa sesuai prinsip etika psikologi dan regulasi perlindungan data.</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Save All Button -->
                        <div class="col-span-1 lg:col-span-2 flex justify-end mt-8">
                            <button type="submit" class="px-8 py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg transition flex items-center gap-2 shadow-lg shadow-teal-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                <span data-i18n="btn_save_all">Simpan Semua Pengaturan</span>
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


    <script>
        // ===== SETTINGS PAGE i18n =====
        const i18nSettings = {
            id: {
                page_title: 'Pengaturan Sistem',
                page_subtitle: 'Kelola pengaturan umum sistem',
                sec_admin_profile: 'Profil Admin',
                sec_admin_profile_sub: 'Kelola informasi akun administrator',
                lbl_name: 'Nama',
                lbl_email: 'Email',
                lbl_phone: 'No. Telepon',
                btn_save_profile: 'Simpan Profil',
                sec_notifications: 'Notifikasi',
                sec_notifications_sub: 'Atur preferensi notifikasi',
                notif_email_label: 'Notifikasi Email',
                notif_email_desc: 'Terima notifikasi via email',
                notif_reminder_label: 'Pengingat Assessment',
                notif_reminder_desc: 'Kirim pengingat ke mahasiswa',
                notif_report_label: 'Laporan Mingguan',
                notif_report_desc: 'Terima ringkasan mingguan',
                sec_security: 'Keamanan',
                sec_security_sub: 'Pengaturan keamanan sistem',
                lbl_min_password: 'Minimal Panjang Password',
                lbl_session_timeout: 'Session Timeout (menit)',
                lbl_max_login: 'Max Login Attempts',
                sec_system: 'Sistem',
                sec_system_sub: 'Pengaturan sistem dan database',
                sys_backup_label: 'Auto Backup',
                sys_backup_desc: 'Backup otomatis harian',
                sys_maintenance_label: 'Mode Maintenance',
                sys_maintenance_desc: 'Nonaktifkan akses mahasiswa',
                btn_manual_backup: 'Backup Manual',
                sec_mh_monitoring: 'Pengaturan Monitoring Kesehatan Mental',
                sec_mh_monitoring_sub: 'Konfigurasi sistem pemantauan kondisi stress mahasiswa',
                lbl_assessment_interval: 'Interval Pengingat Assessment',
                hint_assessment_interval: 'Seberapa sering mahasiswa akan diingatkan untuk melakukan assessment stress',
                opt_7days: '7 Hari (Mingguan)',
                opt_14days: '14 Hari (Dua Mingguan)',
                opt_30days: '30 Hari (Bulanan)',
                lbl_distress_threshold: 'Ambang Batas Distress Alert (Skor 0–100)',
                hint_distress_threshold: 'Skor stress di atas angka ini akan diklasifikasikan sebagai kondisi Distress (Risiko Tinggi)',
                sec_ai_recs: 'Pengaturan Rekomendasi AI',
                sec_ai_recs_sub: 'Konfigurasi mesin rekomendasi konten dan analitik berbasis AI',
                ai_auto_rec_label: 'Aktifkan Rekomendasi Konten Otomatis',
                ai_auto_rec_desc: 'Sistem akan merekomendasikan artikel dan tips sesuai kondisi stress mahasiswa',
                ai_distress_priority_label: 'Prioritaskan Konten untuk Mahasiswa Distress',
                ai_distress_priority_desc: 'Mahasiswa dengan kondisi Distress akan mendapat rekomendasi konten pemulihan lebih intensif',
                lbl_analysis_freq: 'Frekuensi Analisis Data',
                hint_analysis_freq: 'Seberapa sering sistem melakukan analisis data kesehatan mental secara menyeluruh',
                opt_daily: 'Harian',
                opt_weekly: 'Mingguan',
                sec_wellbeing: 'Konfigurasi Wellbeing Kampus',
                sec_wellbeing_sub: 'Ambang batas dan peringatan untuk tim kesehatan kampus',
                lbl_distress_alert: 'Jumlah Mahasiswa Distress untuk Alert Admin',
                hint_distress_alert: 'Admin akan mendapat peringatan otomatis jika jumlah mahasiswa Distress mencapai atau melebihi angka ini',
                note_label: 'Catatan:',
                wellbeing_note: 'Peringatan dikirimkan melalui notifikasi dashboard dan email admin jika fitur notifikasi email aktif.',
                sec_privacy: 'Privasi Data Mahasiswa',
                sec_privacy_sub: 'Pengelolaan etika dan privasi data kesehatan mental',
                privacy_anon_label: 'Anonimisasi Data Mahasiswa',
                privacy_anon_desc: 'Data identitas mahasiswa di laporan analitik akan diganti dengan ID anonim',
                privacy_stats_label: 'Izinkan Analisis Statistik Anonim',
                privacy_stats_desc: 'Data agregat anonim dapat digunakan untuk laporan statistik universitas',
                privacy_restrict_label: 'Batasi Akses Data Sensitif',
                privacy_restrict_desc: 'Hanya admin dengan izin khusus yang dapat mengakses detail data kesehatan mental individu',
                privacy_commitment_label: 'Komitmen Privasi:',
                privacy_commitment_text: 'Platform ini berkomitmen menjaga kerahasiaan data kesehatan mental mahasiswa sesuai prinsip etika psikologi dan regulasi perlindungan data.',
                btn_save_all: 'Simpan Semua Pengaturan'
            },
            en: {
                page_title: 'System Settings',
                page_subtitle: 'Manage general system configuration',
                sec_admin_profile: 'Admin Profile',
                sec_admin_profile_sub: 'Manage administrator account information',
                lbl_name: 'Name',
                lbl_email: 'Email',
                lbl_phone: 'Phone Number',
                btn_save_profile: 'Save Profile',
                sec_notifications: 'Notifications',
                sec_notifications_sub: 'Set notification preferences',
                notif_email_label: 'Email Notifications',
                notif_email_desc: 'Receive notifications via email',
                notif_reminder_label: 'Assessment Reminders',
                notif_reminder_desc: 'Send reminders to students',
                notif_report_label: 'Weekly Reports',
                notif_report_desc: 'Receive weekly summaries',
                sec_security: 'Security',
                sec_security_sub: 'System security settings',
                lbl_min_password: 'Minimum Password Length',
                lbl_session_timeout: 'Session Timeout (minutes)',
                lbl_max_login: 'Max Login Attempts',
                sec_system: 'System',
                sec_system_sub: 'System and database settings',
                sys_backup_label: 'Auto Backup',
                sys_backup_desc: 'Daily automatic backup',
                sys_maintenance_label: 'Maintenance Mode',
                sys_maintenance_desc: 'Disable student access',
                btn_manual_backup: 'Manual Backup',
                sec_mh_monitoring: 'Mental Health Monitoring Settings',
                sec_mh_monitoring_sub: 'Configure student stress condition monitoring system',
                lbl_assessment_interval: 'Assessment Reminder Interval',
                hint_assessment_interval: 'How often students will be reminded to perform stress assessments',
                opt_7days: '7 Days (Weekly)',
                opt_14days: '14 Days (Bi-weekly)',
                opt_30days: '30 Days (Monthly)',
                lbl_distress_threshold: 'Distress Alert Threshold (Score 0–100)',
                hint_distress_threshold: 'Stress scores above this value will be classified as Distress (High Risk) condition',
                sec_ai_recs: 'AI Recommendation Settings',
                sec_ai_recs_sub: 'Configure AI-based content recommendation and analytics engine',
                ai_auto_rec_label: 'Enable Automatic Content Recommendations',
                ai_auto_rec_desc: 'System will recommend articles and tips based on student stress condition',
                ai_distress_priority_label: 'Prioritize Content for Distress Students',
                ai_distress_priority_desc: 'Students with Distress condition will receive more intensive recovery content recommendations',
                lbl_analysis_freq: 'Data Analysis Frequency',
                hint_analysis_freq: 'How often the system performs comprehensive mental health data analysis',
                opt_daily: 'Daily',
                opt_weekly: 'Weekly',
                sec_wellbeing: 'Campus Wellbeing Configuration',
                sec_wellbeing_sub: 'Thresholds and alerts for campus health team',
                lbl_distress_alert: 'Distress Student Count for Admin Alert',
                hint_distress_alert: 'Admin will receive automatic warnings if the number of Distress students reaches or exceeds this number',
                note_label: 'Note:',
                wellbeing_note: 'Alerts are sent via dashboard notifications and admin email if email notification feature is enabled.',
                sec_privacy: 'Student Data Privacy',
                sec_privacy_sub: 'Ethics management and mental health data privacy',
                privacy_anon_label: 'Anonymize Student Data',
                privacy_anon_desc: 'Student identity data in analytics reports will be replaced with anonymous IDs',
                privacy_stats_label: 'Allow Anonymous Statistical Analysis',
                privacy_stats_desc: 'Anonymous aggregate data can be used for university statistical reports',
                privacy_restrict_label: 'Restrict Access to Sensitive Data',
                privacy_restrict_desc: 'Only admins with special permissions can access individual mental health data details',
                privacy_commitment_label: 'Privacy Commitment:',
                privacy_commitment_text: 'This platform is committed to maintaining the confidentiality of student mental health data in accordance with psychological ethics principles and data protection regulations.',
                btn_save_all: 'Save All Settings'
            }
        };

        function applySettingsI18n() {
            const lang = (localStorage.getItem('app_language') || 'id').toLowerCase();
            const t = i18nSettings[lang] || i18nSettings['id'];

            // Text elements with data-i18n
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key] !== undefined) el.textContent = t[key];
            });

            // Update document title
            document.title = t['page_title'] + ' - Insight Stress';
        }

        applySettingsI18n();

        window.addEventListener('storage', function(e) {
            if (e.key === 'app_language') applySettingsI18n();
        });
    </script>
</body>
</html>
