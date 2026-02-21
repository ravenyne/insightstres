<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Assessment Stres</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .header {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 16px;
            opacity: 0.95;
        }
        .icon-container {
            background: rgba(255, 255, 255, 0.2);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            line-height: 1.6;
            color: #4b5563;
            margin-bottom: 30px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 10px 30px rgba(20, 184, 166, 0.3);
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .info-box {
            background: #f0fdfa;
            border-left: 4px solid #14b8a6;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
        }
        .info-box h3 {
            color: #0d9488;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .info-box p {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.5;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .footer a {
            color: #14b8a6;
            text-decoration: none;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
            padding: 20px;
            background: #f9fafb;
            border-radius: 12px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #14b8a6;
        }
        .stat-label {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="icon-container">
                🧠
            </div>
            <h1>Insight Stress</h1>
            <p>Platform Kesehatan Mental Mahasiswa</p>
        </div>

        <div class="content">
            <div class="greeting">
                Halo, {{ $user->name }}! 👋
            </div>

            <div class="message">
                <p>Kami harap Anda dalam keadaan baik. Ini adalah pengingat ramah untuk melakukan assessment stres Anda.</p>
                <p style="margin-top: 15px;">Memantau tingkat stres secara rutin sangat penting untuk kesehatan mental Anda. Dengan melakukan assessment berkala, Anda dapat:</p>
            </div>

            <div class="info-box">
                <h3>✨ Manfaat Assessment Rutin</h3>
                <p>
                    • Memahami pola stres Anda<br>
                    • Mendapatkan rekomendasi yang dipersonalisasi<br>
                    • Melacak perkembangan kesehatan mental Anda<br>
                    • Mengidentifikasi pemicu stres lebih awal
                </p>
            </div>

            <div class="button-container">
                <a href="{{ url('/assessment') }}" class="cta-button">
                    Mulai Assessment Sekarang
                </a>
            </div>

            <div class="message" style="margin-top: 30px;">
                <p style="font-size: 14px; color: #6b7280;">
                    Assessment hanya membutuhkan waktu 5-7 menit. Jawaban Anda akan membantu kami memberikan dukungan yang lebih baik untuk kesehatan mental Anda.
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong>Insight Stress</strong></p>
            <p>Platform Kesehatan Mental Mahasiswa</p>
            <p style="margin-top: 15px; font-size: 12px;">
                Tidak ingin menerima email ini? 
                <a href="{{ url('/profile') }}">Ubah preferensi email Anda</a>
            </p>
            <p style="margin-top: 10px; font-size: 12px; color: #9ca3af;">
                © {{ date('Y') }} Insight Stress. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
