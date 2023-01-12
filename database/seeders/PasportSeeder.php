<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pasports')->insert([
            'pnfl'=>12345678912345,
            'pasport_seria'=>'SA',
            'pasport_seria_code'=>1234567
        ]);
        DB::table('pasports')->insert([
            'pnfl'=>11111111111111,
            'pasport_seria'=>'IA',
            'pasport_seria_code'=>1111111
        ]);
        DB::table('pasports')->insert([
            'pnfl'=>22222222222222,
            'pasport_seria'=>'NA',
            'pasport_seria_code'=>2222222
        ]);
        DB::table('pasports')->insert([
            'pnfl'=>33333333333333,
            'pasport_seria'=>'FA',
            'pasport_seria_code'=>3333333
        ]);
        DB::table('pasports')->insert([
            'pnfl'=>44444444444444,
            'pasport_seria'=>'FA',
            'pasport_seria_code'=>4444444
        ]);
    }
}
