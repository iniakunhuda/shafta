<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RaportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the authenticated student's data
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get available semesters/tahun ajaran
        $semesters = DB::table('tahun_ajaran')
            ->select('id', 'nama', 'semester', 'start_date', 'end_date')
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->semester,
                    'tahun' => $item->nama
                ];
            });

        // Get selected semester (default to active semester or first semester)
        $selectedSemesterId = $request->get('semester');
        if (!$selectedSemesterId) {
            $activeSemester = DB::table('tahun_ajaran')->where('is_active', true)->first();
            $selectedSemesterId = $activeSemester ? $activeSemester->id : ($semesters->first() ? $semesters->first()['id'] : null);
        }

        // Find the selected semester data
        $selectedSemester = $semesters->firstWhere('id', $selectedSemesterId);
        if (!$selectedSemester && $semesters->isNotEmpty()) {
            $selectedSemester = $semesters->first();
            $selectedSemesterId = $selectedSemester['id'];
        }

        // Get student's classes for the selected semester
        $classes = [];
        $selectedClass = null;
        $selectedClassId = $request->get('kelas');

        if ($selectedSemesterId) {
            // Get classes where student is enrolled in the selected semester
            $studentClasses = DB::table('kelas')
                ->join('raport', 'kelas.id', '=', 'raport.id_kelas')
                ->where('raport.id_siswa', $siswa->id)
                ->where('raport.id_tahun_ajaran', $selectedSemesterId)
                ->select('kelas.*')
                ->distinct()
                ->get();

            // If no raport data exists, try to get from siswa table
            if ($studentClasses->isEmpty() && $siswa->id_kelas) {
                $studentClasses = DB::table('kelas')
                    ->where('id', $siswa->id_kelas)
                    ->where('id_tahunajaran', $selectedSemesterId)
                    ->get();
            }

            $classes = $studentClasses->map(function ($class) {
                return [
                    'id' => $class->id,
                    'nama' => $class->nama,
                    'tingkat' => $class->jenjang ?? 'Kelas ' . substr($class->nama, 0, strpos($class->nama, ' ')),
                    'wali_kelas' => $class->wali_kelas_nama,
                    'wali_kelas_img' => 'user-img1.png' // Default image
                ];
            })->toArray();

            // Set selected class
            if ($selectedClassId) {
                $selectedClass = collect($classes)->firstWhere('id', $selectedClassId);
            }
            if (!$selectedClass && !empty($classes)) {
                $selectedClass = $classes[0];
                $selectedClassId = $selectedClass['id'];
            }
        }

        // Get raport data for the student
        $raportData = null;
        $nilaiAkademik = [];
        $nilaiKeshaftaan = [];
        $nilaiHafalan = [];
        $sikapData = [];
        $summaryStats = [
            'rata_rata_akademik' => 0,
            'rata_rata_keshaftaan' => 0,
            'predikat_sikap' => 'B',
            'peringkat_kelas' => 0,
            'nilai_tertinggi' => 0,
            'nilai_terendah' => 0,
            'nilai_hafalan' => 0,
            'nilai_keshaftaan' => 0
        ];

        if ($selectedSemesterId && $selectedClassId) {
            // Get main raport record
            $raportData = DB::table('raport')
                ->where('id_tahun_ajaran', $selectedSemesterId)
                ->where('id_kelas', $selectedClassId)
                ->where('id_siswa', $siswa->id)
                ->first();

            if ($raportData) {
                // Get academic grades (nilai umum)
                $nilaiAkademik = DB::table('raport_nilai')
                    ->join('pelajaran', 'raport_nilai.id_pelajaran', '=', 'pelajaran.id')
                    ->where('raport_nilai.id_raport', $raportData->id)
                    ->where('pelajaran.kategori', 'umum')
                    ->select('pelajaran.judul', 'raport_nilai.nilai', 'raport_nilai.nilai_huruf', 'raport_nilai.catatan')
                    ->get();

                // Get keshaftaan grades
                $nilaiKeshaftaan = DB::table('raport_nilai')
                    ->join('pelajaran', 'raport_nilai.id_pelajaran', '=', 'pelajaran.id')
                    ->where('raport_nilai.id_raport', $raportData->id)
                    ->where('pelajaran.kategori', 'shafta')
                    ->select('pelajaran.judul', 'raport_nilai.nilai', 'raport_nilai.nilai_huruf', 'raport_nilai.catatan')
                    ->get();

                // Get hafalan grades
                $nilaiHafalan = DB::table('raport_hafalan')
                    ->where('id_tahun_ajaran', $selectedSemesterId)
                    ->where('id_kelas', $selectedClassId)
                    ->where('id_siswa', $siswa->id)
                    ->select('judul', 'nilai', 'nilai_huruf', 'catatan')
                    ->get();

                // Get sikap data
                $sikapData = DB::table('raport_sikap')
                    ->join('sikap', 'raport_sikap.id_sikap', '=', 'sikap.id')
                    ->where('raport_sikap.id_raport', $raportData->id)
                    ->select('sikap.judul', 'raport_sikap.nilai', 'raport_sikap.keterangan')
                    ->get();

                // Calculate summary statistics
                $akademikValues = $nilaiAkademik->pluck('nilai')->filter()->values();
                $keshaftaanValues = $nilaiKeshaftaan->pluck('nilai')->filter()->values();
                $hafalanValues = $nilaiHafalan->pluck('nilai')->filter()->values();

                $summaryStats = [
                    'rata_rata_akademik' => $akademikValues->isNotEmpty() ? round($akademikValues->avg(), 1) : 0,
                    'rata_rata_keshaftaan' => $keshaftaanValues->isNotEmpty() ? round($keshaftaanValues->avg(), 1) : 0,
                    'predikat_sikap' => $this->calculateSikapGrade($sikapData),
                    'peringkat_kelas' => $this->calculateClassRank($selectedSemesterId, $selectedClassId, $siswa->id),
                    'nilai_tertinggi' => $akademikValues->isNotEmpty() ? $akademikValues->max() : 0,
                    'nilai_terendah' => $akademikValues->isNotEmpty() ? $akademikValues->min() : 0,
                    'nilai_hafalan' => $hafalanValues->isNotEmpty() ? round($hafalanValues->avg(), 1) : 0,
                    'nilai_keshaftaan' => $keshaftaanValues->isNotEmpty() ? round($keshaftaanValues->avg(), 1) : 0
                ];
            }
        }

        // Generate progress chart data (dummy data for demonstration)
        $progressData = $this->generateProgressData($nilaiAkademik, $nilaiKeshaftaan);

        return view('siswa.raport.index', compact(
            'semesters',
            'selectedSemester',
            'selectedSemesterId',
            'classes',
            'selectedClass',
            'selectedClassId',
            'siswa',
            'raportData',
            'nilaiAkademik',
            'nilaiKeshaftaan',
            'nilaiHafalan',
            'sikapData',
            'summaryStats',
            'progressData'
        ));
    }

    /**
     * Display the specified raport details.
     */
    public function show(Request $request, string $id)
    {
        // Get the authenticated student's data
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get the raport record
        $raportData = DB::table('raport')
            ->join('tahun_ajaran', 'raport.id_tahun_ajaran', '=', 'tahun_ajaran.id')
            ->join('kelas', 'raport.id_kelas', '=', 'kelas.id')
            ->where('raport.id', $id)
            ->where('raport.id_siswa', $siswa->id)
            ->select(
                'raport.*',
                'tahun_ajaran.nama as tahun_ajaran_nama',
                'tahun_ajaran.semester',
                'kelas.nama as kelas_nama',
                'kelas.wali_kelas_nama',
                'kelas.jenjang'
            )
            ->first();

        if (!$raportData) {
            return redirect()->route('siswa.raport.index')->with('error', 'Data raport tidak ditemukan atau tidak dapat diakses.');
        }

        // Get academic grades (nilai umum)
        $nilaiAkademik = DB::table('raport_nilai')
            ->join('pelajaran', 'raport_nilai.id_pelajaran', '=', 'pelajaran.id')
            ->where('raport_nilai.id_raport', $raportData->id)
            ->where('pelajaran.kategori', 'umum')
            ->select(
                'pelajaran.judul as mata_pelajaran',
                'raport_nilai.nilai',
                'raport_nilai.nilai_huruf',
                'raport_nilai.catatan'
            )
            ->orderBy('pelajaran.judul')
            ->get();

        // Get keshaftaan grades with parent information
        $nilaiKeshaftaan = DB::table('raport_nilai')
            ->join('pelajaran', 'raport_nilai.id_pelajaran', '=', 'pelajaran.id')
            ->leftJoin('pelajaran as parent_pelajaran', 'pelajaran.id_parent_pelajaran', '=', 'parent_pelajaran.id')
            ->where('raport_nilai.id_raport', $raportData->id)
            ->where('pelajaran.kategori', 'shafta')
            ->select(
                'pelajaran.judul as mata_pelajaran',
                'pelajaran.kategori_matkul',
                'pelajaran.id_parent_pelajaran',
                'parent_pelajaran.judul as parent_judul',
                'raport_nilai.nilai',
                'raport_nilai.nilai_huruf',
                'raport_nilai.catatan'
            )
            ->orderBy('parent_pelajaran.judul')
            ->orderBy('pelajaran.judul')
            ->get();

        // Group keshaftaan by parent or by kategori_matkul if no parent
        $nilaiKeshaftaanGrouped = collect();

        foreach ($nilaiKeshaftaan as $nilai) {
            if ($nilai->id_parent_pelajaran && $nilai->parent_judul) {
                // Group by parent subject
                $groupKey = $nilai->parent_judul;
            } else {
                // Group by kategori_matkul if no parent (fallback to existing logic)
                $groupKey = $nilai->kategori_matkul ?? 'Lainnya';
            }

            if (!$nilaiKeshaftaanGrouped->has($groupKey)) {
                $nilaiKeshaftaanGrouped->put($groupKey, collect());
            }

            $nilaiKeshaftaanGrouped->get($groupKey)->push($nilai);
        }

        // Get hafalan grades
        $nilaiHafalan = DB::table('raport_hafalan')
            ->where('id_tahun_ajaran', $raportData->id_tahun_ajaran)
            ->where('id_kelas', $raportData->id_kelas)
            ->where('id_siswa', $siswa->id)
            ->select('judul', 'nilai', 'nilai_huruf', 'catatan')
            ->orderBy('judul')
            ->get();

        // Get sikap data
        $sikapData = DB::table('raport_sikap')
            ->join('sikap', 'raport_sikap.id_sikap', '=', 'sikap.id')
            ->where('raport_sikap.id_raport', $raportData->id)
            ->select(
                'sikap.judul as sikap_judul',
                'raport_sikap.nilai',
                'raport_sikap.keterangan',
                'raport_sikap.sikap_deskripsi'
            )
            ->orderBy('sikap.judul')
            ->get();

        // Calculate summary statistics
        $akademikValues = $nilaiAkademik->pluck('nilai')->filter()->values();
        $keshaftaanValues = $nilaiKeshaftaan->pluck('nilai')->filter()->values();
        $hafalanValues = $nilaiHafalan->pluck('nilai')->filter()->values();

        $summaryStats = [
            'rata_rata_akademik' => $akademikValues->isNotEmpty() ? round($akademikValues->avg(), 2) : 0,
            'rata_rata_keshaftaan' => $keshaftaanValues->isNotEmpty() ? round($keshaftaanValues->avg(), 2) : 0,
            'predikat_sikap' => $this->calculateSikapGrade($sikapData),
            'peringkat_kelas' => $this->calculateClassRank($raportData->id_tahun_ajaran, $raportData->id_kelas, $siswa->id),
            'nilai_tertinggi' => $akademikValues->isNotEmpty() ? $akademikValues->max() : 0,
            'nilai_terendah' => $akademikValues->isNotEmpty() ? $akademikValues->min() : 0,
            'nilai_hafalan' => $hafalanValues->isNotEmpty() ? round($hafalanValues->avg(), 2) : 0,
            'total_siswa_kelas' => $this->getTotalStudentsInClass($raportData->id_tahun_ajaran, $raportData->id_kelas)
        ];

        // Student information
        $student = [
            'nama' => $siswa->nama,
            'nis' => $siswa->nis,
            'nisn' => $siswa->nisn,
            'kelas' => $raportData->kelas_nama,
            'semester' => $raportData->semester,
            'tahun_ajaran' => $raportData->tahun_ajaran_nama,
            'wali_kelas' => $raportData->wali_kelas_nama
        ];

        return view('siswa.raport.show', compact(
            'raportData',
            'student',
            'nilaiAkademik',
            'nilaiKeshaftaanGrouped',
            'nilaiHafalan',
            'sikapData',
            'summaryStats'
        ));
    }

    /**
     * Calculate sikap grade based on sikap data
     */
    private function calculateSikapGrade($sikapData)
    {
        if ($sikapData->isEmpty()) {
            return 'B';
        }

        $avgSikap = $sikapData->avg('nilai');

        if ($avgSikap >= 90) return 'A';
        if ($avgSikap >= 80) return 'B';
        if ($avgSikap >= 70) return 'C';
        return 'D';
    }

    /**
     * Calculate class rank for the student
     */
    private function calculateClassRank($tahunAjaranId, $kelasId, $siswaId)
    {
        // Get all students in the class with their average grades
        $classRankings = DB::table('raport')
            ->join('raport_nilai', 'raport.id', '=', 'raport_nilai.id_raport')
            ->where('raport.id_tahun_ajaran', $tahunAjaranId)
            ->where('raport.id_kelas', $kelasId)
            ->select('raport.id_siswa', DB::raw('AVG(raport_nilai.nilai) as rata_rata'))
            ->groupBy('raport.id_siswa')
            ->orderBy('rata_rata', 'desc')
            ->get();

        $rank = 1;
        foreach ($classRankings as $ranking) {
            if ($ranking->id_siswa == $siswaId) {
                return $rank;
            }
            $rank++;
        }

        return 0; // Not found
    }

    /**
     * Get total number of students in a class for a specific semester
     */
    private function getTotalStudentsInClass($tahunAjaranId, $kelasId)
    {
        return DB::table('raport')
            ->where('id_tahun_ajaran', $tahunAjaranId)
            ->where('id_kelas', $kelasId)
            ->distinct('id_siswa')
            ->count();
    }

    /**
     * Generate progress data for charts
     */
    private function generateProgressData($nilaiAkademik, $nilaiKeshaftaan)
    {
        // This is a simplified version - you might want to implement actual progress tracking
        $categories = ['Ulangan 1', 'Tugas Kelas', 'UTS', 'Proyek', 'Ulangan 2', 'UAS'];

        if(count($nilaiAkademik) == 0 || count($nilaiKeshaftaan) == 0) {
            return [
                'categories' => $categories,
                'akademik' => array_fill(0, count($categories), 0),
                'keshaftaan' => array_fill(0, count($categories), 0)
            ];
        }

        $akademikAvg = $nilaiAkademik->avg('nilai');
        $keshaftaanAvg = $nilaiKeshaftaan->avg('nilai');

        $akademikProgress = [];
        $keshaftaanProgress = [];

        for ($i = 0; $i < count($categories); $i++) {
            $akademikProgress[] = round($akademikAvg - 10 + ($i * 2) + rand(-2, 2), 1);
            $keshaftaanProgress[] = round($keshaftaanAvg - 8 + ($i * 1.5) + rand(-1, 1), 1);
        }

        return [
            'categories' => $categories,
            'akademik' => $akademikProgress,
            'keshaftaan' => $keshaftaanProgress
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
