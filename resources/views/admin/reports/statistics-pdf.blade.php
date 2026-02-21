<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Statistik Stress Mahasiswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            color: #1e293b;
            line-height: 1.6;
            padding: 30px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #14b8a6;
        }
        
        .header h1 {
            font-size: 24px;
            color: #0f172a;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            color: #64748b;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
        }
        
        .section-title::before {
            content: "■";
            color: #14b8a6;
            margin-right: 8px;
            font-size: 14px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
        }
        
        .stat-label {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 3px;
        }
        
        .stat-change {
            font-size: 10px;
        }
        
        .stat-change.positive {
            color: #14b8a6;
        }
        
        .stat-change.negative {
            color: #ef4444;
        }
        
        .stat-change.neutral {
            color: #64748b;
        }
        
        .factor-list {
            list-style: none;
        }
        
        .factor-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .factor-item:last-child {
            border-bottom: none;
        }
        
        .factor-name {
            display: flex;
            align-items: center;
            font-size: 12px;
        }
        
        .factor-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .factor-value {
            font-weight: bold;
            font-size: 12px;
        }
        
        .jurusan-item {
            margin-bottom: 15px;
        }
        
        .jurusan-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .jurusan-name {
            font-weight: 600;
            color: #0f172a;
        }
        
        .jurusan-info {
            color: #64748b;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: #14b8a6;
            border-radius: 4px;
        }
        
        .semester-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        
        .semester-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
        }
        
        .semester-label {
            font-size: 10px;
            color: #64748b;
            margin-bottom: 3px;
        }
        
        .semester-value {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 10px;
            color: #64748b;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>LAPORAN STATISTIK STRESS MAHASISWA</h1>
        <p>Insight Stress Mahasiswa - {{ now()->format('F Y') }}</p>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="section">
        <div class="section-title">Ringkasan Statistik</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Rata-rata Stress</div>
                <div class="stat-value">{{ $avgStressPercentage }}%</div>
                <div class="stat-change negative">-5% dari bulan lalu</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Assessment Bulan Ini</div>
                <div class="stat-value">{{ $monthlyAssessments }}</div>
                <div class="stat-change positive">+12% dari bulan lalu</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Mahasiswa Aktif</div>
                <div class="stat-value">{{ number_format($activeStudents) }}</div>
                <div class="stat-change positive">+8% dari bulan lalu</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Stress Tinggi</div>
                <div class="stat-value">{{ $highStressCount }}</div>
                <div class="stat-change neutral">Tidak ada perubahan</div>
            </div>
        </div>
    </div>

    <!-- Faktor Penyebab Stress -->
    <div class="section">
        <div class="section-title">Faktor Penyebab Stress</div>
        <ul class="factor-list">
            <li class="factor-item">
                <div class="factor-name">
                    <span class="factor-dot" style="background: #ef4444;"></span>
                    Tugas & Deadline
                </div>
                <div class="factor-value">35%</div>
            </li>
            <li class="factor-item">
                <div class="factor-name">
                    <span class="factor-dot" style="background: #f97316;"></span>
                    Ujian
                </div>
                <div class="factor-value">25%</div>
            </li>
            <li class="factor-item">
                <div class="factor-name">
                    <span class="factor-dot" style="background: #3b82f6;"></span>
                    Keuangan
                </div>
                <div class="factor-value">20%</div>
            </li>
            <li class="factor-item">
                <div class="factor-name">
                    <span class="factor-dot" style="background: #10b981;"></span>
                    Hubungan Sosial
                </div>
                <div class="factor-value">12%</div>
            </li>
            <li class="factor-item">
                <div class="factor-name">
                    <span class="factor-dot" style="background: #8b5cf6;"></span>
                    Lainnya
                </div>
                <div class="factor-value">8%</div>
            </li>
        </ul>
    </div>

    <!-- Analisis per Jurusan -->
    <div class="section">
        <div class="section-title">Analisis per Jurusan</div>
        @foreach($jurusanStats as $stat)
            <div class="jurusan-item">
                <div class="jurusan-header">
                    <span class="jurusan-name">{{ $stat['jurusan'] }}</span>
                    <span class="jurusan-info">{{ $stat['count'] }} mahasiswa - {{ $stat['avg_stress'] }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $stat['avg_stress'] }}%;"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Rata-rata Stress per Semester -->
    <div class="section">
        <div class="section-title">Rata-rata Stress per Semester</div>
        <div class="semester-grid">
            @for($i = 0; $i < 8; $i++)
                <div class="semester-card">
                    <div class="semester-label">Semester {{ $i + 1 }}</div>
                    <div class="semester-value">{{ $semesterData[$i] }}%</div>
                </div>
            @endfor
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Diekspor pada: {{ now()->format('l, d F Y') }} pukul {{ now()->format('H:i') }}</p>
        <p>© {{ now()->year }} Insight Stress Mahasiswa - Sistem Monitoring Stress Mahasiswa</p>
    </div>

</body>
</html>
