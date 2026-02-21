<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        $search = $request->get('search');

        $query = Tip::query();

        // Filter by category
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $tips = $query->latest()->paginate(12);

        // Get category counts
        $categories = [
            'all' => Tip::count(),
            'breathing' => Tip::where('category', 'breathing')->count(),
            'sleep' => Tip::where('category', 'sleep')->count(),
            'exercise' => Tip::where('category', 'exercise')->count(),
            'mindfulness' => Tip::where('category', 'mindfulness')->count(),
            'study' => Tip::where('category', 'study')->count(),
            'general' => Tip::where('category', 'general')->count(),
        ];

        return view('user.tips', compact('tips', 'categories', 'category', 'search'));
    }

    public function show($id)
    {
        $tip = Tip::findOrFail($id);
        $tip->incrementViews();

        // Return JSON for AJAX requests
        return response()->json([
            'id' => $tip->id,
            'title' => $tip->title,
            'content' => $tip->content,
            'category' => $tip->category,
            'icon' => $tip->icon,
            'views' => $tip->views,
        ]);
    }
}
