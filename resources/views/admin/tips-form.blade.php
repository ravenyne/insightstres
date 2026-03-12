<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="formPageTitle">{{ isset($tip) ? 'Edit Artikel' : 'Tambah Artikel Baru' }} - Insight Stress</title>
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
                        <div class="w-8 h-8 rounded-lg bg-teal-500 flex items-center justify-center">
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
                            <h1 class="text-3xl font-bold" id="formHeaderTitle">{{ isset($tip) ? 'Edit Artikel' : 'Tambah Artikel Baru' }}</h1>
                        </div>
                        <p class="text-slate-400" id="formHeaderSubtitle">{{ isset($tip) ? 'Perbarui informasi artikel' : 'Buat artikel baru untuk mahasiswa' }}</p>
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
                                <p class="font-semibold mb-2" data-i18n-form="form_error_title">Terdapat kesalahan pada form:</p>
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
                            <h3 class="text-lg font-bold" data-i18n-form="form_info_title">Informasi Artikel</h3>
                        </div>

                        <!-- Form Body -->
                        <div class="p-6 space-y-6">
                            
                            <!-- Title ID -->
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <span data-i18n-form="label_title_id">Judul Artikel (Indonesia)</span> <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="title_id" 
                                    value="{{ old('title_id', $tip->title_id ?? '') }}"
                                    required
                                    maxlength="255"
                                    class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition @error('title_id') border-red-500 @enderror"
                                    placeholder="Contoh: 5 Teknik Pernapasan"
                                >
                                @error('title_id')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Title EN -->
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <span data-i18n-form="label_title_en">Judul Artikel (English)</span> <span class="text-red-400">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="title_en" 
                                    value="{{ old('title_en', $tip->title_en ?? '') }}"
                                    required
                                    maxlength="255"
                                    class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition @error('title_en') border-red-500 @enderror"
                                    placeholder="Example: 5 Breathing Techniques"
                                >
                                @error('title_en')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">
                                    <span data-i18n-form="label_category">Kategori</span> <span class="text-red-400">*</span>
                                </label>
                                <select 
                                    name="category" 
                                    required
                                    class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition @error('category') border-red-500 @enderror"
                                >
                                    <option value="" data-i18n-form="opt_select_category">Pilih Kategori</option>
                                    <option value="breathing" {{ old('category', $tip->category ?? '') == 'breathing' ? 'selected' : '' }} data-i18n-form="opt_breathing">🌬️ Pernapasan</option>
                                    <option value="sleep" {{ old('category', $tip->category ?? '') == 'sleep' ? 'selected' : '' }} data-i18n-form="opt_sleep">🌙 Tidur</option>
                                    <option value="exercise" {{ old('category', $tip->category ?? '') == 'exercise' ? 'selected' : '' }} data-i18n-form="opt_exercise">💪 Olahraga</option>
                                    <option value="mindfulness" {{ old('category', $tip->category ?? '') == 'mindfulness' ? 'selected' : '' }} data-i18n-form="opt_mindfulness">🧘 Mindfulness</option>
                                    <option value="study" {{ old('category', $tip->category ?? '') == 'study' ? 'selected' : '' }} data-i18n-form="opt_study">📚 Belajar</option>
                                    <option value="general" {{ old('category', $tip->category ?? '') == 'general' ? 'selected' : '' }} data-i18n-form="opt_general">📝 Umum</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Intervention Fields (Target, Duration, Badges) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 border-t border-slate-700 pt-6">
                                <!-- Target Condition -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        <span data-i18n-form="label_target_condition">Target Kondisi Stress</span> <span class="text-red-400">*</span>
                                    </label>
                                    <select 
                                        name="target_condition" 
                                        required
                                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition @error('target_condition') border-red-500 @enderror"
                                    >
                                        <option value="Semua Kondisi" {{ old('target_condition', $tip->target_condition ?? 'Semua Kondisi') == 'Semua Kondisi' ? 'selected' : '' }} data-i18n-form="opt_all_conditions">Semua Kondisi</option>
                                        <option value="Distress" {{ old('target_condition', $tip->target_condition ?? '') == 'Distress' ? 'selected' : '' }} data-i18n-form="opt_distress">Distress (Risiko Tinggi)</option>
                                        <option value="Eustress" {{ old('target_condition', $tip->target_condition ?? '') == 'Eustress' ? 'selected' : '' }} data-i18n-form="opt_eustress">Eustress (Perlu Perhatian)</option>
                                    </select>
                                    @error('target_condition')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500" data-i18n-form="hint_ai_rec">Untuk rekomendasi AI</p>
                                </div>

                                <!-- Read Duration -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        <span data-i18n-form="label_read_duration">Durasi Baca (Menit)</span>
                                    </label>
                                    <input 
                                        type="number" 
                                        name="read_duration" 
                                        value="{{ old('read_duration', $tip->read_duration ?? '') }}"
                                        min="1"
                                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition @error('read_duration') border-red-500 @enderror"
                                        placeholder="Contoh: 3"
                                    >
                                    @error('read_duration')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Checkboxes (Evidence / AI) -->
                                <div class="col-span-1 md:col-span-2 flex flex-col justify-center space-y-4">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            name="is_evidence_based" 
                                            value="1" 
                                            class="w-5 h-5 rounded border-slate-600 text-teal-500 focus:ring-teal-500/20 bg-slate-900/50"
                                            {{ old('is_evidence_based', $tip->is_evidence_based ?? false) ? 'checked' : '' }}
                                        >
                                        <div>
                                            <span class="text-sm font-medium text-slate-300" data-i18n-form="lbl_evidence_based">Evidence-based / Psychology Based</span>
                                            <p class="text-xs text-slate-500" data-i18n-form="hint_evidence_based">Beri label verifikasi psikologi pada artikel ini</p>
                                        </div>
                                    </label>

                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            name="is_ai_recommended" 
                                            value="1" 
                                            class="w-5 h-5 rounded border-slate-600 text-indigo-500 focus:ring-indigo-500/20 bg-slate-900/50"
                                            {{ old('is_ai_recommended', $tip->is_ai_recommended ?? false) ? 'checked' : '' }}
                                        >
                                        <div>
                                            <span class="text-sm font-medium text-slate-300" data-i18n-form="lbl_ai_recommended">Direkomendasikan AI</span>
                                            <p class="text-xs text-slate-500" data-i18n-form="hint_ai_recommended">Tandai sebagai artikel rekomendasi prioritas sistem</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 border-t border-slate-700 pt-6">
                                <!-- Content ID -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        <span data-i18n-form="label_content_id">Konten (Indonesia)</span> <span class="text-red-400">*</span>
                                    </label>
                                    <textarea 
                                        name="content_id" 
                                        id="contentEditorId"
                                        required
                                        rows="15"
                                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition font-mono text-sm @error('content_id') border-red-500 @enderror"
                                    >{{ old('content_id', $tip->content_id ?? '') }}</textarea>
                                    @error('content_id')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Content EN -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">
                                        <span data-i18n-form="label_content_en">Konten (English)</span> <span class="text-red-400">*</span>
                                    </label>
                                    <textarea 
                                        name="content_en" 
                                        id="contentEditorEn"
                                        required
                                        rows="15"
                                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition font-mono text-sm @error('content_en') border-red-500 @enderror"
                                    >{{ old('content_en', $tip->content_en ?? '') }}</textarea>
                                    @error('content_en')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-2 text-xs text-slate-500">
                                <span data-i18n-form="hint_content_format">Konten mendukung format teks biasa dan HTML</span>
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
                                    <span id="previewToggleText" data-i18n-form="btn_preview">Lihat Preview</span>
                                </button>

                                <!-- Preview Area -->
                                <div id="previewArea" class="hidden mt-4 p-6 bg-slate-900/50 border border-slate-600 rounded-lg">
                                    <h4 class="text-lg font-bold mb-4 text-teal-400" data-i18n-form="preview_title">Preview Artikel</h4>
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
                             data-i18n-form="btn_cancel">
                                Batal
                            </a>
                            <button 
                                type="submit"
                                class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg transition flex items-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span id="formSubmitLabel">{{ isset($tip) ? 'Simpan Perubahan' : 'Tambah Artikel' }}</span>
                            </button>
                        </div>

                    </div>
                </form>

            </div>

        </main>

    </div>

    <script>
        // Character counter
        const contentEditorId = document.getElementById('contentEditorId');

        function updateHeights() {
            contentEditorId.style.height = 'auto';
            contentEditorId.style.height = (contentEditorId.scrollHeight) + 'px';
            const contentEditorEn = document.getElementById('contentEditorEn');
            contentEditorEn.style.height = 'auto';
            contentEditorEn.style.height = (contentEditorEn.scrollHeight) + 'px';
        }

        contentEditorId.addEventListener('input', updateHeights);
        document.getElementById('contentEditorEn').addEventListener('input', updateHeights);

        // Preview functionality
        function togglePreview() {
            const previewArea = document.getElementById('previewArea');
            const toggleText = document.getElementById('previewToggleText');
            const title = document.querySelector('input[name="title_id"]').value;
            const category = document.querySelector('select[name="category"]');
            const content = document.getElementById('contentEditorId').value;

            if (previewArea.classList.contains('hidden')) {
                // Show preview
                const categoryText = category.options[category.selectedIndex].text;
                
                document.getElementById('previewTitle').textContent = title || 'Judul Artikel';
                document.getElementById('previewCategory').innerHTML = categoryText ? 
                    `<span class="px-3 py-1 rounded-full text-xs font-medium bg-teal-500/20 text-teal-400">${categoryText}</span>` : '';
                
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


    <script>
        // ===== FORM PAGE i18n =====
        const i18nForm = {
            id: {
                page_title_create: 'Tambah Artikel Baru',
                page_title_edit: 'Edit Artikel',
                page_subtitle_create: 'Buat artikel baru untuk mahasiswa',
                page_subtitle_edit: 'Perbarui informasi artikel',
                form_info_title: 'Informasi Artikel',
                label_title_id: 'Judul Artikel (Indonesia)',
                label_title_en: 'Judul Artikel (English)',
                label_category: 'Kategori',
                opt_select_category: 'Pilih Kategori',
                opt_breathing: '🌬️ Pernapasan',
                opt_sleep: '🌙 Tidur',
                opt_exercise: '💪 Olahraga',
                opt_mindfulness: '🧘 Mindfulness',
                opt_study: '📚 Belajar',
                opt_general: '📝 Umum',
                label_target_condition: 'Target Kondisi Stress',
                opt_all_conditions: 'Semua Kondisi',
                opt_distress: 'Distress (Risiko Tinggi)',
                opt_eustress: 'Eustress (Perlu Perhatian)',
                hint_ai_rec: 'Untuk rekomendasi AI',
                label_read_duration: 'Durasi Baca (Menit)',
                lbl_evidence_based: 'Evidence-based / Psychology Based',
                hint_evidence_based: 'Beri label verifikasi psikologi pada artikel ini',
                lbl_ai_recommended: 'Direkomendasikan AI',
                hint_ai_recommended: 'Tandai sebagai artikel rekomendasi prioritas sistem',
                label_content_id: 'Konten (Indonesia)',
                label_content_en: 'Konten (English)',
                hint_content_format: 'Konten mendukung format teks biasa dan HTML',
                btn_preview: 'Lihat Preview',
                btn_hide_preview: 'Sembunyikan Preview',
                preview_title: 'Preview Artikel',
                btn_cancel: 'Batal',
                btn_save_changes: 'Simpan Perubahan',
                btn_add_article: 'Tambah Artikel',
                form_error_title: 'Terdapat kesalahan pada form:'
            },
            en: {
                page_title_create: 'Add New Article',
                page_title_edit: 'Edit Article',
                page_subtitle_create: 'Create a new article for students',
                page_subtitle_edit: 'Update article information',
                form_info_title: 'Article Information',
                label_title_id: 'Article Title (Indonesian)',
                label_title_en: 'Article Title (English)',
                label_category: 'Category',
                opt_select_category: 'Select Category',
                opt_breathing: '🌬️ Breathing',
                opt_sleep: '🌙 Sleep',
                opt_exercise: '💪 Exercise',
                opt_mindfulness: '🧘 Mindfulness',
                opt_study: '📚 Study',
                opt_general: '📝 General',
                label_target_condition: 'Stress Target Condition',
                opt_all_conditions: 'All Conditions',
                opt_distress: 'Distress (High Risk)',
                opt_eustress: 'Eustress (Needs Attention)',
                hint_ai_rec: 'For AI recommendations',
                label_read_duration: 'Read Duration (Minutes)',
                lbl_evidence_based: 'Evidence-based / Psychology Based',
                hint_evidence_based: 'Mark this article with psychology verification label',
                lbl_ai_recommended: 'AI Recommended',
                hint_ai_recommended: 'Mark as priority system recommendation article',
                label_content_id: 'Content (Indonesian)',
                label_content_en: 'Content (English)',
                hint_content_format: 'Content supports plain text and HTML format',
                btn_preview: 'Show Preview',
                btn_hide_preview: 'Hide Preview',
                preview_title: 'Article Preview',
                btn_cancel: 'Cancel',
                btn_save_changes: 'Save Changes',
                btn_add_article: 'Add Article',
                form_error_title: 'There are errors in the form:'
            }
        };

        const isEditMode = document.getElementById('formSubmitLabel') !== null &&
            document.getElementById('formHeaderTitle')?.textContent?.includes('Edit');

        function applyFormI18n() {
            const lang = (localStorage.getItem('app_language') || 'id').toLowerCase();
            const t = i18nForm[lang] || i18nForm['id'];

            // Page title and header
            const headerTitleEl = document.getElementById('formHeaderTitle');
            const headerSubtitleEl = document.getElementById('formHeaderSubtitle');
            const pageTitleEl = document.getElementById('formPageTitle');

            if (headerTitleEl) {
                const editMode = headerTitleEl.textContent.includes('Edit') || headerTitleEl.textContent.includes('Edit Article');
                headerTitleEl.textContent = editMode ? t.page_title_edit : t.page_title_create;
                if (pageTitleEl) pageTitleEl.textContent = (editMode ? t.page_title_edit : t.page_title_create) + ' - Insight Stress';
            }
            if (headerSubtitleEl) {
                const editMode = headerSubtitleEl.textContent.includes('Perbarui') || headerSubtitleEl.textContent.includes('Update');
                headerSubtitleEl.textContent = editMode ? t.page_subtitle_edit : t.page_subtitle_create;
            }

            // Submit button label
            const submitLabel = document.getElementById('formSubmitLabel');
            if (submitLabel) {
                const editMode = submitLabel.textContent.includes('Simpan') || submitLabel.textContent.includes('Save');
                submitLabel.textContent = editMode ? t.btn_save_changes : t.btn_add_article;
            }

            // data-i18n-form elements
            document.querySelectorAll('[data-i18n-form]').forEach(el => {
                const key = el.getAttribute('data-i18n-form');
                if (t[key] !== undefined) el.textContent = t[key];
            });
        }

        applyFormI18n();

        window.addEventListener('storage', function(e) {
            if (e.key === 'app_language') applyFormI18n();
        });
    </script>
</body>
</html>
