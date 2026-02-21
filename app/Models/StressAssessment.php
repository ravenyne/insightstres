<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StressAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        // 23 Jawaban Assessment
        'gender',
        'age',
        'stress_recent',
        'heartbeat',
        'anxiety',
        'sleep_problems',
        'anxiety_2',
        'headache',
        'irritated',
        'concentration',
        'sadness',
        'illness',
        'lonely',
        'overwhelmed',
        'competition',
        'relationship_stress',
        'professor_difficulty',
        'work_env',
        'relaxation_time',
        'home_env',
        'conf_academic',
        'conf_subject',
        'activity_conflict',
        'attendance',
        'weight_change',

        // Machine Learning Output
        'predicted_stress',
        'numeric_score',      // 0 = No Stress, 1 = Eustress, 2 = Distress
        'stress_category',    // 'No Stress' / 'Eustress' / 'Distress'
    ];

    /**
     * Get the user that owns the assessment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the total raw score of the assessment.
     */
    public function getTotalScoreAttribute()
    {
        $fields = [
            'stress_recent', 'heartbeat', 'anxiety', 'sleep_problems', 'anxiety_2',
            'headache', 'irritated', 'concentration', 'sadness', 'illness',
            'lonely', 'overwhelmed', 'competition', 'relationship_stress',
            'professor_difficulty', 'work_env', 'relaxation_time', 'home_env',
            'conf_academic', 'conf_subject', 'activity_conflict', 'attendance',
            'weight_change'
        ];

        $total = 0;
        foreach ($fields as $field) {
            $total += $this->$field;
        }

        return $total;
    }
}