<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_places')->insert([
            'name_uz' => 'Maktabgacha ta\'lim tashkilotlari',
            'name_ru' => 'Дошкольные образовательные организации',
            'name_en' => 'Preschool educational organizations',
        ]);
        DB::table('work_places')->insert([
            'name_uz' => 'Umumiy o\'rta ta\'lim maktablari',
            'name_ru' => 'Общеобразовательные школы',
            'name_en' => 'General secondary education schools',
        ]);
        DB::table('work_places')->insert([
            'name_uz' => 'Umumiy o\'rta-maxsus ta\'lim tashkilotlari',
            'name_ru' => 'Организации общего среднего и специального образования',
            'name_en' => 'Organizations of general secondary and special education',
        ]);
        DB::table('work_places')->insert([
            'name_uz' => 'Boshlang\'ich professional ta\'lim muassasalari',
            'name_ru' => 'Начальные профессиональные учебные заведения',
            'name_en' => 'Primary professional educational institutions',
        ]);
        DB::table('work_places')->insert([
            'name_uz' => 'Sport ta\'limi muassasalari',
            'name_ru' => 'Учреждения спортивного образования',
            'name_en' => 'Sports education institutions',
        ]);
        DB::table('work_places')->insert([
            'name_uz' => 'Oliy ta\'lim muassasalari',
            'name_ru' => 'Высшие учебные заведения',
            'name_en' => 'Higher educational institutions',
        ]);
    }
}
