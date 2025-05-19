<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\KelasService;
use App\Http\Requests\KelasRequest;
use App\Http\Services\TahunAjaranService;

class KelasController extends Controller
{
    protected $kelasService;
    protected $tahunAjaranService;
    /**
     * Constructor
     *
     * @param KelasService $kelasService
     * @param TahunAjaranService $tahunAjaranService
     */
    public function __construct(KelasService $kelasService, TahunAjaranService $tahunAjaranService)
    {
        $this->kelasService = $kelasService;
        $this->tahunAjaranService = $tahunAjaranService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $kelas = $this->kelasService->getAll();
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tahunAjaran = $this->tahunAjaranService->getAll();
        return view('admin.kelas.create', compact('tahunAjaran'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KelasRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(KelasRequest $request)
    {
        $data = $request->validated();
        $kelas = $this->kelasService->create($data);
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $kelas = $this->kelasService->getById($id);
        $tahunAjaran = $this->tahunAjaranService->getAll();
        return view('admin.kelas.edit', compact('kelas', 'tahunAjaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param KelasRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(KelasRequest $request, $id)
    {
        $data = $request->validated();
        $kelas = $this->kelasService->update($id, $data);
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->kelasService->delete($id);
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $kelas = $this->kelasService->getById($id);
        return view('admin.kelas.show', compact('kelas'));
    }
    


}
