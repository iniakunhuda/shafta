<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'raport';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_tahun_ajaran',
        'id_kelas',
        'id_siswa',
        'sakit',
        'izin',
        'alpa',
        'catatan',
        'prestasi',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sakit' => 'integer',
        'izin' => 'integer',
        'alpa' => 'integer',
    ];

    /**
     * Get the tahun ajaran record associated with the raport.
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }

    /**
     * Get the kelas record associated with the raport.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    /**
     * Get the siswa record associated with the raport.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    /**
     * Get the nilai records for the raport.
     */
    public function nilais()
    {
        return $this->hasMany(RaportNilai::class, 'id_raport');
    }

    /**
     * Get the sikap records for the raport.
     */
    public function sikaps()
    {
        return $this->hasMany(RaportSikap::class, 'id_raport');
    }
}
