<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Kelas') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Kelas
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.kelas.create') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-plus pr-3"></i>
                Tambah Kelas
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
                <table id="kelasTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="h6 text-gray-300">No</th>
                            <th class="h6 text-gray-300">Nama</th>
                            <th class="h6 text-gray-300">Tahun Ajaran</th>
                            <th class="h6 text-gray-300">Maksimum</th>
                            <th class="h6 text-gray-300">Wali Kelas</th>
                            <th class="h6 text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kelas as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $k->nama }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $k->tahunajaran->nama }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $k->maksimum }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $k->wali_kelas_nama }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-main border rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton-{{ $k->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $k->id }}">
                                            <li>
                                                <a href="{{ route('admin.kelas.show', $k->id) }}" class="dropdown-item">
                                                    <i class="ph ph-eye me-2"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.kelas.edit', $k->id) }}" class="dropdown-item">
                                                    <i class="ph ph-pencil-simple me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" class="dropdown-item-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="ph ph-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data Kelas tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </main>

    <x-slot name="scripts">
        <script>
            new DataTable('#kelasTable', {
                searching: true,
                lengthChange: true,
                info: true,
                paging: true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ],
            });

        </script>
    </x-slot>

</x-app-layout>
