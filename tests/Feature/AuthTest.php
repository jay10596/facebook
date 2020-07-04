<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use App\User;
use App\Post;
use Carbon\Carbon;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $server;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('passport:install',['-vvv' => true]);

        $this->user = factory(User::class)->create();

        $this->token = $this->user->createToken('MyApp')->accessToken;

        $this->server = [
            'HTTP_Authorization' => 'Bearer '. $this->token
        ];
    }

    private function registerData()
    {
        return [
            'name' => 'user',
            'email' => 'user@test.com',
            'password' => 'password',
            'confirm_password' => 'password'
        ];
    }

    private function loginData()
    {
        return [
            'email' => $this->user->email,
            'password' => 'password',
        ];
    }

    private function postData()
    {
        return [
            'body' => 'This is a new post.',
        ];
    }

    /** @test */
    public function unregistered_user_can_register()
    {
        $response = $this->post('/api/register', $this->registerData());

        $response->assertStatus(200);

        $this->assertCount(2, User::all());

        $users = User::all();
        $user = $users->last();

        $this->assertEquals('user', $user->name);
        $this->assertEquals('user@test.com', $user->email);
    }

    /** @test */
    public function registered_user_can_login()
    {
        $response = $this->post('/api/login', $this->loginData());

        $response->assertStatus(200);

        $this->assertCount(1, User::all());

        $user = User::first();

        $this->assertEquals($this->user->name, $user->name);
        $this->assertEquals($this->user->email, $user->email);
    }

    /** @test */
    public function auth_user_can_create_new_post()
    {
        //$this->actingAs($user = factory(User::class)->create(), 'api'); Not required as we are passing the token manually.

        $response = $this->post('/api/posts', $this->postData(), $this->server);

        $response->assertStatus(201);

        $this->assertCount(1, Post::all());
    }

    /** @test */
    public function auth_user_can_logout()
    {
        //Body if not necessary but it is important to add it for best practice.
        $response = $this->post('/api/logout', [],  $this->server);

        $response->assertStatus(200);
    }
}
