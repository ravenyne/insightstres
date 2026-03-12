<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BreathingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $latestAssessment = null;
        $recommendedTechnique = null;

        if ($user) {
            $latestAssessment = \App\Models\StressAssessment::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($latestAssessment) {
                if ($latestAssessment->stress_category === 'Distress') {
                    $recommendedTechnique = '4-7-8';
                } elseif ($latestAssessment->stress_category === 'Eustress') {
                    $recommendedTechnique = 'box';
                } else {
                    $recommendedTechnique = 'deep';
                }
            }
        }

        return view('user.breathing', compact('latestAssessment', 'recommendedTechnique'));
    }
}
