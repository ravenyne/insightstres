<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode - Insight Stress</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Card -->
        <div class="bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl p-8 md:p-12 border border-white/20">
            <!-- Icon -->
            <div class="flex justify-center mb-8">
                <div class="w-24 h-24 bg-orange-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-bold text-white text-center mb-4">
                Sedang Maintenance
            </h1>

            <!-- Subtitle -->
            <p class="text-xl text-slate-300 text-center mb-8">
                Kami sedang melakukan pemeliharaan sistem
            </p>

            <!-- Message -->
            <div class="bg-white/5 rounded-2xl p-6 mb-8 border border-white/10">
                <p class="text-slate-200 text-center leading-relaxed">
                    Mohon maaf atas ketidaknyamanannya. Kami sedang meningkatkan sistem untuk memberikan pengalaman yang lebih baik untuk Anda.
                </p>
                <p class="text-slate-300 text-center mt-4 text-sm">
                    Sistem akan kembali normal dalam waktu singkat. Terima kasih atas kesabaran Anda.
                </p>
            </div>

            <!-- Info -->
            <div class="flex items-center justify-center gap-2 text-slate-400 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Jika ada pertanyaan, hubungi administrator</span>
            </div>

            <!-- Footer -->
            <div class="mt-8 pt-8 border-t border-white/10 text-center">
                <p class="text-slate-400 text-sm">
                    <strong class="text-white">Insight Stress</strong> - Platform Kesehatan Mental Mahasiswa
                </p>
            </div>
        </div>

        <!-- Refresh Button -->
        <div class="text-center mt-6">
            <button onclick="location.reload()" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh Halaman
            </button>
        </div>
    </div>
</body>
</html>
