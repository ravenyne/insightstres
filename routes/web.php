<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssessmentExportController;
use App\Http\Controllers\LanguageController;

Route::get('/', function () {
    return view('index');
});

// LANGUAGE SWITCHER
Route::get('/lang/{locale}', [LanguageController::class , 'switch'])->name('lang.switch');

// AUTH
Route::get('/register', [AuthController::class , 'showRegister'])->name('register');
Route::post('/register', [AuthController::class , 'register'])->name('register.submit');

Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login'])->name('login.submit');
Route::post('/email/resend', [AuthController::class , 'resendVerification'])
    ->middleware(['throttle:6,1'])
    ->name('verification.resend.public');

// EMAIL VERIFIKASI
Route::get('/verify/{token}', [AuthController::class , 'verifyEmail'])->name('verify.email');

// LUPA PASSWORD
Route::get('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class , 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class , 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\ForgotPasswordController::class , 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\ForgotPasswordController::class , 'reset'])->name('password.update');

// EMAIL VERIFICATION (Custom - No Auth Required)
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    // Verify the hash matches
    if (!hash_equals((string)$hash, sha1($user->getEmailForVerification()))) {
        return redirect('/login')->with('error', 'Link verifikasi tidak valid.');
    }

    // Check if already verified
    if ($user->hasVerifiedEmail()) {
        // Ensure status is active even if verified timestamp exists
        if ($user->status !== 'aktif') {
            $user->status = 'aktif';
            $user->save();
        }
        return redirect('/login')->with('success', 'Email sudah diverifikasi sebelumnya. Silakan login.');
    }

    // Mark as verified AND update status
    if ($user->markEmailAsVerified()) {
        $user->status = 'aktif'; // Explicitly set status to active
        $user->save();
        event(new \Illuminate\Auth\Events\Verified($user));
    }

    return redirect('/login')->with('success', 'Email berhasil diverifikasi! Silakan login untuk melanjutkan.');
})->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// USER LOGIN REQUIRED
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AuthController::class , 'dashboard'])->name('dashboard');

    Route::get('/assessment', [AssessmentController::class , 'form'])->name('user.assessment');
    Route::post('/assessment', [AssessmentController::class , 'predict'])->name('assessment.store');

    Route::get('/history', [AssessmentController::class , 'history'])->name('user.history');
    Route::get('/assessment/{id}/details', [AssessmentController::class , 'getAssessmentDetails'])->name('user.assessment.details');
    Route::get('/analysis/{id?}', [AssessmentController::class , 'analysis'])->name('user.analysis');

    Route::get('/profile', [ProfileController::class , 'show'])->name('user.profile');
    Route::put('/profile/update', [ProfileController::class , 'update'])->name('user.profile.update');
    Route::put('/profile/password', [ProfileController::class , 'updatePassword'])->name('user.profile.password');
    Route::put('/profile/email-preferences', [ProfileController::class , 'updateEmailPreferences'])->name('user.profile.email-preferences');


    Route::get('/notifications', [App\Http\Controllers\NotificationController::class , 'index'])->name('user.notifications');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class , 'getUnreadCount'])->name('user.notifications.unread-count');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class , 'markAsRead'])->name('user.notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class , 'markAllAsRead'])->name('user.notifications.read-all');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class , 'delete'])->name('user.notifications.delete');
    Route::delete('/notifications/delete-all', [App\Http\Controllers\NotificationController::class , 'deleteAll'])->name('user.notifications.delete-all');

    // Tips & Articles
    Route::get('/tips', [App\Http\Controllers\TipController::class , 'index'])->name('user.tips');
    Route::get('/tips/{id}', [App\Http\Controllers\TipController::class , 'show'])->name('user.tips.show');

    // Breathing Exercise
    Route::get('/breathing', [App\Http\Controllers\BreathingController::class , 'index'])->name('user.breathing');

    // Feedback
    Route::post('/feedback', [App\Http\Controllers\FeedbackController::class , 'store'])->name('feedback.store');


    Route::get('/export/pdf', [AssessmentExportController::class , 'exportPdf'])->name('user.export.pdf');
    Route::get('/export/analysis-pdf', [AssessmentExportController::class , 'exportAnalysisPdf'])->name('user.export.analysis.pdf');
    Route::get('/export/csv', [AssessmentController::class , 'exportCsv'])->name('user.export.csv');

    Route::post('/logout', [AuthController::class , 'logout'])->name('logout');
});

// Password Reset Routes (outside auth middleware)
Route::get('/forgot-password', [AuthController::class , 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class , 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class , 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class , 'resetPassword'])->name('password.update');

// ADMIN
Route::prefix('admin')->group(function () {
    // Login routes (no middleware)
    Route::get('/login', [AdminController::class , 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class , 'login'])->name('admin.login.post');

    // Protected admin routes (with middleware)
    Route::middleware('admin')->group(function () {
            Route::get('/dashboard', [AdminController::class , 'dashboard'])->name('admin.dashboard');

            // Users Management
            Route::get('/users', [AdminController::class , 'viewUsers'])->name('admin.users');
            Route::put('/users/{id}', [AdminController::class , 'updateUser'])->name('admin.users.update');
            Route::delete('/users/{id}', [AdminController::class , 'deleteUser'])->name('admin.users.delete');
            Route::get('/users/export/pdf', [AdminController::class , 'exportUsersPdf'])->name('admin.users.export.pdf');

            // Assessments
            Route::get('/assessments', [AdminController::class , 'viewAssessments'])->name('admin.assessments');
            Route::get('/assessments/export/pdf', [AdminController::class , 'exportPdf'])->name('admin.assessments.export.pdf');
            Route::get('/assessments/export/excel', [AdminController::class , 'exportExcel'])->name('admin.assessments.export.excel');

            // Admins Management
            Route::get('/admins', [AdminController::class , 'viewAdmins'])->name('admin.admins');
            Route::get('/admins/create', [AdminController::class , 'create'])->name('admin.admins.create');
            Route::post('/admins', [AdminController::class , 'store'])->name('admin.admins.store');

            // Settings
            Route::get('/settings', [AdminController::class , 'settings'])->name('admin.settings');
            Route::put('/settings/profile', [AdminController::class , 'updateProfile'])->name('admin.settings.profile');
            Route::put('/settings/system', [AdminController::class , 'updateSettings'])->name('admin.settings.system');
            Route::post('/settings/backup', [AdminController::class , 'backupDatabase'])->name('admin.settings.backup');

            // Tips & Articles Management
            Route::get('/tips', [AdminController::class , 'viewTips'])->name('admin.tips');
            Route::get('/tips/create', [AdminController::class , 'createTip'])->name('admin.tips.create');
            Route::post('/tips', [AdminController::class , 'storeTip'])->name('admin.tips.store');
            Route::get('/tips/{id}/edit', [AdminController::class , 'editTip'])->name('admin.tips.edit');
            Route::put('/tips/{id}', [AdminController::class , 'updateTip'])->name('admin.tips.update');
            Route::delete('/tips/{id}', [AdminController::class , 'deleteTip'])->name('admin.tips.delete');

            // Feedback Management
            Route::get('/feedback', [App\Http\Controllers\FeedbackController::class , 'index'])->name('admin.feedback');
            Route::get('/feedback/{id}', [App\Http\Controllers\FeedbackController::class , 'show'])->name('admin.feedback.show');
            Route::put('/feedback/{id}', [App\Http\Controllers\FeedbackController::class , 'update'])->name('admin.feedback.update');
            Route::delete('/feedback/{id}', [App\Http\Controllers\FeedbackController::class , 'destroy'])->name('admin.feedback.destroy');

            // Analytics & Data Iteration - Redirect to Dashboard (similar content)
            Route::get('/analytics', function () {
                    return redirect()->route('admin.dashboard');
                }
                )->name('admin.analytics');
                Route::get('/analytics/export/pdf', [AdminController::class , 'exportAnalyticsPdf'])->name('admin.analytics.export.pdf');
                Route::get('/analytics/export/excel', [AdminController::class , 'exportAnalyticsExcel'])->name('admin.analytics.export.excel');

                // Logout
                Route::post('/logout', [AdminController::class , 'logout'])->name('admin.logout');
            }
            );        });