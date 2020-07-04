<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Post;
use App\User;
use App\Comment;


class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function posts_are_returned_with_comments()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['id' => 123, 'user_id' => $user->id]);

        $this->post('/api/posts/' . $post->id . '/comments', ['body' => 'A new comment here!'])->assertStatus(200);;

        $response = $this->get('/api/posts');

        $response->assertStatus(200);

        $comment = Comment::first();

        $this->assertCount(1, Comment::all());

        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($post->id, $comment->post_id);

        $response->assertJson([
            'data' => [
                [
                    'id' => 123,
                    'body' => $post->first()->body,
                    'user_id' => $post->first()->user_id,
                    'created_at' => $post->first()->created_at->diffForHumans(),

                    'likes' => [
                        'data' => [

                        ],
                        'like_count' => 0,
                        'user_liked' => false,
                        'links' => [
                            'self' => '/posts',
                        ]
                    ],

                    'comments' => [
                        'data' => [
                            [
                                'body' => 'A new comment here!',
                                'updated_at' => now()->diffForHumans(),
                                'commented_by' => [
                                    'name' => $user->name,
                                    'email' => $user->email
                                ],
                                'path' => '/posts/' . $post->id . '/comments/' . $comment->id,
                            ]
                        ],
                        'comment_count' => 1,
                        'links' => [
                            'self' => '/posts',
                        ],
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

    /** @test */
    public function auth_user_can_create_a_comment()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['id' => 123]);

        $response = $this->post('/api/posts/' . $post->id . '/comments', ['body' => 'A new comment here!']);

        $response->assertStatus(200);

        $comment = Comment::first();

        $this->assertCount(1, Comment::all());

        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($post->id, $comment->post_id);

        $response->assertJson([
            'data' => [
                [
                    'body' => 'A new comment here!',
                    'post_id' => $post->id,
                    'updated_at' => now()->diffForHumans(),
                    'commented_by' => [
                        'name' => $user->name,
                        'email' => $user->email
                    ],
                    'path' => '/posts/' . $post->id . '/comments/' . $comment->id,
                ]
            ],
            'comment_count' => 1,
            'links' => [
                'self' => '/posts',
            ],
        ]);
    }

    /** @test */
    public function auth_user_can_edit_a_comment()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['id' => 123]);

        $comment = factory(Comment::class)->create(['id' => 123, 'post_id' => $post->id]);

        $response = $this->put('/api/posts/' . $post->id . '/comments/' . $comment->id, ['body' => 'An edited comment here!']);

        $response->assertStatus(200);

        $comment = Comment::first();

        $this->assertCount(1, Comment::all());

        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($post->id, $comment->post_id);
        $this->assertEquals($comment->body, 'An edited comment here!');

        $response->assertJson([
            'data' => [
                [
                    'body' => 'An edited comment here!',
                    'post_id' => 123,
                    'updated_at' => now()->diffForHumans(),
                    'commented_by' => [
                        'name' => $user->name,
                        'email' => $user->email
                    ],
                    'path' => '/posts/' . $post->id . '/comments/' . $comment->id,
                ]
            ],
            'comment_count' => 1,
            'links' => [
                'self' => '/posts',
            ],
        ]);
    }

    /** @test */
    public function auth_user_can_delete_a_comment()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['id' => 123]);

        $comment = factory(Comment::class)->create(['id' => 123, 'post_id' => $post->id]);

        $response = $this->delete('/api/posts/' . $post->id . '/comments/' . $comment->id);

        $response->assertStatus(204);

        $this->assertCount(0, Comment::all());
    }

    /** @test */
    public function body_is_required_to_comment_on_a_post()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['id' => 123]);

        $response = $this->post('/api/posts/' . $post->id . '/comments');

        $response->assertStatus(422);

        $responseString = json_decode($response->getContent(), true); //true will convert the object into array

        $this->assertArrayHasKey('body', $responseString['errors']['meta']);
    }
}
