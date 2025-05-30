<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\EditSiswaRequest;
use App\Http\Services\SiswaService;
use App\Http\Services\RaportService;
use App\Http\Services\TahunAjaranService;
use App\Http\Services\RaportNilaiService;
use App\Http\Services\RaportSikapService;
use App\Http\Services\ExportService;
use App\Http\Services\KelasService;

class SiswaController extends Controller
{
    protected $siswaService;
    protected $raportService;
    protected $tahunAjaranService;
    protected $raportNilaiService;
    protected $raportSikapService;
    protected $exportService;

    public function __construct(
        SiswaService $siswaService,
        RaportService $raportService,
        TahunAjaranService $tahunAjaranService,
        RaportNilaiService $raportNilaiService,
        RaportSikapService $raportSikapService,
        ExportService $exportService
    ) {
        $this->siswaService = $siswaService;
        $this->raportService = $raportService;
        $this->tahunAjaranService = $tahunAjaranService;
        $this->raportNilaiService = $raportNilaiService;
        $this->raportSikapService = $raportSikapService;
        $this->exportService = $exportService;
    }

    public function index()
    {
        $siswa = $this->siswaService->getSiswa();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(CreateSiswaRequest $request)
    {
        $validated = $request->validated();
        $this->siswaService->createSiswa($validated);
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $listKelas = (new KelasService)->getAll();
        $siswa = $this->siswaService->getSiswaById($id);
        return view('admin.siswa.edit', compact('siswa', 'listKelas'));
    }

    public function update(EditSiswaRequest $request, $id)
    {
        $validated = $request->validated();
        $this->siswaService->updateSiswa($id, $validated);
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diubah');
    }

    public function destroy($id)
    {
        $this->siswaService->deleteSiswa($id);
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus');
    }

    public function show($id)
    {
        $siswa = $this->siswaService->getSiswaById($id);
        $tahunAjaran = $this->tahunAjaranService->getAll();
        $tahunAjaranActive = request()->has('tahun_ajaran_id')
            ? $this->tahunAjaranService->getById(request('tahun_ajaran_id'))
            : $this->tahunAjaranService->getActive();
        $raport = $this->raportService->getRaportBySiswaIdAndTahunAjaranId($id, $tahunAjaranActive->id);
        $jumlahSiswa = $this->raportService->getJumlahSiswaByTahunAjaranId($tahunAjaranActive->id, $raport->id_kelas);
        $raportNilaiUmum = $this->raportNilaiService->getRaportNilaiUmumByRaportId($raport->id);
        $rataRataNilaiUmum = $this->raportNilaiService->averageRaportNilaiByRaportId($raport->id, 'umum');
        $raportNilaiShafta = $this->raportNilaiService->getRaportNilaiShaftaByRaportId($raport->id);
        $rankingRaportNilaiUmum = $this->raportNilaiService->getRankingRaportNilaiByRaportId($raport->id, 'umum', $raport->id_kelas);

        $raportSikap = $this->raportSikapService->getRaportSikapByRaportId($raport->id);
        return view('admin.siswa.show', compact('siswa', 'raport', 'tahunAjaran', 'tahunAjaranActive', 'raportNilaiUmum', 'raportNilaiShafta', 'rataRataNilaiUmum', 'jumlahSiswa', 'rankingRaportNilaiUmum', 'raportSikap'));
    }

    public function toggleActive($id)
    {
        $this->siswaService->toggleActive($id);
        return redirect()->route('admin.siswa.index')->with('success', 'Status siswa berhasil diubah');
    }

    /**
     * Export raport data to CSV format
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCsv($id)
    {
        $tahunAjaranActive = request()->has('tahun_ajaran_id')
            ? $this->tahunAjaranService->getById(request('tahun_ajaran_id'))
            : $this->tahunAjaranService->getActive();

        $raport = $this->raportService->getRaportBySiswaIdAndTahunAjaranId($id, $tahunAjaranActive->id);

        return $this->exportService->exportRaportToCsv($raport->id);
    }

    /**
     * Export raport data to Excel format
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel($id)
    {
        $tahunAjaranActive = request()->has('tahun_ajaran_id')
            ? $this->tahunAjaranService->getById(request('tahun_ajaran_id'))
            : $this->tahunAjaranService->getActive();

        $raport = $this->raportService->getRaportBySiswaIdAndTahunAjaranId($id, $tahunAjaranActive->id);

        return $this->exportService->exportRaportToExcel($raport->id);
    }
}
