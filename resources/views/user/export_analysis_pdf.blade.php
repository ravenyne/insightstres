<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Analisis Stres</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 30px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #14b8a6;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            color: #14b8a6;
        }
        
        .user-info {
            margin-bottom: 25px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid #14b8a6;
        }
        
        .user-info-row {
            margin-bottom: 8px;
            font-size: 13px;
        }
        
        .user-info-row strong {
            color: #14b8a6;
            margin-right: 5px;
        }
        
        .score-card {
            text-align: center;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 8px;
        }
        
        .score-card.no-stress {
            background: #d1fae5;
            border: 2px solid #059669;
        }
        
        .score-card.eustress {
            background: #dbeafe;
            border: 2px solid #2563eb;
        }
        
        .score-card.distress {
            background: #fee2e2;
            border: 2px solid #dc2626;
        }
        
        .score-number {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .score-card.no-stress .score-number {
            color: #059669;
        }
        
        .score-card.eustress .score-number {
            color: #2563eb;
        }
        
        .score-card.distress .score-number {
            color: #dc2626;
        }
        
        .score-label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .score-desc {
            font-size: 11px;
            color: #6b7280;
            font-style: italic;
        }
        
        .comparison {
            text-align: center;
            padding: 12px;
            background: #f3f4f6;
            border-radius: 6px;
            margin-bottom: 25px;
            font-size: 11px;
        }
        
        .comparison.increase {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .comparison.decrease {
            background: #d1fae5;
            color: #065f46;
        }
        
        .comparison.stable {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .analysis-text {
            font-size: 12px;
            line-height: 1.8;
            color: #4b5563;
            margin-bottom: 15px;
            text-align: justify;
        }
        
        .tip-box {
            padding: 12px;
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .tip-box strong {
            color: #92400e;
        }
        
        .tip-box p {
            font-size: 11px;
            color: #78350f;
            margin-top: 5px;
        }
        
        .recommendations {
            margin-top: 20px;
        }
        
        .rec-grid {
            display: table;
            width: 100%;
            border-spacing: 10px;
        }
        
        .rec-item {
            display: table-cell;
            width: 50%;
            padding: 12px;
            border-radius: 6px;
            vertical-align: top;
        }
        
        .rec-item.no-stress {
            background: #d1fae5;
            border: 1px solid #059669;
        }
        
        .rec-item.eustress {
            background: #dbeafe;
            border: 1px solid #2563eb;
        }
        
        .rec-item.distress {
            background: #fee2e2;
            border: 1px solid #dc2626;
        }
        
        .rec-title {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .rec-item.no-stress .rec-title {
            color: #065f46;
        }
        
        .rec-item.eustress .rec-title {
            color: #1e40af;
        }
        
        .rec-item.distress .rec-title {
            color: #991b1b;
        }
        
        .rec-desc {
            font-size: 10px;
            color: #4b5563;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
        
        .warning-box {
            padding: 12px;
            background: #fee2e2;
            border-left: 4px solid #dc2626;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .warning-box p {
            font-size: 11px;
            color: #991b1b;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>Laporan Hasil Analisis Stres</h1>
        <p>Insight Stress Mahasiswa</p>
    </div>

    {{-- User Info --}}
    <div class="user-info">
        <div class="user-info-row">
            <strong>Nama:</strong> {{ $user->name }}
        </div>
        @if($user->email)
        <div class="user-info-row">
            <strong>Email:</strong> {{ $user->email }}
        </div>
        @endif
        <div class="user-info-row">
            <strong>Tanggal Assessment:</strong> {{ $latest->created_at->format('d F Y, H:i') }} WIB
        </div>
    </div>

    {{-- Score Card --}}
    @php
        $category = $latest->stress_category ?? 'Unknown';
        $totalScore = $latest->total_score;
        $cardClass = $category === 'No Stress' ? 'no-stress' : ($category === 'Eustress' ? 'eustress' : 'distress');
        
        $categoryDescriptions = [
            "No Stress" => "You are currently experiencing minimal to no stress. Your mental state is balanced and healthy.",
            "Eustress" => "Eustress (Positive Stress) - Stress that motivates and enhances performance.",
            "Distress" => "Distress (Negative Stress) - Stress that causes anxiety and impairs well-being."
        ];
        
        $categoryDesc = $categoryDescriptions[$category] ?? "Unknown stress category.";
    @endphp
    
    <div class="score-card {{ $cardClass }}">
        <div class="score-number">{{ $totalScore }}</div>
        <div class="score-label">Skor Stres: {{ $category }}</div>
        <div class="score-desc">{{ $categoryDesc }}</div>
    </div>

    {{-- Comparison with Previous --}}
    @if($previous)
        @php
            $scoreDiff = $totalScore - $previous->total_score;
            $compClass = $scoreDiff > 0 ? 'increase' : ($scoreDiff < 0 ? 'decrease' : 'stable');
            
            if ($scoreDiff > 0) {
                $trendText = "📈 Meningkat " . abs($scoreDiff) . " poin dari assessment sebelumnya";
            } elseif ($scoreDiff < 0) {
                $trendText = "📉 Menurun " . abs($scoreDiff) . " poin dari assessment sebelumnya";
            } else {
                $trendText = "➡️ Stabil, tidak ada perubahan dari assessment sebelumnya";
            }
        @endphp
        
        <div class="comparison {{ $compClass }}">
            <strong>{{ $trendText }}</strong><br>
            Sebelumnya: {{ $previous->total_score }} → Sekarang: {{ $totalScore }}
        </div>
    @endif

    {{-- Analysis --}}
    <div class="section-title">Analisis Keseluruhan</div>
    
    <p class="analysis-text">
        Berdasarkan hasil assessment terakhir, tingkat stres Anda berada pada kategori <strong>{{ $category }}</strong>.
    </p>

    @if($previous)
        <p class="analysis-text">
            @if($scoreDiff > 0)
                Terjadi peningkatan skor stress sebesar {{ abs($scoreDiff) }} poin. Ini menunjukkan bahwa tingkat stress Anda meningkat sejak assessment terakhir.
            @elseif($scoreDiff < 0)
                Terjadi penurunan skor stress sebesar {{ abs($scoreDiff) }} poin. Ini adalah tanda positif bahwa kondisi mental Anda membaik!
            @else
                Skor stress Anda stabil, tidak ada perubahan signifikan dari assessment sebelumnya.
            @endif
        </p>

        <div class="tip-box">
            <strong>💡 Tips:</strong>
            <p>
                @if($scoreDiff > 0)
                    Luangkan waktu untuk istirahat, lakukan aktivitas yang menenangkan seperti meditasi atau jalan-jalan ringan, 
                    dan pertimbangkan untuk mengurangi beban kerja atau tugas yang tidak mendesak.
                @elseif($scoreDiff < 0)
                    Pertahankan pola hidup sehat yang sudah Anda jalani. Terus lakukan aktivitas positif yang membantu mengurangi stress, 
                    seperti olahraga teratur, tidur cukup, dan menjaga hubungan sosial yang baik.
                @else
                    Kondisi stabil adalah hal yang baik. Terus monitor kondisi mental Anda secara berkala dan jaga keseimbangan 
                    antara aktivitas dan istirahat.
                @endif
            </p>
        </div>
    @endif

    @if($category === "Distress")
        <div class="warning-box">
            <p>
                <strong>⚠️ Perhatian:</strong> Tingkat stress Anda cukup tinggi. Jika kondisi ini berlanjut, 
                pertimbangkan untuk berkonsultasi dengan profesional kesehatan mental atau konselor.
            </p>
        </div>
    @endif

    {{-- Recommendations --}}
    <div class="section-title">Rekomendasi Personal</div>
    
    <div class="recommendations">
        @if($category === "No Stress")
            <div class="rec-grid">
                <div class="rec-item no-stress">
                    <div class="rec-title">Pertahankan Keseimbangan</div>
                    <div class="rec-desc">Anda dalam kondisi stabil. Pertahankan pola hidup sehat.</div>
                </div>
                <div class="rec-item no-stress">
                    <div class="rec-title">Aktivitas Positif</div>
                    <div class="rec-desc">Tetap lakukan olahraga dan interaksi sosial.</div>
                </div>
            </div>
            
        @elseif($category === "Eustress")
            <div class="rec-grid">
                <div class="rec-item eustress">
                    <div class="rec-title">Kelola Energi Positif</div>
                    <div class="rec-desc">Eustress bagus, tetapi jangan sampai berlebihan.</div>
                </div>
                <div class="rec-item eustress">
                    <div class="rec-title">Tetap Seimbang</div>
                    <div class="rec-desc">Istirahat cukup agar tidak berubah menjadi distress.</div>
                </div>
            </div>
            
        @else
            <div class="rec-grid">
                <div class="rec-item distress">
                    <div class="rec-title">Kurangi Beban</div>
                    <div class="rec-desc">Ambil waktu untuk diri sendiri dan kurangi tekanan mental.</div>
                </div>
                <div class="rec-item distress">
                    <div class="rec-title">Cari Dukungan</div>
                    <div class="rec-desc">Pertimbangkan berbicara dengan teman dekat atau konselor.</div>
                </div>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem Insight Stress Mahasiswa</p>
        <p>Tanggal cetak: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

</body>
</html>
