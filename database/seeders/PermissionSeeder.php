<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'show-role',
            'create-employee',
            'edit-employee',
            'delete-employee',
            'show-employee',
            'delete-patient',
            'show-patient',
            'create-department',
            'edit-department',
            'delete-department',
            'show-department',
            'edit-clinicInformation',
            'show-clinicInformation',
            'book-appointment',
            'show-appointment',
            'cancel-appointment',
            'create-patientFile',
            'edit-patientFile',
            'delete-patientFile',
            'show-patientFile',
            'create-rating',
            'show-rating',
            'show-reports',
            'export-excelReport',
            'export-pdfReport'
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
