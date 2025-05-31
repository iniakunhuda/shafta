<?php

namespace App\Http\Services;

use App\Models\RaportHafalan;

class RapotHafalanService
{
    protected $rapotHafalan;

    public function __construct(RaportHafalan $rapotHafalan)
    {
        $this->rapotHafalan = $rapotHafalan;
    }

    /**
     * Get all raport hafalan
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRapotHafalan()
    {
        return $this->rapotHafalan->all();
    }
}
