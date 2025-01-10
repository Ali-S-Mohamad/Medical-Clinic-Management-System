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
            'show-patient',

            'show-department',

            'show-employee',

            'show-clinicInformation',

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
            'edit-Appointment',
            'delete-Appointment',

            'show-rating',

            'show-report',
            'export-report',

            'show-TimeSlot',
            'create-TimeSlot',
            'edit-TimeSlot',
            'delete-TimeSlot',
        ]);

        $employee->givePermissionTo([
            'show-patient',
            
            'show-department',

            'show-employee',

            'show-clinicInformation',

            'show-MedicalFile',

            'show-prescription',

            'show-Appointment',
            'create-Appointment',
            'edit-Appointment',
            'delete-Appointment',

            'show-rating',

            'show-report',
            'export-report', 

            //'show-TimeSlot',

            'show-report',
            'export-report',
 
        ]);

        $patient->givePermissionTo([
            'show-clinicInformation',
            
            'store-AppointmentforPatient',      //api
            'get-AppointmentforPatient',        //api
            'get-AvailableSlot',               //api

            'get-PatientPrescriptions',  //api
            'get-ActiveDepartments',     //api
            'get-AvailableDoctorforPatient',     //api

            'show-report',
            'export-report',

            'show-patientRatings',
            'create-rating',     //api
            'edit-rating',      //api
            'delete-rating', 


        ]);
    }
}
