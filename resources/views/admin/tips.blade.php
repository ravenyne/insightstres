<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intervensi & Edukasi Kesehatan Mental - Insight Stress</title>
    @vite('resources/css/app.css')
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
            
            <!-- Header (Desktop) -->
            <header class="hidden lg:block bg-slate-800/30 border-b border-slate-700 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold" data-i18n="page_title">Intervensi & Edukasi Kesehatan Mental</h1>
                        <p class="text-slate-400 mt-1" data-i18n="page_subtitle">Kelola konten intervensi dan edukasi untuk mahasiswa</p>
                    </div>
                    <a href="{{ route('admin.tips.create') }}" class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span data-i18n="btn_add_new">Tambah Artikel Baru</span>
                    </a>
                </div>
            </header>

            <!-- Content -->
            <div class="p-4 lg:p-8">

                <!-- Mobile Action Button -->
                <div class="lg:hidden mb-6">
                    <a href="{{ route('admin.tips.create') }}" class="w-full px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span data-i18n="btn_add_new">Tambah Artikel Baru</span>
                    </a>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-500/20 border border-green-500 text-green-400 px-6 py-4 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-500/20 border border-red-500 text-red-400 px-6 py-4 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Search & Filter Bar -->
                <div class="mb-6 flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="searchInput"
                                placeholder="Cari berdasarkan judul atau konten..."
                                data-i18n-placeholder="search_placeholder"
                                class="w-full pl-12 pr-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition"
                            >
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="w-full md:w-64">
                        <select 
                            id="categoryFilter"
                            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition"
                        >
                            <option value="all" data-i18n="cat_all">Semua Kategori</option>
                            <option value="breathing" data-i18n="cat_breathing">Pernapasan</option>
                            <option value="sleep" data-i18n="cat_sleep">Tidur</option>
                            <option value="exercise" data-i18n="cat_exercise">Olahraga</option>
                            <option value="mindfulness" data-i18n="cat_mindfulness">Mindfulness</option>
                            <option value="study" data-i18n="cat_study">Belajar</option>
                            <option value="general" data-i18n="cat_general">Umum</option>
                        </select>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
                    @php
                        $categoryStats = [
                            'all' => ['label_id' => 'Total', 'label_en' => 'Total', 'cat_key' => 'cat_all', 'count' => $categories['all'], 'color' => 'slate'],
                            'breathing' => ['label_id' => 'Pernapasan', 'label_en' => 'Breathing', 'cat_key' => 'cat_breathing', 'count' => $categories['breathing'], 'color' => 'blue'],
                            'sleep' => ['label_id' => 'Tidur', 'label_en' => 'Sleep', 'cat_key' => 'cat_sleep', 'count' => $categories['sleep'], 'color' => 'purple'],
                            'exercise' => ['label_id' => 'Olahraga', 'label_en' => 'Exercise', 'cat_key' => 'cat_exercise', 'count' => $categories['exercise'], 'color' => 'green'],
                            'mindfulness' => ['label_id' => 'Mindfulness', 'label_en' => 'Mindfulness', 'cat_key' => 'cat_mindfulness', 'count' => $categories['mindfulness'], 'color' => 'teal'],
                            'study' => ['label_id' => 'Belajar', 'label_en' => 'Study', 'cat_key' => 'cat_study', 'count' => $categories['study'], 'color' => 'orange'],
                            'general' => ['label_id' => 'Umum', 'label_en' => 'General', 'cat_key' => 'cat_general', 'count' => $categories['general'], 'color' => 'gray'],
                        ];
                    @endphp

                    @foreach($categoryStats as $key => $stat)
                        <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
                            <p class="text-slate-400 text-xs mb-1" data-i18n="{{ $stat['cat_key'] }}">{{ $stat['label_id'] }}</p>
                            <p class="text-2xl font-bold text-{{ $stat['color'] }}-400">{{ $stat['count'] }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Table -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl overflow-hidden">
                    
                    <div class="px-6 py-4 border-b border-slate-700">
                        <h3 class="text-lg font-bold" data-i18n="table_title">Daftar Materi Intervensi ({{ $tips->total() }})</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700 bg-slate-800/30">
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm" data-i18n="col_title_category">Judul & Kategori</th>
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm" data-i18n="col_target_condition">Target Kondisi</th>
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm" data-i18n="col_additional_labels">Label Tambahan</th>
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm" data-i18n="col_statistics">Statistik</th>
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm" data-i18n="col_action">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tipsTableBody">
                                @forelse($tips as $tip)
                                    <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition" data-category="{{ $tip->category }}">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                @php
                                                    $iconConfig = [
                                                        'breathing' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>'], // Wind approx
                                                        'sleep' => ['bg' => 'bg-purple-500/20', 'text' => 'text-purple-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>'], // Moon
                                                        'exercise' => ['bg' => 'bg-green-500/20', 'text' => 'text-green-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>'], // Activity/Zap
                                                        'mindfulness' => ['bg' => 'bg-teal-500/20', 'text' => 'text-teal-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>'], // Heart/Mind
                                                        'study' => ['bg' => 'bg-orange-500/20', 'text' => 'text-orange-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>'], // Lightbulb
                                                        'general' => ['bg' => 'bg-gray-500/20', 'text' => 'text-gray-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>'], // Archive/General
                                                    ];
                                                    $config = $iconConfig[$tip->category] ?? ['bg' => 'bg-gray-500/20', 'text' => 'text-gray-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'];
                                                @endphp
                                                <div class="w-10 h-10 rounded-lg {{ $config['bg'] }} flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 {{ $config['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        {!! $config['svg'] !!}
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-white mb-1" data-title-id="{{ addslashes(Str::limit($tip->title_id, 40)) }}" data-title-en="{{ addslashes(Str::limit($tip->title_en, 40)) }}">
                                                        {{ Str::limit($tip->title_id, 40) }}
                                                    </p>
                                                    <div class="flex items-center gap-2">
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wider bg-slate-700 text-slate-300" data-i18n="cat_{{ strtolower($tip->category) }}">
                                                            {{ $tip->category }}
                                                        </span>
                                                        @if($tip->read_duration)
                                                            <span class="text-xs text-slate-400 flex items-center gap-1">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                {{ $tip->read_duration }} <span data-i18n="mins">mnt</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            @php
                                                $targetColors = [
                                                    'Distress' => 'bg-red-500/20 text-red-500 border border-red-500/30',
                                                    'Eustress' => 'bg-yellow-500/20 text-yellow-500 border border-yellow-500/30',
                                                    'Semua Kondisi' => 'bg-slate-700/50 text-slate-300 border border-slate-600',
                                                ];
                                                $tCondition = $tip->target_condition ?? 'Semua Kondisi';
                                                $tColor = $targetColors[$tCondition] ?? 'bg-slate-700/50 text-slate-300 border border-slate-600';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $tColor }}" @if($tCondition === 'Semua Kondisi') data-i18n="all_conditions" @endif>
                                                {{ $tCondition }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 space-y-1.5 flex flex-col items-start">
                                            @if($tip->is_evidence_based)
                                                <span class="px-2 py-1 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    <span data-i18n="lbl_evidence_based">Evidence-based</span>
                                                </span>
                                            @endif
                                            @if($tip->is_ai_recommended)
                                                <span class="px-2 py-1 rounded text-xs font-medium bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                    <span data-i18n="lbl_ai_recommended">Direkomendasikan AI</span>
                                                </span>
                                            @endif
                                            @if(!$tip->is_evidence_based && !$tip->is_ai_recommended)
                                                <span class="text-xs text-slate-500">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-slate-300">
                                            <div class="flex items-center gap-2 text-sm text-slate-400 mb-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                {{ number_format($tip->views) }} views
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                {{ $tip->created_at->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-2">
                                                <!-- Edit -->
                                                <a href="{{ route('admin.tips.edit', $tip->id) }}" class="p-2 hover:bg-slate-700 rounded-lg transition" title="Edit">
                                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                
                                                <!-- Delete -->
                                                <button onclick="confirmDelete({{ $tip->id }}, '{{ addslashes($tip->title_id) }}')" class="p-2 hover:bg-red-500/10 rounded-lg transition" title="Hapus">
                                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-500">
                                            <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                            <p data-i18n="empty_state">Belum ada materi intervensi & edukasi</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($tips->hasPages())
                        <div class="px-6 py-4 border-t border-slate-700">
                            <!-- Custom dark mode styling wrapper for default Laravel pagination -->
                            <style>
                                .pagination { display: flex; padding-left: 0; list-style: none; gap: 0.25rem; }
                                .page-item .page-link { position: relative; display: block; padding: 0.5rem 0.75rem; background-color: #1E293B; border: 1px solid #334155; border-radius: 0.375rem; color: #cbd5e1; transition: all 0.2s; }
                                .page-item.active .page-link { z-index: 3; background-color: #14B8A6; border-color: #14B8A6; color: white; }
                                .page-item.disabled .page-link { color: #64748b; pointer-events: none; background-color: #0f172a; border-color: #1e293b; }
                                .page-item .page-link:hover { z-index: 2; background-color: #334155; border-color: #475569; color: white; }
                            </style>
                            <div class="flex items-center justify-between">
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div class="text-sm text-slate-400">
                                        <span data-i18n="pagination_showing">Menampilkan</span> {{ $tips->firstItem() ?? 0 }} <span data-i18n="pagination_to">hingga</span> {{ $tips->lastItem() ?? 0 }} <span data-i18n="pagination_of">dari</span> {{ $tips->total() }} <span data-i18n="pagination_entries">materi</span>
                                    </div>
                                    <div>
                                        {{ $tips->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </main>

    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl max-w-md w-full shadow-2xl">
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white" data-i18n="modal_delete_title">Konfirmasi Hapus</h3>
                        <p class="text-sm text-slate-400 mt-1" data-i18n="modal_delete_desc">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-slate-300"><span data-i18n="modal_delete_confirm">Apakah Anda yakin ingin menghapus artikel</span> <span id="deleteTipTitle" class="font-semibold text-white"></span>?</p>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-slate-700 bg-slate-800/50">
                <button 
                    onclick="closeDeleteModal()"
                    class="px-6 py-2.5 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-lg transition"
                    data-i18n="btn_cancel"
                >
                    Batal
                </button>
                <form id="deleteForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit"
                        class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span data-i18n="btn_delete_article">Hapus Artikel</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle functionality
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

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterTable();
        });

        // Category filter
        document.getElementById('categoryFilter').addEventListener('change', function(e) {
            filterTable();
        });

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const rows = document.querySelectorAll('#tipsTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const category = row.getAttribute('data-category');
                
                const matchesSearch = text.includes(searchTerm);
                const matchesCategory = categoryFilter === 'all' || category === categoryFilter;
                
                row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
            });
        }

        // Delete confirmation
        function confirmDelete(tipId, tipTitle) {
            document.getElementById('deleteTipTitle').textContent = tipTitle;
            document.getElementById('deleteForm').action = `/admin/tips/${tipId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>

    <script>
        // ===== MULTI-LANGUAGE (i18n) SYSTEM =====
        const i18nTips = {
            id: {
                page_title: 'Intervensi & Edukasi Kesehatan Mental',
                page_subtitle: 'Kelola konten intervensi dan edukasi untuk mahasiswa',
                btn_add_new: 'Tambah Artikel Baru',
                search_placeholder: 'Cari berdasarkan judul atau konten...',
                cat_all: 'Semua Kategori',
                cat_breathing: 'Pernapasan',
                cat_sleep: 'Tidur',
                cat_exercise: 'Olahraga',
                cat_mindfulness: 'Mindfulness',
                cat_study: 'Belajar',
                cat_general: 'Umum',
                table_title: 'Daftar Materi Intervensi',
                col_title_category: 'Judul & Kategori',
                col_target_condition: 'Target Kondisi',
                col_additional_labels: 'Label Tambahan',
                col_statistics: 'Statistik',
                col_action: 'Aksi',
                mins: 'mnt',
                all_conditions: 'Semua Kondisi',
                lbl_evidence_based: 'Evidence-based',
                lbl_ai_recommended: 'Direkomendasikan AI',
                empty_state: 'Belum ada materi intervensi & edukasi',
                pagination_showing: 'Menampilkan',
                pagination_to: 'hingga',
                pagination_of: 'dari',
                pagination_entries: 'materi',
                modal_delete_title: 'Konfirmasi Hapus',
                modal_delete_desc: 'Tindakan ini tidak dapat dibatalkan',
                modal_delete_confirm: 'Apakah Anda yakin ingin menghapus artikel',
                btn_cancel: 'Batal',
                btn_delete_article: 'Hapus Artikel'
            },
            en: {
                page_title: 'Mental Health Intervention & Education',
                page_subtitle: 'Manage intervention and education content for students',
                btn_add_new: 'Add New Article',
                search_placeholder: 'Search by title or content...',
                cat_all: 'All Categories',
                cat_breathing: 'Breathing',
                cat_sleep: 'Sleep',
                cat_exercise: 'Exercise',
                cat_mindfulness: 'Mindfulness',
                cat_study: 'Study',
                cat_general: 'General',
                table_title: 'Intervention Materials List',
                col_title_category: 'Title & Category',
                col_target_condition: 'Target Condition',
                col_additional_labels: 'Additional Labels',
                col_statistics: 'Statistics',
                col_action: 'Actions',
                mins: 'mins',
                all_conditions: 'All Conditions',
                lbl_evidence_based: 'Evidence-based',
                lbl_ai_recommended: 'AI Recommended',
                empty_state: 'No intervention & education materials available',
                pagination_showing: 'Showing',
                pagination_to: 'to',
                pagination_of: 'of',
                pagination_entries: 'entries',
                modal_delete_title: 'Confirm Delete',
                modal_delete_desc: 'This action cannot be undone',
                modal_delete_confirm: 'Are you sure you want to delete the article',
                btn_cancel: 'Cancel',
                btn_delete_article: 'Delete Article'
            }
        };

        function applyTipsI18n() {
            const lang = (localStorage.getItem('app_language') || 'id').toLowerCase();
            const t = i18nTips[lang] || i18nTips['id'];

            // Text elements
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key] !== undefined) {
                    // Specific handling if the element contains nested elements we don't want to overwrite completely,
                    // but for data-i18n spans it usually only has text.
                    el.textContent = t[key];
                }
            });

            // Placeholder elements
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (t[key] !== undefined) el.placeholder = t[key];
            });

            // Handle table title that has dynamic count
            const tableTitleEl = document.querySelector('[data-i18n="table_title"]');
            if (tableTitleEl) {
                const countMatch = tableTitleEl.textContent.match(/\(\d+\)/);
                const count = countMatch ? ` ${countMatch[0]}` : '';
                tableTitleEl.textContent = t['table_title'] + count;
            }

            // Switch article titles based on language
            document.querySelectorAll('[data-title-id]').forEach(el => {
                el.textContent = lang === 'en'
                    ? (el.getAttribute('data-title-en') || el.getAttribute('data-title-id'))
                    : el.getAttribute('data-title-id');
            });

            // Update document title for global translation
            if (t['page_title']) {
                document.title = t['page_title'] + ' - Insight Stress';
            }
        }

        applyTipsI18n();

        // React to language changes from other tabs / pages
        window.addEventListener('storage', function(e) {
            if (e.key === 'app_language') applyTipsI18n();
        });
    </script>
</body>
</html>
