<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><a href="{{ route('admin.user_admin.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">{{ __('Akun Admin') }}</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Detail') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Detail Admin
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.user_admin.index') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-arrow-left pr-3"></i>
                {{ __('Kembali') }}
            </a>
            <div>
                <a href="{{ route('admin.user_admin.edit', $admin->id) }}" class="btn btn-warning text-white rounded-pill px-24 py-12 mx-2">
                    <i class="ph ph-pencil pr-3"></i>
                    {{ __('Edit') }}
                </a>
                <form action="{{ route('admin.user_admin.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin ini?')">
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
                <h5 class="mb-0">Informasi Admin</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Nama</span>
                            <span class="h5 fw-semibold">{{ $admin->nama }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Email</span>
                            <span class="h5 fw-semibold">{{ $admin->email }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Role</span>
                            <span class="h5 fw-semibold">Admin</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Status</span>
                            @if ($admin->status === 'active')
                                <span class="text-13 py-2 px-8 bg-success-50 text-success-600 d-inline-flex align-items-center gap-8 rounded-pill" style="width: fit-content;">
                                    <span class="w-6 h-6 bg-success-600 rounded-circle flex-shrink-0"></span>
                                    Aktif
                                </span>
                            @elseif ($admin->status === 'pending')
                                <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill" style="width: fit-content;">
                                    <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                    Pending
                                </span>
                            @else
                                <span class="text-13 py-2 px-8 bg-danger-50 text-danger-600 d-inline-flex align-items-center gap-8 rounded-pill" style="width: fit-content;">
                                    <span class="w-6 h-6 bg-danger-600 rounded-circle flex-shrink-0"></span>
                                    Diblokir
                                </span>
                            @endif
                        </div>
                    </div>
                    @if($admin->status_message)
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Pesan Status</span>
                            <span class="h5 fw-semibold">{{ $admin->status_message }}</span>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Tanggal Pendaftaran</span>
                            <span class="h5 fw-semibold">{{ $admin->created_at->format('d F Y H:i:s') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex flex-column">
                            <span class="text-gray-400 mb-2 fw-normal">Terakhir Diperbarui</span>
                            <span class="h5 fw-semibold">{{ $admin->updated_at->format('d F Y H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</x-app-layout>
