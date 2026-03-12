@extends('layouts.dashboard')

@section('content')

@php
    $hasData = $latest !== null;

    if($hasData){
        $category = $latest->stress_category ?? "Unknown";
        $labelValue = $latest->numeric_score ?? 0;
        $totalScore = $latest->total_score;

        $colorMap = [
            "No Stress" => ["color" => "text-green-600", "bg" => "bg-green-100", "dark_bg" => "dark:bg-green-900/30", "dark_text" => "dark:text-green-400"],
            "Eustress"  => ["color" => "text-blue-600", "bg" => "bg-blue-100", "dark_bg" => "dark:bg-blue-900/30", "dark_text" => "dark:text-blue-400"],
            "Distress"  => ["color" => "text-red-600", "bg" => "bg-red-100", "dark_bg" => "dark:bg-red-900/30", "dark_text" => "dark:text-red-400"],
        ];

        $info = $colorMap[$category] ?? ["color" => "text-gray-600", "bg" => "bg-gray-300", "dark_bg" => "dark:bg-gray-700", "dark_text" => "dark:text-gray-400"];

        // Category descriptions
        $categoryDescriptions = [
            "No Stress" => __("Desc No Stress"),
            "Eustress" => __("Desc Eustress"),
            "Distress" => __("Desc Distress"),
        ];

        $categoryDesc = $categoryDescriptions[$category] ?? __("Kategori tidak dikenali.");

        // Get previous assessment for comparison
        $previous = $assessments->count() > 1 ? $assessments->get(1) : null;
        $scoreDiff = null;
        $trendText = "";
        $trendIcon = "";
        $trendColor = "";

        if ($previous) {
            $scoreDiff = $totalScore - $previous->total_score;
            
            if ($scoreDiff > 0) {
                $trendText = __('meningkat :value poin dari penilaian sebelumnya', ['value' => abs($scoreDiff)]);
                $trendIcon = "trending-up";
                $trendColor = "text-red-600 dark:text-red-400";
            } elseif ($scoreDiff < 0) {
                $trendText = __('menurun :value poin dari penilaian sebelumnya', ['value' => abs($scoreDiff)]);
                $trendIcon = "trending-down";
                $trendColor = "text-green-600 dark:text-green-400";
            } else {
                $trendText = __('stabil, tidak ada perubahan dari penilaian sebelumnya');
                $trendIcon = "minus";
                $trendColor = "text-blue-600 dark:text-blue-400";
            }
        }

        $chartScores = $assessments->map(function($a){
            return [
                "date" => $a->created_at->format('M d'),
                "score" => $a->numeric_score ?? 0
            ];
        });

        // Calculate synthetic resilience score based on stress level and recent trends
        $baseResilience = 75;
        if($category === 'Distress') $baseResilience = 45;
        elseif($category === 'Eustress') $baseResilience = 65;
        elseif($category === 'No Stress') $baseResilience = 85;

        // Adjust based on trend
        if($scoreDiff !== null) {
            if($scoreDiff < 0) $baseResilience += 5; // improving
            elseif($scoreDiff > 0) $baseResilience -= 5; // worsening
        }

        // Ensure score is within 0-100
        $resilienceScore = max(0, min(100, $baseResilience));

        // Determine resilience label and color
        $resilienceLabel = __('Rendah');
        $resilienceColor = 'text-red-600 dark:text-red-400';
        $resilienceBg = 'bg-red-500';
        
        if($resilienceScore >= 80) {
            $resilienceLabel = __('Tinggi');
            $resilienceColor = 'text-green-600 dark:text-green-400';
            $resilienceBg = 'bg-green-500';
        } elseif($resilienceScore >= 60) {
            $resilienceLabel = __('Sedang');
            $resilienceColor = 'text-blue-600 dark:text-blue-400';
            $resilienceBg = 'bg-blue-500';
        }
    }
@endphp


{{-- ================================================================= --}}
{{-- =================  JIKA BELUM ADA DATA PENILAIAN   ============== --}}
{{-- ================================================================= --}}
@if(!$hasData)

<div class="min-h-[60vh] flex flex-col items-center justify-center animate-fade-in px-4">

    <div class="bg-white dark:bg-gray-800 p-12 rounded-3xl shadow-xl flex flex-col items-center text-center max-w-2xl w-full border border-gray-100 dark:border-gray-700">

        <!-- Icon Container -->
        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-teal-100 to-cyan-100 dark:from-teal-900/30 dark:to-cyan-900/30 flex items-center justify-center mb-6 shadow-lg">
            <svg class="w-16 h-16 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
            {{ __('Belum Ada Data Penilaian') }}
        </h2>

        <!-- Description -->
        <p class="text-gray-600 dark:text-gray-400 text-lg mb-8 max-w-md leading-relaxed">
            {{ __('Anda belum pernah melakukan penilaian stres. Mulai penilaian pertama Anda untuk mendapatkan analisis mendalam dan rekomendasi personal.') }}
        </p>

        <!-- Features List -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 w-full">
            <div class="flex items-start gap-3 p-4 bg-teal-50 dark:bg-teal-900/20 rounded-xl">
                <svg class="w-6 h-6 text-teal-600 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-left">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ __('Analisis Akurat') }}</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ __('Hasil berbasis AI') }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 bg-cyan-50 dark:bg-cyan-900/20 rounded-xl">
                <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <div class="text-left">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ __('Cepat & Mudah') }}</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ __('Hanya 5-10 menit') }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <div class="text-left">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ __('Rekomendasi') }}</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ __('Tips personal') }}</p>
                </div>
            </div>
        </div>

        <!-- CTA Button -->
        <a href="{{ route('user.assessment') }}" class="group">
            <button class="px-8 py-4 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl font-semibold text-lg hover:from-teal-600 hover:to-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                {{ __('Mulai Penilaian Sekarang') }}
            </button>
        </a>

        <!-- Additional Info -->
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-6">
            {{ __('Penilaian akan membantu Anda memahami tingkat stres dan mendapatkan solusi yang tepat') }}
        </p>
    </div>
</div>

@endif

@if($hasData)

{{-- ================================================================= --}}
{{-- =====================     HASIL ANALISIS     ===================== --}}
{{-- ================================================================= --}}

<div class="space-y-8 animate-fade-in">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Hasil Analisis') }}</h1>
            <p class="text-gray-500 dark:text-gray-400">{{ __('Lihat perkembangan tingkat stres Anda') }}</p>
        </div>

        <button onclick="openExportModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg flex items-center gap-2 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200">
            <i data-lucide="download" class="w-4 h-4"></i>
            {{ __('Export PDF') }}
        </button>
    </div>

    {{-- CARD + GRAFIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- CARD KATEGORI --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-3">{{ __('Kategori Stres Terakhir') }}</p>

            <div class="flex items-center justify-center">
                <div class="w-40 h-40 rounded-full flex items-center justify-center {{ $info['bg'] }} {{ $info['dark_bg'] }}">
                    <span class="text-2xl font-bold {{ $info['color'] }} {{ $info['dark_text'] }} text-center px-4">
                        {{ $category }}
                    </span>
                </div>
            </div>

            <p class="text-center mt-4 text-gray-600 dark:text-gray-300 text-sm">
                {{ __('Level') }}: <span class="font-semibold">{{ $labelValue }}</span>
            </p>

            {{-- Category Description --}}
            <div class="mt-4 p-3 {{ $info['bg'] }} {{ $info['dark_bg'] }} rounded-lg">
                <p class="text-xs {{ $info['color'] }} {{ $info['dark_text'] }} text-center leading-relaxed">
                    {{ $categoryDesc }}
                </p>
            </div>

            {{-- Score Comparison --}}
            @if($previous)
                <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="{{ $trendIcon }}" class="w-4 h-4 {{ $trendColor }}"></i>
                        <span class="text-gray-700 dark:text-gray-300">
                            {!! __('Skor :trend_text', ['trend_text' => '<span class="font-semibold ' . $trendColor . '">' . $trendText . '</span>']) !!}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-1">
                        {{ __('Sebelumnya: :prev → Sekarang: :curr', ['prev' => $previous->total_score, 'curr' => $totalScore]) }}
                    </p>
                </div>
            @else
                <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <p class="text-xs text-blue-700 dark:text-blue-300 text-center">
                        {{ __('🎯 Ini adalah penilaian pertama Anda. Lakukan penilaian berikutnya untuk melihat perkembangan!') }}
                    </p>
                </div>
            @endif
        </div>

        {{-- GRAFIK & INSIGHT --}}
        <div class="md:col-span-2 space-y-6">
            {{-- GRAFIK --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                <p class="text-lg font-semibold dark:text-white mb-4">{{ __('Grafik Perkembangan Stres') }}</p>
                <canvas id="stressChart" height="160"></canvas>
                <p class="text-xs text-gray-400 mt-3 text-center">
                    0 = No Stress • 1 = Eustress • 2 = Distress
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- RESILIENCE INDICATOR --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i data-lucide="shield" class="w-5 h-5 text-teal-500"></i>
                        {{ __('Indikator Ketahanan Mahasiswa') }}
                    </h3>
                    
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('Resilience Score') }}</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $resilienceScore }} <span class="text-sm font-normal text-gray-500">/ 100</span></p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 {{ $resilienceColor }}">
                            {{ __('Resiliensi') }} {{ $resilienceLabel }}
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-4">
                        <div class="{{ $resilienceBg }} h-2 rounded-full transition-all duration-1000" style="width: {{ $resilienceScore }}%"></div>
                    </div>

                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ __('Skor ini menggambarkan kemampuan Anda dalam menghadapi tekanan akademik dan menjaga keseimbangan mental.') }}
                    </p>
                </div>

                {{-- COMMUNITY INSIGHT --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow flex flex-col">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-3 flex items-center gap-2">
                        <i data-lucide="users" class="w-5 h-5 text-blue-500"></i>
                        {{ __('Insight Komunitas Mahasiswa') }}
                    </h3>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/10 p-4 rounded-xl flex-grow border border-blue-100 dark:border-blue-800/50">
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                            "{{ __('Berdasarkan data anonim pengguna, mahasiswa sering mengalami peningkatan stres menjelang minggu ujian dan deadline tugas besar.') }}"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ANALISIS --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
        <h2 class="text-xl font-semibold dark:text-white mb-3">{{ __('Analisis Keseluruhan') }}</h2>

        <div class="space-y-3">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('Berdasarkan hasil penilaian terakhir, tingkat stres Anda berada pada kategori') }}
                <strong class="{{ $info['color'] }} {{ $info['dark_text'] }}">{{ $category }}</strong>.
            </p>

            @if($previous)
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    @if($scoreDiff > 0)
                        📈 {!! __('Terjadi peningkatan skor stres sebesar :value poin. Ini menunjukkan bahwa tingkat stres Anda meningkat sejak penilaian terakhir.', ['value' => '<strong class="text-red-600 dark:text-red-400">' . abs($scoreDiff) . '</strong>']) !!}
                        <span class="block mt-2 text-sm italic">
                            💡 <strong>Tips:</strong> {{ __('Tips Peningkatan Stres') }}
                        </span>
                    @elseif($scoreDiff < 0)
                        📉 {!! __('Terjadi penurunan skor stres sebesar :value poin. Ini adalah tanda positif bahwa kondisi mental Anda membaik!', ['value' => '<strong class="text-green-600 dark:text-green-400">' . abs($scoreDiff) . '</strong>']) !!}
                        <span class="block mt-2 text-sm italic">
                            💡 <strong>Tips:</strong> {{ __('Tips Penurunan Stres') }}
                        </span>
                    @else
                        ➡️ {!! __('Skor stres Anda stabil, tidak ada perubahan signifikan dari penilaian sebelumnya.') !!}
                        <span class="block mt-2 text-sm italic">
                            💡 <strong>Tips:</strong> {{ __('Tips Stres Stabil') }}
                        </span>
                    @endif
                </p>
            @else
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ __('Ini adalah penilaian pertama Anda. Lakukan penilaian secara berkala untuk melihat perkembangan dan tren tingkat stres Anda.') }}
                </p>
            @endif

            @if($category === "Distress")
                <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded">
                    <p class="text-sm text-red-800 dark:text-red-300">
                        <strong>{{ __('⚠️ Perhatian:') }}</strong> {{ __('Peringatan Distress') }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- STRESS FACTOR & RECOVERY PROGRESS --}}
    <div class="grid md:grid-cols-2 gap-6">
        
        {{-- STRESS FACTORS --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow h-full">
            <h2 class="text-lg font-semibold dark:text-white mb-2 flex items-center gap-2">
                <i data-lucide="pie-chart" class="w-5 h-5 text-purple-500"></i>
                {{ __('Faktor yang Berkontribusi pada Stres') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                {{ __('Faktor-faktor ini umum berkontribusi pada peningkatan stres mahasiswa.') }}
            </p>

            <ul class="space-y-3">
                <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <div class="mt-0.5 w-5 h-5 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                        <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                    </div>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Beban tugas akademik yang menumpuk') }}</span>
                </li>
                <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <div class="mt-0.5 w-5 h-5 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                        <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                    </div>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Kurangnya waktu istirahat yang berkualitas') }}</span>
                </li>
                <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <div class="mt-0.5 w-5 h-5 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                        <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                    </div>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Jadwal belajar dan aktivitas padat') }}</span>
                </li>
            </ul>
        </div>

        {{-- RECOVERY PROGRESS --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow h-full flex flex-col">
            <h2 class="text-lg font-semibold dark:text-white mb-2 flex items-center gap-2">
                <i data-lucide="activity" class="w-5 h-5 text-teal-500"></i>
                {{ __('Progress Pemulihan') }}
            </h2>
            
            <div class="flex items-center gap-3 mb-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Status:') }}</span>
                @if($category === 'Distress' || ($scoreDiff !== null && $scoreDiff > 0))
                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-semibold rounded-full border border-yellow-200 dark:border-yellow-800/50 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ __('Perlu Perhatian') }}
                    </span>
                @elseif($category === 'Eustress' || ($scoreDiff !== null && $scoreDiff < 0))
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-semibold rounded-full border border-blue-200 dark:border-blue-800/50 flex items-center gap-1">
                        <i data-lucide="refresh-cw" class="w-3 h-3"></i> {{ __('Dalam Pemulihan') }}
                    </span>
                @else
                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full border border-green-200 dark:border-green-800/50 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-3 h-3"></i> {{ __('Kondisi Optimal') }}
                    </span>
                @endif
            </div>

            <div class="flex-grow bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed italic">
                    "{{ __('Progress Penjelasan') }}"
                </p>
            </div>
        </div>

    </div>

    {{-- REKOMENDASI PERSONAL --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
        <h2 class="text-xl font-semibold dark:text-white mb-5">{{ __('Rekomendasi Personal') }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            @if($category === "No Stress")
                <div class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                    <h3 class="font-semibold text-green-700 dark:text-green-400 mb-1">{{ __('Pertahankan Keseimbangan') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Anda dalam kondisi stabil. Pertahankan pola hidup sehat.') }}</p>
                </div>

                <div class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                    <h3 class="font-semibold text-green-700 dark:text-green-400 mb-1">{{ __('Aktivitas Positif') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Tetap lakukan olahraga dan interaksi sosial.') }}</p>
                </div>

            @elseif($category === "Eustress")

                <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                    <h3 class="font-semibold text-blue-700 dark:text-blue-400 mb-1">{{ __('Kelola Energi Positif') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Eustress bagus, tetapi jangan sampai berlebihan.') }}</p>
                </div>

                <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                    <h3 class="font-semibold text-blue-700 dark:text-blue-400 mb-1">{{ __('Tetap Seimbang') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Istirahat cukup agar tidak berubah menjadi distress.') }}</p>
                </div>

            @elseif($category === "Distress")

                <div class="p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <h3 class="font-semibold text-red-700 dark:text-red-400 mb-1">{{ __('Kurangi Beban') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Ambil waktu untuk diri sendiri dan kurangi tekanan mental.') }}</p>
                </div>

                <div class="p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <h3 class="font-semibold text-red-700 dark:text-red-400 mb-1">{{ __('Cari Dukungan') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">{{ __('Pertimbangkan berbicara dengan teman dekat atau konselor.') }}</p>
                </div>

            @else
                <p class="text-gray-600 dark:text-gray-300">{{ __('Kategori tidak dikenali.') }}</p>
            @endif

        </div>
    </div>

</div>

{{-- Export Modal --}}
<div id="exportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        {{-- Modal Header --}}
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="file-text" class="w-6 h-6 text-teal-500"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('Export Hasil Analisis') }}</h3>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Preview dokumen hasil analisis stres Anda sebelum mengunduh') }}</p>
                </div>
                <button onclick="closeExportModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        {{-- Modal Body - Preview --}}
        <div class="p-6 overflow-y-auto max-h-[60vh]">
            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 bg-gray-50 dark:bg-gray-700/30">
                <div class="text-center mb-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">{{ __('Preview Dokumen') }}</p>
                </div>

                {{-- PDF Preview Content --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg">
                    <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-1">{{ __('Laporan Hasil Analisis Stres') }}</h2>
                    <p class="text-center text-sm text-teal-600 dark:text-teal-400 mb-6">{{ __('Insight Stres Mahasiswa') }}</p>

                    {{-- User Info --}}
                    <div class="flex items-center gap-6 mb-6">
                        <div class="flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-teal-500"></i>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $user->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="calendar" class="w-5 h-5 text-teal-500"></i>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $latest->created_at->format('d F Y') }}</span>
                        </div>
                    </div>

                    {{-- Score Display --}}
                    <div class="bg-{{ $category === 'No Stress' ? 'green' : ($category === 'Eustress' ? 'blue' : 'red') }}-50 dark:bg-{{ $category === 'No Stress' ? 'green' : ($category === 'Eustress' ? 'blue' : 'red') }}-900/20 p-4 rounded-lg text-center mb-6">
                        <div class="flex items-center justify-center gap-3">
                            <div class="text-4xl font-bold {{ $info['color'] }} {{ $info['dark_text'] }}">{{ $totalScore }}</div>
                            <div class="text-left">
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ __('Skor Stres') }}: {{ $category }}</p>
                                @if($previous)
                                    <p class="text-xs {{ $trendColor }}">{{ ucfirst(str_replace('assessment', 'penilaian', __($trendText))) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Recommendations Preview --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">{{ __('Rekomendasi') }}:</h3>
                        <ul class="space-y-2 text-xs text-gray-700 dark:text-gray-300">
                            @if($category === "No Stress")
                                <li>• {{ __('Latihan Mindfulness') }}</li>
                                <li>• {{ __('Perbaiki Pola Tidur') }}</li>
                                <li>• {{ __('Aktivitas Fisik') }}</li>
                            @elseif($category === "Eustress")
                                <li>• {{ __('Kelola Energi Positif') }}</li>
                                <li>• {{ __('Tetap Seimbang') }}</li>
                                <li>• {{ __('Istirahat Cukup') }}</li>
                            @else
                                <li>• {{ __('Kurangi Beban') }}</li>
                                <li>• {{ __('Cari Dukungan') }}</li>
                                <li>• {{ __('Konsultasi Profesional') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
            <button 
                onclick="closeExportModal()"
                class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                {{ __('Batal') }}
            </button>
            <a 
                href="{{ route('user.export.analysis.pdf') }}"
                class="px-6 py-2.5 bg-teal-500 text-white rounded-xl hover:bg-teal-600 transition flex items-center gap-2">
                <i data-lucide="download" class="w-5 h-5"></i>
                {{ __('Unduh PDF') }}
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const chartData = @json($chartScores ?? []);

    new Chart(document.getElementById('stressChart'), {
        type: 'line',
        data: {
            labels: chartData.map(i => i.date),
            datasets: [{
                label: "{{ __('Kategori Stres') }}",
                data: chartData.map(i => i.score),
                borderWidth: 3,
                borderColor: "rgb(20,150,140)",
                backgroundColor: "rgba(20,150,140,0.2)",
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    min: 0,
                    max: 2,
                    ticks: {
                        stepSize: 1,
                        callback: v => ({
                            0: "No Stress",
                            1: "Eustress",
                            2: "Distress"
                        }[v])
                    }
                }
            }
        }
    });

    function openExportModal() {
        document.getElementById('exportModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        lucide.createIcons();
    }

    function closeExportModal() {
        document.getElementById('exportModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('exportModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeExportModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeExportModal();
        }
    });

    lucide.createIcons();
</script>

@endif

@endsection
