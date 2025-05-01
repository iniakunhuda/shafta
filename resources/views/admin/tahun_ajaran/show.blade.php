<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.tahun_ajaran.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">{{ __('Tahun Ajaran') }}</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Detail') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Detail Tahun Ajaran
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.tahun_ajaran.index') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-arrow-left pr-3"></i>
                {{ __('Kembali') }}
            </a>
            <div>
                <a href="{{ route('admin.tahun_ajaran.edit', $tahunAjaran->id) }}" class="btn btn-warning text-white rounded-pill px-24 py-12 mx-2">
                    <i class="ph ph-pencil pr-3"></i>
                    {{ __('Edit') }}
                </a>
                <form action="{{ route('admin.tahun_ajaran.destroy', $tahunAjaran->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger text-white rounded-pill px-24 py-12">
                        <i class="ph ph-trash pr-3"></i>
                        {{ __('Hapus') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-bottom border-gray-100">
                <h5 class="mb-0">Informasi Tahun Ajaran</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-500">Nama Tahun Ajaran</span>
                            <span class="h5 fw-semibold">{{ $tahunAjaran->nama }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-500">Semester</span>
                            <span class="h5 fw-semibold">{{ $tahunAjaran->semester }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-500">Tanggal Mulai</span>
                            <span class="h5 fw-semibold">{{ $tahunAjaran->start_date->format('d F Y') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-500">Tanggal Selesai</span>
                            <span class="h5 fw-semibold">{{ $tahunAjaran->end_date->format('d F Y') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-500">Status</span>
                            @if ($tahunAjaran->is_active)
                                <span class="text-13 py-2 px-8 bg-success-50 text-success-600 d-inline-flex align-items-center gap-8 rounded-pill" style="width: fit-content;">
                                    <span class="w-6 h-6 bg-success-600 rounded-circle flex-shrink-0"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="text-13 py-2 px-8 bg-gray-50 text-gray-600 d-inline-flex align-items-center gap-8 rounded-pill" style="width: fit-content;">
                                    <span class="w-6 h-6 bg-gray-600 rounded-circle flex-shrink-0"></span>
                                    Tidak Aktif
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-500">Waktu Dibuat</span>
                            <span class="h5 fw-semibold">{{ $tahunAjaran->created_at->format('d F Y H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($tahunAjaran->raports->count() > 0 || $tahunAjaran->raportHafalans->count() > 0)
            <div class="card mt-20">
                <div class="card-header border-bottom border-gray-100">
                    <h5 class="mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Jumlah Raport</h6>
                                    <p class="card-text h3">{{ $tahunAjaran->raports->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Jumlah Raport Hafalan</h6>
                                    <p class="card-text h3">{{ $tahunAjaran->raportHafalans->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>

</x-app-layout>
