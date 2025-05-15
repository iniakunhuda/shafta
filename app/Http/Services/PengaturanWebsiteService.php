<?php
namespace App\Http\Services;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
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
    public function updatePengaturanWebsite(Request $request)
    {
        $data = $request->except('_token', '_method');
        foreach ($data as $key => $value) {
            $pengaturan = Pengaturan::where('key', $key)->first();
            if ($pengaturan) {
                $pengaturan->value = $value;
                $pengaturan->save();
            }
        }
        return true;
    }


}