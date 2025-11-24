<?php

namespace App\Http\Controllers\Api;

use App\Core\Base\BaseController;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $users = $this->service->getAllUsers();
        return $this->success(UserResource::collection($users), 'Users retrieved successfully');
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,slug',
        ]);

        $user = $this->service->createUser($data);
        return $this->success(new UserResource($user), 'User created successfully', 201);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->service->getUserById($id);
        if (!$user) {
            return $this->error('User not found', 404);
        }
        return $this->success(new UserResource($user), 'User retrieved successfully');
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,slug',
        ]);

        if ($this->service->updateUser($id, $data)) {
            $user = $this->service->getUserById($id);
            return $this->success(new UserResource($user), 'User updated successfully');
        }

        return $this->error('User not found or update failed', 404);
    }

    public function destroy(int $id): JsonResponse
    {
        if ($this->service->deleteUser($id)) {
            return $this->success(null, 'User deleted successfully');
        }

        return $this->error('User not found', 404);
    }
}
