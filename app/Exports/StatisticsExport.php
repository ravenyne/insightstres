<?php

namespace App\Exports;

use App\Models\User;
use App\Models\StressAssessment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StatisticsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new RingkasanSheet(),
            new JurusanSheet(),
            new SemesterSheet(),
        ];
    }
}

class RingkasanSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        $avgScore = StressAssessment::avg('numeric_score') ?? 0;
        $avgStressPercentage = round(($avgScore / 2) * 100);
        
        $monthlyAssessments = StressAssessment::whereYear('created_at', now()->year)
                                            ->whereMonth('created_at', now()->month)
                                            ->count();
        
        $activeStudents = User::has('assessments')->count();
        $highStressCount = StressAssessment::where('numeric_score', '=', 2)->count();
        
        $noStressCount = StressAssessment::where('numeric_score', '=', 0)->count();
        $eustressCount = StressAssessment::where('numeric_score', '=', 1)->count();
        $distressCount = StressAssessment::where('numeric_score', '=', 2)->count();
        
        return collect([
            ['Rata-rata Stress', $avgStressPercentage . '%'],
            ['Assessment Bulan Ini', $monthlyAssessments],
            ['Mahasiswa Aktif', $activeStudents],
            ['Stress Tinggi (Distress)', $highStressCount],
            [''],
            ['Distribusi Stress', ''],
            ['No Stress', $noStressCount],
            ['Eustress', $eustressCount],
            ['Distress', $distressCount],
        ]);
    }
    
    public function headings(): array
    {
        return ['Kategori', 'Nilai'];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '14b8a6']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }
    
    public function title(): string
    {
        return 'Ringkasan Statistik';
    }
}

class JurusanSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        // Refactored to avoid GROUP BY SQL error
        $usersRaw = User::select('id', 'jurusan')
            ->withAvg('assessments as avg_stress_raw', 'numeric_score')
            ->get();

        $jurusanStats = $usersRaw->groupBy('jurusan')
            ->map(function ($group, $jurusan) {
                // Filter users who have at least one assessment
                $activeUsers = $group->whereNotNull('avg_stress_raw');
                $count = $activeUsers->count();

                if ($count === 0) return null;

                // Calculate average of the students' averages
                $avgStress = $activeUsers->avg('avg_stress_raw');

                return [
                    'jurusan' => $jurusan ?? 'Tidak Diketahui',
                    'count' => $count,
                    'avg_stress' => round($avgStress * 50) . '%'
                ];
            })
            ->filter()
            ->values();
        
        return $jurusanStats;
    }
    
    public function headings(): array
    {
        return ['Jurusan', 'Jumlah Mahasiswa', 'Rata-rata Stress'];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '14b8a6']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }
    
    public function title(): string
    {
        return 'Analisis per Jurusan';
    }
}

class SemesterSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function collection()
    {
        $data = collect();
        
        for ($i = 1; $i <= 8; $i++) {
            $avg = StressAssessment::whereHas('user', function($query) use ($i) {
                $query->where('semester', $i);
            })->avg('numeric_score');
            
            $avgPercentage = round(($avg ?? 0) * 50);
            $count = User::where('semester', $i)->has('assessments')->count();
            
            $data->push([
                'semester' => 'Semester ' . $i,
                'count' => $count,
                'avg_stress' => $avgPercentage . '%'
            ]);
        }
        
        return $data;
    }
    
    public function headings(): array
    {
        return ['Semester', 'Jumlah Mahasiswa', 'Rata-rata Stress'];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '14b8a6']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }
    
    public function title(): string
    {
        return 'Rata-rata per Semester';
    }
}
