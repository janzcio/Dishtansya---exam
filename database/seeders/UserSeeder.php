<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('jobs')->truncate();

        $faker = Faker::create();

        // max rows to generate
        $maxRows = 30;

        // percent number of guest users is 95% and 10% is admin
        $numberOfGuestUsers = 90;

        foreach (range(1, $maxRows) as $value) {
            $is_admin = 0;

            if( (($numberOfGuestUsers / 100) * $maxRows) < $value ) {
                $is_admin = 1;
            }

            $userCreate = User::create([
                "name" => $faker->name,
                "email" => $faker->unique()->email,
                'password' => bcrypt('password'),
                'is_admin' => $is_admin,
            ]);
        }
    }
}
