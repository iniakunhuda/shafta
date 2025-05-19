<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kelas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'maksimum',
        'wali_kelas_nama',
        'id_tahunajaran',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'maksimum' => 'integer',
    ];

    /**
     * Get the raports for the kelas.
     */
    public function raports()
    {
        return $this->hasMany(Raport::class, 'id_kelas');
    }

    /**
     * Get the hafalan raports for the kelas.
     */
    public function raportHafalans()
    {
        return $this->hasMany(RaportHafalan::class, 'id_kelas');
    }

    public function tahunajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahunajaran');
    }
}
