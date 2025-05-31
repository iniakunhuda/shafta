<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('siswa.dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('siswa.nilai') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Nilai Siswa</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">Detail Nilai</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Detail Nilai
    </x-slot>

    <main>
        <div class="dashboard-body">
            <!-- Header Section Start -->
            <div class="card mb-24">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2 class="mb-2">Detail Nilai</h2>
                            <p class="text-gray-600">{{ $nilai->pelajaran->judul }}</p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="{{ route('siswa.nilai') }}" class="btn btn-outline-main rounded-pill">
                                <i class="ph ph-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Section End -->

            <!-- Nilai Detail Start -->
            <div class="row gy-4">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Subject Info Card Start -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom border-gray-100">
                            <h5 class="mb-0">Informasi Mata Pelajaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center mb-4 mb-md-0">
                                    <div class="w-96 h-96 rounded-circle {{ $nilai->pelajaran->kategori === 'umum' ? 'bg-main-600' : 'bg-main-two-600' }} flex-center mx-auto">
                                        <img src="{{ asset('assets/images/icons/' . ($nilai->pelajaran->kategori === 'umum' ? 'book.png' : 'certificate.png')) }}" alt="" class="w-48 h-48">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="text-gray-600" width="40%">Mata Pelajaran</td>
                                            <td>: {{ $nilai->pelajaran->judul }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-gray-600">Kategori</td>
                                            <td>: {{ ucfirst($nilai->pelajaran->kategori) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-gray-600">Guru</td>
                                            <td>: {{ $nilai->pelajaran->guru }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-gray-600">KKM</td>
                                            <td>: {{ $nilai->pelajaran->kkm }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Subject Info Card End -->

                    <!-- Score Details Card Start -->
                    <div class="card">
                        <div class="card-header border-bottom border-gray-100">
                            <h5 class="mb-0">Detail Nilai</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center p-4 bg-gray-50 rounded-8">
                                        <h6 class="text-gray-600 mb-2">Nilai Pengetahuan</h6>
                                        @php
                                            $badgeClass = '';
                                            if ($nilai->nilai_pengetahuan >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                            elseif ($nilai->nilai_pengetahuan >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                            elseif ($nilai->nilai_pengetahuan >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                            else $badgeClass = 'bg-danger-50 text-danger-600';
                                        @endphp
                                        <h2 class="mb-0 {{ $badgeClass }} d-inline-flex align-items-center rounded-pill px-4 py-2">
                                            {{ $nilai->nilai_pengetahuan }}
                                        </h2>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-4 bg-gray-50 rounded-8">
                                        <h6 class="text-gray-600 mb-2">Nilai Keterampilan</h6>
                                        @php
                                            $badgeClass = '';
                                            if ($nilai->nilai_keterampilan >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                            elseif ($nilai->nilai_keterampilan >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                            elseif ($nilai->nilai_keterampilan >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                            else $badgeClass = 'bg-danger-50 text-danger-600';
                                        @endphp
                                        <h2 class="mb-0 {{ $badgeClass }} d-inline-flex align-items-center rounded-pill px-4 py-2">
                                            {{ $nilai->nilai_keterampilan }}
                                        </h2>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-4 bg-gray-50 rounded-8">
                                        <h6 class="text-gray-600 mb-2">Nilai Akhir</h6>
                                        @php
                                            $badgeClass = '';
                                            if ($nilai->nilai_akhir >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                            elseif ($nilai->nilai_akhir >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                            elseif ($nilai->nilai_akhir >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                            else $badgeClass = 'bg-danger-50 text-danger-600';
                                        @endphp
                                        <h2 class="mb-0 {{ $badgeClass }} d-inline-flex align-items-center rounded-pill px-4 py-2">
                                            {{ $nilai->nilai_akhir }}
                                        </h2>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6 class="text-gray-600 mb-2">Predikat</h6>
                                <p class="mb-0">{{ $nilai->predikat }}</p>
                            </div>

                            <div class="mt-4">
                                <h6 class="text-gray-600 mb-2">Deskripsi</h6>
                                <p class="mb-0">{{ $nilai->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Score Details Card End -->
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Progress Card Start -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom border-gray-100">
                            <h5 class="mb-0">Perkembangan Nilai</h5>
                        </div>
                        <div class="card-body">
                            <div id="nilaiProgressChart" class="tooltip-style y-value-left"></div>
                        </div>
                    </div>
                    <!-- Progress Card End -->

                    <!-- Notes Card Start -->
                    <div class="card">
                        <div class="card-header border-bottom border-gray-100">
                            <h5 class="mb-0">Catatan Guru</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $nilai->catatan_guru ?? 'Tidak ada catatan' }}</p>
                        </div>
                    </div>
                    <!-- Notes Card End -->
                </div>
            </div>
            <!-- Nilai Detail End -->
        </div>
    </main>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                createNilaiProgressChart();
            });

            function createNilaiProgressChart() {
                var options = {
                    series: [{
                        name: 'Nilai',
                        data: [75, 80, 85, 82, 88, 90, 85] // Dummy data showing progression
                    }],
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#3D7FF9'],
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
                        categories: ['P1', 'P2', 'P3', 'P4', 'P5', 'P6', 'P7'],
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
                            formatter: function(value) {
                                return value.toFixed(0);
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return value.toFixed(0);
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#nilaiProgressChart"), options);
                chart.render();
            }
        </script>
    </x-slot>
</x-app-layout> 