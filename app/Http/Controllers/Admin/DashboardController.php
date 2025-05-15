<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,superadmin']);
    }

    public function index()
    {
        // Get All Semester
        $semester = TahunAjaran::all();
        return view('admin.dashboard', compact('semester'));
    }

}
