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
            'login' => 'supper_admin',
            'password' => Hash::make('supperpasssword'),
            'role_id' => 1,
            'fillial_id'=> 1,
            'pasport_id'=>1
        ]);
        DB::table('users')->insert([
            'login' => 'institut_admin',
            'password' => Hash::make('institut_admin'),
            'role_id' => 2,
            'fillial_id'=> 1,
            'pasport_id'=>1
        ]);
        DB::table('users')->insert([
            'login' => 'samarqand_admin',
            'password' => Hash::make('samarqand_admin'),
            'role_id' => 2,
            'fillial_id'=> 2,
            'pasport_id'=>2
        ]);
        DB::table('users')->insert([
            'login' => 'navoi_admin',
            'password' => Hash::make('navoi_admin'),
            'role_id' => 2,
            'fillial_id'=> 3,
            'pasport_id'=>3
        ]);
        DB::table('users')->insert([
            'login' => 'fargana_admin',
            'password' => Hash::make('fargana_admin'),
            'role_id' => 2,
            'fillial_id'=> 4,
            'pasport_id'=>4
        ]);
    }
}
