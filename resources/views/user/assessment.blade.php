@extends('layouts.dashboard')

@section('content')
@php
    $questions = [
        __('q1'), __('q2'), __('q3'), __('q4'), __('q5'),
        __('q6'), __('q7'), __('q8'), __('q9'), __('q10'),
        __('q11'), __('q12'), __('q13'), __('q14'), __('q15'),
        __('q16'), __('q17'), __('q18'), __('q19'), __('q20'),
        __('q21'), __('q22'), __('q23'),
    ];

    $options = [
        __('Tidak pernah'),
        __('Jarang'),
        __('Kadang-kadang'),
        __('Sering'),
        __('Sangat sering'),
    ];
@endphp



<div class="max-w-3xl mx-auto space-y-6 animate-fade-in">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Penilaian Stres') }}</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ __('Jawab dengan jujur sesuai kondisi Anda.') }}</p>
    </div>

    {{-- AI CONTEXT --}}
    <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-4 border border-indigo-100 dark:border-indigo-800/50 flex items-start gap-3">
        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/40 rounded-lg text-indigo-600 dark:text-indigo-400 mt-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2v4"></path><path d="M12 18v4"></path><path d="M4.93 4.93l2.83 2.83"></path><path d="M16.24 16.24l2.83 2.83"></path><path d="M2 12h4"></path><path d="M18 12h4"></path><path d="M4.93 19.07l2.83-2.83"></path><path d="M16.24 7.76l2.83-2.83"></path>
            </svg>
        </div>
        <div>
            <h3 class="font-semibold text-indigo-900 dark:text-indigo-300">{{ __('Penilaian Stres Berbasis AI') }}</h3>
            <p class="text-sm text-indigo-700/80 dark:text-indigo-400/80 mt-1 leading-relaxed">
                {{ __('Jawaban Anda akan dianalisis untuk memahami pola stres mahasiswa dan membantu meningkatkan kesejahteraan akademik.') }}
            </p>
        </div>
    </div>

    {{-- ERROR MESSAGE --}}
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-red-800 font-semibold">{{ __('Error!') }}</h3>
                    <p class="text-red-700 text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-green-800 font-semibold">{{ __('Berhasil!') }}</h3>
                    <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- PROGRESS --}}
    <div class="bg-white dark:bg-gray-800 p-4 py-5 rounded-xl shadow">
        <div class="flex justify-between mb-3">
            <span id="progress-text" class="text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Pertanyaan') }} 1 {{ __('dari') }} {{ count($questions) }}
            </span>
            <span id="progress-percent" class="text-sm text-gray-500 dark:text-gray-400">4%</span>
        </div>

        <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded mb-3">
            <div id="progress-bar"
                 class="h-2 bg-teal-500 rounded transition-all duration-300"
                 style="width: 4%"></div>
        </div>

        <p class="text-xs text-gray-500 dark:text-gray-400 text-center italic">
            "{{ __('Assessment ini membantu sistem memahami kondisi stres Anda dan membangun insight tentang kesejahteraan mahasiswa.') }}"
        </p>
    </div>

    {{-- PERTANYAAN --}}
    <form id="assessmentForm" action="{{ route('assessment.store') }}" method="POST" class="relative">
        @csrf
        <input type="hidden" name="answers" id="answersInput">

        <div id="questionContainer" class="transition-opacity duration-300 ease-in-out opacity-100">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                <h2 id="questionText" class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">
                    {{ $questions[0] }}
                </h2>

                <div id="optionsContainer" class="space-y-3 relative">
                    @foreach ($options as $index => $option)
                        <button type="button"
                            onclick="selectAnswer({{ $index }})"
                            class="option-btn w-full p-4 rounded-xl border-2 text-left transition duration-200 hover:border-teal-300 hover:bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white group">

                            <div class="flex items-center gap-3">
                                <div class="radio-indicator w-5 h-5 rounded-full border-2 flex items-center justify-center group-hover:border-teal-400 transition-colors">
                                    <svg class="check-icon hidden" width="12" height="12" viewBox="0 0 24 24"
                                        fill="none" stroke="white" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $option }}</span>
                            </div>

                        </button>
                    @endforeach
                    <div class="pt-2 text-center">
                         <span class="text-xs text-gray-400 dark:text-gray-500 flex justify-center items-center gap-1">
                             <kbd class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-gray-500 dark:text-gray-400 font-sans">Enter</kbd>
                             {{ __('Tip: Tekan Enter untuk lanjut ke pertanyaan berikutnya.') }}
                         </span>
                    </div>
                </div>
            </div>

            {{-- NAV BUTTONS --}}
            <div class="flex justify-between items-center mt-6">

                <button type="button" id="prevBtn"
                    onclick="prevQuestion()"
                    class="px-5 py-3 rounded-xl border text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:bg-gray-700 transition"
                    disabled>
                    {{ __('Sebelumnya') }}
                </button>

                <button type="button" id="nextBtn"
                    onclick="nextQuestion()"
                    class="px-6 py-3 rounded-xl bg-teal-500 text-white hover:bg-teal-600 transition flex items-center gap-2">
                    {{ __('Selanjutnya') }}
                </button>

                <button type="submit" id="submitBtn"
                    class="hidden px-6 py-3 rounded-xl bg-teal-500 text-white hover:bg-teal-600 transition flex items-center gap-2">
                    {{ __('Selesai & Lihat Hasil') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7" />
                    </svg>
                </button>

            </div>
        </div>
    </form>

    {{-- DOTS --}}
    <div class="flex justify-center gap-2 mt-4 flex-wrap" id="dotsContainer"></div>
</div>




{{-- SCRIPT --}}
<script>
    // Questions and labels come from PHP/translations — already locale-correct
    const questions = @json($questions);
    const total     = questions.length;

    // Localised strings for JS
    const lblQuestion = '{{ __('Pertanyaan') }}';
    const lblOf       = '{{ __('dari') }}';
    const lblAlert    = '{{ __('Jawab dulu sebelum melanjutkan!') }}';

    // Try to load state from sessionStorage so language switching doesn't wipe progress
    let current = parseInt(sessionStorage.getItem('assessment_current')) || 0;
    
    let savedAnswers = sessionStorage.getItem('assessment_answers');
    let answers = savedAnswers ? JSON.parse(savedAnswers) : Array(total).fill(null);

    const options         = document.querySelectorAll(".option-btn");
    const questionText    = document.getElementById("questionText");
    const progressText    = document.getElementById("progress-text");
    const progressPercent = document.getElementById("progress-percent");
    const progressBar     = document.getElementById("progress-bar");
    const questionContainer = document.getElementById("questionContainer");

    const prevBtn   = document.getElementById("prevBtn");
    const nextBtn   = document.getElementById("nextBtn");
    const submitBtn = document.getElementById("submitBtn");

    const dotsContainer = document.getElementById("dotsContainer");
    let autoAdvanceTimer = null;

    // Handle Enter Keyboard Navigation
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            if (answers[current] !== null) {
                if (current === total - 1) {
                    submitBtn.click();
                } else {
                    nextQuestion();
                }
            }
        }
    });

    // Render DOTS
    for (let i = 0; i < total; i++) {
        const dot = document.createElement("button");
        dot.className = "dot w-3 h-3 rounded-full bg-gray-300 transition duration-200";
        dot.onclick = () => goTo(i);
        dotsContainer.appendChild(dot);
    }
    const dots = document.querySelectorAll(".dot");


    function updateUI(transitioning = false) {
        // Save state on every UI update
        sessionStorage.setItem('assessment_current', current);
        sessionStorage.setItem('assessment_answers', JSON.stringify(answers));

        if (transitioning) {
            questionContainer.style.opacity = '0';
            setTimeout(() => {
                applyUIUpdates();
                questionContainer.style.opacity = '1';
            }, 200);
        } else {
            applyUIUpdates();
        }
    }

    function applyUIUpdates() {
        questionText.innerText = questions[current];

        progressText.innerText = `${lblQuestion} ${current + 1} ${lblOf} ${total}`;
        const percent = Math.round(((current + 1) / total) * 100);
        progressPercent.innerText = percent + "%";
        progressBar.style.width = percent + "%";

        prevBtn.disabled = current === 0;

        if (current === total - 1) {
            nextBtn.classList.add("hidden");
            submitBtn.classList.remove("hidden");
        } else {
            nextBtn.classList.remove("hidden");
            submitBtn.classList.add("hidden");
        }

        // Highlight selected option
        options.forEach((btn, index) => {
            btn.classList.remove("border-teal-500", "bg-teal-50", "dark:bg-teal-900/40");
            btn.querySelector(".radio-indicator").classList.remove("bg-teal-500", "border-teal-500");
            btn.querySelector(".check-icon").classList.add("hidden");

            if (answers[current] === index) {
                btn.classList.add("border-teal-500", "bg-teal-50", "dark:bg-teal-900/40");
                btn.querySelector(".radio-indicator").classList.add("bg-teal-500", "border-teal-500");
                btn.querySelector(".check-icon").classList.remove("hidden");
            }
        });

        // Update DOTS
        dots.forEach((dot, index) => {
            dot.classList.remove("bg-teal-500", "bg-teal-300", "bg-gray-300");
            if (current === index) dot.classList.add("bg-teal-500");
            else if (answers[index] !== null) dot.classList.add("bg-teal-300");
            else dot.classList.add("bg-gray-300");
        });
    }


    function selectAnswer(index) {
        answers[current] = index;
        updateUI();

        if (autoAdvanceTimer) clearTimeout(autoAdvanceTimer);

        if (current < total - 1) {
            autoAdvanceTimer = setTimeout(() => {
                nextQuestion();
            }, 400);
        }
    }

    function nextQuestion() {
        if (autoAdvanceTimer) clearTimeout(autoAdvanceTimer);
        if (answers[current] === null) {
            questionContainer.classList.add('animate-shake');
            setTimeout(() => questionContainer.classList.remove('animate-shake'), 500);
            return;
        }
        current++;
        updateUI(true);
    }

    function prevQuestion() {
        if (autoAdvanceTimer) clearTimeout(autoAdvanceTimer);
        current--;
        updateUI(true);
    }

    function goTo(index) {
        if (autoAdvanceTimer) clearTimeout(autoAdvanceTimer);
        if (answers[current] === null && index > current) {
            alert(lblAlert);
            return;
        }
        current = index;
        updateUI(true);
    }

    document.getElementById("assessmentForm").onsubmit = () => {
        document.getElementById("answersInput").value = JSON.stringify(answers);
        // Clear progress when submitted successfully
        sessionStorage.removeItem('assessment_current');
        sessionStorage.removeItem('assessment_answers');
    };

    updateUI();
</script>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake {
        animation: shake 0.4s ease-in-out;
    }
</style>

@endsection