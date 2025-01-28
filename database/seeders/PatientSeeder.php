<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\TimeSlot;
use App\Models\Appointment;
use App\Models\MedicalFile;
use App\Models\Prescription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 7; $i++) {
        //create patient
            $user = User::create([
                'firstname' => 'patient',
                'lastname' => $i,
                'email' => 'patient' . $i . '@example.com',
                'phone_number' => '091234567' . $i,
                'is_patient' => true,
                'gender' => ($i % 2 == 0) ? 'male' : 'female',
                'password' => Hash::make('password'),
                'confirm_password' => Hash::make('password'),
                'is_verified' => true,
            ]);
            $user->assignRole('patient');

            $patient = Patient::create([
                'user_id' => $user->id,
                'dob' => now()->subYears(rand(20, 50)), //random birthday
                'insurance_number' => 'INS-' . str_pad($i, 5, '0', STR_PAD_LEFT),
            ]);

            // create medical files for patients
            $medicalFile = MedicalFile::create([
                'patient_id' => $patient->id,
                'diagnoses' => 'Diagnosis for patient ' . $i,
            ]);

            //create Timeslots for doctors
            $timeSlots = [
                [
                    'doctor_id' => 1,
                    'start_time' => '09:00:00',
                    'end_time' => '14:00:00',
                    'day_of_week' => $i-1,
                    'is_available' => true,
                    'slot_duration' => 30,
                ],
                [
                    'doctor_id' => 2,
                    'start_time' => '10:00:00',
                    'end_time' => '16:00:00',
                    'day_of_week' => $i-1,
                    'is_available' => true,
                    'slot_duration' => 30,
                ],
            ];

            DB::table('time_slots')->insert($timeSlots);

            // create two appointment for each patient
            for ($j = 1; $j <= 2; $j++) {
                $doctorId = rand(1, 2); // doctors

                // return timeslots for each doctor
                $availableTimeSlots = TimeSlot::where('doctor_id', $doctorId)
                    ->where('is_available', true)
                    ->get();

                if ($availableTimeSlots->isNotEmpty()) {
                    // select a random time
                    $selectedTimeSlot = $availableTimeSlots->random();

                    // create appointment
                    $appointment = Appointment::create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctorId,
                        'appointment_date' => now()->addDays(rand(1, 30))->format('Y-m-d') . ' ' . $selectedTimeSlot->start_time,
                        'status' => 'scheduled',
                        'notes' => 'Notes for appointment ' . $j,
                    ]);

                        // create a perscription for each appointment
                        Prescription::create([
                            'medical_file_id' => $medicalFile->id,
                            'doctor_id' => $doctorId,
                            'appointment_id' => $appointment->id,
                            'medications_names' => 'Medication A, Medication B',
                            'instructions' => 'Take as directed.',
                            'details' => 'Details for prescription.',
                        ]);

                }
            }


        }
    }
    }

