<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('siswa.dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">Nilai Siswa</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Nilai Siswa
    </x-slot>

    <main>
        <div class="dashboard-body">
            <!-- Header Section Start -->
            <div class="card mb-24">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2 class="mb-2">Nilai Siswa</h2>
                            <p class="text-gray-600">Tahun Ajaran {{ $tahunAjaran->nama }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Section End -->

            <!-- Nilai List Start -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>Kategori</th>
                                    <th>Nilai Pengetahuan</th>
                                    <th>Nilai Keterampilan</th>
                                    <th>Nilai Akhir</th>
                                    <th>Predikat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($nilai as $n)
                                <tr>
                                    <td>{{ $n->pelajaran->judul }}</td>
                                    <td>
                                        <span class="badge {{ $n->pelajaran->kategori === 'umum' ? 'bg-main-50 text-main-600' : 'bg-main-two-50 text-main-two-600' }}">
                                            {{ ucfirst($n->pelajaran->kategori) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = '';
                                            if ($n->nilai_pengetahuan >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                            elseif ($n->nilai_pengetahuan >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                            elseif ($n->nilai_pengetahuan >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                            else $badgeClass = 'bg-danger-50 text-danger-600';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $n->nilai_pengetahuan }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = '';
                                            if ($n->nilai_keterampilan >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                            elseif ($n->nilai_keterampilan >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                            elseif ($n->nilai_keterampilan >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                            else $badgeClass = 'bg-danger-50 text-danger-600';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $n->nilai_keterampilan }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = '';
                                            if ($n->nilai_akhir >= 90) $badgeClass = 'bg-success-50 text-success-600';
                                            elseif ($n->nilai_akhir >= 80) $badgeClass = 'bg-main-50 text-main-600';
                                            elseif ($n->nilai_akhir >= 70) $badgeClass = 'bg-warning-50 text-warning-600';
                                            else $badgeClass = 'bg-danger-50 text-danger-600';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $n->nilai_akhir }}</span>
                                    </td>
                                    <td>{{ $n->predikat }}</td>
                                    <td>
                                        <a href="{{ route('siswa.nilai.detail', $n->id) }}" class="btn btn-sm btn-outline-main rounded-pill">
                                            <i class="ph ph-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
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
            <!-- Nilai List End -->
        </div>
    </main>
</x-app-layout> 