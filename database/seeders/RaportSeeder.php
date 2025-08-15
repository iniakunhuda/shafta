<?php

namespace Database\Seeders;

use App\Models\Kalender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Sikap;
use App\Models\Siswa;
use App\Models\Raport;
use App\Models\RaportNilai;
use App\Models\RaportSikap;
use App\Models\RaportHafalan;
use App\Models\Pengaturan;
use Carbon\Carbon;

class RaportSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tahunAjaran1 = TahunAjaran::find(1) ?? TahunAjaran::create([
            'nama' => '2023/2024',
            'semester' => 'Semester 2',
            'start_date' => '2024-01-15',
            'end_date' => '2024-06-20',
            'is_active' => false,
        ]);

        $tahunAjaran2 = TahunAjaran::find(2) ?? TahunAjaran::create([
            'nama' => '2024/2025',
            'semester' => 'Semester 1',
            'start_date' => '2024-07-15',
            'end_date' => '2024-12-20',
            'is_active' => true,
        ]);

        $kelasModels1 = [];
        $kelasModels2 = [];
        $pelajaranModels = [];

        // Create Sikap (for Attitude & Spirituality)
        $ibadahSikap = Sikap::create([
            'kode' => 'IBADAH',
            'judul' => 'IBADAH',
            'deskripsi' => 'Penilaian Ibadah',
            'bobot' => 1,
        ]);

        $ibadahChildren = [
            'SALAT_DHUHA' => 'SALAT DHUHA',
            'SALAT_JUMAT' => 'SALAT JUM\'AT/KEPUTRIAN',
            'SALAT_ZUHUR_ASAR' => 'SALAT ZUHUR DAN ASAR',
        ];

        foreach ($ibadahChildren as $kode => $judul) {
            Sikap::create([
                'kode' => $kode,
                'judul' => $judul,
                'deskripsi' => 'Penilaian ' . $judul,
                'id_parent_sikap' => $ibadahSikap->id,
                'bobot' => 1,
            ]);
        }

        $hafalanSikap = Sikap::create([
            'kode' => 'KESHAFTAAN',
            'judul' => 'KESHAFTAAN',
            'deskripsi' => 'Penilaian Keshaftaan',
            'bobot' => 1,
        ]);

        $keshaftaanChildren = [
            'HAFALAN_SURAT' => 'Hafalan Surat Pendek',
            'HAFALAN_DOA' => 'Hafalan Doa Harian dan Bacaan Sholawat',
            'HAFALAN_BERSUCI' => 'Hafalan Doa dan Bacaan Bersuci',
            'BACAAN_TAHLIL' => 'Bacaan Tahlil',
            'BACAAN_ISTIGHOSAH' => 'Bacaan Istighosah',
            'BACAAN_SHALAT' => 'Bacaan Setelah Shalat (Dzikir)',
            'HAFALAN_QUNUT' => 'Hafalan Doa Qunut',
            'HAFALAN_ASMAUL_HUSNA' => 'Hafalan Asmaul Husna',
            'PRAKTIK_WUDHU_SHALAT' => 'Praktik Wudhu dan Shalat',
        ];

        $keshaftaanModels = [];
        foreach ($keshaftaanChildren as $kode => $judul) {
            $keshaftaanModels[$kode] = Sikap::create([
                'kode' => $kode,
                'judul' => $judul,
                'deskripsi' => 'Penilaian ' . $judul,
                'id_parent_sikap' => $hafalanSikap->id,
                'bobot' => 1,
            ]);
        }

        // Add some default settings
        Pengaturan::setValue('school_name', 'SMA SHAFTA', 'general');
        Pengaturan::setValue('school_address', 'Jl. Pendidikan No. 123, Kota Surabaya', 'general');
        Pengaturan::setValue('school_phone', '(031) 1234567', 'general');
        Pengaturan::setValue('school_email', 'info@shafta.ac.id', 'general');
        Pengaturan::setValue('principal_name', 'Dr. H. Ahmad Fauzi, M.Pd.', 'general');

        $students = [
            [
                'nis' => '3082',
                'nisn' => '0079525966',
                'nama' => 'ACHMAD ALFIAN ARDIANSYAH',
                'jenis_kelamin' => 'l',
                'kelas' => 'XII 4',
                'nilai' => [
                    'PAI' => 90,
                    'PKN' => 88,
                    'B_INDO' => 80,
                    'MAT' => 92,
                    'B_INGG' => 86,
                    'PJOK' => 98,
                    'SEJARAH' => 89,
                    'SENI' => 94,
                    'SOSIO' => 92,
                    'PKWU' => 90,
                    'B_JAWA' => 80,
                ],
                'ekskul' => [
                    'FUTSAL' => 90,
                    'BANJARI' => 80,
                ],
                'ketidakhadiran' => [
                    'sakit' => 1,
                    'izin' => 0,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3083',
                'nisn' => '0079525967',
                'nama' => 'AHMAD RIZKI PRATAMA',
                'jenis_kelamin' => 'l',
                'kelas' => 'XII 4',
                'nilai' => [
                    'PAI' => 85,
                    'PKN' => 82,
                    'B_INDO' => 90,
                    'MAT' => 95,
                    'B_INGG' => 88,
                    'PJOK' => 90,
                    'SEJARAH' => 84,
                    'SENI' => 87,
                    'SOSIO' => 85,
                    'PKWU' => 88,
                    'B_JAWA' => 83,
                ],
                'ekskul' => [
                    'PRAMUKA' => 85,
                    'KIR' => 88,
                ],
                'ketidakhadiran' => [
                    'sakit' => 2,
                    'izin' => 1,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3084',
                'nisn' => '0079525968',
                'nama' => 'ANISA FITRI RAMADHANI',
                'jenis_kelamin' => 'p',
                'kelas' => 'XII 3',
                'nilai' => [
                    'PAI' => 92,
                    'PKN' => 85,
                    'B_INDO' => 94,
                    'MAT' => 88,
                    'B_INGG' => 90,
                    'PJOK' => 85,
                    'SEJARAH' => 89,
                    'SENI' => 92,
                    'BIO' => 87,
                    'PKWU' => 84,
                    'B_JAWA' => 90,
                ],
                'ekskul' => [
                    'PMR' => 92,
                    'ENGLISH_CLUB' => 93,
                ],
                'ketidakhadiran' => [
                    'sakit' => 0,
                    'izin' => 2,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3085',
                'nisn' => '0079525969',
                'nama' => 'BUDI SANTOSO',
                'jenis_kelamin' => 'l',
                'kelas' => 'XII 3',
                'nilai' => [
                    'PAI' => 80,
                    'PKN' => 85,
                    'B_INDO' => 78,
                    'MAT' => 75,
                    'B_INGG' => 82,
                    'PJOK' => 95,
                    'SEJARAH' => 80,
                    'SENI' => 85,
                    'BIO' => 78,
                    'PKWU' => 83,
                    'B_JAWA' => 88,
                ],
                'ekskul' => [
                    'BASKET' => 92,
                    'BADMINTON' => 90,
                ],
                'ketidakhadiran' => [
                    'sakit' => 3,
                    'izin' => 0,
                    'alpa' => 1,
                ],
            ],
            [
                'nis' => '3086',
                'nisn' => '0079525970',
                'nama' => 'DINDA AMALIYA',
                'jenis_kelamin' => 'p',
                'kelas' => 'XII 3',
                'nilai' => [
                    'PAI' => 95,
                    'PKN' => 92,
                    'B_INDO' => 94,
                    'MAT' => 97,
                    'B_INGG' => 93,
                    'PJOK' => 85,
                    'SEJARAH' => 90,
                    'SENI' => 96,
                    'BIO' => 95,
                    'PKWU' => 92,
                    'B_JAWA' => 90,
                ],
                'ekskul' => [
                    'KIR' => 95,
                    'BACA_KITAB' => 90,
                ],
                'ketidakhadiran' => [
                    'sakit' => 0,
                    'izin' => 0,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3087',
                'nisn' => '0079525971',
                'nama' => 'ERICK FIRMANSYAH',
                'jenis_kelamin' => 'l',
                'kelas' => 'XII 2',
                'nilai' => [
                    'PAI' => 78,
                    'PKN' => 80,
                    'B_INDO' => 85,
                    'MAT' => 75,
                    'B_INGG' => 83,
                    'PJOK' => 90,
                    'SEJARAH' => 82,
                    'SENI' => 85,
                    'GEO' => 80,
                    'EKONOMI' => 84,
                    'PKWU' => 79,
                    'B_JAWA' => 82,
                ],
                'ekskul' => [
                    'FUTSAL' => 94,
                    'PASKIB' => 85,
                ],
                'ketidakhadiran' => [
                    'sakit' => 2,
                    'izin' => 3,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3088',
                'nisn' => '0079525972',
                'nama' => 'FATIMAH AZ-ZAHRA',
                'jenis_kelamin' => 'p',
                'kelas' => 'XII 2',
                'nilai' => [
                    'PAI' => 96,
                    'PKN' => 93,
                    'B_INDO' => 90,
                    'MAT' => 92,
                    'B_INGG' => 94,
                    'PJOK' => 88,
                    'SEJARAH' => 91,
                    'SENI' => 95,
                    'GEO' => 90,
                    'EKONOMI' => 92,
                    'PKWU' => 90,
                    'B_JAWA' => 85,
                ],
                'ekskul' => [
                    'PANAHAN' => 92,
                    'BACA_KITAB' => 96,
                ],
                'ketidakhadiran' => [
                    'sakit' => 1,
                    'izin' => 1,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3089',
                'nisn' => '0079525973',
                'nama' => 'GALIH PAMUNGKAS',
                'jenis_kelamin' => 'l',
                'kelas' => 'XII 2',
                'nilai' => [
                    'PAI' => 82,
                    'PKN' => 85,
                    'B_INDO' => 80,
                    'MAT' => 90,
                    'B_INGG' => 85,
                    'PJOK' => 94,
                    'SEJARAH' => 83,
                    'SENI' => 80,
                    'GEO' => 82,
                    'EKONOMI' => 85,
                    'PKWU' => 84,
                    'B_JAWA' => 82,
                ],
                'ekskul' => [
                    'FUTSAL' => 95,
                    'BADMINTON' => 92,
                ],
                'ketidakhadiran' => [
                    'sakit' => 0,
                    'izin' => 2,
                    'alpa' => 1,
                ],
            ],
            [
                'nis' => '3090',
                'nisn' => '0079525974',
                'nama' => 'HANA PERMATA DEWI',
                'jenis_kelamin' => 'p',
                'kelas' => 'XII 1',
                'nilai' => [
                    'PAI' => 88,
                    'PKN' => 90,
                    'B_INDO' => 92,
                    'MAT' => 85,
                    'B_INGG' => 94,
                    'PJOK' => 82,
                    'SEJARAH' => 87,
                    'SENI' => 93,
                    'SOSIO' => 90,
                    'GEO' => 88,
                    'PKWU' => 91,
                    'B_JAWA' => 89,
                ],
                'ekskul' => [
                    'PRAMUKA' => 92,
                    'PMR' => 90,
                ],
                'ketidakhadiran' => [
                    'sakit' => 1,
                    'izin' => 1,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3091',
                'nisn' => '0079525975',
                'nama' => 'ILHAM MAULANA',
                'jenis_kelamin' => 'l',
                'kelas' => 'XII 1',
                'nilai' => [
                    'PAI' => 85,
                    'PKN' => 82,
                    'B_INDO' => 80,
                    'MAT' => 96,
                    'B_INGG' => 83,
                    'PJOK' => 92,
                    'SEJARAH' => 80,
                    'SENI' => 78,
                    'SOSIO' => 82,
                    'GEO' => 85,
                    'PKWU' => 84,
                    'B_JAWA' => 80,
                ],
                'ekskul' => [
                    'BASKET' => 93,
                    'KIR' => 88,
                ],
                'ketidakhadiran' => [
                    'sakit' => 2,
                    'izin' => 0,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3092',
                'nisn' => '0079525976',
                'nama' => 'JASMINE AULIA',
                'jenis_kelamin' => 'p',
                'kelas' => 'XII 1',
                'nilai' => [
                    'PAI' => 93,
                    'PKN' => 90,
                    'B_INDO' => 94,
                    'MAT' => 91,
                    'B_INGG' => 96,
                    'PJOK' => 88,
                    'SEJARAH' => 92,
                    'SENI' => 95,
                    'SOSIO' => 93,
                    'GEO' => 90,
                    'PKWU' => 92,
                    'B_JAWA' => 91,
                ],
                'ekskul' => [
                    'ENGLISH_CLUB' => 96,
                    'BANJARI' => 90,
                ],
                'ketidakhadiran' => [
                    'sakit' => 0,
                    'izin' => 0,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3093',
                'nisn' => '0079525977',
                'nama' => 'KURNIAWAN BUDI',
                'jenis_kelamin' => 'l',
                'kelas' => 'XI 4',
                'nilai' => [
                    'PAI' => 80,
                    'PKN' => 82,
                    'B_INDO' => 85,
                    'MAT' => 78,
                    'B_INGG' => 80,
                    'PJOK' => 95,
                    'SEJARAH' => 82,
                    'SENI' => 80,
                    'BIO' => 78,
                    'EKONOMI' => 82,
                    'PKWU' => 80,
                    'B_JAWA' => 83,
                ],
                'ekskul' => [
                    'FUTSAL' => 90,
                    'PASKIB' => 85,
                ],
                'ketidakhadiran' => [
                    'sakit' => 3,
                    'izin' => 2,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3094',
                'nisn' => '0079525978',
                'nama' => 'LINA FADILAH',
                'jenis_kelamin' => 'p',
                'kelas' => 'XI 4',
                'nilai' => [
                    'PAI' => 92,
                    'PKN' => 90,
                    'B_INDO' => 94,
                    'MAT' => 88,
                    'B_INGG' => 95,
                    'PJOK' => 85,
                    'SEJARAH' => 90,
                    'SENI' => 92,
                    'BIO' => 89,
                    'EKONOMI' => 90,
                    'PKWU' => 92,
                    'B_JAWA' => 88,
                ],
                'ekskul' => [
                    'PMR' => 93,
                    'BACA_KITAB' => 95,
                ],
                'ketidakhadiran' => [
                    'sakit' => 1,
                    'izin' => 0,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3095',
                'nisn' => '0079525979',
                'nama' => 'MUHAMMAD IQBAL',
                'jenis_kelamin' => 'l',
                'kelas' => 'XI 3',
                'nilai' => [
                    'PAI' => 95,
                    'PKN' => 88,
                    'B_INDO' => 85,
                    'MAT' => 90,
                    'B_INGG' => 92,
                    'PJOK' => 94,
                    'SEJARAH' => 88,
                    'SENI' => 85,
                    'SOSIO' => 87,
                    'EKONOMI' => 90,
                    'PKWU' => 89,
                    'B_JAWA' => 85,
                ],
                'ekskul' => [
                    'BACA_KITAB' => 96,
                    'PANAHAN' => 90,
                ],
                'ketidakhadiran' => [
                    'sakit' => 0,
                    'izin' => 1,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3096',
                'nisn' => '0079525980',
                'nama' => 'NADIA PUTRI',
                'jenis_kelamin' => 'p',
                'kelas' => 'XI 3',
                'nilai' => [
                    'PAI' => 90,
                    'PKN' => 92,
                    'B_INDO' => 95,
                    'MAT' => 88,
                    'B_INGG' => 94,
                    'PJOK' => 86,
                    'SEJARAH' => 90,
                    'SENI' => 93,
                    'SOSIO' => 91,
                    'EKONOMI' => 89,
                    'PKWU' => 90,
                    'B_JAWA' => 88,
                ],
                'ekskul' => [
                    'ENGLISH_CLUB' => 95,
                    'KIR' => 93,
                ],
                'ketidakhadiran' => [
                    'sakit' => 2,
                    'izin' => 0,
                    'alpa' => 0,
                ],
            ],
            [
                'nis' => '3097',
                'nisn' => '0079525981',
                'nama' => 'OKTAVIAN DWI PUTRA',
                'jenis_kelamin' => 'l',
                'kelas' => 'XI 2',
                'nilai' => [
                    'PAI' => 82,
                    'PKN' => 80,
                    'B_INDO' => 78,
                    'MAT' => 85,
                    'B_INGG' => 80,
                    'PJOK' => 92,
                    'SEJARAH' => 75,
                    'SENI' => 80,
                    'BIO' => 78,
                    'EKONOMI' => 80,
                    'PKWU' => 82,
                    'B_JAWA' => 78,
                ],
                'ekskul' => [
                    'FUTSAL' => 92,
                    'BADMINTON' => 90,
                ],
                'ketidakhadiran' => [
                    'sakit' => 2,
                    'izin' => 5,
                    'alpa' => 1,
                ],
            ],
            [
                'nis' => '3098',
                'nisn' => '0079525982',
                'nama' => 'PUTRI RAMADHANI',
                'jenis_kelamin' => 'p',
                'kelas' => 'XI 2',
                'nilai' => [
                    'PAI' => 94,
                    'PKN' => 92,
                    'B_INDO' => 96,
                    'MAT' => 90,
                    'B_INGG' => 95,
                    'PJOK' => 88,
                    'SEJARAH' => 90,
                    'SENI' => 93,
                    'BIO' => 91,
                    'EKONOMI' => 90,
                    'PKWU' => 92,
                    'B_JAWA' => 89,
                ],
                'ekskul' => [
                    'PMR' => 95,
                    'BASKET' => 90,
                ],
                'ketidakhadiran' => [
                    'sakit' => 0,
                    'izin' => 1,
                    'alpa' => 0,
                ],
            ],
        ];

        // Create students and their reports for both academic years
        foreach ($students as $studentData) {
            // Create Siswa
            $siswa = Siswa::create([
                'nis' => $studentData['nis'],
                'nisn' => $studentData['nisn'],
                'nama' => $studentData['nama'],
                'jenis_kelamin' => $studentData['jenis_kelamin'],
                'status' => 'active',
            ]);

            // User account for each student
            User::create([
                'nama' => $studentData['nama'],
                'email' => $studentData['nis'].'@shafta.sch.id',
                'password' => Hash::make($studentData['nis']),
                'role' => 'siswa',
                'status' => 'active',
            ]);

            // Create Raport for Tahun Ajaran 1 (2023/2024)
            $raport1 = Raport::create([
                'id_siswa' => $siswa->id,
                'id_tahun_ajaran' => $tahunAjaran1->id,
                'id_kelas' => $kelasModels1[$studentData['kelas']]->id,
                'sakit' => $studentData['ketidakhadiran']['sakit'] ?? 0,
                'izin' => $studentData['ketidakhadiran']['izin'] ?? 0,
                'alpa' => $studentData['ketidakhadiran']['alpa'] ?? 0,
                'catatan' => 'Catatan Semester 2 2023/2024 untuk ' . $siswa->nama,
                'prestasi' => null,
                'status' => 'published'
            ]);

            // Create Raport for Tahun Ajaran 2 (2024/2025)
            $raport2 = Raport::create([
                'id_siswa' => $siswa->id,
                'id_tahun_ajaran' => $tahunAjaran2->id,
                'id_kelas' => $kelasModels2[$studentData['kelas']]->id,
                'sakit' => $studentData['ketidakhadiran']['sakit'] ?? 0,
                'izin' => $studentData['ketidakhadiran']['izin'] ?? 0,
                'alpa' => $studentData['ketidakhadiran']['alpa'] ?? 0,
                'catatan' => 'Catatan Semester 1 2024/2025 untuk ' . $siswa->nama,
                'prestasi' => null,
                'status' => 'published'
            ]);

            // Create Nilai for Tahun Ajaran 1
            foreach ($studentData['nilai'] as $kode => $nilai) {
                // For Tahun Ajaran 1 (2023/2024), use the base nilai with some variation
                $nilai1 = max(0, min(100, $nilai + rand(-3, 3)));
                RaportNilai::create([
                    'id_raport' => $raport1->id,
                    'id_pelajaran' => $pelajaranModels[$kode]->id,
                    'nilai' => $nilai1,
                    'nilai_huruf' => $this->getNilaiHuruf($nilai1),
                    'catatan' => 'Nilai semester 2 2023/2024',
                ]);
            }

            // Create Nilai for Tahun Ajaran 2
            foreach ($studentData['nilai'] as $kode => $nilai) {
                // For Tahun Ajaran 2 (2024/2025), show improvement or decline based on subject
                $variation = 0;

                // Add more variation based on subject type
                switch ($kode) {
                    case 'PAI':
                    case 'PKN':
                    case 'B_INDO':
                        // These subjects tend to improve
                        $variation = rand(2, 5);
                        break;
                    case 'MAT':
                    case 'B_INGG':
                        // These subjects might have more variation
                        $variation = rand(-2, 5);
                        break;
                    case 'PJOK':
                    case 'SENI':
                        // These subjects might have slight decline
                        $variation = rand(-3, 2);
                        break;
                    default:
                        // Other subjects have moderate variation
                        $variation = rand(-2, 3);
                }

                $nilai2 = max(0, min(100, $nilai + $variation));
                RaportNilai::create([
                    'id_raport' => $raport2->id,
                    'id_pelajaran' => $pelajaranModels[$kode]->id,
                    'nilai' => $nilai2,
                    'nilai_huruf' => $this->getNilaiHuruf($nilai2),
                    'catatan' => 'Nilai semester 1 2024/2025',
                ]);
            }

            // Create Ekskul values for both academic years
            if (isset($studentData['ekskul'])) {
                foreach ($studentData['ekskul'] as $kode => $nilai) {
                    // For Tahun Ajaran 1, use base nilai with small variation
                    $nilaiEkskul1 = max(0, min(100, $nilai + rand(-2, 2)));
                    RaportNilai::create([
                        'id_raport' => $raport1->id,
                        'id_pelajaran' => $pelajaranModels[$kode]->id,
                        'nilai' => $nilaiEkskul1,
                        'nilai_huruf' => $this->getNilaiHuruf($nilaiEkskul1),
                        'catatan' => 'Nilai ekstrakurikuler semester 2 2023/2024',
                    ]);

                    // For Tahun Ajaran 2, show improvement in extracurricular activities
                    $nilaiEkskul2 = max(0, min(100, $nilaiEkskul1 + rand(1, 5)));
                    RaportNilai::create([
                        'id_raport' => $raport2->id,
                        'id_pelajaran' => $pelajaranModels[$kode]->id,
                        'nilai' => $nilaiEkskul2,
                        'nilai_huruf' => $this->getNilaiHuruf($nilaiEkskul2),
                        'catatan' => 'Nilai ekstrakurikuler semester 1 2024/2025',
                    ]);
                }
            }

            // Create Sikap for both academic years
            foreach ($keshaftaanModels as $kode => $sikap) {
                // For Tahun Ajaran 1, generate base sikap scores
                $nilaiSikap1 = rand(80, 95);
                RaportSikap::create([
                    'id_raport' => $raport1->id,
                    'id_sikap' => $sikap->id,
                    'sikap_judul' => $sikap->judul,
                    'sikap_deskripsi' => $sikap->deskripsi,
                    'bobot' => $sikap->bobot,
                    'jumlah' => 0,
                    'nilai' => $nilaiSikap1,
                    'keterangan' => 'Keterangan ' . $sikap->judul . ' untuk semester 2 2023/2024',
                ]);

                // For Tahun Ajaran 2, show improvement in sikap scores
                $nilaiSikap2 = min(100, $nilaiSikap1 + rand(1, 5));
                RaportSikap::create([
                    'id_raport' => $raport2->id,
                    'id_sikap' => $sikap->id,
                    'sikap_judul' => $sikap->judul,
                    'sikap_deskripsi' => $sikap->deskripsi,
                    'bobot' => $sikap->bobot,
                    'jumlah' => 0,
                    'nilai' => $nilaiSikap2,
                    'keterangan' => 'Keterangan ' . $sikap->judul . ' untuk semester 1 2024/2025',
                ]);
            }

            // Create Hafalan entries for both academic years
            foreach ($keshaftaanModels as $kode => $sikap) {
                // For Tahun Ajaran 1, generate base hafalan scores
                $nilaiHafalan1 = rand(80, 95);
                RaportHafalan::create([
                    'id_tahun_ajaran' => $tahunAjaran1->id,
                    'id_kelas' => $kelasModels1[$studentData['kelas']]->id,
                    'id_siswa' => $siswa->id,
                    'judul' => $sikap->judul,
                    'catatan' => 'Catatan hafalan semester 2 2023/2024',
                    'nilai' => $nilaiHafalan1,
                    'nilai_huruf' => $this->getNilaiHuruf($nilaiHafalan1),
                ]);

                // For Tahun Ajaran 2, show improvement in hafalan scores
                $nilaiHafalan2 = min(100, $nilaiHafalan1 + rand(1, 5));
                RaportHafalan::create([
                    'id_tahun_ajaran' => $tahunAjaran2->id,
                    'id_kelas' => $kelasModels2[$studentData['kelas']]->id,
                    'id_siswa' => $siswa->id,
                    'judul' => $sikap->judul,
                    'catatan' => 'Catatan hafalan semester 1 2024/2025',
                    'nilai' => $nilaiHafalan2,
                    'nilai_huruf' => $this->getNilaiHuruf($nilaiHafalan2),
                ]);
            }
        }
    }

    /**
     * Convert numeric score to letter grade
     */
    private function getNilaiHuruf($nilai)
    {
        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }
}
