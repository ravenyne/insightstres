@extends('layouts.dashboard')

@section('content')
<script src="https://unpkg.com/lucide@latest"></script>

<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Latihan Pernapasan</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Teknik pernapasan untuk mengurangi stress dan meningkatkan fokus</p>
    </div>

    {{-- Pattern Selection --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pilih Pola Pernapasan</h2>
        
        <div class="grid md:grid-cols-2 gap-4">
            <button onclick="selectPattern('478')" id="pattern-478" class="pattern-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-teal-500 dark:hover:border-teal-500 transition text-left">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-400 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="wind" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">4-7-8 Breathing</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tarik 4s • Tahan 7s • Hembuskan 8s</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Untuk tidur & relaksasi</p>
                    </div>
                </div>
            </button>

            <button onclick="selectPattern('box')" id="pattern-box" class="pattern-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-teal-500 dark:hover:border-teal-500 transition text-left">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><rect width="18" height="18" x="3" y="3" rx="2" /></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Box Breathing</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tarik 4s • Tahan 4s • Hembuskan 4s • Tahan 4s</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Untuk fokus & konsentrasi</p>
                    </div>
                </div>
            </button>

            <button onclick="selectPattern('deep')" id="pattern-deep" class="pattern-btn p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-teal-500 dark:hover:border-teal-500 transition text-left">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="activity" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Deep Breathing</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tarik 5s • Hembuskan 5s</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Untuk relaksasi cepat</p>
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
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tarik 3s • Hembuskan 6s</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Untuk mengurangi kecemasan</p>
                    </div>
                </div>
            </button>
        </div>
    </div>

    {{-- Breathing Circle --}}
    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow p-8">
        <div class="flex flex-col items-center justify-center min-h-[500px]">
            {{-- Circle Animation --}}
            <div class="relative mb-8">
                <div id="breathing-circle" class="w-64 h-64 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center shadow-2xl transition-all ease-in-out">
                    <div class="text-center text-white">
                        <p id="breathing-instruction" class="text-2xl font-bold mb-2">Pilih Pola</p>
                        <p id="breathing-counter" class="text-6xl font-bold"></p>
                    </div>
                </div>
            </div>

            {{-- Controls --}}
            <div class="flex gap-4">
                <button id="start-btn" onclick="startBreathing()" class="px-8 py-3 bg-teal-500 text-white rounded-xl font-semibold hover:bg-teal-600 transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="play" class="w-5 h-5"></i>
                    Mulai
                </button>
                <button id="stop-btn" onclick="stopBreathing()" class="px-8 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition flex items-center gap-2 hidden">
                    <i data-lucide="square" class="w-5 h-5"></i>
                    Berhenti
                </button>
            </div>

            {{-- Session Info --}}
            <div class="mt-6 text-center">
                <p class="text-gray-600 dark:text-gray-400 text-sm">Sesi Selesai: <span id="session-count" class="font-bold text-teal-600 dark:text-teal-400">0</span></p>
            </div>
        </div>
    </div>

    {{-- Tips --}}
    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-6">
        <div class="flex gap-3">
            <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5"></i>
            <div>
                <h3 class="font-semibold text-blue-900 dark:text-blue-300 mb-2">Tips Latihan Pernapasan</h3>
                <ul class="space-y-1 text-sm text-blue-800 dark:text-blue-400">
                    <li>• Cari tempat yang tenang dan nyaman</li>
                    <li>• Duduk dengan postur tegak atau berbaring</li>
                    <li>• Fokus pada pernapasan, biarkan pikiran lain mengalir</li>
                    <li>• Lakukan minimal 5 menit untuk hasil optimal</li>
                    <li>• Praktik rutin setiap hari untuk manfaat jangka panjang</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    let currentPattern = null;
    let isBreathing = false;
    let breathingInterval = null;
    let sessionCount = 0;

    const patterns = {
        '478': {
            name: '4-7-8 Breathing',
            steps: [
                { instruction: 'Tarik Napas', duration: 4, scale: 1.3 },
                { instruction: 'Tahan', duration: 7, scale: 1.3 },
                { instruction: 'Hembuskan', duration: 8, scale: 1 }
            ]
        },
        'box': {
            name: 'Box Breathing',
            steps: [
                { instruction: 'Tarik Napas', duration: 4, scale: 1.3 },
                { instruction: 'Tahan', duration: 4, scale: 1.3 },
                { instruction: 'Hembuskan', duration: 4, scale: 1 },
                { instruction: 'Tahan', duration: 4, scale: 1 }
            ]
        },
        'deep': {
            name: 'Deep Breathing',
            steps: [
                { instruction: 'Tarik Napas', duration: 5, scale: 1.3 },
                { instruction: 'Hembuskan', duration: 5, scale: 1 }
            ]
        },
        'calm': {
            name: 'Calm Breathing',
            steps: [
                { instruction: 'Tarik Napas', duration: 3, scale: 1.3 },
                { instruction: 'Hembuskan', duration: 6, scale: 1 }
            ]
        }
    };

    function selectPattern(patternId) {
        currentPattern = patternId;
        
        // Update button styles
        document.querySelectorAll('.pattern-btn').forEach(btn => {
            btn.classList.remove('border-teal-500', 'bg-teal-50', 'dark:bg-teal-900/20');
            btn.classList.add('border-gray-200', 'dark:border-gray-700');
        });
        
        const selectedBtn = document.getElementById(`pattern-${patternId}`);
        selectedBtn.classList.remove('border-gray-200', 'dark:border-gray-700');
        selectedBtn.classList.add('border-teal-500', 'bg-teal-50', 'dark:bg-teal-900/20');
        
        // Enable start button
        document.getElementById('start-btn').disabled = false;
        
        // Update instruction
        document.getElementById('breathing-instruction').textContent = 'Siap Mulai';
        document.getElementById('breathing-counter').textContent = '';
    }

    function startBreathing() {
        if (!currentPattern || isBreathing) return;
        
        isBreathing = true;
        document.getElementById('start-btn').classList.add('hidden');
        document.getElementById('stop-btn').classList.remove('hidden');
        
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
            
            const countdown = setInterval(() => {
                timeLeft--;
                if (timeLeft > 0) {
                    counter.textContent = timeLeft;
                } else {
                    clearInterval(countdown);
                    stepIndex++;
                    
                    if (stepIndex >= pattern.steps.length) {
                        stepIndex = 0;
                        sessionCount++;
                        document.getElementById('session-count').textContent = sessionCount;
                    }
                    
                    if (isBreathing) {
                        setTimeout(executeStep, 500);
                    }
                }
            }, 1000);
        }
        
        executeStep();
    }

    function stopBreathing() {
        isBreathing = false;
        document.getElementById('start-btn').classList.remove('hidden');
        document.getElementById('stop-btn').classList.add('hidden');
        
        const circle = document.getElementById('breathing-circle');
        circle.style.transform = 'scale(1)';
        
        document.getElementById('breathing-instruction').textContent = 'Selesai';
        document.getElementById('breathing-counter').textContent = '';
    }
</script>

@endsection
