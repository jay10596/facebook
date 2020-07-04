<?php

namespace Tests\Feature;

use App\Friend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Resources\UserResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

use App\User;
use App\Post;
use Carbon\Carbon;


class PostTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $server;

    protected $post;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('passport:install',['-vvv' => true]);

        $this->user = factory(User::class)->create();

        $this->token = $this->user->createToken('MyApp')->accessToken;

        $this->server = [
            'HTTP_Authorization' => 'Bearer '. $this->token
        ];

        Storage::fake('public');
    }

    private function data()
    {
        return [
            'body' => 'This is a new post.',
        ];
    }

    /** @test */
    public function auth_user_can_create_text_post()
    {   //One way to create a post
        $post = factory(Post::class)->create(['user_id' => $this->user->id]);

        //Second way to create a post
        $response = $this->post('/api/posts', $this->data(), $this->server);

        $response->assertStatus(201);

        $this->assertCount(2, Post::all());


        $posts = Post::all();
        $post = $posts->last();

        $this->assertEquals('This is a new post.', $post->body);
        $this->assertEquals($post->user_id, $this->user->id);


        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'body' => $post->body,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at->diffForHumans(),

                'posted_by' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ],

                'path' => $post->path
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_create_image_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $file = UploadedFile::fake()->image('postImage.jpg');

        $response = $this->post('/api/posts', [
            'body' => 'test Body',
            'image' => $file,
            'width' => 750,
            'height' => 750,
            'user_id' => $user->id
        ])->assertStatus(201);

        Storage::disk('public')->assertExists('uploadedPostImages/' . $file->hashName());

        $this->assertCount(1, Post::all());

        $posts = Post::all();
        $post = $posts->first();

        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'body' => $post->body,
                'image' => $post->image,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at->diffForHumans(),

                'posted_by' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],

                'path' => $post->path
            ]
        ]);
    }

    /** @test */
    //actingAs is another way to login if you don't want pass the token
    public function auth_user_can_fetch_all_posts_of_his_friends()
    {
        $this->actingAs($user1 = factory(User::class)->create(), 'api'); //It just logs in the user

        $user2 = factory(User::class)->create();

        $posts = factory(Post::class, 2)->create(['user_id' => $user2->id]);

        Friend::create([
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'confirmed_at' => now(),
            'status' => 1
        ]);

        $response = $this->get('/api/posts');

        $response->assertJson([
            'data' => [
                [
                    'id' => $posts->first()->id,
                    'body' => $posts->first()->body,
                    'user_id' => $posts->first()->user_id,
                    'created_at' => $posts->first()->created_at->diffForHumans(),

                    'posted_by' => [
                        'id' => $user2->id,
                        'name' => $user2->name,
                        'email' => $user2->email,
                    ],

                    'path' => $posts->first()->path
                ],
                [
                    'id' => $posts->last()->id,
                    'body' => $posts->last()->body,
                    'user_id' => $posts->last()->user_id,
                    'created_at' => $posts->last()->created_at->diffForHumans(),

                    'posted_by' => [
                        'id' => $user2->id,
                        'name' => $user2->name,
                        'email' => $user2->email,
                    ],

                    'path' => $posts->last()->path
                ]
            ],
            'links' => [
                'self' => '/posts'
            ]
        ]);
    }

    /** @test */
    public function auth_user_cannot_fetch_others_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $user2 = factory(User::class)->create();

        $posts = factory(Post::class, 2)->create(['user_id' => $user2->id]); //These posts do not belong to logged in user

        $response = $this->get('/api/posts');

        $response->assertExactJson([
            'data' => [],
            'links' => [
                'self' => '/posts'
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_update_text_post()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $response = $this->put('/api/posts/' . $post->id, ['body' => 'An updated post']);

        $response->assertStatus(201);

        $post = Post::first();

        $this->assertEquals('An updated post', $post->body);

        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'body' => 'An updated post',
                'user_id' => $post->user_id,
                'created_at' => $post->created_at->diffForHumans(),

                'posted_by' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],

                'path' => $post->path
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_delete_text_post()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $response = $this->delete('/api/posts/' . $post->id);

        $response->assertStatus(204);

        $posts = Post::all();

        $this->assertCount(0, $posts);
    }
}
