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
        //create a virtual departments to use it for employee table
        $department1 = Department::create([
            'name' => 'Ophthalmology' ,
            'description' => 'Ophthalmology services typically include a variety of treatments and procedures such as cataract surgery, glaucoma surgery, cornea transplantation, refractive surgery (including LASIK), and the provision of corrective vision services such as eyeglasses and contact lenses.'
        ]);

        $department2 = Department::create([
            'name' => 'Pediatrics' ,
            'description' => 'Pediatrics focuses on the health care of infants, children, and adolescents, from birth up to age 18. Pediatricians deal with a wide range of health issues, including acute and chronic illnesses, and work to promote healthy growth and development in children.'
        ]);

        $department3 = Department::create([
            'name' => 'Cardiology' ,
            'description' => 'Cardiology is the branch of medicine that deals with the diagnosis and treatment of heart and vascular diseases. Cardiologists perform necessary tests to identify heart problems, such as hypertension and coronary artery disease, and provide treatment plans that may include medications or surgical interventions.'
        ]);

        $department4 = Department::create([
            'name' => 'Psychiatry' ,
            'description' => 'Psychiatry is concerned with the diagnosis and treatment of mental and emotional disorders. Psychiatrists use a variety of therapeutic approaches, including psychotherapy and medications, to help patients manage issues such as depression, anxiety, and bipolar disorder.'
        ]);

        // Creating Admin User
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '0996522488',
            'password' => Hash::make('12345678'),
            'is_patient' => false,
            'is_verified' => true
        ]);
        $admin->assignRole('Admin');

        // Creating first Doctor User
        $doctor = User::create([
            'name' => 'Doctor 1',
            'email' => 'doctor@gmail.com',
            'phone_number' => '0996522477',
            'password' => Hash::make('123123123'),
            'is_patient' => false,
            'is_verified' => true
        ]);
        $doctor->assignRole('doctor');

        //complete employee fields related to users for doctor2
        Employee::create([
            'user_id' => $doctor->id,
            'department_id' => $department1->id,
            'academic_qualifications' => 'Bachelors Degree in Cardiology',
            'previous_experience' => 'hospital1 , hospital2',
        ]);
        // Creating second Doctor User
        $doctor = User::create([
            'name' => 'Doctor 2',
            'email' => 'doctor2@gmail.com',
            'phone_number' => '0996522470',
            'password' => Hash::make('123123123'),
            'is_patient' => false,
            'is_verified' => true
        ]);
        $doctor->assignRole('doctor');

        //complete employee fields related to users for doctor
        Employee::create([
            'user_id' => $doctor->id,
            'department_id' => $department2->id,
            'academic_qualifications' => 'Bachelors Degree in Medicine and Surgery',
            'previous_experience' => 'hospital5 , hospital20',
        ]);

        // Creating employee User
        $employee = User::create([
            'name' => 'Employee1',
            'email' => 'employee@gmail.com',
            'phone_number' => '0996522466',
            'password' => Hash::make('123123123'),
            'is_patient' => false,
            'is_verified' => true
        ]);
        $employee->assignRole('employee');

        //complete employee fields related to users for employee
        Employee::create([
            'user_id' => $employee->id,
            'department_id' => $department1->id,
            'academic_qualifications' =>  'Bachelors Degree in Business Administration',
            'previous_experience' => 'XYZ Company, ABC Company',
        ]);

        // Creating employee User
        $employee = User::create([
            'name' => 'Employee2',
            'email' => 'employee2@gmail.com',
            'phone_number' => '0996522446',
            'password' => Hash::make('123123123'),
            'is_patient' => false,
            'is_verified' => true
        ]);
        $employee->assignRole('employee');

        //complete employee fields related to users for employee
        Employee::create([
            'user_id' => $employee->id,
            'department_id' => $department2->id,
            'academic_qualifications' =>  'Bachelors Degree in Business Administration',
            'previous_experience' => 'XYZ Company, ABC Company',
        ]);
    }
}
