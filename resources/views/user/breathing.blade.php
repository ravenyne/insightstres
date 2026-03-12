@extends('layouts.dashboard')

@section('content')
<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Latihan Pernapasan') }}</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2">{{ __('Teknik pernapasan untuk mengurangi stres dan meningkatkan fokus') }}</p>
    </div>

    {{-- Tips (Moved Above) --}}
    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-6">
        <div class="flex gap-3">
            <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5"></i>
            <div>
                <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">{{ __('Tips Latihan Pernapasan') }}</h3>
                <ul class="space-y-1 text-sm text-blue-800 dark:text-blue-400">
                    <li>• {{ __('Cari tempat yang tenang dan nyaman') }}</li>
                    <li>• {{ __('Duduk dengan postur tegak atau berbaring dengan nyaman') }}</li>
                    <li>• {{ __('Fokus pada pernapasan dan biarkan pikiran lain berlalu') }}</li>
                    <li>• {{ __('Lakukan minimal 5 menit untuk hasil optimal') }}</li>
                    <li>• {{ __('Praktik rutin setiap hari untuk manfaat jangka panjang') }}</li>
                </ul>
            </div>
        </div>
    </div>

    @if(isset($latestAssessment) && $recommendedTechnique)
    {{-- Personalized Recommendation --}}
    <div class="bg-teal-50 dark:bg-teal-900/20 rounded-xl border border-teal-200 dark:border-teal-800 p-4 flex items-center gap-3">
        <i data-lucide="sparkles" class="w-5 h-5 text-teal-600 dark:text-teal-400 flex-shrink-0"></i>
        <p class="text-teal-800 dark:text-teal-300 text-sm">
            {{ __('Berdasarkan hasil penilaian terakhir Anda, latihan ini direkomendasikan untuk membantu mengurangi stres.') }}
        </p>
    </div>
    @endif

    {{-- Pattern Selection --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6" id="pattern-selection">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Pilih Pola Pernapasan') }}</h2>
        
        <div class="grid md:grid-cols-2 gap-4">
            <button onclick="selectPattern('478')" id="pattern-478" class="pattern-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-teal-500 dark:hover:border-teal-500 transition text-left">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-400 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="wind" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white">4-7-8 Breathing</h3>
                            @if(isset($recommendedTechnique) && $recommendedTechnique === '4-7-8')
                                <span class="text-[10px] bg-teal-500 text-white px-2 py-0.5 rounded-full uppercase tracking-wider font-bold">Recommended</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Tarik 4s • Tahan 7s • Hembuskan 8s') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ __('Untuk tidur & relaksasi') }}</p>
                    </div>
                </div>
            </button>

            <button onclick="selectPattern('box')" id="pattern-box" class="pattern-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-teal-500 dark:hover:border-teal-500 transition text-left">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><rect width="18" height="18" x="3" y="3" rx="2" /></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Box Breathing</h3>
                            @if(isset($recommendedTechnique) && $recommendedTechnique === 'box')
                                <span class="text-[10px] bg-teal-500 text-white px-2 py-0.5 rounded-full uppercase tracking-wider font-bold">Recommended</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Tarik 4s • Tahan 4s • Hembuskan 4s • Tahan 4s') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ __('Untuk fokus & konsentrasi') }}</p>
                    </div>
                </div>
            </button>

            <button onclick="selectPattern('deep')" id="pattern-deep" class="pattern-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-teal-500 dark:hover:border-teal-500 transition text-left">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="activity" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Deep Breathing</h3>
                            @if(isset($recommendedTechnique) && $recommendedTechnique === 'deep')
                                <span class="text-[10px] bg-teal-500 text-white px-2 py-0.5 rounded-full uppercase tracking-wider font-bold">Recommended</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Tarik 5s • Hembuskan 5s') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ __('Untuk relaksasi cepat') }}</p>
                    </div>
                </div>
            </button>

            <button onclick="selectPattern('calm')" id="pattern-calm" class="pattern-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-teal-500 dark:hover:border-teal-500 transition text-left">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="heart" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Calm Breathing</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Tarik 3s • Hembuskan 6s') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ __('Untuk mengurangi kecemasan') }}</p>
                    </div>
                </div>
            </button>
        </div>
    </div>

    {{-- Breathing Circle Session --}}
    <div id="breathing-session" class="hidden bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow p-8">
        <div class="flex flex-col items-center justify-center min-h-[500px]">
            {{-- Session Title --}}
            <h2 id="session-title" class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center"></h2>

            {{-- Circle Animation --}}
            <div class="relative mb-8">
                <div id="breathing-circle" class="w-64 h-64 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center shadow-2xl transition-all ease-in-out">
                    <div class="text-center text-white">
                        <p id="breathing-instruction" class="text-2xl font-bold mb-2">{{ __('Siap Mulai') }}</p>
                        <p id="breathing-counter" class="text-6xl font-bold"></p>
                    </div>
                </div>
            </div>

            {{-- Controls --}}
            <div class="flex gap-4 mb-6">
                <button id="start-btn" onclick="startBreathing()" class="px-8 py-3 bg-teal-500 text-white rounded-xl font-semibold hover:bg-teal-600 transition flex items-center gap-2">
                    <i data-lucide="play" class="w-5 h-5"></i>
                    {{ __('Bantu Mulai') }}
                </button>
                <button id="stop-btn" onclick="stopBreathing()" class="px-8 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition flex items-center gap-2 hidden">
                    <i data-lucide="square" class="w-5 h-5"></i>
                    {{ __('Berhenti') }}
                </button>
                <button id="back-btn" onclick="showPatternSelection()" class="px-8 py-3 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    {{ __('Kembali') }}
                </button>
            </div>

            {{-- Session Info --}}
            <div class="text-center bg-white dark:bg-gray-800/60 px-6 py-3 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700/50">
                <div class="flex items-center gap-6 text-sm">
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>{{ __('Durasi sesi') }}: <span id="session-duration" class="font-bold text-teal-600 dark:text-teal-400">0:00</span></span>
                    </div>
                    <div class="w-px h-4 bg-gray-300 dark:bg-gray-600"></div>
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        <span>{{ __('Putaran') }}: <span id="session-count" class="font-bold text-teal-600 dark:text-teal-400">0</span> / <span id="target-rounds">8</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    let currentPattern = null;
    let isBreathing = false;
    let sessionCount = 0;
    let targetRounds = 8;
    let sessionSeconds = 0;
    let timerInterval = null;
    let cycleTimeout = null;
    let countdownInterval = null;

    const patterns = {
        '478': {
            name: '4-7-8 Breathing',
            target: 8,
            steps: [
                { instruction: '{{ __("Tarik Napas") }}', duration: 4, scale: 1.3 },
                { instruction: '{{ __("Tahan") }}', duration: 7, scale: 1.3 },
                { instruction: '{{ __("Hembuskan") }}', duration: 8, scale: 1 }
            ]
        },
        'box': {
            name: 'Box Breathing',
            target: 8,
            steps: [
                { instruction: '{{ __("Tarik Napas") }}', duration: 4, scale: 1.3 },
                { instruction: '{{ __("Tahan") }}', duration: 4, scale: 1.3 },
                { instruction: '{{ __("Hembuskan") }}', duration: 4, scale: 1 },
                { instruction: '{{ __("Tahan") }}', duration: 4, scale: 1 }
            ]
        },
        'deep': {
            name: 'Deep Breathing',
            target: 10,
            steps: [
                { instruction: '{{ __("Tarik Napas") }}', duration: 5, scale: 1.3 },
                { instruction: '{{ __("Hembuskan") }}', duration: 5, scale: 1 }
            ]
        },
        'calm': {
            name: 'Calm Breathing',
            target: 10,
            steps: [
                { instruction: '{{ __("Tarik Napas") }}', duration: 3, scale: 1.3 },
                { instruction: '{{ __("Hembuskan") }}', duration: 6, scale: 1 }
            ]
        }
    };

    function showPatternSelection() {
        stopBreathing();
        document.getElementById('pattern-selection').classList.remove('hidden');
        document.getElementById('breathing-session').classList.add('hidden');
        
        // Deselect all
        document.querySelectorAll('.pattern-btn').forEach(btn => {
            btn.classList.remove('border-teal-500', 'bg-teal-50', 'dark:bg-teal-900/20');
            btn.classList.add('border-gray-200', 'dark:border-gray-700');
        });
        currentPattern = null;
    }

    function selectPattern(patternId) {
        currentPattern = patternId;
        const patternObj = patterns[patternId];
        targetRounds = patternObj.target;
        
        // Hide selection, show session
        document.getElementById('pattern-selection').classList.add('hidden');
        document.getElementById('session-title').textContent = patternObj.name;
        document.getElementById('target-rounds').textContent = targetRounds;
        document.getElementById('session-count').textContent = '0';
        document.getElementById('session-duration').textContent = '0:00';
        document.getElementById('breathing-session').classList.remove('hidden');
        
        // Reset state
        sessionCount = 0;
        sessionSeconds = 0;
        document.getElementById('breathing-instruction').textContent = '{{ __("Siap Mulai") }}';
        document.getElementById('breathing-counter').textContent = '';
        document.getElementById('start-btn').classList.remove('hidden');
        document.getElementById('stop-btn').classList.add('hidden');
        document.getElementById('back-btn').classList.remove('hidden');
        
        const circle = document.getElementById('breathing-circle');
        circle.style.transitionDuration = '0s';
        circle.style.transform = 'scale(1)';
    }

    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }

    function startTimer() {
        timerInterval = setInterval(() => {
            sessionSeconds++;
            document.getElementById('session-duration').textContent = formatTime(sessionSeconds);
        }, 1000);
    }

    function stopTimer() {
        if (timerInterval) clearInterval(timerInterval);
    }

    function clearBreathingIntervals() {
        if (cycleTimeout) clearTimeout(cycleTimeout);
        if (countdownInterval) clearInterval(countdownInterval);
    }

    function startBreathing() {
        if (!currentPattern || isBreathing) return;
        
        isBreathing = true;
        document.getElementById('start-btn').classList.add('hidden');
        document.getElementById('back-btn').classList.add('hidden');
        document.getElementById('stop-btn').classList.remove('hidden');
        
        startTimer();
        runBreathingCycle();
    }

    function runBreathingCycle() {
        const pattern = patterns[currentPattern];
        let stepIndex = 0;
        
        function executeStep() {
            if (!isBreathing) return;
            
            const step = pattern.steps[stepIndex];
            const circle = document.getElementById('breathing-circle');
            const instruction = document.getElementById('breathing-instruction');
            const counter = document.getElementById('breathing-counter');
            
            instruction.textContent = step.instruction;
            
            // Animate circle with dynamic duration
            circle.style.transitionDuration = `${step.duration}s`;
            circle.style.transform = `scale(${step.scale})`;
            
            // Countdown
            let timeLeft = step.duration;
            counter.textContent = timeLeft;
            
            clearBreathingIntervals();
            
            countdownInterval = setInterval(() => {
                if (!isBreathing) return clearInterval(countdownInterval);
                timeLeft--;
                if (timeLeft > 0) {
                    counter.textContent = timeLeft;
                } else {
                    clearInterval(countdownInterval);
                }
            }, 1000);
            
            cycleTimeout = setTimeout(() => {
                if (!isBreathing) return;
                
                stepIndex++;
                if (stepIndex >= pattern.steps.length) {
                    stepIndex = 0;
                    sessionCount++;
                    document.getElementById('session-count').textContent = sessionCount;
                    
                    if (sessionCount >= targetRounds) {
                        stopBreathing();
                        return;
                    }
                }
                
                if (isBreathing) {
                    executeStep();
                }
            }, step.duration * 1000);
        }
        
        executeStep();
    }

    function stopBreathing() {
        isBreathing = false;
        stopTimer();
        clearBreathingIntervals();
        
        document.getElementById('start-btn').classList.remove('hidden');
        document.getElementById('start-btn').innerHTML = '<i data-lucide="play" class="w-5 h-5"></i> {{ __("Lanjut") }}';
        lucide.createIcons();
        document.getElementById('stop-btn').classList.add('hidden');
        document.getElementById('back-btn').classList.remove('hidden');
        
        const circle = document.getElementById('breathing-circle');
        circle.style.transitionDuration = '1s';
        circle.style.transform = 'scale(1)';
        
        if (sessionCount >= targetRounds) {
            document.getElementById('breathing-instruction').textContent = '{{ __("Sesi Selesai") }}';
            document.getElementById('start-btn').innerHTML = '<i data-lucide="rotate-ccw" class="w-5 h-5"></i> {{ __("Ulangi") }}';
            lucide.createIcons();
            sessionCount = 0;
            sessionSeconds = 0;
        } else {
            document.getElementById('breathing-instruction').textContent = '{{ __("Jeda") }}';
        }
        
        document.getElementById('breathing-counter').textContent = '';
    }
</script>

@endsection
