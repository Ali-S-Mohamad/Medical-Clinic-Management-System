<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Admin']);
        $doctor = Role::create(['name' => 'doctor']);
        $employee = Role::create(['name' => 'employee']);
        $patient = Role::create(['name' => 'patient']);


        $doctor->givePermissionTo([
            'edit-employee',
            'show-employee',
            'show-patient',
            'show-department',
            'show-clinicInformation',
            'create-patientFile',
            'edit-patientFile',
            'delete-patientFile',
            'show-patientFile',
            'show-rating',
        ]);

        $employee->givePermissionTo([
            'edit-employee',
            'show-employee',
            'delete-patient',
            'show-patient',
            'show-department',
            'show-clinicInformation',
            'show-appointment',
            'cancel-appointment',
            'show-rating',
            'show-reports',
            'export-excelReport',
        ]);

        $patient->givePermissionTo([
            'show-clinicInformation',
            'book-appointment',
            'show-appointment',
            'cancel-appointment',
            'create-rating',
            'show-rating',
            'export-pdfReport'

        ]);
    }
}
