<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class ImportExcelRaportHelper
{

    // [
    //     {
    //         "no": 1,
    //         "nama_siswa": "Andi Tabuti",
    //         "nisn": 1122,
    //         "nis": 1122,
    //         "mata_pelajaran": {
    //         "Pendidikan Agama dan Budi Pekerti": 83,
    //         "Pendidikan Pancasila": 95,
    //         "Bahasa Indonesia": 83,
    //         "Matematika": 70,
    //         "Bahasa Inggris": 76,
    //         "Penjasorkes": 94,
    //         "Sejarah": 87,
    //         "Seni dan Budaya": 80,
    //         "IPA": 93,
    //         "IPS": 98,
    //         "Informatika": 88,
    //         "Fisika": 81,
    //         "Kimia": 82,
    //         "Sosiologi": 73,
    //         "Geografi": 71,
    //         "Biologi": 74,
    //         "Ekonomi": 99,
    //         "PKWU": 83,
    //         "Bahasa Daerah": 88
    //         },
    //         "ketidakhadiran": {
    //         "sakit": 0,
    //         "izin": 0,
    //         "alpha": 0
    //         },
    //         "eskul": {
    //         "PRAMUKA": 100,
    //         "PANAHAN": "",
    //         "ENGLISH CLUB": 100,
    //         "BACA KITAB": "",
    //         "KIR": "",
    //         "FUTSAL": "",
    //         "PASKIB": "",
    //         "BADMINTON": "",
    //         "PMR": "",
    //         "BANJARI": "",
    //         "BASKET": ""
    //         }
    //     }
    // ]
    public function import_nilai_umum($sheet, $request)
    {
        // 1. Read mata pelajaran from E4:W4 and E5:W5
        $mata_pelajaran = [];

        // Get subjects from row 4 (index 3) and values from row 5 (index 4)
        // Columns E to W (indices 4 to 22)
        for ($col = 4; $col <= 22; $col++) {
            $subject = isset($sheet[3][$col]) ? trim($sheet[3][$col]) : '';
            if (!empty($subject)) {
                $mata_pelajaran[] = $subject;
            }
        }

        // 2. Read ketidakhadiran from X5, Y5, Z5
        $ketidakhadiran = [
            isset($sheet[4][23]) ? $sheet[4][23] : 'Sakit',  // X5 (index 23)
            isset($sheet[4][24]) ? $sheet[4][24] : 'Izin',   // Y5 (index 24)
            isset($sheet[4][25]) ? $sheet[4][25] : 'Alpha',  // Z5 (index 25)
        ];

        // 3. Read eskul from AA5:AK5
        $eskul = [];

        // Get eskul headers from row 4 (index 3) and values from row 5 (index 4)
        // Columns AA to AK (indices 26 to 36)
        for ($col = 26; $col <= 36; $col++) {
            $eskul_name = isset($sheet[4][$col]) ? trim($sheet[4][$col]) : '';
            if (!empty($eskul_name)) {
                $eskul[] = $eskul_name;
            }
        }

        // Debug: Log the extracted data
        Log::info('Extracted Mata Pelajaran:', $mata_pelajaran);
        Log::info('Extracted Ketidakhadiran:', $ketidakhadiran);
        Log::info('Extracted Eskul:', $eskul);

        // Store in persistent session (not flash session)
        session([
            'upload_data.mata_pelajaran' => $mata_pelajaran,
            'upload_data.ketidakhadiran' => $ketidakhadiran,
            'upload_data.eskul' => $eskul,
            'upload_data.tahun_ajaran' => $request->tahun_ajaran,
            'upload_data.kelas' => $request->kelas,
            'upload_data.jenjang' => $request->jenjang,
        ]);

        // Process multiple students if needed
        $students_data = [];
        $start_row = 5; // Start from row 6 (index 5) for student data

        for ($row = $start_row; $row < count($sheet); $row++) {
            // Check if there's student data in this row
            $student_name = isset($sheet[$row][1]) ? trim($sheet[$row][1]) : ''; // Column B

            if (empty($student_name)) {
                continue; // Skip empty rows
            }

            $student_data = [
                'no' => isset($sheet[$row][0]) ? $sheet[$row][0] : '',
                'nama_siswa' => $student_name,
                'nisn' => isset($sheet[$row][2]) ? $sheet[$row][2] : '',
                'nis' => isset($sheet[$row][3]) ? $sheet[$row][3] : '',
            ];

            // Get mata pelajaran scores for this student
            $student_mata_pelajaran = [];
            for ($col = 4; $col <= 22; $col++) {
                $subject = isset($sheet[3][$col]) ? trim($sheet[3][$col]) : '';
                $score = isset($sheet[$row][$col]) ? $sheet[$row][$col] : '';

                if (!empty($subject)) {
                    $student_mata_pelajaran[$subject] = $score;
                }
            }

            // Get ketidakhadiran for this student
            $student_ketidakhadiran = [
                'sakit' => isset($sheet[$row][23]) ? $sheet[$row][23] : 0,
                'izin' => isset($sheet[$row][24]) ? $sheet[$row][24] : 0,
                'alpha' => isset($sheet[$row][25]) ? $sheet[$row][25] : 0,
            ];

            // Get eskul for this student
            $student_eskul = [];
            for ($col = 26; $col <= 36; $col++) {
                $eskul_name = isset($sheet[4][$col]) ? trim($sheet[4][$col]) : '';
                $eskul_score = isset($sheet[$row][$col]) ? $sheet[$row][$col] : '';

                if (!empty($eskul_name)) {
                    $student_eskul[$eskul_name] = $eskul_score;
                }
            }

            $student_data['mata_pelajaran'] = $student_mata_pelajaran;
            $student_data['ketidakhadiran'] = $student_ketidakhadiran;
            $student_data['eskul'] = $student_eskul;

            $students_data[] = $student_data;
        }

        return $students_data;
    }
}
