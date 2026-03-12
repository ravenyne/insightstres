<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik & Laporan - Insight Stress</title>
    @vite('resources/css/app.css')
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            background: #0f172a;
        }
    </style>
</head>
<body class="bg-slate-900 text-white">

    <div class="flex min-h-screen">
        
        <!-- Sidebar - FIXED -->
        @include('admin.partials.sidebar')

        {{-- Mobile Overlay --}}
        <div id="admin-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>
        
        <!-- Main Content - with margin for fixed sidebar -->
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
            
            <!-- Header (Desktop) -->
            <header class="hidden lg:block bg-slate-800/30 border-b border-slate-700 px-4 lg:px-8 py-4 lg:py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold" data-i18n="page_title">Analitik Kesehatan Mental</h1>
                        <p class="text-slate-400 mt-1 text-sm lg:text-base" data-i18n="page_subtitle">Analisis data stress mahasiswa</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.assessments.export.excel') }}" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-indigo-400 font-semibold rounded-lg transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            CSV
                        </a>
                        <button onclick="openPdfModal()" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-teal-400 font-semibold rounded-lg transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            PDF
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-4 lg:p-8 space-y-6">

                <!-- Mobile Action Buttons -->
                <div class="lg:hidden flex flex-col gap-3 mb-6">
                    <a href="{{ route('admin.assessments.export.excel') }}" class="w-full px-6 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-indigo-400 font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export CSV
                    </a>
                    <button onclick="openPdfModal()" class="w-full px-6 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-teal-400 font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </button>
                </div>

                <!-- AI Analytics Insight Panel -->
                <div class="bg-indigo-500/10 border border-indigo-500/30 rounded-2xl p-6 relative overflow-hidden">
                    <!-- Sparkle Background -->
                    <div class="absolute -right-4 -top-4 opacity-10">
                        <svg class="w-32 h-32 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L15 9L22 12L15 15L12 22L9 15L2 12L9 9L12 2Z"/>
                        </svg>
                    </div>
                    <div class="relative z-10 flex flex-col md:flex-row gap-6 items-start">
                        <div class="bg-indigo-500/20 p-4 rounded-xl flex-shrink-0">
                            <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-indigo-300 mb-2 flex items-center gap-2" data-i18n="ai_insight_title">
                                Insight Analitik Kesehatan Mental
                                <span class="bg-indigo-500 text-white text-[10px] uppercase font-bold px-2 py-0.5 rounded-full">AI Generated</span>
                            </h2>
                            <p class="text-slate-300 leading-relaxed mb-4" id="aiInsightText">
                                {!! $aiInsight !!}
                            </p>
                            @if(count($recommendations) > 0)
                                <div class="bg-slate-900/50 p-4 rounded-lg border border-slate-700/50">
                                    <h3 class="text-sm font-semibold text-white mb-2" data-i18n="recommendations_label">Rekomendasi Sistem:</h3>
                                    <ul class="text-sm text-slate-300 space-y-1" id="aiRecommendationsList">
                                        @foreach($recommendations as $rec)
                                            <li class="flex items-start gap-2">
                                                <span class="text-indigo-400 mt-0.5">•</span>
                                                <span>{{ $rec }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-5">
                    <form method="GET" action="{{ route('admin.assessments') }}" class="flex flex-col md:flex-row items-end gap-4">
                        <div class="w-full md:w-1/4">
                            <label class="block text-sm text-slate-400 mb-1" data-i18n="filter_semester">Filter Semester</label>
                            <select name="semester" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:border-indigo-500 text-sm">
                                <option value="" data-i18n="all_semesters">Semua Semester</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="w-full md:w-1/4">
                            <label class="block text-sm text-slate-400 mb-1" data-i18n="filter_major">Filter Jurusan</label>
                            <select name="jurusan" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:border-indigo-500 text-sm">
                                <option value="" data-i18n="all_majors">Semua Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-1/3">
                            <label class="block text-sm text-slate-400 mb-1" data-i18n="date_range_label">Rentang Waktu (YYYY-MM-DD - YYYY-MM-DD)</label>
                            <input type="text" name="date_range" value="{{ request('date_range') }}" data-i18n-placeholder="date_range_placeholder" placeholder="Contoh: 2026-01-01 - 2026-12-31" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-white focus:outline-none focus:border-indigo-500 text-sm">
                        </div>
                        <div class="w-full md:w-auto">
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition text-sm" data-i18n="apply_filter">Terapkan Filter</button>
                        </div>
                        @if(request()->hasAny(['semester', 'jurusan', 'date_range']))
                            <div class="w-full md:w-auto">
                                <a href="{{ route('admin.assessments') }}" class="w-full px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-lg transition text-sm inline-block text-center border border-slate-600" data-i18n="reset">Reset</a>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Rata-rata Stress -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <p class="text-slate-400 text-sm mb-2" data-i18n="stat_avg_stress">Rata-rata Stress</p>
                        <div class="flex items-end justify-between">
                            <p class="text-4xl font-bold">{{ $avgStressPercentage }}%</p>
                            <div class="flex items-center gap-1 text-green-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span>5%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Assessment Bulan Ini -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <p class="text-slate-400 text-sm mb-2" data-i18n="stat_monthly">Assessment Bulan Ini</p>
                        <div class="flex items-end justify-between">
                            <p class="text-4xl font-bold">{{ $monthlyAssessments }}</p>
                            <div class="flex items-center gap-1 text-green-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span>12%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Mahasiswa Aktif -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <p class="text-slate-400 text-sm mb-2" data-i18n="stat_active">Mahasiswa Aktif</p>
                        <div class="flex items-end justify-between">
                            <p class="text-4xl font-bold">{{ number_format($activeStudents) }}</p>
                            <div class="flex items-center gap-1 text-green-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span>8%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Mahasiswa Risiko Tinggi -->
                    <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-6 md:col-span-2 lg:col-span-1 flex flex-col justify-between">
                        <div>
                            <p class="text-red-400 text-sm font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span data-i18n="stat_high_stress">Stress Tinggi</span>
                            </p>
                            <div class="text-4xl font-bold text-red-500 mb-4">{{ $highStressCount }}</div>
                        </div>
                        <div>
                            @if(count($highRiskUsersList) > 0)
                                <p class="text-xs text-slate-400 mb-2 font-medium uppercase tracking-wider" data-i18n="needs_attention">Perlu Perhatian Segera:</p>
                                <div class="space-y-2">
                                    @foreach($highRiskUsersList as $user)
                                        <div class="flex items-center justify-between text-sm bg-slate-900/50 px-3 py-1.5 rounded-lg border border-red-500/20">
                                            <span class="text-white truncate max-w-[120px]" title="{{ $user->name }}">{{ $user->name }}</span>
                                            <span class="text-xs text-red-400 font-medium">Distress</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-sm text-slate-400 bg-slate-900/50 p-3 rounded-lg text-center border border-slate-700/50" data-i18n="stable_data">
                                    Mendapatkan data stabil. Belum ada mahasiswa dalam kategori distress.
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Tren Distribusi Stress Bulanan -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                    <h3 class="text-lg font-bold mb-6" data-i18n="chart_monthly_trend">Tren Distribusi Stress Bulanan</h3>
                    <div style="height: 400px;">
                        <canvas id="stressDistributionChart"></canvas>
                    </div>
                </div>

                <!-- Rata-rata Stress per Semester & Faktor Penyebab Stress -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Rata-rata Stress per Semester -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <h3 class="text-lg font-bold mb-6" data-i18n="chart_semester">Rata-rata Stress per Semester</h3>
                        <div style="height: 300px;">
                            <canvas id="semesterChart"></canvas>
                        </div>
                    </div>

                    <!-- Faktor Penyebab Stress -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <h3 class="text-lg font-bold mb-6" data-i18n="chart_factors">Faktor Penyebab Stress</h3>
                        <div class="flex items-center justify-center" style="height: 300px;">
                            <canvas id="factorChart"></canvas>
                        </div>
                    </div>

                </div>

                <!-- Analisis per Jurusan -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                    <h3 class="text-lg font-bold mb-6" data-i18n="analysis_by_major">Analisis per Jurusan</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700">
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_jurusan">Jurusan</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_jumlah">Jumlah Mahasiswa</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_avg_stress">Rata-rata Stress</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_visualisasi">Visualisasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jurusanStats as $stat)
                                    <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition">
                                        <td class="py-4 px-4 font-medium">{{ $stat['jurusan'] }}</td>
                                        <td class="py-4 px-4 text-slate-400">{{ $stat['count'] }}</td>
                                        <td class="py-4 px-4 text-slate-400">{{ $stat['avg_stress'] }}%</td>
                                        <td class="py-4 px-4">
                                            <div class="w-full bg-slate-700 rounded-full h-2">
                                                <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $stat['avg_stress'] }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Temuan Utama & Rekomendasi Kampus -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                    
                    <!-- Temuan Utama -->
                    <div class="bg-indigo-500/10 border border-indigo-500/30 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-indigo-300" data-i18n="key_findings_title">Temuan Utama (Berdasarkan Data)</h3>
                        </div>
                        <div class="space-y-4">
                            @forelse($keyFindings as $finding)
                                <div class="bg-slate-900/50 p-4 rounded-xl border border-slate-800/50 flex gap-4">
                                    <div class="text-indigo-500 font-black text-xl mt-[-2px]">{{ $loop->iteration }}</div>
                                    <p class="text-slate-300 text-sm leading-relaxed">{!! $finding !!}</p>
                                </div>
                            @empty
                                <div class="text-center text-slate-500 p-4" data-i18n="no_findings">Belum ada temuan dari data saat ini.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Rekomendasi Kampus -->
                    <div class="bg-teal-500/10 border border-teal-500/30 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-teal-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-teal-300" data-i18n="campus_recs_title">Rekomendasi Tindakan Kampus</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-slate-900/50 p-4 rounded-xl border border-slate-800/50">
                                <h4 class="text-teal-400 font-semibold text-sm mb-2" data-i18n="rec1_title">1. Intervensi Langsung</h4>
                                <p class="text-slate-400 text-sm leading-relaxed" data-i18n="rec1_body">Prioritaskan konseling atau survei mendalam untuk mahasiswa jurusan dengan rata-rata persentase stres tertinggi.</p>
                            </div>
                            <div class="bg-slate-900/50 p-4 rounded-xl border border-slate-800/50">
                                <h4 class="text-teal-400 font-semibold text-sm mb-2" data-i18n="rec2_title">2. Evaluasi Akademik</h4>
                                <p class="text-slate-400 text-sm leading-relaxed" data-i18n="rec2_body">Sistem mendeteksi bahwa semester/tahun tertentu rentan memiliki beban kerja yang memicu distres. Tinjau kembali kurikulum atau beban SKS pada semester tersebut.</p>
                            </div>
                            <div class="bg-slate-900/50 p-4 rounded-xl border border-slate-800/50">
                                <h4 class="text-teal-400 font-semibold text-sm mb-2" data-i18n="rec3_title">3. Program Pendukung</h4>
                                <p class="text-slate-400 text-sm leading-relaxed" data-i18n="rec3_body">Berdasarkan faktor dominan, rekomendasikan UKM/kegiatan kampus yang dapat mengakomodasi pelepasan stres spesifik tersebut (misal: olahraga rutin atau kelas manajemen waktu).</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </main>

    </div>

    <script>
        // ===== MULTI-LANGUAGE (i18n) SYSTEM =====
        const i18nAssessments = {
            id: {
                page_title: 'Analitik Kesehatan Mental',
                page_subtitle: 'Analisis data stress mahasiswa',
                ai_insight_title: 'Insight Analitik Kesehatan Mental',
                recommendations_label: 'Rekomendasi Sistem:',
                stat_avg_stress: 'Rata-rata Stress',
                stat_monthly: 'Assessment Bulan Ini',
                stat_active: 'Mahasiswa Aktif',
                stat_high_stress: 'Stress Tinggi',
                chart_monthly_trend: 'Tren Distribusi Stress Bulanan',
                chart_semester: 'Rata-rata Stress per Semester',
                chart_factors: 'Faktor Penyebab Stress',
                analysis_by_major: 'Analisis per Jurusan',
                col_jurusan: 'Jurusan',
                col_jumlah: 'Jumlah Mahasiswa',
                col_avg_stress: 'Rata-rata Stress',
                col_visualisasi: 'Visualisasi',
                filter_semester: 'Filter Semester',
                all_semesters: 'Semua Semester',
                filter_major: 'Filter Jurusan',
                all_majors: 'Semua Jurusan',
                date_range_label: 'Rentang Waktu (YYYY-MM-DD - YYYY-MM-DD)',
                date_range_placeholder: 'Contoh: 2026-01-01 - 2026-12-31',
                apply_filter: 'Terapkan Filter',
                reset: 'Reset',
                needs_attention: 'Perlu Perhatian Segera:',
                stable_data: 'Mendapatkan data stabil. Belum ada mahasiswa dalam kategori distress.',
                key_findings_title: 'Temuan Utama (Berdasarkan Data)',
                no_findings: 'Belum ada temuan dari data saat ini.',
                campus_recs_title: 'Rekomendasi Tindakan Kampus',
                rec1_title: '1. Intervensi Langsung',
                rec1_body: 'Prioritaskan konseling atau survei mendalam untuk mahasiswa jurusan dengan rata-rata persentase stres tertinggi.',
                rec2_title: '2. Evaluasi Akademik',
                rec2_body: 'Sistem mendeteksi bahwa semester/tahun tertentu rentan memiliki beban kerja yang memicu distres. Tinjau kembali kurikulum atau beban SKS pada semester tersebut.',
                rec3_title: '3. Program Pendukung',
                rec3_body: 'Berdasarkan faktor dominan, rekomendasikan UKM/kegiatan kampus yang dapat mengakomodasi pelepasan stres spesifik tersebut (misal: olahraga rutin atau kelas manajemen waktu).',
                ai_insight_message:
                    'Berdasarkan data assessment terbaru, sistem mendeteksi adanya pola peningkatan tingkat stres mahasiswa pada beberapa periode.\n\nPola ini sering muncul ketika mahasiswa menghadapi banyak deadline akademik dalam waktu yang berdekatan.',
                ai_recs: [
                    'Luangkan waktu istirahat di antara sesi belajar',
                    'Gunakan teknik pernapasan untuk membantu relaksasi',
                    'Pertimbangkan untuk mengatur ulang jadwal belajar'
                ]
            },
            en: {
                page_title: 'Mental Health Analytics',
                page_subtitle: 'Analysis of student stress data',
                ai_insight_title: 'Mental Health Analytics Insight',
                recommendations_label: 'System recommendations:',
                stat_avg_stress: 'Average Stress',
                stat_monthly: 'Assessments This Month',
                stat_active: 'Active Students',
                stat_high_stress: 'High Stress',
                chart_monthly_trend: 'Monthly Stress Distribution Trend',
                chart_semester: 'Average Stress per Semester',
                chart_factors: 'Stress Factors',
                analysis_by_major: 'Analysis by Major',
                col_jurusan: 'Major',
                col_jumlah: 'Number of Students',
                col_avg_stress: 'Average Stress',
                col_visualisasi: 'Visualization',
                filter_semester: 'Filter by Semester',
                all_semesters: 'All Semesters',
                filter_major: 'Filter by Major',
                all_majors: 'All Majors',
                date_range_label: 'Date Range (YYYY-MM-DD - YYYY-MM-DD)',
                date_range_placeholder: 'Example: 2026-01-01 - 2026-12-31',
                apply_filter: 'Apply Filter',
                reset: 'Reset',
                needs_attention: 'Needs Immediate Attention:',
                stable_data: 'Data is stable. No students are in the distress category.',
                key_findings_title: 'Key Findings (Based on Data)',
                no_findings: 'No findings from current data.',
                campus_recs_title: 'Campus Action Recommendations',
                rec1_title: '1. Direct Intervention',
                rec1_body: 'Prioritize counseling or in-depth surveys for students in majors with the highest average stress percentage.',
                rec2_title: '2. Academic Evaluation',
                rec2_body: 'The system detected that certain semesters/years are prone to workloads that trigger distress. Review the curriculum or credit load for those semesters.',
                rec3_title: '3. Support Programs',
                rec3_body: 'Based on dominant factors, recommend campus clubs/activities that can accommodate specific stress relief (e.g., regular exercise or time management classes).',
                ai_insight_message:
                    'Based on recent assessment data, the system detected an increasing trend in student stress levels during certain periods.\n\nThis pattern often occurs when students face multiple academic deadlines within a short time.',
                ai_recs: [
                    'Take short breaks between study sessions',
                    'Use breathing techniques to help relaxation',
                    'Consider reorganizing your study schedule'
                ]
            }
        };

        function applyAssessmentsI18n() {
            const lang = (localStorage.getItem('app_language') || 'id').toLowerCase();
            const t = i18nAssessments[lang] || i18nAssessments['id'];

            // Text elements
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key] !== undefined) el.textContent = t[key];
            });

            // Placeholder elements
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (t[key] !== undefined) el.placeholder = t[key];
            });

            // AI insight message
            const aiTextEl = document.getElementById('aiInsightText');
            if (aiTextEl) {
                aiTextEl.innerHTML = t.ai_insight_message.replace(/\n/g, '<br>');
            }

            // AI recommendations list
            const recsList = document.getElementById('aiRecommendationsList');
            if (recsList) {
                recsList.innerHTML = t.ai_recs.map(rec =>
                    `<li class="flex items-start gap-2"><span class="text-indigo-400 mt-0.5">•</span><span>${rec}</span></li>`
                ).join('');
            }
        }

        applyAssessmentsI18n();

        // React to language changes from other tabs / pages
        window.addEventListener('storage', function(e) {
            if (e.key === 'app_language') applyAssessmentsI18n();
        });
    </script>

    <script>
        const distributionCtx = document.getElementById('stressDistributionChart').getContext('2d');
        new Chart(distributionCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($monthlyDistribution, 'month')) !!},
                datasets: [
                    {
                        label: 'No Stress',
                        data: {!! json_encode(array_column($monthlyDistribution, 'no_stress')) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.6)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Eustress',
                        data: {!! json_encode(array_column($monthlyDistribution, 'eustress')) !!},
                        backgroundColor: 'rgba(249, 115, 22, 0.6)',
                        borderColor: 'rgba(249, 115, 22, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Distress',
                        data: {!! json_encode(array_column($monthlyDistribution, 'distress')) !!},
                        backgroundColor: 'rgba(239, 68, 68, 0.6)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#94a3b8',
                            usePointStyle: true,
                            padding: 15
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 12
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    }
                }
            }
        });

        // Rata-rata Stress per Semester (Bar Chart)
        const semesterCtx = document.getElementById('semesterChart').getContext('2d');
        new Chart(semesterCtx, {
            type: 'bar',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7', '8'],
                datasets: [{
                    label: 'Rata-rata Stress',
                    data: {!! json_encode($semesterData) !!},
                    backgroundColor: '#f97316',
                    borderRadius: 8,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return 'Stress: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    }
                }
            }
        });

        // Faktor Penyebab Stress (Pie Chart)
        const factorCtx = document.getElementById('factorChart').getContext('2d');
        new Chart(factorCtx, {
            type: 'doughnut',
            data: {
                labels: ['Akademik', 'Fisik & Kesehatan', 'Emosional', 'Sosial', 'Lingkungan'],
                datasets: [{
                    data: {!! json_encode($factorData) !!},
                    backgroundColor: [
                        '#ef4444',
                        '#f97316',
                        '#3b82f6',
                        '#10b981',
                        '#8b5cf6'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#94a3b8',
                            usePointStyle: true,
                            padding: 15
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.parsed / total) * 100);
                                return context.label + ': ' + percentage + '%';
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    </script>

    <!-- Modal PDF Preview -->
    <div id="pdfModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-3xl w-full shadow-2xl max-h-[90vh] overflow-hidden flex flex-col">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Export Laporan Statistik</h3>
                        <p class="text-sm text-slate-500">Preview dokumen PDF laporan statistik stress mahasiswa sebelum mengunduh.</p>
                    </div>
                </div>
                <button onclick="closePdfModal()" class="p-2 hover:bg-slate-100 rounded-lg transition">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body - Preview -->
            <div class="flex-1 overflow-y-auto p-8 bg-slate-50">
                <div class="bg-white border-2 border-dashed border-slate-300 rounded-xl p-8">
                    
                    <div class="text-center mb-6 pb-6 border-b border-slate-200">
                        <p class="text-xs text-teal-600 font-semibold mb-2">PREVIEW DOKUMEN</p>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">LAPORAN STATISTIK STRESS MAHASISWA</h2>
                        <p class="text-sm text-slate-600">Insight Stress Mahasiswa - {{ now()->format('F Y') }}</p>
                    </div>

                    <!-- Ringkasan Statistik -->
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-slate-900">Ringkasan Statistik</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-600 mb-1">Rata-rata Stress</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $avgStressPercentage }}%</p>
                                <p class="text-xs text-red-600 mt-1">-5% dari bulan lalu</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-600 mb-1">Assessment Bulan Ini</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $monthlyAssessments }}</p>
                                <p class="text-xs text-teal-600 mt-1">+12% dari bulan lalu</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-600 mb-1">Mahasiswa Aktif</p>
                                <p class="text-2xl font-bold text-slate-900">{{ number_format($activeStudents) }}</p>
                                <p class="text-xs text-teal-600 mt-1">+8% dari bulan lalu</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-600 mb-1">Stress Tinggi</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $highStressCount }}</p>
                                <p class="text-xs text-slate-600 mt-1">Tidak ada perubahan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Faktor Penyebab Stress -->
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-slate-900">Faktor Penyebab Stress</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <span class="text-slate-700">Akademik</span>
                                </div>
                                <span class="font-semibold text-slate-900">35%</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                                    <span class="text-slate-700">Fisik & Kesehatan</span>
                                </div>
                                <span class="font-semibold text-slate-900">25%</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-slate-700">Emosional</span>
                                </div>
                                <span class="font-semibold text-slate-900">20%</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="text-slate-700">Sosial</span>
                                </div>
                                <span class="font-semibold text-slate-900">12%</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                    <span class="text-slate-700">Lingkungan</span>
                                </div>
                                <span class="font-semibold text-slate-900">8%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Analisis per Jurusan -->
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-slate-900">Analisis per Jurusan</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach($jurusanStats->take(4) as $stat)
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-medium text-slate-900">{{ $stat['jurusan'] }}</span>
                                            <span class="text-slate-600">{{ $stat['count'] }} mahasiswa - {{ $stat['avg_stress'] }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2">
                                            <div class="bg-teal-500 h-2 rounded-full" style="width: {{ $stat['avg_stress'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Rata-rata Stress per Semester -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <h3 class="text-lg font-bold text-slate-900">Rata-rata Stress per Semester</h3>
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            @for($i = 0; $i < 8; $i++)
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 text-center">
                                    <p class="text-xs text-slate-600 mb-1">Sem {{ $i + 1 }}</p>
                                    <p class="text-lg font-bold text-slate-900">{{ $semesterData[$i] }}%</p>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 pt-4 border-t border-slate-200 text-center">
                        <p class="text-xs text-slate-500">Diekspor pada: {{ now()->format('l, d F Y') }} pukul {{ now()->format('H:i') }}</p>
                    </div>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-slate-200 bg-white">
                <button onclick="closePdfModal()" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg transition">
                    Batal
                </button>
                <a href="{{ route('admin.assessments.export.pdf') }}" class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Unduh PDF
                </a>
            </div>

        </div>
    </div>

    <script>
        function openPdfModal() {
            document.getElementById('pdfModal').classList.remove('hidden');
        }

        function closePdfModal() {
            document.getElementById('pdfModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('pdfModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePdfModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePdfModal();
            }
        });
    </script>


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
