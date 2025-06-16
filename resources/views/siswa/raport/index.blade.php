<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Siswa</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Raport') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Raport Siswa
    </x-slot>

    <main>
        <div class="dashboard-body">

            <!-- Filter Section Start -->
            <div class="card mb-24">
                <div class="card-header border-bottom border-gray-100">
                    <h5 class="mb-0">Filter Raport</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.raport.index') }}" method="GET" class="row g-3">
                        <div class="col-md-6">
                            <label for="semester" class="form-label">Pilih Semester</label>
                            <select id="semester" name="semester" class="form-select">
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester['id'] }}" {{ ($semester['id'] == $selectedSemesterId) ? 'selected' : '' }}>
                                        {{ $semester['nama'] }} - {{ $semester['tahun'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="kelas" class="form-label">Pilih Kelas</label>
                            <select id="kelas" name="kelas" class="form-select">
                                @foreach ($classes as $class)
                                    <option value="{{ $class['id'] }}" {{ ($class['id'] == $selectedClassId) ? 'selected' : '' }}>
                                        {{ $class['nama'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-main rounded-pill py-9">Tampilkan Raport</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Filter Section End -->

            @if($selectedClass && $selectedSemester)
            <!-- Class Info Section Start -->
            <div class="card mb-24">
                <div class="card-header border-bottom border-gray-100">
                    <h5 class="mb-0">Informasi Kelas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex gap-3">
                                <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0">
                                    <i class="ph-fill ph-graduation-cap"></i>
                                </span>
                                <div>
                                    <h5 class="mb-2">{{ $selectedClass['nama'] }}</h5>
                                    <p class="text-gray-600">Tingkat: {{ $selectedClass['tingkat'] }}</p>
                                    <p class="text-gray-600">Tahun Ajaran: {{ $selectedSemester['tahun'] }}</p>
                                    <p class="text-gray-600">Semester: {{ $selectedSemester['nama'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-3">
                                <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0">
                                    <i class="ph-fill ph-chalkboard-teacher"></i>
                                </span>
                                <div>
                                    <h5 class="mb-2">Wali Kelas</h5>
                                    <p class="text-gray-600">{{ $selectedClass['wali_kelas'] }}</p>
                                    @if($raportData)
                                        <a href="{{ route('siswa.raport.show', ['id' => $raportData->id]) }}" class="btn btn-main rounded-pill py-9 mt-2">Lihat Detail Raport</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Class Info Section End -->

            @if($raportData)
            <!-- Student Performance Summary Start -->
            <div class="card mb-24">
                <div class="card-header border-bottom border-gray-100">
                    <h5 class="mb-0">Ringkasan Nilai</h5>
                </div>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-2">{{ $summaryStats['rata_rata_akademik'] }}</h4>
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
                                    <h4 class="mb-2">{{ $summaryStats['rata_rata_keshaftaan'] }}</h4>
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
                                    <h4 class="mb-2">{{ $summaryStats['predikat_sikap'] }}</h4>
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
                                    <h4 class="mb-2">{{ $summaryStats['peringkat_kelas'] }}</h4>
                                    <span class="text-gray-600">Peringkat Kelas</span>
                                    <div class="flex-between gap-8 mt-16">
                                        <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-warning-600 text-white text-2xl"><i class="ph-fill ph-trophy"></i></span>
                                        <div id="rank-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional detailed statistics -->
                    <div class="row mt-24 gy-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header border-bottom border-gray-100">
                                    <h5 class="mb-0">Detail Nilai Akademik</h5>
                                </div>
                                <div class="card-body">
                                    @if($summaryStats['nilai_tertinggi'] > 0)
                                    <div class="p-xl-4 py-16 px-12 flex-between gap-8 rounded-8 border border-gray-100 hover-border-gray-200 transition-1 mb-16">
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0"><i class="ph-fill ph-graduation-cap"></i></span>
                                            <div>
                                                <h6 class="mb-0">Nilai Tertinggi</h6>
                                                <h4 class="text-success-600">{{ $summaryStats['nilai_tertinggi'] }}</h4>
                                            </div>
                                        </div>
                                        <div class="progress w-100px bg-main-100 rounded-pill h-4">
                                            <div class="progress-bar bg-success-600 rounded-pill" style="width: {{ $summaryStats['nilai_tertinggi'] }}%"></div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($summaryStats['nilai_terendah'] > 0)
                                    <div class="p-xl-4 py-16 px-12 flex-between gap-8 rounded-8 border border-gray-100 hover-border-gray-200 transition-1 mb-16">
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="text-main-600 bg-main-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0"><i class="ph-fill ph-chart-line"></i></span>
                                            <div>
                                                <h6 class="mb-0">Nilai Terendah</h6>
                                                <h4 class="text-warning-600">{{ $summaryStats['nilai_terendah'] }}</h4>
                                            </div>
                                        </div>
                                        <div class="progress w-100px bg-main-100 rounded-pill h-4">
                                            <div class="progress-bar bg-warning-600 rounded-pill" style="width: {{ $summaryStats['nilai_terendah'] }}%"></div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($summaryStats['nilai_tertinggi'] == 0 && $summaryStats['nilai_terendah'] == 0)
                                    <div class="text-center py-4">
                                        <p class="text-gray-500">Belum ada data nilai akademik</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header border-bottom border-gray-100">
                                    <h5 class="mb-0">Detail Nilai Keshaftaan</h5>
                                </div>
                                <div class="card-body">
                                    @if($summaryStats['nilai_hafalan'] > 0)
                                    <div class="p-xl-4 py-16 px-12 flex-between gap-8 rounded-8 border border-gray-100 hover-border-gray-200 transition-1 mb-16">
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="text-main-two-600 bg-main-two-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0"><i class="ph-fill ph-book"></i></span>
                                            <div>
                                                <h6 class="mb-0">Nilai Hafalan</h6>
                                                <h4 class="text-primary-600">{{ $summaryStats['nilai_hafalan'] }}</h4>
                                            </div>
                                        </div>
                                        <div class="progress w-100px bg-main-two-100 rounded-pill h-4">
                                            <div class="progress-bar bg-primary-600 rounded-pill" style="width: {{ $summaryStats['nilai_hafalan'] }}%"></div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($summaryStats['nilai_keshaftaan'] > 0)
                                    <div class="p-xl-4 py-16 px-12 flex-between gap-8 rounded-8 border border-gray-100 hover-border-gray-200 transition-1">
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="text-main-two-600 bg-main-two-50 w-44 h-44 rounded-circle flex-center text-2xl flex-shrink-0"><i class="ph-fill ph-lightning"></i></span>
                                            <div>
                                                <h6 class="mb-0">Nilai Keshaftaan</h6>
                                                <h4 class="text-success-600">{{ $summaryStats['nilai_keshaftaan'] }}</h4>
                                            </div>
                                        </div>
                                        <div class="progress w-100px bg-main-two-100 rounded-pill h-4">
                                            <div class="progress-bar bg-success-600 rounded-pill" style="width: {{ $summaryStats['nilai_keshaftaan'] }}%"></div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($summaryStats['nilai_hafalan'] == 0 && $summaryStats['nilai_keshaftaan'] == 0)
                                    <div class="text-center py-4">
                                        <p class="text-gray-500">Belum ada data nilai keshaftaan</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Student Performance Summary End -->

            <!-- Progress Chart Start -->
            <div class="card mb-24">
                <div class="card-header border-bottom border-gray-100">
                    <h5 class="mb-0">Perkembangan Nilai</h5>
                </div>
                <div class="card-body">
                    <div class="mb-20 flex-between flex-wrap gap-8">
                        <div class="flex-align gap-16 flex-wrap">
                            <div class="flex-align flex-wrap gap-16">
                                <div class="flex-align flex-wrap gap-8">
                                    <span class="w-8 h-8 rounded-circle bg-main-600"></span>
                                    <span class="text-13 text-gray-600">Nilai Akademik</span>
                                </div>
                                <div class="flex-align flex-wrap gap-8">
                                    <span class="w-8 h-8 rounded-circle bg-main-two-600"></span>
                                    <span class="text-13 text-gray-600">Nilai Keshaftaan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="progressChart" class="tooltip-style y-value-left"></div>
                </div>
            </div>
            <!-- Progress Chart End -->

            @else
            <!-- No Raport Data Message -->
            <div class="card mb-24">
                <div class="card-body text-center py-5">
                    <br><br>
                    <i class="ph ph-file-x text-gray-400" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 mb-2">Belum Ada Data Raport</h5>
                    <p class="text-gray-600">Data raport untuk semester dan kelas yang dipilih belum tersedia.</p>
                    <br><br>
                </div>
            </div>
            @endif

            @else
            <!-- No Selection Message -->
            <div class="card mb-24">
                <div class="card-body text-center py-5">
                    <i class="ph ph-selection-all text-gray-400" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 mb-2">Pilih Semester dan Kelas</h5>
                    <p class="text-gray-600">Silakan pilih semester dan kelas untuk melihat data raport.</p>
                </div>
            </div>
            @endif

        </div>
    </main>

    <x-slot name="scripts">
        <script>
            // Function to create mini charts for summary cards
            function createChart(chartId, chartColor, data = null) {
                const defaultData = [65, 70, 75, 80, 82, 87, 87.5];
                const chartData = data || defaultData;

                var options = {
                    series: [{
                        name: 'Nilai',
                        data: chartData,
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
                    },
                };

                var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
                chart.render();
            }

            // Create progress chart with real data
            function createProgressChart() {
                @if(isset($progressData))
                const categories = @json($progressData['categories']);
                const akademikData = @json($progressData['akademik']);
                const keshaftaanData = @json($progressData['keshaftaan']);
                @else
                const categories = ['Ulangan 1', 'Tugas Kelas', 'UTS', 'Proyek', 'Ulangan 2', 'UAS'];
                const akademikData = [80.5, 82.3, 83.7, 85.2, 85.9, 87.5];
                const keshaftaanData = [85.3, 87.1, 88.5, 89.2, 89.8, 90.2];
                @endif

                var options = {
                    series: [
                        {
                            name: 'Nilai Akademik',
                            data: akademikData,
                        },
                        {
                            name: 'Nilai Keshaftaan',
                            data: keshaftaanData,
                        },
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
                        categories: categories,
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
                        min: 70,
                        max: 100,
                        labels: {
                            formatter: function (value) {
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
                            formatter: function (value) {
                                return value.toFixed(1);
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#progressChart"), options);
                chart.render();
            }

            // Execute charts when document is ready
            $(document).ready(function() {
                // Only create charts if we have raport data
                @if(isset($raportData) && $raportData)
                    // Create small charts for each summary card
                    createChart('academic-chart', '#3D7FF9');
                    createChart('keshaftaan-chart', '#27CFA7');
                    createChart('attitude-chart', '#6142FF');
                    createChart('rank-chart', '#FA902F');

                    // Create progress chart
                    createProgressChart();
                @endif
            });
        </script>
    </x-slot>
</x-app-layout>
