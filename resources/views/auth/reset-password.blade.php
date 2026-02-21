<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Insight Stress</title>
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
                    <i data-lucide="lock-keyhole" class="w-8 h-8"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
                <p class="text-gray-500 text-sm mt-2">Buat password baru untuk akun Anda.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </span>
                        <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                            class="w-full pl-10 px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-500 cursor-not-allowed">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </span>
                        <input type="password" name="password" required autofocus
                            class="w-full pl-10 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                            placeholder="Minimal 8 karakter">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </span>
                        <input type="password" name="password_confirmation" required
                            class="w-full pl-10 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                            placeholder="Ulangi password baru">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-3 rounded-xl bg-teal-600 text-white font-semibold hover:bg-teal-700 transition shadow-lg shadow-teal-500/30">
                    Reset Password
                </button>
            </form>

        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
