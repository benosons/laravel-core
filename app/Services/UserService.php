<?php

namespace App\Services;

use App\Core\Base\BaseService;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UserService extends BaseService
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllUsers(): Collection
    {
        return $this->repository->all();
    }

    public function createUser(array $data): Model
    {
        // Remove roles from data to avoid mass assignment errors
        $rolesData = $data['roles'] ?? null;
        unset($data['roles']);
        $user = $this->repository->create($data);

        if ($rolesData) {
            $roles = Role::whereIn('slug', $rolesData)->get();
            $user->roles()->sync($roles);
        }

        return $user;
    }

    public function getUserById(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    public function updateUser(int $id, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Remove roles from data to avoid mass assignment errors
        $rolesData = $data['roles'] ?? null;
        unset($data['roles']);
        $updated = $this->repository->update($id, $data);

        if ($updated && $rolesData) {
            $user = $this->repository->find($id);
            $roles = Role::whereIn('slug', $rolesData)->get();
            $user->roles()->sync($roles);
        }

        return $updated;
    }

    public function deleteUser(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
