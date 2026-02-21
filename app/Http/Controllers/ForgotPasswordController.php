<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    // Tampilkan form lupa password (input email)
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim link reset password ke email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Kita kirim link reset password manual (tanpa built-in auth scaffolding yang ribet)
        // 1. Cek user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // 2. Buat token
        $token = Str::random(60);

        // 3. Simpan token ke tabel password_resets
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // 4. Kirim email (Simulasi/Log dulu jika belum setup SMTP, tapi kita coba pakai Mail facade standar)
        // Untuk production butuh view email. Untuk sekarang kita pakai simple text atau asumsi SMTP jalan.
        // Karena user minta "notif masuk ke email", kita gunakan fitur built-in Laravel Notification/Mail jika memungkinkan.
        // Tapi untuk simplifikasi dan memastikan jalan tanpa setup ribet, kita bisa pakai cara manual atau built-in Password Broker.
        
        // Cara paling clean pakai built-in Password Broker Laravel:
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // Tampilkan form reset password (input password baru)
    public function showResetForm(Request $request)
    {
        $token = $request->route('token');
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // Proses reset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login.');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
