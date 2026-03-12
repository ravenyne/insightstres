<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    /**
     * Store user feedback
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string', // Validasi Frontend bisa dibatasi
            'rating' => 'nullable|integer|min:1|max:5',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'page_url' => 'nullable|string',
            'related_feature' => 'nullable|string',
        ]);

        // Ambil assessment terakhir dari user untuk kondisi stress
        $latestAssessment = \App\Models\StressAssessment::where('user_id', Auth::id())
                                ->orderBy('created_at', 'desc')
                                ->first();
        $stressCondition = $latestAssessment ? $latestAssessment->stress_category : null;

        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'rating' => $request->rating,
            'subject' => $request->subject,
            'message' => $request->message,
            'page_url' => $request->page_url ?? url()->previous(),
            'status' => 'new',
            'stress_condition' => $stressCondition,
            'related_feature' => $request->related_feature,
        ]);

        // Award feedback badge
        $badgeService = app(\App\Services\BadgeService::class);
        $badgeService->checkAndAwardBadges(Auth::user(), 'feedback_submitted');

        // Send email notification to admin if enabled
        try {
            $admin = \App\Models\Admin::first();
            if ($admin && !empty($admin->settings['notif_email']) && $admin->settings['notif_email'] === true) {
                Mail::to($admin->email)->send(new \App\Mail\AdminFeedbackNotification($feedback));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send feedback email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas feedback Anda! Kami akan meninjaunya segera.',
        ]);
    }

    /**
     * Get all feedback (Admin only)
     */
    public function index(Request $request)
    {
        $query = Feedback::with('user')->orderBy('created_at', 'desc');

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating !== 'all') {
            $query->where('rating', $request->rating);
        }

        $feedback = $query->paginate(20);

        // Get counts for filters
        $counts = [
            'all' => Feedback::count(),
            'new' => Feedback::where('status', 'new')->count(),
            'reviewed' => Feedback::where('status', 'reviewed')->count(),
            'resolved' => Feedback::where('status', 'resolved')->count(),
        ];

        return view('admin.feedback', compact('feedback', 'counts'));
    }

    /**
     * Show feedback details (Admin only)
     */
    public function show($id)
    {
        $feedback = Feedback::with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'feedback' => $feedback,
        ]);
    }

    /**
     * Update feedback status (Admin only)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,reviewed,resolved',
            'admin_notes' => 'nullable|string',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feedback updated successfully',
        ]);
    }

    /**
     * Delete feedback (Admin only)
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response()->json([
            'success' => true,
            'message' => 'Feedback berhasil dihapus',
        ]);
    }
}
