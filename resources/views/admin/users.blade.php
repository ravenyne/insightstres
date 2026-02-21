<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Mahasiswa - Insight Stress</title>
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
            <header class="hidden lg:block bg-slate-800/30 border-b border-slate-700 px-4 lg:px-8 py-4 lg:py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold">Kelola Mahasiswa</h1>
                        <p class="text-slate-400 mt-1 text-sm lg:text-base">Lihat dan kelola data mahasiswa</p>
                    </div>
                    <button onclick="openExportModal()" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </button>
                </div>
            </header>

            <!-- Content -->
            <div class="p-4 lg:p-8">

                <!-- Mobile Page Title & Export Button -->
                <div class="lg:hidden mb-6">
                    <h1 class="text-2xl font-bold mb-1">Kelola Mahasiswa</h1>
                    <p class="text-slate-400 text-sm mb-4">Lihat dan kelola data mahasiswa</p>
                    <button onclick="openExportModal()" class="w-full px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </button>
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

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="searchInput"
                            placeholder="Cari berdasarkan nama, NIM, atau jurusan..."
                            class="w-full pl-12 pr-4 py-3 bg-slate-800/50 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                        >
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl overflow-hidden">
                    
                    <div class="px-6 py-4 border-b border-slate-700">
                        <h3 class="text-lg font-bold">Daftar Mahasiswa ({{ $users->total() }})</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700 bg-slate-800/30">
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">Nama</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">NIM</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">Jurusan</th>
                                    <th class="text-left py-3 px-3 text-slate-400 font-medium text-sm">Semester</th>
                                    <th class="text-left py-3 px-3 text-slate-400 font-medium text-sm">Assessment</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">Stress Terakhir</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                @forelse($users as $user)
                                    <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition">
                                        <td class="py-3 px-4">
                                            <div>
                                                <p class="font-medium">{{ $user->name }}</p>
                                                <p class="text-sm text-slate-400">{{ $user->email }}</p>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-slate-300">{{ $user->nim ?? 'N/A' }}</td>
                                        <td class="py-3 px-4 text-slate-300 text-sm">{{ $user->jurusan ?? 'N/A' }}</td>
                                        <td class="py-3 px-3 text-slate-300 text-center">{{ $user->semester ?? 'N/A' }}</td>
                                        <td class="py-3 px-3 text-slate-300 text-center">{{ $user->assessments_count ?? 0 }}</td>
                                        <td class="py-3 px-4">
                                            @if($user->latest_assessment)
                                                @php
                                                    $stressCategory = $user->latest_assessment->stress_category ?? 'Unknown';
                                                    $category = match($stressCategory) {
                                                        'No Stress' => ['text' => 'Rendah', 'class' => 'bg-green-500/20 text-green-400'],
                                                        'Eustress' => ['text' => 'Sedang', 'class' => 'bg-blue-500/20 text-blue-400'],
                                                        'Distress' => ['text' => 'Tinggi', 'class' => 'bg-red-500/20 text-red-400'],
                                                        default => ['text' => 'Unknown', 'class' => 'bg-gray-500/20 text-gray-400']
                                                    };
                                                @endphp
                                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $category['class'] }} whitespace-nowrap">
                                                    {{ $category['text'] }}
                                                </span>
                                            @else
                                                <span class="text-slate-500 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2">
                                                <!-- View -->
                                                <button onclick="openModal({{ $user->id }})" class="p-2 hover:bg-slate-700 rounded-lg transition" title="Lihat Detail">
                                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </button>
                                                
                                                <!-- Edit -->
                                                <button onclick="openEditModal({{ $user->id }})" class="p-2 hover:bg-slate-700 rounded-lg transition" title="Edit">
                                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </button>
                                                
                                                <!-- Delete -->
                                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Hapus mahasiswa {{ $user->name }}?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg transition" title="Hapus">
                                                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-slate-500">
                                            <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p>Belum ada mahasiswa terdaftar</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div class="px-6 py-4 border-t border-slate-700">
                            {{ $users->links() }}
                        </div>
                    @endif

                </div>

            </div>

        </main>

    </div>

    <!-- Modal Detail Mahasiswa -->
    <div id="studentModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl max-w-md w-full shadow-2xl">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-700">
                <div>
                    <h3 class="text-xl font-bold text-white">Detail Mahasiswa</h3>
                    <p class="text-sm text-slate-400 mt-1">Informasi lengkap mahasiswa</p>
                </div>
                <button onclick="closeModal()" class="p-2 hover:bg-slate-700 rounded-lg transition">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <!-- Nama -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Nama</p>
                        <p class="text-white font-medium" id="modalName">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400 mb-1">NIM</p>
                        <p class="text-white font-medium" id="modalNim">-</p>
                    </div>
                </div>

                <!-- Email & Jurusan -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Email</p>
                        <p class="text-white font-medium text-sm" id="modalEmail">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Jurusan</p>
                        <p class="text-white font-medium" id="modalJurusan">-</p>
                    </div>
                </div>

                <!-- Semester & Total Assessment -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Semester</p>
                        <p class="text-white font-medium" id="modalSemester">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Total Assessment</p>
                        <p class="text-white font-medium" id="modalAssessment">-</p>
                    </div>
                </div>

                <!-- Kategori Stress Terakhir -->
                <div>
                    <p class="text-sm text-slate-400 mb-2">Kategori Stress Terakhir</p>
                    <span id="modalStressCategory" class="px-3 py-1 rounded-full text-xs font-medium bg-slate-700 text-slate-400">
                        -
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Mahasiswa -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-700 sticky top-0 bg-slate-800 z-10">
                <div>
                    <h3 class="text-xl font-bold text-white">Edit Mahasiswa</h3>
                    <p class="text-sm text-slate-400 mt-1">Perbarui informasi mahasiswa</p>
                </div>
                <button onclick="closeEditModal()" class="p-2 hover:bg-slate-700 rounded-lg transition">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-4">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Nama Lengkap <span class="text-red-400">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="editName"
                            required
                            class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                            placeholder="Masukkan nama lengkap"
                        >
                    </div>

                    <!-- NIM & Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">
                                NIM <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nim" 
                                id="editNim"
                                required
                                class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                                placeholder="Contoh: 2021001"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">
                                Email <span class="text-red-400">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="editEmail"
                                required
                                class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                                placeholder="email@example.com"
                            >
                        </div>
                    </div>

                    <!-- Jurusan & Semester -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">
                                Jurusan <span class="text-red-400">*</span>
                            </label>
                            <select 
                                name="jurusan" 
                                id="editJurusan"
                                required
                                class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                            >
                                <option value="">Pilih Jurusan</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Sistem Informasi">Sistem Informasi</option>
                                <option value="Bisnis Digital">Bisnis Digital</option>
                                <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                                <option value="Manajemen Informatika">Manajemen Informatika</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">
                                Semester <span class="text-red-400">*</span>
                            </label>
                            <select 
                                name="semester" 
                                id="editSemester"
                                required
                                class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                            >
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                                <option value="3">Semester 3</option>
                                <option value="4">Semester 4</option>
                                <option value="5">Semester 5</option>
                                <option value="6">Semester 6</option>
                                <option value="7">Semester 7</option>
                                <option value="8">Semester 8</option>
                            </select>
                        </div>
                    </div>

                    <!-- Reset Password -->
                    <div class="border-t border-slate-700 pt-4">
                        <div class="flex items-center gap-3 mb-3">
                            <input 
                                type="checkbox" 
                                id="resetPasswordCheck"
                                onchange="togglePasswordField()"
                                class="w-4 h-4 rounded border-slate-600 bg-slate-900/50 text-orange-500 focus:ring-orange-500 focus:ring-offset-slate-800"
                            >
                            <label for="resetPasswordCheck" class="text-sm font-medium text-slate-300">
                                Reset Password
                            </label>
                        </div>
                        <div id="passwordField" class="hidden">
                            <label class="block text-sm font-medium text-slate-300 mb-2">
                                Password Baru
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="editPassword"
                                class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                                placeholder="Minimal 6 karakter"
                            >
                            <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 p-6 border-t border-slate-700 bg-slate-800/50">
                    <button 
                        type="button"
                        onclick="closeEditModal()"
                        class="px-6 py-2.5 bg-slate-700 hover:bg-slate-600 text-white font-medium rounded-lg transition"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit"
                        class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Export PDF -->
    <!-- Modal Export PDF -->
    <div id="exportModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white border border-slate-200 rounded-2xl max-w-4xl w-full shadow-2xl h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-200 flex-shrink-0">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Data Mahasiswa
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">Preview laporan data mahasiswa sebelum mengunduh</p>
                </div>
                <button onclick="closeExportModal()" class="p-2 hover:bg-slate-100 rounded-lg transition">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body (Preview) -->
            <div class="flex-1 bg-slate-50 p-4 overflow-hidden relative">
                <!-- Loading State -->
                <div id="previewLoading" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-50 z-10 transition-opacity duration-300">
                    <div class="w-12 h-12 border-4 border-orange-500 border-t-transparent rounded-full animate-spin mb-4"></div>
                    <p class="text-slate-500 font-medium">Memuat preview dokumen...</p>
                </div>

                <!-- Iframe Preview -->
                <iframe id="pdfPreviewFrame" class="w-full h-full rounded-lg shadow-lg border border-slate-200" src=""></iframe>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-slate-200 bg-white flex-shrink-0">
                <button onclick="closeExportModal()" class="px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition">
                    Batal
                </button>
                <a href="{{ route('admin.users.export.pdf') }}" target="_blank" onclick="closeExportModal()" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Unduh PDF
                </a>
            </div>
        </div>
    </div>

    <script>
        // Student data from PHP
        const studentsData = {
            @foreach($users as $user)
                {{ $user->id }}: {
                    name: "{{ $user->name }}",
                    nim: "{{ $user->nim ?? 'N/A' }}",
                    email: "{{ $user->email }}",
                    jurusan: "{{ $user->jurusan ?? 'N/A' }}",
                    semester: "{{ $user->semester ?? 'N/A' }}",
                    assessmentCount: {{ $user->assessments_count ?? 0 }},
                    @if($user->latest_assessment)
                        @php
                            $score = $user->latest_assessment->numeric_score ?? 0;
                            $category = match(true) {
                                $score < 2 => ['text' => 'Rendah', 'class' => 'bg-green-500/20 text-green-400'],
                                $score < 3 => ['text' => 'Sedang', 'class' => 'bg-orange-500/20 text-orange-400'],
                                default => ['text' => 'Tinggi', 'class' => 'bg-red-500/20 text-red-400']
                            };
                        @endphp
                        stressCategory: "{{ $category['text'] }}",
                        stressClass: "{{ $category['class'] }}"
                    @else
                        stressCategory: "-",
                        stressClass: "bg-slate-700 text-slate-400"
                    @endif
                },
            @endforeach
        };

        // Open modal function
        function openModal(userId) {
            const student = studentsData[userId];
            if (!student) return;

            // Populate modal with student data
            document.getElementById('modalName').textContent = student.name;
            document.getElementById('modalNim').textContent = student.nim;
            document.getElementById('modalEmail').textContent = student.email;
            document.getElementById('modalJurusan').textContent = student.jurusan;
            document.getElementById('modalSemester').textContent = student.semester;
            document.getElementById('modalAssessment').textContent = student.assessmentCount;
            
            const stressBadge = document.getElementById('modalStressCategory');
            stressBadge.textContent = student.stressCategory;
            stressBadge.className = `px-3 py-1 rounded-full text-xs font-medium ${student.stressClass}`;

            // Show modal
            document.getElementById('studentModal').classList.remove('hidden');
        }

        // Close modal function
        function closeModal() {
            document.getElementById('studentModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('studentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeEditModal();
            }
        });

        // ===== EDIT MODAL FUNCTIONS =====
        
        // Open edit modal function
        function openEditModal(userId) {
            const student = studentsData[userId];
            if (!student) return;

            // Populate form with student data
            document.getElementById('editName').value = student.name;
            document.getElementById('editNim').value = student.nim;
            document.getElementById('editEmail').value = student.email;
            document.getElementById('editJurusan').value = student.jurusan;
            document.getElementById('editSemester').value = student.semester;
            
            // Reset password field
            document.getElementById('resetPasswordCheck').checked = false;
            document.getElementById('passwordField').classList.add('hidden');
            document.getElementById('editPassword').value = '';
            
            // Set form action URL
            document.getElementById('editForm').action = `/admin/users/${userId}`;

            // Show modal
            document.getElementById('editModal').classList.remove('hidden');
        }

        // Close edit modal function
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Toggle password field
        function togglePasswordField() {
            const checkbox = document.getElementById('resetPasswordCheck');
            const passwordField = document.getElementById('passwordField');
            
            if (checkbox.checked) {
                passwordField.classList.remove('hidden');
                document.getElementById('editPassword').required = true;
            } else {
                passwordField.classList.add('hidden');
                document.getElementById('editPassword').required = false;
                document.getElementById('editPassword').value = '';
            }
        }

        // Close edit modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#userTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
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

        // ===== EXPORT MODAL FUNCTIONS =====
        const exportModal = document.getElementById('exportModal');
        const pdfPreviewFrame = document.getElementById('pdfPreviewFrame');
        const previewLoading = document.getElementById('previewLoading');

        function openExportModal() {
            exportModal.classList.remove('hidden');
            
            // Start loading
            previewLoading.classList.remove('opacity-0', 'pointer-events-none');
            
            // Set iframe src to preview URL
            // Add timestamp to prevent caching
            pdfPreviewFrame.src = "{{ route('admin.users.export.pdf', ['preview' => 'true']) }}&t=" + new Date().getTime();
            
            // Hide loading when iframe loads
            pdfPreviewFrame.onload = function() {
                previewLoading.classList.add('opacity-0', 'pointer-events-none');
            };
        }

        function closeExportModal() {
            exportModal.classList.add('hidden');
            // Clear iframe to stop memory leaks or background processing
            setTimeout(() => {
                pdfPreviewFrame.src = 'about:blank';
            }, 300);
        }

        // Close export modal when clicking outside
        exportModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeExportModal();
            }
        });
    </script>

</body>
</html>
