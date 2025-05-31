<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\RaportNilaiService;
use App\Http\Services\TahunAjaranService;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
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
        $tahunAjaran = $this->tahunAjaranService->getActive();
        $nilai = $this->raportNilaiService->getRaportNilaiBySiswaIdAndTahunAjaranId(
            Auth::user()->siswa->id,
            $tahunAjaran->id
        );

        return view('siswa.nilai.index', compact('nilai', 'tahunAjaran'));
    }

    public function show($id)
    {
        $nilai = $this->raportNilaiService->getRaportNilaiById($id);
        
        if (!$nilai || $nilai->raport->id_siswa !== Auth::user()->siswa->id) {
            abort(404);
        }

        return view('siswa.nilai.show', compact('nilai'));
    }
} 