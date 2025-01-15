<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employee_language')->insert([
            ['employee_id'=>1 , 'language_id'=>1],
            ['employee_id'=>1 , 'language_id'=>2],
            ['employee_id'=>2 , 'language_id'=>3],
            ['employee_id'=>2 , 'language_id'=>4],
        ]);
    }
}
