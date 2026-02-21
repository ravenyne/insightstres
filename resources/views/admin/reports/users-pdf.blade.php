<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Mahasiswa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            text-transform: uppercase;
            color: #0f172a;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #64748b;
        }
        .header-line {
            margin-top: 15px;
            border-bottom: 1px solid #cbd5e1;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }

        /* Section Titles */
        h3 {
            font-size: 14px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 15px;
            margin-top: 30px;
        }

        /* Stats Cards */
        .stats-container {
            width: 100%;
            margin-bottom: 10px;
            /* Use table for layout as dompdf has partial flex support */
            display: table;
            border-collapse: separate;
            border-spacing: 10px 0;
        }
        .stat-card {
            display: table-cell;
            width: 23%; /* 4 cards */
            padding: 20px 10px;
            border-radius: 8px;
            text-align: center;
            vertical-align: middle;
        }
        
        .card-blue { background-color: #eff6ff; border: 1px solid #dbeafe; }
        .card-green { background-color: #f0fdf4; border: 1px solid #dcfce7; }
        .card-orange { background-color: #fff7ed; border: 1px solid #ffedd5; }
        .card-red { background-color: #fef2f2; border: 1px solid #fee2e2; }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            display: block;
            margin-bottom: 5px;
            line-height: 1;
        }
        .stat-label {
            font-size: 11px;
            color: #64748b;
            text-transform: capitalize;
        }

        .text-blue { color: #2563eb; }
        .text-green { color: #16a34a; }
        .text-orange { color: #ea580c; }
        .text-red { color: #dc2626; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
        }
        th {
            background-color: #2563eb; /* Blue Header */
            color: #ffffff;
            font-weight: 600;
            padding: 12px 10px;
            text-align: left;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }
        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: middle;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        /* Badges */
        .badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-green { background-color: #dcfce7; color: #15803d; }
        .badge-orange { background-color: #ffedd5; color: #c2410c; }
        .badge-red { background-color: #fee2e2; color: #b91c1c; }
        .badge-gray { background-color: #f1f5f9; color: #64748b; }

        /* Footer */
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            font-style: italic;
        }
    </style>
</head>
<body>
    
    <div class="header">
        <h1>LAPORAN DATA MAHASISWA</h1>
        <p>Insight Stress Mahasiswa</p>
        <p>Tanggal: {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
        <div class="header-line"></div>
    </div>

    <h3>Ringkasan Statistik</h3>
    <div class="stats-container">
        <!-- Total -->
        <div class="stat-card card-blue">
            <span class="stat-value text-blue">{{ $stats['total'] }}</span>
            <span class="stat-label">Total Mahasiswa</span>
        </div>
        
        <!-- Rendah -->
        <div class="stat-card card-green">
            <span class="stat-value text-green">{{ $stats['low'] }}</span>
            <span class="stat-label">Stress Rendah</span>
        </div>

        <!-- Sedang -->
        <div class="stat-card card-orange">
            <span class="stat-value text-orange">{{ $stats['medium'] }}</span>
            <span class="stat-label">Stress Sedang</span>
        </div>

        <!-- Tinggi -->
        <div class="stat-card card-red">
            <span class="stat-value text-red">{{ $stats['high'] }}</span>
            <span class="stat-label">Stress Tinggi</span>
        </div>
    </div>

    <h3>Daftar Mahasiswa</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 25%;">Nama</th>
                <th style="width: 15%;">NIM</th>
                <th style="width: 20%;">Jurusan</th>
                <th style="width: 10%; text-align: center;">Smt</th>
                <th style="width: 10%; text-align: center;">Asm</th>
                <th style="width: 15%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        <span style="font-weight: 600; color: #0f172a;">{{ $user->name }}</span>
                    </td>
                    <td>{{ $user->nim ?? '-' }}</td>
                    <td>{{ $user->jurusan ?? '-' }}</td>
                    <td style="text-align: center;">{{ $user->semester ?? '-' }}</td>
                    <td style="text-align: center;">{{ $user->assessments_count ?? 0 }}</td>
                    <td style="text-align: center;">
                        @if($user->latest_assessment)
                            @php
                                $score = $user->latest_assessment->numeric_score;
                                $badgeClass = 'badge-gray';
                                $text = '-';
                                
                                if ($score === 0) {
                                    $badgeClass = 'badge-green';
                                    $text = 'Rendah';
                                } elseif ($score === 1) {
                                    $badgeClass = 'badge-orange';
                                    $text = 'Sedang';
                                } elseif ($score === 2) {
                                    $badgeClass = 'badge-red';
                                    $text = 'Tinggi';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $text }}</span>
                        @else
                            <span class="badge badge-gray">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">Data mahasiswa tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini digenerate oleh sistem Insight Stress Mahasiswa | {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
