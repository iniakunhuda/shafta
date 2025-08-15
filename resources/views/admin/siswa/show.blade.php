<x-app-layout>
    <x-slot name="styles">
        <style>
        .profile-header {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .student-details {
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
            border-bottom: 3px solid #008eff;
        }
        .category-heading {
            background-color: #f1f1f1;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .card-academic-summary {
            background-color: #e8f4ff;
            border-radius: 10px;
        }
        .table-striped>tbody>tr:nth-of-type(odd)>* {
            --bs-table-color-type: var(--bs-table-striped-color) !important;
            --bs-table-bg-type: var(--bs-table-striped-bg) !important;
        }
        </style>
    </x-slot>

    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.siswa.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">{{ __('Siswa') }}</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Detail') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Detail Siswa
    </x-slot>

    <main>
        <div class="profile-header mb-4">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="{{ $siswa->photo_url }}" alt="{{ $siswa->nama }}" class="profile-image mb-3">
                    <h4 class="mb-1">{{ $siswa->nama }}</h4>
                    <p class="text-muted mb-2">Siswa Kelas {{ $siswa->kelas }}</p>
                </div>
                <div class="col-md-9">
                    <div class="student-details">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Informasi Pribadi</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="140">NIS</td>
                                        <td width="20">:</td>
                                        <td>{{ $siswa->nis }}</td>
                                    </tr>
                                    <tr>
                                        <td>NISN</td>
                                        <td>:</td>
                                        <td>{{ $siswa->nisn }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <td>{{ $siswa->kelas }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>:</td>
                                        <td>{{ $siswa->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <td>TTL</td>
                                        <td>:</td>
                                        <td>{{ $siswa->tempat_lahir }}, {{ date('d F Y', strtotime($siswa->tanggal_lahir)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td>{{ $siswa->alamat }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Informasi Orang Tua</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="140">Nama Ayah</td>
                                        <td width="20">:</td>
                                        <td>{{ $siswa->ayah_nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan Ayah</td>
                                        <td>:</td>
                                        <td>{{ $siswa->ayah_pekerjaan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ibu</td>
                                        <td>:</td>
                                        <td>{{ $siswa->ibu_nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan Ibu</td>
                                        <td>:</td>
                                        <td>{{ $siswa->ibu_pekerjaan }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. Telepon</td>
                                        <td>:</td>
                                        <td>{{ $siswa->ayah_telp }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Records Card -->
        <div class="card">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs" id="studentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nilai-umum-tab" data-bs-toggle="tab" data-bs-target="#nilai-umum-tab-pane" type="button" role="tab" aria-controls="nilai-umum-tab-pane" aria-selected="true">
                            <i class="ph ph-book-open me-2"></i>Nilai Umum
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nilai-keshaftaan-tab" data-bs-toggle="tab" data-bs-target="#nilai-keshaftaan-tab-pane" type="button" role="tab" aria-controls="nilai-keshaftaan-tab-pane" aria-selected="false">
                            <i class="ph ph-book me-2"></i>Nilai Keshaftaan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="nilai-sikap-tab" data-bs-toggle="tab" data-bs-target="#nilai-sikap-tab-pane" type="button" role="tab" aria-controls="nilai-sikap-tab-pane" aria-selected="false">
                            <i class="ph ph-heart me-2"></i>Nilai Sikap
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="studentTabContent">
                    <!-- Nilai Umum Tab -->
                    <div class="tab-pane fade show active" id="nilai-umum-tab-pane" role="tabpanel" aria-labelledby="nilai-umum-tab" tabindex="0">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tahun Ajaran</label>
                                    <select class="form-select" id="tahunAjaranSelect" onchange="changeTahunAjaran(this.value)">
                                        @foreach ($tahunAjaran as $item)
                                            <option value="{{ $item->id }}" {{ $tahunAjaranActive->id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.siswa.export.csv', ['id' => $siswa->id, 'tahun_ajaran_id' => $tahunAjaranActive->id]) }}" class="btn btn-sm btn-outline-main">
                                        <i class="ph ph-file-csv me-1"></i> Export CSV
                                    </a>
                                    <a href="{{ route('admin.siswa.export.excel', ['id' => $siswa->id, 'tahun_ajaran_id' => $tahunAjaranActive->id]) }}" class="btn btn-sm btn-outline-main">
                                        <i class="ph ph-microsoft-excel-logo me-1"></i> Export Excel
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Mata Pelajaran</th>
                                        <th width="10%">KKM</th>
                                        <th width="10%">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($raportNilaiUmum as $index => $rn)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $rn->pelajaran->judul }}</td>
                                        <td class="text-center">{{ $rn->pelajaran->kkm ?? '-' }}</td>
                                        <td class="text-center">{{ $rn->nilai }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Academic Summary Card -->
                        @if(isset($rataRataNilaiUmum))
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <h6 class="text-muted mb-2">Rata-rata Nilai</h6>
                                        <h2 class="mb-0 fw-bold">{{ $rataRataNilaiUmum }}</h2>
                                    </div>
                                    <div class="col-md-4 text-center border-start border-end">
                                        <h6 class="text-muted mb-2">Ranking Kelas</h6>
                                        <h2 class="mb-0 fw-bold">{{ $rankingRaportNilaiUmum ?? '-' }}</h2>
                                        <small class="text-muted">dari {{ $jumlahSiswa ?? 0 }} siswa</small>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class="text-muted mb-2">Semester</h6>
                                        <h5 class="mb-0 fw-bold">{{ $raport->tahunAjaran->semester }}</h5>
                                        <small class="text-muted">{{ $raport->tahunAjaran->nama }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Nilai Keshaftaan Tab -->
                    @if(isset($raportNilaiShafta))
                    <div class="tab-pane fade" id="nilai-keshaftaan-tab-pane" role="tabpanel" aria-labelledby="nilai-keshaftaan-tab" tabindex="0">
                        @php
                            $rataRataNilaiShaftas = [];
                        @endphp
                        @foreach ($raportNilaiShafta as $index => $item)
                        @php
                            $rataRataNilaiShaftas[$index]['rataRata'] = 0;
                            $rataRataNilaiShaftas[$index]['jumlah'] = 0;
                        @endphp
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="ph ph-book me-2"></i> {{ $index }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="30%">Kategori</th>
                                                <th width="15%">Nilai</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item as $i => $item2)
                                            @php
                                                $rataRataNilaiShaftas[$index]['rataRata'] += $item2->nilai;
                                                $rataRataNilaiShaftas[$index]['jumlah']++;
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $i + 1 }}</td>
                                                <td>{{ $item2->pelajaran->judul }}</td>
                                                <td class="text-center">{{ $item2->nilai }}</td>
                                                <td>{{ $item2->keterangan }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Keshaftaan Summary Card -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($rataRataNilaiShaftas as $index => $item)
                                    <div class="col-md-3 text-center">
                                        <h6 class="text-muted mb-2">Rata-rata {{ $index }}</h6>
                                        <h2 class="mb-0 fw-bold">{{ number_format($item['rataRata'] / $item['jumlah'], 2) }}</h2>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Nilai Sikap Tab -->
                    @if(isset($raportSikap) && count($raportSikap) > 0)
                    <div class="tab-pane fade" id="nilai-sikap-tab-pane" role="tabpanel" aria-labelledby="nilai-sikap-tab" tabindex="0">
                        @foreach ($raportSikap as $index => $item)
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="ph ph-heart me-2"></i> {{ $index }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="40%">Aspek</th>
                                                <th width="15%">Nilai</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item as $i => $item2)
                                            <tr>
                                                <td class="text-center">{{ $i + 1 }}</td>
                                                <td>{{ $item2->sikap->judul }}</td>
                                                <td class="text-center">
                                                    <span class="badge {{ $item2->nilai == 'A' ? 'bg-success' : 'bg-primary' }}">
                                                        {{ $item2->nilai }}
                                                    </span>
                                                </td>
                                                <td>{{ $item2->keterangan }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Catatan Guru -->
                        <div class="card mt-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="ph ph-note-pencil me-2"></i> Catatan Guru
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach ($raportSikap as $category => $items)
                                <div class="mb-3">
                                    @foreach ($items as $item)
                                    <p class="mb-2">{{ $item->keterangan }}</p>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
    <script>
    function changeTahunAjaran(tahunAjaranId) {
        window.location.href = `{{ route('admin.siswa.show', $siswa->id) }}?tahun_ajaran_id=${tahunAjaranId}`;
    }
    </script>
    @endpush

    @push('styles')
    <style>
    .profile-image {
        border: 3px solid #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .card {
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        border: none;
    }
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        padding: 0.75rem 1.25rem;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background: none;
        border-bottom: 2px solid #0d6efd;
    }
    .table > :not(caption) > * > * {
        padding: 1rem;
    }
    .badge {
        padding: 0.5em 0.75em;
    }
    </style>
    @endpush
</x-app-layout>
