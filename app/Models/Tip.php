<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category',
        'icon',
        'views',
    ];

    protected $casts = [
        'views' => 'integer',
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
}
