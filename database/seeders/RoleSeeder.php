<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Admin']);
        $doctor = Role::create(['name' => 'doctor']);
        $employee = Role::create(['name' => 'employee']);
        $patient = Role::create(['name' => 'patient']);

        // Assign all permissions to Admin
        $admin->syncPermissions(Permission::all());

        // Doctor Permissions
        $doctor->givePermissionTo([
            'view-medicalFiles',
            'create-medicalFile',
            'edit-medicalFile',
            'delete-medicalFile',
            'show-medicalFile',
            'view-prescriptions',
            'create-prescription',
            'edit-prescription',
            'delete-prescription',
            'show-prescription',
            'view-appointment',
            'create-appointment',
            'edit-appointment',
            'delete-appointment',
            'view-timeSlotes',
            'create-timeSlote',
            'edit-timeSlote',
            'delete-timeSlote',
            'show-timeSlote',
            'show-rating',
            'create-timeslot',
            'edit-timeslot',
        ]);

        // Employee Permissions
        $employee->givePermissionTo([
            'view-employees',
            'create-employee',
            'edit-employee',
            'delete-employee',
            'show-employee',
            'view-appointment',
            'create-appointment',
            'edit-appointment',
            'delete-appointment',
            'show-appointment',
            'create-department',
            'edit-department',
            'delete-department',
            'show-department',
            'view-timeSlotes',
        ]);

        // Patient Permissions
        $patient->givePermissionTo([
            'create-appointment',
            'view-appointments',
            'show-appointment',
            'show-medicalFile',
            'show-prescription',
            'create-rating',
            'show-rating',
        ]);
    }
}