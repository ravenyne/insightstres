<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mingguan</title>
</head>
<body style="background-color: #f3f4f6; padding: 20px; font-family: sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background-color: #3b82f6; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Laporan Mingguan Insight Stress</h1>
            <p style="color: #e0f2fe; margin: 5px 0 0 0; font-size: 14px;">Periode: {{ $stats['start_date'] }} - {{ $stats['end_date'] }}</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <p style="color: #374151; font-size: 16px; margin-bottom: 20px;">
                Halo Admin, berikut adalah ringkasan aktivitas platform Anda minggu ini:
            </p>

            <!-- Stats Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px;">
                <!-- User Baru -->
                <div style="background-color: #eff6ff; padding: 15px; border-radius: 8px; text-align: center;">
                    <h3 style="margin: 0; color: #1e40af; font-size: 32px;">{{ $stats['new_users'] }}</h3>
                    <p style="margin: 5px 0 0 0; color: #60a5fa; font-size: 12px; font-weight: bold; text-transform: uppercase;">User Baru</p>
                </div>
                
                <!-- Total Assessment -->
                <div style="background-color: #f0fdf4; padding: 15px; border-radius: 8px; text-align: center;">
                    <h3 style="margin: 0; color: #166534; font-size: 32px;">{{ $stats['total_assessments'] }}</h3>
                    <p style="margin: 5px 0 0 0; color: #4ade80; font-size: 12px; font-weight: bold; text-transform: uppercase;">Assessment Masuk</p>
                </div>
            </div>

            <!-- Insight Box -->
            <div style="background-color: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                <h4 style="margin: 0 0 10px 0; color: #475569;">📊 Insight Minggu Ini</h4>
                <p style="margin: 0; color: #64748b; font-size: 14px; line-height: 1.5;">
                    Kategori stres yang paling mendominasi minggu ini adalah <strong>{{ $stats['dominant_stress'] }}</strong>.
                    <br><br>
                    Saat ini total pengguna terdaftar mencapai <strong>{{ $stats['total_users'] }}</strong> mahasiswa.
                </p>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/admin/dashboard') }}" style="display: inline-block; background-color: #3b82f6; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">
                    Buka Dashboard Admin
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">&copy; {{ date('Y') }} Insight Stress. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
