<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaportSikap extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'raport_sikap';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_raport',
        'id_sikap',
        'sikap_judul',
        'sikap_deskripsi',
        'bobot',
        'jumlah',
        'nilai',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'bobot' => 'float',
        'jumlah' => 'integer',
        'nilai' => 'float',
    ];

    /**
     * Get the raport record associated with the sikap.
     */
    public function raport()
    {
        return $this->belongsTo(Raport::class, 'id_raport');
    }

    /**
     * Get the sikap record associated with the raport sikap.
     */
    public function sikap()
    {
        return $this->belongsTo(Sikap::class, 'id_sikap');
    }
}
