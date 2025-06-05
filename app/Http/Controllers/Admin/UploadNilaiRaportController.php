<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImportExcelRaportHelper;
use App\Http\Controllers\Controller;
use App\Http\Services\KelasService;
use App\Http\Services\TahunAjaranService;
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

    public function step2(Request $request)
    {
        // Validate the request
        $request->validate([
            'tahun_ajaran' => 'required',
            'kelas' => 'required',
            'jenjang' => 'required|in:SMP,SMA',
            'jenis_dokumen' => 'string',
        ]);

        // Get data from session
        $students_data = session('upload_raport.students_data');
        $mata_pelajaran = session('upload_raport.mata_pelajaran');
        $ketidakhadiran = session('upload_raport.ketidakhadiran');
        $eskul = session('upload_raport.eskul');

        // If no data found, redirect back to step1
        if (empty($students_data)) {
            return redirect()->route('admin.upload-nilai-raport.step1')
                ->with('error', 'Data tidak ditemukan. Silakan upload file terlebih dahulu.');
        }

        // Get additional data for display
        $tahunAjaran = (new TahunAjaranService)->getById($request->tahun_ajaran);
        $kelas = (new KelasService)->getById($request->kelas);

        return view('admin.upload_nilai_raport.umum.step2', compact(
            'students_data',
            'mata_pelajaran',
            'ketidakhadiran',
            'eskul',
            'tahunAjaran',
            'kelas'
        ));
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
                $students_data = (new ImportExcelRaportHelper)->import_nilai_umum($sheet, $request);

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

        // Get additional data
        $mata_pelajaran = session('upload_raport.mata_pelajaran');
        $ketidakhadiran = session('upload_raport.ketidakhadiran');
        $eskul = session('upload_raport.eskul');
        $tahunAjaran = (new TahunAjaranService)->getById($request->tahun_ajaran);
        $kelas = (new KelasService)->getById($request->kelas);

        return view('admin.upload_nilai_raport.umum.step3', compact(
            'students_data',
            'mata_pelajaran',
            'ketidakhadiran',
            'eskul',
            'tahunAjaran',
            'kelas'
        ));
    }

    public function handleStep3Save(Request $request)
    {
        $request->validate([
            'jenjang' => 'required|in:SMP,SMA',
            'tahun_ajaran' => 'required|exists:tahun_ajaran,id',
            'kelas' => 'required|exists:kelas,id',
        ]);

        try {
            // Get data from session
            $students_data = session('upload_raport.students_data');
            $mata_pelajaran = session('upload_raport.mata_pelajaran');
            $eskul = session('upload_raport.eskul');

            if (empty($students_data)) {
                return redirect()->route('admin.upload-nilai-raport.step1')
                    ->with('error', 'Data tidak ditemukan. Silakan upload file terlebih dahulu.');
            }

            \DB::beginTransaction();

            // First, delete existing raport data for this class, year, and academic year
            \DB::table('raport_nilai')
                ->whereIn('id_raport', function($query) use ($request) {
                    $query->select('id')
                        ->from('raport')
                        ->where('id_tahun_ajaran', $request->tahun_ajaran)
                        ->where('id_kelas', $request->kelas);
                })
                ->delete();

            \DB::table('raport_sikap')
                ->whereIn('id_raport', function($query) use ($request) {
                    $query->select('id')
                        ->from('raport')
                        ->where('id_tahun_ajaran', $request->tahun_ajaran)
                        ->where('id_kelas', $request->kelas);
                })
                ->delete();

            \DB::table('raport')
                ->where('id_tahun_ajaran', $request->tahun_ajaran)
                ->where('id_kelas', $request->kelas)
                ->delete();

            $saved_count = 0;
            $error_count = 0;
            $errors = [];

            foreach ($students_data as $student) {
                try {
                    // Find or create student record
                    $siswa = \DB::table('siswa')
                        ->where('nis', $student['nis'])
                        ->orWhere('nisn', $student['nisn'])
                        ->first();

                    if (!$siswa) {
                        // Create new student record
                        $siswa_id = \DB::table('siswa')->insertGetId([
                            'nis' => $student['nis'],
                            'nisn' => $student['nisn'],
                            'nama' => $student['nama_siswa'],
                            'jenis_kelamin' => 'l', // Default, can be updated later
                            'status' => 'active',
                            'id_kelas' => $request->kelas,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        $siswa_id = $siswa->id;
                        // Update student's class if needed
                        \DB::table('siswa')
                            ->where('id', $siswa_id)
                            ->update([
                                'id_kelas' => $request->kelas,
                                'updated_at' => now(),
                            ]);
                    }

                    // Create raport record
                    $raport_id = \DB::table('raport')->insertGetId([
                        'id_tahun_ajaran' => $request->tahun_ajaran,
                        'id_kelas' => $request->kelas,
                        'id_siswa' => $siswa_id,
                        'sakit' => $student['ketidakhadiran']['sakit'] ?? 0,
                        'izin' => $student['ketidakhadiran']['izin'] ?? 0,
                        'alpa' => $student['ketidakhadiran']['alpha'] ?? 0,
                        'status' => 'draft',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Insert mata pelajaran scores
                    if (!empty($student['mata_pelajaran'])) {
                        foreach ($student['mata_pelajaran'] as $subject_name => $score) {
                            if (!empty(trim($score)) && is_numeric($score)) {
                                // Find or create pelajaran record
                                $pelajaran = \DB::table('pelajaran')
                                    ->where('judul', $subject_name)
                                    ->first();

                                if (!$pelajaran) {
                                    $pelajaran_id = \DB::table('pelajaran')->insertGetId([
                                        'judul' => $subject_name,
                                        'kategori' => 'umum',
                                        'kategori_matkul' => $this->getCategoryBySubject($subject_name),
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]);
                                } else {
                                    $pelajaran_id = $pelajaran->id;
                                }

                                // Insert score
                                \DB::table('raport_nilai')->insert([
                                    'id_raport' => $raport_id,
                                    'id_pelajaran' => $pelajaran_id,
                                    'nilai' => (float)$score,
                                    'nilai_huruf' => $this->convertToGrade($score),
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        }
                    }

                    // Insert ekstrakurikuler scores
                    if (!empty($student['eskul'])) {
                        foreach ($student['eskul'] as $eskul_name => $eskul_score) {
                            if (!empty(trim($eskul_score)) && is_numeric($eskul_score)) {
                                // Find or create pelajaran record
                                $eskul_detail = \DB::table('pelajaran')
                                    ->where('judul', $eskul_name)
                                    ->first();

                                if (!$eskul_detail) {
                                    $eskul_detail_id = \DB::table('pelajaran')->insertGetId([
                                        'judul' => $eskul_name,
                                        'kategori' => 'umum',
                                        'kategori_matkul' => $this->getCategoryBySubject($eskul_name),
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]);
                                } else {
                                    $eskul_detail_id = $eskul_detail->id;
                                }

                                // Insert score
                                \DB::table('raport_nilai')->insert([
                                    'id_raport' => $raport_id,
                                    'id_pelajaran' => $eskul_detail_id,
                                    'nilai' => (float) $eskul_score,
                                    'nilai_huruf' => $this->convertToGrade($eskul_score),
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        }
                    }

                    $saved_count++;

                } catch (\Exception $e) {
                    $error_count++;
                    $errors[] = "Error saving student {$student['nama_siswa']}: " . $e->getMessage();
                    Log::error("Error saving student data: " . $e->getMessage(), [
                        'student' => $student,
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            \DB::commit();

            // Clear session data after successful save
            $this->clearSession();

            $message = "Data berhasil disimpan! {$saved_count} siswa berhasil disimpan.";
            if ($error_count > 0) {
                $message .= " {$error_count} siswa gagal disimpan.";
            }

            return redirect()->route('admin.upload-nilai-raport.step1')
                ->with('success', $message);

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

    private function getCategoryBySubject($subject_name)
    {
        // Categorize subjects based on common Indonesian curriculum
        $ipa_subjects = ['Matematika', 'Fisika', 'Kimia', 'Biologi', 'IPA'];
        $ips_subjects = ['Sejarah', 'Geografi', 'Ekonomi', 'Sosiologi', 'IPS'];
        $eskul_subjects = ['PRAMUKA', 'PANAHAN', 'ENGLISH CLUB', 'BACA KITAB', 'KIR', 'FUTSAL', 'PASKIB', 'BADMINTON', 'PMR', 'BANJARI', 'BASKET'];

        $subject_lower = strtolower($subject_name);

        foreach ($ipa_subjects as $ipa) {
            if (stripos($subject_name, $ipa) !== false) {
                return 'ipa';
            }
        }

        foreach ($ips_subjects as $ips) {
            if (stripos($subject_name, $ips) !== false) {
                return 'ips';
            }
        }

        foreach ($eskul_subjects as $eskul) {
            if (stripos($subject_name, $eskul) !== false) {
                return 'eskul';
            }
        }

        return 'ipa'; // Default to IPA
    }

    private function convertToGrade($score)
    {
        if ($score >= 90) return 'A';
        if ($score >= 80) return 'B';
        if ($score >= 70) return 'C';
        if ($score >= 60) return 'D';
        return 'E';
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
            'upload_data' // Clear the old session key too
        ]);

        return redirect()->route('admin.upload-nilai-raport.step1')
            ->with('success', 'Session data berhasil dihapus.');
    }
}
