<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class BadgeService
{
    /**
     * Check and award badges based on user activity
     */
    public function checkAndAwardBadges(User $user, string $event, $data = null)
    {
        switch ($event) {
            case 'assessment_completed':
                $this->checkAssessmentBadges($user);
                break;
            case 'user_logged_in':
                $this->checkStreakBadges($user);
                break;
            case 'tip_viewed':
                $this->checkTipReadingBadges($user);
                break;
            case 'breathing_completed':
                $this->checkBreathingBadges($user);
                break;
            case 'feedback_submitted':
                $this->checkFeedbackBadge($user);
                break;
            case 'stress_improved':
                $this->checkImprovementBadges($user);
                break;
        }
    }

    /**
     * Check assessment-related badges
     */
    protected function checkAssessmentBadges(User $user)
    {
        $assessmentCount = $user->assessments()->count();

        $badgesToCheck = [
            1 => 'first-assessment',
            5 => 'five-assessments',
            10 => 'ten-assessments',
            20 => 'twenty-assessments',
        ];

        foreach ($badgesToCheck as $count => $slug) {
            if ($assessmentCount >= $count && !$user->hasBadge($slug)) {
                $badge = Badge::where('slug', $slug)->first();
                if ($badge) {
                    $this->awardBadge($user, $badge);
                }
            }
        }
    }

    /**
     * Check login streak badges
     */
    protected function checkStreakBadges(User $user)
    {
        $streak = $user->login_streak;

        $badgesToCheck = [
            7 => 'seven-day-streak',
            30 => 'thirty-day-streak',
            365 => 'year-streak',
        ];

        foreach ($badgesToCheck as $days => $slug) {
            if ($streak >= $days && !$user->hasBadge($slug)) {
                $badge = Badge::where('slug', $slug)->first();
                if ($badge) {
                    $this->awardBadge($user, $badge);
                }
            }
        }
    }

    /**
     * Check tip reading badges
     */
    protected function checkTipReadingBadges(User $user)
    {
        // Assuming you have a tips_viewed tracking mechanism
        // For now, we'll skip this or implement later
        // You could track this in a separate table or use a counter field
    }

    /**
     * Check breathing exercise badges
     */
    protected function checkBreathingBadges(User $user)
    {
        // Similar to tips, you'd need a tracking mechanism
        // Could be a breathing_sessions table or counter field
    }

    /**
     * Check feedback badge
     */
    protected function checkFeedbackBadge(User $user)
    {
        if (!$user->hasBadge('first-feedback')) {
            $badge = Badge::where('slug', 'first-feedback')->first();
            if ($badge) {
                $this->awardBadge($user, $badge);
            }
        }
    }

    /**
     * Check improvement badges
     */
    protected function checkImprovementBadges(User $user)
    {
        // TODO: Re-enable when total_score column is added to stress_assessments table
        // Currently disabled to prevent database errors
        
        // Get last 3 assessments
        // $recentAssessments = $user->assessments()
        //     ->orderBy('created_at', 'desc')
        //     ->take(3)
        //     ->get();

        // if ($recentAssessments->count() >= 3) {
        //     $scores = $recentAssessments->pluck('total_score')->toArray();
        //     
        //     // Check if stress is reducing (lower scores are better)
        //     if ($scores[0] < $scores[1] && $scores[1] < $scores[2]) {
        //         if (!$user->hasBadge('stress-reduction')) {
        //             $badge = Badge::where('slug', 'stress-reduction')->first();
        //             if ($badge) {
        //                 $this->awardBadge($user, $badge);
        //             }
        //         }
        //     }
        // }

        // // Check for low stress maintenance
        // $lowStressAssessments = $user->assessments()
        //     ->where('created_at', '>=', Carbon::now()->subDays(30))
        //     ->where('total_score', '<', 40) // Assuming < 40 is low stress
        //     ->count();

        // if ($lowStressAssessments >= 3 && !$user->hasBadge('low-stress-month')) {
        //     $badge = Badge::where('slug', 'low-stress-month')->first();
        //     if ($badge) {
        //         $this->awardBadge($user, $badge);
        //     }
        // }
    }

    /**
     * Award a badge to a user
     */
    public function awardBadge(User $user, Badge $badge)
    {
        // Check if user already has this badge
        if ($user->hasBadge($badge->slug)) {
            return false;
        }

        // Attach badge to user
        $user->badges()->attach($badge->id, [
            'earned_at' => now(),
        ]);

        // Create notification
        Notification::create([
            'user_id' => $user->id,
            'type' => 'badge_earned',
            'title' => 'Badge Earned!',
            'message' => "Congratulations! You've earned the '{$badge->name}' badge! {$badge->icon}",
            'data' => json_encode([
                'badge_id' => $badge->id,
                'badge_name' => $badge->name,
                'badge_icon' => $badge->icon,
                'points' => $badge->points,
            ]),
            'is_read' => false,
        ]);

        return true;
    }

    /**
     * Get all badges for a user
     */
    public function getUserBadges(User $user)
    {
        return $user->badges()->orderByPivot('earned_at', 'desc')->get();
    }

    /**
     * Get available badges (not yet earned)
     */
    public function getAvailableBadges(User $user)
    {
        $earnedBadgeIds = $user->badges()->pluck('badges.id')->toArray();
        return Badge::whereNotIn('id', $earnedBadgeIds)->get();
    }

    /**
     * Get badge progress for user
     */
    public function getBadgeProgress(User $user)
    {
        $totalBadges = Badge::count();
        $earnedBadges = $user->badges()->count();
        $totalPoints = $user->total_badge_points;

        return [
            'total_badges' => $totalBadges,
            'earned_badges' => $earnedBadges,
            'total_points' => $totalPoints,
            'progress_percentage' => $totalBadges > 0 ? round(($earnedBadges / $totalBadges) * 100) : 0,
        ];
    }

    /**
     * Update login streak for user
     */
    public function updateLoginStreak(User $user)
    {
        $today = Carbon::today();
        $lastLoginDate = $user->last_login_date ? Carbon::parse($user->last_login_date) : null;

        if (!$lastLoginDate) {
            // First login
            $user->login_streak = 1;
            $user->last_login_date = $today;
        } elseif ($lastLoginDate->isSameDay($today)) {
            // Already logged in today, no change
            return;
        } elseif ($lastLoginDate->isYesterday()) {
            // Consecutive day
            $user->login_streak += 1;
            $user->last_login_date = $today;
        } else {
            // Streak broken
            $user->login_streak = 1;
            $user->last_login_date = $today;
        }

        $user->save();

        // Check for streak badges
        $this->checkStreakBadges($user);
    }
}
