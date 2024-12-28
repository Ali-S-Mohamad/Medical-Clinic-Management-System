<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
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
        //create a virtual department to use it for employee table
        $department1 = Department::create([
            'name' => 'eyes' ,
            'description' => 'the new department'
        ]);

        // Creating Admin User
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '0996522488',
            'password' => Hash::make('12345678'),
            'is_patient' => false
        ]);
        $admin->assignRole('admin');

        // Creating Doctor User
        $doctor = User::create([
            'name' => 'Doctor1',
            'email' => 'doctor@gmail.com',
            'phone_number' => '0996522477',
            'password' => Hash::make('11111111'),
            'is_patient' => false
        ]);
        $doctor->assignRole('doctor');  

        //complete employee fields related to users for doctor
        Employee::create([
            'user_id' => $doctor->id,
            'department_id' => $department1->id,
            'cv_path' => 'dont added yet',
            'academic_qualifications' => 'Bachelors Degree in Medicine and Surgery',
            'previous_experience' => 'hospital1 , hospital2',
            'languages_spoken' => 'Arabic, English, French'
        ]);

        // Creating employee User
        $employee = User::create([
            'name' => 'employee1',
            'email' => 'employee@gmail.com',
            'phone_number' => '0996522466',
            'password' => Hash::make('123456789'),
            'is_patient' => false
        ]);
        $employee->assignRole('employee');

        //complete employee fields related to users for employee
        Employee::create([
            'user_id' => $employee->id,
            'department_id' => $department1->id,
            'cv_path' => 'dont added yet',
            'academic_qualifications' =>  'Bachelors Degree in Business Administration',
            'previous_experience' => 'XYZ Company, ABC Company',
            'languages_spoken' => 'Arabic, English'
        ]);
    }
}
