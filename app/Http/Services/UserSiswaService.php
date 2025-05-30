<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSiswaService
{
    /**
     * Get all siswa
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return User::where('role', 'siswa')->get();
    }

    /**
     * Get siswa by id
     *
     * @param int $id
     * @return \App\Models\User
     */
    public function getById(int $id)
    {
        return User::findOrFail($id);
    }
    
    /**
     * Create siswa
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function create(array $data)
    {
        return User::create($data);
    }   

    /**
     * Update siswa
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\User
     */
    public function update(int $id, array $data)
    {
        $siswa = $this->getById($id);
        $siswa->nama = $data['nama'];
        $siswa->email = $data['email'];
        $siswa->status = $data['status'];
        $siswa->status_message = $data['status_message'] ?? null;

        if (!empty($data['password'])) {
            $siswa->password = Hash::make($data['password']);
        }

        $siswa->save();

        return $siswa;
    }

    /**
     * Delete siswa
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $siswa = $this->getById($id);
        return $siswa->delete();
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(string $id)
    {
        $siswa = $this->getById($id);
        $siswa->status = $siswa->status === 'active' ? 'block' : 'active';
        $siswa->save();
        return $siswa;
    }
}   