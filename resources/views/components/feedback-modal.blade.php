{{-- Feedback Button & Modal --}}
<div id="feedback-container">
    {{-- Floating Feedback Button - Right Bottom --}}
    <button id="feedback-btn" class="fixed bottom-6 right-6 z-50 bg-purple-600 hover:bg-purple-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 hover:scale-110" aria-label="Send Feedback" style="z-index: 9999 !important;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
    </button>

    {{-- Feedback Modal --}}
    <div id="feedback-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background overlay --}}
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

            {{-- Modal panel --}}
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="feedback-form">
                    @csrf
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-2xl font-bold text-gray-900">
                                Berikan Feedback
                            </h3>
                            <button type="button" id="close-feedback-modal" class="text-gray-400 hover:text-gray-600 transition">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <p class="text-sm text-gray-600 mb-6">
                            Bantu kami meningkatkan platform dengan memberikan feedback Anda
                        </p>

                        {{-- Type Selection --}}
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Feedback</label>
                            <select name="type" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Pilih tipe...</option>
                                <option value="bug">🐛 Bug Report</option>
                                <option value="feature">✨ Feature Request</option>
                                <option value="improvement">📈 Improvement</option>
                                <option value="other">💬 Other</option>
                            </select>
                        </div>

                        {{-- Rating --}}
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Rating (Opsional)</label>
                            <div class="flex gap-2">
                                <button type="button" class="rating-btn w-12 h-12 rounded-lg border-2 border-gray-300 hover:border-yellow-400 hover:bg-yellow-50 transition flex items-center justify-center" data-rating="1">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                                <button type="button" class="rating-btn w-12 h-12 rounded-lg border-2 border-gray-300 hover:border-yellow-400 hover:bg-yellow-50 transition flex items-center justify-center" data-rating="2">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                                <button type="button" class="rating-btn w-12 h-12 rounded-lg border-2 border-gray-300 hover:border-yellow-400 hover:bg-yellow-50 transition flex items-center justify-center" data-rating="3">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                                <button type="button" class="rating-btn w-12 h-12 rounded-lg border-2 border-gray-300 hover:border-yellow-400 hover:bg-yellow-50 transition flex items-center justify-center" data-rating="4">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                                <button type="button" class="rating-btn w-12 h-12 rounded-lg border-2 border-gray-300 hover:border-yellow-400 hover:bg-yellow-50 transition flex items-center justify-center" data-rating="5">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                            </div>
                            <input type="hidden" name="rating" id="rating-input">
                        </div>

                        {{-- Subject --}}
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subjek</label>
                            <input type="text" name="subject" required maxlength="255" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Ringkasan singkat...">
                        </div>

                        {{-- Message --}}
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                            <textarea name="message" required rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none" placeholder="Jelaskan feedback Anda secara detail..."></textarea>
                        </div>

                        {{-- Hidden page URL --}}
                        <input type="hidden" name="page_url" id="page-url">
                    </div>

                    {{-- Footer --}}
                    <div class="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                        <button type="button" id="cancel-feedback" class="px-6 py-2.5 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-100 transition">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition">
                            Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Feedback modal script loaded');
    const feedbackBtn = document.getElementById('feedback-btn');
    const feedbackModal = document.getElementById('feedback-modal');
    const closeFeedbackModal = document.getElementById('close-feedback-modal');
    const cancelFeedback = document.getElementById('cancel-feedback');
    const feedbackForm = document.getElementById('feedback-form');
    const ratingBtns = document.querySelectorAll('.rating-btn');
    const ratingInput = document.getElementById('rating-input');
    const pageUrlInput = document.getElementById('page-url');

    console.log('Feedback button element:', feedbackBtn);

    // Set current page URL
    pageUrlInput.value = window.location.href;

    // Open modal
    feedbackBtn.addEventListener('click', function() {
        feedbackModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    // Close modal
    function closeModal() {
        feedbackModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        feedbackForm.reset();
        ratingInput.value = '';
        // Reset rating buttons
        ratingBtns.forEach(btn => {
            btn.classList.remove('border-yellow-400', 'bg-yellow-50');
            btn.classList.add('border-gray-300');
            const icon = btn.querySelector('svg');
            icon.classList.remove('text-yellow-400');
            icon.classList.add('text-gray-400');
        });
    }

    closeFeedbackModal.addEventListener('click', closeModal);
    cancelFeedback.addEventListener('click', closeModal);

    // Rating selection
    ratingBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const rating = this.dataset.rating;
            ratingInput.value = rating;

            // Reset all buttons
            ratingBtns.forEach(b => {
                b.classList.remove('border-yellow-400', 'bg-yellow-50');
                b.classList.add('border-gray-300');
                const icon = b.querySelector('svg');
                icon.classList.remove('text-yellow-400');
                icon.classList.add('text-gray-400');
            });

            // Highlight selected and previous buttons
            for (let i = 0; i < rating; i++) {
                const btn = ratingBtns[i];
                btn.classList.remove('border-gray-300');
                btn.classList.add('border-yellow-400', 'bg-yellow-50');
                const icon = btn.querySelector('svg');
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-yellow-400');
            }
        });
    });

    // Form submission
    feedbackForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(feedbackForm);
        const submitBtn = feedbackForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        fetch('{{ route("feedback.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                alert(data.message);
                closeModal();
            } else {
                alert('Gagal mengirim feedback. Silakan coba lagi.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Kirim Feedback';
        });
    });

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
