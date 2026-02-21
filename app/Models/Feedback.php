<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'user_id',
        'type',
        'rating',
        'subject',
        'message',
        'page_url',
        'status',
        'admin_notes',
    ];

    /**
     * Get the user who submitted the feedback
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
