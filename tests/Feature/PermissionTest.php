<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    public function test_give_permission_to_role(): void
    {
        $user = User::factory(UserFactory::class)->make();
        $name = $user->name;
        $email = $user->email;
        $password = $user->password;
        $credentials = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
        ];
        $response = $this->post('/api/register', $credentials);
        $data = $response->json();
        $token = $data['data']['token'];

        $role = 'admin';
        $permissions = [
            'show posts',
            'create posts',
            'delete posts',
            'update posts'
        ];

        $response = $this->post('/permissions/givenToRole/'.$role . '/' . $permissions)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

    }

    public function test_create_permission(): void
    {
        $user = User::factory(UserFactory::class)->make();
        $name = $user->name;
        $email = $user->email;
        $password = $user->password;
        $credentials = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
        ];
        $response = $this->post('/api/register', $credentials);
        $data = $response->json();
        $token = $data['data']['token'];


        $permission = [
            'name' => 'PermissionTest'
        ];

        $response = $this->put('/permission/store', $permission)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

    }
}
