<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sikap extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sikap';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'judul',
        'deskripsi',
        'id_parent_sikap',
        'bobot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'bobot' => 'float',
    ];

    /**
     * Get the parent sikap.
     */
    public function parentSikap()
    {
        return $this->belongsTo(Sikap::class, 'id_parent_sikap');
    }

    /**
     * Get the child sikaps.
     */
    public function childSikap()
    {
        return $this->hasMany(Sikap::class, 'id_parent_sikap');
    }

    /**
     * Get the raport sikap records for this sikap.
     */
    public function raportSikap()
    {
        return $this->hasMany(RaportSikap::class, 'id_sikap');
    }
}
