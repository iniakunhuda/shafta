<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.kelas.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">{{ __('Kelas') }}</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Detail') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Detail Kelas
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-arrow-left pr-3"></i>
                {{ __('Kembali') }}
            </a>
            <div>
                <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="btn btn-warning text-white rounded-pill px-24 py-12 mx-2">
                    <i class="ph ph-pencil pr-3"></i>
                    {{ __('Edit') }}
                </a>
                <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                <h5 class="mb-0">Informasi Kelas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Jenjang</span>
                            <span class="h5 fw-semibold">{{ $kelas->jenjang }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Nama Kelas</span>
                            <span class="h5 fw-semibold">{{ $kelas->nama }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Tahun Ajaran</span>
                            <span class="h5 fw-semibold">{{ $kelas->tahunajaran->nama ?? '' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Maksimum</span>
                            <span class="h5 fw-semibold">{{ $kelas->maksimum }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Wali Kelas</span>
                            <span class="h5 fw-semibold">{{ $kelas->wali_kelas_nama }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Waktu Dibuat</span>
                            <span class="h5 fw-semibold">{{ $kelas->created_at->format('d F Y H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</x-app-layout>
