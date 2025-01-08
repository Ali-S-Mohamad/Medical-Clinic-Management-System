<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Roles
            'create-role',
            'edit-role',
            'delete-role',
            'show-role',

            // Emplyees
            'view-employees',
            'create-employee',
            'edit-employee',
            'delete-employee',
            'show-employee',

            // Patients
            'show-patient',
            'delete-patient',

            // Departments
            'create-department',
            'edit-department',
            'delete-department',
            'show-department',

            // Appointments
            'view-appointments',
            'create-appointment',
            'edit-appointment',
            'delete-appointment',
            'show-appointment',

            // Clinic Information
            'edit-clinicInfo',
            'show-clinicInfo',

            // Medical Files
            'view-medicalFiles',
            'create-medicalFile',
            'edit-medicalFile',
            'delete-medicalFile',
            'show-medicalFile',

            // Prescriptions
            'view-prescriptions',
            'create-prescription',
            'edit-prescription',
            'delete-prescription',
            'show-prescription',

            // Ratings
            'create-rating',
            'show-rating',

            // Reports
            'show-reports',
            'export-excelReport',
            'export-pdfReport',

            //Time Slots
            'view-timeSlotes',
            'create-timeSlote',
            'edit-timeSlote',
            'delete-timeSlote',
            'show-timeSlote',

        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);

        }


   }
}