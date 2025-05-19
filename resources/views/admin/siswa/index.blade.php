<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Siswa') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Siswa
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-plus pr-3"></i>
                Tambah Siswa
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
                            <th class="h6 text-gray-300">NIS</th>
                            <th class="h6 text-gray-300">NISN</th>
                            <th class="h6 text-gray-300">Nama</th>
                            <th class="h6 text-gray-300">Jenis Kelamin</th>
                            <th class="h6 text-gray-300">Tempat Lahir</th>
                            <th class="h6 text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $index => $s)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $s->nis }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $s->nisn }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $s->nama }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $s->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan' }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $s->tempat_lahir }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-main border rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton-{{ $s->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $s->id }}">
                                            <li>
                                                <a href="{{ route('admin.siswa.show', $s->id) }}" class="dropdown-item">
                                                    <i class="ph ph-eye me-2"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.siswa.edit', $s->id) }}" class="dropdown-item">
                                                    <i class="ph ph-pencil-simple me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.siswa.toggle-active', $s->id) }}" method="POST" class="dropdown-item-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item">
                                                        @if($s->status == 'active')
                                                            <i class="ph ph-power me-2"></i> Nonaktifkan
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
                                                <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" class="dropdown-item-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                <td colspan="17" class="text-center">Data Siswa tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- <div class="mt-4">
                    {{ $siswa->links() }}
                </div> --}}
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
                    { "orderable": false, "targets": 6 }
                ],
            });

        </script>
    </x-slot>

</x-app-layout>
