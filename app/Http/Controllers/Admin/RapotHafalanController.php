<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\RapotHafalanService;
use App\Http\Services\SiswaService;
use App\Http\Services\TahunAjaranService;

class RapotHafalanController extends Controller
{

    protected $rapotHafalanService;
    protected $siswaService;
    protected $tahunAjaranService;

    public function __construct(RapotHafalanService $rapotHafalanService, SiswaService $siswaService, TahunAjaranService $tahunAjaranService)
    {
        $this->rapotHafalanService = $rapotHafalanService;
        $this->siswaService = $siswaService;
        $this->tahunAjaranService = $tahunAjaranService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rapotHafalan = $this->rapotHafalanService->getRapotHafalan();
        return view('admin.rapot-hafalan.index', compact('rapotHafalan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = $this->siswaService->getSiswa();
        $tahunAjaran = $this->tahunAjaranService->getTah();
        return view('admin.rapot-hafalan.create', compact('siswa', 'tahunAjaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
