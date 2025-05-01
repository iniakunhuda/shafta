<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Tahun Ajaran') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Tahun Ajaran
    </x-slot>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-20">
            <a href="{{ route('admin.tahun_ajaran.create') }}" class="btn btn-main text-white rounded-pill px-24 py-12">
                <i class="ph ph-plus pr-3"></i>
                Tambah Tahun Ajaran
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
                <table id="tahunAjaranTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="h6 text-gray-300">No</th>
                            <th class="h6 text-gray-300">Nama</th>
                            <th class="h6 text-gray-300">Semester</th>
                            <th class="h6 text-gray-300">Tanggal Mulai</th>
                            <th class="h6 text-gray-300">Tanggal Selesai</th>
                            <th class="h6 text-gray-300">Status</th>
                            <th class="h6 text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tahunAjaran as $index => $ta)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $ta->nama }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $ta->semester }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $ta->start_date->format('d M Y') }}</span>
                                </td>
                                <td>
                                    <span class="h6 mb-0 fw-medium text-gray-300">{{ $ta->end_date->format('d M Y') }}</span>
                                </td>
                                <td>
                                    @if ($ta->is_active)
                                        <span class="text-13 py-2 px-8 bg-success-50 text-success-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                            <span class="w-6 h-6 bg-success-600 rounded-circle flex-shrink-0"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="text-13 py-2 px-8 bg-gray-50 text-gray-600 d-inline-flex align-items-center gap-8 rounded-pill">
                                            <span class="w-6 h-6 bg-gray-600 rounded-circle flex-shrink-0"></span>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-main border rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton-{{ $ta->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $ta->id }}">
                                            <li>
                                                <a href="{{ route('admin.tahun_ajaran.show', $ta->id) }}" class="dropdown-item">
                                                    <i class="ph ph-eye me-2"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.tahun_ajaran.edit', $ta->id) }}" class="dropdown-item">
                                                    <i class="ph ph-pencil-simple me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.tahun_ajaran.toggle-active', $ta->id) }}" method="POST" class="dropdown-item-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item">
                                                        @if($ta->is_active)
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
                                                <form action="{{ route('admin.tahun_ajaran.destroy', $ta->id) }}" method="POST" class="dropdown-item-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                <td colspan="7" class="text-center">Data Tahun Ajaran tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $tahunAjaran->links() }}
                </div>
            </div>
        </div>
    </main>

    <x-slot name="scripts">
        <script>
            new DataTable('#tahunAjaranTable', {
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
