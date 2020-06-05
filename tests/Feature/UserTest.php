<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Post;
use App\User;


class UserTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function auth_user_can_be_fetched()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $response = $this->post('/api/me');

        $response->assertStatus(200);

        $response->assertJson([
            'success' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }
}
