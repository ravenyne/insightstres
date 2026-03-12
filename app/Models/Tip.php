<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_id',
        'title_en',
        'content_id',
        'content_en',
        'category',
        'icon',
        'views',
        'target_condition',
        'is_evidence_based',
        'read_duration',
        'is_ai_recommended',
    ];

    protected $casts = [
        'views' => 'integer',
        'is_evidence_based' => 'boolean',
        'is_ai_recommended' => 'boolean',
    ];

    // Category constants
    const CATEGORY_BREATHING = 'breathing';
    const CATEGORY_SLEEP = 'sleep';
    const CATEGORY_EXERCISE = 'exercise';
    const CATEGORY_MINDFULNESS = 'mindfulness';
    const CATEGORY_STUDY = 'study';
    const CATEGORY_GENERAL = 'general';

    // Scope for filtering by category
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Accessors for bilingual support
    public function getTitleAttribute()
    {
        return app()->getLocale() == 'en' ? $this->title_en : $this->title_id;
    }

    public function getContentAttribute()
    {
        return app()->getLocale() == 'en' ? $this->content_en : $this->content_id;
    }
}
