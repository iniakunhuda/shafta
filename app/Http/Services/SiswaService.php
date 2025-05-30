<?php

namespace App\Http\Services;

use App\Models\Siswa;

class SiswaService
{
    public function getSiswa()
    {
        return Siswa::all();
    }

    public function getSiswaById($id)
    {
        return Siswa::find($id);
    }

    public function createSiswa($data)
    {
        $siswa = new Siswa();
        $siswa->nama = $data['nama'];
        $siswa->nis = $data['nis'];
        $siswa->nisn = $data['nisn'];
        $siswa->jenis_kelamin = $data['jenis_kelamin'];
        $siswa->tempat_lahir = $data['tempat_lahir'];
        $siswa->tanggal_lahir = $data['tanggal_lahir'];
        $siswa->alamat = $data['alamat'];
        $siswa->ayah_nama = $data['ayah_nama'];
        $siswa->ayah_pekerjaan = $data['ayah_pekerjaan'];
        $siswa->ayah_telp = $data['ayah_telp'];
        $siswa->ayah_alamat = $data['ayah_alamat'];
        $siswa->ibu_nama = $data['ibu_nama'];
        $siswa->ibu_pekerjaan = $data['ibu_pekerjaan'];
        $siswa->ibu_alamat = $data['ibu_alamat'];
        $siswa->status = 'pending';
        $siswa->save();
        return $siswa;
    }

    public function updateSiswa($id, $data)
    {
        $siswa = Siswa::find($id);
        $siswa->update($data);
        $siswa->save();
        return $siswa;
    }

    public function deleteSiswa($id)
    {
        return Siswa::find($id)->delete();
    }

    public function getSiswaByNISN($nisn)
    {
        return Siswa::where('nisn', $nisn)->first();
    }

    public function getSiswaByNIS($nis)
    {
        return Siswa::where('nis', $nis)->first();
    }

    public function toggleActive($id)
    {
        $siswa = Siswa::find($id);
        $status = match($siswa->status) {
            'active' => 'block',
            'block' => 'active',
            'pending' => 'active',
            default => 'pending'
        };
        $siswa->status = $status;
        $siswa->save();
        return $siswa;
    }
    
}