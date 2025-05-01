<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'siswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'ayah_nama',
        'ayah_alamat',
        'ayah_pekerjaan',
        'ayah_telp',
        'ibu_nama',
        'ibu_alamat',
        'ibu_pekerjaan',
        'status',
        'id_user',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the akun record associated with the siswa.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the raports for the siswa.
     */
    public function raports()
    {
        return $this->hasMany(Raport::class, 'id_siswa');
    }

    /**
     * Get the hafalan raports for the siswa.
     */
    public function raportHafalans()
    {
        return $this->hasMany(RaportHafalan::class, 'id_siswa');
    }
}
