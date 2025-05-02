<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.kelas.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">{{ __('Kelas') }}</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Tambah Baru') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Tambah Kelas
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-arrow-left pr-3"></i>
                {{ __('Kembali') }}
            </a>
        </div>

        <div class="card">
            <div class="card-header border-bottom border-gray-100 flex-align gap-8">
                <h5 class="mb-0">Data Kelas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kelas.store') }}" method="POST">
                    @csrf
                    <div class="row g-20">
                        <div class="col-md-6">
                            <label for="nama" class="h5 mb-8 fw-normal font-heading">Nama Kelas <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: 2A" required>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="maksimum" class="h5 mb-8 fw-normal font-heading">Maksimum <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="number" class="form-control py-11 @error('maksimum') is-invalid @enderror" id="maksimum" name="maksimum" value="{{ old('maksimum') }}" placeholder="Contoh: 20" required>
                                @error('maksimum')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="wali_kelas_nama" class="h5 mb-8 fw-normal font-heading">Wali Kelas <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('wali_kelas_nama') is-invalid @enderror" id="wali_kelas_nama" name="wali_kelas_nama" value="{{ old('wali_kelas_nama') }}" placeholder="Contoh: Pak Dede" required>
                                @error('wali_kelas_nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="id_tahunajaran" class="h5 mb-8 fw-normal font-heading">Tahun Ajaran <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <select class="form-control py-11 @error('id_tahunajaran') is-invalid @enderror" id="id_tahunajaran" name="id_tahunajaran" required>
                                    @foreach ($tahunAjaran as $tahun)
                                        <option value="{{ $tahun->id }}">{{ $tahun->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="flex-align justify-content-end gap-8">
                                <button type="submit" class="btn btn-main rounded-pill py-12 px-24">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

</x-app-layout>
