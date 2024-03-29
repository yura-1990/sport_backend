<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pasport;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            FillialSeeder::class,
            PasportSeeder::class,
            UserSeeder::class,
            RegionSeeder::class,
            DirectionSeeder::class,
            DirectionCategorySeeder::class,
            EducationNameSeeder::class,
            WorkPlaceSeeder::class
        ]);
    }
}
