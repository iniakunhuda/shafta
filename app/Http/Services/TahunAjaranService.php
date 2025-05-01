<?php

namespace App\Http\Services;

use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TahunAjaranService
{
    /**
     * Get all tahun ajaran with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return TahunAjaran::latest()->paginate($perPage);
    }

    /**
     * Get all tahun ajaran
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return TahunAjaran::latest()->get();
    }

    /**
     * Get active tahun ajaran
     *
     * @return TahunAjaran|null
     */
    public function getActive(): ?TahunAjaran
    {
        return TahunAjaran::where('is_active', true)->first();
    }

    /**
     * Get tahun ajaran by ID
     *
     * @param int $id
     * @return TahunAjaran|null
     */
    public function getById(int $id): ?TahunAjaran
    {
        return TahunAjaran::find($id);
    }

    /**
     * Create a new tahun ajaran
     *
     * @param array $data
     * @return TahunAjaran
     */
    public function create(array $data): TahunAjaran
    {
        // If this tahun ajaran is set as active, make sure others are not active
        if (isset($data['is_active']) && $data['is_active']) {
            $this->deactivateAll();
        }

        return TahunAjaran::create($data);
    }

    /**
     * Update a tahun ajaran
     *
     * @param int $id
     * @param array $data
     * @return TahunAjaran|null
     */
    public function update(int $id, array $data): ?TahunAjaran
    {
        $tahunAjaran = $this->getById($id);

        if (!$tahunAjaran) {
            return null;
        }

        // If this tahun ajaran is set as active, make sure others are not active
        if (isset($data['is_active']) && $data['is_active']) {
            $this->deactivateAll();
        }

        $tahunAjaran->update($data);

        return $tahunAjaran->fresh();
    }

    /**
     * Delete a tahun ajaran
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $tahunAjaran = $this->getById($id);

        if (!$tahunAjaran) {
            return false;
        }

        return $tahunAjaran->delete();
    }

    /**
     * Deactivate all tahun ajaran
     *
     * @return void
     */
    private function deactivateAll(): void
    {
        TahunAjaran::where('is_active', true)
            ->update(['is_active' => false]);
    }

    /**
     * Toggle the active status of a tahun ajaran
     *
     * @param int $id
     * @return TahunAjaran|null
     */
    public function toggleActive(int $id): ?TahunAjaran
    {
        $tahunAjaran = $this->getById($id);

        if (!$tahunAjaran) {
            return null;
        }

        // If activating, deactivate all others first
        if (!$tahunAjaran->is_active) {
            $this->deactivateAll();
            $tahunAjaran->is_active = true;
        } else {
            $tahunAjaran->is_active = false;
        }

        $tahunAjaran->save();

        return $tahunAjaran->fresh();
    }
}
