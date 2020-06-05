<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Resources\UserResource;
use Tests\TestCase;

use App\Post;
use App\User;


class ProfileTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function auth_user_can_check_user_profiles_and_posts()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $posts = factory(Post::class, 2)->create(['user_id' => $user->id]);

        $response = $this->get('/api/users/' . $user->id);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                [
                    'id' => $posts->first()->id,
                    'body' => $posts->first()->body,
                    'user_id' => $posts->first()->user_id,
                    'created_at' => $posts->first()->created_at->diffForHumans(),

                    'posted_by' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],

                    'path' => $posts->first()->path
                ],
                [
                    'id' => $posts->last()->id,
                    'body' => $posts->last()->body,
                    'user_id' => $posts->last()->user_id,
                    'created_at' => $posts->last()->created_at->diffForHumans(),

                    'posted_by' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],

                    'path' => $posts->last()->path
                ]
            ],
            'links' => [
                'self' => '/posts'
            ]
        ]);
    }
}




