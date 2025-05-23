<?php

namespace App\Http\Services;

use App\Models\RaportNilai;

class RaportNilaiService
{
    protected $raportNilai;

    public function __construct(RaportNilai $raportNilai)
    {
        $this->raportNilai = $raportNilai;
    }

    public function getRaportNilai()
    {
        return $this->raportNilai->all();
    }

    public function getRaportNilaiById($id)
    {
        return $this->raportNilai->find($id);
    }

    public function createRaportNilai($data)
    {
        return $this->raportNilai->create($data);
    }
    
    public function updateRaportNilai($id, $data)
    {
        return $this->raportNilai->find($id)->update($data);
    }
    
    public function deleteRaportNilai($id)
    {
        return $this->raportNilai->find($id)->delete();
    }
    
    public function getRaportNilaiBySiswaId($siswaId)
    {
        return $this->raportNilai->where('id_siswa', $siswaId)->get();
    }
    
    public function getRaportNilaiByTahunAjaranId($tahunAjaranId)
    {
        return $this->raportNilai->where('id_tahun_ajaran', $tahunAjaranId)->get();
    }
    
    public function getRaportNilaiByRaportId($raportId, $kategori)
    {
        return $this->raportNilai
            ->with('pelajaran')
            ->whereHas('pelajaran', function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->where('id_raport', $raportId)
            ->get();
    }
    
    public function averageRaportNilaiByRaportId($raportId, $kategori)
    {
        return number_format($this->raportNilai
            ->whereHas('pelajaran', function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->where('id_raport', $raportId)
            ->avg('nilai'), 2);
    }

    public function getRankingRaportNilaiByRaportId($raportId, $kategori, $kelasId)
    {
        // Get the average score for the specific student
        $nilaiSiswa = $this->raportNilai
            ->whereHas('pelajaran', function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->whereHas('raport', function ($query) use ($kelasId) {
                $query->where('id_kelas', $kelasId);
            })
            ->where('id_raport', $raportId)
            ->avg('nilai');

        // Get all students' average scores in the same class
        $semuaNilaiSiswa = $this->raportNilai
            ->whereHas('pelajaran', function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->whereHas('raport', function ($query) use ($kelasId) {
                $query->where('id_kelas', $kelasId);
            })
            ->select('id_raport')
            ->selectRaw('AVG(nilai) as rata_rata')
            ->groupBy('id_raport')
            ->orderByDesc('rata_rata')
            ->get();

        // Find the student's rank
        $ranking = 1;
        foreach ($semuaNilaiSiswa as $nilai) {
            if ($nilai->rata_rata > $nilaiSiswa) {
                $ranking++;
            }
        }

        return $ranking;
    }
}

