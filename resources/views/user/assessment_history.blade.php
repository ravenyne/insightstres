@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 animate-fade-in">
    
    {{-- Header --}}
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Riwayat Assessment</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Lihat semua hasil penilaian sebelumnya</p>
        </div>
        <button 
            onclick="openExportModal()"
            class="px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center gap-2 text-gray-700 dark:text-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Export Semua
        </button>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Total Assessment --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Assessment</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalAssessments }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Skor Terendah --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Skor Terendah</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $lowestScore ?? '-' }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Skor Tertinggi --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Skor Tertinggi</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $highestScore ?? '-' }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Rata-rata --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Rata-rata</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $averageScore ?? '-' }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Assessment List --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Assessment</h2>
        </div>
        
        <div class="p-6">
            @if($assessments->count() > 0)
                <div class="space-y-3">
                    @foreach($assessments as $assessment)
                        @php
                            $score = $assessment->total_score;
                            $category = $assessment->stress_category ?? 'Unknown';
                            
                            // Determine badge color based on category
                            if ($category === 'No Stress' || $score < 30) {
                                $badgeColor = 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400';
                                $badgeText = 'Rendah-Sedang';
                            } elseif ($category === 'Eustress' || $score < 60) {
                                $badgeColor = 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
                                $badgeText = 'Sedang';
                            } else {
                                $badgeColor = 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
                                $badgeText = 'Tinggi';
                            }
                        @endphp
                        
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="flex items-center gap-4 flex-1">
                                {{-- Date & Time --}}
                                <div class="flex items-center gap-3 min-w-[200px]">
                                    <div class="w-10 h-10 bg-white dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $assessment->created_at->format('d F Y') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $assessment->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="flex-1">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $category }}
                                    </p>
                                </div>

                                {{-- Score --}}
                                <div class="text-right min-w-[80px]">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Skor: <span class="font-semibold text-gray-900 dark:text-white">{{ $score }}</span></p>
                                </div>

                                {{-- Badge --}}
                                <div class="min-w-[120px] text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badgeColor }}">
                                        {{ $badgeText }}
                                    </span>
                                </div>
                            </div>

                            {{-- View Icon --}}
                            <button onclick="openQuickView({{ $assessment->id }})" class="ml-4 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada data assessment</p>
                    <a href="{{ route('user.assessment') }}" class="mt-4 inline-block px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition">
                        Mulai Assessment
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Export Modal --}}
<div id="exportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
        {{-- Modal Header --}}
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Export Riwayat Assessment</h3>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Preview semua riwayat assessment sebelum mengunduh</p>
                </div>
                <button onclick="closeExportModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Modal Body - Preview --}}
        <div class="p-6 overflow-y-auto max-h-[60vh]">
            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 bg-gray-50 dark:bg-gray-700/30">
                <div class="text-center mb-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Preview Dokumen</p>
                </div>

                {{-- PDF Preview Content --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg">
                    <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-1">Laporan Riwayat Assessment</h2>
                    <p class="text-center text-sm text-teal-600 dark:text-teal-400 mb-6">Insight Stress Mahasiswa</p>

                    {{-- User Info --}}
                    <div class="flex items-center gap-6 mb-6">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $user->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $totalAssessments }} Assessment</span>
                        </div>
                    </div>

                    {{-- Statistics Summary --}}
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg text-center">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Total</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $totalAssessments }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded-lg text-center">
                            <p class="text-xs text-green-700 dark:text-green-400 mb-1">Terendah</p>
                            <p class="text-lg font-bold text-green-700 dark:text-green-400">{{ $lowestScore ?? '-' }}</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-3 rounded-lg text-center">
                            <p class="text-xs text-red-700 dark:text-red-400 mb-1">Tertinggi</p>
                            <p class="text-lg font-bold text-red-700 dark:text-red-400">{{ $highestScore ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Assessment List Preview --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Riwayat Assessment:</h3>
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            @foreach($assessments->take(5) as $assessment)
                                @php
                                    $score = $assessment->total_score;
                                    $category = $assessment->stress_category ?? 'Unknown';
                                    
                                    if ($category === 'No Stress' || $score < 30) {
                                        $badgeColor = 'bg-green-100 text-green-700';
                                        $badgeText = 'Sedang';
                                    } elseif ($category === 'Eustress' || $score < 60) {
                                        $badgeColor = 'bg-blue-100 text-blue-700';
                                        $badgeText = 'Sedang';
                                    } else {
                                        $badgeColor = 'bg-red-100 text-red-700';
                                        $badgeText = 'Tinggi';
                                    }
                                @endphp
                                
                                <div class="flex items-center justify-between text-sm py-2 border-b border-gray-200 dark:border-gray-600">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $assessment->created_at->format('d F Y') }}</span>
                                    <span class="px-2 py-1 rounded text-xs {{ $badgeColor }}">{{ $badgeText }}</span>
                                </div>
                            @endforeach
                            
                            @if($assessments->count() > 5)
                                <p class="text-xs text-center text-gray-500 dark:text-gray-400 py-2">+{{ $assessments->count() - 5 }} lainnya</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
            <button 
                onclick="closeExportModal()"
                class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                Batal
            </button>
            <a 
                href="{{ route('user.export.pdf') }}"
                class="px-6 py-2.5 bg-teal-500 text-white rounded-xl hover:bg-teal-600 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Unduh PDF
            </a>
        </div>
    </div>
</div>

{{-- Quick View Modal --}}
<div id="quickViewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        {{-- Modal Header --}}
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Assessment</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5" id="quickview-datetime">Loading...</p>
                        </div>
                    </div>
                </div>
                <button onclick="closeQuickView()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
            {{-- Loading State --}}
            <div id="quickview-loading" class="text-center py-12">
                <svg class="animate-spin h-10 w-10 text-teal-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">Memuat data...</p>
            </div>

            {{-- Content --}}
            <div id="quickview-content" class="hidden space-y-6">
                {{-- Stress Category Badge --}}
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Kategori Stress</p>
                        <span id="quickview-category" class="px-4 py-2 rounded-lg text-sm font-semibold"></span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Skor</p>
                        <p id="quickview-score" class="text-3xl font-bold text-gray-900 dark:text-white"></p>
                    </div>
                </div>

                {{-- Mini Chart --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Visualisasi Jawaban</h4>
                    <div class="grid grid-cols-5 gap-2" id="quickview-chart">
                        <!-- Chart will be populated by JavaScript -->
                    </div>
                    <div class="flex items-center justify-between mt-3 text-xs text-gray-500 dark:text-gray-400">
                        <span>Tidak Pernah</span>
                        <span>Sangat Sering</span>
                    </div>
                </div>

                {{-- Recommendations --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Rekomendasi</h4>
                    <div id="quickview-recommendations" class="space-y-2">
                        <!-- Recommendations will be populated by JavaScript -->
                    </div>
                </div>

                {{-- Top Concerns --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Area Perhatian Utama</h4>
                    <div id="quickview-concerns" class="space-y-2">
                        <!-- Top concerns will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
            <button 
                onclick="closeQuickView()"
                class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                Tutup
            </button>
            <a 
                id="quickview-detail-link"
                href="{{ route('user.analysis') }}"
                class="px-6 py-2.5 bg-teal-500 text-white rounded-xl hover:bg-teal-600 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Lihat Detail Lengkap
            </a>
        </div>
    </div>
</div>

<script>
// Export Modal Functions
function openExportModal() {
    document.getElementById('exportModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Quick View Modal Functions
function openQuickView(assessmentId) {
    const modal = document.getElementById('quickViewModal');
    const loading = document.getElementById('quickview-loading');
    const content = document.getElementById('quickview-content');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    loading.classList.remove('hidden');
    content.classList.add('hidden');
    
    // Fetch assessment details
    fetch(`/assessment/${assessmentId}/details`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const data = result.data;
                
                // Update datetime
                document.getElementById('quickview-datetime').textContent = `${data.date} • ${data.time}`;
                
                // Update detail link with assessment ID
                document.getElementById('quickview-detail-link').href = `/analysis/${data.id}`;
                
                // Update category badge
                const categoryBadge = document.getElementById('quickview-category');
                categoryBadge.textContent = data.category;
                
                if (data.category === 'No Stress') {
                    categoryBadge.className = 'px-4 py-2 rounded-lg text-sm font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400';
                } else if (data.category === 'Eustress') {
                    categoryBadge.className = 'px-4 py-2 rounded-lg text-sm font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
                } else {
                    categoryBadge.className = 'px-4 py-2 rounded-lg text-sm font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
                }
                
                // Update score
                document.getElementById('quickview-score').textContent = data.total_score;
                
                // Create mini chart
                const chartContainer = document.getElementById('quickview-chart');
                chartContainer.innerHTML = '';
                
                const answerLabels = ['Tidak Pernah', 'Jarang', 'Kadang-kadang', 'Sering', 'Sangat Sering'];
                const answerCounts = [0, 0, 0, 0, 0];
                
                Object.values(data.answers).forEach(answer => {
                    answerCounts[answer]++;
                });
                
                const maxCount = Math.max(...answerCounts);
                
                answerCounts.forEach((count, index) => {
                    const percentage = maxCount > 0 ? (count / maxCount) * 100 : 0;
                    const bar = document.createElement('div');
                    bar.className = 'flex flex-col items-center gap-1';
                    bar.innerHTML = `
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-24 flex items-end overflow-hidden">
                            <div class="w-full bg-teal-500 dark:bg-teal-400 rounded-t-full transition-all" style="height: ${percentage}%"></div>
                        </div>
                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">${count}</span>
                    `;
                    chartContainer.appendChild(bar);
                });
                
                // Update recommendations
                const recommendationsContainer = document.getElementById('quickview-recommendations');
                recommendationsContainer.innerHTML = '';
                
                data.recommendations.forEach(rec => {
                    const recDiv = document.createElement('div');
                    recDiv.className = 'flex items-start gap-2 p-3 bg-teal-50 dark:bg-teal-900/20 rounded-lg';
                    recDiv.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-600 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">${rec}</span>
                    `;
                    recommendationsContainer.appendChild(recDiv);
                });
                
                // Find top concerns (answers >= 3)
                const concernsContainer = document.getElementById('quickview-concerns');
                concernsContainer.innerHTML = '';
                
                const concerns = [];
                Object.entries(data.answers).forEach(([key, value]) => {
                    if (value >= 3) {
                        concerns.push({
                            label: data.fields[key],
                            value: value
                        });
                    }
                });
                
                if (concerns.length > 0) {
                    concerns.sort((a, b) => b.value - a.value);
                    concerns.slice(0, 5).forEach(concern => {
                        const concernDiv = document.createElement('div');
                        concernDiv.className = 'flex items-center justify-between p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg';
                        concernDiv.innerHTML = `
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-sm text-gray-700 dark:text-gray-300">${concern.label}</span>
                            </div>
                            <span class="px-2 py-1 bg-orange-200 dark:bg-orange-800 text-orange-800 dark:text-orange-200 rounded text-xs font-semibold">${concern.value === 3 ? 'Sering' : 'Sangat Sering'}</span>
                        `;
                        concernsContainer.appendChild(concernDiv);
                    });
                } else {
                    concernsContainer.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada area perhatian khusus</p>';
                }
                
                // Show content, hide loading
                loading.classList.add('hidden');
                content.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loading.innerHTML = '<p class="text-red-500">Gagal memuat data. Silakan coba lagi.</p>';
        });
}

function closeQuickView() {
    document.getElementById('quickViewModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modals when clicking outside
document.getElementById('exportModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeExportModal();
    }
});

document.getElementById('quickViewModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuickView();
    }
});

// Close modals on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeExportModal();
        closeQuickView();
    }
});
</script>

@endsection