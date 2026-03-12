<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Register') }} - Insight Stress</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-[#e8f9f8] to-white px-4 py-12">

    <div class="w-full max-w-md animate-fadeIn">

        {{-- LOGO --}}
        <div class="flex justify-center mb-8">
            @include('components.logo')
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4 text-center">
                @foreach($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-md p-8 md:p-10">

            <h2 class="text-2xl font-bold text-center">{{ __('Create Account') }}</h2>
            <p class="text-gray-500 text-center text-sm mb-6">{{ __('Register to start your stress assessment') }}</p>

            <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="text-sm font-medium">{{ __('Full Name') }}</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2"> @include('components.icons.user')</span>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full pl-10 px-4 py-3 border rounded-xl focus:ring-teal-400"
                            placeholder="John Doe">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-sm font-medium">{{ __('Email') }}</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2"> @include('components.icons.mail')</span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-10 px-4 py-3 border rounded-xl focus:ring-teal-400"
                            placeholder="nama@email.com">
                    </div>
                </div>

                {{-- NIM + Semester --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">NIM</label>
                        <div class="relative mt-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2"> @include('components.icons.hash')</span>
                            <input type="text" name="nim" value="{{ old('nim') }}" required
                                class="w-full pl-10 px-4 py-3 border rounded-xl focus:ring-teal-400"
                                placeholder="123456789">
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium">{{ __('Semester') }}</label>
                        <input type="number" name="semester" min="1" max="14" required
                            value="{{ old('semester') }}"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-teal-400"
                            placeholder="5">
                    </div>
                </div>

                {{-- Gender + Age --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">{{ __('Gender') }}</label>
                        <div class="relative mt-1">
                            <select name="gender" required
                                class="w-full px-4 py-3 border rounded-xl focus:ring-teal-400 appearance-none bg-white">
                                <option value="">{{ __('Select Gender') }}</option>
                                <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>{{ __('Female') }}</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium">{{ __('Age') }}</label>
                        <input type="number" name="age" min="15" max="100" required
                            value="{{ old('age') }}"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-teal-400"
                            placeholder="20">
                    </div>
                </div>

                {{-- Major --}}
                <div>
                    <label class="text-sm font-medium">{{ __('Major') }}</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"> @include('components.icons.book')</span>
                        <select name="jurusan" required
                            class="w-full pl-10 px-4 py-3 border rounded-xl focus:ring-teal-400 appearance-none bg-white">
                            <option value="">{{ __('Select Major') }}</option>
                            <option value="Teknik Informatika" {{ old('jurusan') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                            <option value="Sistem Informasi" {{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="Bisnis Digital" {{ old('jurusan') == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
                            <option value="Rekayasa Perangkat Lunak" {{ old('jurusan') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                            <option value="Manajemen Informatika" {{ old('jurusan') == 'Manajemen Informatika' ? 'selected' : '' }}>Manajemen Informatika</option>
                        </select>
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="text-sm font-medium">{{ __('Password') }}</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2"> @include('components.icons.lock')</span>
                        <input type="password" name="password" required
                            class="w-full pl-10 px-4 py-3 border rounded-xl focus:ring-teal-400"
                            placeholder="••••••••">
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="text-sm font-medium">{{ __('Confirm Password') }}</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2"> @include('components.icons.lock')</span>
                        <input type="password" name="password_confirmation" required
                            class="w-full pl-10 px-4 py-3 border rounded-xl focus:ring-teal-400"
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-teal-500 to-teal-400 text-white font-semibold text-lg hover:opacity-90 transition">
                    {{ __('Register Now') }} →
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" class="text-teal-600 hover:underline font-medium">{{ __('Login') }}</a>
            </p>

        </div>
    </div>

</body>
</html>