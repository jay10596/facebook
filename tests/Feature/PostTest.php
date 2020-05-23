<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Resources\UserResource;
use Tests\TestCase;

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

        \Artisan::call('passport:install',['-vvv' => true]);

        $this->user = factory(User::class)->create();

        $this->token = $this->user->createToken('MyApp')->accessToken;

        $this->server = [
            'HTTP_Authorization' => 'Bearer '. $this->token
        ];
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
    //actingAs is another way to login if you don't want pass the token   
    public function auth_user_can_fetch_only_his_posts() 
    {        
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $posts = factory(Post::class, 2)->create(['user_id' => $user->id]);

        $response = $this->get('/api/posts');
    
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

    /** @test */ 
    public function auth_user_cannot_fetch_others_posts() 
    {        
        $this->actingAs($user = factory(User::class)->create(), 'api'); 

        $posts = factory(Post::class, 2)->create(); //These posts do not belong to logged in user

        $response = $this->get('/api/posts');
    
        $response->assertExactJson([
            'data' => [],
            'links' => [
                'self' => '/posts'
            ]
        ]);
    }
}
