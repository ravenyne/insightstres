<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    public function up(): void
    {
        // Get the first user
        $user = DB::table('users')->first();

        if ($user) {
            // Create sample notifications
            DB::table('notifications')->insert([
                [
                    'user_id' => $user->id,
                    'title' => 'Peringatan Assessment Mingguan',
                    'message' => 'Sudah waktunya melakukan assessment stress mingguan Anda. Pantau kesehatan mental secara berkala untuk hasil yang lebih akurat.',
                    'type' => 'info',
                    'icon' => 'info',
                    'is_read' => false,
                    'created_at' => now()->subHours(2),
                    'updated_at' => now()->subHours(2),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Aktivitas Tercatat',
                    'title_en' => 'Activity Recorded',
                    'message' => 'Sesi meditasi harian Anda berhasil disimpan. Lanjutkan kebiasaan baik ini!',
                    'message_en' => 'Your daily meditation session was successfully saved. Keep up the good habit!',
                    'type' => 'info',
                    'icon' => 'activity',
                    'is_read' => false,
                    'created_at' => now()->subHours(2),
                    'updated_at' => now()->subHours(2),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Tips Baru Tersedia',
                    'title_en' => 'New Tips Available',
                    'message' => 'Baca artikel terbaru tentang cara mengelola stres saat belajar untuk ujian.',
                    'message_en' => 'Read our latest article on how to manage stress while studying for exams.',
                    'type' => 'info',
                    'icon' => 'book-open',
                    'is_read' => true,
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Peringatan Sistem',
                    'title_en' => 'System Warning',
                    'message' => 'Password Anda akan kedaluwarsa dalam 3 hari. Mohon segera perbarui.',
                    'message_en' => 'Your password will expire in 3 days. Please update it soon.',
                    'type' => 'warning',
                    'icon' => 'alert-triangle',
                    'is_read' => false,
                    'created_at' => now()->subMinutes(30),
                    'updated_at' => now()->subMinutes(30),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Assessment Berhasil Disimpan',
                    'title_en' => 'Assessment Successfully Saved',
                    'message' => 'Hasil assessment terakhir Anda telah tersimpan. Lihat hasil analisis dan rekomendasi personal Anda.',
                    'message_en' => 'Your last assessment results have been saved. View your analysis and personalized recommendations.',
                    'type' => 'success',
                    'icon' => 'check-circle',
                    'is_read' => false,
                    'created_at' => now()->subDays(2)->subHours(14)->subMinutes(30),
                    'updated_at' => now()->subDays(2)->subHours(14)->subMinutes(30),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Tips Baru Tersedia',
                    'title_en' => 'New Tips Available',
                    'message' => 'Kami telah menambahkan tips baru tentang teknik pernapasan untuk mengatasi kecemasan mendadak.',
                    'message_en' => 'We have added new tips on breathing techniques to manage sudden anxiety.',
                    'type' => 'info',
                    'icon' => 'lightbulb',
                    'is_read' => false,
                    'created_at' => now()->subDays(1)->subHours(9),
                    'updated_at' => now()->subDays(1)->subHours(9),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Perhatian: Pola Tidur Anda',
                    'title_en' => 'Attention: Your Sleep Pattern',
                    'message' => 'Berdasarkan assessment terakhir, kualitas tidur Anda menurun. Coba terapkan tips tidur sehat kami.',
                    'message_en' => 'Based on the last assessment, your sleep quality has decreased. Try our healthy sleep tips.',
                    'type' => 'warning',
                    'icon' => 'alert-triangle',
                    'is_read' => false,
                    'created_at' => now()->subDays(28)->subHours(16),
                    'updated_at' => now()->subDays(28)->subHours(16),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Pencapaian: 5 Assessment Selesai',
                    'title_en' => 'Achievement: 5 Assessments Completed',
                    'message' => 'Selamat! Anda telah menyelesaikan 5 assessment. Terus pantau kesehatan mental Anda.',
                    'message_en' => 'Congratulations! You have completed 5 assessments. Continue to monitor your mental health.',
                    'type' => 'success',
                    'icon' => 'trophy',
                    'is_read' => false,
                    'created_at' => now()->subDays(26)->subHours(10)->subMinutes(15),
                    'updated_at' => now()->subDays(26)->subHours(10)->subMinutes(15),
                ],
            ]);
        }
    }

    public function down(): void
    {
        DB::table('notifications')->truncate();
    }
};
