<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.upload-nilai-raport.step1') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Upload Nilai Raport</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Koreksi Data Shafta') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Koreksi Data Nilai Raport
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
                left: -0.3px;
                z-index: 10;
                white-space: normal;
            }
            .table-fixed .header-section {
                background-color: #e9ecef;
                font-weight: bold;
                font-size: 12px;
                padding: 12px 8px;
            }
            .editable-cell {
                background-color: #fff3cd;
                cursor: pointer;
                min-width: 80px;
                padding: 6px 4px;
            }
            .editable-cell:hover {
                background-color: #ffeaa7;
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
                /**writing-mode: vertical-rl;**/
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
                /**writing-mode: vertical-rl;**/
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
                /**writing-mode: horizontal-tb !important;**/
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
            }
            .action-buttons {
                margin-top: 20px;
                text-align: center;
            }

            /* Input styling within cells */
            .table-fixed input.form-control {
                font-size: 12px;
                padding: 6px 8px;
                border: 1px solid transparent;
                background: transparent;
                width: 100%;
                min-height: 32px;
            }

            .table-fixed input.form-control:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
                background-color: white;
            }

            .score-input {
                width: 100%;
                text-align: center;
                font-size: 12px;
                padding: 4px 6px;
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
        </style>
    </x-slot>

    <main>
        <div class="card">
            <div class="card-header border-bottom border-gray-100 flex-align gap-8">
                <h5 class="mb-0">Koreksi Data Nilai Raport</h5>
                <button type="button" class="text-main-600 text-md d-flex" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Koreksi dan validasi data nilai shafta sebelum menyimpan">
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
                        <button class="nav-link active btn-main" style="color:white !important" id="koreksi-tab">Koreksi Data</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="validasi-tab">Validasi Nilai</button>
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
                                    <p class="mb-1"><strong>Jenis Dokumen:</strong> Shafta</p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Table -->
                        @if(isset($students_data) && count($students_data) > 0)
                        <form id="correctionForm" method="POST" action="{{ route('admin.upload-nilai-raport.step2.save') }}">
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
                                            <td class="student-info nisn-cell">
                                                <input type="text"
                                                       name="students[{{ $index }}][nisn]"
                                                       value="{{ $student['nisn'] }}"
                                                       class="form-control form-control-sm text-center">
                                            </td>
                                            <td class="student-info nis-cell">
                                                <input type="text"
                                                       name="students[{{ $index }}][nis]"
                                                       value="{{ $student['nis'] }}"
                                                       class="form-control form-control-sm text-center">
                                            </td>
                                            <td class="student-info student-cell">
                                                <input type="text"
                                                       name="students[{{ $index }}][nama_siswa]"
                                                       value="{{ $student['nama_siswa'] }}"
                                                       class="form-control form-control-sm">
                                            </td>

                                            <!-- Pengembangan Bidang Studi Scores -->
                                            @if(isset($pengembangan_bidang_studi))
                                                @foreach($pengembangan_bidang_studi as $subject)
                                                    <td class="editable-cell score-cell pengembangan-section">
                                                        <input type="text"
                                                               name="students[{{ $index }}][pengembangan_bidang_studi][{{ $subject['name'] }}]"
                                                               value="{{ $student['pengembangan_bidang_studi'][$subject['name']] ?? '' }}"
                                                               class="form-control form-control-sm score-input"
                                                               placeholder="-">
                                                    </td>
                                                @endforeach
                                            @endif

                                            <!-- Ibadah Scores -->
                                            @if(isset($ibadah))
                                                @foreach($ibadah as $subject)
                                                    <td class="editable-cell score-cell ibadah-section">
                                                        <input type="text"
                                                               name="students[{{ $index }}][ibadah][{{ $subject['name'] }}]"
                                                               value="{{ $student['ibadah'][$subject['name']] ?? '' }}"
                                                               class="form-control form-control-sm score-input"
                                                               placeholder="-">
                                                    </td>
                                                @endforeach
                                            @endif

                                            <!-- Keshaftaan Scores -->
                                            @if(isset($keshaftaan))
                                                @foreach($keshaftaan as $subject)
                                                    @if(isset($subject['child']) && count($subject['child']) > 0)
                                                        <!-- Only show child scores for items with children -->
                                                        @foreach($subject['child'] as $child)
                                                            <td class="editable-cell score-cell keshaftaan-section">
                                                                <input type="text"
                                                                       name="students[{{ $index }}][keshaftaan][{{ $child['name'] }}]"
                                                                       value="{{ $student['keshaftaan'][$child['name']] ?? '' }}"
                                                                       class="form-control form-control-sm score-input"
                                                                       placeholder="-">
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        <!-- Show parent score for items without children -->
                                                        <td class="editable-cell score-cell keshaftaan-section">
                                                            <input type="text"
                                                                   name="students[{{ $index }}][keshaftaan][{{ $subject['name'] }}]"
                                                                   value="{{ $student['keshaftaan'][$subject['name']] ?? '' }}"
                                                                   class="form-control form-control-sm score-input"
                                                                   placeholder="-">
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
                                <button type="button" class="btn btn-secondary rounded-pill py-9 px-20 me-3" onclick="window.location.href='{{ route('admin.upload-nilai-raport.step1') }}'">
                                    <i class="ph ph-arrow-left me-2"></i>Kembali ke Upload
                                </button>
                                <button type="submit" class="btn btn-main rounded-pill py-9 px-20 me-3">
                                    <i class="ph ph-floppy-disk me-2"></i>Simpan Koreksi
                                </button>
                                <button type="button" class="btn btn-success rounded-pill py-9 px-20" onclick="proceedToValidation()">
                                    <i class="ph ph-check-circle me-2"></i>Lanjut ke Validasi
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
            function proceedToValidation() {
                // Save current form data first (optional auto-save)
                const formData = new FormData(document.getElementById('correctionForm'));

                // Redirect to validation step
                window.location.href = "{{ route('admin.upload-nilai-raport.step3') }}?" +
                                     "jenjang={{ request()->jenjang }}&" +
                                     "tahun_ajaran={{ request()->tahun_ajaran }}&" +
                                     "kelas={{ request()->kelas }}&" +
                                     "jenis_dokumen={{ request()->jenis_dokumen }}";
            }

            // Auto-save functionality and visual feedback
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('input[type="text"]');

                inputs.forEach(input => {
                    input.addEventListener('change', function() {
                        // Visual feedback for changed values
                        this.style.backgroundColor = '#e3f2fd';
                        setTimeout(() => {
                            this.style.backgroundColor = '';
                        }, 1000);
                    });
                });

                // Add tooltip for editable cells
                const editableCells = document.querySelectorAll('.editable-cell');
                editableCells.forEach(cell => {
                    cell.setAttribute('title', 'Klik untuk mengedit nilai');
                });

                // Section-based color coding for better UX
                const pengembanganCells = document.querySelectorAll('.pengembangan-section');
                const ibadahCells = document.querySelectorAll('.ibadah-section');
                const keshaftaanCells = document.querySelectorAll('.keshaftaan-section');

                pengembanganCells.forEach(cell => {
                    const input = cell.querySelector('input');
                    if (input) {
                        input.addEventListener('focus', function() {
                            this.parentElement.style.backgroundColor = '#d4edda';
                        });
                        input.addEventListener('blur', function() {
                            this.parentElement.style.backgroundColor = '';
                        });
                    }
                });

                ibadahCells.forEach(cell => {
                    const input = cell.querySelector('input');
                    if (input) {
                        input.addEventListener('focus', function() {
                            this.parentElement.style.backgroundColor = '#fff3cd';
                        });
                        input.addEventListener('blur', function() {
                            this.parentElement.style.backgroundColor = '';
                        });
                    }
                });

                keshaftaanCells.forEach(cell => {
                    const input = cell.querySelector('input');
                    if (input) {
                        input.addEventListener('focus', function() {
                            this.parentElement.style.backgroundColor = '#f8d7da';
                        });
                        input.addEventListener('blur', function() {
                            this.parentElement.style.backgroundColor = '';
                        });
                    }
                });
            });

            // Form validation before submission
            document.getElementById('correctionForm').addEventListener('submit', function(e) {
                const requiredFields = document.querySelectorAll('input[name*="[nama_siswa]"], input[name*="[nis]"]');
                let hasEmpty = false;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.style.borderColor = '#dc3545';
                        hasEmpty = true;
                    } else {
                        field.style.borderColor = '';
                    }
                });

                if (hasEmpty) {
                    e.preventDefault();
                    alert('Mohon lengkapi data siswa yang masih kosong (Nama dan NIS wajib diisi)');
                    return false;
                }
            });

            // Real-time validation for required fields
            document.addEventListener('input', function(e) {
                if (e.target.name && (e.target.name.includes('[nama_siswa]') || e.target.name.includes('[nis]'))) {
                    if (e.target.value.trim()) {
                        e.target.style.borderColor = '#28a745';
                    } else {
                        e.target.style.borderColor = '#dc3545';
                    }
                }
            });
        </script>
    </x-slot>
</x-app-layout>
