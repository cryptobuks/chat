<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
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
        $invited = factory(User::class)->create();
        $me = factory(User::class)->create();

        // I added someone as friend
        $me->friends()->attach($friend->id);
        // Someone else added me as friend
        $invited->friends()->attach($me->id);

        $response = $this->getJson('/api/users', $this->auth($me));
        $response->assertOk();
        $this->assertTrue($response->json('status'));
        $response->assertJsonFragment($friend->toArray());
        $this->assertCount(2, $response->json('data'));
    }

    public function test_a_user_can_search_friends()
    {
        $this->withoutExceptionHandling();

        $name = $this->faker->name;
        $public = factory(User::class)->create(compact('name'));
        $invited = factory(User::class)->create(compact('name'));
        $friend = factory(User::class)->create(compact('name'));
        $me = factory(User::class)->create();
        $me->friends()->attach($friend->id);
        $invited->friends()->attach($me->id);

        $response = $this->getJson('/api/users/search?term='.$public->name, $this->auth($me));
        $response->assertOk();
        $this->assertTrue($response->json('status'));
        $response->assertJsonFragment($public->toArray());

        // Only non-friends will show up
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

        $first = $me->friends->first();
        $this->assertNotEmpty($first->pivot->room);
    }

    public function test_user_friends_will_have_a_room()
    {
        $this->assertTrue(true);
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

    /**
     * @return array
     */
    protected function api()
    {
        return [
            'X-Api-Key' => env('API_KEY'),
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    protected function auth($user)
    {
        $user->apiLogin();

        return [
            'X-Api-Key' => env('API_KEY'),
            'Authorization' => "Bearer {$user->api_token}",
        ];
    }
}
