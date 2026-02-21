@extends('layouts.dashboard')

@section('content')
@php
    $questions = [
        "Apakah Anda mengalami stres akhir-akhir ini?",
        "Apakah Anda merasakan detak jantung cepat atau berdebar?",
        "Apakah Anda merasa cemas atau tegang akhir-akhir ini?",
        "Apakah Anda mengalami kesulitan tidur?",
        "Apakah Anda merasa cemas tanpa alasan jelas?",
        "Apakah Anda sering mengalami sakit kepala?",
        "Apakah Anda mudah merasa kesal?",
        "Apakah Anda kesulitan berkonsentrasi pada tugas kuliah?",
        "Apakah Anda merasa sedih atau murung?",
        "Apakah Anda mengalami masalah kesehatan akhir-akhir ini?",
        "Apakah Anda merasa kesepian?",
        "Apakah Anda merasa kewalahan dengan tugas kuliah?",
        "Apakah persaingan dengan teman membuat Anda stres?",
        "Apakah hubungan pribadi/romansa membuat Anda stres?",
        "Apakah Anda mengalami kesulitan dengan dosen?",
        "Apakah lingkungan belajar/kerja Anda tidak menyenangkan?",
        "Apakah Anda sulit menemukan waktu untuk istirahat atau hiburan?",
        "Apakah lingkungan rumah atau kos membuat Anda tidak nyaman?",
        "Apakah Anda kurang percaya diri dengan kemampuan akademik Anda?",
        "Apakah Anda ragu dengan pilihan jurusan Anda?",
        "Apakah kegiatan akademik & non-akademik Anda sering bertabrakan?",
        "Apakah Anda jarang menghadiri kelas?",
        "Apakah Anda mengalami perubahan berat badan?"
    ];

    $options = ["Tidak pernah", "Jarang", "Kadang-kadang", "Sering", "Sangat sering"];
@endphp


<div class="max-w-3xl mx-auto space-y-6 animate-fade-in">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Assessment Stress</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Jawab dengan jujur sesuai kondisi Anda.</p>
    </div>

    {{-- ERROR MESSAGE --}}
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-red-800 font-semibold">Error!</h3>
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
                    <h3 class="text-green-800 font-semibold">Berhasil!</h3>
                    <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- PROGRESS --}}
    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow">
        <div class="flex justify-between mb-2">
            <span id="progress-text" class="text-sm font-medium text-gray-900 dark:text-white">
                Pertanyaan 1 dari {{ count($questions) }}
            </span>
            <span id="progress-percent" class="text-sm text-gray-500 dark:text-gray-400">4%</span>
        </div>

        <div class="w-full bg-gray-200 h-2 rounded">
            <div id="progress-bar"
                 class="h-2 bg-teal-500 rounded transition-all duration-300"
                 style="width: 4%"></div>
        </div>
    </div>

    {{-- PERTANYAAN --}}
    <form id="assessmentForm" action="{{ route('assessment.store') }}" method="POST">
        @csrf
        <input type="hidden" name="answers" id="answersInput">

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
            <h2 id="questionText" class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">
                {{ $questions[0] }}
            </h2>

            <div id="optionsContainer" class="space-y-3">
                @foreach ($options as $index => $option)
                    <button type="button"
                        onclick="selectAnswer({{ $index }})"
                        class="option-btn w-full p-4 rounded-xl border-2 text-left transition duration-200 hover:border-teal-300 hover:bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">

                        <div class="flex items-center gap-3">
                           <div class="radio-indicator w-5 h-5 rounded-full border-2 flex items-center justify-center">
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
            </div>
        </div>

        {{-- NAV BUTTONS --}}
        <div class="flex justify-between items-center mt-6">

            <button type="button" id="prevBtn"
                onclick="prevQuestion()"
                class="px-5 py-3 rounded-xl border text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:bg-gray-700 transition"
                disabled>
                ← Sebelumnya
            </button>

            <button type="button" id="nextBtn"
                onclick="nextQuestion()"
                class="px-6 py-3 rounded-xl bg-teal-500 text-white hover:bg-teal-600 transition flex items-center gap-2">
                Selanjutnya →
            </button>

            <button type="submit" id="submitBtn"
                class="hidden px-6 py-3 rounded-xl bg-teal-500 text-white hover:bg-teal-600 transition flex items-center gap-2">
                Selesai & Lihat Hasil
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7" />
                </svg>
            </button>

        </div>
    </form>

    {{-- DOTS --}}
    <div class="flex justify-center gap-2 mt-4 flex-wrap" id="dotsContainer"></div>
</div>




{{-- SCRIPT --}}
<script>
    const questions = @json($questions);
    const total = questions.length;

    let current = 0;
    let answers = Array(total).fill(null);

    const options = document.querySelectorAll(".option-btn");
    const questionText = document.getElementById("questionText");
    const progressText = document.getElementById("progress-text");
    const progressPercent = document.getElementById("progress-percent");
    const progressBar = document.getElementById("progress-bar");

    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const submitBtn = document.getElementById("submitBtn");

    const dotsContainer = document.getElementById("dotsContainer");

    // Render DOTS
    for (let i = 0; i < total; i++) {
        const dot = document.createElement("button");
        dot.className = "dot w-3 h-3 rounded-full bg-gray-300 transition duration-200";
        dot.onclick = () => goTo(i);
        dotsContainer.appendChild(dot);
    }
    const dots = document.querySelectorAll(".dot");


    function updateUI() {
        questionText.innerText = questions[current];

        progressText.innerText = `Pertanyaan ${current + 1} dari ${total}`;
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
            btn.classList.remove("border-teal-500", "bg-teal-50");
            btn.querySelector(".radio-indicator").classList.remove("bg-teal-500", "border-teal-500");
            btn.querySelector(".check-icon").classList.add("hidden");

            if (answers[current] === index) {
                btn.classList.add("border-teal-500", "bg-teal-50");
                btn.querySelector(".radio-indicator").classList.add("bg-teal-500", "border-teal-500");
                btn.querySelector(".check-icon").classList.remove("hidden");
            }
        });

        // Update DOTS
        dots.forEach((dot, index) => {
            dot.classList.remove("bg-teal-500", "bg-teal-200", "bg-gray-300");

            if (current === index) dot.classList.add("bg-teal-500");
            else if (answers[index] !== null) dot.classList.add("bg-teal-200");
            else dot.classList.add("bg-gray-300");
        });
    }


    function selectAnswer(index) {
        answers[current] = index;
        updateUI();
    }

    function nextQuestion() {
        if (answers[current] === null) {
            alert("Pilih jawaban terlebih dahulu.");
            return;
        }
        current++;
        updateUI();
    }

    function prevQuestion() {
        current--;
        updateUI();
    }

    function goTo(index) {
        if (answers[current] === null && index > current) {
            alert("Jawab dulu sebelum melanjutkan!");
            return;
        }
        current = index;
        updateUI();
    }

    document.getElementById("assessmentForm").onsubmit = () => {
        document.getElementById("answersInput").value = JSON.stringify(answers);
    };

    updateUI();
</script>

@endsection