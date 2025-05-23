<?php

namespace App\Http\Services;

use App\Models\Raport;

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
        return $this->raport->where('id_siswa', $siswaId)->where('id_tahun_ajaran', $tahunAjaranId)->first();
    }

    public function getJumlahSiswaByTahunAjaranId($tahunAjaranId, $kelasId)
    {
        return $this->raport->where('id_tahun_ajaran', $tahunAjaranId)->where('id_kelas', $kelasId)->count();
    }

}
