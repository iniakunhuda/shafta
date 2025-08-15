<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImportExcelRaportHelper;
use App\Http\Controllers\Controller;
use App\Http\Services\KelasService;
use App\Http\Services\RaportService;
use App\Http\Services\TahunAjaranService;
use App\Models\Raport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class UploadNilaiRaportController extends Controller
{
    protected $tahunAjaranService;

    public function step1(Request $request)
    {
        $kelas = [];
        $tahunAjaran = (new TahunAjaranService)->getAll();
        $jenjang = ["SMP", "SMA"];

        if($request->has('tahun_ajaran')) {
            $kelas = (new KelasService)->getAllWithFilter([
                'tahun_ajaran' => $request->input('tahun_ajaran'),
                'jenjang' => $request->input('jenjang', null),
            ]);
        }

        $data['tahunAjaran'] = $tahunAjaran;
        $data['kelas'] = $kelas;
        $data['jenjang'] = $jenjang;
        return view('admin.upload_nilai_raport.step1', $data);
    }

    public function handleStep1Save(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'kelas' => 'required',
            'file' => 'required|file|mimes:xlsx,csv,xls|max:2048',
            'jenjang' => 'required|in:SMP,SMA',
            'jenis_dokumen' => 'required',
        ]);

        $file = $request->file('file');

        try {
            if (!class_exists('Maatwebsite\Excel\Facades\Excel')) {
                throw new \Exception('Excel package not found. Please install maatwebsite/excel package.');
            }

            $data = Excel::toArray([], $file);
            $sheet = $data[0];

            if (empty($data) || empty($data[0])) {
                throw new \Exception('Excel file is empty or cannot be read.');
            }

            if ($request->jenis_dokumen == 'umum') {
                $students_data = ImportExcelRaportHelper::import_nilai_umum_sma($sheet, $request);

                if (empty($students_data)) {
                    throw new \Exception('No student data found in the Excel file.');
                }

                // Store in persistent session with namespace
                session([
                    'upload_raport.students_data' => $students_data,
                    'upload_raport.mata_pelajaran' => session('upload_data.mata_pelajaran'),
                    'upload_raport.ketidakhadiran' => session('upload_data.ketidakhadiran'),
                    'upload_raport.eskul' => session('upload_data.eskul'),
                    'upload_raport.request_data' => [
                        'jenjang' => $request->jenjang,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'kelas' => $request->kelas,
                        'jenis_dokumen' => $request->jenis_dokumen,
                    ]
                ]);

                return redirect()->route('admin.upload-nilai-raport.step2', [
                    'jenjang' => $request->jenjang,
                    'tahun_ajaran' => $request->tahun_ajaran,
                    'kelas' => $request->kelas,
                    'jenis_dokumen' => $request->jenis_dokumen
                ])->with('success', 'File berhasil diupload. Silakan periksa dan koreksi data.');
            } else if ($request->jenis_dokumen == 'shafta') {
                $students_data = ImportExcelRaportHelper::import_nilai_shafta($sheet, $request);

                if (empty($students_data)) {
                    throw new \Exception('No student data found in the Excel file.');
                }

                // Store in persistent session with namespace
                session([
                    'upload_raport.students_data' => $students_data,
                    'upload_raport.pengembangan_bidang_studi' => session('upload_data.pengembangan_bidang_studi'),
                    'upload_raport.ibadah' => session('upload_data.ibadah'),
                    'upload_raport.keshaftaan' => session('upload_data.keshaftaan'),
                    'upload_raport.request_data' => [
                        'jenjang' => $request->jenjang,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'kelas' => $request->kelas,
                        'jenis_dokumen' => $request->jenis_dokumen,
                    ]
                ]);

                return redirect()->route('admin.upload-nilai-raport.step2', [
                    'jenjang' => $request->jenjang,
                    'tahun_ajaran' => $request->tahun_ajaran,
                    'kelas' => $request->kelas,
                    'jenis_dokumen' => $request->jenis_dokumen
                ])->with('success', 'File berhasil diupload. Silakan periksa dan koreksi data.');
            } else {
                throw new \Exception('Jenis dokumen tidak valid.');
            }

        } catch (\Exception $e) {
            Log::error('Error processing Excel file: ' . $e->getMessage());
            return redirect()->route('admin.upload-nilai-raport.step1', [
                'jenjang' => $request->jenjang,
                'tahuan_ajaran' => $request->tahun_ajaran,
                'kelas' => $request->kelas,
                'jenis_dokumen' => $request->jenis_dokumen
            ])->with('error', 'Error processing file: ' . $e->getMessage());
        }

        return redirect()->route('admin.upload-nilai-raport.step1')->with('success', 'File uploaded successfully.');
    }

    public function step2(Request $request)
    {
        // Validate the request
        $request->validate([
            'tahun_ajaran' => 'required',
            'kelas' => 'required',
            'jenjang' => 'required|in:SMP,SMA',
            'jenis_dokumen' => 'string',
        ]);

        // Get additional data for display
        $tahunAjaran = (new TahunAjaranService)->getById($request->tahun_ajaran);
        $kelas = (new KelasService)->getById($request->kelas);

        $students_data = session('upload_raport.students_data');
        if (empty($students_data)) {
            return redirect()->route('admin.upload-nilai-raport.step1')
                ->with('error', 'Data tidak ditemukan. Silakan upload file terlebih dahulu.');
        }

        if (request()->jenis_dokumen == 'shafta') {
            $pengembangan_bidang_studi = session('upload_raport.pengembangan_bidang_studi');
            $ibadah = session('upload_raport.ibadah');
            $keshaftaan = session('upload_raport.keshaftaan');
            return view('admin.upload_nilai_raport.shafta.step2', compact(
                'students_data',
                'pengembangan_bidang_studi',
                'ibadah',
                'keshaftaan',
                'tahunAjaran',
                'kelas'
            ));

        } else if (request()->jenis_dokumen == 'umum') {
            // Get data from session
            $mata_pelajaran = session('upload_raport.mata_pelajaran');
            $ketidakhadiran = session('upload_raport.ketidakhadiran');
            $eskul = session('upload_raport.eskul');

            return view('admin.upload_nilai_raport.umum.step2', compact(
                'students_data',
                'mata_pelajaran',
                'ketidakhadiran',
                'eskul',
                'tahunAjaran',
                'kelas'
            ));
        } else {
            return redirect()->route('admin.upload-nilai-raport.step1')
                ->with('error', 'Jenis dokumen tidak valid.');
        }
    }

    public function handleStep2Save(Request $request)
    {
        // Validate the corrected data
        $request->validate([
            'students' => 'required|array',
            'students.*.nama_siswa' => 'required|string',
            'students.*.nisn' => 'required',
            'students.*.nis' => 'required',
        ]);

        // Update session data with corrected values
        session([
            'upload_raport.students_data' => $request->students
        ]);

        return redirect()->route('admin.upload-nilai-raport.step2', [
            'jenjang' => $request->jenjang,
            'tahun_ajaran' => $request->tahun_ajaran,
            'kelas' => $request->kelas,
            'jenis_dokumen' => $request->jenis_dokumen
        ])->with('success', 'Data berhasil disimpan. Data siap untuk validasi.');
    }

    public function step3(Request $request)
    {
        // Validation step
        $students_data = session('upload_raport.students_data');
        if (empty($students_data)) {
            return redirect()->route('admin.upload-nilai-raport.step1')
                ->with('error', 'Data tidak ditemukan. Silakan upload file terlebih dahulu.');
        }

        $tahunAjaran = (new TahunAjaranService)->getById($request->tahun_ajaran);
        $kelas = (new KelasService)->getById($request->kelas);

        if (request()->jenis_dokumen == 'shafta') {
            $pengembangan_bidang_studi = session('upload_raport.pengembangan_bidang_studi');
            $ibadah = session('upload_raport.ibadah');
            $keshaftaan = session('upload_raport.keshaftaan');
            return view('admin.upload_nilai_raport.shafta.step3', compact(
                'students_data',
                'pengembangan_bidang_studi',
                'ibadah',
                'keshaftaan',
                'tahunAjaran',
                'kelas'
            ));
        } else if (request()->jenis_dokumen == 'umum') {
            $mata_pelajaran = session('upload_raport.mata_pelajaran');
            $ketidakhadiran = session('upload_raport.ketidakhadiran');
            $eskul = session('upload_raport.eskul');
            return view('admin.upload_nilai_raport.umum.step3', compact(
                'students_data',
                'mata_pelajaran',
                'ketidakhadiran',
                'eskul',
                'tahunAjaran',
                'kelas'
            ));
        } else {
            return redirect()->route('admin.upload-nilai-raport.step1')
                ->with('error', 'Jenis dokumen tidak valid.');
        }
    }

    public function handleStep3Save(Request $request)
    {
        // $request->validate([
        //     'jenjang' => 'required|in:SMP,SMA',
        //     'tahun_ajaran' => 'required',
        //     'kelas' => 'required',
        //     'jenis_dokumen' => 'string'
        // ]);

        try {

            $raportService = new RaportService(new Raport());
            if (request()->jenis_dokumen == 'shafta') {
                $result = $raportService->insertRaportShafta($request);
            } else {
                $result = $raportService->insertRaportUmum($request);
            }

            $this->clearSession();
            if ($result['error_count'] > 0) {
                $message = "Data gagal disimpan! {$result['error_count']} siswa gagal disimpan.";
            } else {
                $message = "Data berhasil disimpan! {$result['saved_count']} siswa berhasil disimpan.";
            }

            if ($result['error_count'] > 0) {
                return redirect()->route('admin.upload-nilai-raport.step3', [
                    'jenjang' => $request->jenjang,
                    'tahun_ajaran' => $request->tahun_ajaran,
                    'kelas' => $request->kelas,
                    'jenis_dokumen' => $request->jenis_dokumen
                ])->with('error', $message);
            } else {
                return redirect()->route('admin.upload-nilai-raport.step1')
                    ->with('success', $message);
            }


        } catch (\Exception $e) {
            \DB::rollback();
            Log::error('Error in handleStep3Save: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.upload-nilai-raport.step3', [
                'jenjang' => $request->jenjang,
                'tahun_ajaran' => $request->tahun_ajaran,
                'kelas' => $request->kelas,
                'jenis_dokumen' => $request->jenis_dokumen
            ])->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }



    public function clearSession()
    {
        // Clear all upload raport session data
        session()->forget([
            'upload_raport.students_data',
            'upload_raport.mata_pelajaran',
            'upload_raport.ketidakhadiran',
            'upload_raport.eskul',
            'upload_raport.request_data',
            'upload_raport.corrected_students_data',
            'upload_raport.is_corrected',
            'upload_raport.pengembangan_bidang_studi',
            'upload_raport.ibadah',
            'upload_raport.keshaftaan',
            'upload_data' // Clear the old session key too
        ]);

        return redirect()->route('admin.upload-nilai-raport.step1')
            ->with('success', 'Session data berhasil dihapus.');
    }
}
