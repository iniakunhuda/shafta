<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Siswa</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Detail Raport') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Detail Raport Siswa
    </x-slot>

    <main>
        <div class="dashboard-body">

            <!-- Student Info Section Start -->
            <div class="card mb-24">
                <div class="card-header border-bottom border-gray-100">
                    <h5 class="mb-0">Informasi Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="140">Nama Siswa</td>
                                    <td width="20">:</td>
                                    <td><strong>{{ $student['nama'] }}</strong></td>
                                </tr>
                                <tr>
                                    <td>NIS</td>
                                    <td>:</td>
                                    <td>{{ $student['nis'] }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>:</td>
                                    <td>{{ $student['nisn'] ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="140">Kelas</td>
                                    <td width="20">:</td>
                                    <td>{{ $student['kelas'] }}</td>
                                </tr>
                                <tr>
                                    <td>Semester</td>
                                    <td>:</td>
                                    <td>{{ $student['semester'] }}</td>
                                </tr>
                                <tr>
                                    <td>Tahun Ajaran</td>
                                    <td>:</td>
                                    <td>{{ $student['tahun_ajaran'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <strong>Catatan:</strong> Berikut adalah detail nilai raport siswa untuk {{ $student['semester'] }} - {{ $student['tahun_ajaran'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Student Info Section End -->

            <!-- Tabs Start -->
            <div class="card mb-24">
                <div class="card-header border-bottom border-gray-100">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="nilai-umum-tab" data-bs-toggle="tab" data-bs-target="#nilai-umum-tab-pane" type="button" role="tab" aria-controls="nilai-umum-tab-pane" aria-selected="true">Nilai Umum</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nilai-keshaftaan-tab" data-bs-toggle="tab" data-bs-target="#nilai-keshaftaan-tab-pane" type="button" role="tab" aria-controls="nilai-keshaftaan-tab-pane" aria-selected="false">Nilai Keshaftaan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nilai-sikap-tab" data-bs-toggle="tab" data-bs-target="#nilai-sikap-tab-pane" type="button" role="tab" aria-controls="nilai-sikap-tab-pane" aria-selected="false">Nilai Sikap</button>
                        </li>
                        <li class="nav-item ms-auto" role="presentation">
                            <button class="btn btn-outline-main" onclick="window.print()">
                                <i class="ph ph-printer me-2"></i> Cetak Raport
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <!-- Nilai Umum Tab -->
                        <div class="tab-pane fade show active" id="nilai-umum-tab-pane" role="tabpanel" aria-labelledby="nilai-umum-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>NO</th>
                                            <th>MATA PELAJARAN</th>
                                            <th>KKM</th>
                                            <th>NILAI</th>
                                            <th>KETERANGAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($nilaiAkademik as $index => $nilai)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $nilai->mata_pelajaran }}</td>
                                                <td>75</td>
                                                <td>{{ $nilai->nilai ?? '-' }}</td>
                                                <td>{{ $nilai->catatan ?? ($nilai->nilai ? \App\Helpers\GradeHelper::getKeterangan($nilai->nilai) : '-') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data nilai umum</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    @if($nilaiAkademik->isNotEmpty())
                                        <tfoot class="table-primary">
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">Rata-rata</td>
                                                <td class="fw-bold">{{ number_format($summaryStats['rata_rata_akademik'], 2) }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">Ranking</td>
                                                <td class="fw-bold">{{ $summaryStats['peringkat_kelas'] }} dari {{ $summaryStats['total_siswa_kelas'] }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>

                            @if($raportData && $raportData->catatan)
                                <div class="mt-4">
                                    <h6>Catatan Guru:</h6>
                                    <div class="p-3 border rounded bg-light">
                                        <p class="mb-0">{{ $raportData->catatan }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Nilai Keshaftaan Tab -->
                        <div class="tab-pane fade" id="nilai-keshaftaan-tab-pane" role="tabpanel" aria-labelledby="nilai-keshaftaan-tab" tabindex="0">
                            @if($nilaiKeshaftaanGrouped->isNotEmpty())
                                @foreach($nilaiKeshaftaanGrouped as $kategori => $nilaiGroup)
                                    <div class="mb-4">
                                        <h5 class="
                                            @if($kategori == 'ipa') bg-warning text-dark
                                            @elseif($kategori == 'ips') bg-danger text-white
                                            @elseif($kategori == 'eskul') bg-success text-white
                                            @else bg-secondary text-white
                                            @endif
                                            p-2 rounded">
                                            {{ ucfirst($kategori ?? 'Lainnya') }}
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>KATEGORI</th>
                                                        <th>NILAI/PREDIKAT</th>
                                                        <th>KETERANGAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($nilaiGroup as $index => $nilai)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $nilai->mata_pelajaran }}</td>
                                                            <td>{{ $nilai->nilai ?? ($nilai->nilai_huruf ?? '-') }}</td>
                                                            <td>{{ $nilai->catatan ?? ($nilai->nilai ? \App\Helpers\GradeHelper::getKeterangan($nilai->nilai) : '-') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Hafalan Section -->
                                @if($nilaiHafalan->isNotEmpty())
                                    <div class="mb-4">
                                        <h5 class="bg-info text-white p-2 rounded">Hafalan</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>KATEGORI</th>
                                                        <th>NILAI/PREDIKAT</th>
                                                        <th>KETERANGAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($nilaiHafalan as $index => $hafalan)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $hafalan->judul }}</td>
                                                            <td>{{ $hafalan->nilai ?? ($hafalan->nilai_huruf ?? '-') }}</td>
                                                            <td>{{ $hafalan->catatan ?? ($hafalan->nilai ? \App\Helpers\GradeHelper::getKeterangan($hafalan->nilai) : '-') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                <!-- Summary Section -->
                                <div class="mt-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-header bg-main-50">
                                                    <h6 class="mb-0">Ringkasan Nilai Keshaftaan</h6>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="50%">Rata-rata Nilai</td>
                                                            <td class="fw-bold">{{ number_format($summaryStats['rata_rata_keshaftaan'], 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Predikat Sikap</td>
                                                            <td class="fw-bold">{{ $summaryStats['predikat_sikap'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nilai Hafalan</td>
                                                            <td class="fw-bold">{{ number_format($summaryStats['nilai_hafalan'], 2) }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-header bg-main-50">
                                                    <h6 class="mb-0">Catatan Guru Keshaftaan</h6>
                                                </div>
                                                <div class="card-body">
                                                    @if($raportData && $raportData->prestasi)
                                                        <p>{{ $raportData->prestasi }}</p>
                                                    @else
                                                        <p>Siswa menunjukkan kedisiplinan dan kemampuan yang baik dalam aspek keshaftaan.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <p class="mb-0">Belum ada data nilai keshaftaan untuk semester ini.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Nilai Sikap Tab -->
                        <div class="tab-pane fade" id="nilai-sikap-tab-pane" role="tabpanel" aria-labelledby="nilai-sikap-tab" tabindex="0">
                            @if($sikapData->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>NO</th>
                                                <th>ASPEK SIKAP</th>
                                                <th>NILAI</th>
                                                <th>KETERANGAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sikapData as $index => $sikap)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $sikap->sikap_judul }}</td>
                                                    <td>{{ $sikap->nilai ?? '-' }}</td>
                                                    <td>{{ $sikap->keterangan ?? $sikap->sikap_deskripsi ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-primary">
                                            <tr>
                                                <td colspan="2" class="text-end fw-bold">Predikat Sikap</td>
                                                <td class="fw-bold">{{ $summaryStats['predikat_sikap'] }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Attendance Section -->
                                @if($raportData)
                                    <div class="mt-4">
                                        <h6>Kehadiran:</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <h5 class="text-success">{{ $raportData->sakit ?? 0 }}</h5>
                                                        <p class="mb-0">Sakit</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <h5 class="text-warning">{{ $raportData->izin ?? 0 }}</h5>
                                                        <p class="mb-0">Izin</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <h5 class="text-danger">{{ $raportData->alpa ?? 0 }}</h5>
                                                        <p class="mb-0">Alpa</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <p class="mb-0">Belum ada data nilai sikap untuk semester ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabs End -->

            <!-- Signature Section Start -->
            <div class="card mb-24">
                <div class="card-header border-bottom border-gray-100">
                    <h5 class="mb-0">Tanda Tangan</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h6>Orang Tua/Wali</h6>
                            <div class="mt-5 mb-2">
                                <div class="border-bottom border-dark d-inline-block" style="width: 150px; min-height: 40px;"></div>
                            </div>
                            <p>(...................................)</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Wali Kelas</h6>
                            <div class="mt-5 mb-2">
                                <div class="border-bottom border-dark d-inline-block" style="width: 150px; min-height: 40px;"></div>
                            </div>
                            <p>({{ $student['wali_kelas'] ?? 'Nama Wali Kelas' }})</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Kepala Sekolah</h6>
                            <div class="mt-5 mb-2">
                                <div class="border-bottom border-dark d-inline-block" style="width: 150px; min-height: 40px;"></div>
                            </div>
                            <p>(Dr. H. Mahmud Yunus, M.Pd.I)</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Signature Section End -->

        </div>
    </main>

    <x-slot name="scripts">
        <script>
            // Print style adjustments
            window.onbeforeprint = function() {
                const elements = document.querySelectorAll('.dashboard-footer, .top-navbar, .sidebar');
                elements.forEach(el => {
                    if (el) el.style.display = 'none';
                });
            };

            window.onafterprint = function() {
                const elements = [
                    {selector: '.dashboard-footer', display: 'block'},
                    {selector: '.top-navbar', display: 'flex'},
                    {selector: '.sidebar', display: 'block'}
                ];
                elements.forEach(item => {
                    const el = document.querySelector(item.selector);
                    if (el) el.style.display = item.display;
                });
            };
        </script>
    </x-slot>
</x-app-layout>
