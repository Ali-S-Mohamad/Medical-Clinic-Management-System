<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\ClinicInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClinicInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinicInfo = ClinicInfo::create([
        //  'logo' => 'storage/logos/logo.png',
            'name' => 'MediCore',
            'email'=> 'info@MediCore.com',
            'address' =>  'Damas, Syria',
            'phone_number' =>  '011-2244',
            'established_at' => '2024-01-01' ,
            'about' => 'Welcome to MediCore, where excellence meets care. 
                        Our team of elite doctors, equipped with the latest medical technology,                         is dedicated to providing top-notch healthcare services. 
                        Our diverse departments include General Medicine, Pediatrics, Cardiology, Orthopedics, and more, ensuring comprehensive care for you and your family.
                        Experience the best in healthcare at MediCore',
        ]);

        Image::create([ 
            'image_path' => '/logos/logo.jpg', 
            'imageable_id' => $clinicInfo->id, 
            'imageable_type' => ClinicInfo::class, 
    ]);
    }
}
