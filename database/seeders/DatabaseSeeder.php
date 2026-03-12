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
                'title_id' => 'Teknik Pernapasan 4-7-8',
                'title_en' => '4-7-8 Breathing Technique',
                'content_id' => 'Teknik pernapasan yang efektif untuk mengurangi kecemasan dan membantu tidur lebih baik. Caranya: Tarik napas melalui hidung selama 4 detik, tahan napas selama 7 detik, lalu hembuskan perlahan melalui mulut selama 8 detik. Ulangi 4 kali. Teknik ini mengaktifkan sistem saraf parasimpatis yang membantu tubuh rileks.',
                'content_en' => 'An effective breathing technique to reduce anxiety and help you sleep better. How to do it: Inhale through your nose for 4 seconds, hold your breath for 7 seconds, then exhale slowly through your mouth for 8 seconds. Repeat 4 times. This technique activates the parasympathetic nervous system which helps the body relax.',
                'category' => 'breathing',
                'icon' => 'wind',
            ],
            [
                'title_id' => 'Box Breathing untuk Fokus',
                'title_en' => 'Box Breathing for Focus',
                'content_id' => 'Teknik pernapasan yang digunakan oleh Navy SEALs untuk meningkatkan fokus dan mengurangi stress. Caranya: Tarik napas 4 detik, tahan 4 detik, hembuskan 4 detik, tahan 4 detik. Ulangi selama 5 menit. Sangat efektif sebelum ujian atau presentasi.',
                'content_en' => 'A breathing technique used by Navy SEALs to improve focus and reduce stress. How to do it: Inhale for 4 seconds, hold for 4 seconds, exhale for 4 seconds, hold for 4 seconds. Repeat for 5 minutes. Highly effective before exams or presentations.',
                'category' => 'breathing',
                'icon' => 'square',
            ],
            [
                'title_id' => 'Pernapasan Diafragma',
                'title_en' => 'Diaphragmatic Breathing',
                'content_id' => 'Bernapas dengan diafragma lebih efektif daripada pernapasan dada. Letakkan satu tangan di dada dan satu di perut. Saat menarik napas, pastikan perut mengembang lebih banyak daripada dada. Ini memaksimalkan oksigen yang masuk dan membantu relaksasi.',
                'content_en' => 'Diaphragmatic breathing is more effective than chest breathing. Place one hand on your chest and one on your stomach. When inhaling, make sure your stomach expands more than your chest. This maximizes oxygen intake and aids relaxation.',
                'category' => 'breathing',
                'icon' => 'activity',
            ],

            // Sleep
            [
                'title_id' => 'Rutinitas Tidur yang Konsisten',
                'title_en' => 'Consistent Sleep Routine',
                'content_id' => 'Tidur dan bangun di waktu yang sama setiap hari, termasuk akhir pekan. Ini membantu mengatur jam biologis tubuh (circadian rhythm). Usahakan tidur 7-9 jam setiap malam. Konsistensi adalah kunci untuk kualitas tidur yang baik.',
                'content_en' => 'Go to bed and wake up at the same time every day, including weekends. This helps regulate the body\'s biological clock (circadian rhythm). Try to sleep 7-9 hours each night. Consistency is key for good sleep quality.',
                'category' => 'sleep',
                'icon' => 'moon',
            ],
            [
                'title_id' => 'Hindari Layar Sebelum Tidur',
                'title_en' => 'Avoid Screens Before Bed',
                'content_id' => 'Cahaya biru dari smartphone dan laptop mengganggu produksi melatonin, hormon tidur. Matikan semua layar minimal 1 jam sebelum tidur. Gunakan mode malam atau blue light filter jika harus menggunakan gadget. Ganti dengan membaca buku atau mendengarkan musik tenang.',
                'content_en' => 'Blue light from smartphones and laptops disrupts the production of melatonin, the sleep hormone. Turn off all screens at least 1 hour before bed. Use night mode or blue light filters if you must use gadgets. Replace screen time with reading a book or listening to calm music.',
                'category' => 'sleep',
                'icon' => 'smartphone',
            ],
            [
                'title_id' => 'Ciptakan Lingkungan Tidur Ideal',
                'title_en' => 'Create an Ideal Sleep Environment',
                'content_id' => 'Kamar tidur yang gelap, sejuk (18-22°C), dan tenang adalah kunci tidur berkualitas. Gunakan tirai tebal, matikan lampu, dan pertimbangkan white noise jika lingkungan bising. Pastikan kasur dan bantal nyaman. Kamar tidur hanya untuk tidur, bukan untuk belajar atau bekerja.',
                'content_en' => 'A dark, cool (18-22°C), and quiet bedroom is key to quality sleep. Use thick curtains, turn off lights, and consider white noise if the environment is noisy. Ensure your mattress and pillows are comfortable. The bedroom should be for sleep only, not for studying or working.',
                'category' => 'sleep',
                'icon' => 'bed',
            ],

            // Exercise
            [
                'title_id' => 'Jalan Kaki 15 Menit',
                'title_en' => '15-Minute Walk',
                'content_id' => 'Jalan kaki 15 menit setiap hari dapat meningkatkan mood dan mengurangi stress secara signifikan. Lakukan di pagi hari untuk energi ekstra atau sore hari untuk melepas penat. Jalan di taman atau area hijau memberikan manfaat tambahan. Tidak perlu cepat, yang penting konsisten.',
                'content_en' => 'A 15-minute walk every day can boost your mood and significantly reduce stress. Do it in the morning for extra energy or in the evening to unwind. Walking in a park or green area provides added benefits. It doesn\'t need to be fast, consistency is key.',
                'category' => 'exercise',
                'icon' => 'footprints',
            ],
            [
                'title_id' => 'Stretching di Sela Belajar',
                'title_en' => 'Stretching Between Studies',
                'content_id' => 'Setiap 1 jam belajar, lakukan stretching 5 menit. Regangkan leher, bahu, punggung, dan kaki. Ini meningkatkan sirkulasi darah, mengurangi ketegangan otot, dan menyegarkan pikiran. Gerakan sederhana seperti memutar bahu atau membungkuk menyentuh jari kaki sudah cukup efektif.',
                'content_en' => 'For every hour of study, do 5 minutes of stretching. Stretch your neck, shoulders, back, and legs. This improves blood circulation, reduces muscle tension, and refreshes the mind. Simple movements like rolling your shoulders or bending to touch your toes are effective enough.',
                'category' => 'exercise',
                'icon' => 'move',
            ],
            [
                'title_id' => 'Yoga untuk Pemula',
                'title_en' => 'Yoga for Beginners',
                'content_id' => 'Yoga menggabungkan gerakan fisik, pernapasan, dan meditasi. Mulai dengan pose sederhana seperti Child\'s Pose, Cat-Cow, dan Downward Dog. 10-15 menit yoga setiap pagi dapat meningkatkan fleksibilitas, kekuatan, dan ketenangan mental. Banyak tutorial gratis di YouTube.',
                'content_en' => 'Yoga combines physical movement, breathing, and meditation. Start with simple poses like Child\'s Pose, Cat-Cow, and Downward Dog. 10-15 minutes of yoga every morning can increase flexibility, strength, and mental calmness. Many free tutorials are available on YouTube.',
                'category' => 'exercise',
                'icon' => 'user',
            ],

            // Mindfulness
            [
                'title_id' => 'Meditasi 5 Menit',
                'title_en' => '5-Minute Meditation',
                'content_id' => 'Duduk dengan nyaman, tutup mata, fokus pada napas. Saat pikiran melayang, dengan lembut kembalikan fokus ke napas. Jangan menghakimi pikiran yang muncul, biarkan mengalir. Lakukan 5 menit setiap pagi. Meditasi teratur mengurangi kecemasan dan meningkatkan fokus.',
                'content_en' => 'Sit comfortably, close your eyes, and focus on your breath. As your mind wanders, gently bring your focus back to your breath. Do not judge the thoughts that arise, let them flow. Do this for 5 minutes every morning. Regular meditation reduces anxiety and improves focus.',
                'category' => 'mindfulness',
                'icon' => 'sparkles',
            ],
            [
                'title_id' => 'Teknik Grounding 5-4-3-2-1',
                'title_en' => '5-4-3-2-1 Grounding Technique',
                'content_id' => 'Saat merasa cemas atau overwhelmed, gunakan teknik ini: Sebutkan 5 hal yang Anda lihat, 4 hal yang Anda sentuh, 3 hal yang Anda dengar, 2 hal yang Anda cium, 1 hal yang Anda rasakan. Ini membawa kesadaran ke momen sekarang dan mengurangi kecemasan.',
                'content_en' => 'When feeling anxious or overwhelmed, use this technique: Name 5 things you can see, 4 things you can touch, 3 things you can hear, 2 things you can smell, and 1 thing you can taste. This brings your awareness to the present moment and reduces anxiety.',
                'category' => 'mindfulness',
                'icon' => 'anchor',
            ],
            [
                'title_id' => 'Gratitude Journaling',
                'title_en' => 'Gratitude Journaling',
                'content_id' => 'Setiap malam sebelum tidur, tulis 3 hal yang Anda syukuri hari ini. Bisa hal kecil seperti "makan enak" atau "cuaca cerah". Praktik ini mengubah fokus dari hal negatif ke positif, meningkatkan kebahagiaan, dan mengurangi stress. Konsistensi lebih penting daripada panjangnya tulisan.',
                'content_en' => 'Every night before going to sleep, write down 3 things you are grateful for today. It can be small things like "good food" or "sunny weather." This practice shifts focus from negative to positive, increases happiness, and reduces stress. Consistency is more important than the length of the writing.',
                'category' => 'mindfulness',
                'icon' => 'heart',
            ],

            // Study
            [
                'title_id' => 'Teknik Pomodoro',
                'title_en' => 'Pomodoro Technique',
                'content_id' => 'Belajar 25 menit fokus penuh, istirahat 5 menit. Setelah 4 sesi, istirahat lebih lama (15-30 menit). Teknik ini mencegah burnout, meningkatkan fokus, dan produktivitas. Gunakan timer untuk disiplin. Saat istirahat, jauhi layar - jalan-jalan atau stretching lebih baik.',
                'content_en' => 'Study with full focus for 25 minutes, followed by a 5-minute break. After 4 sessions, take a longer break (15-30 minutes). This technique prevents burnout, improves focus, and increases productivity. Use a timer for discipline. During breaks, avoid screens—walking or stretching is better.',
                'category' => 'study',
                'icon' => 'clock',
            ],
            [
                'title_id' => 'Active Recall vs Passive Reading',
                'title_en' => 'Active Recall vs Passive Reading',
                'content_id' => 'Jangan hanya membaca ulang catatan. Setelah membaca, tutup buku dan coba ingat apa yang baru dipelajari. Tulis atau jelaskan dengan kata-kata sendiri. Active recall jauh lebih efektif untuk retensi jangka panjang dibanding membaca pasif berkali-kali.',
                'content_en' => 'Do not just reread your notes. After reading, close the book and try to recall what you just learned. Write or explain it in your own words. Active recall is much more effective for long-term retention compared to continuously reading passively.',
                'category' => 'study',
                'icon' => 'brain',
            ],
            [
                'title_id' => 'Buat Lingkungan Belajar Ideal',
                'title_en' => 'Create an Ideal Study Environment',
                'content_id' => 'Tempat belajar harus rapi, terang, dan bebas distraksi. Matikan notifikasi HP atau simpan di laci. Gunakan headphone noise-canceling atau musik instrumental jika perlu. Pastikan meja hanya berisi yang diperlukan untuk belajar. Lingkungan yang tepat meningkatkan fokus hingga 50%.',
                'content_en' => 'Your study place should be tidy, well-lit, and free from distractions. Turn off phone notifications or keep it in a drawer. Use noise-canceling headphones or instrumental music if necessary. Make sure the desk only contains what is needed for studying. The right environment improves focus by up to 50%.',
                'category' => 'study',
                'icon' => 'book-open',
            ],

            // General
            [
                'title_id' => 'Batasi Konsumsi Kafein',
                'title_en' => 'Limit Caffeine Consumption',
                'content_id' => 'Kafein dapat meningkatkan kecemasan dan mengganggu tidur. Batasi maksimal 2 cangkir kopi per hari, dan hindari setelah jam 2 siang. Jika merasa cemas, coba ganti dengan teh herbal atau air putih. Ingat, kafein tetap ada dalam sistem 6-8 jam setelah konsumsi.',
                'content_en' => 'Caffeine can increase anxiety and disrupt sleep. Limit to a maximum of 2 cups of coffee per day, and avoid it after 2 PM. If you feel anxious, try replacing it with herbal tea or water. Remember, caffeine remains in the system for 6-8 hours after consumption.',
                'category' => 'general',
                'icon' => 'coffee',
            ],
            [
                'title_id' => 'Hidrasi yang Cukup',
                'title_en' => 'Adequate Hydration',
                'content_id' => 'Dehidrasi ringan saja dapat memperburuk mood dan meningkatkan stress. Minum minimal 8 gelas (2 liter) air per hari. Bawa botol air kemana-mana sebagai reminder. Jika urin berwarna kuning gelap, Anda perlu minum lebih banyak. Air putih adalah pilihan terbaik.',
                'content_en' => 'Even mild dehydration can worsen your mood and increase stress. Drink at least 8 glasses (2 liters) of water per day. Carry a water bottle everywhere as a reminder. If your urine is dark yellow, you need to drink more. Water is the best choice.',
                'category' => 'general',
                'icon' => 'droplet',
            ],
            [
                'title_id' => 'Berbicara dengan Orang Terdekat',
                'title_en' => 'Talk to Loved Ones',
                'content_id' => 'Jangan simpan masalah sendiri. Berbicara dengan teman, keluarga, atau konselor dapat sangat membantu. Kadang hanya dengan didengarkan sudah membuat beban terasa lebih ringan. Jika merasa overwhelmed, jangan ragu mencari bantuan profesional. Meminta bantuan adalah tanda kekuatan, bukan kelemahan.',
                'content_en' => 'Don\'t keep your problems to yourself. Talking to friends, family, or counselors can be very helpful. Sometimes simply being heard makes the burden feel lighter. If you feel overwhelmed, do not hesitate to seek professional help. Asking for help is a sign of strength, not weakness.',
                'category' => 'general',
                'icon' => 'users',
            ],
            [
                'title_id' => 'Batasi Media Sosial',
                'title_en' => 'Limit Social Media',
                'content_id' => 'Terlalu banyak media sosial dapat meningkatkan kecemasan dan FOMO (Fear of Missing Out). Batasi penggunaan maksimal 30 menit per hari. Unfollow akun yang membuat Anda merasa buruk. Ingat, orang hanya posting highlight reel mereka, bukan realitas. Fokus pada kehidupan Anda sendiri.',
                'content_en' => 'Too much social media can increase anxiety and FOMO (Fear of Missing Out). Limit your usage to a maximum of 30 minutes per day. Unfollow accounts that make you feel bad. Remember, people only post their highlight reels, not reality. Focus on your own life.',
                'category' => 'general',
                'icon' => 'smartphone',
            ],
        ];

        foreach ($tips as $tip) {
            Tip::updateOrCreate(
                ['title_id' => $tip['title_id']], // Use title as unique identifier since no slug
                $tip
            );
        }
        $this->command->info('✅ Tips seeded successfully!');
    }
}
