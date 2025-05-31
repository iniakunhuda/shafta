<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\RaportNilaiService;
use App\Http\Services\TahunAjaranService;
use App\Http\Services\KelasService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $raportNilaiService;
    protected $tahunAjaranService;
    protected $kelasService;

    public function __construct(
        RaportNilaiService $raportNilaiService,
        TahunAjaranService $tahunAjaranService,
        KelasService $kelasService
    ) {
        $this->raportNilaiService = $raportNilaiService;
        $this->tahunAjaranService = $tahunAjaranService;
        $this->kelasService = $kelasService;
    }

    public function index()
    {
        $semesterActive = $this->tahunAjaranService->getActive();
        $semester = $this->tahunAjaranService->getAll();

        // Get all classes for the active semester
        $kelas = $this->kelasService->getByTahunAjaranId($semesterActive->id);
        
        // Initialize arrays for chart data
        $nilaiUmum = [];
        $nilaiKeshaftaan = [];
        
        // Get average grades for each class
        foreach ($kelas as $k) {
            $raport = $k->raports()->first();
            if ($raport) {
                $nilaiUmum[] = $this->raportNilaiService->averageRaportNilaiByRaportId($raport->id, 'umum');
                $nilaiKeshaftaan[] = $this->raportNilaiService->averageRaportNilaiByRaportId($raport->id, 'shafta');
            }
        }

        return view('admin.dashboard', compact('semesterActive', 'semester', 'nilaiUmum', 'nilaiKeshaftaan', 'kelas'));
    }
}
