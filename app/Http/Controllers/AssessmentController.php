<?php

namespace App\Http\Controllers;

use App\Models\StressAssessment;
use App\Services\BadgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AssessmentController extends Controller
{
    // =============================
    // SHOW FORM ASSESSMENT
    // =============================
    public function form()
    {
        return view('user.assessment');
    }

    // =============================
    // PROCESS ASSESSMENT (ML + SAVE)
    // =============================
    public function predict(Request $request)
    {
        $user = Auth::user();

        // Ambil array jawaban 0–22
        $answers = json_decode($request->answers, true);

        if (!$answers || count($answers) !== 23) {
            return back()->with('error', 'Jawaban tidak lengkap.');
        }

        // ===== PAYLOAD KE FLASK (URUT SESUAI FEATURE LIST) =====
        $payload = [
            "gender" => $user->gender ?? 1,
            "age" => $user->age ?? 20,
            "have_you_recently_experienced_stress_in_your_life" => $answers[0],
            "have_you_noticed_a_rapid_heartbeat_or_palpitations" => $answers[1],
            "have_you_been_dealing_with_anxiety_or_tension_recently" => $answers[2],
            "do_you_face_any_sleep_problems_or_difficulties_falling_asleep" => $answers[3],
            "have_you_been_dealing_with_anxiety_or_tension_recently_1" => $answers[4],
            "have_you_been_getting_headaches_more_often_than_usual" => $answers[5],
            "do_you_get_irritated_easily" => $answers[6],
            "do_you_have_trouble_concentrating_on_your_academic_tasks" => $answers[7],
            "have_you_been_feeling_sadness_or_low_mood" => $answers[8],
            "have_you_been_experiencing_any_illness_or_health_issues" => $answers[9],
            "do_you_often_feel_lonely_or_isolated" => $answers[10],
            "do_you_feel_overwhelmed_with_your_academic_workload" => $answers[11],
            "are_you_in_competition_with_your_peers,_and_does_it_affect_you" => $answers[12],
            "do_you_find_that_your_relationship_often_causes_you_stress" => $answers[13],
            "are_you_facing_any_difficulties_with_your_professors_or_instructors" => $answers[14],
            "is_your_working_environment_unpleasant_or_stressful" => $answers[15],
            "do_you_struggle_to_find_time_for_relaxation_and_leisure_activities" => $answers[16],
            "is_your_hostel_or_home_environment_causing_you_difficulties" => $answers[17],
            "do_you_lack_confidence_in_your_academic_performance" => $answers[18],
            "do_you_lack_confidence_in_your_choice_of_academic_subjects" => $answers[19],
            "academic_and_extracurricular_activities_conflicting_for_you" => $answers[20],
            "do_you_attend_classes_regularly" => $answers[21],
            "weight_change" => $answers[22],
        ];


        // ===== CALL FLASK API =====
        try {
            $apiUrl = env('ML_API_URL', 'https://insightstress.pythonanywhere.com/predict');
            $response = Http::timeout(10)->post($apiUrl, $payload);

            // Check if response is successful
            if (!$response->successful()) {
                \Log::error('ML API returned error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return back()->with("error", "Machine Learning API mengembalikan error. Silakan coba lagi.");
            }

            $label = $response->json("label"); // 0 / 1 / 2
            $category = $response->json("category"); // No Stress / Eustress / Distress

            // Validate response data
            if ($label === null || $category === null) {
                \Log::error('ML API returned incomplete data', [
                    'response' => $response->json()
                ]);
                return back()->with("error", "Data prediksi tidak lengkap. Silakan coba lagi.");
            }

            // Validate label value
            if (!in_array($label, [0, 1, 2])) {
                \Log::error('ML API returned invalid label', [
                    'label' => $label,
                    'category' => $category
                ]);
                return back()->with("error", "Hasil prediksi tidak valid. Silakan coba lagi.");
            }

            // Validate category value
            $validCategories = ['No Stress', 'Eustress', 'Distress'];
            if (!in_array($category, $validCategories)) {
                \Log::error('ML API returned invalid category', [
                    'label' => $label,
                    'category' => $category
                ]);
                return back()->with("error", "Kategori stress tidak valid. Silakan coba lagi.");
            }


            // Log successful prediction
            \Log::info('ML API prediction successful', [
                'user_id' => $user->id,
                'label' => $label,
                'category' => $category
            ]);

            // ===== RULE-BASED VALIDATION =====
            // Calculate average score from answers (0-4 scale)
            $totalScore = array_sum($answers);
            $avgScore = $totalScore / count($answers);

            // Determine expected category based on average
            // 0-1.5 = No Stress, 1.5-3 = Eustress, 3-4 = Distress
            $expectedCategory = null;
            if ($avgScore < 1.5) {
                $expectedCategory = 'No Stress';
                $expectedLabel = 0;
            }
            elseif ($avgScore < 3.0) {
                $expectedCategory = 'Eustress';
                $expectedLabel = 1;
            }
            else {
                $expectedCategory = 'Distress';
                $expectedLabel = 2;
            }

            // Override ML prediction if it's unreasonable
            $originalCategory = $category;
            $originalLabel = $label;

            // If ML says "No Stress" but avg > 3 (mostly "Sering/Sangat Sering")
            if ($category === 'No Stress' && $avgScore >= 3.0) {
                $category = 'Distress';
                $label = 2;
                \Log::warning('ML prediction overridden', [
                    'original' => $originalCategory,
                    'corrected' => $category,
                    'avg_score' => $avgScore
                ]);
            }

            // If ML says "Eustress" but avg > 3.5 (almost all "Sangat Sering")
            if ($category === 'Eustress' && $avgScore >= 3.5) {
                $category = 'Distress';
                $label = 2;
                \Log::warning('ML prediction overridden', [
                    'original' => $originalCategory,
                    'corrected' => $category,
                    'avg_score' => $avgScore
                ]);
            }

            // If ML says "Distress" but avg < 1 (mostly "Tidak Pernah")
            if ($category === 'Distress' && $avgScore < 1.0) {
                $category = 'No Stress';
                $label = 0;
                \Log::warning('ML prediction overridden', [
                    'original' => $originalCategory,
                    'corrected' => $category,
                    'avg_score' => $avgScore
                ]);
            }

        }
        catch (\Illuminate\Http\Client\ConnectionException $e) {
            \Log::error('Cannot connect to ML API', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            return back()->with("error", "Tidak dapat terhubung ke Machine Learning API. Pastikan koneksi internet Anda stabil atau coba lagi nanti.");
        }
        catch (\Exception $e) {
            \Log::error('ML API call failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            return back()->with("error", "Gagal memproses assessment: " . $e->getMessage());
        }

        // ===== SAVE TO DATABASE =====
        $assessment = StressAssessment::create([
            "user_id" => $user->id,
            "gender" => $user->gender ?? 1,
            "age" => $user->age ?? 20,

            "stress_recent" => $answers[0],
            "heartbeat" => $answers[1],
            "anxiety" => $answers[2],
            "sleep_problems" => $answers[3],
            "anxiety_2" => $answers[4],
            "headache" => $answers[5],
            "irritated" => $answers[6],
            "concentration" => $answers[7],
            "sadness" => $answers[8],
            "illness" => $answers[9],
            "lonely" => $answers[10],
            "overwhelmed" => $answers[11],
            "competition" => $answers[12],
            "relationship_stress" => $answers[13],
            "professor_difficulty" => $answers[14],
            "work_env" => $answers[15],
            "relaxation_time" => $answers[16],
            "home_env" => $answers[17],
            "conf_academic" => $answers[18],
            "conf_subject" => $answers[19],
            "activity_conflict" => $answers[20],
            "attendance" => $answers[21],
            "weight_change" => $answers[22],

            // FINAL CLASSIFIER OUTPUT
            "predicted_stress" => $label,
            "numeric_score" => $label, // 0/1/2 → untuk grafik
            "stress_category" => $category // teks kategori
        ]);

        // ===== CREATE NOTIFICATIONS =====

        // 1. Success notification for assessment completion
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'title' => 'Assessment Berhasil Disimpan',
            'title_en' => 'Assessment Saved Successfully',
            'message' => 'Hasil assessment terakhir Anda telah tersimpan. Lihat hasil analisis dan rekomendasi personal Anda.',
            'message_en' => 'Your latest assessment has been saved. View your analysis results and personalized recommendations.',
            'type' => 'success',
            'icon' => 'check-circle',
            'is_read' => false,
        ]);

        // 2. Warning notification if stress category is Distress
        if ($category === 'Distress') {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => 'Peringatan: Tingkat Stres Tinggi',
                'title_en' => 'Warning: High Stress Level Detected',
                'message' => 'Tingkat stres Anda tergolong Distress. Luangkan waktu untuk istirahat, atau pertimbangkan untuk konsultasi dengan konselor.',
                'message_en' => 'Your stress level is categorized as Distress. Take time to rest, or consider consulting a counselor.',
                'type' => 'warning',
                'icon' => 'alert-triangle',
                'is_read' => false,
            ]);
        }

        // 3. Alert notification if sleep problems score is high (≥3)
        if ($answers[3] >= 3) { // sleep_problems
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => 'Perhatian: Pola Tidur Anda',
                'title_en' => 'Attention: Your Sleep Pattern',
                'message' => 'Berdasarkan assessment terakhir, kualitas tidur Anda menurun. Coba terapkan tips tidur sehat kami.',
                'message_en' => 'Based on your latest assessment, your sleep quality has decreased. Try applying our healthy sleep tips.',
                'type' => 'warning',
                'icon' => 'moon',
                'is_read' => false,
            ]);
        }

        // 4. Milestone notification when user completes 5, 10, 15+ assessments
        $totalAssessments = \App\Models\StressAssessment::where('user_id', $user->id)->count();
        if (in_array($totalAssessments, [5, 10, 15, 20, 25, 30])) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => 'Pencapaian: ' . $totalAssessments . ' Assessment Selesai',
                'title_en' => 'Achievement: ' . $totalAssessments . ' Assessments Completed',
                'message' => 'Selamat! Anda telah menyelesaikan ' . $totalAssessments . ' assessment. Terus pantau kesehatan mental Anda.',
                'message_en' => 'Congratulations! You have completed ' . $totalAssessments . ' assessments. Keep monitoring your mental health.',
                'type' => 'success',
                'icon' => 'trophy',
                'is_read' => false,
            ]);
        }

        // 5. Tips notification (random, 20% chance)
        if (rand(1, 100) <= 20) {
            $tips = [
                [
                    'id' => 'Kami telah menambahkan tips baru tentang teknik pernapasan untuk mengatasi kecemasan mendadak.',
                    'en' => 'We have added new tips on breathing techniques to overcome sudden anxiety.',
                ],
                [
                    'id' => 'Tips baru tersedia! Pelajari cara membuat jadwal tidur yang konsisten untuk hasil yang lebih baik.',
                    'en' => 'New tips available! Learn how to create a consistent sleep schedule for better results.',
                ],
                [
                    'id' => 'Coba teknik Pomodoro untuk meningkatkan fokus dan mengurangi stress akademik Anda.',
                    'en' => 'Try the Pomodoro technique to boost focus and reduce your academic stress.',
                ],
            ];

            $selectedTip = $tips[array_rand($tips)];

            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => 'Tips Baru Tersedia',
                'title_en' => 'New Tips Available',
                'message' => $selectedTip['id'],
                'message_en' => $selectedTip['en'],
                'type' => 'info',
                'icon' => 'lightbulb',
                'is_read' => false,
            ]);
        }

        // ===== CHECK AND AWARD BADGES =====
        $badgeService = app(BadgeService::class);
        $badgeService->checkAndAwardBadges($user, 'assessment_completed');
        $badgeService->checkAndAwardBadges($user, 'stress_improved');

        return redirect()->route("user.analysis")
            ->with("success", "Assessment berhasil disimpan!");
    }

    // =============================
    // ANALYSIS PAGE
    // =============================
    public function analysis($id = null)
    {
        $user = Auth::user();

        // Get all assessments first
        $assessments = StressAssessment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')->get();

        // If ID is provided, show that specific assessment
        if ($id) {
            $latest = StressAssessment::where('user_id', $user->id)
                ->where('id', $id)
                ->firstOrFail();
        }
        else {
            // Otherwise, show the latest assessment
            $latest = $assessments->first();
        }

        return view('user.analysis', compact('latest', 'assessments', 'user'));
    }

    // =============================
    // HISTORY PAGE
    // =============================
    public function history()
    {
        $user = Auth::user();
        $assessments = StressAssessment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $totalAssessments = $assessments->count();

        $lowestScore = null;
        $highestScore = null;
        $averageScore = null;

        if ($totalAssessments > 0) {
            // Get total scores for each assessment
            $scores = $assessments->map(function ($assessment) {
                return $assessment->total_score;
            });

            $lowestScore = $scores->min();
            $highestScore = $scores->max();
            $averageScore = round($scores->avg());
        }

        return view('user.assessment_history', compact(
            'assessments',
            'user',
            'totalAssessments',
            'lowestScore',
            'highestScore',
            'averageScore'
        ));
    }

    // =============================
    // GET ASSESSMENT DETAILS (AJAX)
    // =============================
    public function getAssessmentDetails($id)
    {
        $user = Auth::user();
        $assessment = StressAssessment::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Get all assessment fields
        $fields = [
            'stress_recent' => 'Stress Baru-baru Ini',
            'heartbeat' => 'Detak Jantung Cepat',
            'anxiety' => 'Kecemasan/Ketegangan',
            'sleep_problems' => 'Masalah Tidur',
            'anxiety_2' => 'Kecemasan (2)',
            'headache' => 'Sakit Kepala',
            'irritated' => 'Mudah Tersinggung',
            'concentration' => 'Kesulitan Konsentrasi',
            'sadness' => 'Kesedihan',
            'illness' => 'Sakit/Masalah Kesehatan',
            'lonely' => 'Kesepian',
            'overwhelmed' => 'Kewalahan dengan Tugas',
            'competition' => 'Kompetisi dengan Teman',
            'relationship_stress' => 'Stress Hubungan',
            'professor_difficulty' => 'Kesulitan dengan Dosen',
            'work_env' => 'Lingkungan Kerja Tidak Nyaman',
            'relaxation_time' => 'Kurang Waktu Relaksasi',
            'home_env' => 'Lingkungan Rumah/Kos',
            'conf_academic' => 'Kurang Percaya Diri Akademik',
            'conf_subject' => 'Kurang Percaya Diri Mata Kuliah',
            'activity_conflict' => 'Konflik Akademik & Ekstrakurikuler',
            'attendance' => 'Kehadiran Kelas',
            'weight_change' => 'Perubahan Berat Badan',
        ];

        // Get recommendations based on stress category
        $recommendations = [];
        if ($assessment->stress_category === 'Distress') {
            $recommendations = [
                'Pertimbangkan untuk berkonsultasi dengan konselor atau psikolog',
                'Praktikkan teknik relaksasi seperti meditasi atau yoga',
                'Atur jadwal tidur yang teratur (7-8 jam per malam)',
                'Batasi konsumsi kafein dan screen time sebelum tidur',
                'Lakukan olahraga ringan secara teratur',
            ];
        }
        elseif ($assessment->stress_category === 'Eustress') {
            $recommendations = [
                'Pertahankan pola hidup sehat yang sudah Anda jalani',
                'Tetap kelola waktu dengan baik untuk menghindari stress berlebih',
                'Jaga keseimbangan antara akademik dan kehidupan pribadi',
                'Lakukan aktivitas yang Anda sukai secara rutin',
            ];
        }
        else {
            $recommendations = [
                'Pertahankan kondisi mental yang baik',
                'Tetap waspada terhadap perubahan pola stress',
                'Lakukan assessment secara berkala',
                'Jaga pola hidup sehat',
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $assessment->id,
                'date' => $assessment->created_at->format('d F Y'),
                'time' => $assessment->created_at->format('H:i'),
                'category' => $assessment->stress_category,
                'numeric_score' => $assessment->numeric_score,
                'total_score' => $assessment->total_score,
                'fields' => $fields,
                'answers' => [
                    'stress_recent' => $assessment->stress_recent,
                    'heartbeat' => $assessment->heartbeat,
                    'anxiety' => $assessment->anxiety,
                    'sleep_problems' => $assessment->sleep_problems,
                    'anxiety_2' => $assessment->anxiety_2,
                    'headache' => $assessment->headache,
                    'irritated' => $assessment->irritated,
                    'concentration' => $assessment->concentration,
                    'sadness' => $assessment->sadness,
                    'illness' => $assessment->illness,
                    'lonely' => $assessment->lonely,
                    'overwhelmed' => $assessment->overwhelmed,
                    'competition' => $assessment->competition,
                    'relationship_stress' => $assessment->relationship_stress,
                    'professor_difficulty' => $assessment->professor_difficulty,
                    'work_env' => $assessment->work_env,
                    'relaxation_time' => $assessment->relaxation_time,
                    'home_env' => $assessment->home_env,
                    'conf_academic' => $assessment->conf_academic,
                    'conf_subject' => $assessment->conf_subject,
                    'activity_conflict' => $assessment->activity_conflict,
                    'attendance' => $assessment->attendance,
                    'weight_change' => $assessment->weight_change,
                ],
                'recommendations' => $recommendations,
            ]
        ]);
    }

    // =============================
    // EXPORT CSV
    // =============================
    public function exportCsv()
    {
        $user = Auth::user();
        $assessments = StressAssessment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')->get();

        $filename = 'assessment_' . $user->name . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($assessments) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'Tanggal',
                'Kategori Stress',
                'Skor Numerik',
                'Gender',
                'Age',
                'Stress Recent',
                'Heartbeat',
                'Anxiety',
                'Sleep Problems',
                'Headache',
                'Irritated',
                'Concentration',
                'Sadness',
                'Illness',
                'Lonely',
                'Overwhelmed',
                'Competition',
                'Relationship Stress',
                'Professor Difficulty',
                'Work Environment',
                'Relaxation Time',
                'Home Environment',
                'Confidence Academic',
                'Confidence Subject',
                'Activity Conflict',
                'Attendance',
                'Weight Change'
            ]);

            // Data rows
            foreach ($assessments as $assessment) {
                fputcsv($file, [
                    $assessment->created_at->format('Y-m-d H:i:s'),
                    $assessment->stress_category,
                    $assessment->numeric_score,
                    $assessment->gender,
                    $assessment->age,
                    $assessment->stress_recent,
                    $assessment->heartbeat,
                    $assessment->anxiety,
                    $assessment->sleep_problems,
                    $assessment->headache,
                    $assessment->irritated,
                    $assessment->concentration,
                    $assessment->sadness,
                    $assessment->illness,
                    $assessment->lonely,
                    $assessment->overwhelmed,
                    $assessment->competition,
                    $assessment->relationship_stress,
                    $assessment->professor_difficulty,
                    $assessment->work_env,
                    $assessment->relaxation_time,
                    $assessment->home_env,
                    $assessment->conf_academic,
                    $assessment->conf_subject,
                    $assessment->activity_conflict,
                    $assessment->attendance,
                    $assessment->weight_change,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}