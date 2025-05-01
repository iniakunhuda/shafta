<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TahunAjaranRequest;
use App\Http\Services\TahunAjaranService;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    protected $tahunAjaranService;

    /**
     * Constructor
     *
     * @param TahunAjaranService $tahunAjaranService
     */
    public function __construct(TahunAjaranService $tahunAjaranService)
    {
        $this->tahunAjaranService = $tahunAjaranService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tahunAjaran = $this->tahunAjaranService->getAllPaginated();
        return view('admin.tahun_ajaran.index', compact('tahunAjaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tahun_ajaran.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TahunAjaranRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TahunAjaranRequest $request)
    {
        $data = $request->validated();

        $this->tahunAjaranService->create($data);

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $tahunAjaran = $this->tahunAjaranService->getById($id);

        if (!$tahunAjaran) {
            return redirect()->route('admin.tahun_ajaran.index')
                ->with('error', 'Tahun Ajaran tidak ditemukan.');
        }

        return view('admin.tahun_ajaran.show', compact('tahunAjaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tahunAjaran = $this->tahunAjaranService->getById($id);

        if (!$tahunAjaran) {
            return redirect()->route('admin.tahun_ajaran.index')
                ->with('error', 'Tahun Ajaran tidak ditemukan.');
        }

        return view('admin.tahun_ajaran.edit', compact('tahunAjaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TahunAjaranRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TahunAjaranRequest $request, $id)
    {
        $data = $request->validated();

        $tahunAjaran = $this->tahunAjaranService->update($id, $data);

        if (!$tahunAjaran) {
            return redirect()->route('admin.tahun_ajaran.index')
                ->with('error', 'Tahun Ajaran tidak ditemukan.');
        }

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $deleted = $this->tahunAjaranService->delete($id);

        if (!$deleted) {
            return redirect()->route('admin.tahun_ajaran.index')
                ->with('error', 'Tahun Ajaran tidak ditemukan.');
        }

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActive($id)
    {
        $tahunAjaran = $this->tahunAjaranService->toggleActive($id);

        if (!$tahunAjaran) {
            return redirect()->route('admin.tahun_ajaran.index')
                ->with('error', 'Tahun Ajaran tidak ditemukan.');
        }

        $status = $tahunAjaran->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', "Tahun Ajaran berhasil $status.");
    }
}
