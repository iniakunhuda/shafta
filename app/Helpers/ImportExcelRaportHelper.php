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
    static public function import_nilai_umum_sma($sheet, $request)
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

    // [
    //     {
    //         "no": "1",
    //         "nama_siswa": "Andi Tabuti",
    //         "nis": "1122",
    //         "nisn": "1122",
    //         "pengembangan_bidang_studi": {
    //             "BAHASA ARAB": "90",
    //             "NUMERASI": "84",
    //             "LITERASI": "75"
    //         },
    //         "ibadah": {
    //             "SALAT DHUHA": "79",
    //             "SALAT JUM'AT\/KEPUTRIAN": "78",
    //             "SALAT ZUHUR DAN ASAR": "75"
    //         },
    //         "keshaftaan": {
    //             "Hafalan Surat Pendek": "73",
    //             "QS. An-Nas - QS. Al-Humazah": "73",
    //             "QS. Al-'asr - QS. Ad-Duhaa": "71",
    //             "Hafalan Doa Harian dan Bacaan Sholawat": "90",
    //             "Doa bangun tidur": "90",
    //             "Doa akan tidur": "77",
    //             "Doa sebelum makan dan minum": "77",
    //             "Doa setelah makan dan minum": "82",
    //             "Doa memakai pakaian": "76",
    //             "Doa memakai pakaian baru": "85",
    //             "Doa melepas pakaian": "91",
    //             "Doa bercermin": "76",
    //             "Doa masuk kamar mandi": "93",
    //             "Doa keluar kamar mandi": "99",
    //             "Doa masuk rumah": "90",
    //             "Doa keluar rumah": "70",
    //             "Shalawat Nariyah": "97",
    //             "Shalawat Munjiyat": "77",
    //             "Hafalan Doa dan Bacaan Bersuci": "88",
    //             "Niat berwudhu": "88",
    //             "Niat mandi wajib": "70",
    //             "Doa saat basuh telapak tangan": "97",
    //             "Doa saat berkumur": "89",
    //             "Doa saat membersihkan lubang hidung": "79",
    //             "Bacaan Tahlil": "85",
    //             "Bacaan Istighosah": "77",
    //             "Bacaan Setelah Shalat (Dzikir)": "79",
    //             "Hafalan Doa Qunut": "71",
    //             "Hafalan Asmaul Husna": "86",
    //             "Praktik Wudhu dan Shalat": "72"
    //         }
    //     },
    //     {
    //         "no": "2",
    //         "nama_siswa": "Budi Farid Wais",
    //         "nis": "1123",
    //         "nisn": "1123",
    //         "pengembangan_bidang_studi": {
    //             "BAHASA ARAB": "93",
    //             "NUMERASI": "73",
    //             "LITERASI": "74"
    //         },
    //         "ibadah": {
    //             "SALAT DHUHA": "94",
    //             "SALAT JUM'AT\/KEPUTRIAN": "96",
    //             "SALAT ZUHUR DAN ASAR": "81"
    //         },
    //         "keshaftaan": {
    //             "Hafalan Surat Pendek": "78",
    //             "QS. An-Nas - QS. Al-Humazah": "78",
    //             "QS. Al-'asr - QS. Ad-Duhaa": "94",
    //             "Hafalan Doa Harian dan Bacaan Sholawat": "75",
    //             "Doa bangun tidur": "75",
    //             "Doa akan tidur": "88",
    //             "Doa sebelum makan dan minum": "72",
    //             "Doa setelah makan dan minum": "78",
    //             "Doa memakai pakaian": "77",
    //             "Doa memakai pakaian baru": "83",
    //             "Doa melepas pakaian": "88",
    //             "Doa bercermin": "79",
    //             "Doa masuk kamar mandi": "78",
    //             "Doa keluar kamar mandi": "83",
    //             "Doa masuk rumah": "88",
    //             "Doa keluar rumah": "100",
    //             "Shalawat Nariyah": "79",
    //             "Shalawat Munjiyat": "72",
    //             "Hafalan Doa dan Bacaan Bersuci": "95",
    //             "Niat berwudhu": "95",
    //             "Niat mandi wajib": "75",
    //             "Doa saat basuh telapak tangan": "86",
    //             "Doa saat berkumur": "78",
    //             "Doa saat membersihkan lubang hidung": "83",
    //             "Bacaan Tahlil": "76",
    //             "Bacaan Istighosah": "70",
    //             "Bacaan Setelah Shalat (Dzikir)": "88",
    //             "Hafalan Doa Qunut": "86",
    //             "Hafalan Asmaul Husna": "84",
    //             "Praktik Wudhu dan Shalat": "76"
    //         }
    //     }
    // ]
    static public function import_nilai_shafta($sheet, $request)
    {
        // Find the header rows dynamically
        $header_row = null;
        $subheader_row = null;
        $data_start_row = null;

        // Look for the main header row (containing "PENGEMBANGAN BIDANG STUDI", "IBADAH", "KESHAFTAAN")
        for ($row = 0; $row < min(10, count($sheet)); $row++) {
            $row_data = $sheet[$row] ?? [];
            $row_text = implode(' ', array_filter($row_data, function($cell) {
                return !empty(trim($cell));
            }));

            if (stripos($row_text, 'PENGEMBANGAN') !== false &&
                stripos($row_text, 'IBADAH') !== false &&
                stripos($row_text, 'KESHAFTAAN') !== false) {
                $header_row = $row;
                $subheader_row = $row + 1;
                break;
            }
        }

        if ($header_row === null) {
            throw new \Exception('Header row not found in Excel file');
        }

        // Find where student data starts (look for numeric values in first column)
        for ($row = $subheader_row + 1; $row < count($sheet); $row++) {
            $first_cell = isset($sheet[$row][0]) ? trim($sheet[$row][0]) : '';
            if (is_numeric($first_cell) && $first_cell > 0) {
                $data_start_row = $row;
                break;
            }
        }

        Log::info("Found header row at index: $header_row, subheader at: $subheader_row, data starts at: $data_start_row");

        // Parse headers dynamically
        $headers = $sheet[$header_row] ?? [];
        $subheaders = $sheet[$subheader_row] ?? [];

        // Initialize sections
        $sections = [
            'pengembangan_bidang_studi' => [],
            'ibadah' => [],
            'keshaftaan' => []
        ];

        // Find column ranges for each section
        $pengembangan_start = null;
        $ibadah_start = null;
        $keshaftaan_start = null;

        foreach ($headers as $col => $header) {
            $header = trim($header);
            if (stripos($header, 'PENGEMBANGAN') !== false) {
                $pengembangan_start = $col;
            } elseif (stripos($header, 'IBADAH') !== false) {
                $ibadah_start = $col;
            } elseif (stripos($header, 'KESHAFTAAN') !== false) {
                $keshaftaan_start = $col;
            }
        }

        // Parse sections with hierarchical structure
        $sections = self::parseShaftaSections($sheet, $subheader_row, $data_start_row,
                                            $pengembangan_start, $ibadah_start, $keshaftaan_start);

        // Debug: Log the extracted sections
        Log::info('Extracted Shafta Sections:', $sections);

        // Store in persistent session
        session([
            'upload_data.pengembangan_bidang_studi' => $sections['pengembangan_bidang_studi'],
            'upload_data.ibadah' => $sections['ibadah'],
            'upload_data.keshaftaan' => $sections['keshaftaan'],
            'upload_data.tahun_ajaran' => $request->tahun_ajaran,
            'upload_data.kelas' => $request->kelas,
            'upload_data.jenjang' => $request->jenjang,
        ]);

        Log::info('Session data for Shafta:', session('upload_data'));

        // Process student data
        $students_data = [];

        for ($row = $data_start_row; $row < count($sheet); $row++) {
            $row_data = $sheet[$row] ?? [];

            // Skip empty rows
            if (empty(array_filter($row_data, function($cell) { return !empty(trim($cell)); }))) {
                continue;
            }

            // Find student basic info (usually in first few columns)
            $student_name = '';
            $student_nis = '';
            $student_nisn = '';
            $student_no = '';

            // Look for student data in first 5 columns
            for ($col = 0; $col < min(5, count($row_data)); $col++) {
                $cell_value = trim($row_data[$col] ?? '');
                if (empty($cell_value)) continue;

                // First non-empty cell is usually the number
                if (empty($student_no) && is_numeric($cell_value)) {
                    $student_no = $cell_value;
                }
                // Next non-empty cell is usually the name
                elseif (empty($student_name) && !is_numeric($cell_value)) {
                    $student_name = $cell_value;
                }
                // Look for NIS/NISN patterns
                elseif (is_numeric($cell_value) && strlen($cell_value) >= 4) {
                    if (empty($student_nis)) {
                        $student_nis = $cell_value;
                    } elseif (empty($student_nisn)) {
                        $student_nisn = $cell_value;
                    }
                }
            }

            if (empty($student_name)) {
                continue; // Skip if no student name found
            }

            $student_data = [
                'no' => $student_no,
                'nama_siswa' => $student_name,
                'nis' => $student_nis,
                'nisn' => $student_nisn,
            ];

            // Extract scores for each section using the parsed structure
            $student_pengembangan = [];
            foreach ($sections['pengembangan_bidang_studi'] as $subject) {
                $score = isset($row_data[$subject['column']]) ? trim($row_data[$subject['column']]) : '';
                $student_pengembangan[$subject['name']] = $score;
            }

            $student_ibadah = [];
            foreach ($sections['ibadah'] as $subject) {
                $score = isset($row_data[$subject['column']]) ? trim($row_data[$subject['column']]) : '';
                $student_ibadah[$subject['name']] = $score;
            }

            $student_keshaftaan = [];
            foreach ($sections['keshaftaan'] as $subject) {
                $score = isset($row_data[$subject['column']]) ? trim($row_data[$subject['column']]) : '';
                $student_keshaftaan[$subject['name']] = $score;

                // Handle child items if they exist
                if (isset($subject['child'])) {
                    foreach ($subject['child'] as $child) {
                        if (isset($child['column'])) {
                            $child_score = isset($row_data[$child['column']]) ? trim($row_data[$child['column']]) : '';
                            $student_keshaftaan[$child['name']] = $child_score;
                        }
                    }
                }
            }

            $student_data['pengembangan_bidang_studi'] = $student_pengembangan;
            $student_data['ibadah'] = $student_ibadah;
            $student_data['keshaftaan'] = $student_keshaftaan;

            $students_data[] = $student_data;
        }

        Log::info('Processed Shafta Students Data:' . json_encode($students_data, JSON_PRETTY_PRINT));

        return $students_data;
    }

    private static function parseShaftaSections($sheet, $subheader_row, $data_start_row, $pengembangan_start, $ibadah_start, $keshaftaan_start)
    {
        $sections = [
            'pengembangan_bidang_studi' => [],
            'ibadah' => [],
            'keshaftaan' => []
        ];

        $subheaders = $sheet[$subheader_row] ?? [];

        // Parse PENGEMBANGAN BIDANG STUDI section
        if ($pengembangan_start !== null) {
            $end_col = $ibadah_start ?? count($subheaders);
            for ($col = $pengembangan_start; $col < $end_col; $col++) {
                $subheader = isset($subheaders[$col]) ? trim($subheaders[$col]) : '';
                if (!empty($subheader) && !stripos($subheader, 'NILAI')) {
                    $sections['pengembangan_bidang_studi'][] = [
                        'column' => $col,
                        'name' => $subheader
                    ];
                }
            }
        }

        // Parse IBADAH section
        if ($ibadah_start !== null) {
            $end_col = $keshaftaan_start ?? count($subheaders);
            for ($col = $ibadah_start; $col < $end_col; $col++) {
                $subheader = isset($subheaders[$col]) ? trim($subheaders[$col]) : '';
                if (!empty($subheader) && !stripos($subheader, 'NILAI')) {
                    $sections['ibadah'][] = [
                        'column' => $col,
                        'name' => $subheader
                    ];
                }
            }
        }

        // Parse KESHAFTAAN section with hierarchical structure
        if ($keshaftaan_start !== null) {
            $current_parent = null;
            $child_column_counter = $keshaftaan_start;

            // First, identify parent categories from subheaders
            for ($col = $keshaftaan_start; $col < count($subheaders); $col++) {
                $subheader = isset($subheaders[$col]) ? trim($subheaders[$col]) : '';
                if (!empty($subheader) && !stripos($subheader, 'NILAI')) {
                    $sections['keshaftaan'][] = [
                        'column' => $col,
                        'name' => $subheader
                    ];
                }
            }

            // Now parse child items from rows between subheader and data start
            for ($row = $subheader_row + 1; $row < $data_start_row; $row++) {
                $row_data = $sheet[$row] ?? [];

                // Look for child items in the keshaftaan section
                for ($col = $keshaftaan_start; $col < count($row_data); $col++) {
                    $cell_value = isset($row_data[$col]) ? trim($row_data[$col]) : '';

                    if (!empty($cell_value) && !is_numeric($cell_value)) {
                        // Find which parent this child belongs to
                        $parent_index = self::findParentForChild($sections['keshaftaan'], $col);

                        if ($parent_index !== null) {
                            // Initialize child array if not exists
                            if (!isset($sections['keshaftaan'][$parent_index]['child'])) {
                                $sections['keshaftaan'][$parent_index]['child'] = [];
                            }

                            $sections['keshaftaan'][$parent_index]['child'][] = [
                                'name' => $cell_value,
                                'column' => $col
                            ];
                        }
                    }
                }
            }
        }

        return $sections;
    }

    private static function findParentForChild($keshaftaan_items, $child_column)
    {
        $best_match = null;
        $min_distance = PHP_INT_MAX;

        foreach ($keshaftaan_items as $index => $item) {
            $distance = abs($item['column'] - $child_column);
            if ($distance < $min_distance && $item['column'] <= $child_column) {
                $min_distance = $distance;
                $best_match = $index;
            }
        }

        return $best_match;
    }


}
