<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    public function run()
    {
        // Create doctor if not exists
        $doctorUser = User::where('email', 'doctor@hospital.com')->first();
        if ($doctorUser) {
            $doctor = Doctor::firstOrCreate(
                ['user_id' => $doctorUser->id],
                [
                    'specialty' => 'طبيب عام',
                    'phone' => '01234567890',
                    'license_number' => 'DOC123456',
                    'working_hours' => ['09:00-17:00'],
                    'bio' => 'طبيب متخصص في الطب العام',
                    'consultation_fee' => 100.00,
                    'is_available' => true
                ]
            );
        }

        // Create patient if not exists
        $patientUser = User::where('email', 'patient@hospital.com')->first();
        if ($patientUser && !Patient::where('user_id', $patientUser->id)->exists()) {
            Patient::create([
                'user_id' => $patientUser->id,
                'medical_record_number' => 'MR-' . Str::random(8),
                'phone' => '01234567891',
                'date_of_birth' => '1990-01-01',
                'gender' => 'male',
                'address' => '123 شارع المثال',
                'emergency_contact_name' => 'أحمد محمد',
                'emergency_contact_phone' => '01234567892',
                'emergency_contact' => '01234567892',
                'medical_history' => 'لا توجد أمراض مزمنة',
                'allergies' => 'لا توجد حساسية',
                'assigned_doctor_id' => $doctor->id ?? null
            ]);
        }

        // Create additional sample patients
        $samplePatients = [
            [
                'name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'phone' => '01234567893',
                'date_of_birth' => '1985-05-15',
                'gender' => 'male',
                'address' => '456 شارع النصر',
                'emergency_contact_name' => 'محمد أحمد',
                'emergency_contact_phone' => '01234567894',
                'emergency_contact' => '01234567894',
                'medical_history' => 'سكري من النوع الثاني',
                'allergies' => 'حساسية من البنسلين',
            ],
            [
                'name' => 'فاطمة علي',
                'email' => 'fatima@example.com',
                'phone' => '01234567895',
                'date_of_birth' => '1992-08-20',
                'gender' => 'female',
                'address' => '789 شارع السلام',
                'emergency_contact_name' => 'علي فاطمة',
                'emergency_contact_phone' => '01234567896',
                'emergency_contact' => '01234567896',
                'medical_history' => 'لا توجد أمراض مزمنة',
                'allergies' => 'لا توجد حساسية',
            ],
        ];

        foreach ($samplePatients as $patientData) {
            $user = User::firstOrCreate(
                ['email' => $patientData['email']],
                [
                    'name' => $patientData['name'],
                    'password' => bcrypt('password123'),
                    'email_verified_at' => now(),
                ]
            );

            if (!Patient::where('user_id', $user->id)->exists()) {
                Patient::create([
                    'user_id' => $user->id,
                    'medical_record_number' => 'MR-' . Str::random(8),
                    'phone' => $patientData['phone'],
                    'date_of_birth' => $patientData['date_of_birth'],
                    'gender' => $patientData['gender'],
                    'address' => $patientData['address'],
                    'emergency_contact_name' => $patientData['emergency_contact_name'],
                    'emergency_contact_phone' => $patientData['emergency_contact_phone'],
                    'emergency_contact' => $patientData['emergency_contact'],
                    'medical_history' => $patientData['medical_history'],
                    'allergies' => $patientData['allergies'],
                    'assigned_doctor_id' => $doctor->id ?? null
                ]);
            }
        }
    }
}
