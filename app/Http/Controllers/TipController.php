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
                $q->where('title_id', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('content_id', 'like', "%{$search}%")
                  ->orWhere('content_en', 'like', "%{$search}%");
            });
        }

        $tips = $query->latest()->paginate(12);

        // Fetch user's latest assessment and recommend tips
        $user = auth()->user();
        $recommendedTips = collect();
        $latestAssessment = null;

        if ($user) {
            $latestAssessment = \App\Models\StressAssessment::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($latestAssessment) {
                $recCategories = [];
                if ($latestAssessment->stress_category === 'Distress') {
                    $recCategories = ['breathing', 'mindfulness', 'general'];
                } elseif ($latestAssessment->stress_category === 'Eustress') {
                    $recCategories = ['study', 'exercise', 'general'];
                } else { // No Stress
                    $recCategories = ['sleep', 'mindfulness', 'general'];
                }

                $recommendedTips = Tip::whereIn('category', $recCategories)
                    ->inRandomOrder()
                    ->take(3)
                    ->get();
            }
        }

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

        return view('user.tips', compact('tips', 'categories', 'category', 'search', 'recommendedTips', 'latestAssessment'));
    }

    public function show($id)
    {
        $tip = Tip::findOrFail($id);
        $tip->incrementViews();

        // Return JSON for AJAX requests
        return response()->json([
            'id' => $tip->id,
            'title' => $tip->title, // Uses accessor
            'title_id' => $tip->title_id,
            'title_en' => $tip->title_en,
            'content' => $tip->content, // Uses accessor
            'content_id' => $tip->content_id,
            'content_en' => $tip->content_en,
            'category' => $tip->category,
            'icon' => $tip->icon,
            'views' => $tip->views,
        ]);
    }
}
