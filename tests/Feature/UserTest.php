<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_users()
    {
        $admin = User::factory()->create();
        User::factory()->count(3)->create();

        $response = $this->actingAs($admin)
            ->getJson('/api/auth/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => ['id', 'name', 'email', 'roles']
                ]
            ]);
    }

    public function test_can_create_user_with_roles()
    {
        $admin = User::factory()->create();
        $role = Role::create(['name' => 'Admin', 'slug' => 'admin']);

        $response = $this->actingAs($admin)
            ->postJson('/api/auth/users', [
                'name' => 'New User',
                'email' => 'new@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'roles' => ['admin'],
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'name' => 'New User',
                    'email' => 'new@example.com',
                    'roles' => ['Admin'],
                ]
            ]);
    }

    public function test_can_update_user_roles()
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Editor', 'slug' => 'editor']);

        $response = $this->actingAs($admin)
            ->putJson("/api/auth/users/{$user->id}", [
                'roles' => ['editor'],
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'roles' => ['Editor'],
                ]
            ]);
    }

    public function test_can_delete_user()
    {
        $admin = User::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($admin)
            ->deleteJson("/api/auth/users/{$user->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
