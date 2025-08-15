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

class MasterDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin Account
        $adminUser = User::create([
            'id' => 1,
            'nama' => 'Administrator',
            'email' => 'admin@shafta.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'status' => 'active',
        ]);

        // Create Tahun Ajaran
        $tahunAjaran1 = TahunAjaran::create([
            'nama' => '2023/2024',
            'semester' => 'Semester 2',
            'start_date' => '2024-01-15',
            'end_date' => '2024-06-20',
            'is_active' => false,
        ]);

        $tahunAjaran2 = TahunAjaran::create([
            'nama' => '2024/2025',
            'semester' => 'Semester 1',
            'start_date' => '2024-07-15',
            'end_date' => '2024-12-20',
            'is_active' => true,
        ]);

        // Create Kelas for both tahun ajaran
        $kelas = [
            'X 1', 'X 2', 'X 3', 'X 4',
            'XI 1', 'XI 2', 'XI 3', 'XI 4',
            'XII 1', 'XII 2', 'XII 3', 'XII 4',
        ];

        $kelasModels1 = [];
        foreach ($kelas as $k) {
            $kelasModels1[$k] = Kelas::create([
                'nama' => $k,
                'maksimum' => 30,
                'wali_kelas_nama' => 'Wali Kelas ' . $k,
                'id_tahunajaran' => $tahunAjaran1->id,
                'jenjang' => 'SMA',
            ]);
        }

        // Create Pelajaran
        $pelajaran = [
            'PAI' => ['judul' => 'PAI', 'deskripsi' => 'Pendidikan Agama Islam', 'kategori' => 'umum', 'kategori_matkul' => null],
            'PKN' => ['judul' => 'PKN', 'deskripsi' => 'Pendidikan Kewarganegaraan', 'kategori' => 'umum', 'kategori_matkul' => null],
            'B_INDO' => ['judul' => 'B. Indonesia', 'deskripsi' => 'Bahasa Indonesia', 'kategori' => 'umum', 'kategori_matkul' => null],
            'MAT' => ['judul' => 'Matematika', 'deskripsi' => 'Matematika', 'kategori' => 'umum', 'kategori_matkul' => null],
            'B_INGG' => ['judul' => 'B. Inggris', 'deskripsi' => 'Bahasa Inggris', 'kategori' => 'umum', 'kategori_matkul' => null],
            'PJOK' => ['judul' => 'PJOK', 'deskripsi' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'kategori' => 'umum', 'kategori_matkul' => null],
            'SEJARAH' => ['judul' => 'Sejarah', 'deskripsi' => 'Sejarah', 'kategori' => 'umum', 'kategori_matkul' => 'ips'],
            'SENI' => ['judul' => 'Seni Budaya', 'deskripsi' => 'Seni Budaya', 'kategori' => 'umum', 'kategori_matkul' => null],
            'SOSIO' => ['judul' => 'Sosiologi', 'deskripsi' => 'Sosiologi', 'kategori' => 'umum', 'kategori_matkul' => 'ips'],
            'GEO' => ['judul' => 'Geografi', 'deskripsi' => 'Geografi', 'kategori' => 'umum', 'kategori_matkul' => 'ips'],
            'BIO' => ['judul' => 'Biologi', 'deskripsi' => 'Biologi', 'kategori' => 'umum', 'kategori_matkul' => 'ipa'],
            'EKONOMI' => ['judul' => 'Ekonomi', 'deskripsi' => 'Ekonomi', 'kategori' => 'umum', 'kategori_matkul' => 'ips'],
            'PKWU' => ['judul' => 'PKWU', 'deskripsi' => 'Prakarya dan Kewirausahaan', 'kategori' => 'umum', 'kategori_matkul' => null],
            'B_JAWA' => ['judul' => 'B. Jawa', 'deskripsi' => 'Bahasa Jawa', 'kategori' => 'umum', 'kategori_matkul' => null],
            'P5' => ['judul' => 'P5', 'deskripsi' => 'Projek Penguatan Profil Pelajar Pancasila', 'kategori' => 'umum', 'kategori_matkul' => null],

            // Ekstrakurikuler
            'PRAMUKA' => ['judul' => 'Pramuka', 'deskripsi' => 'Pramuka', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'PANAHAN' => ['judul' => 'Panahan', 'deskripsi' => 'Panahan', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'ENGLISH_CLUB' => ['judul' => 'English Club', 'deskripsi' => 'English Club', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'BACA_KITAB' => ['judul' => 'Baca Kitab', 'deskripsi' => 'Baca Kitab', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'KIR' => ['judul' => 'KIR', 'deskripsi' => 'Kelompok Ilmiah Remaja', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'FUTSAL' => ['judul' => 'Futsal', 'deskripsi' => 'Futsal', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'PASKIB' => ['judul' => 'Paskib', 'deskripsi' => 'Pasukan Pengibar Bendera', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'BADMINTON' => ['judul' => 'Badminton', 'deskripsi' => 'Badminton', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'PMR' => ['judul' => 'PMR', 'deskripsi' => 'Palang Merah Remaja', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'BANJARI' => ['judul' => 'Banjari', 'deskripsi' => 'Banjari', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],
            'BASKET' => ['judul' => 'Basket', 'deskripsi' => 'Basket', 'kategori' => 'umum', 'kategori_matkul' => 'eskul'],

            // Penunjang
            'SPIRITUAL' => ['judul' => 'Spiritual', 'deskripsi' => 'Spiritual', 'kategori' => 'shafta', 'kategori_matkul' => null],
            'KEPRIBADIAN' => ['judul' => 'Kepribadian', 'deskripsi' => 'Kepribadian', 'kategori' => 'shafta', 'kategori_matkul' => null],
            'KEDISIPLINAN' => ['judul' => 'Kedisiplinan', 'deskripsi' => 'Kedisiplinan', 'kategori' => 'shafta', 'kategori_matkul' => null],
        ];

        $pelajaranModels = [];
        foreach ($pelajaran as $key => $p) {
            $pelajaranModels[$key] = Pelajaran::create([
                'judul' => $p['judul'],
                'deskripsi' => $p['deskripsi'],
                'kategori' => $p['kategori'],
                'kategori_matkul' => $p['kategori_matkul'],
            ]);
        }

        // Create Kalender for both academic years
        Kalender::create([
            'title' => 'Ujian Akhir Semester 2 2023/2024',
            'description' => 'Ujian Akhir Semester untuk 2023/2024',
            'start' => '2024-06-01',
            'end' => '2024-06-15',
            'className' => 'danger',
            'type' => 'ujian',
            'user_id' => 1,
        ]);

        Kalender::create([
            'title' => 'Ujian Akhir Semester 1 2024/2025',
            'description' => 'Ujian Akhir Semester untuk 2024/2025',
            'start' => '2024-12-01',
            'end' => '2024-12-15',
            'className' => 'danger',
            'type' => 'ujian',
            'user_id' => 1,
        ]);
    }

}
