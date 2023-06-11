<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'username'      => 'user1',
            'password'      => Hash::make('password123'),
            'email'         => 'user1@example.com',
            'photo_profile' => NULL,
            'created_at'    => Carbon::now()
        ]);
    }
}
