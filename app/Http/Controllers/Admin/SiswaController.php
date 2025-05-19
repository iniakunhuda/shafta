<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\EditSiswaRequest;
use App\Http\Services\SiswaService;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    protected $siswaService;

    public function __construct(SiswaService $siswaService)
    {
        $this->siswaService = $siswaService;
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
        $siswa = $this->siswaService->getSiswaById($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function toggleActive($id)
    {
        $this->siswaService->toggleActive($id);
        return redirect()->route('admin.siswa.index')->with('success', 'Status siswa berhasil diubah');
    }
}
