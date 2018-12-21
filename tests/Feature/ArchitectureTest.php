<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArchitectureTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_endpoints_require_x_api_key()
    {
        $response = $this->getJson('/api', $this->validApi());
        $response->assertOk();
        $this->assertNotEquals($response->json('code'), 401);

        $another = $this->postJson('/api/users', [], $this->invalidApi());
        $another->assertOk();
        $this->assertFalse($another->json('status'));
        $this->assertEquals($another->json('code'), 401);
    }

    public function test_auth_routes_require_authorization_bearer()
    {
        $invalid = $this->getJson('/api/users', $this->validApi());
        $invalid->assertOk();
        $this->assertFalse($invalid->json('status'));
        $this->assertEquals($invalid->json('code'), 403);

        $valid = $this->getJson('/api/users', $this->validAuth());
        $valid->assertOk();
        $this->assertTrue($valid->json('status'));
        $this->assertEquals($valid->json('code'), 200);
    }

    /**
     * @return array
     */
    protected function validAuth()
    {
        $user = factory(User::class)->create();
        $user->apiLogin();

        return [
            'X-Api-Key' => env('API_KEY'),
            'Authorization' => "Bearer {$user->api_token}",
        ];
    }

    /**
     * @return array
     */
    protected function validApi()
    {
        return [
            'X-Api-Key' => env('API_KEY'),
        ];
    }

    /**
     * @return array
     */
    protected function invalidApi()
    {
        return [
            'X-Api-Key' => str_random(60),
        ];
    }
}
