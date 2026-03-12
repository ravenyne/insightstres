@extends('layouts.dashboard')

@section('content')
<script src="https://unpkg.com/lucide@latest"></script>

<div class="space-y-8 animate-fade-in">

    {{-- Header dengan Greeting Personal --}}
    @php
        // Timezone Makassar (WITA - UTC+8)
        date_default_timezone_set('Asia/Makassar');
        $hour = date('H');
        $greeting = __('Selamat Malam');
        if ($hour >= 5 && $hour < 11) {
            $greeting = __('Selamat Pagi');
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = __('Selamat Siang');
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = __('Selamat Sore');
        }

        $userName = auth()->user()->name;
        $carbonLocale = app()->getLocale() === 'en' ? 'en' : 'id';
        $currentDate = \Carbon\Carbon::now()->locale($carbonLocale)->translatedFormat('l, d F Y');
        $currentTime = date('H:i');
    @endphp

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $greeting }}, {{ $userName }}!
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">{{ __('Bagaimana perasaan Anda hari ini?') }}</p>
        </div>
        
        <div class="text-right">
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $currentDate }}</p>
            <p id="live-clock" class="text-2xl font-bold text-teal-600 dark:text-teal-400">{{ $currentTime }}</p>
        </div>
    </div>

    {{-- CTA Mulai Penilaian --}}
    <div class="mt-8 rounded-2xl bg-gradient-to-r from-teal-500 to-cyan-500 p-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl text-white font-semibold">{{ __('Mulai Penilaian Baru') }}</h2>
                <p class="text-white/80">{{ __('Lacak kesehatan mental Anda secara berkala.') }}</p>
            </div>

            <a href="{{ route('user.assessment') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium flex items-center gap-2">
                {{ __('Mulai Sekarang') }}
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-8">

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow">
            <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-400 rounded-xl flex items-center justify-center mb-3">
                <i data-lucide="clipboard-list" class="w-6 h-6"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Total Penilaian') }}</p>
            <p class="text-2xl font-bold dark:text-white">{{ $stats['total'] ?? 0 }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-3">
                <i data-lucide="activity" class="w-6 h-6"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Tingkat Stres Terakhir') }}</p>
            <p class="text-xl font-bold dark:text-white
                @if($stats['last_label'] === 'No Stress') text-green-600
                @elseif($stats['last_label'] === 'Eustress') text-blue-600
                @elseif($stats['last_label'] === 'Distress') text-red-600
                @endif">
                {{ $stats['last_label'] }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center mb-3">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Penilaian Bulan Ini') }}</p>
            <p class="text-2xl font-bold dark:text-white">{{ $stats['this_month'] ?? 0 }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow">
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 rounded-xl flex items-center justify-center mb-3">
                <i data-lucide="trending-up" class="w-6 h-6"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Trend Tingkat Stres') }}</p>
            <div class="flex items-center gap-2 mt-1">
                <p class="text-2xl font-bold dark:text-white
                    @if($stats['trend'] === 'Membaik') text-green-600
                    @elseif($stats['trend'] === 'Meningkat') text-red-600
                    @elseif($stats['trend'] === 'Stabil') text-blue-600
                    @endif">
                    {{ __($stats['trend']) }}
                </p>
                @if($stats['trend'] === 'Membaik')
                    <i data-lucide="arrow-down" class="w-5 h-5 text-green-600"></i>
                @elseif($stats['trend'] === 'Meningkat')
                    <i data-lucide="arrow-up" class="w-5 h-5 text-red-600"></i>
                @endif
            </div>
        </div>

    </div>


    {{-- Trend Chart --}}
    @if($chartData->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow mt-8 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold dark:text-white">{{ __('Grafik Perkembangan Stres') }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Pantau perubahan kondisi mental Anda dalam 30 hari terakhir.') }}</p>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <span class="text-gray-600 dark:text-gray-400">No Stress</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <span class="text-gray-600 dark:text-gray-400">Eustress</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <span class="text-gray-600 dark:text-gray-400">Distress</span>
                </div>
            </div>
        </div>
        <div class="relative" style="height: 300px;">
            <canvas id="stressTrendChart"></canvas>
        </div>
        <div class="mt-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 italic">
                {{ __('Data ini membantu Anda memahami pola stres dan membangun kebiasaan yang lebih sehat.') }}
            </p>
        </div>
    </div>
    @endif

    {{-- AI Insight --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow mt-8 relative overflow-hidden">
        <div class="p-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="p-2 bg-teal-50 dark:bg-teal-900/30 rounded-lg">
                    <i data-lucide="sparkles" class="w-5 h-5 text-teal-600 dark:text-teal-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ __('AI Insight') }}</h3>
            </div>
            
            <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-6">
                {{ __('AI Insight teks') }}
            </p>

            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
                <h4 class="text-sm font-medium text-teal-600 dark:text-teal-400 mb-3 flex items-center gap-2">
                    <i data-lucide="lightbulb" class="w-4 h-4"></i> {{ __('Rekomendasi Sistem') }}
                </h4>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-300">
                        <span class="text-teal-500 mt-0.5">•</span>
                        {{ __('Rekomendasi 1') }}
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-300">
                        <span class="text-teal-500 mt-0.5">•</span>
                        {{ __('Rekomendasi 2') }}
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-300">
                        <span class="text-teal-500 mt-0.5">•</span>
                        {{ __('Rekomendasi 3') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- CONTENT GRID --}}
    <div class="grid lg:grid-cols-2 gap-6 mt-10">

        {{-- Kiri --}}
        <div class="space-y-6">
            {{-- Penilaian Terakhir --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow">
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold dark:text-white">{{ __('Penilaian Terakhir') }}</h3>
                    <a href="{{ route('user.history') }}" class="text-sm text-teal-600 dark:text-teal-400 hover:underline flex items-center gap-1">
                        {{ __('Lihat Semua') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="p-6 space-y-4">
                    @forelse($recent as $item)
                        <div class="flex justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                            <div>
                                <p class="font-medium text-gray-800 dark:text-white">{{ $item->created_at->locale($carbonLocale)->translatedFormat('d M Y') }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item->created_at->format('H:i') }}</p>
                            </div>

                            <div class="text-right">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($item->stress_category === 'No Stress') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($item->stress_category === 'Eustress') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                    @else bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                    @endif">
                                    {{ $item->stress_category ?? 'Unknown' }}
                                </span>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Skor') }}: <span class="font-semibold">{{ $item->total_score }}</span></p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center">{{ __('Not Available') }}</p>
                    @endforelse
                </div>
            </div>

            {{-- Refleksi Mingguan --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-4">
                    <i data-lucide="brain-circuit" class="w-5 h-5 text-blue-500"></i>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ __('Refleksi Mingguan') }}</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                    "{{ __('Refleksi Mingguan teks') }}"
                </p>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800/50">
                    <p class="text-xs text-blue-800 dark:text-blue-300">
                        <span class="font-semibold">{{ __('Saran') }}:</span> {{ __('Refleksi Mingguan saran') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Tips Hari Ini --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow h-fit">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold dark:text-white flex items-center gap-2">
                    <i data-lucide="lightbulb" class="w-5 h-5 text-teal-500"></i>
                    {{ __('Tips Hari Ini') }}
                </h3>
            </div>

            <div class="p-6 space-y-4">
                @php
                    $allTips = [
                        ['title' => 'tip_jeda_title',       'desc' => 'tip_jeda_desc'],
                        ['title' => 'tip_air_title',        'desc' => 'tip_air_desc'],
                        ['title' => 'tip_olahraga_title',   'desc' => 'tip_olahraga_desc'],
                        ['title' => 'tip_333_title',        'desc' => 'tip_333_desc'],
                        ['title' => 'tip_teman_title',      'desc' => 'tip_teman_desc'],
                        ['title' => 'tip_stretching_title', 'desc' => 'tip_stretching_desc'],
                        ['title' => 'tip_sosmed_title',     'desc' => 'tip_sosmed_desc'],
                        ['title' => 'tip_pomodoro_title',   'desc' => 'tip_pomodoro_desc'],
                        ['title' => 'tip_5010_title',       'desc' => 'tip_5010_desc'],
                        ['title' => 'tip_satu_tugas_title', 'desc' => 'tip_satu_tugas_desc'],
                        ['title' => 'tip_54321_title',      'desc' => 'tip_54321_desc'],
                        ['title' => 'tip_journal_title',    'desc' => 'tip_journal_desc'],
                        ['title' => 'tip_detox_title',      'desc' => 'tip_detox_desc'],
                        ['title' => 'tip_nap_title',        'desc' => 'tip_nap_desc'],
                        ['title' => 'tip_meditasi_title',   'desc' => 'tip_meditasi_desc'],
                        ['title' => 'tip_kafein_title',     'desc' => 'tip_kafein_desc'],
                    ];
                    $seed = date('Y-m-d');
                    mt_srand(crc32($seed));
                    shuffle($allTips);
                    $tip1 = $allTips[0];
                    $tip2 = $allTips[1];
                    $tip3 = $allTips[2];
                    $tip4 = $allTips[3];
                @endphp

                <div class="p-4 bg-teal-50 dark:bg-teal-900/20 rounded-xl border border-teal-100 dark:border-teal-800">
                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">{{ __($tip1['title']) }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __($tip1['desc']) }}</p>
                </div>

                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">{{ __($tip2['title']) }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __($tip2['desc']) }}</p>
                </div>

                <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800">
                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">{{ __($tip3['title']) }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __($tip3['desc']) }}</p>
                </div>

                <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800">
                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">{{ __($tip4['title']) }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __($tip4['desc']) }}</p>
                </div>

            </div>
        </div>

    </div>


    {{-- Badges & Achievements --}}
    <div class="mt-8">
        @include('components.badge-showcase', ['user' => auth()->user()])
    </div>


    {{-- Motivational Card --}}
    @php
        $lastAssessment = $recent->first();

        $timeAgo = __('Not Available');
        if ($lastAssessment) {
            $diffInHours = floor($lastAssessment->created_at->diffInHours(now()));
            $diffInDays  = floor($lastAssessment->created_at->diffInDays(now()));

            if ($diffInHours == 0) {
                $timeAgo = __('baru saja');
            } elseif ($diffInHours < 24) {
                $timeAgo = $diffInHours . ' ' . __('jam yang lalu');
            } elseif ($diffInDays == 1) {
                $timeAgo = __('kemarin');
            } else {
                $timeAgo = $diffInDays . ' ' . __('hari yang lalu');
            }
        }

        $daysSinceLastAssessment = $lastAssessment ? floor($lastAssessment->created_at->diffInDays(now())) : 999;
    @endphp

    @if($lastAssessment && $daysSinceLastAssessment < 7)
        <div class="bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl shadow p-6 mt-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 text-white rounded-full flex items-center justify-center">
                    <i data-lucide="heart" class="w-6 h-6"></i>
                </div>
                <div class="text-white">
                    <p class="font-semibold">{{ __('Tetap Semangat!') }} 💪</p>
                    <p class="text-sm text-white/90">
                        {{ __('Penilaian terakhir') }} {{ $timeAgo }}.
                        @if($stats['last_label'] === 'Distress')
                            {{ __('Ingat untuk istirahat dan jaga kesehatan mental Anda.') }}
                        @elseif($stats['last_label'] === 'Eustress')
                            {{ __('Pertahankan energi positif Anda!') }}
                        @else
                            {{ __('Terus jaga keseimbangan hidup Anda!') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border-l-4 border-orange-400 mt-8">
            <div class="flex items-center gap-4 p-6">
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-400 rounded-full flex items-center justify-center">
                    <i data-lucide="calendar-clock" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ __('Sudah Lama Tidak Penilaian') }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        @if($lastAssessment)
                            {{ __('Terakhir') }} {{ $timeAgo }}. {{ __('Yuk, cek kondisi mental Anda lagi!') }}
                        @else
                            {{ __('Not Available') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    lucide.createIcons();

    // Live Clock
    function updateClock() {
        const now = new Date();
        const hours   = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const el = document.getElementById('live-clock');
        if (el) el.textContent = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Trend Chart
    @if(isset($chartData) && $chartData->count() > 0)
    const chartData    = @json($chartData);
    const chartLocale  = '{{ app()->getLocale() === "en" ? "en-US" : "id-ID" }}';
    const lblScore     = '{{ __("Skor Stres") }}';
    const lblCategory  = '{{ __("Kategori") }}';

    const ctx = document.getElementById('stressTrendChart');
    if (ctx) {
        const labels = chartData.map(item => {
            const d = new Date(item.date);
            return d.toLocaleDateString(chartLocale, { day: 'numeric', month: 'short' });
        });
        const scores = chartData.map(item => item.score);
        const pointColors = chartData.map(item => {
            if (item.category === 'No Stress') return 'rgb(34, 197, 94)';
            if (item.category === 'Eustress')  return 'rgb(59, 130, 246)';
            return 'rgb(239, 68, 68)';
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: lblScore,
                    data: scores,
                    borderColor: 'rgb(20, 184, 166)',
                    backgroundColor: 'rgba(20, 184, 166, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: pointColors,
                    pointBorderColor: pointColors,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: ctx => ctx[0].label,
                            label: ctx => {
                                const item = chartData[ctx.dataIndex];
                                return [`${lblScore}: ${item.score}`, `${lblCategory}: ${item.category}`];
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { stepSize: 20 }, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
    @endif
</script>


{{-- Feedback Modal --}}
@include('components.feedback-modal')

@endsection
