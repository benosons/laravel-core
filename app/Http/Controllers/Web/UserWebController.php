<?php

namespace App\Http\Controllers\Web;

use App\Core\Base\BaseController;
use App\Services\UserService;
use App\Models\Role;
use Illuminate\Http\Request;

class UserWebController extends BaseController
{
    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = $this->service->getAllUsers();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,slug',
        ]);

        $this->service->createUser($data);
        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show(int $id)
    {
        $user = $this->service->getUserById($id);
        if (!$user) {
            abort(404);
        }
        return view('users.show', compact('user'));
    }

    public function edit(int $id)
    {
        $user = $this->service->getUserById($id);
        if (!$user) {
            abort(404);
        }
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,slug',
        ]);

        $this->service->updateUser($id, $data);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(int $id)
    {
        $this->service->deleteUser($id);
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
