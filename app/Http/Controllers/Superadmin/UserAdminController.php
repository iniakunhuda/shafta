<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAdminRequest;
use App\Http\Services\UserAdminService;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    protected $userAdminService;

    /**
     * Constructor
     *
     * @param UserAdminService $userAdminService
     */
    public function __construct(UserAdminService $userAdminService)
    {
        $this->middleware(['auth', 'role:superadmin']);
        $this->userAdminService = $userAdminService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $admins = $this->userAdminService->getAllPaginated();
        return view('admin.user_admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user_admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserAdminRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserAdminRequest $request)
    {
        $data = $request->validated();

        $this->userAdminService->create($data);

        return redirect()->route('admin.user_admin.index')
            ->with('success', 'Akun Admin berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $admin = $this->userAdminService->getById($id);

        if (!$admin) {
            return redirect()->route('admin.user_admin.index')
                ->with('error', 'Pengguna bukan admin atau tidak ditemukan.');
        }

        return view('admin.user_admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $admin = $this->userAdminService->getById($id);

        if (!$admin) {
            return redirect()->route('admin.user_admin.index')
                ->with('error', 'Pengguna bukan admin atau tidak ditemukan.');
        }

        return view('admin.user_admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserAdminRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserAdminRequest $request, $id)
    {
        $data = $request->validated();

        $admin = $this->userAdminService->update($id, $data);

        if (!$admin) {
            return redirect()->route('admin.user_admin.index')
                ->with('error', 'Pengguna bukan admin atau tidak ditemukan.');
        }

        return redirect()->route('admin.user_admin.index')
            ->with('success', 'Akun Admin berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $deleted = $this->userAdminService->delete($id);

        if (!$deleted) {
            return redirect()->route('admin.user_admin.index')
                ->with('error', 'Tidak dapat menghapus admin. Pastikan bukan admin terakhir.');
        }

        return redirect()->route('admin.user_admin.index')
            ->with('success', 'Akun Admin berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus($id)
    {
        $admin = $this->userAdminService->toggleStatus($id);

        if (!$admin) {
            return redirect()->route('admin.user_admin.index')
                ->with('error', 'Pengguna bukan admin atau tidak ditemukan.');
        }

        $statusText = ($admin->status === 'active') ? 'diaktifkan' : 'diblokir';

        return redirect()->route('admin.user_admin.index')
            ->with('success', "Status admin berhasil $statusText.");
    }
}
