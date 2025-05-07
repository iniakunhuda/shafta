<?php
namespace App\Http\Services;

use App\Models\Pengaturan;
class PengaturanWebsiteService
{
    /**
     * Get all pengaturan website
     *
     * @return array
     */
    public function getPengaturanWebsite()
    {
        $pengaturan = Pengaturan::all();
        $result = [];
        foreach ($pengaturan as $key => $value) {
            $result[$value->key] = $value->value;
        }
        return $result;
    }

    /**
     * Update pengaturan website
     *
     * @param array $request
     * @return void
     */
    public function updatePengaturanWebsite($request)
    {
        foreach ($request as $key => $value) {
            $pengaturan = Pengaturan::where('key', $key)->first();
            $pengaturan->value = $value;
            $pengaturan->save();
        }
    }


}