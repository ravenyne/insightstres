<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Insight Stress</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-[#e8f9f8] to-white px-4 py-12">

    <div class="w-full max-w-md animate-fade-in">

        {{-- LOGO --}}
        <div class="flex justify-center mb-8">
            @include('components.logo')
        </div>

        <div class="bg-white rounded-2xl shadow-md p-8 md:p-10">

            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="key-round" class="w-8 h-8"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Lupa Password?</h2>
                <p class="text-gray-500 text-sm mt-2">Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
            </div>

            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6" role="alert">
                    <div class="flex items-start">
                        <i data-lucide="check-circle" class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="font-semibold mb-1">Email Berhasil Dikirim! ✉️</p>
                            <p class="text-sm">Kami telah mengirimkan link reset password ke email Anda.</p>
                            <p class="text-sm mt-2">📌 <strong>Langkah selanjutnya:</strong></p>
                            <ul class="text-sm mt-1 ml-4 list-disc">
                                <li>Cek inbox email Anda</li>
                                <li>Jika tidak ada, periksa folder <strong>Spam/Junk</strong></li>
                                <li>Link akan kadaluarsa dalam <strong>60 menit</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Terdaftar</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </span>
                        <input type="email" name="email" required autofocus
                            class="w-full pl-10 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-3 rounded-xl bg-teal-600 text-white font-semibold hover:bg-teal-700 transition shadow-lg shadow-teal-500/30">
                    Kirim Link Reset
                </button>
            </form>

            <div class="text-center mt-8">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-teal-600 flex items-center justify-center gap-2 transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Login
                </a>
            </div>

        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
