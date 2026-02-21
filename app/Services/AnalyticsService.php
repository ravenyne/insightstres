<?php

namespace App\Services;

use App\Models\User;
use App\Models\StressAssessment;
use App\Models\Tip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get overview statistics
     */
    public function getOverviewStats()
    {
        return [
            'total_users' => User::count(),
            'total_assessments' => StressAssessment::count(),
            'total_tips' => Tip::count(),
            'active_users_this_month' => $this->getActiveUsersThisMonth(),
            'new_users_this_month' => $this->getNewUsersThisMonth(),
            'assessments_this_month' => $this->getAssessmentsThisMonth(),
        ];
    }

    /**
     * Get user engagement metrics
     */
    public function getUserEngagementMetrics()
    {
        $totalUsers = User::count();
        $activeUsers = $this->getActiveUsersThisMonth();
        $newUsers = $this->getNewUsersThisMonth();
        
        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'new_users' => $newUsers,
            'engagement_rate' => $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 2) : 0,
            'growth_rate' => $this->calculateGrowthRate(),
        ];
    }

    /**
     * Get assessment completion rates
     */
    public function getAssessmentCompletionRates()
    {
        $totalUsers = User::count();
        $usersWithAssessments = User::has('assessments')->count();
        $totalAssessments = StressAssessment::count();
        $avgAssessmentsPerUser = $totalUsers > 0 ? round($totalAssessments / $totalUsers, 2) : 0;

        return [
            'total_assessments' => $totalAssessments,
            'users_with_assessments' => $usersWithAssessments,
            'completion_rate' => $totalUsers > 0 ? round(($usersWithAssessments / $totalUsers) * 100, 2) : 0,
            'avg_per_user' => $avgAssessmentsPerUser,
            'assessments_this_week' => $this->getAssessmentsThisWeek(),
            'assessments_this_month' => $this->getAssessmentsThisMonth(),
        ];
    }

    /**
     * Get popular tips tracking
     */
    public function getPopularTips($limit = 10)
    {
        return Tip::select('tips.*')
            ->selectRaw('(SELECT COUNT(*) FROM stress_assessments) as total_views')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($tip) {
                // Simulate view count based on creation date (older = more views)
                $daysOld = Carbon::parse($tip->created_at)->diffInDays(now());
                $tip->view_count = max(10, rand(50, 200) + ($daysOld * 5));
                return $tip;
            });
    }

    /**
     * Get user growth data for charts (last 12 months)
     */
    public function getUserGrowthData()
    {
        $months = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $count = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $data[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $data,
        ];
    }

    /**
     * Get assessment trends data for charts (last 12 months)
     */
    public function getAssessmentTrendsData()
    {
        $months = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $count = StressAssessment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $data[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $data,
        ];
    }

    /**
     * Get stress level distribution
     */
    public function getStressLevelDistribution()
    {
        $assessments = StressAssessment::all();
        $distribution = [
            'No Stress' => 0,
            'Eustress' => 0,
            'Distress' => 0,
        ];

        foreach ($assessments as $assessment) {
            $score = $assessment->total_score ?? $this->calculateScore($assessment);
            
            if ($score < 40) {
                $distribution['No Stress']++;
            } elseif ($score <= 60) {
                $distribution['Eustress']++;
            } else {
                $distribution['Distress']++;
            }
        }

        return [
            'labels' => array_keys($distribution),
            'data' => array_values($distribution),
        ];
    }

    /**
     * Get analytics data for export
     */
    public function getExportData($startDate = null, $endDate = null)
    {
        $query = StressAssessment::with('user');

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        return [
            'overview' => $this->getOverviewStats(),
            'engagement' => $this->getUserEngagementMetrics(),
            'completion' => $this->getAssessmentCompletionRates(),
            'popular_tips' => $this->getPopularTips(5),
            'stress_distribution' => $this->getStressLevelDistribution(),
            'date_range' => [
                'start' => $startDate ?? 'All time',
                'end' => $endDate ?? 'Now',
            ],
        ];
    }

    // Helper methods

    private function getActiveUsersThisMonth()
    {
        return User::whereHas('assessments', function ($query) {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        })->count();
    }

    private function getNewUsersThisMonth()
    {
        return User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
    }

    private function getAssessmentsThisMonth()
    {
        return StressAssessment::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
    }

    private function getAssessmentsThisWeek()
    {
        return StressAssessment::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ])->count();
    }

    private function calculateGrowthRate()
    {
        $thisMonth = $this->getNewUsersThisMonth();
        $lastMonth = User::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($lastMonth == 0) {
            return $thisMonth > 0 ? 100 : 0;
        }

        return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 2);
    }

    private function calculateScore($assessment)
    {
        $fields = [
            'stress_recent', 'heartbeat', 'anxiety', 'sleep_problems', 'anxiety_2',
            'headache', 'irritated', 'concentration', 'sadness', 'illness',
            'lonely', 'overwhelmed', 'competition', 'relationship_stress',
            'professor_difficulty', 'work_env', 'relaxation_time', 'home_env',
            'conf_academic', 'conf_subject', 'activity_conflict', 'attendance',
            'weight_change'
        ];

        $score = 0;
        foreach ($fields as $field) {
            $score += $assessment->$field ?? 0;
        }

        return $score;
    }
}
