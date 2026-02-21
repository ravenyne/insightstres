<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendWeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-weekly-report';
    protected $description = 'Send weekly execution report to admin';

    public function handle()
    {
        // 1. cek apakah fitur laporan mingguan diaktifkan
        $admin = \App\Models\Admin::first();
        if (!$admin || empty($admin->settings['notif_report']) || $admin->settings['notif_report'] !== true) {
            $this->info('Weekly Report is DISABLED in Admin Settings.');
            return;
        }

        // 2. hitung statistik untuk 7 hari terakhir
        $startOfWeek = \Carbon\Carbon::now()->subDays(7);
        
        $newUsers = \App\Models\User::where('created_at', '>=', $startOfWeek)->count();
        $totalAssessments = \App\Models\StressAssessment::where('created_at', '>=', $startOfWeek)->count();
        
        // cari kategori stres yang paling dominan minggu ini
        $dominantStress = \App\Models\StressAssessment::where('created_at', '>=', $startOfWeek)
            ->select('stress_category', \DB::raw('count(*) as total'))
            ->groupBy('stress_category')
            ->orderBy('total', 'desc')
            ->first();
            
        $dominantCategory = $dominantStress ? $dominantStress->stress_category : '-';

        // data statistik yang akan dikirimk ke admin
        $stats = [
            'new_users' => $newUsers,
            'total_assessments' => $totalAssessments,
            'dominant_stress' => $dominantCategory,
            'total_users' => \App\Models\User::count(),
            'start_date' => $startOfWeek->format('d M'),
            'end_date' => now()->format('d M Y'),
        ];

        // 3. kirim email laporan ke admin
        try {
            \Mail::to($admin->email)->send(new \App\Mail\WeeklyReportNotification($stats));
            $this->info('Weekly report sent to ' . $admin->email);
        } catch (\Exception $e) {
            $this->error('Failed to send email: ' . $e->getMessage());
        }
    }
}
