<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Http\Response;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_a_user_can_be_created_and_logged_in()
    {
        $this->withoutExceptionHandling();
        $attributes = factory(User::class)->raw();

        $response = $this->postJson('/api/users', $attributes, $this->api());
        $response->assertOk();
        $this->assertDatabaseHas('users', $response->json('data'));
        $this->assertTrue($response->json('status'));
        $response->assertJsonFragment($attributes);
        $this->assertNotEmpty($response->json('data.api_token'));
    }

    public function test_a_user_can_see_list_of_friends()
    {
        $this->withoutExceptionHandling();

        $friend = factory(User::class)->create();
        $me = factory(User::class)->create();
        $me->friends()->attach($friend->id);

        $response = $this->getJson('/api/users', $this->auth($me));
        $response->assertOk();
        $this->assertTrue($response->json('status'));
        $response->assertJsonFragment($friend->toArray());
        $this->assertCount(1, $response->json('data'));
    }

    public function test_a_user_can_search_friends()
    {
        $this->withoutExceptionHandling();

        $friend = factory(User::class)->create();
        $me = factory(User::class)->create();

        $response = $this->getJson('/api/users/search?term='.$friend->name, $this->auth($me));
        $response->assertOk();
        $this->assertTrue($response->json('status'));
        $response->assertJsonFragment($friend->toArray());
        $this->assertCount(1, $response->json('data'));
    }

    public function test_a_user_can_add_friends()
    {
        $this->withoutExceptionHandling();

        $friend = factory(User::class)->create();
        $me = factory(User::class)->create();

        $response = $this->putJson('/api/users/invite', ['id' => $friend->id], $this->auth($me));
        $response->assertOk();
        $this->assertTrue($response->json('status'));
        $this->assertCount(1, $response->json('data'));
        $this->assertCount(1, $me->friends);
    }

    public function test_user_email_is_required()
    {
        $attributes = factory(User::class)->raw(['email' => '']);

        $response = $this->postJson('/api/users', $attributes, $this->api());
        $this->assertFalse($response->json('status'));
        $this->assertEquals($response->json('code'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_name_is_required()
    {
        $attributes = factory(User::class)->raw(['name' => '']);

        $response = $this->postJson('/api/users', $attributes, $this->api());
        $this->assertFalse($response->json('status'));
        $this->assertEquals($response->json('code'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_image_is_required()
    {
        $attributes = factory(User::class)->raw(['image' => '']);

        $response = $this->postJson('/api/users', $attributes, $this->api());
        $this->assertFalse($response->json('status'));
        $this->assertEquals($response->json('code'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function api()
    {
        return [
            'X-Api-Key' => env('API_KEY'),
        ];
    }

    protected function auth($user)
    {
        $user->apiLogin();

        return [
            'X-Api-Key' => env('API_KEY'),
            'Authorization' => "Bearer {$user->api_token}",
        ];
    }
}
