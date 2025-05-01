@php
// Sample student data
$student = [
    'id' => 1,
    'nama' => 'Miftahul Huda',
    'nis' => '12345',
    'nisn' => '9876543210',
    'kelas' => 'X IPA 1',
    'foto' => 'user-img.png',
    'email' => 'siswa@shafta.sch.id'
];

// Sample data for semesters
$semesters = [
    ['id' => 1, 'nama' => 'Semester 1', 'tahun' => '2023/2024'],
    ['id' => 2, 'nama' => 'Semester 2', 'tahun' => '2023/2024'],
    ['id' => 3, 'nama' => 'Semester 1', 'tahun' => '2024/2025'],
    ['id' => 4, 'nama' => 'Semester 2', 'tahun' => '2024/2025'],
];

// Get current semester
$currentSemester = $semesters[count($semesters) - 1];

// Sample academic data across semesters
$academicData = [
    1 => ['rata_umum' => 82.5, 'rata_keshaftaan' => 85.7, 'peringkat' => 8, 'predikat' => 'B'],
    2 => ['rata_umum' => 84.3, 'rata_keshaftaan' => 87.2, 'peringkat' => 6, 'predikat' => 'B+'],
    3 => ['rata_umum' => 86.8, 'rata_keshaftaan' => 89.5, 'peringkat' => 5, 'predikat' => 'A-'],
    4 => ['rata_umum' => 87.5, 'rata_keshaftaan' => 90.2, 'peringkat' => 5, 'predikat' => 'A'],
];

// Current semester performance
$currentPerformance = $academicData[count($semesters)];

// Sample data for recent grades
$recentGrades = [
    ['mata_pelajaran' => 'Matematika', 'jenis' => 'Ulangan Harian', 'nilai' => 92, 'tanggal' => '23 Apr 2025', 'icon' => 'course-name-icon1.png', 'color' => 'bg-main-600'],
    ['mata_pelajaran' => 'Bahasa Indonesia', 'jenis' => 'Tugas Esai', 'nilai' => 88, 'tanggal' => '20 Apr 2025', 'icon' => 'course-name-icon2.png', 'color' => 'bg-purple-600'],
    ['mata_pelajaran' => 'Fisika', 'jenis' => 'Praktikum', 'nilai' => 90, 'tanggal' => '18 Apr 2025', 'icon' => 'course-name-icon3.png', 'color' => 'bg-warning-600'],
    ['mata_pelajaran' => 'Bahasa Inggris', 'jenis' => 'Presentasi', 'nilai' => 85, 'tanggal' => '15 Apr 2025', 'icon' => 'course-name-icon4.png', 'color' => 'bg-main-two-600'],
    ['mata_pelajaran' => 'Pendidikan Agama', 'jenis' => 'Hafalan', 'nilai' => 95, 'tanggal' => '10 Apr 2025', 'icon' => 'course-name-icon1.png', 'color' => 'bg-main-600'],
];

// Sample data for upcoming assignments/exams
$upcomingEvents = [
    ['jenis' => 'Ulangan', 'mata_pelajaran' => 'Matematika', 'tanggal' => '30 Apr 2025', 'materi' => 'Kalkulus Dasar', 'icon' => 'ph-squares-four'],
    ['jenis' => 'Tugas', 'mata_pelajaran' => 'Bahasa Arab', 'tanggal' => '28 Apr 2025', 'materi' => 'Percakapan Sehari-hari', 'icon' => 'ph-magic-wand'],
    ['jenis' => 'Presentasi', 'mata_pelajaran' => 'Biologi', 'tanggal' => '5 Mei 2025', 'materi' => 'Sistem Pencernaan', 'icon' => 'ph-presentation'],
];

// Sample data for subject performance
$subjectPerformance = [
    ['mata_pelajaran' => 'Pendidikan Agama Islam', 'nilai' => 90, 'rata_kelas' => 85],
    ['mata_pelajaran' => 'Matematika', 'nilai' => 92, 'rata_kelas' => 83],
    ['mata_pelajaran' => 'Bahasa Indonesia', 'nilai' => 88, 'rata_kelas' => 82],
    ['mata_pelajaran' => 'Bahasa Inggris', 'nilai' => 86, 'rata_kelas' => 80],
    ['mata_pelajaran' => 'Fisika', 'nilai' => 90, 'rata_kelas' => 78],
    ['mata_pelajaran' => 'Biologi', 'nilai' => 85, 'rata_kelas' => 79],
    ['mata_pelajaran' => 'Kimia', 'nilai' => 82, 'rata_kelas' => 77],
];

// Sample data for hafalan progress
$hafalanProgress = [
    ['surah' => 'Al-Fatihah', 'status' => 'Selesai', 'nilai' => 99],
    ['surah' => 'Al-Baqarah (1-50)', 'status' => 'Selesai', 'nilai' => 95],
    ['surah' => 'Al-Baqarah (51-100)', 'status' => 'Selesai', 'nilai' => 92],
    ['surah' => 'Al-Baqarah (101-150)', 'status' => 'Dalam Proses', 'nilai' => 85],
    ['surah' => 'Al-Baqarah (151-200)', 'status' => 'Belum Mulai', 'nilai' => 0],
];

// Recent notifications
$notifications = [
    ['title' => 'Nilai UTS telah diupload', 'time' => '2 jam yang lalu', 'read' => false],
    ['title' => 'Jadwal UAS sudah tersedia', 'time' => '1 hari yang lalu', 'read' => true],
    ['title' => 'Pengumuman libur Hari Raya', 'time' => '3 hari yang lalu', 'read' => true],
];
@endphp

<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Dashboard') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Dashboard
    </x-slot>

    <main>
        <!-- Greeting Box Start -->
        <div class="card mb-24">
            <div class="card-body grettings-box-two position-relative z-1 p-0">
                <div class="row align-items-center h-100">
                    <div class="col-lg-8">
                        <div class="grettings-box-two__content">
                            <h2 class="fw-medium mb-0 flex-align gap-10">Selamat Datang, Siswa <img src="../assets/images/icons/wave-hand.png" alt=""> </h2>
                            <h4 class="fw-medium mb-16">Pantau nilai dan perkembangan akademik di semester ini!</h4>
                            <p class="text-15 text-gray-400">Semester 1 - Tahun Ajaran 2023/2024</p>
                            <a href="raport.php" class="btn btn-main rounded-pill mt-32">Lihat Detail Raport</a>
                        </div>
                    </div>
                    <div class="col-lg-4 d-md-block d-none mt-auto">
                        <img src="../assets/images/thumbs/gretting-thumb.png" alt="">
                    </div>
                </div>
                <img src="../assets/images/bg/star-shape.png" class="position-absolute start-0 top-0 w-100 h-100 z-n1 object-fit-contain" alt="">
            </div>
        </div>
        <!-- Greeting Box End -->

        <!-- Student Performance Summary Start -->
        <div class="row gy-4 mb-24">
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-2"><?php echo $currentPerformance['rata_umum']; ?></h4>
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
                        <h4 class="mb-2"><?php echo $currentPerformance['rata_keshaftaan']; ?></h4>
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
                        <h4 class="mb-2"><?php echo $currentPerformance['predikat']; ?></h4>
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
                        <h4 class="mb-2"><?php echo $currentPerformance['peringkat']; ?></h4>
                        <span class="text-gray-600">Peringkat Kelas</span>
                        <div class="flex-between gap-8 mt-16">
                            <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-warning-600 text-white text-2xl"><i class="ph-fill ph-trophy"></i></span>
                            <div id="rank-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Student Performance Summary End -->

        <!-- Main Content Sections Start -->
        <div class="row gy-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Semester Progress Card Start -->
                <div class="card mb-24">
                    <div class="card-header border-bottom border-gray-100">
                        <h5 class="mb-0">Perkembangan Nilai per Semester</h5>
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

                <!-- Subject Performance Card Start -->
                <div class="card mb-24">
                    <div class="card-header border-bottom border-gray-100">
                        <h5 class="mb-0">Performa per Mata Pelajaran (Semester Ini)</h5>
                    </div>
                    <div class="card-body">
                        <div id="subjectPerformanceChart" class="tooltip-style y-value-left"></div>
                    </div>
                </div>
                <!-- Subject Performance Card End -->

                <!-- Recent Grades Card Start -->
                <div class="card mb-24">
                    <div class="card-header border-bottom border-gray-100">
                        <div class="mb-0 flex-between flex-wrap gap-8">
                            <h5 class="mb-0">Nilai Terbaru</h5>
                            <a href="#" class="text-13 fw-medium text-main-600 hover-text-decoration-underline">Lihat Semua</a>
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
                                    <?php foreach ($recentGrades as $grade): ?>
                                        <tr>
                                            <td>
                                                <div class="flex-align gap-8">
                                                    <div class="w-40 h-40 rounded-circle <?php echo $grade['color']; ?> flex-center flex-shrink-0">
                                                        <img src="../assets/images/icons/<?php echo $grade['icon']; ?>" alt="">
                                                    </div>
                                                    <div class="">
                                                        <h6 class="mb-0"><?php echo $grade['mata_pelajaran']; ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex-align gap-8">
                                                    <?php
                                                    $badgeClass = '';
                                                    if ($grade['nilai'] >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                                    elseif ($grade['nilai'] >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                                    elseif ($grade['nilai'] >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                                    else $badgeClass = 'bg-danger-50 text-danger-600';
                                                    ?>
                                                    <span class="text-13 py-2 px-8 <?php echo $badgeClass; ?> d-inline-flex align-items-center rounded-pill fw-bold">
                                                        <?php echo $grade['nilai']; ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-gray-600"><?php echo $grade['jenis']; ?></span>
                                            </td>
                                            <td>
                                                <span class="text-gray-600"><?php echo $grade['tanggal']; ?></span>
                                            </td>
                                            <td>
                                                <div class="flex-align justify-content-center gap-16">
                                                    <a href="#" class="text-gray-900 hover-text-main-600 text-md d-flex"><i class="ph ph-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
                                            <?php foreach ($hafalanProgress as $hafalan): ?>
                                                <tr>
                                                    <td><?php echo $hafalan['surah']; ?></td>
                                                    <td>
                                                        <?php if ($hafalan['status'] == 'Selesai'): ?>
                                                            <span class="badge bg-success-50 text-success-600"><?php echo $hafalan['status']; ?></span>
                                                        <?php elseif ($hafalan['status'] == 'Dalam Proses'): ?>
                                                            <span class="badge bg-warning-50 text-warning-600"><?php echo $hafalan['status']; ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-gray-200 text-gray-600"><?php echo $hafalan['status']; ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($hafalan['nilai'] > 0): ?>
                                                            <?php echo $hafalan['nilai']; ?>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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
                            <img src="../assets/images/thumbs/<?php echo $student['foto']; ?>" alt="<?php echo $student['nama']; ?>" class="w-96 h-96 rounded-circle object-fit-cover">
                            <h5 class="mt-3 mb-0"><?php echo $student['nama']; ?></h5>
                            <p class="text-gray-600"><?php echo $student['kelas']; ?></p>
                        </div>
                        <div class="border-top border-gray-100 pt-3">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-gray-600">NIS</td>
                                    <td>: <?php echo $student['nis']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-gray-600">NISN</td>
                                    <td>: <?php echo $student['nisn']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-gray-600">Semester</td>
                                    <td>: <?php echo $currentSemester['nama'] . ' ' . $currentSemester['tahun']; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="detail-raport.php" class="btn btn-main w-100 rounded-pill">Lihat Detail Raport</a>
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
                            <h2 class="mb-2"><?php echo $currentPerformance['peringkat']; ?></h2>
                            <p class="text-gray-600">dari 32 siswa di kelas</p>
                            <div class="progress mt-3 mb-2" style="height: 10px;">
                                <?php
                                // Calculate percentile (invert ranking - higher is better)
                                $rankPercentile = 100 - (($currentPerformance['peringkat'] / 32) * 100);
                                $badgeClass = '';
                                if ($rankPercentile >= 90) $badgeClass = 'bg-success-600';
                                elseif ($rankPercentile >= 70) $badgeClass = 'bg-main-600';
                                elseif ($rankPercentile >= 50) $badgeClass = 'bg-warning-600';
                                else $badgeClass = 'bg-danger-600';
                                ?>
                                <div class="progress-bar <?php echo $badgeClass; ?>" role="progressbar" style="width: <?php echo $rankPercentile; ?>%" aria-valuenow="<?php echo $rankPercentile; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="text-sm">
                                <?php if ($rankPercentile >= 90): ?>
                                    <span class="text-success-600">Sangat Baik</span> - Pertahankan prestasimu!
                                <?php elseif ($rankPercentile >= 70): ?>
                                    <span class="text-main-600">Baik</span> - Kamu dapat meningkatkannya lagi!
                                <?php elseif ($rankPercentile >= 50): ?>
                                    <span class="text-warning-600">Cukup</span> - Perlu usaha lebih keras!
                                <?php else: ?>
                                    <span class="text-danger-600">Perlu Ditingkatkan</span> - Belajar lebih giat!
                                <?php endif; ?>
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
                        <?php foreach ($upcomingEvents as $index => $event): ?>
                            <div class="event-item bg-gray-50 rounded-8 p-16 <?php echo ($index < count($upcomingEvents) - 1) ? 'mb-16' : ''; ?>">
                                <div class="flex-between gap-4">
                                    <div class="flex-align gap-8">
                                        <span class="icon d-flex w-44 h-44 bg-white rounded-8 flex-center text-2xl"><i class="ph <?php echo $event['icon']; ?>"></i></span>
                                        <div class="">
                                            <h6 class="mb-2"><?php echo $event['jenis']; ?> <?php echo $event['mata_pelajaran']; ?></h6>
                                            <p class="mb-1 text-sm"><?php echo $event['materi']; ?></p>
                                            <span class="text-warning-600"><?php echo $event['tanggal']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                    </div>
                </div>
                <!-- Achievement Card End -->
            </div>
        </div>
        <!-- Main Content Sections End -->
    </main>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                // Create small charts for each summary card
                createMiniChart('academic-chart', '#3D7FF9'); // Blue for academic
                createMiniChart('keshaftaan-chart', '#27CFA7'); // Green for keshaftaan
                createMiniChart('attitude-chart', '#6142FF'); // Purple for attitude
                createMiniChart('rank-chart', '#FA902F'); // Orange for rank

                // Create semester progress chart
                createSemesterProgressChart();

                // Create subject performance chart
                createSubjectPerformanceChart();

                // Create hafalan donut chart
                createHafalanDonutChart();

                // Create ranking radial chart
                createRankingRadialChart();
            });

            // Function to create mini charts for summary cards
            // Function to create mini charts for summary cards
            function createMiniChart(chartId, chartColor) {
                // Pre-defined data arrays for each chart type
                const academicData = [82.5, 84.3, 86.8, 87.5];
                const keshaftaanData = [85.7, 87.2, 89.5, 90.2];
                const attitudeData = [80, 85, 88, 92];
                const rankData = [20, 40, 50, 50]; // Inverted rank data (higher is better)

                // Select the appropriate data based on chartId
                let chartData;
                if (chartId === 'academic-chart') {
                    chartData = academicData;
                } else if (chartId === 'keshaftaan-chart') {
                    chartData = keshaftaanData;
                } else if (chartId === 'attitude-chart') {
                    chartData = attitudeData;
                } else if (chartId === 'rank-chart') {
                    chartData = rankData;
                } else {
                    chartData = [70, 75, 80, 85]; // Default data
                }

                var options = {
                    series: [{
                        name: 'Nilai',
                        data: chartData
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

            // Create semester progress chart
            function createSemesterProgressChart() {
                var options = {
                    series: [{
                            name: 'Nilai Umum',
                            data: [
                                <?php
                                foreach ($academicData as $semester) {
                                    echo $semester['rata_umum'] . ', ';
                                }
                                ?>
                            ]
                        },
                        {
                            name: 'Nilai Keshaftaan',
                            data: [
                                <?php
                                foreach ($academicData as $semester) {
                                    echo $semester['rata_keshaftaan'] . ', ';
                                }
                                ?>
                            ]
                        }
                    ],
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#3D7FF9', '#27CFA7'], // Blue for Nilai Umum, Green for Nilai Keshaftaan
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
                        categories: [
                            <?php
                            foreach ($semesters as $semester) {
                                echo "'" . $semester['nama'] . " " . $semester['tahun'] . "', ";
                            }
                            ?>
                        ],
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

            // Create subject performance chart
            function createSubjectPerformanceChart() {
                var options = {
                    series: [{
                        name: 'Nilai Siswa',
                        data: [
                            <?php
                            foreach ($subjectPerformance as $subject) {
                                echo $subject['nilai'] . ', ';
                            }
                            ?>
                        ]
                    }, {
                        name: 'Rata-rata Kelas',
                        data: [
                            <?php
                            foreach ($subjectPerformance as $subject) {
                                echo $subject['rata_kelas'] . ', ';
                            }
                            ?>
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            borderRadius: 5,
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#3D7FF9', '#D0D0D0'], // Blue for student, Gray for class average
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: [
                            <?php
                            foreach ($subjectPerformance as $subject) {
                                echo "'" . $subject['mata_pelajaran'] . "', ";
                            }
                            ?>
                        ],
                        labels: {
                            style: {
                                fontSize: '10px'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Nilai'
                        },
                        min: 60,
                        max: 100
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetY: -15
                    }
                };

                var chart = new ApexCharts(document.querySelector("#subjectPerformanceChart"), options);
                chart.render();
            }

            // Create hafalan donut chart
            function createHafalanDonutChart() {
                // Count hafalan by status
                var completed = <?php echo count(array_filter($hafalanProgress, function ($item) {
                                    return $item['status'] == 'Selesai';
                                })); ?>;
                var inProgress = <?php echo count(array_filter($hafalanProgress, function ($item) {
                                        return $item['status'] == 'Dalam Proses';
                                    })); ?>;
                var notStarted = <?php echo count(array_filter($hafalanProgress, function ($item) {
                                        return $item['status'] == 'Belum Mulai';
                                    })); ?>;

                var options = {
                    series: [completed, inProgress, notStarted],
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
                                            return completed + inProgress + notStarted;
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

            // Create ranking radial chart
            function createRankingRadialChart() {
                // Calculate percentile (invert ranking - higher is better)
                var rankPercentile = 100 - ((<?php echo $currentPerformance['peringkat']; ?> / 32) * 100);

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
        </script>
    </x-slot>

</x-app-layout>
