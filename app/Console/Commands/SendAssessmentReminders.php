<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\StressAssessment;
use App\Mail\AssessmentReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendAssessmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-assessment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send assessment reminder emails to users who haven\'t taken an assessment in 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to send assessment reminders...');

        // 1. cek switch global dari admin (kalau dimatiin, langsung stop)
        $admin = \App\Models\Admin::first();
        if ($admin && isset($admin->settings['notif_reminder']) && !$admin->settings['notif_reminder']) {
            $this->warn('Global Assessment Reminder is DISABLED in Admin Settings. Aborting.');
            return Command::SUCCESS;
        }

        // ambil user yang memenuhi kriteria:
        // 1. reminder email aktif
        // 2. belum dikirimi reminder dalam 24 jam terakhir (biar tidak spam))
        // 3. belum pernah atau terakhir kali assessment lebih dari 7 hari yang lalu
        
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $oneDayAgo = Carbon::now()->subDay();
        
        $users = User::where('email_reminder_enabled', true)
            ->where(function($query) use ($oneDayAgo) {
                $query->whereNull('last_reminder_sent_at')
                      ->orWhere('last_reminder_sent_at', '<', $oneDayAgo);
            })
            ->whereNotNull('email_verified_at') // hanya user yang sudah verifikasi email
            ->get();

        $sentCount = 0;

        foreach ($users as $user) {
            // ambil data assessment terakhir user
            $lastAssessment = StressAssessment::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $shouldSendReminder = false;

            if (!$lastAssessment) {
                // user belum pernah melakukan assessment
                $shouldSendReminder = true;
            } elseif ($lastAssessment->created_at < $sevenDaysAgo) {
                // assessment terakhir lebih dari 7 hari yang lalu
                $shouldSendReminder = true;
            }

            if ($shouldSendReminder) {
                try {
                    // kirim email reminder
                    Mail::to($user->email)->send(new AssessmentReminder($user));
                    
                    // update timestamp terakhir dikirimi reminder
                    $user->update([
                        'last_reminder_sent_at' => Carbon::now()
                    ]);
                    
                    $sentCount++;
                    $this->info("✓ Sent reminder to: {$user->email}");
                } catch (\Exception $e) {
                    $this->error("✗ Failed to send to {$user->email}: {$e->getMessage()}");
                }
            }
        }

        $this->info("Completed! Sent {$sentCount} reminder(s).");
        
        return Command::SUCCESS;
    }
}
