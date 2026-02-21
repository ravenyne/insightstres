@extends('layouts.dashboard')

@section('content')
<div class="space-y-6 animate-fade-in">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Profil Mahasiswa</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola informasi profil Anda</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- Kolom Kiri: Form Profil --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Informasi Pribadi</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Data diri yang terdaftar di sistem</p>
                    </div>
                    <button type="button" onclick="enableEdit()" id="btn-edit" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-white transition flex items-center gap-2">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                        Edit
                    </button>
                </div>

                {{-- Avatar --}}
                <div class="flex justify-center mb-8">
                    <div class="w-24 h-24 bg-teal-500 rounded-full flex items-center justify-center text-3xl font-bold text-white shadow-lg">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.profile.update') }}" method="POST" id="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4"></i> Nama Lengkap
                            </label>
                            <input type="text" name="name" value="{{ $user->name }}" disabled
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-teal-500 transition disabled:opacity-100 disabled:bg-gray-50/50 dark:text-white font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <i data-lucide="mail" class="w-4 h-4"></i> Email
                            </label>
                            <input type="email" name="email" value="{{ $user->email }}" disabled
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-teal-500 transition disabled:opacity-100 disabled:bg-gray-50/50 dark:text-white font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <i data-lucide="hash" class="w-4 h-4"></i> NIM
                            </label>
                            <input type="text" name="nim" value="{{ $user->nim }}" disabled
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-teal-500 transition disabled:opacity-100 disabled:bg-gray-50/50 dark:text-white font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <i data-lucide="book-open" class="w-4 h-4"></i> Jurusan
                            </label>
                            <select name="jurusan" disabled
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-teal-500 transition disabled:opacity-100 disabled:bg-gray-50/50 dark:text-white font-medium">
                                <option value="Teknik Informatika" {{ $user->jurusan == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="Sistem Informasi" {{ $user->jurusan == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                <option value="Ilmu Komputer" {{ $user->jurusan == 'Ilmu Komputer' ? 'selected' : '' }}>Ilmu Komputer</option>
                                <option value="Teknik Elektro" {{ $user->jurusan == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <i data-lucide="graduation-cap" class="w-4 h-4"></i> Semester
                            </label>
                            <select name="semester" disabled
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-teal-500 transition disabled:opacity-100 disabled:bg-gray-50/50 dark:text-white font-medium">
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ $user->semester == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4"></i> Jenis Kelamin
                            </label>
                            <select name="gender" disabled
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-teal-500 transition disabled:opacity-100 disabled:bg-gray-50/50 dark:text-white font-medium">
                                <option value="1" {{ $user->gender == 1 ? 'selected' : '' }}>Laki-laki</option>
                                <option value="0" {{ $user->gender == 0 ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-2">
                                <i data-lucide="calendar" class="w-4 h-4"></i> Umur
                            </label>
                            <input type="number" name="age" value="{{ $user->age }}" disabled
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-teal-500 transition disabled:opacity-100 disabled:bg-gray-50/50 dark:text-white font-medium">
                        </div>
                    </div>

                    <div id="action-buttons" class="hidden mt-8 flex gap-4">
                        <button type="button" onclick="cancelEdit()" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-xl shadow-lg shadow-teal-500/30 transition">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- Kolom Kanan: Statistik --}}
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Statistik Anda</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    
                    <div class="bg-teal-50 dark:bg-teal-900/20 p-5 rounded-2xl flex flex-col items-center justify-center text-center h-32">
                        <p class="text-3xl font-bold text-teal-600 dark:text-teal-400 mb-1">{{ $stats['total'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total Assessment</p>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900/20 p-5 rounded-2xl flex flex-col items-center justify-center text-center h-32">
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400 mb-1">{{ $stats['last_score'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Skor Terakhir</p>
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 p-5 rounded-2xl flex flex-col items-center justify-center text-center h-32">
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ $stats['active_months'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Bulan Aktif</p>
                    </div>

                    <div class="bg-purple-50 dark:bg-purple-900/20 p-5 rounded-2xl flex flex-col items-center justify-center text-center h-32">
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">{{ $stats['improvement'] }}%</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Peningkatan</p>
                    </div>

                </div>
            </div>

            {{-- Ganti Password --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Keamanan Akun</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Update password akun Anda</p>
                    </div>
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-full flex items-center justify-center">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </div>
                </div>

                <form action="{{ route('user.profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition dark:text-white">
                    </div>

                    <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-xl shadow-lg shadow-orange-500/30 transition flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Update Password
                    </button>
                </form>
            </div>

            {{-- Email Preferences --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Preferensi Email</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola notifikasi email Anda</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                    </div>
                </div>

                <style>
                    /* Custom Toggle Switch (Teal Version) */
                    .toggle-checkbox:checked {
                        right: 0;
                        border-color: #0d9488; /* teal-600 */
                    }
                    .toggle-checkbox:checked + .toggle-label {
                        background-color: #0d9488; /* teal-600 */
                    }
                    .toggle-checkbox:checked + .toggle-label:before {
                        transform: translateX(100%);
                    }
                    
                    .toggle-label {
                        width: 44px;
                        height: 24px;
                        position: relative;
                        display: block;
                        background: #e5e7eb; /* gray-200 */
                        border-radius: 9999px;
                        cursor: pointer;
                        transition: 0.3s;
                    }
                    /* Dark mode support */
                    @media (prefers-color-scheme: dark) {
                        .toggle-label {
                            background: #374151; /* gray-700 */
                        }
                    }
                    .dark .toggle-label {
                         background: #374151; /* gray-700 */
                    }

                    .toggle-label:before {
                        content: '';
                        position: absolute;
                        top: 2px;
                        left: 2px;
                        width: 20px;
                        height: 20px;
                        background: #fff;
                        border-radius: 50%;
                        transition: 0.3s;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                    }
                </style>

                <form action="{{ route('user.profile.email-preferences') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900 rounded-xl">
                            <div class="flex-1">
                                <label for="email_reminder_enabled" class="block font-medium text-gray-900 dark:text-white mb-1">
                                    Pengingat Assessment
                                </label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Terima email pengingat untuk melakukan assessment stres secara berkala
                                </p>
                            </div>
                            <div class="ml-4">
                                <div class="relative inline-block w-11 h-6 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="email_reminder_enabled" id="email_reminder_enabled" 
                                           value="1" {{ $user->email_reminder_enabled ? 'checked' : '' }}
                                           class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer outline-none hidden"/>
                                    <label for="email_reminder_enabled" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </div>
                        </div>

                        @if($user->last_reminder_sent_at)
                        <div class="text-xs text-gray-500 dark:text-gray-400 px-4">
                            <i data-lucide="clock" class="w-3 h-3 inline"></i>
                            Pengingat terakhir dikirim: {{ \Carbon\Carbon::parse($user->last_reminder_sent_at)->diffForHumans() }}
                        </div>
                        @endif
                    </div>

                    <button type="submit" class="w-full mt-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl shadow-lg shadow-blue-500/30 transition flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Preferensi
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

<script>
    // Re-initialize icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    function enableEdit() {
        const inputs = document.querySelectorAll('#profile-form input, #profile-form select');
        inputs.forEach(input => {
             input.disabled = false;
             input.classList.remove('bg-gray-50', 'border-none');
             input.classList.add('bg-white', 'border', 'border-gray-300');
        });
        
        document.getElementById('action-buttons').classList.remove('hidden');
        document.getElementById('btn-edit').classList.add('hidden');
    }

    function cancelEdit() {
        location.reload();
    }
</script>
@endsection
