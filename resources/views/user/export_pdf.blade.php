<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Assessment</title>
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
            display: flex;
            gap: 30px;
            margin-bottom: 5px;
        }
        
        .user-info-item {
            font-size: 13px;
        }
        
        .user-info-item strong {
            color: #14b8a6;
            margin-right: 5px;
        }
        
        .statistics {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-spacing: 10px;
        }
        
        .stat-card {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
        }
        
        .stat-card.total {
            background: #e5e7eb;
        }
        
        .stat-card.lowest {
            background: #d1fae5;
        }
        
        .stat-card.highest {
            background: #fee2e2;
        }
        
        .stat-label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: bold;
        }
        
        .stat-card.total .stat-value {
            color: #1f2937;
        }
        
        .stat-card.lowest .stat-value {
            color: #059669;
        }
        
        .stat-card.highest .stat-value {
            color: #dc2626;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .assessment-list {
            margin-top: 10px;
        }
        
        .assessment-item {
            display: table;
            width: 100%;
            padding: 12px;
            margin-bottom: 8px;
            background: #f9fafb;
            border-radius: 6px;
            border-left: 3px solid #14b8a6;
        }
        
        .assessment-row {
            display: table-row;
        }
        
        .assessment-date {
            display: table-cell;
            width: 30%;
            font-size: 12px;
            color: #1f2937;
            font-weight: 500;
        }
        
        .assessment-category {
            display: table-cell;
            width: 40%;
            font-size: 11px;
            color: #6b7280;
        }
        
        .assessment-score {
            display: table-cell;
            width: 15%;
            text-align: center;
            font-size: 11px;
        }
        
        .assessment-badge {
            display: table-cell;
            width: 15%;
            text-align: right;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }
        
        .badge-low {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-medium {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .badge-high {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>Laporan Riwayat Assessment</h1>
        <p>Insight Stress Mahasiswa</p>
    </div>

    {{-- User Info --}}
    <div class="user-info">
        <div class="user-info-row">
            <div class="user-info-item">
                <strong>Nama:</strong> {{ $user->name }}
            </div>
            <div class="user-info-item">
                <strong>Total Assessment:</strong> {{ $assessments->count() }} Assessment
            </div>
        </div>
        @if($user->email)
        <div class="user-info-row">
            <div class="user-info-item">
                <strong>Email:</strong> {{ $user->email }}
            </div>
        </div>
        @endif
    </div>

    {{-- Statistics --}}
    @php
        $totalAssessments = $assessments->count();
        $lowestScore = null;
        $highestScore = null;
        
        if ($totalAssessments > 0) {
            $scores = $assessments->map(function($assessment) {
                return $assessment->total_score;
            });
            
            $lowestScore = $scores->min();
            $highestScore = $scores->max();
        }
    @endphp
    
    <div class="statistics">
        <div class="stat-card total">
            <div class="stat-label">Total</div>
            <div class="stat-value">{{ $totalAssessments }}</div>
        </div>
        <div class="stat-card lowest">
            <div class="stat-label">Terendah</div>
            <div class="stat-value">{{ $lowestScore ?? '-' }}</div>
        </div>
        <div class="stat-card highest">
            <div class="stat-label">Tertinggi</div>
            <div class="stat-value">{{ $highestScore ?? '-' }}</div>
        </div>
    </div>

    {{-- Assessment List --}}
    <div class="section-title">Riwayat Assessment:</div>
    
    <div class="assessment-list">
        @foreach ($assessments as $assessment)
            @php
                $score = $assessment->total_score;
                $category = $assessment->stress_category ?? 'Unknown';
                
                // Determine badge based on category and score
                if ($category === 'No Stress' || $score < 30) {
                    $badgeClass = 'badge-low';
                    $badgeText = 'Rendah-Sedang';
                } elseif ($category === 'Eustress' || $score < 60) {
                    $badgeClass = 'badge-medium';
                    $badgeText = 'Sedang';
                } else {
                    $badgeClass = 'badge-high';
                    $badgeText = 'Tinggi';
                }
            @endphp
            
            <div class="assessment-item">
                <div class="assessment-row">
                    <div class="assessment-date">
                        {{ $assessment->created_at->format('d F Y, H:i') }}
                    </div>
                    <div class="assessment-category">
                        {{ $category }}
                    </div>
                    <div class="assessment-score">
                        <strong>Skor: {{ $score }}</strong>
                    </div>
                    <div class="assessment-badge">
                        <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                    </div>
                </div>
            </div>
            
            {{-- Page break after every 15 assessments --}}
            @if($loop->iteration % 15 === 0 && !$loop->last)
                <div class="page-break"></div>
                <div class="section-title">Riwayat Assessment (lanjutan):</div>
            @endif
        @endforeach
        
        @if($assessments->count() === 0)
            <div style="text-align: center; padding: 30px; color: #9ca3af;">
                Belum ada data assessment
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