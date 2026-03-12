@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto space-y-4 animate-fade-in">
    
    {{-- Header --}}
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Assessment History') }}</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">{{ __('View all previous assessments') }}</p>
        </div>
        <button 
            onclick="openExportModal()"
            class="px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center gap-2 text-gray-700 dark:text-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            {{ __('Export All') }}
        </button>
    </div>

    @php
        // Calculate Stability Index
        $stabilityIndex = 100;
        if($assessments->count() > 1) {
            $variance = 0;
            $mean = $averageScore ?? 0;
            foreach($assessments as $a) {
                $variance += pow($a->total_score - $mean, 2);
            }
            $variance = $variance / $assessments->count();
            $stdDev = sqrt($variance);
            
            // Normalize stability (0-100) based on standard deviation
            // 0 stdDev = 100% stable. Max typical stdDev ~40 (e.g. scores swinging 0 to 80)
            $stabilityScore = max(0, 100 - ($stdDev * 2.5)); 
            $stabilityIndex = round($stabilityScore);
        }

        // Determine Insight Pattern message
        $insightTitle = __('Stress Pattern Insight');
        $insightMessage = __('Not enough data to analyze your stress pattern. Take more assessments regularly.');
        $insightIcon = "activity";
        $insightColor = "text-blue-500 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400";
        $insightBorder = "border-blue-200 dark:border-blue-800";

        if($assessments->count() >= 2) {
            $latestScore = $assessments[0]->total_score;
            $previousScore = $assessments[1]->total_score;
            
            if($latestScore > $previousScore + 5) {
                $insightMessage = __('Stress level shows an **increasing** trend in the last two assessments. This often happens as academic workload increases.');
                $insightIcon = "trending-up";
                $insightColor = "text-orange-500 bg-orange-100 dark:bg-orange-900/30 dark:text-orange-400";
                $insightBorder = "border-orange-200 dark:border-orange-800";
            } elseif($latestScore < $previousScore - 5) {
                $insightMessage = __('There is a **decreasing** trend in stress levels on your last assessment.');
                $insightIcon = "trending-down";
                $insightColor = "text-green-500 bg-green-100 dark:bg-green-900/30 dark:text-green-400";
                $insightBorder = "border-green-200 dark:border-green-800";
            } else {
                $insightMessage = __('Your stress level has been relatively **stable** lately.');
                $insightIcon = "minus";
                 $insightColor = "text-teal-500 bg-teal-100 dark:bg-teal-900/30 dark:text-teal-400";
                 $insightBorder = "border-teal-200 dark:border-teal-800";
            }
        }
    @endphp

    {{-- STRESS PATTERN INSIGHT --}}
    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border {{ $insightBorder }}">
        <div class="flex items-center gap-3">
            <div class="p-2 rounded-lg {{ $insightColor }} shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    @if($insightIcon === 'trending-up')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    @elseif($insightIcon === 'trending-down')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    @elseif($insightIcon === 'minus')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    @endif
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-0.5">{{ $insightTitle }}</h3>
                <p class="text-gray-600 dark:text-gray-300 leading-snug max-w-5xl text-xs line-clamp-2">
                    {!! str_replace('**', '<strong>', str_replace('**', '</strong>', $insightMessage)) !!}
                </p>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
        {{-- Total Assessment --}}
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-1">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap overflow-hidden text-ellipsis">{{ __('Total Assessments') }}</p>
                <div class="w-6 h-6 shrink-0 bg-blue-100 dark:bg-blue-900/30 rounded flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalAssessments }}</p>
        </div>

        {{-- Skor Terendah --}}
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-1">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap overflow-hidden text-ellipsis">{{ __('Lowest Score') }}</p>
                <div class="w-6 h-6 shrink-0 bg-green-100 dark:bg-green-900/30 rounded flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                </div>
            </div>
            <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $lowestScore ?? '-' }}</p>
        </div>

        {{-- Skor Tertinggi --}}
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-1">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap overflow-hidden text-ellipsis">{{ __('Highest Score') }}</p>
                <div class="w-6 h-6 shrink-0 bg-red-100 dark:bg-red-900/30 rounded flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $highestScore ?? '-' }}</p>
        </div>

        {{-- Rata-rata --}}
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-1">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap overflow-hidden text-ellipsis">{{ __('Average Score') }}</p>
                <div class="w-6 h-6 shrink-0 bg-purple-100 dark:bg-purple-900/30 rounded flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $averageScore ?? '-' }}</p>
        </div>
        
        {{-- Stability Index --}}
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 relative group cursor-help md:col-start-auto col-span-2 md:col-span-2 lg:col-span-2">
            <div class="flex items-center justify-between mb-1">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium whitespace-nowrap overflow-hidden text-ellipsis">{{ __('Stability Index') }}</p>
                <div class="w-6 h-6 shrink-0 bg-indigo-100 dark:bg-indigo-900/30 rounded flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $assessments->count() > 1 ? $stabilityIndex . '%' : '-' }}</p>
            @if($assessments->count() > 1)
                <!-- Tooltip for stability index -->
                <div class="absolute opacity-0 group-hover:opacity-100 transition duration-300 bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded-lg shadow-lg pointer-events-none z-10 text-center">
                    {{ __('This indicator shows how stable your stress condition is over time.') }}
                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                </div>
            @endif
        </div>
    </div>

    {{-- Assessment List --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mt-4">
        <div class="p-3 border-b border-gray-200 dark:border-gray-700 px-4">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('Assessment List') }}</h2>
        </div>
        
        <div class="p-3 space-y-2">
            @if($assessments->count() > 0)
                <div class="space-y-3">
                    @foreach($assessments as $assessment)
                        @php
                            $score = $assessment->total_score;
                            $category = $assessment->stress_category ?? 'Unknown';
                            
                            // Calculate diff with previous assessment if not the last one in the collection
                            $scoreDiff = null;
                            if($loop->index < $assessments->count() - 1) {
                                $prevScoreInLoop = $assessments[$loop->index + 1]->total_score;
                                $scoreDiff = $score - $prevScoreInLoop;
                            }
                            
                            // Determine badge color based on category
                            if ($category === 'No Stress' || $score < 30) {
                                $badgeColor = 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400';
                                $badgeText = __('Low-Moderate');
                            } elseif ($category === 'Eustress' || $score < 60) {
                                $badgeColor = 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
                                $badgeText = __('Moderate');
                            } else {
                                $badgeColor = 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
                                $badgeText = __('High');
                            }
                        @endphp
                        
                        <div class="flex items-center justify-between py-3 px-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="flex items-center gap-3 md:gap-4 flex-wrap sm:flex-nowrap w-full pr-4">
                                
                                {{-- Date --}}
                                <div class="text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $assessment->created_at->format('d M Y') }}</span>
                                    <span class="mx-1.5 hidden sm:inline-block text-gray-300 dark:text-gray-600">•</span>
                                </div>
                                
                                {{-- Category --}}
                                <div class="font-medium text-sm text-gray-800 dark:text-gray-200 flex items-center whitespace-nowrap">
                                    {{ $category }}
                                    <span class="mx-1.5 hidden sm:inline-block text-gray-300 dark:text-gray-600">•</span>
                                </div>
                                
                                {{-- Score --}}
                                <div class="text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                    {{ __('Score') }} {{ $score }}
                                    <span class="mx-1.5 hidden sm:inline-block text-gray-300 dark:text-gray-600">•</span>
                                </div>

                                {{-- Change --}}
                                <div class="text-xs font-medium whitespace-nowrap">
                                    @if($scoreDiff !== null)
                                        <span class="{{ $scoreDiff > 0 ? 'text-red-500' : ($scoreDiff < 0 ? 'text-green-500' : 'text-gray-500') }}">
                                            @if($scoreDiff > 0)
                                                ↑ +{{ $scoreDiff }}
                                            @elseif($scoreDiff < 0)
                                                ↓ {{ $scoreDiff }}
                                            @else
                                                − 0
                                            @endif
                                        </span>
                                    @else
                                         <span class="text-gray-400 dark:text-gray-500">{{ __('First Assessment') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- View Icon (Compact) --}}
                            <button onclick="openQuickView({{ $assessment->id }})" title="Lihat Detail" class="w-8 h-8 shrink-0 flex items-center justify-center rounded-md hover:bg-white dark:hover:bg-gray-600 transition text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white border border-transparent hover:border-gray-200 dark:hover:border-gray-500 bg-gray-100 dark:bg-gray-800/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Belum ada data penilaian') }}</p>
                    <a href="{{ route('user.assessment') }}" class="mt-4 inline-block px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition">
                        {{ __('Mulai Penilaian') }}
                    </a>
                </div>
            @endif
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-800/30 rounded-b-xl flex justify-center">
             <p class="text-xs text-gray-500 dark:text-gray-400 italic text-center">
                 "{{ __('Assessment history helps you understand stress patterns over time and build healthier stress management strategies.') }}"
             </p>
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
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('Export Riwayat Penilaian') }}</h3>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Preview semua riwayat penilaian sebelum mengunduh') }}</p>
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
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">{{ __('Document Preview') }}</p>
                </div>

                {{-- PDF Preview Content --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg">
                    <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-1">{{ __('Assessment History Report') }}</h2>
                    <p class="text-center text-sm text-teal-600 dark:text-teal-400 mb-6">{{ __('Student Stress Insight') }}</p>

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
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $totalAssessments }} {{ __('Assessments') }}</span>
                        </div>
                    </div>

                    {{-- Statistics Summary --}}
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded-lg text-center">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('Total') }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $totalAssessments }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded-lg text-center">
                            <p class="text-xs text-green-700 dark:text-green-400 mb-1">{{ __('Lowest') }}</p>
                            <p class="text-lg font-bold text-green-700 dark:text-green-400">{{ $lowestScore ?? '-' }}</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-3 rounded-lg text-center">
                            <p class="text-xs text-red-700 dark:text-red-400 mb-1">{{ __('Highest') }}</p>
                            <p class="text-lg font-bold text-red-700 dark:text-red-400">{{ $highestScore ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Assessment List Preview --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">{{ __('Assessment History:') }}</h3>
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            @foreach($assessments->take(5) as $assessment)
                                @php
                                    $score = $assessment->total_score;
                                    $category = $assessment->stress_category ?? 'Unknown';
                                    
                                    if ($category === 'No Stress' || $score < 30) {
                                        $badgeColor = 'bg-green-100 text-green-700';
                                        $badgeText = __('Low-Moderate');
                                    } elseif ($category === 'Eustress' || $score < 60) {
                                        $badgeColor = 'bg-blue-100 text-blue-700';
                                        $badgeText = __('Moderate');
                                    } else {
                                        $badgeColor = 'bg-red-100 text-red-700';
                                        $badgeText = __('High');
                                    }
                                @endphp
                                
                                <div class="flex items-center justify-between text-sm py-2 border-b border-gray-200 dark:border-gray-600">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $assessment->created_at->format('d F Y') }}</span>
                                    <span class="px-2 py-1 rounded text-xs {{ $badgeColor }}">{{ $badgeText }}</span>
                                </div>
                            @endforeach
                            
                            @if($assessments->count() > 5)
                                <p class="text-xs text-center text-gray-500 dark:text-gray-400 py-2">+{{ $assessments->count() - 5 }} {{ __('others') }}</p>
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
                {{ __('Cancel') }}
            </button>
            <a 
                href="{{ route('user.export.pdf') }}"
                class="px-6 py-2.5 bg-teal-500 text-white rounded-xl hover:bg-teal-600 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('Download PDF') }}
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
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('Assessment Detail') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5" id="quickview-datetime">{{ __('Loading data...') }}</p>
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
                <p class="text-gray-500 dark:text-gray-400">{{ __('Loading data...') }}</p>
            </div>

            {{-- Content --}}
            <div id="quickview-content" class="hidden space-y-6">
                {{-- Stress Category Badge --}}
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('Kategori Stres') }}</p>
                        <span id="quickview-category" class="px-4 py-2 rounded-lg text-sm font-semibold"></span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('Total Skor') }}</p>
                        <p id="quickview-score" class="text-3xl font-bold text-gray-900 dark:text-white"></p>
                    </div>
                </div>

                {{-- Mini Chart --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">{{ __('Answer Visualization') }}</h4>
                    <div class="grid grid-cols-5 gap-2" id="quickview-chart">
                        <!-- Chart will be populated by JavaScript -->
                    </div>
                    <div class="flex items-center justify-between mt-3 text-xs text-gray-500 dark:text-gray-400">
                        <span>{{ __('Never') }}</span>
                        <span>{{ __('Very Often') }}</span>
                    </div>
                </div>

                {{-- Recommendations --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">{{ __('Recommendations') }}</h4>
                    <div id="quickview-recommendations" class="space-y-2">
                        <!-- Recommendations will be populated by JavaScript -->
                    </div>
                </div>

                {{-- Top Concerns --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">{{ __('Key Areas of Concern') }}</h4>
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
                {{ __('Close') }}
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
                
                const answerLabels = ['{{ __("Never") }}', '{{ __("Rarely") }}', '{{ __("Sometimes") }}', '{{ __("Often") }}', '{{ __("Very Often") }}'];
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
                            <span class="px-2 py-1 bg-orange-200 dark:bg-orange-800 text-orange-800 dark:text-orange-200 rounded text-xs font-semibold">${concern.value === 3 ? '{{ __("Often") }}' : '{{ __("Very Often") }}'}</span>
                        `;
                        concernsContainer.appendChild(concernDiv);
                    });
                } else {
                    concernsContainer.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">{{ __("No specific areas of concern") }}</p>';
                }
                
                // Show content, hide loading
                loading.classList.add('hidden');
                content.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loading.innerHTML = '<p class="text-red-500">{{ __("Failed to load data. Please try again.") }}</p>';
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