<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Post;
use App\User;


class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function auth_user_can_like_a_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['id' => 123]);

        $response = $this->post('/api/posts/' . $post->id . '/like-dislike');

        $response->assertStatus(200);

        $this->assertCount(1, $user->likes);

        $response->assertJson([
            'data' => [
                [
                    'created_at' => now()->diffForHumans(),
                    'post_id' => $post->id,
                    'path' => url('/posts/' . $post->id),
                ]
            ],
            'links' => [
                'self' => '/posts',
            ],
        ]);
    }


    /** @test */
    public function posts_are_return_with_likes()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['id' => 123, 'user_id' => $user->id]);

        $this->post('/api/posts/' . $post->id . '/like-dislike')->assertStatus(200);;

        $response = $this->get('/api/posts');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                [
                    'id' => $post->first()->id,
                    'body' => $post->first()->body,
                    'user_id' => $post->first()->user_id,
                    'created_at' => $post->first()->created_at->diffForHumans(),

                    'likes' => [
                        'data' => [
                            [
                                'created_at' => now()->diffForHumans(),
                                'post_id' => $post->id,
                                'path' => url('/posts/' . $post->id),
                            ]
                        ],
                        'links' => [
                            'self' => '/posts',
                        ]
                    ],

                    'posted_by' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],

                    'path' => $post->first()->path
                ],
            ],
            'links' => [
                'self' => '/posts',
            ],
        ]);
    }
}
