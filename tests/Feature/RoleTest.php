<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    public function test_assign_role(): void
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


        $data = [
            'role' => 'admin',
            'user_id' => $user->id
        ];

        $response = $this->post('/role/assign', $data)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

    }

    public function test_create_role(): void
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


        $role = [
          'name' => 'RoleTest'
        ];

        $response = $this->put('/role/store', $role)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

    }
}
