<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserAdminService
{
    /**
     * Get all admin users with pagination.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return User::where('role', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get admin user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function getById(int $id): ?User
    {
        $user = User::find($id);

        if (!$user || $user->role !== 'admin') {
            return null;
        }

        return $user;
    }

    /**
     * Create a new admin user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'admin',
            'status' => $data['status'],
            'status_message' => $data['status_message'] ?? null,
        ]);
    }

    /**
     * Update an existing admin user.
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id, array $data): ?User
    {
        $user = $this->getById($id);

        if (!$user) {
            return null;
        }

        $user->nama = $data['nama'];
        $user->email = $data['email'];
        $user->status = $data['status'];
        $user->status_message = $data['status_message'] ?? null;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return $user;
    }

    /**
     * Delete an admin user.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $user = $this->getById($id);

        if (!$user) {
            return false;
        }

        // Check if this is the last admin
        $adminCount = User::where('role', 'admin')->count();
        if ($adminCount <= 1) {
            return false;
        }

        return $user->delete();
    }

    /**
     * Toggle the status of an admin user between active and block.
     *
     * @param int $id
     * @return User|null
     */
    public function toggleStatus(int $id): ?User
    {
        $user = $this->getById($id);

        if (!$user) {
            return null;
        }

        $user->status = ($user->status === 'active') ? 'block' : 'active';
        $user->save();

        return $user;
    }
}
