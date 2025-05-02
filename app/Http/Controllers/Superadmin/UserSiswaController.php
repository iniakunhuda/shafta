<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Services\UserSiswaService;
use App\Http\Requests\UserSiswaRequest;
use Illuminate\Http\Request;

class UserSiswaController extends Controller
{
    protected $userSiswaService;

    /**
     * Constructor
     *
     * @param UserSiswaService $userSiswaService
     */
    public function __construct(UserSiswaService $userSiswaService)
    {
        $this->middleware(['auth', 'role:superadmin']);
        $this->userSiswaService = $userSiswaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $siswa = $this->userSiswaService->getAll();
        return view('admin.user_siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user_siswa.create');
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\UserSiswaRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserSiswaRequest $request)
    {
        $data = $request->validated();
        $this->userSiswaService->create($data);
        return redirect()->route('admin.user_siswa.index')->with('success', 'User Siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = $this->userSiswaService->getById($id);
        return view('admin.user_siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = $this->userSiswaService->getById($id);
        return view('admin.user_siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserSiswaRequest $request, string $id)
    {
        $data = $request->validated();
        $this->userSiswaService->update($id, $data);
        return redirect()->route('admin.user_siswa.show', $id)->with('success', 'User Siswa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userSiswaService->delete($id);
        return redirect()->route('admin.user_siswa.index')->with('success', 'User Siswa berhasil dihapus');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(string $id)
    {
        $this->userSiswaService->toggleStatus($id);
        return redirect()->route('admin.user_siswa.index')->with('success', 'Status Siswa berhasil diubah');
    }
}
