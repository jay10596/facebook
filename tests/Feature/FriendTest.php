<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Carbon\Carbon;
use App\User;
use App\Friend;


class FriendTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function auth_user_can_send_friend_request()
    {
        $this->actingAs($user1 = factory(User::class)->create(), 'api'); //It just logs in the user

        $user2 = factory(User::class)->create();

        $response = $this->post('/api/send-request', ['friend_id' => $user2->id]);

        $response->assertStatus(200);

        $friendRequest = Friend::first(); //To grab first row from the friend's table

        $this->assertNotNull($friendRequest);
        $this->assertEquals($user2->id, $friendRequest->friend_id);
        $this->assertEquals($user1->id, $friendRequest->user_id);

        $response->assertJson([
            'data' => [
                'id' => $friendRequest->id,
                'status' => $friendRequest->status, //NULL
                'confirmed_at' => $friendRequest->confirmed_at, //NULL
                'path' => url('/users/'.$friendRequest->friend_id)
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_accept_friend_request()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user1 = factory(User::class)->create(), 'api'); //It just logs in the user

        $user2 = factory(User::class)->create();

        $response1 = $this->post('/api/send-request', ['friend_id' => $user2->id]);

        $this->actingAs($user2, 'api'); //It just logs in the user

        $response2 = $this->post('/api/confirm-request', ['user_id' => $user1->id]);

        $response2->assertStatus(200);

        $friendRequest = Friend::first(); //To grab first row from the friend's table

        $this->assertNotNull($friendRequest->confirmed_at);
        $this->assertNotNull($friendRequest->status);

        $this->assertInstanceOf(Carbon::class, $friendRequest->confirmed_at);

        $this->assertEquals(now()->startOfSecond(), $friendRequest->confirmed_at);

        $this->assertEquals(1, $friendRequest->status);

        $response2->assertJson([
            'data' => [
                'id' => $friendRequest->id,
                'status' => $friendRequest->status,
                'confirmed_at' => $friendRequest->confirmed_at->diffForHumans(),
                'path' => url('/users/'.$friendRequest->friend_id)
            ]
        ]);
    }

    /** @test */
    public function only_valid_users_can_send_friend_request()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $response = $this->post('/api/send-request', ['friend_id' => 123]);

        $friendRequest = Friend::first(); //To grab first row from the friend's table

        $this->assertNull($friendRequest);

        $response->assertStatus(404);

        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => 'User not found',
                'detail' => 'Unable to locate user with given information'
            ]
        ]);
    }

    /** @test */
    public function only_valid_friend_requests_can_be_accepted()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $response = $this->post('/api/confirm-request', ['user_id' => 123]);

        $friendRequest = Friend::first(); //To grab first row from the friend's table

        $this->assertNull($friendRequest);

        $response->assertStatus(404);

        $response->assertJson([
            'errors' => [
                'code' => 404,
                'title' => 'Friend Request not found',
                'detail' => 'Unable to locate friend request with given information'
            ]
        ]);
    }

    /** @test */
    public function third_party_user_cannot_accept_the_request()
    {
        $this->actingAs($user1 = factory(User::class)->create(), 'api'); //It just logs in the user

        $user2 = factory(User::class)->create();

        $response1 = $this->post('/api/send-request', ['friend_id' => $user2->id]);

        $response1->assertStatus(200);

        $user3 = factory(User::class)->create();

        $this->actingAs($user3, 'api');

        $response2 = $this->post('/api/confirm-request', ['user_id' => $user1->id]);

        $response2->assertStatus(404);

        $friendRequest = Friend::first();

        $this->assertEquals(null, $friendRequest->confirmed_at);

        $this->assertEquals(null, $friendRequest->status);

        $response2->assertJson([
            'errors' => [
                'code' => 404,
                'title' => 'Friend Request not found',
                'detail' => 'Unable to locate friend request with given information'
            ]
        ]);
    }

    /** @test */
    public function friend_id_is_required_to_send_request()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $response = $this->post('/api/send-request', ['friend_id' => '']);

        $response->assertStatus(422);

        $responseString = json_decode($response->getContent(), true); //true will convert the object into array

        $this->assertArrayHasKey('friend_id', $responseString['errors']['meta']);
    }

    /** @test */
    public function user_id_is_required_to_confirm_request()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $response = $this->post('/api/confirm-request', ['user_id' => '']);

        $response->assertStatus(422);

        $responseString = json_decode($response->getContent(), true); //true will convert the object into array

        $this->assertArrayHasKey('user_id', $responseString['errors']['meta']);
    }

    /** @test */
    public function friendships_can_be_fetched_in_the_profile()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user1 = factory(User::class)->create(), 'api'); //It just logs in the user

        $user2 = factory(User::class)->create();

        //Another way without post response
        $friendRequest = Friend::create([
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'confirmed_at' => now()->subDay(),
            'status' => 1
        ]);

        $response = $this->get('/api/users/' . $user2->id);

        $response->assertStatus(200);

        $response->assertJson([
            [
                'id' => $user2->id,
                'name' => $user2->name,
                'email' => $user2->email,
                'friendship' => [
                    'confirmed_at' => '1 day ago'
                ],
                'path' => $user2->path
            ],
            [
                'data' =>[],
                'links' => [
                    'self' => '/posts'
                ]
            ]
        ]);
    }

    /** @test */
    public function inverse_friendships_can_be_fetched_in_the_profile()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user1 = factory(User::class)->create(), 'api'); //It just logs in the user

        $user2 = factory(User::class)->create();

        //Another way without post response
        $friendRequest = Friend::create([
            'friend_id' => $user1->id,
            'user_id' => $user2->id,
            'confirmed_at' => now()->subDay(),
            'status' => 1
        ]);

        $response = $this->get('/api/users/' . $user2->id);

        $response->assertStatus(200);

        $response->assertJson([
            [
                'id' => $user2->id,
                'name' => $user2->name,
                'email' => $user2->email,
                'friendship' => [
                    'confirmed_at' => '1 day ago'
                ],
                'path' => $user2->path
            ],
            [
                'data' =>[],
                'links' => [
                    'self' => '/posts'
                ]
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_delete_friend_request()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user1 = factory(User::class)->create(), 'api'); //It just logs in the user

        $user2 = factory(User::class)->create();

        $response1 = $this->post('/api/send-request', ['friend_id' => $user2->id]);

        $this->actingAs($user2, 'api'); //It just logs in the user

        $response2 = $this->post('/api/delete-request', ['user_id' => $user1->id]);

        $response2->assertStatus(204);

        $friendRequest = Friend::first(); //To grab first row from the friend's table

        $this->assertNull($friendRequest);

        $response2->assertNoContent();
    }

    /** @test */
    public function third_party_user_cannot_delete_the_request()
    {
        $this->actingAs($user1 = factory(User::class)->create(), 'api'); //It just logs in the user

        $user2 = factory(User::class)->create();

        $response1 = $this->post('/api/send-request', ['friend_id' => $user2->id]);

        $response1->assertStatus(200);

        $user3 = factory(User::class)->create();

        $this->actingAs($user3, 'api');

        $response2 = $this->post('/api/delete-request', ['user_id' => $user1->id]);

        $response2->assertStatus(404);

        $friendRequest = Friend::first();

        $this->assertEquals(null, $friendRequest->confirmed_at);

        $this->assertEquals(null, $friendRequest->status);

        $response2->assertJson([
            'errors' => [
                'code' => 404,
                'title' => 'Friend Request not found',
                'detail' => 'Unable to locate friend request with given information'
            ]
        ]);
    }

    /** @test */
    public function user_id_is_required_to_delete_request()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $response = $this->post('/api/delete-request', ['user_id' => '']);

        $response->assertStatus(422);

        $responseString = json_decode($response->getContent(), true); //true will convert the object into array

        $this->assertArrayHasKey('user_id', $responseString['errors']['meta']);
    }
}
