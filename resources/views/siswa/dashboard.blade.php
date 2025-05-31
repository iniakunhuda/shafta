<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('siswa.dashboard') }}" class="text-main-600 fw-normal text-15">Home</a></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Dashboard Siswa
    </x-slot>

    <main>
        <div class="dashboard-body">
            <!-- Greeting Box Start -->
            <div class="card mb-24">
                <div class="card-body grettings-box-two position-relative z-1 p-0">
                    <div class="row align-items-center h-100">
                        <div class="col-lg-8">
                            <div class="grettings-box-two__content">
                                <h2 class="fw-medium mb-0 flex-align gap-10">Selamat Datang, {{ Auth::user()->siswa->nama ?? Auth::user()->name }} <img src="{{ asset('assets/images/icons/wave-hand.png') }}" alt=""> </h2>
                                <h4 class="fw-medium mb-16">Pantau nilai dan perkembangan akademik di semester ini!</h4>
                                <p class="text-15 text-gray-400">Tahun Ajaran {{ $tahunAjaran->nama }}</p>
                                <a href="{{ route('siswa.raport.index') }}" class="btn btn-main rounded-pill mt-32">Lihat Detail Raport</a>
                            </div>
                        </div>
                        <div class="col-lg-4 d-md-block d-none mt-auto">
                            <img src="{{ asset('assets/images/thumbs/gretting-thumb.png') }}" alt="">
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/bg/star-shape.png') }}" class="position-absolute start-0 top-0 w-100 h-100 z-n1 object-fit-contain" alt="">
                </div>
            </div>
            <!-- Greeting Box End -->

            <!-- Performance Summary Start -->
            <div class="row gy-4 mb-24">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ number_format($currentPerformance->rata_umum, 1) }}</h4>
                            <span class="text-gray-600">Rata-rata Nilai Akademik</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-600 text-white text-2xl"><i class="ph-fill ph-book-open"></i></span>
                                <div id="academic-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ number_format($currentPerformance->rata_keshaftaan, 1) }}</h4>
                            <span class="text-gray-600">Rata-rata Nilai Keshaftaan</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-two-600 text-white text-2xl"><i class="ph-fill ph-certificate"></i></span>
                                <div id="keshaftaan-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $currentPerformance->predikat }}</h4>
                            <span class="text-gray-600">Predikat Sikap</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-purple-600 text-white text-2xl"> <i class="ph-fill ph-star"></i></span>
                                <div id="attitude-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $currentPerformance->peringkat }}</h4>
                            <span class="text-gray-600">Peringkat Kelas</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-warning-600 text-white text-2xl"><i class="ph-fill ph-trophy"></i></span>
                                <div id="rank-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Performance Summary End -->

            <!-- Main Content Sections Start -->
            <div class="row gy-4">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Semester Progress Card Start -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom border-gray-100">
                            <h5 class="mb-0">Perkembangan Nilai per Tahun Ajaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-20 flex-between flex-wrap gap-8">
                                <div class="flex-align gap-16 flex-wrap">
                                    <div class="flex-align flex-wrap gap-16">
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="w-8 h-8 rounded-circle bg-main-600"></span>
                                            <span class="text-13 text-gray-600">Nilai Umum</span>
                                        </div>
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="w-8 h-8 rounded-circle bg-main-two-600"></span>
                                            <span class="text-13 text-gray-600">Nilai Keshaftaan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="semesterProgressChart" class="tooltip-style y-value-left"></div>
                        </div>
                    </div>
                    <!-- Semester Progress Card End -->

                    <!-- Recent Grades Card Start -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom border-gray-100">
                            <div class="mb-0 flex-between flex-wrap gap-8">
                                <h5 class="mb-0">Nilai Terbaru</h5>
                                <a href="{{ route('siswa.nilai') }}" class="text-13 fw-medium text-main-600 hover-text-decoration-underline">Lihat Semua</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table style-two mb-0">
                                    <thead>
                                        <tr>
                                            <th>Mata Pelajaran</th>
                                            <th>Nilai</th>
                                            <th>Kategori</th>
                                            <th>Tanggal</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($nilai as $n)
                                        <tr>
                                            <td>
                                                <div class="flex-align gap-8">
                                                    <div class="w-40 h-40 rounded-circle {{ $n->pelajaran->kategori === 'umum' ? 'bg-main-600' : 'bg-main-two-600' }} flex-center flex-shrink-0">
                                                        <img src="{{ asset('assets/images/icons/course-name-icon1.png') }}" alt="">
                                                    </div>
                                                    <div class="">
                                                        <h6 class="mb-0">{{ $n->pelajaran->judul }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex-align gap-8">
                                                    @php
                                                        $badgeClass = '';
                                                        if ($n->nilai >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                                        elseif ($n->nilai >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                                        elseif ($n->nilai >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                                        else $badgeClass = 'bg-danger-50 text-danger-600';
                                                    @endphp
                                                    <span class="text-13 py-2 px-8 {{ $badgeClass }} d-inline-flex align-items-center rounded-pill fw-bold">
                                                        {{ $n->nilai }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-gray-600">{{ ucfirst($n->pelajaran->kategori) }}</span>
                                            </td>
                                            <td>
                                                <span class="text-gray-600">{{ $n->created_at->format('d M Y') }}</span>
                                            </td>
                                            <td>
                                                <div class="flex-align justify-content-center gap-16">
                                                    <a href="{{ route('siswa.nilai.detail', $n->id) }}" class="text-gray-900 hover-text-main-600 text-md d-flex">
                                                        <i class="ph ph-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="text-gray-600">
                                                    <i class="ph ph-info me-2"></i> Tidak ada data nilai
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Recent Grades Card End -->

                    <!-- Hafalan Progress Card Start -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom border-gray-100">
                            <div class="mb-0 flex-between flex-wrap gap-8">
                                <h5 class="mb-0">Progres Hafalan</h5>
                                <a href="#" class="text-13 fw-medium text-main-600 hover-text-decoration-underline">Lihat Detail</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div id="hafalanDonutChart"></div>
                                </div>
                                <div class="col-md-7">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Surah/Ayat</th>
                                                    <th>Status</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($hafalan ?? [] as $h)
                                                <tr>
                                                    <td>{{ $h->surah }}</td>
                                                    <td>
                                                        @if($h->status == 'Selesai')
                                                            <span class="badge bg-success-50 text-success-600">{{ $h->status }}</span>
                                                        @elseif($h->status == 'Dalam Proses')
                                                            <span class="badge bg-warning-50 text-warning-600">{{ $h->status }}</span>
                                                        @else
                                                            <span class="badge bg-gray-200 text-gray-600">{{ $h->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($h->nilai > 0)
                                                            {{ $h->nilai }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-4">
                                                        <div class="text-gray-600">
                                                            <i class="ph ph-info me-2"></i> Tidak ada data hafalan
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hafalan Progress Card End -->
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Student Info Card Start -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom border-gray-100">
                            <h5 class="mb-0">Informasi Siswa</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-16">
                                <div class="w-96 h-96 rounded-circle bg-main-600 flex-center mx-auto">
                                    <img src="{{ asset('assets/images/icons/student.png') }}" alt="" class="w-48 h-48">
                                </div>
                                <h5 class="mt-3 mb-0">{{ Auth::user()->siswa->nama ?? Auth::user()->name }}</h5>
                                <p class="text-gray-600">{{ Auth::user()->siswa->kelas->nama ?? '-' }}</p>
                            </div>
                            <div class="border-top border-gray-100 pt-3">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-gray-600">NIS</td>
                                        <td>: {{ Auth::user()->siswa->nis ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-600">Tahun Ajaran</td>
                                        <td>: {{ $tahunAjaran->nama }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('siswa.raport.index') }}" class="btn btn-main w-100 rounded-pill">Lihat Detail Raport</a>
                            </div>
                        </div>
                    </div>
                    <!-- Student Info Card End -->

                    <!-- Academic Ranking Card Start -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom border-gray-100">
                            <h5 class="mb-0">Peringkat Akademik</h5>
                        </div>
                        <div class="card-body">
                            <div id="rankingRadialChart" class="d-flex justify-content-center"></div>
                            <div class="text-center">
                                <h2 class="mb-2">{{ $currentPerformance->peringkat }}</h2>
                                <p class="text-gray-600">dari 32 siswa di kelas</p>
                                <div class="progress mt-3 mb-2" style="height: 10px;">
                                    @php
                                        $rankPercentile = 100 - ((explode(' ', $currentPerformance->peringkat)[0] / 32) * 100);
                                        $badgeClass = '';
                                        if ($rankPercentile >= 90) $badgeClass = 'bg-success-600';
                                        elseif ($rankPercentile >= 70) $badgeClass = 'bg-main-600';
                                        elseif ($rankPercentile >= 50) $badgeClass = 'bg-warning-600';
                                        else $badgeClass = 'bg-danger-600';
                                    @endphp
                                    <div class="progress-bar {{ $badgeClass }}" role="progressbar" style="width: {{ $rankPercentile }}%" aria-valuenow="{{ $rankPercentile }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-sm">
                                    @if($rankPercentile >= 90)
                                        <span class="text-success-600">Sangat Baik</span> - Pertahankan prestasimu!
                                    @elseif($rankPercentile >= 70)
                                        <span class="text-main-600">Baik</span> - Kamu dapat meningkatkannya lagi!
                                    @elseif($rankPercentile >= 50)
                                        <span class="text-warning-600">Cukup</span> - Perlu usaha lebih keras!
                                    @else
                                        <span class="text-danger-600">Perlu Ditingkatkan</span> - Belajar lebih giat!
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Academic Ranking Card End -->

                    <!-- Upcoming Events Card Start -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom border-gray-100">
                            <h5 class="mb-0">Jadwal Ujian & Tugas</h5>
                        </div>
                        <div class="card-body">
                            @forelse($upcomingEvents ?? [] as $event)
                            <div class="event-item bg-gray-50 rounded-8 p-16 {{ !$loop->last ? 'mb-16' : '' }}">
                                <div class="flex-between gap-4">
                                    <div class="flex-align gap-8">
                                        <span class="icon d-flex w-44 h-44 bg-white rounded-8 flex-center text-2xl">
                                            <i class="ph {{ $event->icon }}"></i>
                                        </span>
                                        <div class="">
                                            <h6 class="mb-2">{{ $event->jenis }} {{ $event->mata_pelajaran }}</h6>
                                            <p class="mb-1 text-sm">{{ $event->materi }}</p>
                                            <span class="text-warning-600">{{ $event->tanggal }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <div class="text-gray-600">
                                    <i class="ph ph-info me-2"></i> Tidak ada jadwal terdekat
                                </div>
                            </div>
                            @endforelse
                            <a href="#" class="btn btn-outline-main w-100 rounded-pill mt-16">Lihat Semua Jadwal</a>
                        </div>
                    </div>
                    <!-- Upcoming Events Card End -->

                    <!-- Achievement Card Start -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom border-gray-100">
                            <h5 class="mb-0">Pencapaian Terbaru</h5>
                        </div>
                        <div class="card-body">
                            @forelse($achievements ?? [] as $achievement)
                            <div class="achievement-item d-flex align-items-center gap-3 {{ !$loop->last ? 'mb-4' : '' }}">
                                <div class="achievement-badge {{ $achievement->badge_class }} rounded-circle p-3">
                                    <i class="ph {{ $achievement->icon }} text-2xl"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $achievement->title }}</h6>
                                    <p class="text-sm text-gray-600 mb-0">{{ $achievement->date }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="achievement-item d-flex align-items-center gap-3 mb-4">
                                <div class="achievement-badge bg-main-50 text-main-600 rounded-circle p-3">
                                    <i class="ph ph-crown text-2xl"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Nilai Tertinggi Matematika</h6>
                                    <p class="text-sm text-gray-600 mb-0">April 2025</p>
                                </div>
                            </div>
                            <div class="achievement-item d-flex align-items-center gap-3 mb-4">
                                <div class="achievement-badge bg-success-50 text-success-600 rounded-circle p-3">
                                    <i class="ph ph-check-circle text-2xl"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">100% Kehadiran</h6>
                                    <p class="text-sm text-gray-600 mb-0">Semester Berjalan</p>
                                </div>
                            </div>
                            <div class="achievement-item d-flex align-items-center gap-3">
                                <div class="achievement-badge bg-warning-50 text-warning-600 rounded-circle p-3">
                                    <i class="ph ph-star text-2xl"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Hafalan Surah Terbaik</h6>
                                    <p class="text-sm text-gray-600 mb-0">Maret 2025</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- Achievement Card End -->
                </div>
            </div>
            <!-- Main Content Sections End -->
        </div>
    </main>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                // Create small charts for each summary card
                createMiniChart('academic-chart', '#3D7FF9', @json($academicData->pluck('rata_umum'))); // Blue for academic
                createMiniChart('keshaftaan-chart', '#27CFA7', @json($academicData->pluck('rata_keshaftaan'))); // Green for keshaftaan
                createMiniChart('attitude-chart', '#6142FF', [65, 70, 75, 80, 82, 87, 87.5]); // Purple for attitude
                createMiniChart('rank-chart', '#FA902F', [65, 70, 75, 80, 82, 87, 87.5]); // Orange for rank

                // Create semester progress chart
                createSemesterProgressChart();

                // Create ranking radial chart
                createRankingRadialChart();

                // Create hafalan donut chart
                createHafalanDonutChart();
            });

            // Function to create mini charts for summary cards
            function createMiniChart(chartId, chartColor, data) {
                var options = {
                    series: [{
                        name: 'Nilai',
                        data: data
                    }],
                    chart: {
                        type: 'area',
                        width: 80,
                        height: 42,
                        sparkline: {
                            enabled: true
                        },
                        toolbar: {
                            show: false
                        },
                        padding: {
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 1,
                        colors: [chartColor],
                        lineCap: 'round'
                    },
                    fill: {
                        type: 'gradient',
                        colors: [chartColor],
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.5,
                            gradientToColors: [`${chartColor}00`],
                            inverseColors: false,
                            opacityFrom: .5,
                            opacityTo: 0.3,
                            stops: [0, 100],
                        },
                    },
                    markers: {
                        colors: [chartColor],
                        strokeWidth: 2,
                        size: 0,
                        hover: {
                            size: 8
                        }
                    },
                    tooltip: {
                        x: {
                            show: false,
                        },
                        y: {
                            formatter: function(value) {
                                return value.toFixed(1);
                            }
                        }
                    },
                };

                var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
                chart.render();
            }

            // Create semester progress chart
            function createSemesterProgressChart() {
                var options = {
                    series: [{
                            name: 'Nilai Umum',
                            data: @json($academicData->pluck('rata_umum'))
                        },
                        {
                            name: 'Nilai Keshaftaan',
                            data: @json($academicData->pluck('rata_keshaftaan'))
                        }
                    ],
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#3D7FF9', '#27CFA7'],
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2,
                    },
                    grid: {
                        show: true,
                        borderColor: '#E6E6E6',
                        strokeDashArray: 3,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                    },
                    markers: {
                        size: 4,
                        hover: {
                            size: 7
                        }
                    },
                    xaxis: {
                        categories: @json($semesters->pluck('nama')),
                        labels: {
                            style: {
                                fontSize: "12px"
                            }
                        },
                    },
                    yaxis: {
                        title: {
                            text: 'Nilai'
                        },
                        min: 75,
                        max: 100,
                        labels: {
                            formatter: function(value) {
                                return value.toFixed(1);
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetY: -15
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return value.toFixed(1);
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#semesterProgressChart"), options);
                chart.render();
            }

            // Create ranking radial chart
            function createRankingRadialChart() {
                // Calculate percentile (invert ranking - higher is better)
                var rankPercentile = 100 - (({{ explode(' ', $currentPerformance->peringkat)[0] }} / 32) * 100);

                var options = {
                    series: [Math.round(rankPercentile)],
                    chart: {
                        height: 200,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: '70%',
                            },
                            dataLabels: {
                                name: {
                                    show: false
                                },
                                value: {
                                    fontSize: '22px',
                                    fontWeight: 'bold',
                                    formatter: function(val) {
                                        return 'Top ' + val + '%';
                                    }
                                }
                            }
                        },
                    },
                    fill: {
                        colors: ['#3D7FF9']
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    labels: ['Percentile'],
                };

                var chart = new ApexCharts(document.querySelector("#rankingRadialChart"), options);
                chart.render();
            }

            // Create hafalan donut chart
            function createHafalanDonutChart() {
                var options = {
                    series: [70, 20, 10], // Example data: Completed, In Progress, Not Started
                    chart: {
                        type: 'donut',
                        height: 250
                    },
                    labels: ['Selesai', 'Dalam Proses', 'Belum Mulai'],
                    colors: ['#27CFA7', '#FA902F', '#E2E2E2'],
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '55%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        formatter: function() {
                                            return 100;
                                        }
                                    }
                                }
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#hafalanDonutChart"), options);
                chart.render();
            }
        </script>
    </x-slot>
</x-app-layout>
