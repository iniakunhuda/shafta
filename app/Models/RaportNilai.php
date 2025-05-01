<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaportNilai extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'raport_nilai';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_raport',
        'id_pelajaran',
        'nilai',
        'nilai_huruf',
        'catatan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nilai' => 'float',
    ];

    /**
     * Get the raport record associated with the nilai.
     */
    public function raport()
    {
        return $this->belongsTo(Raport::class, 'id_raport');
    }

    /**
     * Get the pelajaran record associated with the nilai.
     */
    public function pelajaran()
    {
        return $this->belongsTo(Pelajaran::class, 'id_pelajaran');
    }
}
