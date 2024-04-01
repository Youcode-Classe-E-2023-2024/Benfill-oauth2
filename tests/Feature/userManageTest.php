<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class userManageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_creation(): void
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

        $user = User::factory(UserFactory::class)->create();
        $name = $user->name;
        $email = $user->email;
        $password = $user->password;
        $credentials = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
        ];
        $response = $this->post('/users', $credentials)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

    }

    public function test_get_users(): void
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

        $response = $this->get('/users')->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

    }

    public function test_get_user_detail(): void
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

        $response = $this->get('/users' . $user->id)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

    }

    public function test_delete_user(): void
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

        $response = $this->delete('/users' . $user->id)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

    }

    public function test_update_user(): void
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

        $user = User::factory(UserFactory::class)->make();
        $name = $user->name;
        $email = $user->email;
        $password = $user->password;
        $credentials = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
        ];
        $response = $this->put('/users' . $user->id, $credentials)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ]);

    }
}
