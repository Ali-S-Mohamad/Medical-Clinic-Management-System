<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Creating Admin User
         $superAdmin = User::create([
            'name' => 'admin', 
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'is_patient' => false
        ]);
    }
}
