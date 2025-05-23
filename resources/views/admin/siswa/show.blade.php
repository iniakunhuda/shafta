<x-app-layout>
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

       
  <div class="card">
    <div class="card-body">
      <!-- Profile Header -->
      <div class="profile-header mb-4">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="{{ asset('storage/siswa/' . $siswa->foto) }}" alt="{{ $siswa->nama }}" class="profile-image mb-3">
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
                                    <td>{{ $siswa->jenis_kelamin }}</td>
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
    </div>
  </div>

<!-- Tabs Section -->
<div class="card mt-8">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="studentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="nilai-umum-tab" data-bs-toggle="tab" data-bs-target="#nilai-umum-tab-pane" type="button" role="tab" aria-controls="nilai-umum-tab-pane" aria-selected="true">Nilai Umum</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="nilai-keshaftaan-tab" data-bs-toggle="tab" data-bs-target="#nilai-keshaftaan-tab-pane" type="button" role="tab" aria-controls="nilai-keshaftaan-tab-pane" aria-selected="false">Nilai Keshaftaan</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="nilai-sikap-tab" data-bs-toggle="tab" data-bs-target="#nilai-sikap-tab-pane" type="button" role="tab" aria-controls="nilai-sikap-tab-pane" aria-selected="false">Nilai Sikap</button>
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
                            <select class="form-select">
                                @foreach ($tahunAjaran as $item)
                                    <option value="{{ $item->id }}" {{ $tahunAjaranActive->id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-outline-main">
                                <i class="ph ph-file-csv me-1"></i> Export CSV
                            </button>
                            <button class="btn btn-sm btn-outline-main">
                                <i class="ph ph-microsoft-excel-logo me-1"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>KKM</th>
                                <th>Nilai</th>
                                <th>Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($raportNilaiUmum as $index => $rn)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $rn->pelajaran->judul }}</td>
                                <td>{{ $rn->pelajaran->kkm ?? '-' }}</td>
                                <td>{{ $rn->nilai }}</td>
                                <td>
                                    <span class="badge {{ $rn->nilai_huruf == 'A' ? 'bg-success' : 'bg-primary' }}">
                                        {{ $rn->nilai_huruf }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Academic Summary Card -->
                @if(isset($rataRataNilaiUmum))
                <div class="card card-academic-summary mt-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <h6 class="mb-2">Rata-rata Nilai</h6>
                                <h2 class="mb-0">{{ $rataRataNilaiUmum }}</h2>
                            </div>
                            <div class="col-md-4 text-center border-start border-end">
                                <h6 class="mb-2">Ranking Kelas</h6>
                                <h2 class="mb-0">{{ $rankingRaportNilaiUmum ?? '-' }}</h2>
                                <small class="text-muted">dari {{ $jumlahSiswa ?? 0 }} siswa</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <h6 class="mb-2">Semester</h6>
                                <h5 class="mb-0">{{ $raport->semester }}</h5>
                                <small class="text-muted">{{ $raport->tahun_ajaran }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Nilai Keshaftaan Tab -->
            @if(isset($raportNilaiShafta))
            <div class="tab-pane fade" id="nilai-keshaftaan-tab-pane" role="tabpanel" aria-labelledby="nilai-keshaftaan-tab" tabindex="0">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <select class="form-select">
                                @foreach ($tahunAjaran as $item)
                                    <option value="{{ $item->id }}" {{ $tahunAjaranActive->id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Bahasa Arab Section -->
                <div class="category-heading">
                    <i class="ph ph-book me-2"></i> Bahasa Arab
                </div>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Kategori</th>
                                <th width="15%">Nilai</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($raportNilaiShafta as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->pelajaran->judul }}</td>
                                <td>{{ $item->nilai }}</td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Numerasi Section -->
                <div class="category-heading">
                    <i class="ph ph-calculator me-2"></i> Numerasi
                </div>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Kategori</th>
                                <th width="15%">Nilai</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($raportNilaiShafta as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->pelajaran->judul }}</td>
                                <td>{{ $item->nilai }}</td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            

                <!-- Keshaftaan Summary Card -->
                <div class="card card-academic-summary mt-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <h6 class="mb-2">Rata-rata Nilai</h6>
                                <h2 class="mb-0">{{ $raportNilaiShafta->avg('nilai') }}</h2>
                            </div>
                            <div class="col-md-3 text-center border-start border-end">
                                <h6 class="mb-2">Sikap</h6>
                                <h2 class="mb-0">{{ $raportNilaiShafta->avg('nilai') }}</h2>
                            </div>
                            <div class="col-md-3 text-center border-end">
                                <h6 class="mb-2">Nilai Hafalan</h6>
                                <h2 class="mb-0">{{ $raportNilaiShafta->avg('nilai') }}</h2>
                            </div>
                            <div class="col-md-3 text-center">
                                <h6 class="mb-2">Nilai Ibadah</h6>
                                <h2 class="mb-0">{{ $raportNilaiShafta->avg('nilai') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Nilai Sikap Tab -->
            @if(isset($nilaiSikap))
            <div class="tab-pane fade" id="nilai-sikap-tab-pane" role="tabpanel" aria-labelledby="nilai-sikap-tab" tabindex="0">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <select class="form-select">
                                <option selected>Semester 1 (2024/2025)</option>
                                <option>Semester 2 (2023/2024)</option>
                                <option>Semester 1 (2023/2024)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Spiritual Section -->
                <div class="category-heading">
                    <i class="ph ph-heart me-2"></i> Sikap Spiritual
                </div>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="40%">Aspek</th>
                                <th width="15%">Nilai</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilaiSikap[0]['spiritual'] as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['aspek'] }}</td>
                                <td>
                                    <span class="badge {{ $item['nilai'] == 'A' ? 'bg-success' : 'bg-primary' }}">
                                        {{ $item['nilai'] }}
                                    </span>
                                </td>
                                <td>{{ $item['keterangan'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Sosial Section -->
                <div class="category-heading">
                    <i class="ph ph-users-three me-2"></i> Sikap Sosial
                </div>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="40%">Aspek</th>
                                <th width="15%">Nilai</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilaiSikap[0]['sosial'] as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['aspek'] }}</td>
                                <td>
                                    <span class="badge {{ $item['nilai'] == 'A' ? 'bg-success' : 'bg-primary' }}">
                                        {{ $item['nilai'] }}
                                    </span>
                                </td>
                                <td>{{ $item['keterangan'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Catatan Guru -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ph ph-note-pencil me-2"></i> Catatan Guru</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $nilaiSikap[0]['catatan_guru'] }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</main>

</x-app-layout>
