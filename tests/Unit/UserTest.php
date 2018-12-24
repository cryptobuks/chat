<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_login()
    {
        $user = factory(User::class)->create();
        $this->assertEmpty($user->api_token);

        $user->apiLogin();
        $this->assertNotEmpty($user->api_token);
    }

    public function test_it_has_friends()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->friends);
    }
}
