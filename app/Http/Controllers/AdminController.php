<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use App\Models\StressAssessment;
use App\Models\Tip; // Added Tip model

class AdminController extends Controller
{
    // ... existing login methods ...

    // ===============================
    // TIPS & ARTICLES MANAGEMENT
    // ===============================

    // List all tips
    public function viewTips(Request $request)
    {
        $query = Tip::query();

        // Search
        if ($search = $request->get('search')) {
            $query->where('title_id', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('content_id', 'like', "%{$search}%")
                  ->orWhere('content_en', 'like', "%{$search}%");
        }

        // Filter by category
        if ($category = $request->get('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        $tips = $query->latest()->paginate(10);

        // Get category counts from entire database
        $categories = [
            'all' => Tip::count(),
            'breathing' => Tip::where('category', 'breathing')->count(),
            'sleep' => Tip::where('category', 'sleep')->count(),
            'exercise' => Tip::where('category', 'exercise')->count(),
            'mindfulness' => Tip::where('category', 'mindfulness')->count(),
            'study' => Tip::where('category', 'study')->count(),
            'general' => Tip::where('category', 'general')->count(),
        ];

        return view('admin.tips', compact('tips', 'categories'));
    }

    // Show create form
    public function createTip()
    {
        return view('admin.tips-form');
    }

    // Store new tip
    public function storeTip(Request $request)
    {
        $request->validate([
            'title_id' => 'required|max:255',
            'title_en' => 'required|max:255',
            'category' => 'required|in:breathing,sleep,exercise,mindfulness,study,general',
            'content_id' => 'required',
            'content_en' => 'required',
            'target_condition' => 'required|in:Distress,Eustress,Semua Kondisi',
            'read_duration' => 'nullable|integer|min:1',
            'is_evidence_based' => 'nullable|boolean',
            'is_ai_recommended' => 'nullable|boolean'
        ]);

        Tip::create([
            'title_id' => $request->title_id,
            'title_en' => $request->title_en,
            'category' => $request->category,
            'content_id' => $request->content_id,
            'content_en' => $request->content_en,
            'target_condition' => $request->target_condition,
            'read_duration' => $request->read_duration,
            'is_evidence_based' => $request->has('is_evidence_based'),
            'is_ai_recommended' => $request->has('is_ai_recommended'),
            'views' => 0
        ]);

        return redirect()->route('admin.tips')->with('success', 'Artikel berhasil ditambahkan.');
    }

    // Show edit form
    public function editTip($id)
    {
        $tip = Tip::findOrFail($id);
        return view('admin.tips-form', compact('tip'));
    }

    // Update tip
    public function updateTip(Request $request, $id)
    {
        $request->validate([
            'title_id' => 'required|max:255',
            'title_en' => 'required|max:255',
            'category' => 'required|in:breathing,sleep,exercise,mindfulness,study,general',
            'content_id' => 'required',
            'content_en' => 'required',
            'target_condition' => 'required|in:Distress,Eustress,Semua Kondisi',
            'read_duration' => 'nullable|integer|min:1',
            'is_evidence_based' => 'nullable|boolean',
            'is_ai_recommended' => 'nullable|boolean'
        ]);

        $tip = Tip::findOrFail($id);
        $tip->update([
            'title_id' => $request->title_id,
            'title_en' => $request->title_en,
            'category' => $request->category,
            'content_id' => $request->content_id,
            'content_en' => $request->content_en,
            'target_condition' => $request->target_condition,
            'read_duration' => $request->read_duration,
            'is_evidence_based' => $request->has('is_evidence_based'),
            'is_ai_recommended' => $request->has('is_ai_recommended')
        ]);

        return redirect()->route('admin.tips')->with('success', 'Artikel berhasil diperbarui.');
    }

    // Delete tip
    public function deleteTip($id)
    {
        $tip = Tip::findOrFail($id);
        $tip->delete();

        return redirect()->route('admin.tips')->with('success', 'Artikel berhasil dihapus.');
    }

    // tampilkan halaman login admin
    public function showLogin()
    {
        return view('admin.login');
    }

    // proses login admin
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai admin.');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // dashboard admin
    public function dashboard()
    {
        // Stats Cards
        $totalUsers = User::count();
        $totalAssessments = StressAssessment::count();
        
        // Average stress score (0-2 scale: 0=No Stress, 1=Eustress, 2=Distress)
        $avgScore = StressAssessment::avg('numeric_score') ?? 0;
        $avgScorePercentage = round(($avgScore / 2) * 100);
        
        
        // Count unique students whose LATEST assessment is Distress in the last 30 days
        $highStressCount = User::whereHas('assessments', function($query) {
            $query->where('numeric_score', 2)
                  ->where('created_at', '>=', now()->subDays(30))
                  ->whereRaw('id = (SELECT id FROM stress_assessments WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1)');
        })->count();
        
        // Monthly trend data (last 7 months)
        $monthlyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = StressAssessment::whereYear('created_at', $month->year)
                                    ->whereMonth('created_at', $month->month)
                                    ->count();
            $monthlyTrend[] = [
                'month' => $month->format('M'),
                'count' => $count
            ];
        }
        
        // Stress distribution based on numeric_score (0=No Stress, 1=Eustress, 2=Distress)
        $stressDistribution = [
            'low' => StressAssessment::where('numeric_score', '=', 0)->count(),    // No Stress
            'medium' => StressAssessment::where('numeric_score', '=', 1)->count(), // Eustress
            'high' => StressAssessment::where('numeric_score', '=', 2)->count(),   // Distress
        ];
        
        // Calculate AI Insight based on 30 day trend
        $recentHighCount = StressAssessment::where('numeric_score', 2)->where('created_at', '>=', now()->subDays(30))->count();
        $previousHighCount = StressAssessment::where('numeric_score', 2)->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        
        $aiInsightMessage = '';
        $isEn = app()->getLocale() === 'en';

        if ($recentHighCount === 0 && $previousHighCount === 0) {
            $aiInsightMessage = $isEn
                ? 'Student stress levels are currently monitored as stable and low. Continue maintaining the existing student wellbeing programs.'
                : 'Saat ini tingkat stres mahasiswa terpantau stabil dan rendah. Terus pertahankan program kesejahteraan mahasiswa yang ada.';
        } elseif ($recentHighCount > $previousHighCount) {
            $percentageIncrease = $previousHighCount > 0 ? round((($recentHighCount - $previousHighCount) / $previousHighCount) * 100) : 100;
            $aiInsightMessage = $isEn
                ? "Based on the latest assessment data, the system detected that student stress levels show a pattern of <b>increasing by {$percentageIncrease}%</b> compared to last month. This pattern often appears during assignment deadlines or exam periods. <br><br><b>System Recommendations:</b><br>&bull; Encourage students to complete assessments regularly.<br>&bull; Promote breathing exercises and relaxation techniques.<br>&bull; Consider additional academic support or counseling programs."
                : "Berdasarkan data assessment terbaru, sistem mendeteksi bahwa tingkat stres mahasiswa menunjukkan pola <b>meningkat sebesar {$percentageIncrease}%</b> dibandingkan bulan lalu. Pola ini biasanya muncul saat periode tugas atau ujian akademik. <br><br><b>Rekomendasi sistem:</b><br>&bull; Dorong mahasiswa untuk melakukan assessment secara rutin.<br>&bull; Promosikan latihan pernapasan dan teknik relaksasi.<br>&bull; Pertimbangkan program dukungan akademik atau konseling tambahan.";
        } else {
            $percentageDecrease = $previousHighCount > 0 ? round((($previousHighCount - $recentHighCount) / $previousHighCount) * 100) : 0;
            $aiInsightMessage = $isEn
                ? "This month, student stress levels have <b>decreased by {$percentageDecrease}%</b>. The ongoing mental health intervention and education programs are showing positive results. <br><br><b>System Recommendations:</b><br>&bull; Continue sharing new educational articles to maintain this momentum."
                : "Bulan ini tingkat stres mahasiswa <b>menurun sebesar {$percentageDecrease}%</b>. Program intervensi dan edukasi kesehatan mental yang berjalan menunjukkan hasil positif. <br><br><b>Rekomendasi sistem:</b><br>&bull; Terus bagikan artikel edukasi baru untuk menjaga momentum ini.";
        }

        // Recent assessments (last 5)
        $recentAssessments = StressAssessment::with('user')
                                            ->orderBy('created_at', 'desc')
                                            ->take(5)
                                            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAssessments',
            'avgScorePercentage',
            'highStressCount',
            'monthlyTrend',
            'stressDistribution',
            'aiInsightMessage',
            'recentAssessments'
        ));
    }

    /**
     * tampilkan daftar users untuk admin
     */
    public function viewUsers()
    {
        // Calculate Top Cards Statistics
        $totalUsers = User::count();
        $activeUsers = User::whereHas('assessments')->count();
        
        $highRiskUsers = User::whereHas('assessments', function($query) {
            $query->where('numeric_score', 2)
                  ->whereRaw('id = (SELECT id FROM stress_assessments WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1)');
        })->count();

        $users = User::withCount('assessments')
                    ->with(['assessments' => function($query) {
                        $query->latest()->limit(1);
                    }])
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        
        // Add latest_assessment to each user
        $users->getCollection()->transform(function($user) {
            $user->latest_assessment = $user->assessments->first();
            return $user;
        });
        
        return view('admin.users', compact('users', 'totalUsers', 'activeUsers', 'highRiskUsers'));
    }

    /**
     * update user data
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:users,nim,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'jurusan' => 'required|string|max:255',
            'semester' => 'required|integer|min:1|max:8',
        ];

        // Add password validation if provided
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6';
        }

        $validated = $request->validate($rules);

        // Update user data
        $user->name = $validated['name'];
        $user->nim = $validated['nim'];
        $user->email = $validated['email'];
        $user->jurusan = $validated['jurusan'];
        $user->semester = $validated['semester'];

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * hapus user 
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return back()->with('success', 'User berhasil dihapus.');
        }

        return back()->with('error', 'User tidak ditemukan.');
    }

    /**
     * Export Users to PDF
     */
    public function exportUsersPdf(Request $request)
    {
        // Get all students with their latest assessment
        $users = User::with(['assessments' => function($query) {
                        $query->latest()->limit(1);
                    }])
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        // Add latest_assessment and calculate stats
        $stats = [
            'total' => $users->count(),
            'low' => 0,
            'medium' => 0,
            'high' => 0
        ];

        foreach ($users as $user) {
            $user->latest_assessment = $user->assessments->first();
            
            if ($user->latest_assessment) {
                $score = $user->latest_assessment->numeric_score;
                if ($score === 0) $stats['low']++;
                elseif ($score === 1) $stats['medium']++;
                elseif ($score === 2) $stats['high']++;
            }
        }

        // Return preview view if requested
        if ($request->has('preview')) {
            return view('admin.reports.users-pdf', compact('users', 'stats'));
        }

        // Generate PDF
        $pdf = \PDF::loadView('admin.reports.users-pdf', compact('users', 'stats'));
        
        // Set paper to landscape for clearer table
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Data-Mahasiswa-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * tampilkan statistik dan laporan dengan analitik AI
     */
    public function viewAssessments(Request $request)
    {
        // 1. Process Filters
        $semesterFilter = $request->get('semester');
        $jurusanFilter = $request->get('jurusan');
        $dateRangeFilter = $request->get('date_range');
        
        $assessmentQuery = StressAssessment::query();
        $userQuery = User::query();
        
        if ($semesterFilter) {
            $userQuery->where('semester', $semesterFilter);
            $assessmentQuery->whereHas('user', function($q) use ($semesterFilter) {
                $q->where('semester', $semesterFilter);
            });
        }
        
        if ($jurusanFilter) {
            $userQuery->where('jurusan', $jurusanFilter);
            $assessmentQuery->whereHas('user', function($q) use ($jurusanFilter) {
                $q->where('jurusan', $jurusanFilter);
            });
        }
        
        if ($dateRangeFilter) {
            $dates = explode(' - ', $dateRangeFilter);
            if (count($dates) == 2) {
                $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $dates[0])->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $dates[1])->endOfDay();
                $assessmentQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        // Stats Cards
        $avgScore = (clone $assessmentQuery)->avg('numeric_score') ?? 0;
        $avgStressPercentage = round(($avgScore / 2) * 100); // 0-2 scale to percentage
        
        $monthlyAssessments = (clone $assessmentQuery)->whereYear('created_at', now()->year)
                                            ->whereMonth('created_at', now()->month)
                                            ->count();
        
        
        $activeStudents = (clone $userQuery)->has('assessments')->count();
        
        // Count unique students whose LATEST assessment is Distress
        $highStressCount = (clone $userQuery)->whereHas('assessments', function($query) {
            $query->where('numeric_score', 2)
                  ->whereRaw('id = (SELECT id FROM stress_assessments WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1)');
        })->count();
        
        // Fetch top 5 high-risk students for the new card
        $highRiskUsersList = (clone $userQuery)->whereHas('assessments', function($query) {
            $query->where('numeric_score', 2)
                  ->whereRaw('id = (SELECT id FROM stress_assessments WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1)');
        })->with(['assessments' => function($query) {
            $query->latest()->limit(1);
        }])->take(5)->get();
        
        // Monthly Distribution (last 6 months) - Stacked data
        $monthlyDistribution = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $assessments = StressAssessment::whereYear('created_at', $month->year)
                                         ->whereMonth('created_at', $month->month)
                                         ->get();
            
            $monthlyDistribution[] = [
                'month' => $month->format('M'),
                'no_stress' => $assessments->where('numeric_score', '=', 0)->count(),
                'eustress' => $assessments->where('numeric_score', '=', 1)->count(),
                'distress' => $assessments->where('numeric_score', '=', 2)->count(),
            ];
        }
        
        // Semester Data (average stress per semester)
        $semesterData = [];
        for ($i = 1; $i <= 8; $i++) {
            $avg = StressAssessment::whereHas('user', function($query) use ($i) {
                $query->where('semester', $i);
            })->avg('numeric_score');
            
            $semesterData[] = round(($avg ?? 0) * 50); // Convert 0-2 scale to 0-100 scale
        }
        
        
        // Stress Factors - Calculate from actual assessment data
        $allAssessments = StressAssessment::all();
        
        // Group factors by category
        $akademik = 0; // professor_difficulty, conf_academic, conf_subject, attendance
        $fisikKesehatan = 0; // sleep_problems, headache, illness, weight_change
        $emosional = 0; // anxiety, anxiety_2, sadness, overwhelmed, irritated
        $sosial = 0; // relationship_stress, lonely, competition
        $lingkungan = 0; // work_env, home_env, relaxation_time, activity_conflict
        
        foreach ($allAssessments as $assessment) {
            // Akademik
            $akademik += ($assessment->professor_difficulty ?? 0) + ($assessment->conf_academic ?? 0) + 
                        ($assessment->conf_subject ?? 0) + ($assessment->attendance ?? 0);
            // Fisik & Kesehatan
            $fisikKesehatan += ($assessment->sleep_problems ?? 0) + ($assessment->headache ?? 0) + 
                              ($assessment->illness ?? 0) + ($assessment->weight_change ?? 0);
            // Emosional
            $emosional += ($assessment->anxiety ?? 0) + ($assessment->anxiety_2 ?? 0) + 
                         ($assessment->sadness ?? 0) + ($assessment->overwhelmed ?? 0) + 
                         ($assessment->irritated ?? 0);
            // Sosial
            $sosial += ($assessment->relationship_stress ?? 0) + ($assessment->lonely ?? 0) + 
                      ($assessment->competition ?? 0);
            // Lingkungan
            $lingkungan += ($assessment->work_env ?? 0) + ($assessment->home_env ?? 0) + 
                          ($assessment->relaxation_time ?? 0) + ($assessment->activity_conflict ?? 0);
        }
        
        $total = $akademik + $fisikKesehatan + $emosional + $sosial + $lingkungan;
        
        $factorData = [0, 0, 0, 0, 0];
        $isEn = app()->getLocale() === 'en';
        $factorNames = $isEn
            ? ['Academic', 'Physical & Health', 'Emotional', 'Social', 'Environment']
            : ['Akademik', 'Fisik & Kesehatan', 'Emosional', 'Sosial', 'Lingkungan'];
        $dominantFactorIndex = 0;
        
        if ($total > 0) {
            $factorData = [
                round(($akademik / $total) * 100),
                round(($fisikKesehatan / $total) * 100),
                round(($emosional / $total) * 100),
                round(($sosial / $total) * 100),
                round(($lingkungan / $total) * 100)
            ];
            // Find dominant factor
            $dominantFactorIndex = array_keys($factorData, max($factorData))[0];
        }
        
        // Jurusan Statistics (Refactored to avoid GROUP BY SQL error)
        $usersRaw = User::select('id', 'jurusan')
            ->withAvg('assessments as avg_stress_raw', 'numeric_score')
            ->get();

        $jurusanStats = $usersRaw->groupBy('jurusan')
            ->map(function ($group, $jurusan) {
                // Filter users who have at least one assessment (avg_stress_raw is not null)
                $activeUsers = $group->whereNotNull('avg_stress_raw');
                $count = $activeUsers->count();

                if ($count === 0) return null;

                // Calculate average of the students' averages
                $avgStress = $activeUsers->avg('avg_stress_raw');

                return [
                    'jurusan' => $jurusan ?? 'Tidak Diketahui',
                    'count' => $count,
                    'avg_stress' => round($avgStress * 50)
                ];
            })
            ->filter() // Remove nulls (jurusans with 0 active students)
            ->values(); // Reset keys

        // Generate AI Insight
        $aiInsight = "";
        $recommendations = [];
        
        if ($highStressCount > 10) {
            $aiInsight = "Sistem mendeteksi tingkat stres (Distress) yang tinggi secara keseluruhan. Faktor dominan penyebab stres adalah tekanan <b>{$factorNames[$dominantFactorIndex]}</b>. Intervensi segera sangat direkomendasikan.";
            $recommendations = [
                "Segera hubungi mahasiswa yang berada di kategori Risiko Tinggi untuk menawarkan konseling.",
                "Adakan survei khusus terkait beban {$factorNames[$dominantFactorIndex]} untuk mengidentifikasi akar masalah.",
                "Promosikan layanan dukungan psikologis di seluruh media kampus.",
            ];
        } elseif ($highStressCount > 0) {
            $aiInsight = "Sebagian kecil mahasiswa berada dalam kategori Distress. Meskipun stres rata-rata terkendali, ada indikasi tekanan dari faktor <b>{$factorNames[$dominantFactorIndex]}</b>.";
            $recommendations = [
                "Fokuskan perhatian pada " . $highStressCount . " mahasiswa di kategori Risiko Tinggi.",
                "Tingkatkan akses fitur relaksasi pada platform.",
                "Pertimbangkan program bimbingan akademik ringan.",
            ];
        } else {
            $aiInsight = "Kondisi kesehatan mental mahasiswa terpantau sangat stabil dan cenderung positif. Belum ada deteksi peningkatan tingkat stres (Distress).";
            $recommendations = [
                "Pertahankan program kesehatan mental yang sudah berjalan.",
                "Dorong mahasiswa untuk terus melakukan assessment rutin mingguan.",
                "Bagikan tip menjaga keseimbangan work-life balance."
            ];
        }

        // Generate Key Findings (bilingual)
        $keyFindings = [];
        $maxSemesterIndex = array_keys($semesterData, max($semesterData ?: [0]))[0] ?? 0;
        $keyFindings[] = $isEn
            ? "Semester " . ($maxSemesterIndex + 1) . " shows the highest average stress level (" . ($semesterData[$maxSemesterIndex] ?? 0) . "%)."
            : "Semester " . ($maxSemesterIndex + 1) . " menunjukkan rata-rata tingkat stres tertinggi (" . ($semesterData[$maxSemesterIndex] ?? 0) . "%).";
        
        if ($total > 0) {
            $keyFindings[] = $isEn
                ? "The <b>{$factorNames[$dominantFactorIndex]}</b> factor is the most dominant complaint (" . max($factorData) . "%)."
                : "Faktor <b>{$factorNames[$dominantFactorIndex]}</b> menjadi keluhan paling dominan (" . max($factorData) . "%).";
        }
        
        if(count($monthlyDistribution) > 0) {
             $latestMonth = end($monthlyDistribution);
             $keyFindings[] = $isEn
                 ? "Month " . $latestMonth['month'] . " recorded " . $latestMonth['distress'] . " Distress cases."
                 : "Bulan " . $latestMonth['month'] . " mencatatkan " . $latestMonth['distress'] . " kasus Distress.";
        }



        // Get Jurusans for Filter Dropdown
        $jurusans = User::whereNotNull('jurusan')->distinct('jurusan')->pluck('jurusan');

        return view('admin.assessments', compact(
            'avgStressPercentage',
            'monthlyAssessments',
            'activeStudents',
            'highStressCount',
            'highRiskUsersList',
            'monthlyDistribution',
            'semesterData',
            'factorData',
            'jurusanStats',
            'aiInsight',
            'recommendations',
            'keyFindings',
            'jurusans'
        ));
    }

    /**
     * Export PDF laporan statistik
     */
    public function exportPdf()
    {
        // Get same data as viewAssessments
        $avgScore = StressAssessment::avg('numeric_score') ?? 0;
        $avgStressPercentage = round(($avgScore / 2) * 100);
        
        $monthlyAssessments = StressAssessment::whereYear('created_at', now()->year)
                                            ->whereMonth('created_at', now()->month)
                                            ->count();
        
        $activeStudents = User::has('assessments')->count();
        
        // Count unique students whose LATEST assessment is Distress
        $highStressCount = User::whereHas('assessments', function($query) {
            $query->where('numeric_score', 2)
                  ->whereRaw('id = (SELECT id FROM stress_assessments WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1)');
        })->count();
        
        $semesterData = [];
        for ($i = 1; $i <= 8; $i++) {
            $avg = StressAssessment::whereHas('user', function($query) use ($i) {
                $query->where('semester', $i);
            })->avg('numeric_score');
            
            $semesterData[] = round(($avg ?? 0) * 50);
        }
        
        // Stress Factors - Calculate from actual assessment data (same as viewAssessments)
        $allAssessments = StressAssessment::all();
        
        $akademik = 0;
        $fisikKesehatan = 0;
        $emosional = 0;
        $sosial = 0;
        $lingkungan = 0;
        
        foreach ($allAssessments as $assessment) {
            $akademik += ($assessment->professor_difficulty ?? 0) + ($assessment->conf_academic ?? 0) + 
                        ($assessment->conf_subject ?? 0) + ($assessment->attendance ?? 0);
            $fisikKesehatan += ($assessment->sleep_problems ?? 0) + ($assessment->headache ?? 0) + 
                              ($assessment->illness ?? 0) + ($assessment->weight_change ?? 0);
            $emosional += ($assessment->anxiety ?? 0) + ($assessment->anxiety_2 ?? 0) + 
                         ($assessment->sadness ?? 0) + ($assessment->overwhelmed ?? 0) + 
                         ($assessment->irritated ?? 0);
            $sosial += ($assessment->relationship_stress ?? 0) + ($assessment->lonely ?? 0) + 
                      ($assessment->competition ?? 0);
            $lingkungan += ($assessment->work_env ?? 0) + ($assessment->home_env ?? 0) + 
                          ($assessment->relaxation_time ?? 0) + ($assessment->activity_conflict ?? 0);
        }
        
        $total = $akademik + $fisikKesehatan + $emosional + $sosial + $lingkungan;
        
        if ($total > 0) {
            $factorData = [
                round(($akademik / $total) * 100),
                round(($fisikKesehatan / $total) * 100),
                round(($emosional / $total) * 100),
                round(($sosial / $total) * 100),
                round(($lingkungan / $total) * 100)
            ];
        } else {
            $factorData = [0, 0, 0, 0, 0];
        }
        
        // Jurusan Statistics (Refactored)
        $usersRaw = User::select('id', 'jurusan')
            ->withAvg('assessments as avg_stress_raw', 'numeric_score')
            ->get();

        $jurusanStats = $usersRaw->groupBy('jurusan')
            ->map(function ($group, $jurusan) {
                $activeUsers = $group->whereNotNull('avg_stress_raw');
                $count = $activeUsers->count();

                if ($count === 0) return null;

                $avgStress = $activeUsers->avg('avg_stress_raw');

                return [
                    'jurusan' => $jurusan ?? 'Tidak Diketahui',
                    'count' => $count,
                    'avg_stress' => round($avgStress * 50)
                ];
            })
            ->filter()
            ->values();

        $pdf = \PDF::loadView('admin.reports.statistics-pdf', compact(
            'avgStressPercentage',
            'monthlyAssessments',
            'activeStudents',
            'highStressCount',
            'semesterData',
            'factorData',
            'jurusanStats'
        ));

        return $pdf->download('Laporan-Statistik-Stress-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export Excel laporan statistik
     */
    public function exportExcel()
    {
        return \Excel::download(new \App\Exports\StatisticsExport, 'Laporan-Statistik-Stress-' . now()->format('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * tampilkan daftar admin
     */
    public function viewAdmins()
    {
        $admins = Admin::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.admins', compact('admins'));
    }

    // tambah admin
    public function create()
    {
        return view('admin.create-admin');
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email',
        'password' => 'required|min:6',
    ]);

    \App\Models\Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    return redirect()->route('admin.admins')->with('success', 'Admin baru berhasil ditambahkan.');
}


    // settings page
    public function settings()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        $admin = Auth::guard('admin')->user();
        $systemSettings = \App\Models\SystemSetting::all()->pluck('value', 'key');
        return view('admin.settings', compact('admin', 'systemSettings'));
    }

    // update admin profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        $admin = Auth::guard('admin')->user();
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // update system settings
    public function updateSettings(Request $request)
    {
        // Update Admin Settings (Notifications)
        $admin = Auth::guard('admin')->user();
        $adminSettings = $admin->settings ?? [];
        
        $adminSettings['notif_email'] = $request->has('notif_email');
        $adminSettings['notif_reminder'] = $request->has('notif_reminder');
        $adminSettings['notif_report'] = $request->has('notif_report');
        
        $admin->settings = $adminSettings;
        $admin->save();

        // Update System Settings (Global)
        $systemSettings = [
            'min_password_length' => $request->min_password_length,
            'session_timeout' => $request->session_timeout,
            'max_login_attempts' => $request->max_login_attempts,
            'auto_backup' => $request->has('auto_backup') ? '1' : '0',
            'maintenance_mode' => $request->has('maintenance_mode') ? '1' : '0',
        ];

        foreach ($systemSettings as $key => $value) {
            \App\Models\SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Handle Laravel Maintenance Mode
        // We now handle this via Middleware (CheckMaintenanceMode)
        // so we don't need Artisan::call('down') anymore.
        // The 'maintenance_mode' setting in DB is enough trigger.
        
        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    // backup database
    public function backupDatabase()
    {
        $filename = "backup-" . now()->format('Y-m-d-H-i-s') . ".sql";
        $path = storage_path("app/backups/" . $filename);

        // Ensure directory exists
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        // Get DB credentials
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');

        // Try to find mysqldump in common locations
        $mysqldumpPaths = [
            'mysqldump', // Try system PATH first
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe', // Laragon MySQL 8.0.30
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-5.7.24\\bin\\mysqldump.exe',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
        ];

        $mysqldump = null;
        foreach ($mysqldumpPaths as $testPath) {
            if ($testPath === 'mysqldump' || file_exists($testPath)) {
                $mysqldump = $testPath;
                break;
            }
        }

        if (!$mysqldump) {
            return back()->withErrors(['msg' => 'Gagal menemukan mysqldump. Silakan install MySQL atau gunakan export manual.']);
        }

        // Build command with proper escaping
        $command = sprintf(
            '"%s" --user=%s --password=%s --host=%s %s > "%s"',
            $mysqldump,
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbHost),
            escapeshellarg($dbName),
            $path
        );
        
        // Execute command
        exec($command . ' 2>&1', $output, $returnVar);

        if ($returnVar !== 0 || !file_exists($path) || filesize($path) === 0) {
            // Log error for debugging
            \Log::error('Backup failed', [
                'command' => $command,
                'output' => $output,
                'return_var' => $returnVar
            ]);
            
            return back()->withErrors(['msg' => 'Gagal membuat backup database. Error: ' . implode(', ', $output)]);
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }

    // logout admin
    public function logout(Request $request)
    {
        // Logout dari admin guard
        Auth::guard('admin')->logout();
        
        // Invalidate session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        // Clear any manual session data
        $request->session()->forget(['admin_id', 'admin_name']);
        
        return redirect('/admin/login')->with('success', 'Berhasil logout.');
    }

    // ===============================
    // ANALYTICS & DATA ITERATION
    // ===============================

    /**
     * Display analytics dashboard
     */
    public function analytics()
    {
        $analyticsService = new \App\Services\AnalyticsService();

        $overview = $analyticsService->getOverviewStats();
        $engagement = $analyticsService->getUserEngagementMetrics();
        $completion = $analyticsService->getAssessmentCompletionRates();
        $popularTips = $analyticsService->getPopularTips(10);
        $userGrowth = $analyticsService->getUserGrowthData();
        $assessmentTrends = $analyticsService->getAssessmentTrendsData();
        $stressDistribution = $analyticsService->getStressLevelDistribution();

        return view('admin.analytics', compact(
            'overview',
            'engagement',
            'completion',
            'popularTips',
            'userGrowth',
            'assessmentTrends',
            'stressDistribution'
        ));
    }

    /**
     * Export analytics to PDF
     */
    public function exportAnalyticsPdf(Request $request)
    {
        $analyticsService = new \App\Services\AnalyticsService();
        
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $data = $analyticsService->getExportData($startDate, $endDate);

        $pdf = \PDF::loadView('admin.reports.analytics-pdf', $data);

        return $pdf->download('Analytics-Report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export analytics to Excel
     */
    public function exportAnalyticsExcel(Request $request)
    {
        $analyticsService = new \App\Services\AnalyticsService();
        
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $data = $analyticsService->getExportData($startDate, $endDate);

        return \Excel::download(
            new \App\Exports\AnalyticsExport($data), 
            'Analytics-Report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
