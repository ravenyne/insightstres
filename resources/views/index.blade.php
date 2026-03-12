<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insight Stress - {{ __('AI Mental Health Platform for Students') }}</title>

    {{-- SEO Meta Tags --}}
    <meta name="description" content="{{ __('Insight Stress helps students monitor mental well-being and generates AI-driven insights for healthier academic environments.') }}">
    <meta name="keywords" content="mental health, student stress, stress assessment, AI, wellbeing, university">
    <meta name="author" content="Insight Stress">

    {{-- Open Graph --}}
    <meta property="og:title" content="Insight Stress - AI Mental Health Platform">
    <meta property="og:description" content="{{ __('Insight Stress helps students monitor mental well-being and generates AI-driven insights for healthier academic environments.') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">

    @vite('resources/css/app.css')

    <style>
        .gradient-primary { background: linear-gradient(135deg, #0fb7b3, #17c8c1); }
        .gradient-hero    { background: linear-gradient(180deg, #e8f9f8 0%, #ffffff 100%); }
        .text-gradient {
            background: linear-gradient(90deg, #0fb7b3, #0bbcd1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        html { scroll-behavior: smooth; }

        /* Fade-in animations */
        .fade-in {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s ease-out, transform 0.65s ease-out;
        }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        /* Step connector */
        .step-connector {
            position: absolute;
            top: 50%;
            left: calc(50% + 56px);
            width: calc(100% - 112px);
            height: 2px;
            background: linear-gradient(90deg, #0fb7b3, transparent);
        }

        /* Card hover */
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(15,183,179,0.12); }
        .feature-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }

        /* Mobile menu */
        #mobile-menu { transition: max-height 0.3s ease-in-out; }

        /* FAQ */
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; }
        .faq-answer.active { max-height: 400px; }

        /* Sticky CTA */
        #sticky-cta {
            position: fixed; bottom: -100px; right: 20px; z-index: 40;
            transition: bottom 0.3s ease-out;
        }
        #sticky-cta.show { bottom: 20px; }
    </style>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="font-sans bg-white antialiased">

    {{-- STICKY CTA --}}
    <a href="{{ route('register') }}" id="sticky-cta" class="px-5 py-3 gradient-primary text-white rounded-full font-semibold shadow-lg hover:opacity-90 transition flex items-center gap-2 text-sm">
        <i data-lucide="rocket" class="w-4 h-4"></i>
        {{ __('Start Now') }}
    </a>

    {{-- ===================== NAVBAR ===================== --}}
    <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                            <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAB9klEQVR4AbTV3XVTMRAEYEEl0AlUAlQCVAJUAlQCnST7yR6dvTeyk5f4aKzV7K92dey345U/9xK8q9zfCv+u+FE7DnZ8qZ+uewl+l/nXgoDwuWQc7Hg2ZXJctxKk2j9l/qbwvvCzIAjseD5lcly7BAJ8uJp9ue7/a/9eyNrx3S9245xAG/ScMaPsZEnssJPZap/5sJnoCVSda/YA0/DOFz/q+HyqQ7jDDShKN7TiYwnaoNcl3l0CszUnvm7iEUyn8w2QhsnJ7vwcum18JJl+PUHIdb1psf+K7V47xtL3BGnHut44fvrwPIaj9nIyZFJirRmoGij1094heE9sXrhuQzYDu1iwEnCgEHxlRxRU1YMXNbQARzfaxwzEQNGvBDNbsefgRY2/9WWQcazjIOPAuSMxFLESdIOzrBWeoOqiI+MkCrfdM+RUMq+1tXw5mQcwb5IEqUSrVDyv9/KY05IP3xT5C5sEbuAFMGLg9+g8QPa3wJYPXzYKPtwAKbtEZDuQd3DTzuch4PiZEfnJkCkpZFcFOUhvnfOsyaC42ZI68K3tstKiy2nM50dWISeytpHzS4uL3h592pNE7LY36LN4KKtzb7v+Zu/Lb67zDZCq9cbTR20T1E84jj6ydtDjw4mxsEtAyckM8n8sqGB0QKYXVDFkHN0BjwAAAP///i8VYAAAAAZJREFUAwCP9HAxz3RvwwAAAABJRU5ErkJggg==" x="0" y="0" width="24" height="24" style="filter:brightness(0) invert(1)"/>
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-gray-800 tracking-tight">Insight Stress</span>
                </div>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-3">
                    <a href="#features" class="px-4 py-2 text-gray-600 hover:text-teal-600 font-medium transition text-sm">{{ __('Features') }}</a>
                    <a href="#how-it-works" class="px-4 py-2 text-gray-600 hover:text-teal-600 font-medium transition text-sm">{{ __('How It Works') }}</a>
                    <a href="{{ route('admin.login') }}" class="px-4 py-2 text-gray-600 hover:text-teal-600 font-medium transition text-sm">Admin</a>
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 hover:text-teal-600 font-medium transition text-sm">{{ __('Login') }}</a>

                    {{-- Language Switcher --}}
                    <div class="flex items-center gap-1 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <a href="{{ route('lang.switch', 'id') }}" class="text-sm font-medium transition {{ app()->getLocale() == 'id' ? 'text-teal-600 font-bold' : 'text-gray-500 hover:text-teal-600' }}">ID</a>
                        <span class="text-gray-300 text-sm">/</span>
                        <a href="{{ route('lang.switch', 'en') }}" class="text-sm font-medium transition {{ app()->getLocale() == 'en' ? 'text-teal-600 font-bold' : 'text-gray-500 hover:text-teal-600' }}">EN</a>
                    </div>
                </div>

                {{-- Mobile Toggle --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="menu" class="w-6 h-6 text-gray-600"></i>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="md:hidden overflow-hidden max-h-0">
                <div class="pt-4 pb-2 space-y-1">
                    <a href="#features" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">{{ __('Features') }}</a>
                    <a href="#how-it-works" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">{{ __('How It Works') }}</a>
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">{{ __('Login') }}</a>
                    {{-- Mobile Language Switcher --}}
                    <div class="flex items-center gap-2 px-4 py-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <a href="{{ route('lang.switch', 'id') }}" class="text-sm font-medium {{ app()->getLocale() == 'id' ? 'text-teal-600 font-bold' : 'text-gray-500' }}">ID</a>
                        <span class="text-gray-300">/</span>
                        <a href="{{ route('lang.switch', 'en') }}" class="text-sm font-medium {{ app()->getLocale() == 'en' ? 'text-teal-600 font-bold' : 'text-gray-500' }}">EN</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ===================== HERO SECTION ===================== --}}
    <section class="relative min-h-[calc(100vh-68px)] flex items-center gradient-hero px-6 overflow-hidden py-12">
        {{-- Background decoration --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-teal-100/50 blur-3xl"></div>
            <div class="absolute bottom-0 -left-20 w-80 h-80 rounded-full bg-cyan-100/40 blur-3xl"></div>
        </div>

        <div class="relative max-w-5xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-teal-100 text-teal-700 font-medium mb-8 fade-in text-sm">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                {{ __('AI-Powered Mental Health Platform for Students') }}
            </div>

            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight tracking-tight fade-in">
                {{ __('Understanding') }} <span class="text-gradient">{{ __('Student Stress') }}</span><br>
                {{ __('to Build a Healthier Academic Environment') }}
            </h1>

            <p class="text-gray-600 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed fade-in">
                {{ __('Insight Stress helps students monitor their mental well-being while generating AI-driven insights that help universities understand and reduce academic pressure.') }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 gradient-primary text-white rounded-full font-semibold text-lg hover:opacity-90 transition shadow-lg shadow-teal-200">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                    {{ __('Start Assessment') }}
                </a>
                <a href="#features" class="inline-flex items-center gap-2 px-8 py-4 bg-white border-2 border-gray-200 rounded-full font-semibold text-lg text-gray-700 hover:border-teal-400 hover:text-teal-600 transition">
                    <i data-lucide="play-circle" class="w-5 h-5"></i>
                    {{ __('Learn More') }}
                </a>
            </div>

            {{-- Stats Bar --}}
            <div class="mt-16 grid grid-cols-3 gap-6 max-w-2xl mx-auto fade-in">
                <div class="text-center">
                    <p class="text-3xl font-bold text-teal-600">85%</p>
                    <p class="text-sm text-gray-500 mt-1">{{ __('Students face high academic pressure') }}</p>
                </div>
                <div class="text-center border-x border-gray-200">
                    <p class="text-3xl font-bold text-teal-600">AI</p>
                    <p class="text-sm text-gray-500 mt-1">{{ __('Neural network analysis') }}</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-teal-600">73%</p>
                    <p class="text-sm text-gray-500 mt-1">{{ __('Feel better with proper support') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== FEATURES SECTION ===================== --}}
    <section id="features" class="py-24 px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-block px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-sm font-semibold mb-4 fade-in">{{ __('Platform Capabilities') }}</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 fade-in">{{ __('Key Features') }}</h2>
                <p class="text-gray-600 max-w-xl mx-auto fade-in">{{ __('Everything you need to understand, track, and improve your mental well-being.') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Feature 1 --}}
                <div class="feature-card bg-gray-50 rounded-2xl p-7 fade-in">
                    <div class="w-12 h-12 rounded-xl bg-teal-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('AI Stress Analysis') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('Automatically analyzes student stress patterns using neural network predictions.') }}</p>
                </div>

                {{-- Feature 2 --}}
                <div class="feature-card bg-gray-50 rounded-2xl p-7 fade-in">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Mental Health Monitoring') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('Students can regularly track their emotional state and stress level over time.') }}</p>
                </div>

                {{-- Feature 3 --}}
                <div class="feature-card bg-gray-50 rounded-2xl p-7 fade-in">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Personalized Recommendations') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('The system suggests breathing exercises, mindfulness techniques, and study balance tips.') }}</p>
                </div>

                {{-- Feature 4 --}}
                <div class="feature-card bg-gray-50 rounded-2xl p-7 fade-in">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Data Insight for Universities') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('Aggregated data helps institutions understand academic pressure trends and take action.') }}</p>
                </div>

                {{-- Feature 5 --}}
                <div class="feature-card bg-gray-50 rounded-2xl p-7 fade-in">
                    <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Breathing Exercise Tools') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('Built-in guided breathing techniques to help reduce stress quickly and effectively.') }}</p>
                </div>

                {{-- Feature 6 --}}
                <div class="feature-card bg-gray-50 rounded-2xl p-7 fade-in">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Stress History Tracking') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('Students can monitor their stress progression over time with detailed history charts.') }}</p>
                </div>

            </div>
        </div>
    </section>

    {{-- ===================== HOW IT WORKS ===================== --}}
    <section id="how-it-works" class="py-24 px-6 bg-gradient-to-b from-teal-50/60 to-white">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-block px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-sm font-semibold mb-4 fade-in">{{ __('Simple Process') }}</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 fade-in">{{ __('How Insight Stress Works') }}</h2>
                <p class="text-gray-600 max-w-lg mx-auto fade-in">{{ __('Three simple steps to understand and manage your mental well-being.') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                {{-- Connector lines (desktop) --}}
                <div class="hidden md:block absolute top-10 left-[calc(33%+16px)] right-[calc(33%+16px)] h-0.5 bg-gradient-to-r from-teal-300 to-teal-300 z-0"></div>

                {{-- Step 1 --}}
                <div class="relative z-10 text-center fade-in">
                    <div class="w-20 h-20 rounded-2xl gradient-primary flex items-center justify-center mx-auto mb-6 shadow-lg shadow-teal-200">
                        <span class="text-white text-2xl font-bold">1</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ __('Take the Assessment') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('Students complete a quick, science-based stress assessment in under 10 minutes.') }}</p>
                </div>

                {{-- Step 2 --}}
                <div class="relative z-10 text-center fade-in">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-purple-200">
                        <span class="text-white text-2xl font-bold">2</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ __('AI Analyzes Your Data') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('The AI model analyzes stress patterns and identifies risk indicators using neural networks.') }}</p>
                </div>

                {{-- Step 3 --}}
                <div class="relative z-10 text-center fade-in">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-orange-200">
                        <span class="text-white text-2xl font-bold">3</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ __('Receive Personalized Insights') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('The platform generates insights and personalized recommendations to improve your well-being.') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== IMPACT / WHY THIS MATTERS ===================== --}}
    <section class="py-24 px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Left Text --}}
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-orange-50 text-orange-700 text-sm font-semibold mb-4 fade-in">{{ __('Impact & Mission') }}</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 fade-in leading-tight">{{ __('Why This Matters') }}</h2>
                    <p class="text-gray-600 leading-relaxed mb-8 fade-in">
                        {{ __('Academic stress is one of the leading mental health challenges among university students. Insight Stress provides early detection and actionable insights to support healthier academic environments.') }}
                    </p>

                    <div class="space-y-4 fade-in">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('AI-Powered Analysis') }}</p>
                                <p class="text-gray-600 text-sm mt-1">{{ __('Neural network models trained to detect and classify student stress levels accurately.') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('Data-Driven Mental Health Insights') }}</p>
                                <p class="text-gray-600 text-sm mt-1">{{ __('Aggregated and anonymized data surfaces trends universities can act on.') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('Built for Students and Universities') }}</p>
                                <p class="text-gray-600 text-sm mt-1">{{ __('Designed to serve both the individual student and the academic institution as a whole.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Stats --}}
                <div class="grid grid-cols-2 gap-5 fade-in">
                    <div class="bg-teal-50 rounded-2xl p-7">
                        <p class="text-5xl font-bold text-teal-600 mb-2">85%</p>
                        <p class="text-gray-700 text-sm font-medium">{{ __('Students report high academic pressure during their study period') }}</p>
                    </div>
                    <div class="bg-purple-50 rounded-2xl p-7 mt-6">
                        <p class="text-5xl font-bold text-purple-600 mb-2">40%</p>
                        <p class="text-gray-700 text-sm font-medium">{{ __('Rarely monitor their mental health regularly') }}</p>
                    </div>
                    <div class="bg-orange-50 rounded-2xl p-7 -mt-6">
                        <p class="text-5xl font-bold text-orange-500 mb-2">73%</p>
                        <p class="text-gray-700 text-sm font-medium">{{ __('Feel better after receiving proper mental health support') }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-2xl p-7">
                        <p class="text-5xl font-bold text-blue-600 mb-2">AI</p>
                        <p class="text-gray-700 text-sm font-medium">{{ __('Neural network driving every analysis and recommendation') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== TESTIMONIALS ===================== --}}
    <section class="py-24 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-block px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 text-sm font-semibold mb-4 fade-in">{{ __('Testimonials') }}</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 fade-in">{{ __('What Students Say') }}</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([
                    ['initials'=>'DH','name'=>'Diaz Herlangga','major'=>'Informatics Engineering','color'=>'teal',
                     'quote'=>__('This platform helped me understand my stress patterns throughout the semester. The insights made me more aware of when to rest and how to manage my study time.')],
                    ['initials'=>'CW','name'=>'Christi Wilhelmia','major'=>'Information Systems','color'=>'purple',
                     'quote'=>__('I became more aware of my own mental state. The system helps me see the relationship between my class schedule, sleep quality, and stress levels.')],
                    ['initials'=>'RF','name'=>'Rahma Fitri','major'=>'Digital Business','color'=>'blue',
                     'quote'=>__('The mood tracking feature is super helpful for reflecting on my condition every day. The insights feel practical and relevant for student life.')]
                ] as $t)
                <div class="bg-white rounded-2xl p-8 shadow-sm fade-in">
                    <div class="flex gap-1 mb-5">
                        @for($i=0;$i<5;$i++)<svg class="w-4 h-4 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed text-sm">"{{ $t['quote'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-{{ $t['color'] }}-100 flex items-center justify-center">
                            <span class="text-{{ $t['color'] }}-600 font-bold text-sm">{{ $t['initials'] }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">{{ $t['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ __('Student') }} — {{ $t['major'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== FINAL CTA ===================== --}}
    <section class="py-24 px-6 bg-white">
        <div class="max-w-3xl mx-auto text-center">
            <div class="bg-gradient-to-br from-teal-500 via-teal-500 to-cyan-500 rounded-3xl p-14 shadow-2xl shadow-teal-200/60 fade-in relative overflow-hidden">
                {{-- Decorative circles --}}
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full bg-white/10"></div>

                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 relative">
                    {{ __('Start Understanding Your Stress Today') }}
                </h2>
                <p class="text-white/85 mb-10 max-w-xl mx-auto relative text-lg">
                    {{ __('Join thousands of students who use Insight Stress to monitor their mental well-being and build healthier habits.') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center relative">
                    <a href="{{ route('user.assessment') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-teal-600 rounded-full font-bold text-lg hover:bg-gray-50 transition shadow-lg">
                        <i data-lucide="activity" class="w-5 h-5"></i>
                        {{ __('Start Assessment') }}
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white/20 border border-white/40 text-white rounded-full font-bold text-lg hover:bg-white/30 transition">
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                        {{ __('Create Account') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== FOOTER ===================== --}}
    <footer class="bg-gray-900 text-gray-300 py-14 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-3 gap-10 mb-10">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 24 24">
                                <image xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAB9klEQVR4AbTV3XVTMRAEYEEl0AlUAlQCVAJUAlQCnST7yR6dvTeyk5f4aKzV7K92dey345U/9xK8q9zfCv+u+FE7DnZ8qZ+uewl+l/nXgoDwuWQc7Hg2ZXJctxKk2j9l/qbwvvCzIAjseD5lcly7BAJ8uJp9ue7/a/9eyNrx3S9245xAG/ScMaPsZEnssJPZap/5sJnoCVSda/YA0/DOFz/q+HyqQ7jDDShKN7TiYwnaoNcl3l0CszUnvm7iEUyn8w2QhsnJ7vwcum18JJl+PUHIdb1psf+K7V47xtL3BGnHut44fvrwPIaj9nIyZFJirRmoGij1094heE9sXrhuQzYDu1iwEnCgEHxlRxRU1YMXNbQARzfaxwzEQNGvBDNbsefgRY2/9WWQcazjIOPAuSMxFLESdIOzrBWeoOqiI+MkCrfdM+RUMq+1tXw5mQcwb5IEqUSrVDyv9/KY05IP3xT5C5sEbuAFMGLg9+g8QPa3wJYPXzYKPtwAKbtEZDuQd3DTzuch4PiZEfnJkCkpZFcFOUhvnfOsyaC42ZI68K3tstKiy2nM50dWISeytpHzS4uL3h592pNE7LY36LN4KKtzb7v+Zu/Lb67zDZCq9cbTR20T1E84jj6ydtDjw4mxsEtAyckM8n8sqGB0QKYXVDFkHN0BjwAAAP///i8VYAAAAAZJREFUAwCP9HAxz3RvwwAAAABJRU5ErkJggg==" x="0" y="0" width="24" height="24" style="filter:brightness(0) invert(1)"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-white">Insight Stress</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        {{ __('AI-powered mental health platform for university students. Detect stress early, get personalized recommendations, and build healthier academic habits.') }}
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-4">{{ __('Quick Links') }}</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-teal-400 transition">{{ __('Features') }}</a></li>
                        <li><a href="#how-it-works" class="hover:text-teal-400 transition">{{ __('How It Works') }}</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-teal-400 transition">{{ __('Login') }}</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-teal-400 transition">{{ __('Register') }}</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-teal-400 transition">Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
                <p>© {{ date('Y') }} Insight Stress. {{ __('All rights reserved.') }}</p>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script>
        lucide.createIcons();

        // Sticky CTA
        const stickyCta = document.getElementById('sticky-cta');
        window.addEventListener('scroll', () => {
            stickyCta.classList.toggle('show', window.scrollY > 500);
        });

        // Mobile menu
        document.getElementById('mobile-menu-btn').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.style.maxHeight = (menu.style.maxHeight === '0px' || !menu.style.maxHeight)
                ? menu.scrollHeight + 'px' : '0px';
        });

        // Scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    </script>

    @vite('resources/js/app.js')

</body>
</html>