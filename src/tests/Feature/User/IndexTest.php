<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
