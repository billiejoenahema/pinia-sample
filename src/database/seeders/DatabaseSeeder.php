<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'テスト ユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('11111111'),
        ]);

        User::factory(10)->create();
    }
}
