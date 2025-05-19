<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.siswa.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">{{ __('Siswa') }}</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Edit') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Edit Siswa
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-arrow-left pr-3"></i>
                {{ __('Kembali') }}
            </a>
        </div>

        <div class="card">
            <div class="card-header border-bottom border-gray-100 flex-align gap-8">
                <h5 class="mb-0">Edit Data Siswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-20">
                        <div class="col-md-6">
                            <label for="nama" class="h5 mb-8 fw-semibold font-heading">Nama Siswa <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $siswa->nama) }}" placeholder="Masukkan nama siswa" required>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="nis" class="h5 mb-8 fw-semibold font-heading">NIS <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}" placeholder="Masukkan NIS" required>
                                @error('nis')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="nisn" class="h5 mb-8 fw-semibold font-heading">NISN <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" placeholder="Masukkan NISN" required>
                                @error('nisn')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="h5 mb-8 fw-semibold font-heading">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-select py-11 @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="" disabled>Pilih Jenis Kelamin</option>
                                    <option value="l" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'l' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="p" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'p' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="tempat_lahir" class="h5 mb-8 fw-semibold font-heading">Tempat Lahir</label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" placeholder="Masukkan tempat lahir">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="h5 mb-8 fw-semibold font-heading">Tanggal Lahir</label>
                            <div class="position-relative">
                                <input type="date" class="form-control py-11 @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="alamat" class="h5 mb-8 fw-semibold font-heading">Alamat</label>
                            <div class="position-relative">
                                <textarea class="form-control py-11 @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat">{{ old('alamat', $siswa->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="ayah_nama" class="h5 mb-8 fw-semibold font-heading">Nama Ayah</label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('ayah_nama') is-invalid @enderror" id="ayah_nama" name="ayah_nama" value="{{ old('ayah_nama', $siswa->ayah_nama) }}" placeholder="Masukkan nama ayah">
                                @error('ayah_nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="ayah_pekerjaan" class="h5 mb-8 fw-semibold font-heading">Pekerjaan Ayah</label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('ayah_pekerjaan') is-invalid @enderror" id="ayah_pekerjaan" name="ayah_pekerjaan" value="{{ old('ayah_pekerjaan', $siswa->ayah_pekerjaan) }}" placeholder="Masukkan pekerjaan ayah">
                                @error('ayah_pekerjaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="ayah_telp" class="h5 mb-8 fw-semibold font-heading">No. Telp Ayah</label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('ayah_telp') is-invalid @enderror" id="ayah_telp" name="ayah_telp" value="{{ old('ayah_telp', $siswa->ayah_telp) }}" placeholder="Masukkan no. telp ayah">
                                @error('ayah_telp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="ayah_alamat" class="h5 mb-8 fw-semibold font-heading">Alamat Ayah</label>
                            <div class="position-relative">
                                <textarea class="form-control py-11 @error('ayah_alamat') is-invalid @enderror" id="ayah_alamat" name="ayah_alamat" rows="3" placeholder="Masukkan alamat ayah">{{ old('ayah_alamat', $siswa->ayah_alamat) }}</textarea>
                                @error('ayah_alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="ibu_nama" class="h5 mb-8 fw-semibold font-heading">Nama Ibu</label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('ibu_nama') is-invalid @enderror" id="ibu_nama" name="ibu_nama" value="{{ old('ibu_nama', $siswa->ibu_nama) }}" placeholder="Masukkan nama ibu">
                                @error('ibu_nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="ibu_pekerjaan" class="h5 mb-8 fw-semibold font-heading">Pekerjaan Ibu</label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('ibu_pekerjaan') is-invalid @enderror" id="ibu_pekerjaan" name="ibu_pekerjaan" value="{{ old('ibu_pekerjaan', $siswa->ibu_pekerjaan) }}" placeholder="Masukkan pekerjaan ibu">
                                @error('ibu_pekerjaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="ibu_alamat" class="h5 mb-8 fw-semibold font-heading">Alamat Ibu</label>
                            <div class="position-relative">
                                <textarea class="form-control py-11 @error('ibu_alamat') is-invalid @enderror" id="ibu_alamat" name="ibu_alamat" rows="3" placeholder="Masukkan alamat ibu">{{ old('ibu_alamat', $siswa->ibu_alamat) }}</textarea>
                                @error('ibu_alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" {{ old('status', $siswa->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Status Aktif</label>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="flex-align justify-content-end gap-8">
                                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-main rounded-pill py-12 px-24">Batal</a>
                                <button type="submit" class="btn btn-main rounded-pill py-12 px-24">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

</x-app-layout>
