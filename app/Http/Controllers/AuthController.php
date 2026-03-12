<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    // ===============================
    // SHOW REGISTER PAGE
    // ===============================
    public function showRegister()
    {
        // FILE ADA DI resources/views/register.blade.php
        return view('user.register');
    }

    // ===============================
    // PROSES REGISTER
    // ===============================
    public function register(Request $request)
    {
        $allowedJurusan = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Bisnis Digital',
            'Rekayasa Perangkat Lunak',
            'Manajemen Informatika',
        ];

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'nim' => 'required|numeric|unique:users,nim',
            'jurusan' => ['required', 'string', function ($attr, $value, $fail) use ($allowedJurusan) {
                if (!in_array($value, $allowedJurusan)) {
                    $fail("Jurusan tidak valid.");
                }
            }],
            'semester' => 'required|integer|min:1|max:8',
            'gender' => 'required|in:1,0',
            'age' => 'required|integer|min:15|max:100',
            'password' => 'required|min:6|confirmed', // KONFIRMASI WAJIB
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'semester' => $request->semester,
            'gender' => $request->gender,
            'age' => $request->age,
            'password' => Hash::make($request->password),
        ]);

        // Send Laravel's built-in email verification
        $user->sendEmailVerificationNotification();

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan cek email untuk verifikasi akun.');
    }

    // ===============================
    // VERIFIKASI EMAIL
    // ===============================
    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Token verifikasi tidak valid.');
        }

        $user->status = 'aktif';
        $user->verification_token = null;
        $user->save();

        return redirect('/login')->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    // ===============================
    // RESEND VERIFICATION EMAIL
    // ===============================
    public function resendVerification(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        if ($user->hasVerifiedEmail() && $user->status !== 'pending') {
            return redirect()->route('login')->with('success', 'Akun sudah aktif. Silakan login.');
        }

        // Send notification
        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Link verifikasi baru telah dikirim ke email Anda!');
    }

    // ===============================
    // LOGIN PAGE
    // ===============================
    public function showLogin()
    {
        return view('user.login');
    }

    // ===============================
    // PROSES LOGIN
    // ===============================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        if (!$user->hasVerifiedEmail() || $user->status === 'pending') {
            return back()
                ->with('error', 'Akun belum aktif atau belum diverifikasi.')
                ->with('need_verification', true)
                ->with('email_for_verification', $request->email);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Update login streak and check for streak badges
            $badgeService = app(\App\Services\BadgeService::class);
            $badgeService->updateLoginStreak(Auth::user());
            
            return redirect('/dashboard');
        }

        return back()->with('error', 'Password salah!');
    }

    // ===============================
    // DASHBOARD
    // ===============================
    public function dashboard()
{
    $user = auth()->user();

    // Ambil 3 assessment terbaru user
    $recent = \App\Models\StressAssessment::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

    // Ambil assessment terakhir
    $lastAssessment = $recent->first();
    
    // Convert label to category text
    $lastCategory = __('Not Available');
    if ($lastAssessment) {
        $label = $lastAssessment->numeric_score ?? $lastAssessment->predicted_stress;
        $lastCategory = match($label) {
            0 => 'No Stress',
            1 => 'Eustress',
            2 => 'Distress',
            default => 'Unknown'
        };
    }

    // Calculate trend (compare last 2 assessments)
    $trend = __('Not Available');
    if ($recent->count() >= 2) {
        $current = $recent[0]->numeric_score ?? $recent[0]->predicted_stress ?? 0;
        $previous = $recent[1]->numeric_score ?? $recent[1]->predicted_stress ?? 0;
        
        if ($current < $previous) {
            $trend = 'Membaik';
        } elseif ($current > $previous) {
            $trend = 'Meningkat';
        } else {
            $trend = 'Stabil';
        }
    }

    // Hitung statistik
    $stats = [
        'total' => \App\Models\StressAssessment::where('user_id', $user->id)->count(),
        'last_label' => $lastCategory,
        'this_month' => \App\Models\StressAssessment::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count(),
        'trend' => $trend,
    ];

    // Get last 30 days of assessments for trend chart
    $chartData = \App\Models\StressAssessment::where('user_id', $user->id)
        ->where('created_at', '>=', now()->subDays(30))
        ->orderBy('created_at', 'asc')
        ->get()
        ->map(function($assessment) {
            return [
                'date' => $assessment->created_at->format('Y-m-d'),
                'score' => $assessment->total_score,
                'category' => $assessment->stress_category,
            ];
        });

    return view('user.dashboard', compact('stats', 'recent', 'chartData'));
}

    // ===============================
    // LOGOUT
    // ===============================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout.');
    }

    // ===============================
    // FORGOT PASSWORD - SHOW FORM
    // ===============================
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // ===============================
    // FORGOT PASSWORD - SEND EMAIL
    // ===============================
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem.']);
        }

        // Generate token
        $token = Str::random(64);

        // Store token in database
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Create reset URL
        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        // Send email
        try {
            Mail::send('emails.reset-password', ['resetUrl' => $resetUrl], function($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password - Insight Stress');
            });

            return back()->with('status', 'Link reset password telah dikirim ke email Anda!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
        }
    }

    // ===============================
    // RESET PASSWORD - SHOW FORM
    // ===============================
    public function showResetPasswordForm($token, Request $request)
    {
        $email = $request->query('email');
        
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    // ===============================
    // RESET PASSWORD - PROCESS
    // ===============================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Get token from database
        $resetRecord = \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Token reset tidak valid.']);
        }

        // Check if token expired (60 minutes)
        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset telah kadaluarsa. Silakan minta link baru.']);
        }

        // Verify token
        if (!Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Token reset tidak valid.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete used token
        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}