@extends('layouts.dashboard')

@section('content')
<script src="https://unpkg.com/lucide@latest"></script>

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tips & Artikel</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Panduan praktis untuk mengelola stress</p>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
        <form action="{{ route('user.tips') }}" method="GET" class="flex gap-3">
            <div class="flex-1 relative">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search ?? '' }}"
                    placeholder="Cari tips..." 
                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition">
                Cari
            </button>
        </form>
    </div>

    {{-- Category Filter --}}
    <div class="flex gap-3 overflow-x-auto pb-2">
        <a href="{{ route('user.tips') }}" 
           class="px-4 py-2 rounded-lg font-medium whitespace-nowrap transition
           {{ !request('category') || request('category') == 'all' ? 'bg-teal-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            Semua ({{ $categories['all'] }})
        </a>
        <a href="{{ route('user.tips', ['category' => 'breathing']) }}" 
           class="px-4 py-2 rounded-lg font-medium whitespace-nowrap transition flex items-center gap-2
           {{ request('category') == 'breathing' ? 'bg-teal-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="wind" class="w-4 h-4"></i>
            Pernapasan ({{ $categories['breathing'] }})
        </a>
        <a href="{{ route('user.tips', ['category' => 'sleep']) }}" 
           class="px-4 py-2 rounded-lg font-medium whitespace-nowrap transition flex items-center gap-2
           {{ request('category') == 'sleep' ? 'bg-teal-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="moon" class="w-4 h-4"></i>
            Tidur ({{ $categories['sleep'] }})
        </a>
        <a href="{{ route('user.tips', ['category' => 'exercise']) }}" 
           class="px-4 py-2 rounded-lg font-medium whitespace-nowrap transition flex items-center gap-2
           {{ request('category') == 'exercise' ? 'bg-teal-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="activity" class="w-4 h-4"></i>
            Olahraga ({{ $categories['exercise'] }})
        </a>
        <a href="{{ route('user.tips', ['category' => 'mindfulness']) }}" 
           class="px-4 py-2 rounded-lg font-medium whitespace-nowrap transition flex items-center gap-2
           {{ request('category') == 'mindfulness' ? 'bg-teal-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="sparkles" class="w-4 h-4"></i>
            Mindfulness ({{ $categories['mindfulness'] }})
        </a>
        <a href="{{ route('user.tips', ['category' => 'study']) }}" 
           class="px-4 py-2 rounded-lg font-medium whitespace-nowrap transition flex items-center gap-2
           {{ request('category') == 'study' ? 'bg-teal-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="book-open" class="w-4 h-4"></i>
            Belajar ({{ $categories['study'] }})
        </a>
        <a href="{{ route('user.tips', ['category' => 'general']) }}" 
           class="px-4 py-2 rounded-lg font-medium whitespace-nowrap transition flex items-center gap-2
           {{ request('category') == 'general' ? 'bg-teal-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            <i data-lucide="lightbulb" class="w-4 h-4"></i>
            Umum ({{ $categories['general'] }})
        </a>
    </div>

    {{-- Tips Grid --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tips as $tip)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-lg bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-400 flex items-center justify-center flex-shrink-0">
                        @if(($tip->icon ?? 'lightbulb') == 'square')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><rect width="18" height="18" x="3" y="3" rx="2" /></svg>
                        @else
                            <i data-lucide="{{ $tip->icon ?? 'lightbulb' }}" class="w-6 h-6"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $tip->title }}</h3>
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                            {{ ucfirst($tip->category) }}
                        </span>
                    </div>
                </div>
                
                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 flex-1 line-clamp-3">
                    {{ Str::limit($tip->content, 150) }}
                </p>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                        <span>{{ $tip->views }}</span>
                    </div>
                    <button onclick="showTipDetail({{ $tip->id }})" class="text-teal-600 dark:text-teal-400 hover:underline text-sm font-medium">
                        Baca Selengkapnya →
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i data-lucide="search-x" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400">Tidak ada tips ditemukan</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($tips->hasPages())
        <div class="mt-6">
            {{ $tips->links() }}
        </div>
    @endif
</div>

{{-- Tip Detail Modal --}}
<div id="tipDetailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-6 flex items-center justify-between">
            <h2 id="tipDetailTitle" class="text-2xl font-bold text-gray-900 dark:text-white"></h2>
            <button onclick="closeTipDetail()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                <i data-lucide="x" class="w-6 h-6 text-gray-600 dark:text-gray-400"></i>
            </button>
        </div>
        
        <div class="p-6">
            <div id="tipDetailCategory" class="mb-4"></div>
            <div id="tipDetailContent" class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed"></div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    function showTipDetail(tipId) {
        // Fetch tip details
        fetch(`/tips/${tipId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('tipDetailTitle').textContent = data.title;
                
                let iconHtml;
                if ((data.icon || 'lightbulb') === 'square') {
                    iconHtml = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><rect width="18" height="18" x="3" y="3" rx="2" /></svg>';
                } else {
                    iconHtml = `<i data-lucide="${data.icon || 'lightbulb'}" class="w-4 h-4"></i>`;
                }

                document.getElementById('tipDetailCategory').innerHTML = `
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-300 text-sm font-medium">
                        ${iconHtml}
                        ${data.category.charAt(0).toUpperCase() + data.category.slice(1)}
                    </span>
                `;
                document.getElementById('tipDetailContent').textContent = data.content;
                
                document.getElementById('tipDetailModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                lucide.createIcons();
            });
    }

    function closeTipDetail() {
        document.getElementById('tipDetailModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close on outside click
    document.getElementById('tipDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeTipDetail();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeTipDetail();
        }
    });
</script>

@endsection
