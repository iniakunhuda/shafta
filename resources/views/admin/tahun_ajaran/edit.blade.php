<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.tahun_ajaran.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">{{ __('Tahun Ajaran') }}</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Edit') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Edit Tahun Ajaran
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.tahun_ajaran.index') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-arrow-left pr-3"></i>
                {{ __('Kembali') }}
            </a>
        </div>

        <div class="card">
            <div class="card-header border-bottom border-gray-100 flex-align gap-8">
                <h5 class="mb-0">Edit Data Tahun Ajaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tahun_ajaran.update', $tahunAjaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-20">
                        <div class="col-md-6">
                            <label for="nama" class="h5 mb-8 fw-semibold font-heading">Nama Tahun Ajaran <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $tahunAjaran->nama) }}" placeholder="Contoh: 2023/2024" required>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="semester" class="h5 mb-8 fw-semibold font-heading">Semester <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <select id="semester" name="semester" class="form-select py-11 @error('semester') is-invalid @enderror" required>
                                    <option value="" disabled>Pilih Semester</option>
                                    <option value="Ganjil" {{ old('semester', $tahunAjaran->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $tahunAjaran->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="start_date" class="h5 mb-8 fw-semibold font-heading">Tanggal Mulai <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="date" class="form-control py-11 @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $tahunAjaran->start_date->format('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="end_date" class="h5 mb-8 fw-semibold font-heading">Tanggal Selesai <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="date" class="form-control py-11 @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $tahunAjaran->end_date->format('Y-m-d')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" {{ old('is_active', $tahunAjaran->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktifkan Tahun Ajaran Ini</label>
                            </div>
                            <small class="text-muted">Jika diaktifkan, tahun ajaran lain yang aktif akan dinonaktifkan.</small>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="flex-align justify-content-end gap-8">
                                <a href="{{ route('admin.tahun_ajaran.index') }}" class="btn btn-outline-main rounded-pill py-12 px-24">Batal</a>
                                <button type="submit" class="btn btn-main rounded-pill py-12 px-24">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

</x-app-layout>
