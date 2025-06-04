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
                        <div class="tab-pane fade show active" id="upload-tab-pane" role="tabpanel" aria-labelledby="upload-tab" tabindex="0">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Pilih Formulir</h5>
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-8 fw-normal">Pilih Jenjang <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <select class="form-control py-11 @error('jenjang') is-invalid @enderror" name="jenjang" required>
                                            <option value="">Pilih Jenjang</option>
                                            <option value="SMP">SMP</option>
                                            <option value="SMA">SMA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <br>
                                    <label class="mb-8 fw-normal">Pilih Tahun Ajaran <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <select class="form-control py-11 @error('tahun_ajaran') is-invalid @enderror" name="tahun_ajaran" required>
                                            <option value="">Pilih Tahun Ajaran</option>
                                            @foreach ($tahunAjaran as $tahun)
                                                <option value="{{ $tahun->id }}">{{ $tahun->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <br>
                                    <label class="mb-8 fw-normal">Pilih Kelas<span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <select class="form-control py-11 @error('kelas') is-invalid @enderror" name="kelas" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <br><br>
                                    <h5>Upload Nilai Excel</h5>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="upload-container">
                                            <h6>Pilih File Excel Nilai</h6>
                                            <p class="text-muted">Format: .xlsx atau .xls</p>
                                            <input type="file" name="nilaiUmumFile" class="form-control mb-3" required>
                                            <br>
                                            <button type="submit" name="uploadNilaiUmum" class="btn btn-main rounded-pill py-9">Upload</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <br><br>
                                    <h5>Preview Nilai</h5>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
</x-app-layout>
