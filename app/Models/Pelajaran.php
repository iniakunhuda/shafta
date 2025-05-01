<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelajaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'kategori_matkul',
        'id_parent_pelajaran',
    ];

    /**
     * Get the parent pelajaran.
     */
    public function parentPelajaran()
    {
        return $this->belongsTo(Pelajaran::class, 'id_parent_pelajaran');
    }

    /**
     * Get the child pelajaran.
     */
    public function childPelajaran()
    {
        return $this->hasMany(Pelajaran::class, 'id_parent_pelajaran');
    }

    /**
     * Get the raport nilai for the pelajaran.
     */
    public function raportNilai()
    {
        return $this->hasMany(RaportNilai::class, 'id_pelajaran');
    }
}
