<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Insight & Edukasi - Insight Stress</title>
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
            <header class="hidden lg:block bg-slate-800/30 border-b border-slate-700 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Kelola Tips & Artikel</h1>
                        <p class="text-slate-400 mt-1">Kelola konten tips dan artikel untuk mahasiswa</p>
                    </div>
                    <a href="{{ route('admin.tips.create') }}" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Artikel Baru
                    </a>
                </div>
            </header>

            <!-- Content -->
            <div class="p-4 lg:p-8">

                <!-- Mobile Action Button -->
                <div class="lg:hidden mb-6">
                    <a href="{{ route('admin.tips.create') }}" class="w-full px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Artikel Baru
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
                                class="w-full pl-12 pr-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                            >
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="w-full md:w-64">
                        <select 
                            id="categoryFilter"
                            class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                        >
                            <option value="all">Semua Kategori</option>
                            <option value="breathing">Pernapasan</option>
                            <option value="sleep">Tidur</option>
                            <option value="exercise">Olahraga</option>
                            <option value="mindfulness">Mindfulness</option>
                            <option value="study">Belajar</option>
                            <option value="general">Umum</option>
                        </select>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
                    @php
                        $categoryStats = [
                            'all' => ['label' => 'Total', 'count' => $categories['all'], 'color' => 'slate'],
                            'breathing' => ['label' => 'Pernapasan', 'count' => $categories['breathing'], 'color' => 'blue'],
                            'sleep' => ['label' => 'Tidur', 'count' => $categories['sleep'], 'color' => 'purple'],
                            'exercise' => ['label' => 'Olahraga', 'count' => $categories['exercise'], 'color' => 'green'],
                            'mindfulness' => ['label' => 'Mindfulness', 'count' => $categories['mindfulness'], 'color' => 'teal'],
                            'study' => ['label' => 'Belajar', 'count' => $categories['study'], 'color' => 'orange'],
                            'general' => ['label' => 'Umum', 'count' => $categories['general'], 'color' => 'gray'],
                        ];
                    @endphp

                    @foreach($categoryStats as $key => $stat)
                        <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
                            <p class="text-slate-400 text-xs mb-1">{{ $stat['label'] }}</p>
                            <p class="text-2xl font-bold text-{{ $stat['color'] }}-400">{{ $stat['count'] }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Table -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl overflow-hidden">
                    
                    <div class="px-6 py-4 border-b border-slate-700">
                        <h3 class="text-lg font-bold">Daftar Tips & Artikel ({{ $tips->total() }})</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700 bg-slate-800/30">
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm">Judul</th>
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm">Kategori</th>
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm">Views</th>
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm">Dibuat</th>
                                    <th class="text-left py-4 px-6 text-slate-400 font-medium text-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tipsTableBody">
                                @forelse($tips as $tip)
                                    <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition" data-category="{{ $tip->category }}">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                @php
                                                    $iconColors = [
                                                        'breathing' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400'],
                                                        'sleep' => ['bg' => 'bg-purple-500/20', 'text' => 'text-purple-400'],
                                                        'exercise' => ['bg' => 'bg-green-500/20', 'text' => 'text-green-400'],
                                                        'mindfulness' => ['bg' => 'bg-teal-500/20', 'text' => 'text-teal-400'],
                                                        'study' => ['bg' => 'bg-orange-500/20', 'text' => 'text-orange-400'],
                                                        'general' => ['bg' => 'bg-gray-500/20', 'text' => 'text-gray-400'],
                                                    ];
                                                    $iconColor = $iconColors[$tip->category] ?? ['bg' => 'bg-gray-500/20', 'text' => 'text-gray-400'];
                                                @endphp
                                                <div class="w-10 h-10 rounded-lg {{ $iconColor['bg'] }} flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 {{ $iconColor['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-medium">{{ Str::limit($tip->title, 50) }}</p>
                                                    <p class="text-sm text-slate-400">{{ Str::limit(strip_tags($tip->content), 60) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            @php
                                                $categoryBadges = [
                                                    'breathing' => ['text' => 'Pernapasan', 'class' => 'bg-blue-500/20 text-blue-400'],
                                                    'sleep' => ['text' => 'Tidur', 'class' => 'bg-purple-500/20 text-purple-400'],
                                                    'exercise' => ['text' => 'Olahraga', 'class' => 'bg-green-500/20 text-green-400'],
                                                    'mindfulness' => ['text' => 'Mindfulness', 'class' => 'bg-teal-500/20 text-teal-400'],
                                                    'study' => ['text' => 'Belajar', 'class' => 'bg-orange-500/20 text-orange-400'],
                                                    'general' => ['text' => 'Umum', 'class' => 'bg-gray-500/20 text-gray-400'],
                                                ];
                                                $badge = $categoryBadges[$tip->category] ?? ['text' => 'Unknown', 'class' => 'bg-gray-500/20 text-gray-400'];
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badge['class'] }}">
                                                {{ $badge['text'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-slate-300">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <span>{{ number_format($tip->views) }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-slate-300">
                                            {{ $tip->created_at->format('d M Y') }}
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
                                                <button onclick="confirmDelete({{ $tip->id }}, '{{ addslashes($tip->title) }}')" class="p-2 hover:bg-red-500/10 rounded-lg transition" title="Hapus">
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
                                            <p>Belum ada tips & artikel</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($tips->hasPages())
                        <div class="px-6 py-4 border-t border-slate-700">
                            {{ $tips->links() }}
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
                        <h3 class="text-xl font-bold text-white">Konfirmasi Hapus</h3>
                        <p class="text-sm text-slate-400 mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-slate-300">Apakah Anda yakin ingin menghapus artikel <span id="deleteTipTitle" class="font-semibold text-white"></span>?</p>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-slate-700 bg-slate-800/50">
                <button 
                    onclick="closeDeleteModal()"
                    class="px-6 py-2.5 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-lg transition"
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
                        Hapus Artikel
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

</body>
</html>
