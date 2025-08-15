<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.upload-nilai-raport.step1') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Upload Nilai Raport</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Validasi Nilai Shafta') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Validasi Data Nilai Raport Shafta
    </x-slot>

    <x-slot name="styles">
        <style>
            .tab-content {
                padding: 20px;
                border: 1px solid #ddd;
                border-top: none;
                border-radius: 0 0 5px 5px;
            }
            .nav-tabs .nav-link {
                border: 1px solid #ddd;
                border-radius: 5px 5px 0 0;
                margin-right: 5px;
            }
            .nav-tabs .nav-link.active {
                background-color: #f8f9fa;
                border-bottom: 1px solid #f8f9fa;
            }
            .table-container {
                overflow-x: auto;
                max-height: 70vh;
                overflow-y: auto;
            }
            .table-responsive {
                min-height: 400px;
            }
            .alert {
                margin-top: 20px;
            }
            .table-striped>tbody>tr:nth-of-type(odd)>* {
                --bs-table-color-type: var(--bs-table-striped-color) !important;
                --bs-table-bg-type: var(--bs-table-striped-bg) !important;
            }
            .table-fixed {
                table-layout: auto;
                white-space: nowrap;
                min-width: 100%;
            }
            .table-fixed th,
            .table-fixed td {
                border: 1px solid #dee2e6;
                padding: 10px 8px;
                text-align: center;
                vertical-align: middle;
                font-size: 13px;
                min-height: 45px;
            }
            .table-fixed .student-info {
                background-color: #f8f9fa;
                font-weight: bold;
                position: sticky;
                left: 0;
                z-index: 10;
                white-space: normal;
            }
            .table-fixed .header-section {
                background-color: #e9ecef;
                font-weight: bold;
                font-size: 12px;
                padding: 12px 8px;
            }
            .readonly-cell {
                background-color: #f8f9fa;
                min-width: 80px;
                padding: 6px 4px;
            }
            .valid-cell {
                background-color: #d4edda !important;
                color: #155724;
            }
            .invalid-cell {
                background-color: #f8d7da !important;
                color: #721c24;
            }
            .warning-cell {
                background-color: #fff3cd !important;
                color: #856404;
            }
            .section-header {
                background-color: #6c757d !important;
                color: white !important;
                font-weight: bold;
                text-align: center !important;
                padding: 15px 10px !important;
                font-size: 14px;
            }

            /* Parent and Child Header Styling */
            .parent-header {
                text-orientation: mixed;
                font-size: 11px;
                padding: 8px 6px !important;
                min-width: 80px;
                max-width: 100px;
                height: 120px;
                white-space: normal;
                font-weight: bold;
            }

            .child-header {
                text-orientation: mixed;
                font-size: 10px;
                padding: 6px 4px !important;
                min-width: 70px;
                max-width: 90px;
                height: 80px;
                white-space: normal;
                font-weight: normal;
            }

            /* Keshaftaan parent headers that span multiple columns */
            .keshaftaan-parent-span {
                text-orientation: initial !important;
                height: 40px !important;
                min-height: 40px !important;
                font-size: 12px !important;
                padding: 8px 10px !important;
                text-align: center !important;
                vertical-align: middle !important;
            }

            /* Shafta specific colors */
            .pengembangan-header {
                background-color: #28a745 !important;
                color: white !important;
            }
            .ibadah-header {
                background-color: #dc3545 !important;
                color: white !important;
            }
            .keshaftaan-header {
                background-color: #ffc107 !important;
                color: black !important;
            }
            .keshaftaan-child-header {
                background-color: #f6d466 !important;
                color: black !important;
            }

            .student-cell {
                min-width: 150px;
                max-width: 250px;
                font-size: 12px;
                text-align: left !important;
                padding: 8px 10px !important;
                white-space: normal;
                word-wrap: break-word;
            }
            .number-cell {
                min-width: 50px;
                max-width: 60px;
                text-align: center !important;
            }
            .nisn-cell, .nis-cell {
                min-width: 100px;
                max-width: 120px;
                font-size: 11px;
                text-align: center !important;
                padding: 8px 6px !important;
            }
            .score-cell {
                min-width: 80px;
                max-width: 100px;
                padding: 4px 2px !important;
                font-weight: bold;
            }
            .action-buttons {
                margin-top: 20px;
                text-align: center;
            }

            /* Validation Icons */
            .validation-icon {
                font-size: 14px;
                margin-left: 4px;
            }

            .validation-summary {
                background: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
            }

            .validation-item {
                display: flex;
                align-items: center;
                margin-bottom: 8px;
            }

            .validation-item i {
                margin-right: 8px;
                font-size: 16px;
            }

            .validation-item.valid {
                color: #155724;
            }

            .validation-item.invalid {
                color: #721c24;
            }

            .validation-item.warning {
                color: #856404;
            }

            /* Section-specific styling */
            .pengembangan-section {
                background-color: #e8f5e8 !important;
            }
            .ibadah-section {
                background-color: #ffebee !important;
            }
            .keshaftaan-section {
                background-color: #fff8e1 !important;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .table-fixed th,
                .table-fixed td {
                    font-size: 11px;
                    padding: 6px 4px;
                }

                .student-cell {
                    min-width: 100px;
                    font-size: 11px;
                }

                .parent-header,
                .child-header {
                    font-size: 10px;
                    min-width: 60px;
                }
            }

            /* Print styles */
            @media print {
                .action-buttons,
                .nav-tabs,
                .alert {
                    display: none !important;
                }

                .table-container {
                    max-height: none;
                    overflow: visible;
                }

                .table-fixed th,
                .table-fixed td {
                    font-size: 10px;
                    padding: 4px 2px;
                }
            }
        </style>
    </x-slot>

    <main>
        <div class="card">
            <div class="card-header border-bottom border-gray-100 flex-align gap-8">
                <h5 class="mb-0">Validasi Data Nilai Raport Shafta</h5>
                <button type="button" class="text-main-600 text-md d-flex" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Validasi final sebelum menyimpan ke database">
                    <i class="ph-fill ph-question"></i>
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link">Upload File Excel</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link">Koreksi Data Shafta</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active btn-main" style="color:white !important" id="validasi-tab">Validasi Nilai</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" role="tabpanel">

                        <!-- Data Summary -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <h6 class="mb-2"><i class="ph ph-info"></i> Informasi Data Shafta</h6>
                                    <p class="mb-1"><strong>Jenjang:</strong> {{ request()->jenjang ?? session('upload_data.jenjang') }}</p>
                                    <p class="mb-1"><strong>Tahun Ajaran:</strong> {{ $tahunAjaran->nama ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Kelas:</strong> {{ $kelas->nama ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Total Siswa:</strong> {{ count($students_data ?? []) }} siswa</p>
                                    <p class="mb-0"><strong>Jenis Dokumen:</strong> Shafta</p>
                                </div>
                                <div class="alert alert-warning">
                                    <h5><i class="ph ph-info-circle"></i> Penting!</h5>
                                    <p>Pastikan semua data nilai Shafta sudah benar sebelum menyimpan ke database. Periksa kembali nilai.</p>
                                    <p>Jika ada data yang tidak valid atau tidak lengkap, Anda dapat kembali ke langkah sebelumnya untuk memperbaikinya.</p>
                                    <p><strong>Data akan menghapus data yang lama dan diperbarui dengan data baru sesuai pilihan tahun ajaran, kelas, dan jenjang</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- Validation Summary -->
                        @if(isset($students_data) && count($students_data) > 0)
                        <div class="validation-summary">
                            <h6 class="mb-3"><i class="ph ph-check-circle"></i> Ringkasan Validasi Shafta</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="validation-item valid">
                                        <i class="ph ph-check-circle"></i>
                                        <span>Data Siswa: <strong id="validStudents">0</strong> Valid</span>
                                    </div>
                                    <div class="validation-item valid">
                                        <i class="ph ph-check-circle"></i>
                                        <span>Nilai Valid: <strong id="validScores">0</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="validation-item warning">
                                        <i class="ph ph-warning-circle"></i>
                                        <span>Nilai Kosong: <strong id="emptyScores">0</strong></span>
                                    </div>
                                    <div class="validation-item warning">
                                        <i class="ph ph-warning-circle"></i>
                                        <span>Nilai Rendah (<50): <strong id="lowScores">0</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="validation-item invalid">
                                        <i class="ph ph-x-circle"></i>
                                        <span>Nilai Invalid: <strong id="invalidScores">0</strong></span>
                                    </div>
                                    <div class="validation-item invalid">
                                        <i class="ph ph-x-circle"></i>
                                        <span>Data Tidak Lengkap: <strong id="incompleteData">0</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <form id="validationForm" method="POST" action="{{ route('admin.upload-nilai-raport.step3.save') }}">
                            @csrf
                            <input type="hidden" name="jenjang" value="{{ request()->jenjang }}">
                            <input type="hidden" name="tahun_ajaran" value="{{ request()->tahun_ajaran }}">
                            <input type="hidden" name="kelas" value="{{ request()->kelas }}">
                            <input type="hidden" name="jenis_dokumen" value="{{ request()->jenis_dokumen }}">

                            <div class="table-container">
                                <table class="table table-bordered table-fixed">
                                    <thead>
                                        <!-- First Header Row - Main Section Names -->
                                        <tr>
                                            <th rowspan="4" class="student-info number-cell">NO</th>
                                            <th rowspan="4" class="student-info nisn-cell">NISN</th>
                                            <th rowspan="4" class="student-info nis-cell">NIS</th>
                                            <th rowspan="4" class="student-info student-cell">NAMA SISWA</th>

                                            @if(isset($pengembangan_bidang_studi) && count($pengembangan_bidang_studi) > 0)
                                                <th colspan="{{ count($pengembangan_bidang_studi) }}" class="section-header" style="background-color: #28a745 !important;">PENGEMBANGAN BIDANG STUDI</th>
                                            @endif

                                            @if(isset($ibadah) && count($ibadah) > 0)
                                                <th colspan="{{ count($ibadah) }}" class="section-header" style="background-color: #dc3545 !important; color: white !important;">IBADAH</th>
                                            @endif

                                            @if(isset($keshaftaan) && count($keshaftaan) > 0)
                                                @php
                                                    $keshaftaan_total_cols = 0;
                                                    foreach($keshaftaan as $item) {
                                                        if(isset($item['child']) && count($item['child']) > 0) {
                                                            $keshaftaan_total_cols += count($item['child']); // Only child columns for items with children
                                                        } else {
                                                            $keshaftaan_total_cols++; // Parent column for items without children
                                                        }
                                                    }
                                                @endphp
                                                <th colspan="{{ $keshaftaan_total_cols }}" class="section-header" style="background-color: #ffc107 !important;color: black !important">KESHAFTAAN</th>
                                            @endif
                                        </tr>

                                        <!-- Second Header Row - Keshaftaan Parent Categories -->
                                        <tr>
                                            <!-- Pengembangan Bidang Studi - No additional row needed -->
                                            @if(isset($pengembangan_bidang_studi))
                                                @foreach($pengembangan_bidang_studi as $subject)
                                                    <th rowspan="3" class="pengembangan-header parent-header">{{ $subject['name'] }}</th>
                                                @endforeach
                                            @endif

                                            <!-- Ibadah - No additional row needed -->
                                            @if(isset($ibadah))
                                                @foreach($ibadah as $subject)
                                                    <th rowspan="3" class="ibadah-header parent-header">{{ $subject['name'] }}</th>
                                                @endforeach
                                            @endif

                                            <!-- Keshaftaan Parent Categories -->
                                            @if(isset($keshaftaan))
                                                @foreach($keshaftaan as $subject)
                                                    @if(isset($subject['child']) && count($subject['child']) > 0)
                                                        <th colspan="{{ count($subject['child']) }}" class="keshaftaan-header parent-header" style="writing-mode: horizontal-tb; height: auto; min-height: 40px;">{{ $subject['name'] }}</th>
                                                    @else
                                                        <th rowspan="3" class="keshaftaan-header parent-header">{{ $subject['name'] }}</th>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tr>

                                        <!-- Third Header Row - Child Categories (only for Keshaftaan with children) -->
                                        <tr>
                                            @if(isset($keshaftaan))
                                                @foreach($keshaftaan as $subject)
                                                    @if(isset($subject['child']) && count($subject['child']) > 0)
                                                        @foreach($subject['child'] as $child)
                                                            <th class="keshaftaan-child-header child-header">{{ $child['name'] }}</th>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students_data as $index => $student)
                                        <tr>
                                            <td class="student-info number-cell">{{ $student['no'] ?? ($index + 1) }}</td>
                                            <td class="student-info nisn-cell {{ empty($student['nisn']) ? 'invalid-cell' : 'valid-cell' }}">
                                                {{ $student['nisn'] }}
                                                @if(empty($student['nisn']))
                                                    <i class="ph ph-warning-circle validation-icon text-danger" title="NISN tidak boleh kosong"></i>
                                                @endif
                                            </td>
                                            <td class="student-info nis-cell {{ empty($student['nis']) ? 'invalid-cell' : 'valid-cell' }}">
                                                {{ $student['nis'] }}
                                                @if(empty($student['nis']))
                                                    <i class="ph ph-warning-circle validation-icon text-danger" title="NIS tidak boleh kosong"></i>
                                                @endif
                                            </td>
                                            <td class="student-info student-cell {{ empty($student['nama_siswa']) ? 'invalid-cell' : 'valid-cell' }}">
                                                {{ $student['nama_siswa'] }}
                                                @if(empty($student['nama_siswa']))
                                                    <i class="ph ph-warning-circle validation-icon text-danger" title="Nama siswa tidak boleh kosong"></i>
                                                @endif
                                            </td>

                                            <!-- Pengembangan Bidang Studi Scores -->
                                            @if(isset($pengembangan_bidang_studi))
                                                @foreach($pengembangan_bidang_studi as $subject)
                                                    @php
                                                        $score = $student['pengembangan_bidang_studi'][$subject['name']] ?? '';
                                                        $cellClass = 'readonly-cell score-cell pengembangan-section';
                                                        $icon = '';
                                                        $title = '';

                                                        if (empty($score)) {
                                                            $cellClass .= ' warning-cell';
                                                            $icon = '<i class="ph ph-warning-circle validation-icon text-warning"></i>';
                                                            $title = 'Nilai kosong';
                                                        } elseif (!is_numeric($score) && !in_array(strtoupper($score), ['A', 'B', 'C', 'D'])) {
                                                            $cellClass .= ' invalid-cell';
                                                            $icon = '<i class="ph ph-x-circle validation-icon text-danger"></i>';
                                                            $title = 'Nilai tidak valid';
                                                        } elseif (is_numeric($score) && ($score < 0 || $score > 100)) {
                                                            $cellClass .= ' invalid-cell';
                                                            $icon = '<i class="ph ph-x-circle validation-icon text-danger"></i>';
                                                            $title = 'Nilai harus 0-100 atau A-D';
                                                        } elseif (is_numeric($score) && $score < 50) {
                                                            $cellClass .= ' warning-cell';
                                                            $icon = '<i class="ph ph-warning-circle validation-icon text-warning"></i>';
                                                            $title = 'Nilai di bawah KKM';
                                                        } else {
                                                            $cellClass .= ' valid-cell';
                                                            $icon = '<i class="ph ph-check-circle validation-icon text-success"></i>';
                                                            $title = 'Nilai valid';
                                                        }
                                                    @endphp
                                                    <td class="{{ $cellClass }}" title="{{ $title }}">
                                                        {{ $score }}
                                                        {!! $icon !!}
                                                    </td>
                                                @endforeach
                                            @endif

                                            <!-- Ibadah Scores -->
                                            @if(isset($ibadah))
                                                @foreach($ibadah as $subject)
                                                    @php
                                                        $score = $student['ibadah'][$subject['name']] ?? '';
                                                        $cellClass = 'readonly-cell score-cell ibadah-section';
                                                        $icon = '';
                                                        $title = '';

                                                        if (empty($score)) {
                                                            $cellClass .= ' warning-cell';
                                                            $icon = '<i class="ph ph-warning-circle validation-icon text-warning"></i>';
                                                            $title = 'Nilai kosong';
                                                        } elseif (!is_numeric($score) && !in_array(strtoupper($score), ['A', 'B', 'C', 'D'])) {
                                                            $cellClass .= ' invalid-cell';
                                                            $icon = '<i class="ph ph-x-circle validation-icon text-danger"></i>';
                                                            $title = 'Nilai tidak valid';
                                                        } elseif (is_numeric($score) && ($score < 0 || $score > 100)) {
                                                            $cellClass .= ' invalid-cell';
                                                            $icon = '<i class="ph ph-x-circle validation-icon text-danger"></i>';
                                                            $title = 'Nilai harus 0-100 atau A-D';
                                                        } elseif (is_numeric($score) && $score < 50) {
                                                            $cellClass .= ' warning-cell';
                                                            $icon = '<i class="ph ph-warning-circle validation-icon text-warning"></i>';
                                                            $title = 'Nilai di bawah KKM';
                                                        } else {
                                                            $cellClass .= ' valid-cell';
                                                            $icon = '<i class="ph ph-check-circle validation-icon text-success"></i>';
                                                            $title = 'Nilai valid';
                                                        }
                                                    @endphp
                                                    <td class="{{ $cellClass }}" title="{{ $title }}">
                                                        {{ $score }}
                                                        {!! $icon !!}
                                                    </td>
                                                @endforeach
                                            @endif

                                            <!-- Keshaftaan Scores -->
                                            @if(isset($keshaftaan))
                                                @foreach($keshaftaan as $subject)
                                                    @if(isset($subject['child']) && count($subject['child']) > 0)
                                                        <!-- Only show child scores for items with children -->
                                                        @foreach($subject['child'] as $child)
                                                            @php
                                                                $score = $student['keshaftaan'][$child['name']] ?? '';
                                                                $cellClass = 'readonly-cell score-cell keshaftaan-section';
                                                                $icon = '';
                                                                $title = '';

                                                                if (empty($score)) {
                                                                    $cellClass .= ' warning-cell';
                                                                    $icon = '<i class="ph ph-warning-circle validation-icon text-warning"></i>';
                                                                    $title = 'Nilai kosong';
                                                                } elseif (!is_numeric($score) && !in_array(strtoupper($score), ['A', 'B', 'C', 'D'])) {
                                                                    $cellClass .= ' invalid-cell';
                                                                    $icon = '<i class="ph ph-x-circle validation-icon text-danger"></i>';
                                                                    $title = 'Nilai tidak valid';
                                                                } elseif (is_numeric($score) && ($score < 0 || $score > 100)) {
                                                                    $cellClass .= ' invalid-cell';
                                                                    $icon = '<i class="ph ph-x-circle validation-icon text-danger"></i>';
                                                                    $title = 'Nilai harus 0-100 atau A-D';
                                                                } elseif (is_numeric($score) && $score < 50) {
                                                                    $cellClass .= ' warning-cell';
                                                                    $icon = '<i class="ph ph-warning-circle validation-icon text-warning"></i>';
                                                                    $title = 'Nilai di bawah KKM';
                                                                } else {
                                                                    $cellClass .= ' valid-cell';
                                                                    $icon = '<i class="ph ph-check-circle validation-icon text-success"></i>';
                                                                    $title = 'Nilai valid';
                                                                }
                                                            @endphp
                                                            <td class="{{ $cellClass }}" title="{{ $title }}">
                                                                {{ $score }}
                                                                {!! $icon !!}
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        <!-- Show parent score for items without children -->
                                                        @php
                                                            $score = $student['keshaftaan'][$subject['name']] ?? '';
                                                            $cellClass = 'readonly-cell score-cell keshaftaan-section';
                                                            $icon = '';
                                                            $title = '';

                                                            if (empty($score)) {
                                                                $cellClass .= ' warning-cell';
                                                                $icon = '<i class="ph ph-warning-circle validation-icon text-warning"></i>';
                                                                $title = 'Nilai kosong';
                                                            } elseif (!is_numeric($score) && !in_array(strtoupper($score), ['A', 'B', 'C', 'D'])) {
                                                                $cellClass .= ' invalid-cell';
                                                                $icon = '<i class="ph ph-x-circle validation-icon text-danger"></i>';
                                                                $title = 'Nilai tidak valid';
                                                            } elseif (is_numeric($score) && ($score < 0 || $score > 100)) {
                                                                $cellClass .= ' invalid-cell';
                                                                $icon = '<i class="ph ph-x-circle validation-icon text-danger"></i>';
                                                                $title = 'Nilai harus 0-100 atau A-D';
                                                            } elseif (is_numeric($score) && $score < 50) {
                                                                $cellClass .= ' warning-cell';
                                                                $icon = '<i class="ph ph-warning-circle validation-icon text-warning"></i>';
                                                                $title = 'Nilai di bawah KKM';
                                                            } else {
                                                                $cellClass .= ' valid-cell';
                                                                $icon = '<i class="ph ph-check-circle validation-icon text-success"></i>';
                                                                $title = 'Nilai valid';
                                                            }
                                                        @endphp
                                                        <td class="{{ $cellClass }}" title="{{ $title }}">
                                                            {{ $score }}
                                                            {!! $icon !!}
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <button type="button" class="btn btn-secondary rounded-pill py-9 px-20 me-3" onclick="window.location.href='{{ route('admin.upload-nilai-raport.step2') }}?jenjang={{ request()->jenjang }}&tahun_ajaran={{ request()->tahun_ajaran }}&kelas={{ request()->kelas }}&jenis_dokumen={{ request()->jenis_dokumen }}'">
                                    <i class="ph ph-arrow-left me-2"></i>Kembali ke Koreksi
                                </button>
                                <button type="submit" class="btn btn-success rounded-pill py-9 px-20 me-3" id="saveButton">
                                    <i class="ph ph-database me-2"></i>Simpan ke Database
                                </button>
                                <button type="button" class="btn btn-danger rounded-pill py-9 px-20" onclick="clearAllData()">
                                    <i class="ph ph-trash me-2"></i>Reset Data
                                </button>
                            </div>
                        </form>

                        @else
                        <div class="alert alert-warning text-center">
                            <h5><i class="ph ph-warning-circle"></i> Tidak Ada Data</h5>
                            <p>Tidak ada data siswa yang ditemukan. Silakan kembali ke langkah upload dan pastikan file Excel memiliki format yang benar.</p>
                            <br>
                            <button type="button" class="btn btn-main rounded-pill py-9" onclick="window.location.href='{{ route('admin.upload-nilai-raport.step1') }}'">
                                <i class="ph ph-arrow-left me-2"></i>Kembali ke Upload
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-slot name="scripts">
        <script>
            function clearAllData() {
                if (confirm('Apakah Anda yakin ingin menghapus semua data? Anda akan kembali ke langkah upload.')) {
                    window.location.href = "{{ route('admin.upload-nilai-raport.clear-session') }}";
                }
            }

            function validateAndSave() {
                const saveButton = document.getElementById('saveButton');
                const originalText = saveButton.innerHTML;

                // Show loading state
                saveButton.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Menyimpan...';
                saveButton.disabled = true;

                // Validate all data before saving
                const invalidScores = document.querySelectorAll('.invalid-cell').length;
                const incompleteData = document.querySelectorAll('.student-info.invalid-cell').length;

                if (invalidScores > 0 || incompleteData > 0) {
                    if (!confirm(`Ditemukan ${invalidScores} nilai tidak valid dan ${incompleteData} data tidak lengkap. Apakah Anda yakin ingin melanjutkan?`)) {
                        saveButton.innerHTML = originalText;
                        saveButton.disabled = false;
                        return false;
                    }
                }

                // Submit the form
                document.getElementById('validationForm').submit();
            }

            // Calculate validation statistics
            document.addEventListener('DOMContentLoaded', function() {
                calculateValidationStats();

                // Add confirmation to save button
                document.getElementById('saveButton').addEventListener('click', function(e) {
                    e.preventDefault();
                    validateAndSave();
                });
            });

            function calculateValidationStats() {
                const students = document.querySelectorAll('tbody tr');
                const allCells = document.querySelectorAll('tbody .readonly-cell');
                const validCells = document.querySelectorAll('tbody .valid-cell');
                const warningCells = document.querySelectorAll('tbody .warning-cell');
                const invalidCells = document.querySelectorAll('tbody .invalid-cell');
                const incompleteStudentData = document.querySelectorAll('.student-info.invalid-cell');

                // Count specific validation types
                let validScores = 0;
                let emptyScores = 0;
                let lowScores = 0;
                let invalidScores = 0;

                allCells.forEach(cell => {
                    const cellValue = cell.textContent.trim();
                    const hasIcon = cell.querySelector('.validation-icon');

                    if (cell.classList.contains('valid-cell')) {
                        validScores++;
                    } else if (cell.classList.contains('warning-cell')) {
                        if (!cellValue || cellValue === '') {
                            emptyScores++;
                        } else {
                            lowScores++;
                        }
                    } else if (cell.classList.contains('invalid-cell')) {
                        invalidScores++;
                    }
                });

                // Update summary
                document.getElementById('validStudents').textContent = students.length;
                document.getElementById('validScores').textContent = validScores;
                document.getElementById('emptyScores').textContent = emptyScores;
                document.getElementById('lowScores').textContent = lowScores;
                document.getElementById('invalidScores').textContent = invalidScores;
                document.getElementById('incompleteData').textContent = incompleteStudentData.length;

                // Update save button state
                const saveButton = document.getElementById('saveButton');
                if (invalidScores > 0 || incompleteStudentData.length > 0) {
                    saveButton.classList.remove('btn-success');
                    saveButton.classList.add('btn-warning');
                    saveButton.innerHTML = '<i class="ph ph-warning me-2"></i>Simpan dengan Peringatan';
                } else {
                    saveButton.classList.remove('btn-warning');
                    saveButton.classList.add('btn-success');
                    saveButton.innerHTML = '<i class="ph ph-database me-2"></i>Simpan ke Database';
                }
            }

            // Add tooltips for better UX
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Bootstrap tooltips if available
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }

                // Add section-specific highlighting on hover
                const pengembanganCells = document.querySelectorAll('.pengembangan-section');
                const ibadahCells = document.querySelectorAll('.ibadah-section');
                const keshaftaanCells = document.querySelectorAll('.keshaftaan-section');

                pengembanganCells.forEach(cell => {
                    cell.addEventListener('mouseenter', function() {
                        pengembanganCells.forEach(c => c.style.backgroundColor = '#e8f5e8');
                    });
                    cell.addEventListener('mouseleave', function() {
                        pengembanganCells.forEach(c => c.style.backgroundColor = '');
                    });
                });

                ibadahCells.forEach(cell => {
                    cell.addEventListener('mouseenter', function() {
                        ibadahCells.forEach(c => c.style.backgroundColor = '#ffebee');
                    });
                    cell.addEventListener('mouseleave', function() {
                        ibadahCells.forEach(c => c.style.backgroundColor = '');
                    });
                });

                keshaftaanCells.forEach(cell => {
                    cell.addEventListener('mouseenter', function() {
                        keshaftaanCells.forEach(c => c.style.backgroundColor = '#fff8e1');
                    });
                    cell.addEventListener('mouseleave', function() {
                        keshaftaanCells.forEach(c => c.style.backgroundColor = '');
                    });
                });
            });

            // Print functionality
            function printValidationTable() {
                window.print();
            }

            // Export to PDF functionality (if needed)
            function exportToPDF() {
                // This would require additional libraries like jsPDF
                alert('Fitur export PDF akan segera tersedia');
            }

            // Keyboard navigation for better accessibility
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key) {
                        case 's':
                            e.preventDefault();
                            document.getElementById('saveButton').click();
                            break;
                        case 'p':
                            e.preventDefault();
                            printValidationTable();
                            break;
                    }
                }
            });

            // Auto-scroll to problematic data
            function scrollToProblematicData() {
                const invalidCell = document.querySelector('.invalid-cell');
                if (invalidCell) {
                    invalidCell.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    invalidCell.style.boxShadow = '0 0 10px rgba(220, 53, 69, 0.5)';
                    setTimeout(() => {
                        invalidCell.style.boxShadow = '';
                    }, 3000);
                }
            }

            // Add scroll to problematic data button if issues found
            document.addEventListener('DOMContentLoaded', function() {
                const invalidCells = document.querySelectorAll('.invalid-cell');
                if (invalidCells.length > 0) {
                    const actionButtons = document.querySelector('.action-buttons');
                    const scrollButton = document.createElement('button');
                    scrollButton.type = 'button';
                    scrollButton.className = 'btn btn-info rounded-pill py-9 px-20 me-3';
                    scrollButton.innerHTML = '<i class="ph ph-magnifying-glass me-2"></i>Lihat Masalah';
                    scrollButton.onclick = scrollToProblematicData;
                    actionButtons.insertBefore(scrollButton, actionButtons.children[1]);
                }
            });
        </script>
    </x-slot>
</x-app-layout>
