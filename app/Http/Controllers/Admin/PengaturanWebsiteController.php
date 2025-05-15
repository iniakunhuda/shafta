<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\PengaturanWebsiteService;
use Illuminate\Http\Request;

class PengaturanWebsiteController extends Controller
{
    protected $pengaturanService;
    public function __construct(PengaturanWebsiteService $pengaturanService)
    {
        $this->pengaturanService = $pengaturanService;
    }

    public function index()
    {
        $pengaturan = $this->pengaturanService->getPengaturanWebsite();
        return view('admin.settings.index', compact('pengaturan'));
    }
    public function update(Request $request)
    {
        $result = $this->pengaturanService->updatePengaturanWebsite($request);
        if ($result) {
            return redirect()->back()->with('success', 'Pengaturan website berhasil diupdate');
        }
        return redirect()->back()->with('error', 'Pengaturan website gagal diupdate');
    }
}
