<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Akun Siswa') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Akun Siswa
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.user_siswa.create') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-plus pr-3"></i>
                Tambah Akun Siswa
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-10">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mb-10">
                {{ session('error') }}
            </div>
        @endif

        <div class="card overflow-hidden px-8 py-8">
            <div class="card-body overflow-x-auto">
                <table id="siswaTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="h6 text-gray-300">No</th>
                            <th class="h6 text-gray-300">Nama</th>
                            <th class="h6 text-gray-300">Email</th>
                            <th class="h6 text-gray-300">Status</th>
                            <th class="h6 text-gray-300">Terakhir Diperbarui</th>
                            <th class="h6 text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $index => $siswa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $siswa->nama }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $siswa->email }}</span>
                                </td>
                                <td>
                                    @if ($siswa->status === 'active')
                                        <span class="text-13 py-2 px-8 bg-success-50 text-success-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                            <span class="w-6 h-6 bg-success-600 rounded-circle flex-shrink-0"></span>
                                            Aktif
                                        </span>
                                    @elseif ($siswa->status === 'pending')
                                        <span class="text-13 py-2 px-8 bg-warning-50 text-warning-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                            <span class="w-6 h-6 bg-warning-600 rounded-circle flex-shrink-0"></span>
                                            Pending
                                        </span>
                                    @else
                                        <span class="text-13 py-2 px-8 bg-danger-50 text-danger-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                            <span class="w-6 h-6 bg-danger-600 rounded-circle flex-shrink-0"></span>
                                            Diblokir
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $siswa->updated_at?->format('d M Y H:i') }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-main border rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton-{{ $siswa->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $siswa->id }}">
                                            <li>
                                                <a href="{{ route('admin.user_siswa.show', $siswa->id) }}" class="dropdown-item">
                                                    <i class="ph ph-eye me-2"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.user_siswa.edit', $siswa->id) }}" class="dropdown-item">
                                                    <i class="ph ph-pencil-simple me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.user_siswa.toggle-status', $siswa->id) }}" method="POST" class="dropdown-item-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item">
                                                        @if($siswa->status === 'active')
                                                            <i class="ph ph-prohibit-inset me-2"></i> Blokir
                                                        @else
                                                            <i class="ph ph-check-circle me-2"></i> Aktifkan
                                                        @endif
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.user_siswa.destroy', $siswa->id) }}" method="POST" class="dropdown-item-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun siswa ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="ph ph-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data Siswa tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <x-slot name="scripts">
        <script>
            new DataTable('#siswaTable', {
                searching: true,
                lengthChange: true,
                info: true,
                paging: true,
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ],
            });
        </script>
    </x-slot>

</x-app-layout>
