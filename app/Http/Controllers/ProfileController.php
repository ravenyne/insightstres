<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // menampilkan halaman profil mahasiswa
    public function show()
    {
        $user = Auth::user();
        
        // Fetch stats
        $assessments = \App\Models\StressAssessment::where('user_id', $user->id)->latest()->get();
        $totalAssessments = $assessments->count();
        
        // Last Score (using accessor if available, or manual sum fallback)
        $lastAssessment = $assessments->first();
        $lastScore = 0;
        if ($lastAssessment) {
            // Fallback calculation if accessor not yet working
            $fields = [
                'stress_recent', 'heartbeat', 'anxiety', 'sleep_problems', 'anxiety_2',
                'headache', 'irritated', 'concentration', 'sadness', 'illness',
                'lonely', 'overwhelmed', 'competition', 'relationship_stress',
                'professor_difficulty', 'work_env', 'relaxation_time', 'home_env',
                'conf_academic', 'conf_subject', 'activity_conflict', 'attendance',
                'weight_change'
            ];
            foreach ($fields as $field) {
                $lastScore += $lastAssessment->$field;
            }
        }

        // Active Months
        $activeMonths = \App\Models\StressAssessment::where('user_id', $user->id)
            ->selectRaw('count(distinct date_format(created_at, "%Y-%m")) as count')
            ->value('count');

        // Improvement (Compare last 2 scores)
        $improvement = 0;
        if ($assessments->count() >= 2) {
            $current = 0;
            $previous = 0;
            foreach ($fields as $field) {
                $current += $assessments[0]->$field;
                $previous += $assessments[1]->$field;
            }
            if ($previous > 0) {
                $improvement = round((($previous - $current) / $previous) * 100);
            }
        }

        $stats = [
            'total' => $totalAssessments,
            'last_score' => $lastScore,
            'active_months' => $activeMonths,
            'improvement' => $improvement
        ];

        return view('user.profile', compact('user', 'stats'));
    }

    // update data profil mahasiswa
    public function update(Request $request)
    {
        $user = Auth::user();

        // Cek apakah ada perubahan data
        if (
            $request->name == $user->name &&
            $request->nim == $user->nim &&
            $request->jurusan == $user->jurusan &&
            $request->semester == $user->semester &&
            $request->gender == $user->gender &&
            $request->age == $user->age &&
            $request->email == $user->email
        ) {
            return back()->with('error', 'Tidak bisa mengedit data dengan data yang anda masukkan!');
        }

        $request->validate([
            'name' => 'required|string|max:50',
            'nim' => 'required|numeric|unique:users,nim,' . $user->id,
            'jurusan' => 'required|string',
            'semester' => 'required|integer|min:1|max:8',
            'gender' => 'required|in:1,0',
            'age' => 'required|integer|min:15|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 50 karakter.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.numeric' => 'NIM harus berupa angka.',
            'nim.unique' => 'NIM :input sudah digunakan oleh mahasiswa lain.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'semester.required' => 'Semester wajib diisi.',
            'semester.min' => 'Semester minimal adalah semester 1.',
            'semester.max' => 'Semester maksimal adalah semester 8.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'age.required' => 'Usia wajib diisi.',
            'age.min' => 'Usia minimal adalah 15 tahun.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email :input sudah terdaftar pada akun lain.',
        ]);

        $user->update([
            'name' => $request->name,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'semester' => $request->semester,
            'gender' => $request->gender,
            'age' => $request->age,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    // update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal berjumlah 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah.');
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    // update email preferences
    public function updateEmailPreferences(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'email_reminder_enabled' => $request->has('email_reminder_enabled'),
        ]);

        return back()->with('success', 'Preferensi email berhasil diperbarui!');
    }
}
