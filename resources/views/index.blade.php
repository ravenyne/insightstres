<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insight Stress - Platform Kesehatan Mental Mahasiswa</title>
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="Platform kesehatan mental untuk mahasiswa. Penilaian stress berbasis sains, rekomendasi personal, dan dukungan untuk kesejahteraan mental Anda.">
    <meta name="keywords" content="kesehatan mental, stress mahasiswa, penilaian stress, mental health, wellbeing">
    <meta name="author" content="Insight Stress">
    
    {{-- Open Graph Meta Tags --}}
    <meta property="og:title" content="Insight Stress - Platform Kesehatan Mental Mahasiswa">
    <meta property="og:description" content="Pahami tingkat stress Anda dengan penilaian berbasis sains dan tingkatkan kesejahteraan mental.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    
    {{-- TAILWIND via VITE --}}
    @vite('resources/css/app.css')

    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #0fb7b3, #17c8c1);
        }
        .gradient-hero {
            background: linear-gradient(180deg, #e8f9f8, #ffffff);
        }
        .text-gradient {
            background: linear-gradient(90deg, #0fb7b3, #0bbcd1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Mobile menu animation */
        #mobile-menu {
            transition: max-height 0.3s ease-in-out;
        }
        
        /* Scroll animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* FAQ accordion */
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .faq-answer.active {
            max-height: 500px;
        }
        
        /* Sticky CTA button */
        #sticky-cta {
            position: fixed;
            bottom: -100px;
            right: 20px;
            z-index: 40;
            transition: bottom 0.3s ease-out;
        }
        
        #sticky-cta.show {
            bottom: 20px;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
    
    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>

<body class="font-sans bg-gray-50">

    {{-- STICKY CTA BUTTON --}}
    <a href="{{ route('register') }}" id="sticky-cta" class="px-6 py-3 gradient-primary text-white rounded-full font-semibold shadow-lg hover:opacity-90 transition flex items-center gap-2">
        <i data-lucide="rocket" class="w-5 h-5"></i>
        Mulai Sekarang
    </a>

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                            <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAB9klEQVR4AbTV3XVTMRAEYEEl0AlUAlQCVAJUAlQCnST7yR6dvTeyk5f4aKzV7K92dey345U/9xK8q9zfCv+u+FE7DnZ8qZ+uewl+l/nXgoDwuWQc7Hg2ZXJctxKk2j9l/qbwvvCzIAjseD5lcly7BAJ8uJp9ue7/a/9eyNrx3S9245xAG/ScMaPsZEnssJPZap/5sJnoCVSda/YA0/DOFz/q+HyqQ7jDDShKN7TiYwnaoNcl3l0CszUnvm7iEUyn8w2QhsnJ7vwcum18JJl+PUHIdb1psf+K7V47xtL3BGnHut44fvrwPIaj9nIyZFJirRmoGij1094heE9sXrhuQzYDu1iwEnCgEHxlRxRU1YMXNbQARzfaxwzEQNGvBDNbsefgRY2/9WWQcazjIOPAuSMxFLESdIOzrBWeoOqiI+MkCrfdM+RUMq+1tXw5mQcwb5IEqUSrVDyv9/KY05IP3xT5C5sEbuAFMGLg9+g8QPa3wJYPXzYKPtwAKbtEZDuQd3DTzuch4PiZEfnJkCkpZFcFOUhvnfOsyaC42ZI68K3tstKiy2nM50dWISeytpHzS4uL3h592pNE7LY36LN4KKtzb7v+Zu/Lb67zDZCq9cbTR20T1E84jj6ydtDjw4mxsEtAyckM8n8sqGB0QKYXVDFkHN0BjwAAAP///i8VYAAAAAZJREFUAwCP9HAxz3RvwwAAAABJRU5ErkJggg==" 
                                 x="0" 
                                 y="0" 
                                 width="24" 
                                 height="24"
                                 style="filter: brightness(0) invert(1);" 
                            />
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-gray-800">Insight Stress</span>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex gap-4">
                    <a href="{{ route('admin.login') }}" class="px-4 py-2 text-gray-600 hover:text-teal-600 font-medium transition">
                        Admin
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 hover:text-teal-600 font-medium transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 gradient-primary text-white rounded-full font-semibold hover:opacity-90 transition">
                        Daftar
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition" aria-label="Toggle menu">
                    <i data-lucide="menu" class="w-6 h-6 text-gray-600"></i>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="md:hidden overflow-hidden max-h-0" style="max-height: 0px;">
                <div class="pt-4 pb-2 space-y-2">
                    <a href="{{ route('admin.login') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">
                        Admin
                    </a>
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 gradient-primary text-white rounded-lg font-semibold text-center hover:opacity-90 transition">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="pt-32 pb-20 gradient-hero px-6">
        <div class="max-w-5xl mx-auto text-center">

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-teal-100 text-teal-700 font-medium mb-6 fade-in">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                Platform Kesehatan Mental Mahasiswa
            </div>

            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight fade-in">
                Pahami <span class="text-gradient">Tingkat Stres</span> Anda,<br> Tingkatkan Kesejahteraan
            </h1>

            <p class="text-gray-600 text-lg max-w-2xl mx-auto mb-10 fade-in">
                Ambil langkah pertama menuju kesehatan mental yang lebih baik dengan penilaian stress berbasis sains dan rekomendasi personal.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-teal-500 text-white rounded-full font-semibold text-lg hover:bg-teal-600 transition">
                    Mulai Penilaian →
                </a>

                <a href="{{ route('login') }}" class="px-6 py-3 bg-white border border-gray-300 rounded-full font-semibold text-lg hover:bg-gray-100 transition">
                    Sudah Punya Akun
                </a>
            </div>

            {{-- Mood Section --}}
            <div class="mt-20 max-w-4xl mx-auto bg-white shadow-md p-8 rounded-2xl fade-in">
                <h2 class="text-xl font-semibold text-center mb-8">Bagaimana perasaan Anda hari ini?</h2>

                <div class="flex justify-center gap-4 flex-wrap">
                    <!-- Great - Hijau -->
                    <button onclick="showMoodTip('great')" 
                            class="mood-btn flex flex-col items-center gap-3 p-6 rounded-2xl border-2 border-gray-200 hover:border-green-500 hover:bg-green-50 transition-all transform hover:scale-105 min-w-[120px]"
                            aria-label="Luar Biasa">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <i data-lucide="smile" class="w-7 h-7 text-green-600"></i>
                        </div>
                        <span class="text-gray-700 font-medium text-sm">Luar Biasa</span>
                    </button>

                    <!-- Good - Biru -->
                    <button onclick="showMoodTip('good')" 
                            class="mood-btn flex flex-col items-center gap-3 p-6 rounded-2xl border-2 border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition-all transform hover:scale-105 min-w-[120px]"
                            aria-label="Baik">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i data-lucide="smile" class="w-7 h-7 text-blue-600"></i>
                        </div>
                        <span class="text-gray-700 font-medium text-sm">Baik</span>
                    </button>

                    <!-- Okay - Orange -->
                    <button onclick="showMoodTip('okay')" 
                            class="mood-btn flex flex-col items-center gap-3 p-6 rounded-2xl border-2 border-gray-200 hover:border-orange-500 hover:bg-orange-50 transition-all transform hover:scale-105 min-w-[120px]"
                            aria-label="Biasa Saja">
                        <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">
                            <i data-lucide="meh" class="w-7 h-7 text-orange-600"></i>
                        </div>
                        <span class="text-gray-700 font-medium text-sm">Biasa Saja</span>
                    </button>

                    <!-- Stressed - Ungu -->
                    <button onclick="showMoodTip('stressed')" 
                            class="mood-btn flex flex-col items-center gap-3 p-6 rounded-2xl border-2 border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all transform hover:scale-105 min-w-[120px]"
                            aria-label="Tertekan">
                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <i data-lucide="frown" class="w-7 h-7 text-purple-600"></i>
                        </div>
                        <span class="text-gray-700 font-medium text-sm">Tertekan</span>
                    </button>

                    <!-- Overwhelmed - Merah -->
                    <button onclick="showMoodTip('overwhelmed')" 
                            class="mood-btn flex flex-col items-center gap-3 p-6 rounded-2xl border-2 border-gray-200 hover:border-red-500 hover:bg-red-50 transition-all transform hover:scale-105 min-w-[120px]"
                            aria-label="Kewalahan">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <i data-lucide="alert-circle" class="w-7 h-7 text-red-600"></i>
                        </div>
                        <span class="text-gray-700 font-medium text-sm">Kewalahan</span>
                    </button>
                </div>

                <!-- Tip Display Area -->
                <div id="mood-tip" class="mt-8 p-6 rounded-xl hidden transition-all duration-300" role="alert">
                    <p class="font-semibold text-gray-800 mb-3" id="tip-title"></p>
                    <p class="text-gray-600" id="tip-message"></p>
                </div>
            </div>

        </div>
    </section>

    {{-- STATS SECTION --}}
    <section class="py-20 bg-teal-50/30 px-6">
        <div class="max-w-5xl mx-auto">
            
            <!-- Stats Grid -->
            <div class="grid md:grid-cols-3 gap-12 mb-12">
                
                <!-- Stat 1 -->
                <div class="text-center fade-in">
                    <p class="text-6xl font-bold text-teal-600 mb-3">85%</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        mahasiswa merasa kewalahan pada suatu titik
                    </p>
                </div>

                <!-- Stat 2 -->
                <div class="text-center fade-in">
                    <p class="text-6xl font-bold text-teal-600 mb-3">40%</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        melaporkan tingkat stres tinggi secara teratur
                    </p>
                </div>

                <!-- Stat 3 -->
                <div class="text-center fade-in">
                    <p class="text-6xl font-bold text-teal-600 mb-3">73%</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        melihat perbaikan dengan dukungan yang tepat
                    </p>
                </div>

            </div>

            <!-- Message -->
            <p class="text-center text-gray-700 text-lg font-medium fade-in">
                Anda tidak sendirian. Kami di sini untuk membantu.
            </p>

        </div>
    </section>

    {{-- TIPS SECTION --}}
    <section class="py-20 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-3 fade-in">Insight untuk Mengurangi Stress</h2>
            <p class="text-gray-600 text-center mb-12 fade-in">Tips berbasis bukti untuk membantu Anda menghadapi tekanan akademik dengan percaya diri</p>

            <div class="grid md:grid-cols-3 gap-6">

                <!-- Card 1: Mindful Breaks -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition fade-in">
                    <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mb-4">
                        <i data-lucide="brain" class="w-7 h-7 text-green-600"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-gray-800">Jeda Mindful</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Mengambil jeda mindful 5 menit di antara sesi belajar dapat meningkatkan fokus hingga 40%.
                    </p>
                </div>

                <!-- Card 2: Sleep Patterns -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition fade-in">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                        <i data-lucide="moon" class="w-7 h-7 text-blue-600"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-gray-800">Pola Tidur</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Mahasiswa yang menjaga jadwal tidur konsisten melaporkan tingkat stres 30% lebih rendah.
                    </p>
                </div>

                <!-- Card 3: Caffeine Balance -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition fade-in">
                    <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center mb-4">
                        <i data-lucide="coffee" class="w-7 h-7 text-orange-600"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-gray-800">Keseimbangan Kafein</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Membatasi kafein setelah jam 2 siang dapat meningkatkan kualitas tidur Anda secara signifikan.
                    </p>
                </div>

                <!-- Card 4: Social Connection -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition fade-in">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center mb-4">
                        <i data-lucide="users" class="w-7 h-7 text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-gray-800">Koneksi Sosial</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Hanya 15 menit interaksi sosial yang bermakna dapat mengurangi tingkat kortisol.
                    </p>
                </div>

                <!-- Card 5: Study Techniques -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition fade-in">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center mb-4">
                        <i data-lucide="book-open" class="w-7 h-7 text-teal-600"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-gray-800">Teknik Belajar</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Teknik Pomodoro membantu 78% mahasiswa merasa lebih terkontrol atas beban kerja mereka.
                    </p>
                </div>

                <!-- Card 6: Time Blocking -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition fade-in">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-50 flex items-center justify-center mb-4">
                        <i data-lucide="timer" class="w-7 h-7 text-cyan-600"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-gray-800">Time Blocking</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Menjadwalkan waktu khusus untuk khawatir membatasi dampak kecemasan pada jam produktif Anda.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- TESTIMONIAL SECTION --}}
    <section class="py-20 px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-3 fade-in">Apa Kata Mereka?</h2>
            <p class="text-gray-600 text-center mb-12 fade-in">Testimoni dari mahasiswa yang telah merasakan manfaatnya</p>

            <div class="grid md:grid-cols-3 gap-8">
                
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm fade-in">
                    <div class="flex items-center gap-1 mb-4">
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        "Platform ini sangat membantu saya memahami tingkat stress saya. Rekomendasi yang diberikan sangat personal dan mudah diterapkan."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center">
                            <span class="text-teal-600 font-bold text-lg">AS</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Andi Saputra</p>
                            <p class="text-sm text-gray-500">Mahasiswa Teknik Informatika</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm fade-in">
                    <div class="flex items-center gap-1 mb-4">
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        "Saya jadi lebih aware dengan kondisi mental saya. Tips yang diberikan sangat praktis dan efektif untuk mengurangi stress."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-lg">SR</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Siti Rahmawati</p>
                            <p class="text-sm text-gray-500">Mahasiswa Psikologi</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-sm fade-in">
                    <div class="flex items-center gap-1 mb-4">
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-yellow-400"></i>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        "Fitur mood tracker-nya keren! Saya bisa tracking perasaan saya setiap hari dan mendapat insight yang berguna."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-lg">BP</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Budi Prasetyo</p>
                            <p class="text-sm text-gray-500">Mahasiswa Manajemen</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- FAQ SECTION --}}
    <section class="py-20 px-6 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-3 fade-in">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-gray-600 text-center mb-12 fade-in">Temukan jawaban untuk pertanyaan umum tentang platform kami</p>

            <div class="space-y-4">
                
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden fade-in">
                    <button onclick="toggleFaq(1)" class="w-full px-8 py-6 text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800">Apakah platform ini gratis?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 faq-icon-1 transition-transform"></i>
                    </button>
                    <div id="faq-1" class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Ya, platform Insight Stress sepenuhnya gratis untuk semua mahasiswa. Kami percaya bahwa kesehatan mental adalah hak setiap orang dan tidak boleh dibatasi oleh biaya.
                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden fade-in">
                    <button onclick="toggleFaq(2)" class="w-full px-8 py-6 text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800">Apakah data saya aman?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 faq-icon-2 transition-transform"></i>
                    </button>
                    <div id="faq-2" class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Keamanan dan privasi data Anda adalah prioritas utama kami. Semua data dienkripsi dan disimpan dengan aman. Kami tidak akan membagikan informasi pribadi Anda kepada pihak ketiga tanpa izin Anda.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden fade-in">
                    <button onclick="toggleFaq(3)" class="w-full px-8 py-6 text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800">Berapa lama waktu yang dibutuhkan untuk assessment?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 faq-icon-3 transition-transform"></i>
                    </button>
                    <div id="faq-3" class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Assessment biasanya memakan waktu sekitar 5-10 menit. Kami merancang pertanyaan agar efisien namun tetap akurat dalam mengukur tingkat stress Anda.
                        </p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden fade-in">
                    <button onclick="toggleFaq(4)" class="w-full px-8 py-6 text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800">Apakah saya bisa melakukan assessment berkali-kali?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 faq-icon-4 transition-transform"></i>
                    </button>
                    <div id="faq-4" class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Tentu saja! Anda dapat melakukan assessment kapan saja untuk tracking perkembangan kondisi mental Anda. Kami bahkan merekomendasikan untuk melakukan assessment secara berkala.
                        </p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden fade-in">
                    <button onclick="toggleFaq(5)" class="w-full px-8 py-6 text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800">Apakah platform ini menggantikan konsultasi dengan profesional?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 faq-icon-5 transition-transform"></i>
                    </button>
                    <div id="faq-5" class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Platform ini adalah alat bantu untuk memahami kondisi mental Anda, bukan pengganti konsultasi profesional. Jika Anda mengalami stress berat atau masalah kesehatan mental serius, kami sangat menyarankan untuk berkonsultasi dengan psikolog atau konselor profesional.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="gradient-primary p-14 text-center rounded-3xl shadow-lg fade-in">
                <h2 class="text-3xl font-bold text-white mb-4">Siap Memulai Perjalanan Kesehatan Mental Anda?</h2>
                <p class="text-white/90 mb-8">Daftar sekarang untuk analisis stres akurat.</p>
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 rounded-full bg-white text-teal-600 font-semibold text-lg hover:bg-gray-100 transition">
                    Daftar Gratis Sekarang →
                </a>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300 py-12 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                
                {{-- Brand --}}
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAB9klEQVR4AbTV3XVTMRAEYEEl0AlUAlQCVAJUAlQCnST7yR6dvTeyk5f4aKzV7K92dey345U/9xK8q9zfCv+u+FE7DnZ8qZ+uewl+l/nXgoDwuWQc7Hg2ZXJctxKk2j9l/qbwvvCzIAjseD5lcly7BAJ8uJp9ue7/a/9eyNrx3S9245xAG/ScMaPsZEnssJPZap/5sJnoCVSda/YA0/DOFz/q+HyqQ7jDDShKN7TiYwnaoNcl3l0CszUnvm7iEUyn8w2QhsnJ7vwcum18JJl+PUHIdb1psf+K7V47xtL3BGnHut44fvrwPIaj9nIyZFJirRmoGij1094heE9sXrhuQzYDu1iwEnCgEHxlRxRU1YMXNbQARzfaxwzEQNGvBDNbsefgRY2/9WWQcazjIOPAuSMxFLESdIOzrBWeoOqiI+MkCrfdM+RUMq+1tXw5mQcwb5IEqUSrVDyv9/KY05IP3xT5C5sEbuAFMGLg9+g8QPa3wJYPXzYKPtwAKbtEZDuQd3DTzuch4PiZEfnJkCkpZFcFOUhvnfOsyaC42ZI68K3tstKiy2nM50dWISeytpHzS4uL3h592pNE7LY36LN4KKtzb7v+Zu/Lb67zDZCq9cbTR20T1E84jj6ydtDjw4mxsEtAyckM8n8sqGB0QKYXVDFkHN0BjwAAAP///i8VYAAAAAZJREFUAwCP9HAxz3RvwwAAAABJRU5ErkJggg==" 
                                     x="0" 
                                     y="0" 
                                     width="24" 
                                     height="24"
                                     style="filter: brightness(0) invert(1);" 
                                />
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-white">Insight Stress</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        Platform kesehatan mental untuk mahasiswa. Kami membantu Anda memahami dan mengelola stress dengan pendekatan berbasis sains.
                    </p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="font-semibold text-white mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-teal-400 transition">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-teal-400 transition">Daftar</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-teal-400 transition">Admin</a></li>
                    </ul>
                </div>

            </div>

            {{-- Bottom Bar --}}
            <div class="pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
                <p>© 2025 Insight Stress Mahasiswa. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script>
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Sticky CTA button
        const stickyCta = document.getElementById('sticky-cta');
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Show sticky CTA after scrolling down 500px
            if (scrollTop > 500) {
                stickyCta.classList.add('show');
            } else {
                stickyCta.classList.remove('show');
            }
            
            lastScrollTop = scrollTop;
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuBtn.addEventListener('click', () => {
            if (mobileMenu.style.maxHeight === '0px' || mobileMenu.style.maxHeight === '') {
                mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
            } else {
                mobileMenu.style.maxHeight = '0px';
            }
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.addEventListener('DOMContentLoaded', () => {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(el => observer.observe(el));
            
            // Re-initialize icons after DOM is ready
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        // Mood tip functionality
        function showMoodTip(mood) {
            const tipDiv = document.getElementById('mood-tip');
            const tipTitle = document.getElementById('tip-title');
            const tipMessage = document.getElementById('tip-message');
            
            // Reset classes
            tipDiv.className = 'mt-8 p-6 rounded-xl transition-all duration-300';
            
            // Set title
            tipTitle.textContent = 'Terima kasih sudah berbagi! Berikut tips berdasarkan perasaan Anda:';
            
            // Set message and styling based on mood
            switch(mood) {
                case 'great':
                case 'good':
                    tipDiv.classList.add('bg-green-50', 'border-l-4', 'border-green-500');
                    tipMessage.textContent = 'Anda luar biasa! Pertahankan momentum positif dengan merayakan pencapaian kecil hari ini.';
                    break;
                case 'okay':
                    tipDiv.classList.add('bg-orange-50', 'border-l-4', 'border-orange-500');
                    tipMessage.textContent = 'Luangkan waktu sejenak untuk bernapas dalam-dalam. Bahkan istirahat 5 menit dapat membantu menyegarkan pikiran Anda.';
                    break;
                case 'stressed':
                case 'overwhelmed':
                    tipDiv.classList.add('bg-red-50', 'border-l-4', 'border-red-500');
                    tipMessage.textContent = 'Ingat, tidak apa-apa merasa seperti ini. Coba teknik pernapasan 4-7-8: tarik napas selama 4 detik, tahan selama 7 detik, buang napas selama 8 detik.';
                    break;
            }
            
            // Show with animation
            tipDiv.classList.remove('hidden');
            setTimeout(() => {
                tipDiv.style.opacity = '1';
            }, 10);
        }

        // FAQ toggle functionality
        function toggleFaq(index) {
            const answer = document.getElementById(`faq-${index}`);
            const icon = document.querySelector(`.faq-icon-${index}`);
            
            // Toggle answer
            answer.classList.toggle('active');
            
            // Rotate icon
            icon.style.transform = answer.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    </script>

    @vite('resources/js/app.js')

</body>
</html>