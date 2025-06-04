<?php

namespace App\Http\Services;

use App\Models\Kelas;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class KelasService
{
    /**
     * Get all kelas with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Kelas::latest()->paginate($perPage);
    }

    /**
     * Get all kelas
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Kelas::latest()->get();
    }

    /**
     * Get kelas by id
     *
     * @param int $id
     * @return Kelas
     */
    public function getById(int $id): Kelas
    {
        return Kelas::findOrFail($id);
    }

    /**
     * Create kelas
     *
     * @param array $data
     * @return Kelas
     */
    public function create(array $data): Kelas
    {
        return Kelas::create($data);
    }

    /**
     * Update kelas
     *
     * @param int $id
     * @param array $data
     * @return Kelas
     */
    public function update(int $id, array $data): Kelas
    {
        $kelas = $this->getById($id);
        $kelas->update($data);
        return $kelas;
    }

    /**
     * Delete kelas
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $kelas = $this->getById($id);
        return $kelas->delete();
    }


    /**
     * Get all kelas by tahun ajaran id
     *
     * @param int $tahunAjaranId
     * @return Collection
     */
    public function getAllByTahunAjaranId(int $tahunAjaranId): Collection
    {
        return Kelas::where('id_tahunajaran', $tahunAjaranId)->get();
    }


    /**
     * Get all kelas with filter
     *
     * @param array $filters
     * @return Collection
     */
    public function getAllWithFilter(array $filters = []): Collection
    {
        $query = Kelas::query();

        if (isset($filters['id_tahunajaran'])) {
            $query->where('id_tahunajaran', $filters['id_tahunajaran']);
        }

        if (isset($filters['jenjang'])) {
            $query->where('jenjang', $filters['jenjang']);
        }

        return $query->get();
    }
}
