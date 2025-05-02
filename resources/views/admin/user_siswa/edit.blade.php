<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.user_siswa.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">{{ __('Akun Siswa') }}</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Edit') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Edit Akun Siswa
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.user_siswa.show', $siswa->id) }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-arrow-left pr-3"></i>
                {{ __('Kembali') }}
            </a>
        </div>

        <div class="card">
            <div class="card-header border-bottom border-gray-100 flex-align gap-8">
                <h5 class="mb-0">Edit Data Siswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.user_siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-20">
                        <div class="col-md-6">
                            <label for="nama" class="h5 mb-8 fw-semibold font-heading">Nama <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $siswa->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="h5 mb-8 fw-semibold font-heading">Email <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="email" class="form-control py-11 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $siswa->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="h5 mb-8 fw-semibold font-heading">Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control py-11 @error('password') is-invalid @enderror" id="password" name="password">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="h5 mb-8 fw-semibold font-heading">Konfirmasi Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control py-11" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="h5 mb-8 fw-semibold font-heading">Status <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <select id="status" name="status" class="form-select py-11 @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status', $siswa->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="pending" {{ old('status', $siswa->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="block" {{ old('status', $siswa->status) == 'block' ? 'selected' : '' }}>Blokir</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="status_message" class="h5 mb-8 fw-semibold font-heading">Pesan Status</label>
                            <div class="position-relative">
                                <input type="text" class="form-control py-11 @error('status_message') is-invalid @enderror" id="status_message" name="status_message" value="{{ old('status_message', $siswa->status_message) }}">
                                @error('status_message')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Input Hidden --}}
                        <input type="hidden" name="role" value="siswa">

                        <div class="col-md-12 mt-4">
                            <div class="flex-align justify-content-end gap-8">
                                <a href="{{ route('admin.user_siswa.index') }}" class="btn btn-outline-main rounded-pill py-12 px-24">Batal</a>
                                <button type="submit" class="btn btn-main rounded-pill py-12 px-24">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

</x-app-layout>
