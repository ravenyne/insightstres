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
                    'title' => 'Assessment Berhasil Disimpan',
                    'message' => 'Hasil assessment terakhir Anda telah tersimpan. Lihat hasil analisis dan rekomendasi personal Anda.',
                    'type' => 'success',
                    'icon' => 'check-circle',
                    'is_read' => false,
                    'created_at' => now()->subDays(2)->subHours(14)->subMinutes(30),
                    'updated_at' => now()->subDays(2)->subHours(14)->subMinutes(30),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Tips Baru Tersedia',
                    'message' => 'Kami telah menambahkan tips baru tentang teknik pernapasan untuk mengatasi kecemasan mendadak.',
                    'type' => 'info',
                    'icon' => 'lightbulb',
                    'is_read' => false,
                    'created_at' => now()->subDays(1)->subHours(9),
                    'updated_at' => now()->subDays(1)->subHours(9),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Perhatian: Pola Tidur Anda',
                    'message' => 'Berdasarkan assessment terakhir, kualitas tidur Anda menurun. Coba terapkan tips tidur sehat kami.',
                    'type' => 'warning',
                    'icon' => 'alert-triangle',
                    'is_read' => false,
                    'created_at' => now()->subDays(28)->subHours(16),
                    'updated_at' => now()->subDays(28)->subHours(16),
                ],
                [
                    'user_id' => $user->id,
                    'title' => 'Pencapaian: 5 Assessment Selesai',
                    'message' => 'Selamat! Anda telah menyelesaikan 5 assessment. Terus pantau kesehatan mental Anda.',
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
