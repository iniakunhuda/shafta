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
    
    }

