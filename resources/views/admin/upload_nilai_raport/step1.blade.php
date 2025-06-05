<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Upload Nilai Raport') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Upload Nilai Raport
    </x-slot>

    <x-slot name="styles">
        <style>
            .tab-content {
                padding: 20px;
                border: 1px solid #ddd;
                border-top: none;
                border-radius: 0 0 5px 5px;
            }
            .nav-tabs .nav-link {
                border: 1px solid #ddd;
                border-radius: 5px 5px 0 0;
                margin-right: 5px;
            }
            .nav-tabs .nav-link.active {
                background-color: #f8f9fa;
                border-bottom: 1px solid #f8f9fa;
            }
            .upload-container {
                border: 2px dashed #ddd;
                padding: 30px;
                text-align: center;
                border-radius: 5px;
                margin-bottom: 20px;
            }
            .table-container {
                overflow-x: auto;
            }
            .table-responsive {
                min-height: 400px;
            }
            .alert {
                margin-top: 20px;
            }
            .table-striped>tbody>tr:nth-of-type(odd)>* {
                --bs-table-color-type: var(--bs-table-striped-color) !important;
                --bs-table-bg-type: var(--bs-table-striped-bg) !important;
            }
        </style>
    </x-slot>

    <main>
        <div class="card">
                <div class="card-header border-bottom border-gray-100 flex-align gap-8">
                    <h5 class="mb-0">Upload Data Raport</h5>
                    <button type="button" class="text-main-600 text-md d-flex" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Upload Data Raport">
                        <i class="ph-fill ph-question"></i>
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Validation Errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-tab-pane" type="button" role="tab" aria-controls="upload-tab-pane" aria-selected="true">Upload File Excel</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="nilai-umum-tab">Koreksi Data</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nilai-keshaftaan-tab">Validasi Nilai</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <form action="{{ route('admin.upload-nilai-raport.step1.handleUpload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                            @csrf
                            <div class="tab-pane fade show active" id="upload-tab-pane" role="tabpanel" aria-labelledby="upload-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Pilih Formulir</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="mb-8 fw-normal">Pilih Jenjang <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <select class="form-control py-11 @error('jenjang') is-invalid @enderror" name="jenjang" required onchange="window.location.href='{{ route('admin.upload-nilai-raport.step1') }}?jenjang=' + this.value">
                                                <option value="">Pilih Jenjang</option>
                                                <option value="SMP" {{ (request()->jenjang == 'SMP') ? 'selected' : '' }}>SMP</option>
                                                <option value="SMA" {{ (request()->jenjang == 'SMA') ? 'selected' : '' }}>SMA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <label class="mb-8 fw-normal">Pilih Tahun Ajaran <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <select class="form-control py-11 @error('tahun_ajaran') is-invalid @enderror" name="tahun_ajaran" required onchange="window.location.href='{{ route('admin.upload-nilai-raport.step1') }}?jenjang={{ request()->jenjang }}&tahun_ajaran=' + this.value">

                                                @if (!isset(request()->jenjang))
                                                    <option value="" disabled selected>Pilih Jenjang terlebih dahulu</option>
                                                @else
                                                    <option value="">Pilih Tahun Ajaran</option>
                                                    @foreach ($tahunAjaran as $tahun)
                                                        <option value="{{ $tahun->id }}" {{ request()->tahun_ajaran == $tahun->id ? 'selected' : '' }}>{{ $tahun->nama }}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <label class="mb-8 fw-normal">Pilih Kelas<span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <select class="form-control py-11 @error('kelas') is-invalid @enderror" name="kelas" required onchange="window.location.href='{{ route('admin.upload-nilai-raport.step1') }}?jenjang={{ request()->jenjang }}&tahun_ajaran={{ request()->tahun_ajaran }}&kelas=' + this.value">
                                                @if(!isset(request()->tahun_ajaran))
                                                    <option value="" disabled selected>Pilih Tahun Ajaran terlebih dahulu</option>
                                                @else
                                                    <option value="">Pilih Kelas</option>
                                                    @foreach ($kelas as $item)
                                                        <option value="{{ $item->id }}" {{ request()->kelas == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                        <label class="mb-8 fw-normal">Pilih Jenis Dokumen<span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <select class="form-control py-11 @error('jenis_dokumen') is-invalid @enderror" name="jenis_dokumen" required onchange="window.location.href='{{ route('admin.upload-nilai-raport.step1') }}?jenjang={{ request()->jenjang }}&tahun_ajaran={{ request()->tahun_ajaran }}&kelas={{ request()->kelas }}&jenis_dokumen=' + this.value">
                                                @if (!isset(request()->kelas))
                                                    <option value="" disabled selected>Pilih Kelas terlebih dahulu</option>
                                                @else
                                                    <option value="">Pilih Jenis Dokumen</option>
                                                    <option value="umum" {{ request()->jenis_dokumen == 'umum' ? 'selected' : '' }}>Nilai Umum</option>
                                                    <option value="shafta" {{ request()->jenis_dokumen == 'shafta' ? 'selected' : '' }}>Nilai Keshaftaan</option>
                                                    <option value="sikap" {{ request()->jenis_dokumen == 'sikap' ? 'selected' : '' }}>Nilai Sikap</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <br><br>
                                        <h5>Upload Nilai Excel</h5>
                                            <div class="upload-container">
                                                <h6>Pilih File Excel Nilai</h6>
                                                <p class="text-muted">Format: .xlsx atau .xls</p>
                                                <input type="file" name="file" class="form-control mb-3" required>
                                                <br>
                                                <button type="submit" class="btn btn-main rounded-pill py-9">Upload</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
</x-app-layout>
