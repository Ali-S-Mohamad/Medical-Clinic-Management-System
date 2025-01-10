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

            'show-dashboard',

            'show-clinicInformation',
            'edit-clinicInformation',

            'show-employee',
            'create-employee',
            'edit-employee',
            'Archive-employee',
            'view-archiveEmpolyess',
            'restore-employee',
            'delete-employee',

            'show-patient',

            'show-department',
            'create-department',
            'edit-department',
            'Archive-department',
            'view-archiveDepartment',
            'restore-department',
            'delete-department',

            
            'show-MedicalFile',
            'create-MedicalFile',
            'edit-MedicalFile',
            'Archive-MedicalFile',
            'view-archiveMedicalFile',
            'restore-MedicalFile',
            'delete-MedicalFile',

            'show-prescription',
            'create-prescription',
            'edit-prescription',
            'Archive-prescription',
            'view-archivePrescription',
            'restore-prescription',
            'delete-prescription',

            'show-Appointment',
            'create-Appointment',
            'edit-Appointment',
            'delete-Appointment',
            'store-AppointmentforPatient',      //api
            'get-AppointmentforPatient',        //api
            'get-AvailableSlot',               //api

        
            'show-TimeSlot',
            'create-TimeSlot',
            'edit-TimeSlot',
            'delete-TimeSlot',
            
            'show-rating',
            'show-patientRatings',
            'create-rating',     //api
            'edit-rating',      //api
            'delete-rating', 
              
            
            'show-report',
            'export-report',

            'get-PatientPrescriptions',  //api
            'get-ActiveDepartments',     //api
            'get-AvailableDoctorforPatient'     //api


        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
