<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(3)->has(
            Partner::factory()->state(
                ['name' => 'test']
            )
        )->create();
        User::factory(3)->state(['datetime' => now()->addDay()])
            ->has(
                Partner::factory()->state(
                    ['name' => 'test']
                )
            )->create();
    }
}
