<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login') }} - Insight Stress</title>
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
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4 text-center">
                @if(session('need_verification'))
                    {{ __('Account not yet active or not verified. Please') }}
                    <form action="{{ route('verification.resend.public') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email_for_verification') }}">
                        <button type="submit" class="font-semibold underline text-teal-600 hover:text-teal-800">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>
                    {{ __('then check your email.') }}
                @else
                    {{ session('error') }}
                @endif
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-md p-8 md:p-10">

            <h2 class="text-2xl font-bold text-center">{{ __('Welcome Back') }}</h2>
            <p class="text-gray-500 text-center text-sm mb-6">{{ __('Login to your account to continue') }}</p>

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="text-sm font-medium">{{ __('Email') }}</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2"> @include('components.icons.mail')</span>
                        <input type="email" name="email" required
                            class="w-full pl-10 px-4 py-3 border rounded-xl focus:ring-teal-400"
                            placeholder="nama@email.com">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex justify-between">
                        <label class="text-sm font-medium">{{ __('Password') }}</label>
                        <a href="{{ route('password.request') }}" class="text-sm text-teal-600 hover:underline">{{ __('Forgot password?') }}</a>
                    </div>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2"> @include('components.icons.lock')</span>
                        <input type="password" name="password" required
                            class="w-full pl-10 px-4 py-3 border rounded-xl focus:ring-teal-400"
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-teal-500 to-teal-400 text-white font-semibold text-lg hover:opacity-90 transition">
                    {{ __('Login') }} →
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="text-teal-600 hover:underline font-medium">{{ __('Register now') }}</a>
            </p>

        </div>
    </div>

</body>
</html>