<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザー一覧を取得できるか
     *
     * @return void
     */
    public function test_getUserIndex()
    {
        /** @var User */
        User::factory(5)->create();

        $response = $this->getJson('/api/user');
        $response->assertStatus(200)->assertJsonCount(5, 'data');
    }

    /**
     * ユーザー一覧を取得できるか
     *
     * @return void
     */
    public function test_searchIndex()
    {
        /** @var User */
        $yesterday = now()->subDay()->format('Y/m/d H:i:s');
        $today = now()->format('Y/m/d H:i:s');
        $tomorrow = now()->addDay()->format('Y/m/d H:i:s');
        User::factory()->create(['datetime' => $yesterday]);
        User::factory()->create(['datetime' => $today]);
        $user = User::factory()->create(['datetime' => $tomorrow]);

        $response = $this->getJson('/api/user?datetime=' . $today);
        $response->assertJsonCount(3)->assertJsonPath('data.0.datetime', $user->datetime);
    }
}
