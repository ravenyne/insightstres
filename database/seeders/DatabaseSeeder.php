<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Badge;
use App\Models\Tip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admins (from AdminSeeder)
        $this->seedAdmins();

        // 2. Seed Users
        $this->seedUsers();

        // 3. Seed Badges (from BadgeSeeder)
        $this->seedBadges();

        // 4. Seed Tips (from TipSeeder)
        $this->seedTips();
    }

    private function seedUsers()
    {
        $userData = [
            'name' => 'Demo User',
            'email' => 'demouser@insightstres.lain.ch',
            'password' => Hash::make('demouser123'),
            'nim' => '000000',
            'jurusan' => 'Teknik Informatika',
            'semester' => 5,
            'gender' => '1', // 1 for Male, 0 for Female
            'age' => 20,
            'status' => 'aktif',
            'email_verified_at' => now(), // Mark as verified
        ];

        if (User::where('email', $userData['email'])->exists()) {
            $this->command->warn("User {$userData['email']} sudah ada!");
        } else {
            User::create($userData);
            $this->command->info("✓ User {$userData['name']} berhasil dibuat!");
        }
    }

    private function seedAdmins()
    {
        $admins = [
            [
                'name' => 'Rachel Anastasya Maharani B.',
                'email' => 'rachel@insightstres.lain.ch',
                'password' => 'marushy00',
            ],
        ];

        foreach ($admins as $adminData) {
            if (Admin::where('email', $adminData['email'])->exists()) {
                $this->command->warn("Admin {$adminData['email']} sudah ada!");
                continue;
            }

            Admin::create([
                'name' => $adminData['name'],
                'email' => $adminData['email'],
                'password' => Hash::make($adminData['password']),
            ]);

            $this->command->info("✓ Admin {$adminData['name']} berhasil dibuat!");
        }
    }

    private function seedBadges()
    {
        $badges = [
            // Assessment Badges
            [
                'name' => 'First Step',
                'slug' => 'first-assessment',
                'description' => 'Complete your first stress assessment',
                'icon' => '🎯',
                'color' => 'blue',
                'type' => 'bronze',
                'points' => 10,
            ],
            [
                'name' => 'Consistent Tracker',
                'slug' => 'five-assessments',
                'description' => 'Complete 5 stress assessments',
                'icon' => '📊',
                'color' => 'blue',
                'type' => 'silver',
                'points' => 50,
            ],
            [
                'name' => 'Wellness Champion',
                'slug' => 'ten-assessments',
                'description' => 'Complete 10 stress assessments',
                'icon' => '👤',
                'color' => 'purple',
                'type' => 'gold',
                'points' => 100,
            ],
            [
                'name' => 'Mental Health Master',
                'slug' => 'twenty-assessments',
                'description' => 'Complete 20 stress assessments',
                'icon' => '💎',
                'color' => 'purple',
                'type' => 'platinum',
                'points' => 200,
            ],

            // Streak Badges
            [
                'name' => 'Week Warrior',
                'slug' => 'seven-day-streak',
                'description' => 'Login for 7 consecutive days',
                'icon' => '🔥',
                'color' => 'orange',
                'type' => 'bronze',
                'points' => 30,
            ],
            [
                'name' => 'Month Master',
                'slug' => 'thirty-day-streak',
                'description' => 'Login for 30 consecutive days',
                'icon' => '⚡',
                'color' => 'orange',
                'type' => 'gold',
                'points' => 100,
            ],
            [
                'name' => 'Year Champion',
                'slug' => 'year-streak',
                'description' => 'Login for 365 consecutive days',
                'icon' => '☀️',
                'color' => 'yellow',
                'type' => 'platinum',
                'points' => 500,
            ],

            // Improvement Badges
            [
                'name' => 'Stress Reducer',
                'slug' => 'stress-reduction',
                'description' => 'Show consistent stress reduction over 3 assessments',
                'icon' => '📉',
                'color' => 'green',
                'type' => 'gold',
                'points' => 150,
            ],
            [
                'name' => 'Calm Mind',
                'slug' => 'low-stress-month',
                'description' => 'Maintain low stress levels for a month',
                'icon' => '🧘',
                'color' => 'green',
                'type' => 'platinum',
                'points' => 200,
            ],

            // Engagement Badges
            [
                'name' => 'Voice Heard',
                'slug' => 'first-feedback',
                'description' => 'Submit your first feedback',
                'icon' => '💬',
                'color' => 'teal',
                'type' => 'bronze',
                'points' => 20,
            ],

            // Knowledge Badges
            [
                'name' => 'Knowledge Seeker',
                'slug' => 'tips-reader',
                'description' => 'Read 10 tips and articles',
                'icon' => '📚',
                'color' => 'indigo',
                'type' => 'silver',
                'points' => 40,
            ],

            // Breathing Exercise Badge
            [
                'name' => 'Breath Master',
                'slug' => 'breathing-expert',
                'description' => 'Complete 10 breathing exercises',
                'icon' => '🌬️',
                'color' => 'cyan',
                'type' => 'silver',
                'points' => 50,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['slug' => $badge['slug']],
                $badge
            );
        }
        $this->command->info('✅ Badges seeded successfully!');
    }

    private function seedTips()
    {
        $tips = [
            // Breathing
            [
                'title' => 'Teknik Pernapasan 4-7-8',
                'content' => 'Teknik pernapasan yang efektif untuk mengurangi kecemasan dan membantu tidur lebih baik. Caranya: Tarik napas melalui hidung selama 4 detik, tahan napas selama 7 detik, lalu hembuskan perlahan melalui mulut selama 8 detik. Ulangi 4 kali. Teknik ini mengaktifkan sistem saraf parasimpatis yang membantu tubuh rileks.',
                'category' => 'breathing',
                'icon' => 'wind',
            ],
            [
                'title' => 'Box Breathing untuk Fokus',
                'content' => 'Teknik pernapasan yang digunakan oleh Navy SEALs untuk meningkatkan fokus dan mengurangi stress. Caranya: Tarik napas 4 detik, tahan 4 detik, hembuskan 4 detik, tahan 4 detik. Ulangi selama 5 menit. Sangat efektif sebelum ujian atau presentasi.',
                'category' => 'breathing',
                'icon' => 'square',
            ],
            [
                'title' => 'Pernapasan Diafragma',
                'content' => 'Bernapas dengan diafragma lebih efektif daripada pernapasan dada. Letakkan satu tangan di dada dan satu di perut. Saat menarik napas, pastikan perut mengembang lebih banyak daripada dada. Ini memaksimalkan oksigen yang masuk dan membantu relaksasi.',
                'category' => 'breathing',
                'icon' => 'activity',
            ],

            // Sleep
            [
                'title' => 'Rutinitas Tidur yang Konsisten',
                'content' => 'Tidur dan bangun di waktu yang sama setiap hari, termasuk akhir pekan. Ini membantu mengatur jam biologis tubuh (circadian rhythm). Usahakan tidur 7-9 jam setiap malam. Konsistensi adalah kunci untuk kualitas tidur yang baik.',
                'category' => 'sleep',
                'icon' => 'moon',
            ],
            [
                'title' => 'Hindari Layar Sebelum Tidur',
                'content' => 'Cahaya biru dari smartphone dan laptop mengganggu produksi melatonin, hormon tidur. Matikan semua layar minimal 1 jam sebelum tidur. Gunakan mode malam atau blue light filter jika harus menggunakan gadget. Ganti dengan membaca buku atau mendengarkan musik tenang.',
                'category' => 'sleep',
                'icon' => 'smartphone',
            ],
            [
                'title' => 'Ciptakan Lingkungan Tidur Ideal',
                'content' => 'Kamar tidur yang gelap, sejuk (18-22°C), dan tenang adalah kunci tidur berkualitas. Gunakan tirai tebal, matikan lampu, dan pertimbangkan white noise jika lingkungan bising. Pastikan kasur dan bantal nyaman. Kamar tidur hanya untuk tidur, bukan untuk belajar atau bekerja.',
                'category' => 'sleep',
                'icon' => 'bed',
            ],

            // Exercise
            [
                'title' => 'Jalan Kaki 15 Menit',
                'content' => 'Jalan kaki 15 menit setiap hari dapat meningkatkan mood dan mengurangi stress secara signifikan. Lakukan di pagi hari untuk energi ekstra atau sore hari untuk melepas penat. Jalan di taman atau area hijau memberikan manfaat tambahan. Tidak perlu cepat, yang penting konsisten.',
                'category' => 'exercise',
                'icon' => 'footprints',
            ],
            [
                'title' => 'Stretching di Sela Belajar',
                'content' => 'Setiap 1 jam belajar, lakukan stretching 5 menit. Regangkan leher, bahu, punggung, dan kaki. Ini meningkatkan sirkulasi darah, mengurangi ketegangan otot, dan menyegarkan pikiran. Gerakan sederhana seperti memutar bahu atau membungkuk menyentuh jari kaki sudah cukup efektif.',
                'category' => 'exercise',
                'icon' => 'move',
            ],
            [
                'title' => 'Yoga untuk Pemula',
                'content' => 'Yoga menggabungkan gerakan fisik, pernapasan, dan meditasi. Mulai dengan pose sederhana seperti Child\'s Pose, Cat-Cow, dan Downward Dog. 10-15 menit yoga setiap pagi dapat meningkatkan fleksibilitas, kekuatan, dan ketenangan mental. Banyak tutorial gratis di YouTube.',
                'category' => 'exercise',
                'icon' => 'user',
            ],

            // Mindfulness
            [
                'title' => 'Meditasi 5 Menit',
                'content' => 'Duduk dengan nyaman, tutup mata, fokus pada napas. Saat pikiran melayang, dengan lembut kembalikan fokus ke napas. Jangan menghakimi pikiran yang muncul, biarkan mengalir. Lakukan 5 menit setiap pagi. Meditasi teratur mengurangi kecemasan dan meningkatkan fokus.',
                'category' => 'mindfulness',
                'icon' => 'sparkles',
            ],
            [
                'title' => 'Teknik Grounding 5-4-3-2-1',
                'content' => 'Saat merasa cemas atau overwhelmed, gunakan teknik ini: Sebutkan 5 hal yang Anda lihat, 4 hal yang Anda sentuh, 3 hal yang Anda dengar, 2 hal yang Anda cium, 1 hal yang Anda rasakan. Ini membawa kesadaran ke momen sekarang dan mengurangi kecemasan.',
                'category' => 'mindfulness',
                'icon' => 'anchor',
            ],
            [
                'title' => 'Gratitude Journaling',
                'content' => 'Setiap malam sebelum tidur, tulis 3 hal yang Anda syukuri hari ini. Bisa hal kecil seperti "makan enak" atau "cuaca cerah". Praktik ini mengubah fokus dari hal negatif ke positif, meningkatkan kebahagiaan, dan mengurangi stress. Konsistensi lebih penting daripada panjangnya tulisan.',
                'category' => 'mindfulness',
                'icon' => 'heart',
            ],

            // Study
            [
                'title' => 'Teknik Pomodoro',
                'content' => 'Belajar 25 menit fokus penuh, istirahat 5 menit. Setelah 4 sesi, istirahat lebih lama (15-30 menit). Teknik ini mencegah burnout, meningkatkan fokus, dan produktivitas. Gunakan timer untuk disiplin. Saat istirahat, jauhi layar - jalan-jalan atau stretching lebih baik.',
                'category' => 'study',
                'icon' => 'clock',
            ],
            [
                'title' => 'Active Recall vs Passive Reading',
                'content' => 'Jangan hanya membaca ulang catatan. Setelah membaca, tutup buku dan coba ingat apa yang baru dipelajari. Tulis atau jelaskan dengan kata-kata sendiri. Active recall jauh lebih efektif untuk retensi jangka panjang dibanding membaca pasif berkali-kali.',
                'category' => 'study',
                'icon' => 'brain',
            ],
            [
                'title' => 'Buat Lingkungan Belajar Ideal',
                'content' => 'Tempat belajar harus rapi, terang, dan bebas distraksi. Matikan notifikasi HP atau simpan di laci. Gunakan headphone noise-canceling atau musik instrumental jika perlu. Pastikan meja hanya berisi yang diperlukan untuk belajar. Lingkungan yang tepat meningkatkan fokus hingga 50%.',
                'category' => 'study',
                'icon' => 'book-open',
            ],

            // General
            [
                'title' => 'Batasi Konsumsi Kafein',
                'content' => 'Kafein dapat meningkatkan kecemasan dan mengganggu tidur. Batasi maksimal 2 cangkir kopi per hari, dan hindari setelah jam 2 siang. Jika merasa cemas, coba ganti dengan teh herbal atau air putih. Ingat, kafein tetap ada dalam sistem 6-8 jam setelah konsumsi.',
                'category' => 'general',
                'icon' => 'coffee',
            ],
            [
                'title' => 'Hidrasi yang Cukup',
                'content' => 'Dehidrasi ringan saja dapat memperburuk mood dan meningkatkan stress. Minum minimal 8 gelas (2 liter) air per hari. Bawa botol air kemana-mana sebagai reminder. Jika urin berwarna kuning gelap, Anda perlu minum lebih banyak. Air putih adalah pilihan terbaik.',
                'category' => 'general',
                'icon' => 'droplet',
            ],
            [
                'title' => 'Berbicara dengan Orang Terdekat',
                'content' => 'Jangan simpan masalah sendiri. Berbicara dengan teman, keluarga, atau konselor dapat sangat membantu. Kadang hanya dengan didengarkan sudah membuat beban terasa lebih ringan. Jika merasa overwhelmed, jangan ragu mencari bantuan profesional. Meminta bantuan adalah tanda kekuatan, bukan kelemahan.',
                'category' => 'general',
                'icon' => 'users',
            ],
            [
                'title' => 'Batasi Media Sosial',
                'content' => 'Terlalu banyak media sosial dapat meningkatkan kecemasan dan FOMO (Fear of Missing Out). Batasi penggunaan maksimal 30 menit per hari. Unfollow akun yang membuat Anda merasa buruk. Ingat, orang hanya posting highlight reel mereka, bukan realitas. Fokus pada kehidupan Anda sendiri.',
                'category' => 'general',
                'icon' => 'smartphone',
            ],
        ];

        foreach ($tips as $tip) {
            Tip::updateOrCreate(
                ['title' => $tip['title']], // Use title as unique identifier since no slug
                $tip
            );
        }
        $this->command->info('✅ Tips seeded successfully!');
    }
}