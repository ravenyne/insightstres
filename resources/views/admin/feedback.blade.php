<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Feedback Management - Insight Stress</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-900 text-white">

    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
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
                <div>
                    <h1 class="text-3xl font-bold" data-i18n="page_title">{{ __('admin_feedback') }}</h1>
                    <p class="text-slate-400 mt-1" data-i18n="page_subtitle">{{ __('admin_feedback_subtitle') }}</p>
                </div>
            </header>

            <!-- Insight Panel -->
            <div class="p-8 pb-0">
                <div class="bg-gradient-to-r from-indigo-500/20 to-purple-500/20 border border-indigo-500/30 rounded-2xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-indigo-500/30 text-indigo-400 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2" data-i18n="insight_title">Insight Feedback Pengguna</h3>
                            <div class="text-slate-300 space-y-2">
                                <p data-i18n="insight_body">Mayoritas pengguna memberikan feedback positif terhadap fitur latihan pernapasan dan analisis stres.</p>
                                @php
                                    $avgRating = \App\Models\Feedback::whereNotNull('rating')->avg('rating');
                                @endphp
                                <p class="font-semibold text-indigo-300"><span data-i18n="insight_avg_rating">Rating rata-rata pengguna</span>: {{ number_format($avgRating ?: 0, 1) }} / 5</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4 lg:p-8">

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-400" data-i18n="stat_total">Total Feedback</p>
                                <p class="text-3xl font-bold mt-1">{{ $counts['all'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-400">New</p>
                                <p class="text-3xl font-bold text-orange-400 mt-1">{{ $counts['new'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-400">Reviewed</p>
                                <p class="text-3xl font-bold text-blue-400 mt-1">{{ $counts['reviewed'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-400">Resolved</p>
                                <p class="text-3xl font-bold text-green-400 mt-1">{{ $counts['resolved'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6 mb-6">
                    <form method="GET" action="{{ route('admin.feedback') }}" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition">
                                <option value="all">All Status</option>
                                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-slate-300 mb-2" data-i18n="filter_category">Kategori</label>
                            <select name="type" class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition">
                                <option value="all" data-i18n="opt_all_categories">Semua Kategori</option>
                                <option value="pengalaman_assessment" data-i18n="opt_pengalaman_assessment" {{ request('type') == 'pengalaman_assessment' ? 'selected' : '' }}>Pengalaman Assessment</option>
                                <option value="saran_fitur" data-i18n="opt_saran_fitur" {{ request('type') == 'saran_fitur' ? 'selected' : '' }}>Saran Fitur</option>
                                <option value="masalah_teknis" data-i18n="opt_masalah_teknis" {{ request('type') == 'masalah_teknis' ? 'selected' : '' }}>Masalah Teknis</option>
                                <option value="kualitas_konten" data-i18n="opt_kualitas_konten" {{ request('type') == 'kualitas_konten' ? 'selected' : '' }}>Kualitas Konten</option>
                                <option value="kesehatan_mental" data-i18n="opt_kesehatan_mental" {{ request('type') == 'kesehatan_mental' ? 'selected' : '' }}>Kesehatan Mental</option>
                            </select>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Rating</label>
                            <select name="rating" class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition">
                                <option value="all">All Ratings</option>
                                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐</option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐</option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐</option>
                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐</option>
                                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg transition">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Feedback Table -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-700">
                        <h3 class="text-lg font-bold" data-i18n="table_title" data-total="{{ $feedback->total() }}">Daftar Feedback ({{ $feedback->total() }})</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700 bg-slate-800/30">
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_user_subject">User & Subjek</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_category_feature">Kategori & Fitur</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_stress_condition">Kondisi Stress</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_priority">Prioritas</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">Status</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm whitespace-nowrap" data-i18n="col_date">Tanggal</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm" data-i18n="col_actions">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedback as $item)
                                    <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition">
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2 mb-2">
                                                <div class="w-8 h-8 bg-purple-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <span class="text-purple-400 font-semibold text-sm">{{ substr($item->user->name ?? 'U', 0, 1) }}</span>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-medium text-sm truncate">{{ $item->user->name ?? 'Anonymous' }}</p>
                                                    <p class="text-xs text-slate-400 truncate">{{ $item->user->email ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <p class="font-medium text-sm mt-2">{{ $item->subject }}</p>
                                            <p class="text-xs text-slate-400 mt-1">{{ Str::limit($item->message, 40) }}</p>
                                        </td>
                                        <td class="py-3 px-4">
                                            @php
                                                $typeColors = [
                                                    'pengalaman_assessment' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400'],
                                                    'saran_fitur' => ['bg' => 'bg-green-500/20', 'text' => 'text-green-400'],
                                                    'masalah_teknis' => ['bg' => 'bg-red-500/20', 'text' => 'text-red-400'],
                                                    'kualitas_konten' => ['bg' => 'bg-orange-500/20', 'text' => 'text-orange-400'],
                                                    'kesehatan_mental' => ['bg' => 'bg-purple-500/20', 'text' => 'text-purple-400']
                                                ];
                                                $typeColor = $typeColors[$item->type] ?? ['bg' => 'bg-gray-500/20', 'text' => 'text-gray-400'];
                                                $formattedType = ucwords(str_replace('_', ' ', $item->type));
                                            @endphp
                                            <span class="inline-block px-2 py-1 {{ $typeColor['bg'] }} {{ $typeColor['text'] }} text-xs font-semibold rounded-full whitespace-nowrap mb-1">
                                                {{ $formattedType }}
                                            </span>
                                            @if($item->related_feature)
                                                <div class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                    {{ $item->related_feature }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @php
                                                $stressColors = [
                                                    'Distress' => 'bg-red-500/20 text-red-500 border-red-500/30',
                                                    'Eustress' => 'bg-yellow-500/20 text-yellow-500 border-yellow-500/30',
                                                    'No Stress' => 'bg-emerald-500/20 text-emerald-500 border-emerald-500/30',
                                                ];
                                                $sColor = $stressColors[$item->stress_condition] ?? 'bg-slate-700/50 text-slate-400 border-slate-600';
                                            @endphp
                                            <span class="px-2 py-1 rounded text-xs font-medium border {{ $sColor }}">
                                                <span @if(!$item->stress_condition) data-i18n="not_tested" @endif>{{ $item->stress_condition ?? 'Belum Uji' }}</span>
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            @php
                                                $priorityBadge = ['text' => '-', 'class' => 'text-slate-500'];
                                                if ($item->rating) {
                                                    if ($item->rating <= 2) {
                                                        $priorityBadge = ['text' => 'Tinggi', 'key' => 'priority_high', 'class' => 'bg-red-500/10 text-red-400 border border-red-500/20'];
                                                    } elseif ($item->rating == 3) {
                                                        $priorityBadge = ['text' => 'Sedang', 'key' => 'priority_medium', 'class' => 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20'];
                                                    } else {
                                                        $priorityBadge = ['text' => 'Rendah', 'key' => 'priority_low', 'class' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'];
                                                    }
                                                }
                                            @endphp
                                            <span class="px-2 py-1 rounded text-xs font-medium {{ $priorityBadge['class'] }}" @if(isset($priorityBadge['key'])) data-i18n="{{ $priorityBadge['key'] }}" @endif>
                                                {{ $priorityBadge['text'] }}
                                            </span>
                                            @if($item->rating)
                                            <div class="flex items-center gap-0.5 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= $item->rating ? 'text-yellow-400 fill-yellow-400' : 'text-slate-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @php
                                                $statusColors = [
                                                    'new' => ['bg' => 'bg-orange-500/20', 'text' => 'text-orange-400'],
                                                    'reviewed' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400'],
                                                    'resolved' => ['bg' => 'bg-green-500/20', 'text' => 'text-green-400']
                                                ];
                                                $statusColor = $statusColors[$item->status] ?? ['bg' => 'bg-gray-500/20', 'text' => 'text-gray-400'];
                                            @endphp
                                            <span class="inline-block px-2 py-1 {{ $statusColor['bg'] }} {{ $statusColor['text'] }} text-xs font-semibold rounded-full whitespace-nowrap">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-xs text-slate-300 whitespace-nowrap">
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="relative inline-block text-left" x-data="{ open: false }" @click.outside="open = false">
                                                <button @click="open = !open" type="button" class="inline-flex items-center gap-2 px-3 py-2 bg-slate-700/50 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                    </svg>
                                                    <span class="hidden sm:inline">Actions</span>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div x-show="open" x-transition @click.stop class="absolute right-0 mt-2 w-56 bg-slate-800 border border-slate-700 rounded-lg shadow-xl z-50">
                                                    <div class="py-1">
                                                        <!-- View Details -->
                                                        <button onclick="viewFeedback({{ $item->id }})" class="w-full text-left px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white flex items-center gap-2 transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                            View Details
                                                        </button>

                                                        <!-- Divider -->
                                                        <div class="border-t border-slate-700 my-1"></div>

                                                        <!-- Quick Status Change -->
                                                        <div class="px-4 py-2">
                                                            <p class="text-xs text-slate-500 mb-2">Change Status</p>
                                                            <select onchange="updateStatus({{ $item->id }}, this.value)" class="w-full px-3 py-1.5 bg-slate-900/50 border border-slate-600 rounded text-sm text-white focus:outline-none focus:border-teal-500">
                                                                <option value="new" {{ $item->status == 'new' ? 'selected' : '' }}>New</option>
                                                                <option value="reviewed" {{ $item->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                                                <option value="resolved" {{ $item->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                                            </select>
                                                        </div>

                                                        <!-- Divider -->
                                                        <div class="border-t border-slate-700 my-1"></div>

                                                        <!-- Delete -->
                                                        <button onclick="deleteFeedback({{ $item->id }})" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 flex items-center gap-2 transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-slate-500">
                                            <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                            </svg>
                                            <p data-i18n="empty_state">Belum ada feedback pengguna</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($feedback->hasPages())
                        <div class="px-6 py-4 border-t border-slate-700">
                            {{ $feedback->links() }}
                        </div>
                    @endif
                </div>

            </div>

            <!-- Feedback Detail Modal -->
            <div id="feedbackModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                <div class="bg-slate-800 rounded-2xl border border-slate-700 max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                    <!-- Modal Header -->
                    <div class="sticky top-0 bg-slate-800 border-b border-slate-700 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white" data-i18n="modal_title">Detail Feedback</h3>
                        <button onclick="closeFeedbackModal()" class="p-2 hover:bg-slate-700 rounded-lg transition">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div id="feedbackModalContent" class="p-6 space-y-6">
                        <!-- Loading State -->
                        <div class="flex items-center justify-center py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-teal-500"></div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </div>

    <!-- Alpine.js for dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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

        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // Toast Notification Function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-[100] transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white font-medium`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        let currentLang = (localStorage.getItem('app_language') || 'id').toLowerCase();

        // View Feedback Details
        async function viewFeedback(id) {
            const modal = document.getElementById('feedbackModal');
            const content = document.getElementById('feedbackModalContent');
            
            modal.classList.remove('hidden');
            
            try {
                const response = await fetch(`/admin/feedback/${id}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const feedback = data.feedback;
                    const typeColors = {
                        'bug': { bg: 'bg-red-500/20', text: 'text-red-400' },
                        'feature': { bg: 'bg-blue-500/20', text: 'text-blue-400' },
                        'improvement': { bg: 'bg-green-500/20', text: 'text-green-400' },
                        'other': { bg: 'bg-gray-500/20', text: 'text-gray-400' }
                    };
                    const statusColors = {
                        'new': { bg: 'bg-orange-500/20', text: 'text-orange-400' },
                        'reviewed': { bg: 'bg-blue-500/20', text: 'text-blue-400' },
                        'resolved': { bg: 'bg-green-500/20', text: 'text-green-400' }
                    };
                    
                    const typeColor = typeColors[feedback.type] || typeColors.other;
                    const statusColor = statusColors[feedback.status] || statusColors.new;
                    
                    content.innerHTML = `
                        <!-- User Info -->
                        <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center">
                                    <span class="text-purple-400 font-semibold text-2xl">${(feedback.user?.name || 'U').charAt(0)}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-lg text-white">${feedback.user?.name || 'Anonymous'}</p>
                                    <p class="text-sm text-slate-400">${feedback.user?.email || 'N/A'}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Feedback Info -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-sm text-slate-400 mb-1">${i18nFeedback[currentLang]?.modal_category || 'Kategori'}</p>
                                <span class="inline-block px-3 py-1 ${typeColor.bg} ${typeColor.text} text-sm font-semibold rounded-full whitespace-nowrap">
                                    ${feedback.type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-slate-400 mb-1">${i18nFeedback[currentLang]?.modal_related_feature || 'Fitur Terkait'}</p>
                                <span class="text-slate-200 font-medium">${feedback.related_feature || '-'}</span>
                            </div>
                            <div>
                                <p class="text-sm text-slate-400 mb-1">${i18nFeedback[currentLang]?.modal_stress_condition || 'Kondisi Stress'}</p>
                                <span class="text-slate-200 font-medium">${feedback.stress_condition || (i18nFeedback[currentLang]?.not_detected || 'Belum Terdeteksi')}</span>
                            </div>
                            <div>
                                <p class="text-sm text-slate-400 mb-1">${i18nFeedback[currentLang]?.modal_status || 'Status'}</p>
                                <span class="inline-block px-3 py-1 ${statusColor.bg} ${statusColor.text} text-sm font-semibold rounded-full">
                                    ${feedback.status.charAt(0).toUpperCase() + feedback.status.slice(1)}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-slate-400 mb-1">${i18nFeedback[currentLang]?.modal_rating || 'Rating'}</p>
                                <div class="flex items-center gap-1">
                                    ${feedback.rating ? Array.from({length: 5}, (_, i) => 
                                        `<svg class="w-5 h-5 ${i < feedback.rating ? 'text-yellow-400 fill-yellow-400' : 'text-slate-600'}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>`
                                    ).join('') : '<span class="text-slate-500 text-sm">' + (i18nFeedback[currentLang]?.no_rating || 'No rating') + '</span>'}
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-slate-400 mb-1">${i18nFeedback[currentLang]?.modal_date || 'Tanggal'}</p>
                                <p class="text-white">${new Date(feedback.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</p>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <p class="text-sm text-slate-400 mb-2">${i18nFeedback[currentLang]?.modal_subject || 'Subjek'}</p>
                            <p class="text-white font-medium text-lg">${feedback.subject}</p>
                        </div>

                        <!-- Message -->
                        <div>
                            <p class="text-sm text-slate-400 mb-2">${i18nFeedback[currentLang]?.modal_message || 'Pesan'}</p>
                            <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700">
                                <p class="text-slate-300 whitespace-pre-wrap">${feedback.message}</p>
                            </div>
                        </div>

                        <!-- Page URL -->
                        ${feedback.page_url ? `
                        <div>
                            <p class="text-sm text-slate-400 mb-2">${i18nFeedback[currentLang]?.modal_page_url || 'URL Halaman'}</p>
                            <a href="${feedback.page_url}" target="_blank" class="text-teal-400 hover:text-teal-300 text-sm break-all">
                                ${feedback.page_url}
                            </a>
                        </div>
                        ` : ''}

                        <!-- Admin Notes -->
                        <div>
                            <p class="text-sm text-slate-400 mb-2">Admin Notes</p>
                            <textarea id="adminNotes" rows="4" class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition" placeholder="Add internal notes...">${feedback.admin_notes || ''}</textarea>
                            <button onclick="saveAdminNotes(${feedback.id})" class="mt-2 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition">
                                Save Notes
                            </button>
                        </div>
                    `;
                } else {
                    content.innerHTML = '<p class="text-red-400 text-center py-8">Failed to load feedback details</p>';
                }
            } catch (error) {
                console.error('Error fetching feedback:', error);
                content.innerHTML = '<p class="text-red-400 text-center py-8">Error loading feedback details</p>';
            }
        }

        // Close Modal
        function closeFeedbackModal() {
            document.getElementById('feedbackModal').classList.add('hidden');
        }

        // Save Admin Notes
        async function saveAdminNotes(id) {
            const notes = document.getElementById('adminNotes').value;
            
            try {
                const response = await fetch(`/admin/feedback/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: document.querySelector(`select[onchange*="${id}"]`)?.value || 'new',
                        admin_notes: notes
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Admin notes saved successfully');
                } else {
                    showToast('Failed to save notes', 'error');
                }
            } catch (error) {
                console.error('Error saving notes:', error);
                showToast('Error saving notes', 'error');
            }
        }

        // Update Status
        async function updateStatus(id, status) {
            try {
                const response = await fetch(`/admin/feedback/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Status updated successfully');
                    // Reload page to update the status badge
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Failed to update status', 'error');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                showToast('Error updating status', 'error');
            }
        }

        // Delete Feedback
        async function deleteFeedback(id) {
            if (!confirm('Are you sure you want to delete this feedback? This action cannot be undone.')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/feedback/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Feedback deleted successfully');
                    // Reload page to update the list
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Failed to delete feedback', 'error');
                }
            } catch (error) {
                console.error('Error deleting feedback:', error);
                showToast('Error deleting feedback', 'error');
            }
        }

        // Close modal on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeFeedbackModal();
            }
        });

        
        // ===== FEEDBACK PAGE i18n =====
        const i18nFeedback = {
            id: {
                page_title: 'Feedback Pengguna',
                page_subtitle: 'Kelola dan analisis feedback dari pengguna platform',
                insight_title: 'Insight Feedback Pengguna',
                insight_body: 'Mayoritas pengguna memberikan feedback positif terhadap fitur latihan pernapasan dan analisis stres. Beberapa pengguna juga menyarankan peningkatan pada pengalaman pengisian assessment agar lebih nyaman digunakan.',
                insight_avg_rating: 'Rating rata-rata pengguna',
                stat_total: 'Total Feedback',
                filter_category: 'Kategori',
                opt_all_categories: 'Semua Kategori',
                opt_pengalaman_assessment: 'Pengalaman Assessment',
                opt_saran_fitur: 'Saran Fitur',
                opt_masalah_teknis: 'Masalah Teknis',
                opt_kualitas_konten: 'Kualitas Konten',
                opt_kesehatan_mental: 'Kesehatan Mental',
                table_title: 'Daftar Feedback',
                col_user_subject: 'User & Subjek',
                col_category_feature: 'Kategori & Fitur',
                col_stress_condition: 'Kondisi Stress',
                col_priority: 'Prioritas',
                col_actions: 'Aksi',
                col_date: 'Tanggal',
                priority_high: 'Tinggi',
                priority_medium: 'Sedang',
                priority_low: 'Rendah',
                not_tested: 'Belum Uji',
                empty_state: 'Belum ada feedback pengguna',
                modal_title: 'Detail Feedback',
                modal_subtitle: 'Informasi lengkap feedback pengguna',
                modal_category: 'Kategori',
                modal_related_feature: 'Fitur Terkait',
                modal_stress_condition: 'Kondisi Stress',
                modal_status: 'Status',
                modal_rating: 'Rating',
                modal_date: 'Tanggal',
                modal_subject: 'Subjek',
                modal_message: 'Pesan',
                modal_page_url: 'URL Halaman',
                not_detected: 'Belum Terdeteksi',
                no_rating: 'Tidak ada rating',
                btn_view_details: 'Lihat Detail',
                btn_close: 'Tutup',
            },
            en: {
                page_title: 'User Feedback',
                page_subtitle: 'Manage and analyze feedback from platform users',
                insight_title: 'User Feedback Insight',
                insight_body: 'Most users provided positive feedback regarding the breathing exercise feature and stress analytics. Several users also suggested improvements to the assessment experience to make it more comfortable to use.',
                insight_avg_rating: 'Average user rating',
                stat_total: 'Total Feedback',
                filter_category: 'Category',
                opt_all_categories: 'All Categories',
                opt_pengalaman_assessment: 'Assessment Experience',
                opt_saran_fitur: 'Feature Suggestions',
                opt_masalah_teknis: 'Technical Issues',
                opt_kualitas_konten: 'Content Quality',
                opt_kesehatan_mental: 'Mental Health',
                table_title: 'Feedback List',
                col_user_subject: 'User & Subject',
                col_category_feature: 'Category & Feature',
                col_stress_condition: 'Stress Condition',
                col_priority: 'Priority',
                col_actions: 'Actions',
                col_date: 'Date',
                priority_high: 'High',
                priority_medium: 'Medium',
                priority_low: 'Low',
                not_tested: 'Not Tested',
                empty_state: 'No user feedback available',
                modal_title: 'Feedback Details',
                modal_subtitle: 'Complete information about user feedback',
                modal_category: 'Category',
                modal_related_feature: 'Related Feature',
                modal_stress_condition: 'Stress Condition',
                modal_status: 'Status',
                modal_rating: 'Rating',
                modal_date: 'Date',
                modal_subject: 'Subject',
                modal_message: 'Message',
                modal_page_url: 'Page URL',
                not_detected: 'Not Detected',
                no_rating: 'No rating',
                btn_view_details: 'View Details',
                btn_close: 'Close',
            }
        };

        function applyFeedbackI18n() {
            currentLang = (localStorage.getItem('app_language') || 'id').toLowerCase();
            const t = i18nFeedback[currentLang] || i18nFeedback['id'];

            // data-i18n text elements
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key] !== undefined) {
                    // Special handling for table_title which has a count
                    if (key === 'table_title') {
                        const total = el.getAttribute('data-total') || '';
                        el.textContent = t[key] + (total ? ' (' + total + ')' : '');
                    } else {
                        el.textContent = t[key];
                    }
                }
            });

            // Update document title
            document.title = t['page_title'] + ' - Insight Stress';
        }

        applyFeedbackI18n();

        window.addEventListener('storage', function(e) {
            if (e.key === 'app_language') {
                currentLang = (localStorage.getItem('app_language') || 'id').toLowerCase();
                applyFeedbackI18n();
            }
        });

        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>

</body>
</html>
