<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($tip) ? 'Edit Artikel' : 'Tambah Artikel Baru' }} - Insight Stress</title>
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
                    
                    {{-- Mobile Header with Hamburger --}}            <header class="lg:hidden bg-slate-800/30 border-b border-slate-700 px-4 py-3 flex items-center justify-between sticky top-0 z-30">
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
            

            
            <!-- Header -->
            <header class="hidden lg:block bg-slate-800/30 border-b border-slate-700 px-4 lg:px-8 py-4 lg:py-6">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Menu (Mobile Only) -->
                    <button id="admin-sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-slate-700/50 transition">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <a href="{{ route('admin.tips') }}" class="text-slate-400 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                            </a>
                            <h1 class="text-3xl font-bold">{{ isset($tip) ? 'Edit Artikel' : 'Tambah Artikel Baru' }}</h1>
                        </div>
                        <p class="text-slate-400">{{ isset($tip) ? 'Perbarui informasi artikel' : 'Buat artikel baru untuk mahasiswa' }}</p>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-8">

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mb-6 bg-red-500/20 border border-red-500 text-red-400 px-6 py-4 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <p class="font-semibold mb-2">Terdapat kesalahan pada form:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ isset($tip) ? route('admin.tips.update', $tip->id) : route('admin.tips.store') }}" class="space-y-6">
                    @csrf
                    @if(isset($tip))
                        @method('PUT')
                    @endif

                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl overflow-hidden">
                        
                        <!-- Form Header -->
                        <div class="px-6 py-4 border-b border-slate-700">
                            <h3 class="text-lg font-bold">Informasi Artikel</h3>
                        </div>

                        <!-- Form Body -->
                        <div class="p-6 space-y-6">
                            
                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Judul Artikel <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="title" 
                                    value="{{ old('title', $tip->title ?? '') }}"
                                    required
                                    maxlength="255"
                                    class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition @error('title') border-red-500 @enderror"
                                    placeholder="Contoh: 5 Teknik Pernapasan untuk Mengurangi Stress"
                                >
                                @error('title')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category & Icon -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Category -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        Kategori <span class="text-red-400">*</span>
                                    </label>
                                    <select 
                                        name="category" 
                                        required
                                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition @error('category') border-red-500 @enderror"
                                    >
                                        <option value="">Pilih Kategori</option>
                                        <option value="breathing" {{ old('category', $tip->category ?? '') == 'breathing' ? 'selected' : '' }}>🌬️ Pernapasan</option>
                                        <option value="sleep" {{ old('category', $tip->category ?? '') == 'sleep' ? 'selected' : '' }}>🌙 Tidur</option>
                                        <option value="exercise" {{ old('category', $tip->category ?? '') == 'exercise' ? 'selected' : '' }}>💪 Olahraga</option>
                                        <option value="mindfulness" {{ old('category', $tip->category ?? '') == 'mindfulness' ? 'selected' : '' }}>🧘 Mindfulness</option>
                                        <option value="study" {{ old('category', $tip->category ?? '') == 'study' ? 'selected' : '' }}>📚 Belajar</option>
                                        <option value="general" {{ old('category', $tip->category ?? '') == 'general' ? 'selected' : '' }}>📝 Umum</option>
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Icon -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        Icon (Opsional)
                                    </label>
                                    <select 
                                        name="icon" 
                                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition @error('icon') border-red-500 @enderror"
                                    >
                                        <option value="book-open" {{ old('icon', $tip->icon ?? 'book-open') == 'book-open' ? 'selected' : '' }}>📖 Book Open</option>
                                        <option value="wind" {{ old('icon', $tip->icon ?? '') == 'wind' ? 'selected' : '' }}>🌬️ Wind</option>
                                        <option value="moon" {{ old('icon', $tip->icon ?? '') == 'moon' ? 'selected' : '' }}>🌙 Moon</option>
                                        <option value="activity" {{ old('icon', $tip->icon ?? '') == 'activity' ? 'selected' : '' }}>💪 Activity</option>
                                        <option value="brain" {{ old('icon', $tip->icon ?? '') == 'brain' ? 'selected' : '' }}>🧠 Brain</option>
                                        <option value="lightbulb" {{ old('icon', $tip->icon ?? '') == 'lightbulb' ? 'selected' : '' }}>💡 Lightbulb</option>
                                        <option value="heart" {{ old('icon', $tip->icon ?? '') == 'heart' ? 'selected' : '' }}>❤️ Heart</option>
                                        <option value="star" {{ old('icon', $tip->icon ?? '') == 'star' ? 'selected' : '' }}>⭐ Star</option>
                                    </select>
                                    @error('icon')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500">Icon akan ditampilkan di halaman user</p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    Konten Artikel <span class="text-red-400">*</span>
                                </label>
                                <textarea 
                                    name="content" 
                                    id="contentEditor"
                                    required
                                    rows="15"
                                    class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition font-mono text-sm @error('content') border-red-500 @enderror"
                                    placeholder="Tulis konten artikel di sini...&#10;&#10;Tips:&#10;- Gunakan paragraf untuk memisahkan ide&#10;- Gunakan poin-poin untuk daftar&#10;- Tulis dengan bahasa yang mudah dipahami&#10;- Sertakan contoh praktis jika memungkinkan"
                                >{{ old('content', $tip->content ?? '') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                                <div class="mt-2 flex items-center justify-between">
                                    <p class="text-xs text-slate-500">Konten mendukung format teks biasa dan HTML</p>
                                    <span id="charCount" class="text-xs text-slate-500">0 karakter</span>
                                </div>
                            </div>

                            <!-- Preview Toggle -->
                            <div class="border-t border-slate-700 pt-6">
                                <button 
                                    type="button"
                                    onclick="togglePreview()"
                                    class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-lg transition flex items-center gap-2"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span id="previewToggleText">Lihat Preview</span>
                                </button>

                                <!-- Preview Area -->
                                <div id="previewArea" class="hidden mt-4 p-6 bg-slate-900/50 border border-slate-600 rounded-lg">
                                    <h4 class="text-lg font-bold mb-4 text-orange-400">Preview Artikel</h4>
                                    <div id="previewTitle" class="text-2xl font-bold mb-4"></div>
                                    <div id="previewCategory" class="mb-4"></div>
                                    <div id="previewContent" class="prose prose-invert max-w-none text-slate-300 leading-relaxed"></div>
                                </div>
                            </div>

                        </div>

                        <!-- Form Footer -->
                        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-700 bg-slate-800/30">
                            <a 
                                href="{{ route('admin.tips') }}"
                                class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-lg transition"
                            >
                                Batal
                            </a>
                            <button 
                                type="submit"
                                class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition flex items-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ isset($tip) ? 'Simpan Perubahan' : 'Tambah Artikel' }}
                            </button>
                        </div>

                    </div>
                </form>

            </div>

        </main>

    </div>

    <script>
        // Character counter
        const contentEditor = document.getElementById('contentEditor');
        const charCount = document.getElementById('charCount');

        function updateCharCount() {
            const count = contentEditor.value.length;
            charCount.textContent = `${count.toLocaleString()} karakter`;
        }

        contentEditor.addEventListener('input', updateCharCount);
        updateCharCount(); // Initial count

        // Preview functionality
        function togglePreview() {
            const previewArea = document.getElementById('previewArea');
            const toggleText = document.getElementById('previewToggleText');
            const title = document.querySelector('input[name="title"]').value;
            const category = document.querySelector('select[name="category"]');
            const content = contentEditor.value;

            if (previewArea.classList.contains('hidden')) {
                // Show preview
                const categoryText = category.options[category.selectedIndex].text;
                
                document.getElementById('previewTitle').textContent = title || 'Judul Artikel';
                document.getElementById('previewCategory').innerHTML = categoryText ? 
                    `<span class="px-3 py-1 rounded-full text-xs font-medium bg-orange-500/20 text-orange-400">${categoryText}</span>` : '';
                
                // Convert line breaks to paragraphs for better preview
                const formattedContent = content
                    .split('\n\n')
                    .map(para => `<p class="mb-4">${para.replace(/\n/g, '<br>')}</p>`)
                    .join('');
                
                document.getElementById('previewContent').innerHTML = formattedContent || '<p class="text-slate-500">Konten artikel akan ditampilkan di sini...</p>';
                
                previewArea.classList.remove('hidden');
                toggleText.textContent = 'Sembunyikan Preview';
            } else {
                // Hide preview
                previewArea.classList.add('hidden');
                toggleText.textContent = 'Lihat Preview';
            }
        }

        // Auto-resize textarea
        contentEditor.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Prevent accidental navigation
        let formChanged = false;
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            input.addEventListener('change', () => {
                formChanged = true;
            });
        });

        window.addEventListener('beforeunload', (e) => {
            if (formChanged && !form.submitted) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        form.addEventListener('submit', () => {
            form.submitted = true;
        });
    </script>


    <script>
        // Admin sidebar toggle functionality
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
    </script>

</body>
</html>
