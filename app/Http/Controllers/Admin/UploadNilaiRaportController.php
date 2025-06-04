<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadNilaiRaportController extends Controller
{
    protected $tahunAjaranService;

    public function view()
    {
        $data['tahunAjaran'] = [];
        $data['kelas'] = [];
        return view('admin.upload_nilai_raport.step1', $data);
    }
}
