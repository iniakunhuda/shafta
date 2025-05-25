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

class SiswaController extends Controller
{
    protected $siswaService;
    protected $raportService;
    protected $tahunAjaranService;
    protected $raportNilaiService;
    protected $raportSikapService;
    public function __construct(SiswaService $siswaService, RaportService $raportService, TahunAjaranService $tahunAjaranService, RaportNilaiService $raportNilaiService, RaportSikapService $raportSikapService)
    {
        $this->siswaService = $siswaService;
        $this->raportService = $raportService;
        $this->tahunAjaranService = $tahunAjaranService;
        $this->raportNilaiService = $raportNilaiService;
        $this->raportSikapService = $raportSikapService;
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
        $siswa = $this->siswaService->getSiswaById($id);
        return view('admin.siswa.edit', compact('siswa'));
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
        // get siswa
        $siswa = $this->siswaService->getSiswaById($id);
        // get tahun ajaran && tahun ajaran aktif
        $tahunAjaran = $this->tahunAjaranService->getAll();
        $tahunAjaranActive = $this->tahunAjaranService->getActive();
        // get raport by siswa id and tahun ajaran id
        $raport = $this->raportService->getRaportBySiswaIdAndTahunAjaranId($id, $tahunAjaranActive->id);
        // get jumlah siswa
        $jumlahSiswa = $this->raportService->getJumlahSiswaByTahunAjaranId($tahunAjaranActive->id, $raport->id_kelas);
        // get raport nilai umum by raport id
        $raportNilaiUmum = $this->raportNilaiService->getRaportNilaiUmumByRaportId($raport->id);
        // get rata rata nilai umum by raport id
        $rataRataNilaiUmum = $this->raportNilaiService->averageRaportNilaiByRaportId($raport->id, 'umum');
        // get raport nilai shafta by raport id
        $raportNilaiShafta = $this->raportNilaiService->getRaportNilaiShaftaByRaportId($raport->id);
        // get ranking raport nilai umum by raport id
        $rankingRaportNilaiUmum = $this->raportNilaiService->getRankingRaportNilaiByRaportId($raport->id, 'umum', $raport->id_kelas);

        // get raport sikap by raport id
        $raportSikap = $this->raportSikapService->getRaportSikapByRaportId($raport->id);
        return view('admin.siswa.show', compact('siswa', 'raport', 'tahunAjaran', 'tahunAjaranActive', 'raportNilaiUmum', 'raportNilaiShafta', 'rataRataNilaiUmum', 'jumlahSiswa', 'rankingRaportNilaiUmum', 'raportSikap'));
    }

    public function toggleActive($id)
    {
        $this->siswaService->toggleActive($id);
        return redirect()->route('admin.siswa.index')->with('success', 'Status siswa berhasil diubah');
    }
}
