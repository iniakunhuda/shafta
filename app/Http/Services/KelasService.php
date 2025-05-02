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
}