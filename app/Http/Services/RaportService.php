<?php

namespace App\Http\Services;

use App\Models\Raport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RaportService
{
    protected $raport;

    public function __construct(Raport $raport)
    {
        $this->raport = $raport;
    }

    public function getRaport()
    {
        return $this->raport->all();
    }

    public function getRaportById($id)
    {
        return $this->raport->find($id);
    }

    public function createRaport($data)
    {
        return $this->raport->create($data);
    }

    public function updateRaport($id, $data)
    {
        return $this->raport->find($id)->update($data);
    }

    public function deleteRaport($id)
    {
        return $this->raport->find($id)->delete();
    }

    public function getRaportBySiswaId($siswaId)
    {
        return $this->raport->where('id_siswa', $siswaId)->get();
    }

    public function getRaportByTahunAjaranId($tahunAjaranId)
    {
        return $this->raport->where('id_tahun_ajaran', $tahunAjaranId)->get();
    }

    public function getRaportBySiswaIdAndTahunAjaranId($siswaId, $tahunAjaranId)
    {
        return $this->raport->with('tahunAjaran')->where('id_siswa', $siswaId)->where('id_tahun_ajaran', $tahunAjaranId)->first();
    }

    public function getJumlahSiswaByTahunAjaranId($tahunAjaranId, $kelasId)
    {
        return $this->raport->where('id_tahun_ajaran', $tahunAjaranId)->where('id_kelas', $kelasId)->count();
    }

    public function importRaportUmum(Request $request)
    {
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
                    ->where('import_type', 'umum')
                    ->where('id_tahun_ajaran', $request->tahun_ajaran)
                    ->where('id_kelas', $request->kelas);
            })
            ->delete();

        \DB::table('raport_sikap')
            ->whereIn('id_raport', function($query) use ($request) {
                $query->select('id')
                    ->from('raport')
                    ->where('import_type', 'umum')
                    ->where('id_tahun_ajaran', $request->tahun_ajaran)
                    ->where('id_kelas', $request->kelas);
            })
            ->delete();

        \DB::table('raport')
            ->where('import_type', 'umum')
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
                    'import_type' => 'umum',
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

        if ($error_count > 0) {
            return [
                'status' => false,
                'saved_count' => $saved_count,
                'error_count' => $error_count,
                'errors' => $errors
            ];
        } else {
            return [
                'status' => true,
                'saved_count' => $saved_count,
                'error_count' => $error_count,
                'errors' => []
            ];
        }
    }

    private function getCategoryBySubject($subject_name)
    {
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

}
