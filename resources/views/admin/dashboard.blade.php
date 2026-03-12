<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="page_title">Dashboard Admin - Insight Stress</title>
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

        <!-- Main Content - with margin for fixed sidebar -->
        <main class="flex-1 overflow-y-auto ml-64">
            
            <!-- Header -->
            <header class="bg-slate-800/30 border-b border-slate-700 px-8 py-6">
                <h1 class="text-3xl font-bold" data-i18n="header_title">Dashboard Admin</h1>
                <p class="text-slate-400 mt-1" data-i18n="header_subtitle">Selamat datang di panel administrasi</p>
            </header>

            <!-- Content -->
            <div class="p-8 space-y-6">

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Total Mahasiswa -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-slate-400 text-sm" data-i18n="stat_total_students">Total Mahasiswa</p>
                                <p class="text-3xl font-bold mt-1">{{ number_format($totalUsers) }}</p>
                            </div>
                            <div class="w-14 h-14 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                                <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Assessment -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-slate-400 text-sm" data-i18n="stat_total_assessments">Total Assessment</p>
                                <p class="text-3xl font-bold mt-1">{{ number_format($totalAssessments) }}</p>
                            </div>
                            <div class="w-14 h-14 rounded-xl bg-teal-500/20 flex items-center justify-center">
                                <svg class="w-7 h-7 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Rata-rata Skor Stress -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-slate-400 text-sm" data-i18n="stat_avg_score">Rata-rata Skor Stress</p>
                                <p class="text-3xl font-bold mt-1">{{ $avgScorePercentage }}%</p>
                            </div>
                            <div class="w-14 h-14 rounded-xl bg-blue-500/20 flex items-center justify-center">
                                <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Indikator Risiko Dini -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-400 text-sm font-medium whitespace-nowrap" data-i18n="stat_risk_indicator">Indikator Risiko Dini</p>
                                @if($highStressCount > 0)
                                    <p class="text-3xl font-bold mt-1 text-red-500">{{ $highStressCount }}</p>
                                    <p class="text-xs text-slate-500 mt-1" data-i18n="stat_at_risk_students">Mahasiswa berisiko</p>
                                @else
                                    <p class="text-3xl font-bold mt-1 text-green-500">0</p>
                                    <p class="text-xs text-slate-500 mt-1" data-i18n="stat_at_risk_students">Mahasiswa berisiko</p>
                                @endif
                            </div>
                            <div class="w-14 h-14 rounded-xl {{ $highStressCount > 0 ? 'bg-red-500/20' : 'bg-slate-700/50' }} flex flex-shrink-0 items-center justify-center">
                                <svg class="w-7 h-7 {{ $highStressCount > 0 ? 'text-red-500' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Tren Stress Bulanan -->
                    <div class="lg:col-span-2 bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <h3 class="text-lg font-bold mb-6" data-i18n="chart_monthly_trend">Tren Stress Bulanan</h3>
                        <div style="height: 300px;">
                            <canvas id="monthlyTrendChart"></canvas>
                        </div>
                    </div>

                    <!-- Distribusi Stress -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <h3 class="text-lg font-bold mb-6" data-i18n="chart_distribution">Distribusi Stress</h3>
                        <div class="flex items-center justify-center">
                            <canvas id="stressDistributionChart" width="200" height="200"></canvas>
                        </div>
                        <div class="mt-6 space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="text-slate-400" data-i18n="stress_no_stress">Tidak Stres</span>
                                </div>
                                <span class="font-medium">{{ $stressDistribution['low'] }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <span class="text-slate-400" data-i18n="stress_eustress">Eustress</span>
                                </div>
                                <span class="font-medium">{{ $stressDistribution['medium'] }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <span class="text-slate-400" data-i18n="stress_distress">Distress</span>
                                </div>
                                <span class="font-medium">{{ $stressDistribution['high'] }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- AI INSIGHT PANEL -->
                <div class="bg-indigo-900/30 border border-indigo-500/30 rounded-2xl p-6 relative overflow-hidden">
                    <!-- Decorative background element -->
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex flex-shrink-0 items-center justify-center mt-1">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-indigo-300 mb-2" data-i18n="ai_insight_title">Insight Kesehatan Mental (AI)</h3>
                            <div class="text-slate-300 leading-relaxed text-sm">
                                {!! $aiInsightMessage ?? '<span data-i18n="ai_insight_loading">Sistem sedang mengumpulkan lebih banyak data untuk menghasilkan insight.</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assessment Terbaru -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                    <h3 class="text-lg font-bold mb-6" data-i18n="table_recent_title">Assessment Terbaru</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700">
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_name">Nama</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_nim">NIM</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_stress_category">Kategori Stress</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_date">Tanggal</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_time">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAssessments as $assessment)
                                    <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition">
                                        <td class="py-4 px-4">{{ $assessment->user->name ?? 'N/A' }}</td>
                                        <td class="py-4 px-4 text-slate-400">{{ $assessment->user->nim ?? 'N/A' }}</td>
                                        <td class="py-4 px-4">
                                            @php
                                                $score = $assessment->numeric_score ?? 0;
                                                $category = match((int)$score) {
                                                    0 => ['key' => 'cat_no_stress', 'text' => 'No Stress', 'class' => 'bg-green-500/20 text-green-400'],
                                                    1 => ['key' => 'cat_eustress', 'text' => 'Eustress', 'class' => 'bg-orange-500/20 text-orange-400'],
                                                    2 => ['key' => 'cat_distress', 'text' => 'Distress', 'class' => 'bg-red-500/20 text-red-400'],
                                                    default => ['key' => 'cat_unknown', 'text' => 'Unknown', 'class' => 'bg-gray-500/20 text-gray-400']
                                                };
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $category['class'] }}" data-i18n="{{ $category['key'] }}">
                                                {{ $category['text'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-slate-400">{{ $assessment->created_at->format('Y-m-d') }}</td>
                                        <td class="py-4 px-4 text-slate-400">{{ $assessment->created_at->format('H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-4 border border-slate-700">
                                                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <h4 class="text-lg font-medium text-white mb-2" data-i18n="empty_title">Belum Ada Data Assessment</h4>
                                                <p class="text-slate-400 max-w-sm mx-auto text-sm leading-relaxed" data-i18n="empty_desc">
                                                    Data assessment akan muncul setelah mahasiswa mulai melakukan penilaian tingkat stres mereka.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>

    </div>

    <script>
        // ====================================================
        // TRANSLATION DICTIONARY
        // ====================================================
        const i18n = {
            id: {
                page_title:             'Dashboard Admin - Insight Stress',
                header_title:           'Dashboard Admin',
                header_subtitle:        'Selamat datang di panel administrasi Insight Stress',
                stat_total_students:    'Total Mahasiswa',
                stat_total_assessments: 'Total Assessment',
                stat_avg_score:         'Rata-rata Skor Stress',
                stat_risk_indicator:    'Indikator Risiko Dini',
                stat_at_risk_students:  'Mahasiswa berisiko',
                chart_monthly_trend:    'Tren Stress Bulanan',
                chart_distribution:     'Distribusi Stress',
                stress_no_stress:       'Tidak Stres',
                stress_eustress:        'Eustress',
                stress_distress:        'Distress',
                ai_insight_title:       'Insight Kesehatan Mental (AI)',
                ai_insight_loading:     'Sistem sedang mengumpulkan lebih banyak data untuk menghasilkan insight.',
                table_recent_title:     'Assessment Terbaru',
                col_name:               'Nama',
                col_nim:                'NIM',
                col_stress_category:    'Kategori Stress',
                col_date:               'Tanggal',
                col_time:               'Waktu',
                cat_no_stress:          'No Stress',
                cat_eustress:           'Eustress',
                cat_distress:           'Distress',
                cat_unknown:            'Tidak Diketahui',
                empty_title:            'Belum Ada Data Assessment',
                empty_desc:             'Data assessment akan muncul setelah mahasiswa mulai melakukan penilaian tingkat stres mereka.',
                chart_label_count:      'Jumlah Assessment',
                donut_labels:           ['Tidak Stres', 'Eustress', 'Distress'],
            },
            en: {
                page_title:             'Admin Dashboard - Insight Stress',
                header_title:           'Admin Dashboard',
                header_subtitle:        'Welcome to the Insight Stress administration panel',
                stat_total_students:    'Total Students',
                stat_total_assessments: 'Total Assessments',
                stat_avg_score:         'Average Stress Score',
                stat_risk_indicator:    'Early Risk Indicator',
                stat_at_risk_students:  'At-risk students',
                chart_monthly_trend:    'Monthly Stress Trend',
                chart_distribution:     'Stress Distribution',
                stress_no_stress:       'No Stress',
                stress_eustress:        'Eustress',
                stress_distress:        'Distress',
                ai_insight_title:       'Mental Health Insight (AI)',
                ai_insight_loading:     'The system is collecting more data to generate insights.',
                table_recent_title:     'Latest Assessments',
                col_name:               'Name',
                col_nim:                'Student ID',
                col_stress_category:    'Stress Category',
                col_date:               'Date',
                col_time:               'Time',
                cat_no_stress:          'No Stress',
                cat_eustress:           'Eustress',
                cat_distress:           'Distress',
                cat_unknown:            'Unknown',
                empty_title:            'No Assessment Data Yet',
                empty_desc:             'Assessment data will appear after students begin evaluating their stress levels.',
                chart_label_count:      'Assessment Count',
                donut_labels:           ['No Stress', 'Eustress', 'Distress'],
            }
        };

        // ====================================================
        // DETECT LANGUAGE
        // Priority: Laravel session locale (server-side, authoritative)
        //   → then sync to localStorage for cross-page consistency
        // ====================================================
        function getActiveLocale() {
            // The server-side locale is the source of truth (set by sidebar switcher)
            const htmlLang = document.documentElement.lang;
            const serverLocale = (htmlLang === 'en') ? 'en' : 'id';

            // Sync to localStorage so user-side pages (splash/dashboard) also know
            localStorage.setItem('app_language', serverLocale);

            return serverLocale;
        }

        // ====================================================
        // APPLY TRANSLATIONS
        // ====================================================
        function applyTranslations(locale) {
            const t = i18n[locale] || i18n.id;
            document.documentElement.lang = locale;
            document.title = t.page_title;

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key] !== undefined) {
                    el.textContent = t[key];
                }
            });

            // Sync localStorage so sidebar and other pages are consistent
            localStorage.setItem('app_language', locale);
        }

        // ====================================================
        // APPLY ON PAGE LOAD
        // ====================================================
        const currentLocale = getActiveLocale();
        applyTranslations(currentLocale);

        // ====================================================
        // CHARTS — built after locale is resolved
        // ====================================================
        const t = i18n[currentLocale] || i18n.id;

        // Monthly Trend Chart
        const monthlyTrendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
        const gradient = monthlyTrendCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(20, 184, 166, 0.3)');
        gradient.addColorStop(0.5, 'rgba(20, 184, 166, 0.15)');
        gradient.addColorStop(1, 'rgba(20, 184, 166, 0)');
        
        new Chart(monthlyTrendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($monthlyTrend, 'month')) !!},
                datasets: [{
                    label: t.chart_label_count,
                    data: {!! json_encode(array_column($monthlyTrend, 'count')) !!},
                    borderColor: '#14b8a6',
                    backgroundColor: gradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#14b8a6',
                    pointBorderColor: '#1e293b',
                    pointBorderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            title: ctx => ctx[0].label,
                            label: ctx => ctx.parsed.y + ' ' + t.chart_label_count,
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 100,
                        grid: { color: 'rgba(148, 163, 184, 0.05)', drawBorder: false },
                        ticks: { color: '#64748b', font: { size: 11 }, padding: 8, stepSize: 20 }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#64748b', font: { size: 11 }, padding: 8 }
                    }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });

        // Stress Distribution Donut Chart
        const distributionCtx = document.getElementById('stressDistributionChart').getContext('2d');
        new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: t.donut_labels,
                datasets: [{
                    data: [
                        {{ $stressDistribution['low'] }},
                        {{ $stressDistribution['medium'] }},
                        {{ $stressDistribution['high'] }}
                    ],
                    backgroundColor: ['#22C55E', '#F59E0B', '#EF4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                cutout: '70%'
            }
        });
    </script>

</body>
</html>
