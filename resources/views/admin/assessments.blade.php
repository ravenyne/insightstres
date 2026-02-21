<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik & Laporan - Insight Stress</title>
    @vite('resources/css/app.css')
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            background: #0f172a;
        }
    </style>
</head>
<body class="bg-slate-900 text-white">

    <div class="flex min-h-screen">
        
        <!-- Sidebar - FIXED -->
        @include('admin.partials.sidebar')

        {{-- Mobile Overlay --}}
        <div id="admin-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>
        
        <!-- Main Content - with margin for fixed sidebar -->
        <main class="flex-1 overflow-y-auto lg:ml-64">
            
            {{-- Mobile Header with Hamburger --}}
            <header class="lg:hidden bg-slate-800/30 border-b border-slate-700 px-4 py-3 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button id="admin-mobile-menu-button" class="p-2 rounded-lg hover:bg-slate-700/50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-orange-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-white">Admin Panel</span>
                    </div>
                </div>
            </header>
            
            <!-- Header (Desktop) -->
            <header class="hidden lg:block bg-slate-800/30 border-b border-slate-700 px-4 lg:px-8 py-4 lg:py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold">Statistik & Laporan</h1>
                        <p class="text-slate-400 mt-1 text-sm lg:text-base">Analisis data stress mahasiswa</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.assessments.export.excel') }}" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            CSV
                        </a>
                        <button onclick="openPdfModal()" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            PDF
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-4 lg:p-8 space-y-6">

                <!-- Mobile Action Buttons -->
                <div class="lg:hidden flex flex-col gap-3 mb-6">
                    <a href="{{ route('admin.assessments.export.excel') }}" class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export CSV
                    </a>
                    <button onclick="openPdfModal()" class="w-full px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Rata-rata Stress -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <p class="text-slate-400 text-sm mb-2">Rata-rata Stress</p>
                        <div class="flex items-end justify-between">
                            <p class="text-4xl font-bold">{{ $avgStressPercentage }}%</p>
                            <div class="flex items-center gap-1 text-green-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span>5%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Assessment Bulan Ini -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <p class="text-slate-400 text-sm mb-2">Assessment Bulan Ini</p>
                        <div class="flex items-end justify-between">
                            <p class="text-4xl font-bold">{{ $monthlyAssessments }}</p>
                            <div class="flex items-center gap-1 text-green-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span>12%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Mahasiswa Aktif -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <p class="text-slate-400 text-sm mb-2">Mahasiswa Aktif</p>
                        <div class="flex items-end justify-between">
                            <p class="text-4xl font-bold">{{ number_format($activeStudents) }}</p>
                            <div class="flex items-center gap-1 text-green-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span>8%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stress Tinggi -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <p class="text-slate-400 text-sm mb-2">Stress Tinggi</p>
                        <div class="flex items-end justify-between">
                            <p class="text-4xl font-bold">{{ $highStressCount }}</p>
                            <div class="flex items-center gap-1 text-slate-400 text-sm">
                                <span>--</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tren Distribusi Stress Bulanan -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                    <h3 class="text-lg font-bold mb-6">Tren Distribusi Stress Bulanan</h3>
                    <div style="height: 400px;">
                        <canvas id="stressDistributionChart"></canvas>
                    </div>
                </div>

                <!-- Rata-rata Stress per Semester & Faktor Penyebab Stress -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Rata-rata Stress per Semester -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <h3 class="text-lg font-bold mb-6">Rata-rata Stress per Semester</h3>
                        <div style="height: 300px;">
                            <canvas id="semesterChart"></canvas>
                        </div>
                    </div>

                    <!-- Faktor Penyebab Stress -->
                    <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                        <h3 class="text-lg font-bold mb-6">Faktor Penyebab Stress</h3>
                        <div class="flex items-center justify-center" style="height: 300px;">
                            <canvas id="factorChart"></canvas>
                        </div>
                    </div>

                </div>

                <!-- Analisis per Jurusan -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-2xl p-6">
                    <h3 class="text-lg font-bold mb-6">Analisis per Jurusan</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700">
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">Jurusan</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">Jumlah Mahasiswa</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">Rata-rata Stress</th>
                                    <th class="text-left py-3 px-4 text-slate-400 font-medium text-sm">Visualisasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jurusanStats as $stat)
                                    <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition">
                                        <td class="py-4 px-4 font-medium">{{ $stat['jurusan'] }}</td>
                                        <td class="py-4 px-4 text-slate-400">{{ $stat['count'] }}</td>
                                        <td class="py-4 px-4 text-slate-400">{{ $stat['avg_stress'] }}%</td>
                                        <td class="py-4 px-4">
                                            <div class="w-full bg-slate-700 rounded-full h-2">
                                                <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $stat['avg_stress'] }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>

    </div>

    <script>
        // Tren Distribusi Stress Bulanan (Stacked Area Chart)
        const distributionCtx = document.getElementById('stressDistributionChart').getContext('2d');
        new Chart(distributionCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($monthlyDistribution, 'month')) !!},
                datasets: [
                    {
                        label: 'No Stress',
                        data: {!! json_encode(array_column($monthlyDistribution, 'no_stress')) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.6)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Eustress',
                        data: {!! json_encode(array_column($monthlyDistribution, 'eustress')) !!},
                        backgroundColor: 'rgba(249, 115, 22, 0.6)',
                        borderColor: 'rgba(249, 115, 22, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Distress',
                        data: {!! json_encode(array_column($monthlyDistribution, 'distress')) !!},
                        backgroundColor: 'rgba(239, 68, 68, 0.6)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#94a3b8',
                            usePointStyle: true,
                            padding: 15
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 12
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    }
                }
            }
        });

        // Rata-rata Stress per Semester (Bar Chart)
        const semesterCtx = document.getElementById('semesterChart').getContext('2d');
        new Chart(semesterCtx, {
            type: 'bar',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7', '8'],
                datasets: [{
                    label: 'Rata-rata Stress',
                    data: {!! json_encode($semesterData) !!},
                    backgroundColor: '#f97316',
                    borderRadius: 8,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return 'Stress: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    }
                }
            }
        });

        // Faktor Penyebab Stress (Pie Chart)
        const factorCtx = document.getElementById('factorChart').getContext('2d');
        new Chart(factorCtx, {
            type: 'doughnut',
            data: {
                labels: ['Akademik', 'Fisik & Kesehatan', 'Emosional', 'Sosial', 'Lingkungan'],
                datasets: [{
                    data: {!! json_encode($factorData) !!},
                    backgroundColor: [
                        '#ef4444',
                        '#f97316',
                        '#3b82f6',
                        '#10b981',
                        '#8b5cf6'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#94a3b8',
                            usePointStyle: true,
                            padding: 15
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.parsed / total) * 100);
                                return context.label + ': ' + percentage + '%';
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    </script>

    <!-- Modal PDF Preview -->
    <div id="pdfModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-3xl w-full shadow-2xl max-h-[90vh] overflow-hidden flex flex-col">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Export Laporan Statistik</h3>
                        <p class="text-sm text-slate-500">Preview dokumen PDF laporan statistik stress mahasiswa sebelum mengunduh.</p>
                    </div>
                </div>
                <button onclick="closePdfModal()" class="p-2 hover:bg-slate-100 rounded-lg transition">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body - Preview -->
            <div class="flex-1 overflow-y-auto p-8 bg-slate-50">
                <div class="bg-white border-2 border-dashed border-slate-300 rounded-xl p-8">
                    
                    <div class="text-center mb-6 pb-6 border-b border-slate-200">
                        <p class="text-xs text-teal-600 font-semibold mb-2">PREVIEW DOKUMEN</p>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">LAPORAN STATISTIK STRESS MAHASISWA</h2>
                        <p class="text-sm text-slate-600">Insight Stress Mahasiswa - {{ now()->format('F Y') }}</p>
                    </div>

                    <!-- Ringkasan Statistik -->
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-slate-900">Ringkasan Statistik</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-600 mb-1">Rata-rata Stress</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $avgStressPercentage }}%</p>
                                <p class="text-xs text-red-600 mt-1">-5% dari bulan lalu</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-600 mb-1">Assessment Bulan Ini</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $monthlyAssessments }}</p>
                                <p class="text-xs text-teal-600 mt-1">+12% dari bulan lalu</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-600 mb-1">Mahasiswa Aktif</p>
                                <p class="text-2xl font-bold text-slate-900">{{ number_format($activeStudents) }}</p>
                                <p class="text-xs text-teal-600 mt-1">+8% dari bulan lalu</p>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                <p class="text-xs text-slate-600 mb-1">Stress Tinggi</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $highStressCount }}</p>
                                <p class="text-xs text-slate-600 mt-1">Tidak ada perubahan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Faktor Penyebab Stress -->
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-slate-900">Faktor Penyebab Stress</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <span class="text-slate-700">Akademik</span>
                                </div>
                                <span class="font-semibold text-slate-900">35%</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                                    <span class="text-slate-700">Fisik & Kesehatan</span>
                                </div>
                                <span class="font-semibold text-slate-900">25%</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-slate-700">Emosional</span>
                                </div>
                                <span class="font-semibold text-slate-900">20%</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="text-slate-700">Sosial</span>
                                </div>
                                <span class="font-semibold text-slate-900">12%</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                    <span class="text-slate-700">Lingkungan</span>
                                </div>
                                <span class="font-semibold text-slate-900">8%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Analisis per Jurusan -->
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-slate-900">Analisis per Jurusan</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach($jurusanStats->take(4) as $stat)
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-medium text-slate-900">{{ $stat['jurusan'] }}</span>
                                            <span class="text-slate-600">{{ $stat['count'] }} mahasiswa - {{ $stat['avg_stress'] }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2">
                                            <div class="bg-teal-500 h-2 rounded-full" style="width: {{ $stat['avg_stress'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Rata-rata Stress per Semester -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <h3 class="text-lg font-bold text-slate-900">Rata-rata Stress per Semester</h3>
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            @for($i = 0; $i < 8; $i++)
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 text-center">
                                    <p class="text-xs text-slate-600 mb-1">Sem {{ $i + 1 }}</p>
                                    <p class="text-lg font-bold text-slate-900">{{ $semesterData[$i] }}%</p>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 pt-4 border-t border-slate-200 text-center">
                        <p class="text-xs text-slate-500">Diekspor pada: {{ now()->format('l, d F Y') }} pukul {{ now()->format('H:i') }}</p>
                    </div>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-slate-200 bg-white">
                <button onclick="closePdfModal()" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg transition">
                    Batal
                </button>
                <a href="{{ route('admin.assessments.export.pdf') }}" class="px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Unduh PDF
                </a>
            </div>

        </div>
    </div>

    <script>
        function openPdfModal() {
            document.getElementById('pdfModal').classList.remove('hidden');
        }

        function closePdfModal() {
            document.getElementById('pdfModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('pdfModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePdfModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePdfModal();
            }
        });
    </script>


    <script>
        // Admin sidebar toggle functionality
        const adminMobileMenuButton = document.getElementById('admin-mobile-menu-button');
        const adminSidebar = document.getElementById('admin-sidebar');
        const adminSidebarOverlay = document.getElementById('admin-sidebar-overlay');
        const adminSidebarClose = document.getElementById('admin-sidebar-close');

        function openAdminSidebar() {
            adminSidebar.classList.remove('-translate-x-full');
            adminSidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAdminSidebar() {
            adminSidebar.classList.add('-translate-x-full');
            adminSidebarOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        adminMobileMenuButton?.addEventListener('click', openAdminSidebar);
        adminSidebarClose?.addEventListener('click', closeAdminSidebar);
        adminSidebarOverlay?.addEventListener('click', closeAdminSidebar);
    </script>

</body>
</html>
