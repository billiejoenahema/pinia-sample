<?php

namespace Database\Seeders;

use App\Models\Attendance;
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
        $user = User::factory()->has(
            Partner::factory()->state(
                ['name' => 'test']
            )
        )->create();

        $workingDates = [
            '2022-11-01',
            '2022-11-02',
            '2022-11-03',
            '2022-11-04',
            '2022-11-05',
        ];
        foreach ($workingDates as $workingDate) {
            Attendance::factory()->create([
                'user_id' => $user->id,
                'working_date' => $workingDate,
            ]);
        }
    }
}
