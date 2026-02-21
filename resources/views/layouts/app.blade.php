<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Insight Stress' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- NAVBAR --}}
    <nav class="w-full bg-white shadow-sm fixed top-0 left-0 z-50">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="/" class="text-xl font-bold text-teal-600">Insight Stress</a>
            <div class="flex gap-4">
                <a href="/login" class="text-gray-700 hover:text-teal-600">Masuk</a>
                <a href="/register" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">Daftar</a>
            </div>
        </div>
    </nav>

    <div class="pt-20">
        {{-- Isi konten halaman --}}
        @yield('content')
    </div>

</body>
</html>