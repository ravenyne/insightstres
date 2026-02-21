@extends('layouts.dashboard')

@section('content')
<script src="https://unpkg.com/lucide@latest"></script>

<div class="space-y-8 animate-fade-in">

    {{-- Header dengan Greeting Personal --}}
    @php
        // Timezone Makassar (WITA - UTC+8)
        date_default_timezone_set('Asia/Makassar');
        $hour = date('H');
        $greeting = 'Selamat Malam';
        if ($hour >= 5 && $hour < 11) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Selamat Sore';
        }
        
        $userName = auth()->user()->name;
        $currentDate = \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y'); // Senin, 09 Desember 2025
        $currentTime = date('H:i'); // 20:02
    @endphp

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $greeting }}, {{ $userName }}!
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Bagaimana perasaan Anda hari ini?</p>
        </div>
        
        <div class="text-right">
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $currentDate }}</p>
            <p id="live-clock" class="text-2xl font-bold text-teal-600 dark:text-teal-400">{{ $currentTime }}</p>
        </div>
    </div>

    {{-- CTA Mulai Assessment --}}
    <div class="mt-8 rounded-2xl bg-gradient-to-r from-teal-500 to-cyan-500 p-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl text-white font-semibold">Mulai Assessment Baru</h2>
                <p class="text-white/80">Lacak kesehatan mental Anda secara berkala.</p>
            </div>

            <a href="{{ route('user.assessment') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium flex items-center gap-2">
                Mulai Sekarang
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
            <p class="text-gray-500 dark:text-gray-400 text-sm">Total Assessment</p>
            <p class="text-2xl font-bold dark:text-white">{{ $stats['total'] ?? 0 }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-3">
                <i data-lucide="activity" class="w-6 h-6"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Tingkat Stres Terakhir</p>
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
            <p class="text-gray-500 dark:text-gray-400 text-sm">Assessment Bulan Ini</p>
            <p class="text-2xl font-bold dark:text-white">{{ $stats['this_month'] ?? 0 }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow">
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 rounded-xl flex items-center justify-center mb-3">
                <i data-lucide="trending-up" class="w-6 h-6"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Trend</p>
            <p class="text-2xl font-bold dark:text-white
                @if($stats['trend'] === 'Membaik') text-green-600
                @elseif($stats['trend'] === 'Meningkat') text-red-600
                @elseif($stats['trend'] === 'Stabil') text-blue-600
                @endif">
                {{ $stats['trend'] }}
            </p>
        </div>

    </div>


    {{-- Trend Chart --}}
    @if($chartData->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow mt-8 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold dark:text-white">Grafik Perkembangan Stress</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">30 hari terakhir</p>
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
    </div>
    @endif


    {{-- CONTENT GRID --}}
    <div class="grid lg:grid-cols-2 gap-6 mt-10">

        {{-- Assessment Terakhir --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold dark:text-white">Assessment Terakhir</h3>

                <a href="{{ route('user.history') }}" class="text-sm text-teal-600 dark:text-teal-400 hover:underline flex items-center gap-1">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="p-6 space-y-4">

                @forelse($recent as $item)
                    <div class="flex justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white">{{ $item->created_at->locale('id')->translatedFormat('d M Y') }}</p>
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
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Skor: <span class="font-semibold">{{ $item->total_score }}</span></p>
                        </div>
                    </div>

                @empty
                    <p class="text-gray-500 text-sm text-center">Belum ada data.</p>
                @endforelse

            </div>
        </div>

        {{-- Tips Hari Ini --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold dark:text-white flex items-center gap-2">
                    <i data-lucide="lightbulb" class="w-5 h-5 text-teal-500"></i>
                    Tips Hari Ini
                </h3>
            </div>

            <div class="p-6 space-y-4">
                @php
                    // Tips pool
                    $allTips = [
                        ['title' => 'Teknik 5-4-3-2-1', 'desc' => 'Saat cemas, identifikasi 5 hal yang Anda lihat, 4 sentuh, 3 dengar, 2 cium, 1 rasakan.'],
                        ['title' => 'Jeda Sejenak', 'desc' => 'Ambil 5 menit untuk tarik napas dalam-dalam setiap 2 jam.'],
                        ['title' => 'Journaling', 'desc' => 'Tulis 3 hal yang Anda syukuri hari ini sebelum tidur.'],
                        ['title' => 'Digital Detox', 'desc' => 'Matikan notifikasi 1 jam sebelum tidur untuk kualitas tidur lebih baik.'],
                        ['title' => 'Olahraga Ringan', 'desc' => 'Jalan kaki 15 menit dapat meningkatkan mood dan mengurangi stress.'],
                        ['title' => 'Minum Air Putih', 'desc' => 'Dehidrasi dapat memperburuk stress. Minum minimal 8 gelas sehari.'],
                        ['title' => 'Power Nap', 'desc' => 'Tidur siang 20-30 menit dapat meningkatkan fokus dan mengurangi kelelahan.'],
                        ['title' => 'Berbicara dengan Teman', 'desc' => 'Sharing masalah dengan orang terdekat dapat meringankan beban pikiran.'],
                        ['title' => 'Meditasi 5 Menit', 'desc' => 'Duduk tenang, fokus pada napas, biarkan pikiran mengalir tanpa judgment.'],
                        ['title' => 'Batasi Kafein', 'desc' => 'Terlalu banyak kafein dapat meningkatkan kecemasan. Batasi 2 cangkir/hari.'],
                    ];
                    
                    // Random 2 tips per hari
                    $seed = date('Y-m-d');
                    mt_srand(crc32($seed));
                    shuffle($allTips);
                    $tip1 = $allTips[0];
                    $tip2 = $allTips[1];
                @endphp

                <div class="p-4 bg-teal-50 dark:bg-teal-900/20 rounded-xl border border-teal-100 dark:border-teal-800">
                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">{{ $tip1['title'] }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $tip1['desc'] }}</p>
                </div>

                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">{{ $tip2['title'] }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $tip2['desc'] }}</p>
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
        
        // Format waktu yang lebih manusiawi
        $timeAgo = 'belum ada';
        if ($lastAssessment) {
            $diffInHours = floor($lastAssessment->created_at->diffInHours(now()));
            $diffInDays = floor($lastAssessment->created_at->diffInDays(now()));
            
            if ($diffInHours == 0) {
                $timeAgo = 'baru saja';
            } elseif ($diffInHours < 24) {
                $timeAgo = $diffInHours . ' jam yang lalu';
            } elseif ($diffInDays == 1) {
                $timeAgo = 'kemarin';
            } else {
                $timeAgo = $diffInDays . ' hari yang lalu';
            }
        }
        
        $daysSinceLastAssessment = $lastAssessment ? floor($lastAssessment->created_at->diffInDays(now())) : 999;
    @endphp

    @if($lastAssessment && $daysSinceLastAssessment < 7)
        {{-- Jika baru assessment (< 7 hari) - tampilkan motivasi --}}
        <div class="bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl shadow p-6 mt-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 text-white rounded-full flex items-center justify-center">
                    <i data-lucide="heart" class="w-6 h-6"></i>
                </div>
                <div class="text-white">
                    <p class="font-semibold">Tetap Semangat! 💪</p>
                    <p class="text-sm text-white/90">
                        Assessment terakhir {{ $timeAgo }}. 
                        @if($stats['last_label'] === 'Distress')
                            Ingat untuk istirahat dan jaga kesehatan mental Anda.
                        @elseif($stats['last_label'] === 'Eustress')
                            Pertahankan energi positif Anda!
                        @else
                            Terus jaga keseimbangan hidup Anda!
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @else
        {{-- Jika sudah lama tidak assessment (>= 7 hari) - tampilkan reminder --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border-l-4 border-orange-400 mt-8">
            <div class="flex items-center gap-4 p-6">
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-400 rounded-full flex items-center justify-center">
                    <i data-lucide="calendar-clock" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white">Sudah Lama Tidak Assessment</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        @if($lastAssessment)
                            Terakhir {{ $timeAgo }}. Yuk, cek kondisi mental Anda lagi!
                        @else
                            Belum ada assessment. Mulai sekarang untuk tracking kesehatan mental Anda!
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
    
    // Live Clock - Update setiap detik
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            clockElement.textContent = `${hours}:${minutes}:${seconds}`;
        }
    }
    
    // Update setiap detik
    setInterval(updateClock, 1000);
    updateClock(); // Initial call

    // Trend Chart
    @if(isset($chartData) && $chartData->count() > 0)
    const chartData = @json($chartData);
    
    const ctx = document.getElementById('stressTrendChart');
    if (ctx) {
        // Prepare data
        const labels = chartData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
        });
        
        const scores = chartData.map(item => item.score);
        
        // Color points based on category
        const pointColors = chartData.map(item => {
            if (item.category === 'No Stress') return 'rgb(34, 197, 94)'; // green
            if (item.category === 'Eustress') return 'rgb(59, 130, 246)'; // blue
            return 'rgb(239, 68, 68)'; // red for Distress
        });
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Stress',
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
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const item = chartData[context.dataIndex];
                                return [
                                    `Skor: ${item.score}`,
                                    `Kategori: ${item.category}`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    @endif
</script>


{{-- Feedback Modal - Only on Dashboard --}}
@include('components.feedback-modal')

@endsection
