<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tahun_ajaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'semester',
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the raports for the tahun ajaran.
     */
    public function raports()
    {
        return $this->hasMany(Raport::class, 'id_tahun_ajaran');
    }

    /**
     * Get the hafalan raports for the tahun ajaran.
     */
    public function raportHafalans()
    {
        return $this->hasMany(RaportHafalan::class, 'id_tahun_ajaran');
    }
}
