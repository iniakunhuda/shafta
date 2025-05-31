@extends('layouts.app')

@section('title', 'Detail Raport - Shafta E-Raport')

@section('content')
<div class="dashboard-body">
    <!-- Header Section Start -->
    <div class="card mb-24">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="mb-2">Detail Raport</h2>
                    <p class="text-gray-600">Semester {{ $currentSemester->nama }} - Tahun Ajaran {{ $currentSemester->tahun }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <button class="btn btn-outline-main rounded-pill" onclick="window.print()">
                        <i class="ph ph-printer me-2"></i> Cetak Raport
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Section End -->

    <!-- Student Info Section Start -->
    <div class="card mb-24">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    <img src="{{ asset('assets/images/thumbs/' . auth()->user()->foto) }}" alt="{{ auth()->user()->name }}" class="w-120 h-120 rounded-circle object-fit-cover mb-3">
                    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-gray-600">{{ auth()->user()->kelas }}</p>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-gray-600" width="40%">NIS</td>
                                    <td>: {{ auth()->user()->nis }}</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-600">NISN</td>
                                    <td>: {{ auth()->user()->nisn }}</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-600">Kelas</td>
                                    <td>: {{ auth()->user()->kelas }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-gray-600" width="40%">Semester</td>
                                    <td>: {{ $currentSemester->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-600">Tahun Ajaran</td>
                                    <td>: {{ $currentSemester->tahun }}</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-600">Status</td>
                                    <td>: <span class="badge bg-success-50 text-success-600">Aktif</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Student Info Section End -->

    <!-- Subject Detail Section Start -->
    <div class="card mb-24">
        <div class="card-header border-bottom border-gray-100">
            <h5 class="mb-0">Detail Nilai Mata Pelajaran</h5>
        </div>
        <div class="card-body">
            @foreach($subjectDetails as $subject)
            <div class="subject-detail mb-4 {{ !$loop->last ? 'border-bottom border-gray-100 pb-4' : '' }}">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <div class="flex-align gap-8">
                            <div class="w-40 h-40 rounded-circle {{ $subject->color }} flex-center flex-shrink-0">
                                <img src="{{ asset('assets/images/icons/' . $subject->icon) }}" alt="">
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $subject->mata_pelajaran }}</h6>
                                <span class="text-13 text-gray-600">{{ $subject->guru }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="flex-align justify-content-md-end gap-8">
                            <div class="text-center">
                                <h6 class="mb-1">Nilai Akhir</h6>
                                @php
                                    $badgeClass = '';
                                    if ($subject->nilai_akhir >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                    elseif ($subject->nilai_akhir >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                    elseif ($subject->nilai_akhir >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                    else $badgeClass = 'bg-danger-50 text-danger-600';
                                @endphp
                                <span class="text-13 py-2 px-8 {{ $badgeClass }} d-inline-flex align-items-center rounded-pill fw-bold">
                                    {{ $subject->nilai_akhir }}
                                </span>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-1">Predikat</h6>
                                <span class="badge {{ $subject->predikat_color }}">{{ $subject->predikat }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Knowledge Assessment Start -->
                <div class="mb-4">
                    <h6 class="mb-3">Penilaian Pengetahuan</h6>
                    <div class="table-responsive">
                        <table class="table style-two mb-0">
                            <thead>
                                <tr>
                                    <th>Jenis Penilaian</th>
                                    <th>Nilai</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subject->penilaian_pengetahuan as $penilaian)
                                <tr>
                                    <td>{{ $penilaian->jenis }}</td>
                                    <td>
                                        @php
                                            $badgeClass = '';
                                            if ($penilaian->nilai >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                            elseif ($penilaian->nilai >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                            elseif ($penilaian->nilai >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                            else $badgeClass = 'bg-danger-50 text-danger-600';
                                        @endphp
                                        <span class="text-13 py-2 px-8 {{ $badgeClass }} d-inline-flex align-items-center rounded-pill fw-bold">
                                            {{ $penilaian->nilai }}
                                        </span>
                                    </td>
                                    <td>{{ $penilaian->tanggal->format('d M Y') }}</td>
                                    <td>{{ $penilaian->deskripsi }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Knowledge Assessment End -->

                <!-- Skill Assessment Start -->
                <div class="mb-4">
                    <h6 class="mb-3">Penilaian Keterampilan</h6>
                    <div class="table-responsive">
                        <table class="table style-two mb-0">
                            <thead>
                                <tr>
                                    <th>Jenis Penilaian</th>
                                    <th>Nilai</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subject->penilaian_keterampilan as $penilaian)
                                <tr>
                                    <td>{{ $penilaian->jenis }}</td>
                                    <td>
                                        @php
                                            $badgeClass = '';
                                            if ($penilaian->nilai >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                            elseif ($penilaian->nilai >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                            elseif ($penilaian->nilai >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                            else $badgeClass = 'bg-danger-50 text-danger-600';
                                        @endphp
                                        <span class="text-13 py-2 px-8 {{ $badgeClass }} d-inline-flex align-items-center rounded-pill fw-bold">
                                            {{ $penilaian->nilai }}
                                        </span>
                                    </td>
                                    <td>{{ $penilaian->tanggal->format('d M Y') }}</td>
                                    <td>{{ $penilaian->deskripsi }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Skill Assessment End -->

                <!-- Competency Description Start -->
                <div>
                    <h6 class="mb-3">Deskripsi Kompetensi</h6>
                    <div class="bg-gray-50 rounded-8 p-16">
                        <p class="text-gray-600 mb-0">{{ $subject->deskripsi_kompetensi }}</p>
                    </div>
                </div>
                <!-- Competency Description End -->
            </div>
            @endforeach
        </div>
    </div>
    <!-- Subject Detail Section End -->

    <!-- Attitude Assessment Section Start -->
    <div class="card mb-24">
        <div class="card-header border-bottom border-gray-100">
            <h5 class="mb-0">Penilaian Sikap</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="attitude-item bg-gray-50 rounded-8 p-16">
                        <h6 class="mb-3">Spiritual</h6>
                        <div class="flex-between align-items-center mb-2">
                            <span class="text-gray-600">Predikat</span>
                            <span class="badge {{ $attitudeAssessment->spiritual_color }}">{{ $attitudeAssessment->spiritual_predikat }}</span>
                        </div>
                        <p class="text-gray-600 mb-0">{{ $attitudeAssessment->spiritual_deskripsi }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="attitude-item bg-gray-50 rounded-8 p-16">
                        <h6 class="mb-3">Sosial</h6>
                        <div class="flex-between align-items-center mb-2">
                            <span class="text-gray-600">Predikat</span>
                            <span class="badge {{ $attitudeAssessment->sosial_color }}">{{ $attitudeAssessment->sosial_predikat }}</span>
                        </div>
                        <p class="text-gray-600 mb-0">{{ $attitudeAssessment->sosial_deskripsi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Attitude Assessment Section End -->

    <!-- Extracurricular Section Start -->
    <div class="card mb-24">
        <div class="card-header border-bottom border-gray-100">
            <h5 class="mb-0">Ekstrakurikuler</h5>
        </div>
        <div class="card-body">
            @foreach($extracurriculars as $extra)
            <div class="extra-item mb-4 {{ !$loop->last ? 'border-bottom border-gray-100 pb-4' : '' }}">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="flex-align gap-8">
                            <div class="w-40 h-40 rounded-circle {{ $extra->color }} flex-center flex-shrink-0">
                                <img src="{{ asset('assets/images/icons/' . $extra->icon) }}" alt="">
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $extra->nama }}</h6>
                                <span class="text-13 text-gray-600">{{ $extra->pembina }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="flex-align justify-content-md-end gap-8">
                            <div class="text-center">
                                <h6 class="mb-1">Predikat</h6>
                                <span class="badge {{ $extra->predikat_color }}">{{ $extra->predikat }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <h6 class="mb-2">Deskripsi</h6>
                    <p class="text-gray-600 mb-0">{{ $extra->deskripsi }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Extracurricular Section End -->

    <!-- Attendance Section Start -->
    <div class="card mb-24">
        <div class="card-header border-bottom border-gray-100">
            <h5 class="mb-0">Kehadiran</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="attendance-item bg-gray-50 rounded-8 p-16 text-center">
                        <h3 class="mb-2">{{ $attendance->hadir }}</h3>
                        <span class="text-gray-600">Hadir</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="attendance-item bg-gray-50 rounded-8 p-16 text-center">
                        <h3 class="mb-2">{{ $attendance->izin }}</h3>
                        <span class="text-gray-600">Izin</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="attendance-item bg-gray-50 rounded-8 p-16 text-center">
                        <h3 class="mb-2">{{ $attendance->sakit }}</h3>
                        <span class="text-gray-600">Sakit</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="attendance-item bg-gray-50 rounded-8 p-16 text-center">
                        <h3 class="mb-2">{{ $attendance->alpha }}</h3>
                        <span class="text-gray-600">Alpha</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Attendance Section End -->

    <!-- Notes Section Start -->
    <div class="card mb-24">
        <div class="card-header border-bottom border-gray-100">
            <h5 class="mb-0">Catatan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="note-item bg-gray-50 rounded-8 p-16">
                        <h6 class="mb-3">Catatan Wali Kelas</h6>
                        <p class="text-gray-600 mb-0">{{ $notes->wali_kelas }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="note-item bg-gray-50 rounded-8 p-16">
                        <h6 class="mb-3">Catatan Kepala Sekolah</h6>
                        <p class="text-gray-600 mb-0">{{ $notes->kepala_sekolah }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Notes Section End -->

    <!-- Signatures Section Start -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <p class="mb-4">Mengetahui,<br>Orang Tua/Wali</p>
                    <div class="signature-space"></div>
                    <p class="mt-4">( {{ auth()->user()->nama_ortu }} )</p>
                </div>
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <p class="mb-4">Wali Kelas</p>
                    <div class="signature-space"></div>
                    <p class="mt-4">( {{ $waliKelas->nama }} )</p>
                </div>
                <div class="col-md-4 text-center">
                    <p class="mb-4">Kepala Sekolah</p>
                    <div class="signature-space"></div>
                    <p class="mt-4">( {{ $kepalaSekolah->nama }} )</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Signatures Section End -->
</div>
@endsection

@push('styles')
<style>
    @media print {
        .btn, .card-header {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .signature-space {
            height: 100px;
            border-bottom: 1px solid #000;
            margin: 0 auto;
            width: 200px;
        }
    }
</style>
@endpush 