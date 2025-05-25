<?php

namespace App\Http\Services;

use App\Models\Raport;
use App\Models\RaportNilai;
use App\Models\RaportSikap;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ExportService
{
    /**
     * Export raport data to CSV format
     *
     * @param int $raportId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportRaportToCsv(int $raportId)
    {
        try {
            $raport = Raport::with(['siswa', 'tahunAjaran', 'kelas'])->findOrFail($raportId);
            $nilaiUmum = RaportNilai::with('pelajaran')
                ->where('id_raport', $raportId)
                ->whereHas('pelajaran', function ($query) {
                    $query->where('kategori', 'umum');
                })
                ->get();
            $nilaiShafta = RaportNilai::with('pelajaran')
                ->where('id_raport', $raportId)
                ->whereHas('pelajaran', function ($query) {
                    $query->where('kategori', 'shafta');
                })
                ->get();
            $nilaiSikap = RaportSikap::with('sikap')
                ->where('id_raport', $raportId)
                ->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="raport_' . $raport->siswa->nis . '_' . $raport->tahunAjaran->nama . '.csv"',
            ];

            $callback = function() use ($raport, $nilaiUmum, $nilaiShafta, $nilaiSikap) {
                $file = fopen('php://output', 'w');
                
                // Add student information
                fputcsv($file, ['INFORMASI SISWA']);
                fputcsv($file, ['NIS', $raport->siswa->nis]);
                fputcsv($file, ['NISN', $raport->siswa->nisn]);
                fputcsv($file, ['Nama', $raport->siswa->nama]);
                fputcsv($file, ['Kelas', $raport->kelas->nama]);
                fputcsv($file, ['Tahun Ajaran', $raport->tahunAjaran->nama]);
                fputcsv($file, []);

                // Add academic scores
                fputcsv($file, ['NILAI UMUM']);
                fputcsv($file, ['No', 'Mata Pelajaran', 'KKM', 'Nilai', 'Predikat']);
                
                foreach ($nilaiUmum as $index => $nilai) {
                    fputcsv($file, [
                        $index + 1,
                        $nilai->pelajaran->judul,
                        $nilai->pelajaran->kkm ?? '-',
                        $nilai->nilai,
                        $nilai->nilai_huruf
                    ]);
                }
                fputcsv($file, []);

                // Add Keshaftaan scores
                fputcsv($file, ['NILAI KESHAFTAAN']);
                fputcsv($file, ['No', 'Mata Pelajaran', 'Nilai', 'Keterangan']);
                
                foreach ($nilaiShafta as $index => $nilai) {
                    fputcsv($file, [
                        $index + 1,
                        $nilai->pelajaran->judul,
                        $nilai->nilai,
                        $nilai->keterangan
                    ]);
                }
                fputcsv($file, []);

                // Add Sikap scores
                fputcsv($file, ['NILAI SIKAP']);
                fputcsv($file, ['No', 'Aspek', 'Nilai', 'Keterangan']);
                
                foreach ($nilaiSikap as $index => $nilai) {
                    fputcsv($file, [
                        $index + 1,
                        $nilai->sikap->judul,
                        $nilai->nilai,
                        $nilai->keterangan
                    ]);
                }

                fclose($file);
            };

            return Response::stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to export data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Export raport data to Excel format
     *
     * @param int $raportId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportRaportToExcel(int $raportId)
    {
        try {
            $raport = Raport::with(['siswa', 'tahunAjaran', 'kelas'])->findOrFail($raportId);
            $nilaiUmum = RaportNilai::with('pelajaran')
                ->where('id_raport', $raportId)
                ->whereHas('pelajaran', function ($query) {
                    $query->where('kategori', 'umum');
                })
                ->get();
            $nilaiShafta = RaportNilai::with('pelajaran')
                ->where('id_raport', $raportId)
                ->whereHas('pelajaran', function ($query) {
                    $query->where('kategori', 'shafta');
                })
                ->get();
            $nilaiSikap = RaportSikap::with('sikap')
                ->where('id_raport', $raportId)
                ->get();

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set student information
            $sheet->setCellValue('A1', 'INFORMASI SISWA');
            $sheet->mergeCells('A1:B1');
            $sheet->setCellValue('A2', 'NIS');
            $sheet->setCellValue('B2', $raport->siswa->nis);
            $sheet->setCellValue('A3', 'NISN');
            $sheet->setCellValue('B3', $raport->siswa->nisn);
            $sheet->setCellValue('A4', 'Nama');
            $sheet->setCellValue('B4', $raport->siswa->nama);
            $sheet->setCellValue('A5', 'Kelas');
            $sheet->setCellValue('B5', $raport->kelas->nama);
            $sheet->setCellValue('A6', 'Tahun Ajaran');
            $sheet->setCellValue('B6', $raport->tahunAjaran->nama);

            // Style student information
            $sheet->getStyle('A1:B1')->applyFromArray([
                'font' => ['bold' => true, 'size' => 14],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E2E8F0']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);

            // Set academic scores
            $row = 8;
            $sheet->setCellValue('A' . $row, 'NILAI UMUM');
            $sheet->mergeCells('A' . $row . ':E' . $row);
            $row++;
            
            $sheet->setCellValue('A' . $row, 'No');
            $sheet->setCellValue('B' . $row, 'Mata Pelajaran');
            $sheet->setCellValue('C' . $row, 'KKM');
            $sheet->setCellValue('D' . $row, 'Nilai');
            $sheet->setCellValue('E' . $row, 'Predikat');
            
            // Style header
            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'F8FAFC']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            $row++;
            foreach ($nilaiUmum as $index => $nilai) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $nilai->pelajaran->judul);
                $sheet->setCellValue('C' . $row, $nilai->pelajaran->kkm ?? '-');
                $sheet->setCellValue('D' . $row, $nilai->nilai);
                $sheet->setCellValue('E' . $row, $nilai->nilai_huruf);
                $row++;
            }

            // Set Keshaftaan scores
            $row += 2;
            $sheet->setCellValue('A' . $row, 'NILAI KESHAFTAAN');
            $sheet->mergeCells('A' . $row . ':D' . $row);
            $row++;
            
            $sheet->setCellValue('A' . $row, 'No');
            $sheet->setCellValue('B' . $row, 'Mata Pelajaran');
            $sheet->setCellValue('C' . $row, 'Nilai');
            $sheet->setCellValue('D' . $row, 'Keterangan');
            
            // Style header
            $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'F8FAFC']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            $row++;
            foreach ($nilaiShafta as $index => $nilai) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $nilai->pelajaran->judul);
                $sheet->setCellValue('C' . $row, $nilai->nilai);
                $sheet->setCellValue('D' . $row, $nilai->keterangan);
                $row++;
            }

            // Set Sikap scores
            $row += 2;
            $sheet->setCellValue('A' . $row, 'NILAI SIKAP');
            $sheet->mergeCells('A' . $row . ':D' . $row);
            $row++;
            
            $sheet->setCellValue('A' . $row, 'No');
            $sheet->setCellValue('B' . $row, 'Aspek');
            $sheet->setCellValue('C' . $row, 'Nilai');
            $sheet->setCellValue('D' . $row, 'Keterangan');
            
            // Style header
            $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'F8FAFC']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
            ]);

            $row++;
            foreach ($nilaiSikap as $index => $nilai) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $nilai->sikap->judul);
                $sheet->setCellValue('C' . $row, $nilai->nilai);
                $sheet->setCellValue('D' . $row, $nilai->keterangan);
                $row++;
            }

            // Style all sections
            $sheet->getStyle('A8:A' . ($row - 1))->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);

            // Auto-size columns
            foreach (range('A', 'E') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Create Excel file
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $filename = 'raport_' . $raport->siswa->nis . '_' . $raport->tahunAjaran->nama . '.xlsx';
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to export data: ' . $e->getMessage()], 500);
        }
    }
} 