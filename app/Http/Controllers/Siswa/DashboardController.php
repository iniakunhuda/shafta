<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Services\TahunAjaranService;
use App\Http\Services\RaportNilaiService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $raportNilaiService;
    protected $tahunAjaranService;

    public function __construct(RaportNilaiService $raportNilaiService, TahunAjaranService $tahunAjaranService)
    {
        $this->raportNilaiService = $raportNilaiService;
        $this->tahunAjaranService = $tahunAjaranService;
        $this->middleware(['auth', 'role:siswa']);
    }

    public function index()
    {
        // Get current tahun ajaran
        $tahunAjaran = $this->tahunAjaranService->getActive();
        
        // Get student's grades
        $nilai = $this->raportNilaiService->getRaportNilaiBySiswaIdAndTahunAjaranId(
            Auth::user()->siswa->id,
            $tahunAjaran->id
        );

        // Calculate performance metrics
        $currentPerformance = (object)[
            'rata_umum' => $nilai->where('pelajaran.kategori', 'umum')->avg('nilai'),
            'rata_keshaftaan' => $nilai->where('pelajaran.kategori', 'keshaftaan')->avg('nilai'),
            'predikat' => $this->getPredikat($nilai->avg('nilai')),
            'peringkat' => $this->getPeringkat(Auth::user()->siswa->id, $tahunAjaran->id)
        ];

        // Get academic data for chart
        $semesters = $this->tahunAjaranService->getAll()->take(4);
        $academicData = collect();
        foreach ($semesters as $semester) {
            $nilaiSemester = $this->raportNilaiService->getRaportNilaiBySiswaIdAndTahunAjaranId(
                Auth::user()->siswa->id,
                $semester->id
            );
            
            $academicData->push((object)[
                'rata_umum' => $nilaiSemester->where('pelajaran.kategori', 'umum')->avg('nilai') ?? 0,
                'rata_keshaftaan' => $nilaiSemester->where('pelajaran.kategori', 'keshaftaan')->avg('nilai') ?? 0
            ]);
        }

        return view('siswa.dashboard', compact(
            'tahunAjaran',
            'nilai',
            'currentPerformance',
            'semesters',
            'academicData'
        ));
    }

    private function getPredikat($nilai)
    {
        if ($nilai >= 90) return 'Sangat Baik';
        if ($nilai >= 80) return 'Baik';
        if ($nilai >= 70) return 'Cukup';
        return 'Kurang';
    }

    private function getPeringkat($siswaId, $tahunAjaranId)
    {
        // TODO: Implement actual ranking calculation
        return '5 dari 30';
    }
}
