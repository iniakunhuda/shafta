<?php

namespace App\Http\Services;

use App\Models\RaportSikap;
use App\Models\Sikap;

class RaportSikapService
{
    protected $raportSikap;

    public function __construct(RaportSikap $raportSikap)
    {
        $this->raportSikap = $raportSikap;
    }

    public function getRaportSikapByRaportId($raportId)
    {
        $raportSikap = $this->raportSikap->with('sikap')->where('id_raport', $raportId)->get();
        $raportSikapGroupped = [];
        foreach ($raportSikap as $item) {
            $parentSikap = Sikap::find($item->sikap->id_parent_sikap);
            $raportSikapGroupped[$parentSikap->judul][] = $item;
        }
        return $raportSikapGroupped;
    }

    public function getRaportSikapBySiswaId($siswaId)
    {
        return $this->raportSikap->where('id_siswa', $siswaId)->get();
    }

    public function getRaportSikapByTahunAjaranId($tahunAjaranId)
    {
        return $this->raportSikap->where('id_tahun_ajaran', $tahunAjaranId)->get();
    }

    public function getRaportSikapBySiswaIdAndTahunAjaranId($siswaId, $tahunAjaranId)
    {
        return $this->raportSikap->where('id_siswa', $siswaId)->where('id_tahun_ajaran', $tahunAjaranId)->get();
    }

    public function createRaportSikap($data)
    {
        return $this->raportSikap->create($data);
    }

    public function updateRaportSikap($id, $data)
    {
        return $this->raportSikap->where('id', $id)->update($data);
    }

    public function deleteRaportSikap($id)
    {
        return $this->raportSikap->where('id', $id)->delete();
    }
}