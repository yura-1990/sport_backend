<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'login' => 'supper_admin_of_sport_institude',
            'password' => Hash::make('supperpassswordofsportinstitude'),
            'role_id' => 1,
            'fillial_id'=> 1,
            'pasport_id'=>1
        ]);
    }
}
