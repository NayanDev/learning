<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pre-Test Pelatihan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tabler Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F0F7F8; /* Latar belakang dari sistem Anda */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }
        .test-container {
            max-width: 960px; /* Diperlebar untuk memuat kolom nomor */
            width: 100%;
        }
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(8, 145, 178, 0.25); /* Cyan focus */
            border-color: #0891B2;
        }
        .answer-option {
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        .answer-option:hover {
            background-color: #f8f9fa;
            border-color: #0891B2;
            cursor: pointer;
        }
        .answer-option input[type="radio"] {
            display: none;
        }
        .answer-option.selected {
            background-color: #E6F4F1;
            border-color: #0891B2;
            box-shadow: 0 0 5px rgba(8, 145, 178, 0.3);
        }
        /* Style untuk tombol nomor soal */
        #question-navigator .btn {
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="test-container">

        <!-- =================================== -->
        <!-- HALAMAN 1: FORM DATA DIRI (LOBI) -->
        <!-- =================================== -->
        <div id="data-collection-page">
            <!-- Menambahkan row dan offset agar form tetap di tengah & tidak terlalu lebar -->
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            
                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-dark mt-3">Formulir Data Peserta </h3>
                                <p class="text-muted">Selamat datang di Pre-Test untuk <strong>{{ $data->workshop->name }}</strong>.</p>
                            </div>
                            
                            <form id="form-data-peserta">
                                <div id="error-message" class="alert alert-danger d-none" role="alert">
                                    Harap isi semua kolom yang wajib diisi.
                                </div>

                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label fw-medium">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                                        <input type="text" class="form-control" id="nama_lengkap" placeholder="Masukkan nama lengkap Anda" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-medium">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                        <input type="email" class="form-control" id="email" placeholder="contoh@email.com" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="posisi" class="form-label fw-medium">Posisi yang Dilamar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-briefcase"></i></span>
                                        <input type="text" class="form-control" id="posisi" placeholder="Masukkan posisi yang dilamar" required>
                                    </div>
                                </div>

                                <div class="alert alert-light border" role="alert">
                                    <h6 class="fw-bold"><i class="ti ti-info-circle me-2"></i>Petunjuk Pengerjaan</h6>
                                    <ul class="mb-0 small" style="padding-left: 1.2rem;">
                                        <li>Tes terdiri dari <strong>10 soal</strong> pilihan ganda.</li>
                                        <li>Waktu pengerjaan adalah <strong>15 menit</strong>.</li>
                                        <li>Pastikan koneksi internet Anda stabil.</li>
                                        <li>Klik tombol "Mulai Test" jika Anda sudah siap.</li>
                                    </ul>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-lg mt-4 fw-bold">
                                    Mulai Test <i class="ti ti-arrow-right ms-1"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================================== -->
        <!-- HALAMAN 2: TES PENGERJAAN SOAL -->
        <!-- =================================== -->
        <div id="test-page" class="d-none"> <!-- Container ini yang di-toggle -->
            <div class="row g-4">
                
                <!-- Kolom Soal (Kiri) -->
                <div class="col-lg-8">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Pre-Test: {{ $data->workshop->name }}</h5>
                            <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-3 py-2">Soal 1 dari 10</span>
                        </div>
                        <div class="card-body p-4 p-md-5">
                            
                            <div class="text-center mb-4">
                                <h4 class="text-danger fw-bold" id="timer">Sisa Waktu: --:--</h4>
                                <p class="text-muted small mb-0">
                                    <i class="ti ti-clock me-1"></i>
                                    Durasi Test: 
                                    @php
                                        $start = \Carbon\Carbon::parse($data->start_date);
                                        $end = \Carbon\Carbon::parse($data->end_date);
                                        $diff = $start->diff($end);
                                        
                                        $hours = $diff->h + ($diff->days * 24);
                                        $minutes = $diff->i;
                                        
                                        if ($hours > 0) {
                                            echo "{$hours} jam {$minutes} menit";
                                        } else {
                                            echo "{$minutes} menit";
                                        }
                                    @endphp
                                </p>
                            </div>

                            <p class="fs-5 fw-semibold mb-4">1. Apa kepanjangan dari K3?</p>

                            <!-- Pilihan Jawaban -->
                            <div class="d-grid gap-3" id="answer-options">
                                <label class="answer-option d-flex align-items-center" data-value="A">
                                    <input type="radio" name="question1" value="A" class="me-3">
                                    <span class="fw-medium">A. Kesehatan dan Keselamatan Karyawan</span>
                                </label>
                                <label class="answer-option d-flex align-items-center" data-value="B">
                                    <input type="radio" name="question1" value="B" class="me-3">
                                    <span class="fw-medium">B. Keselamatan dan Kesehatan Kerja</span>
                                </label>
                                <label class="answer-option d-flex align-items-center" data-value="C">
                                    <input type="radio" name="question1" value="C" class="me-3">
                                    <span class="fw-medium">C. Keamanan, Kesehatan, dan Kerja</span>
                                </label>
                                <label class="answer-option d-flex align-items-center" data-value="D">
                                    <input type="radio" name="question1" value="D" class="me-3">
                                    <span class="fw-medium">D. Komite Keselamatan dan Kesehatan Karyawan</span>
                                </label>
                            </div>
                        </div>
                        <div class="card-footer p-3 d-flex justify-content-between">
                            <button class="btn btn-outline-secondary" disabled>
                                <i class="ti ti-arrow-left me-1"></i> Sebelumnya
                            </button>
                            <button class="btn btn-primary">
                                Selanjutnya <i class="ti ti-arrow-right ms-1"></i>
                            </button>
                            
                            <!-- Tombol Selesai (muncul di soal terakhir) -->
                            <!-- 
                            <button class="btn btn-success d-none">
                                Selesai Test <i class="ti ti-check ms-1"></i>
                            </button> 
                            -->
                        </div>
                    </div>
                </div>

                <!-- Kolom Nomor Soal (Kanan) - BARU -->
                <div class="col-lg-4" id="number-column">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white">
                            <h6 class="fw-bold mb-0">Nomor Soal</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row row-cols-5 g-2" id="question-navigator">
                                <!-- Baris 1 -->
                                <div class="col">
                                    <button class="btn btn-primary w-100" data-question="1">1</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-secondary w-100" data-question="2">2</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-secondary w-100" data-question="3">3</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-secondary w-100" data-question="4">4</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-secondary w-100" data-question="5">5</button>
                                </div>
                                <!-- Baris 2 -->
                                <div class="col">
                                    <button class="btn btn-outline-secondary w-100" data-question="6">6</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-secondary w-100" data-question="7">7</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-secondary w-100" data-question="8">8</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-secondary w-100" data-question="9">9</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-secondary w-100" data-question="10">10</button>
                                </div>
                            </div>
                            <hr class="my-3">
                            <p class="fw-bold small">Legenda:</p>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2" style="width: 20px;">&nbsp;</span>
                                <small>Soal Saat Ini</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2" style="width: 20px;">&nbsp;</span>
                                <small>Sudah Dijawab</small>
                            </div>
                             <div class="d-flex align-items-center">
                                <span class="badge bg-light border text-dark me-2" style="width: 20px;">&nbsp;</span>
                                <small>Belum Dijawab</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div> <!-- .test-container -->

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript untuk Fungsionalitas -->
    <script>
        // State Management
        let questionsData = [];
        let userAnswers = {};
        let currentQuestionIndex = 0;
        let timerInterval = null;
        let testStartTime = null; // Waktu mulai test
        
        // Hitung durasi test dari selisih start_date dan end_date
        const EVENT_START_DATE = new Date("{{ $data->start_date }}");
        const EVENT_END_DATE = new Date("{{ $data->end_date }}");
        const timerDuration = Math.floor((EVENT_END_DATE - EVENT_START_DATE) / 1000); // dalam detik
        
        let isSubmitting = false; // Flag untuk prevent double submit
        let isSubmitted = false; // Flag untuk track apakah sudah submit
        const TEST_EMPLOYEE_ID = {{ $data->id }};
        const EVENT_ID = {{ $data->event_id ?? 'null' }};
        const STORAGE_KEY = `test_progress_${TEST_EMPLOYEE_ID}_${EVENT_ID}`;

        // LocalStorage functions
        function saveProgress() {
            const progress = {
                nama_lengkap: document.getElementById('nama_lengkap')?.value || '',
                email: document.getElementById('email')?.value || '',
                posisi: document.getElementById('posisi')?.value || '',
                userAnswers: Object.assign({}, userAnswers), // Create clean copy
                currentQuestionIndex: currentQuestionIndex,
                testStartTime: testStartTime, // Simpan waktu mulai test
                timestamp: Date.now()
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(progress));
        }

        function loadProgress() {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved) {
                try {
                    return JSON.parse(saved);
                } catch (e) {
                    console.error('Error parsing saved progress:', e);
                    return null;
                }
            }
            return null;
        }

        function clearProgress() {
            localStorage.removeItem(STORAGE_KEY);
        }

        function restoreProgress() {
            const progress = loadProgress();
            if (progress) {
                // Restore form data
                if (document.getElementById('nama_lengkap')) {
                    document.getElementById('nama_lengkap').value = progress.nama_lengkap || '';
                }
                if (document.getElementById('email')) {
                    document.getElementById('email').value = progress.email || '';
                }
                if (document.getElementById('posisi')) {
                    document.getElementById('posisi').value = progress.posisi || '';
                }
                
                // DON'T restore answers here - will be done in initializeTest
                // This function only restores form data
                
                return true;
            }
            return false;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const formDataPeserta = document.getElementById('form-data-peserta');
            const dataCollectionPage = document.getElementById('data-collection-page');
            const testPage = document.getElementById('test-page');
            const errorMessage = document.getElementById('error-message');

            // --- START: Auto-save form data ---
            const namaInput = document.getElementById('nama_lengkap');
            const emailInput = document.getElementById('email');
            const posisiInput = document.getElementById('posisi');

            // Auto-save form data on input
            [namaInput, emailInput, posisiInput].forEach(input => {
                input.addEventListener('input', saveProgress);
            });
            // --- END: Auto-save form data ---

            // Restore progress from localStorage
            const hasProgress = restoreProgress();
            if (hasProgress) {
                const progress = loadProgress();
                // Jika ada progress dan sudah pernah mulai test, tanyakan apakah ingin melanjutkan
                if (progress.userAnswers && Object.keys(progress.userAnswers).length > 0) {
                    Swal.fire({
                        title: 'Data Test Ditemukan',
                        html: 'Anda memiliki progress test yang belum selesai.<br>Apakah Anda ingin melanjutkan?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#0891B2',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Mulai dari Awal',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Lanjutkan test
                            dataCollectionPage.classList.add('d-none');
                            testPage.classList.remove('d-none');
                            loadQuestions();
                        } else {
                            // Mulai dari awal - hapus progress jawaban saja, form data tetap ada
                            const currentProgress = loadProgress();
                            currentProgress.userAnswers = {};
                            currentProgress.currentQuestionIndex = 0;
                            localStorage.setItem(STORAGE_KEY, JSON.stringify(currentProgress));
                        }
                    });
                }
            }

            // Logika perpindahan halaman
            formDataPeserta.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const nama = document.getElementById('nama_lengkap').value.trim();
                const email = document.getElementById('email').value.trim();
                const posisi = document.getElementById('posisi').value.trim();

                if (nama === '' || email === '' || posisi === '') {
                    errorMessage.classList.remove('d-none');
                } else {
                    errorMessage.classList.add('d-none');
                    
                    // Save form data to localStorage
                    saveProgress();
                    
                    dataCollectionPage.classList.add('d-none');
                    testPage.classList.remove('d-none');
                    
                    // Load questions and start test
                    loadQuestions();
                }
            });
        });

        // Fetch questions from database
        function loadQuestions() {
            const url = `/api/questions?test_employee_id=${TEST_EMPLOYEE_ID}&event_id=${EVENT_ID}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.status && data.questions.length > 0) {
                        questionsData = data.questions;
                        initializeTest();
                    } else {
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Tidak ada soal tersedia untuk test ini.',
                            icon: 'warning',
                            confirmButtonColor: '#0891B2',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading questions:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal memuat soal. Silakan refresh halaman.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'OK'
                    });
                });
        }

        // Initialize test after questions loaded
        function initializeTest() {
            // Check if there's saved progress
            const progress = loadProgress();
            
            // First, initialize all answers to null
            questionsData.forEach((q, index) => {
                userAnswers[index] = null;
            });
            
            // Then restore saved answers if available
            if (progress && progress.userAnswers) {
                // Only restore answers that exist in progress
                Object.keys(progress.userAnswers).forEach(key => {
                    const index = parseInt(key);
                    if (!isNaN(index) && progress.userAnswers[key] !== null && progress.userAnswers[key] !== undefined) {
                        userAnswers[index] = progress.userAnswers[key];
                    }
                });
            }

            // Setup navigation buttons
            setupNavigationButtons();
            
            // Setup question navigator
            setupQuestionNavigator();
            
            // Display question (from progress or first question)
            const startIndex = (progress && progress.currentQuestionIndex !== undefined && progress.currentQuestionIndex !== null) 
                ? progress.currentQuestionIndex 
                : 0;
            displayQuestion(startIndex);
            
            // Setup timer dengan waktu yang tersisa
            console.log('=== TIMER INFORMATION ===');
            console.log('Start Date:', EVENT_START_DATE);
            console.log('End Date:', EVENT_END_DATE);
            console.log('Total Duration (seconds):', timerDuration);
            console.log('Total Duration (minutes):', timerDuration / 60);
            
            let remainingTime = timerDuration;
            
            if (progress && progress.testStartTime) {
                // Ada progress, hitung waktu tersisa
                testStartTime = progress.testStartTime;
                const elapsedSeconds = Math.floor((Date.now() - testStartTime) / 1000);
                remainingTime = timerDuration - elapsedSeconds;
                
                console.log('Restored testStartTime:', new Date(testStartTime));
                console.log('Elapsed time (seconds):', elapsedSeconds);
                console.log('Remaining time (seconds):', remainingTime);
                
                // Jika waktu sudah habis
                if (remainingTime <= 0) {
                    remainingTime = 0;
                    setTimeout(() => {
                        finishTest(true); // Auto submit karena waktu habis
                    }, 100);
                }
            } else {
                // Test baru dimulai, set waktu mulai
                testStartTime = Date.now();
                saveProgress(); // Save waktu mulai
                console.log('New test started at:', new Date(testStartTime));
            }
            
            // Start timer dengan waktu tersisa
            startTimer(remainingTime, document.getElementById('timer'));
        }

        // Display question by index
        function displayQuestion(index) {
            currentQuestionIndex = index;
            
            // Save progress when changing question
            saveProgress();
            
            const question = questionsData[index];
            
            // Update question text
            const questionTextElement = document.querySelector('.fs-5.fw-semibold');
            questionTextElement.textContent = `${index + 1}. ${question.question_text}`;
            
            // Update badge
            const badge = document.querySelector('.badge.bg-primary-subtle');
            badge.textContent = `Soal ${index + 1} dari ${questionsData.length}`;
            
            // Update answer options
            const answerContainer = document.getElementById('answer-options');
            answerContainer.innerHTML = '';
            
            question.answers.forEach((answer, idx) => {
                const letter = String.fromCharCode(65 + idx); // A, B, C, D...
                const isSelected = userAnswers[index] === answer.id;
                
                const label = document.createElement('label');
                label.className = `answer-option d-flex align-items-center ${isSelected ? 'selected' : ''}`;
                label.setAttribute('data-answer-id', answer.id);
                
                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = `question${index}`;
                radio.value = answer.id;
                radio.className = 'me-3';
                if (isSelected) radio.checked = true;
                
                const span = document.createElement('span');
                span.className = 'fw-medium';
                span.textContent = `${letter}. ${answer.content}`;
                
                label.appendChild(radio);
                label.appendChild(span);
                answerContainer.appendChild(label);
                
                // Add click event
                label.addEventListener('click', function() {
                    selectAnswer(answer.id);
                });
            });
            
            // Update navigation buttons state
            updateNavigationButtons();
            
            // Update question navigator highlight
            updateQuestionNavigator();
        }

        // Select answer
        function selectAnswer(answerId) {
            userAnswers[currentQuestionIndex] = answerId;
            
            // Save progress to localStorage
            saveProgress();
            
            // Update UI
            const options = document.querySelectorAll('.answer-option');
            options.forEach(option => {
                option.classList.remove('selected');
                if (option.getAttribute('data-answer-id') === answerId.toString()) {
                    option.classList.add('selected');
                }
            });
            
            // Update navigator button color
            updateQuestionNavigator();
        }

        // Setup navigation buttons (Previous/Next)
        function setupNavigationButtons() {
            const footer = document.querySelector('.card-footer');
            footer.innerHTML = '';
            
            const prevBtn = document.createElement('button');
            prevBtn.className = 'btn btn-outline-secondary';
            prevBtn.id = 'prev-btn';
            prevBtn.innerHTML = '<i class="ti ti-arrow-left me-1"></i> Sebelumnya';
            prevBtn.onclick = previousQuestion;
            
            const nextBtn = document.createElement('button');
            nextBtn.className = 'btn btn-primary';
            nextBtn.id = 'next-btn';
            nextBtn.innerHTML = 'Selanjutnya <i class="ti ti-arrow-right ms-1"></i>';
            nextBtn.onclick = nextQuestion;
            
            const finishBtn = document.createElement('button');
            finishBtn.className = 'btn btn-success d-none';
            finishBtn.id = 'finish-btn';
            finishBtn.innerHTML = 'Selesai Test <i class="ti ti-check ms-1"></i>';
            finishBtn.onclick = finishTest;
            
            footer.appendChild(prevBtn);
            footer.appendChild(nextBtn);
            footer.appendChild(finishBtn);
        }

        // Update navigation buttons state
        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            const finishBtn = document.getElementById('finish-btn');
            
            // Previous button
            if (currentQuestionIndex === 0) {
                prevBtn.disabled = true;
            } else {
                prevBtn.disabled = false;
            }
            
            // Next/Finish button
            if (currentQuestionIndex === questionsData.length - 1) {
                nextBtn.classList.add('d-none');
                finishBtn.classList.remove('d-none');
            } else {
                nextBtn.classList.remove('d-none');
                finishBtn.classList.add('d-none');
            }
        }

        // Previous question
        function previousQuestion() {
            if (currentQuestionIndex > 0) {
                displayQuestion(currentQuestionIndex - 1);
            }
        }

        // Next question
        function nextQuestion() {
            if (currentQuestionIndex < questionsData.length - 1) {
                displayQuestion(currentQuestionIndex + 1);
            }
        }

        // Setup question navigator (number buttons)
        function setupQuestionNavigator() {
            const navigator = document.getElementById('question-navigator');
            navigator.innerHTML = '';
            
            questionsData.forEach((q, index) => {
                const col = document.createElement('div');
                col.className = 'col';
                
                const btn = document.createElement('button');
                btn.className = 'btn btn-outline-secondary w-100';
                btn.textContent = index + 1;
                btn.onclick = function() {
                    displayQuestion(index);
                };
                
                col.appendChild(btn);
                navigator.appendChild(col);
            });
        }

        // Update question navigator highlight
        function updateQuestionNavigator() {
            const buttons = document.querySelectorAll('#question-navigator button');
            buttons.forEach((btn, index) => {
                btn.classList.remove('btn-primary', 'btn-success', 'btn-outline-secondary');
                
                if (index === currentQuestionIndex) {
                    btn.classList.add('btn-primary');
                } else if (userAnswers[index] !== null) {
                    btn.classList.add('btn-success');
                } else {
                    btn.classList.add('btn-outline-secondary');
                }
            });
        }

        // Timer function
        function startTimer(duration, display) {
            let timer = duration;
            timerInterval = setInterval(function () {
                const minutes = parseInt(timer / 60, 10);
                const seconds = parseInt(timer % 60, 10);

                const minutesStr = minutes < 10 ? "0" + minutes : minutes;
                const secondsStr = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = "Sisa Waktu: " + minutesStr + ":" + secondsStr;

                if (--timer < 0) {
                    clearInterval(timerInterval);
                    display.textContent = "Waktu Habis!";
                    finishTest(true); // Auto submit
                }
            }, 1000);
        }

        // Finish test
        function finishTest(autoSubmit = false) {
            // Cek apakah sudah pernah submit
            if (isSubmitted) {
                Swal.fire({
                    title: 'Test Sudah Selesai!',
                    text: 'Anda sudah menyelesaikan test ini sebelumnya.',
                    icon: 'info',
                    confirmButtonColor: '#0891B2',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Cek apakah sedang proses submit
            if (isSubmitting) {
                return; // Prevent double click
            }
            
            clearInterval(timerInterval);
            
            // Count answered questions - PERBAIKAN
            let answeredCount = 0;
            let unansweredQuestions = [];
            
            for (let i = 0; i < questionsData.length; i++) {
                if (userAnswers[i] !== null && userAnswers[i] !== undefined) {
                    answeredCount++;
                } else {
                    unansweredQuestions.push(i + 1); // Simpan nomor soal yang belum dijawab
                }
            }
            
            const unansweredCount = questionsData.length - answeredCount;
            
            console.log('Debug - Total soal:', questionsData.length);
            console.log('Debug - Soal dijawab:', answeredCount);
            console.log('Debug - Soal belum dijawab:', unansweredCount);
            console.log('Debug - Nomor soal belum dijawab:', unansweredQuestions);
            console.log('Debug - userAnswers:', userAnswers);
            
            // Validasi: cek apakah semua soal sudah dijawab (kecuali auto submit)
            if (unansweredCount > 0 && !autoSubmit) {
                Swal.fire({
                    title: 'Soal Belum Lengkap!',
                    html: `
                        <div class="text-start">
                            <p>Masih ada <strong class="text-danger">${unansweredCount} soal</strong> yang belum dijawab:</p>
                            <ul class="text-muted small">
                                <li>Soal Dijawab: <strong>${answeredCount}</strong></li>
                                <li>Belum Dijawab: <strong class="text-danger">${unansweredCount}</strong></li>
                                <li>Total Soal: <strong>${questionsData.length}</strong></li>
                                <li>Nomor Soal Belum Dijawab: <strong class="text-danger">${unansweredQuestions.join(', ')}</strong></li>
                            </ul>
                            <div class="alert alert-warning py-2 px-3 mb-0">
                                <small><i class="ti ti-alert-triangle me-1"></i> Anda harus menjawab semua soal sebelum menyelesaikan test.</small>
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    confirmButtonColor: '#0891B2',
                    confirmButtonText: 'OK, Saya Mengerti',
                    allowOutsideClick: false
                });
                
                // Restart timer jika belum lengkap
                const progress = loadProgress();
                if (progress && progress.testStartTime) {
                    const elapsedSeconds = Math.floor((Date.now() - progress.testStartTime) / 1000);
                    const remainingTime = timerDuration - elapsedSeconds;
                    if (remainingTime > 0) {
                        startTimer(remainingTime, document.getElementById('timer'));
                    }
                }
                
                return;
            }
            
            if (!autoSubmit) {
                // Konfirmasi pertama: apakah yakin ingin menyelesaikan?
                Swal.fire({
                    title: 'Konfirmasi Penyelesaian Test',
                    html: `
                        <div class="text-start">
                            <p class="mb-3">Anda telah menjawab <strong class="text-success">${answeredCount}</strong> dari <strong>${questionsData.length}</strong> soal.</p>
                            <div class="alert alert-info py-2 px-3 mb-3">
                                <small><i class="ti ti-info-circle me-1"></i> Setelah Anda klik "Ya, Selesaikan", jawaban tidak dapat diubah lagi.</small>
                            </div>
                            <p class="mb-0 fw-bold">Apakah Anda yakin ingin menyelesaikan test ini?</p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0891B2',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="ti ti-check me-1"></i> Ya, Selesaikan',
                    cancelButtonText: '<i class="ti ti-x me-1"></i> Batal',
                    reverseButtons: true,
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Konfirmasi kedua: konfirmasi final
                        Swal.fire({
                            title: 'Konfirmasi Terakhir',
                            html: `
                                <div class="text-start">
                                    <p class="text-danger fw-bold mb-3"><i class="ti ti-alert-circle me-1"></i> Ini adalah konfirmasi terakhir!</p>
                                    <p class="mb-2">Data yang akan dikirim:</p>
                                    <ul class="text-muted small">
                                        <li>Nama: <strong>${document.getElementById('nama_lengkap').value}</strong></li>
                                        <li>Email: <strong>${document.getElementById('email').value}</strong></li>
                                        <li>Total Jawaban: <strong>${answeredCount} soal</strong></li>
                                    </ul>
                                    <p class="mb-0"><strong>Apakah Anda benar-benar yakin?</strong></p>
                                </div>
                            `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: '<i class="ti ti-send me-1"></i> Ya, Kirim Sekarang!',
                            cancelButtonText: '<i class="ti ti-arrow-left me-1"></i> Periksa Lagi',
                            reverseButtons: true,
                            allowOutsideClick: false
                        }).then((finalResult) => {
                            if (finalResult.isConfirmed) {
                                submitAnswers();
                            } else {
                                // User batal, restart timer
                                const progress = loadProgress();
                                if (progress && progress.testStartTime) {
                                    const elapsedSeconds = Math.floor((Date.now() - progress.testStartTime) / 1000);
                                    const remainingTime = timerDuration - elapsedSeconds;
                                    if (remainingTime > 0) {
                                        startTimer(remainingTime, document.getElementById('timer'));
                                    }
                                }
                            }
                        });
                    } else {
                        // User batal, restart timer
                        const progress = loadProgress();
                        if (progress && progress.testStartTime) {
                            const elapsedSeconds = Math.floor((Date.now() - progress.testStartTime) / 1000);
                            const remainingTime = timerDuration - elapsedSeconds;
                            if (remainingTime > 0) {
                                startTimer(remainingTime, document.getElementById('timer'));
                            }
                        }
                    }
                });
            } else {
                // Auto submit (waktu habis)
                Swal.fire({
                    title: 'Waktu Habis!',
                    text: 'Test akan otomatis dikirim.',
                    icon: 'warning',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    submitAnswers();
                });
            }
        }

        

        // Submit answers to server
        function submitAnswers() {
            // Prevent double submit
            if (isSubmitting || isSubmitted) {
                return;
            }
            
            isSubmitting = true; // Set flag sedang submit
            
            const namaLengkap = document.getElementById('nama_lengkap').value;
            const email = document.getElementById('email').value;
            const posisi = document.getElementById('posisi').value;
            
            // Tampilkan loading
            Swal.fire({
                title: 'Mengirim Jawaban...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            const payload = {
                test_employee_id: TEST_EMPLOYEE_ID,
                event_id: EVENT_ID,
                nama_lengkap: namaLengkap,
                email: email,
                posisi: posisi,
                answers: userAnswers
            };
            
            fetch('/api/submit-test', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    // Set flag sudah submit
                    isSubmitted = true;
                    
                    // Hapus data dari localStorage setelah berhasil submit
                    clearProgress();
                    
                    // Tampilkan hasil test dengan SweetAlert2
                    Swal.fire({
                        title: 'Test Berhasil Diselesaikan!',
                        html: `
                            <div class="text-start">
                                <p class="mb-2"><strong>Nama:</strong> ${namaLengkap}</p>
                                <p class="mb-2"><strong>Email:</strong> ${email}</p>
                                <p class="mb-2"><strong>Posisi:</strong> ${posisi}</p>
                                <hr>
                                <p class="mb-2"><strong>Soal Dijawab:</strong> ${data.total_answers} dari ${questionsData.length}</p>
                                <p class="mb-0"><strong>Total Nilai:</strong> <span class="text-success fs-4">${data.score}</span></p>
                            </div>
                        `,
                        icon: 'success',
                        confirmButtonColor: '#0891B2',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then(() => {
                        // Redirect atau refresh halaman jika diperlukan
                        // window.location.href = '/dashboard';
                    });
                } else {
                    // Reset flag jika gagal
                    isSubmitting = false;
                    
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Gagal menyimpan jawaban: ' + data.message,
                        icon: 'error',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                // Reset flag jika error
                isSubmitting = false;
                
                console.error('Error submitting test:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengirim jawaban.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK'
                });
            });
        }
    </script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>

