<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\Bill;
use App\Models\BillService;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Admin');

        // Create doctor users
        $doctor1 = User::create([
            'name' => 'Dr. John Smith',
            'email' => 'john.smith@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $doctor1->assignRole('Doctor');

        $doctor2 = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $doctor2->assignRole('Doctor');

        // Create nurse user
        $nurse = User::create([
            'name' => 'Nurse Mary Wilson',
            'email' => 'mary.wilson@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $nurse->assignRole('Nurse');

        // Create receptionist user
        $receptionist = User::create([
            'name' => 'Receptionist Tom Brown',
            'email' => 'tom.brown@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $receptionist->assignRole('Receptionist');

        // Create doctor profiles
        Doctor::create([
            'user_id' => $doctor1->id,
            'specialty' => 'Cardiology',
            'phone' => '+1-555-0101',
            'license_number' => 'MD123456',
            'working_hours' => [
                'monday' => ['09:00', '17:00'],
                'tuesday' => ['09:00', '17:00'],
                'wednesday' => ['09:00', '17:00'],
                'thursday' => ['09:00', '17:00'],
                'friday' => ['09:00', '15:00'],
            ],
            'bio' => 'Experienced cardiologist with 15 years of practice.',
            'consultation_fee' => 150.00,
            'is_available' => true,
        ]);

        Doctor::create([
            'user_id' => $doctor2->id,
            'specialty' => 'Pediatrics',
            'phone' => '+1-555-0102',
            'license_number' => 'MD123457',
            'working_hours' => [
                'monday' => ['08:00', '16:00'],
                'tuesday' => ['08:00', '16:00'],
                'wednesday' => ['08:00', '16:00'],
                'thursday' => ['08:00', '16:00'],
                'friday' => ['08:00', '14:00'],
            ],
            'bio' => 'Pediatric specialist focused on child healthcare.',
            'consultation_fee' => 120.00,
            'is_available' => true,
        ]);

        // Create patient users and profiles
        $patient1 = User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice.johnson@email.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $patient1->assignRole('Patient');

        $patient2 = User::create([
            'name' => 'Bob Smith',
            'email' => 'bob.smith@email.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $patient2->assignRole('Patient');

        Patient::create([
            'user_id' => $patient1->id,
            'medical_record_number' => 'MR001',
            'date_of_birth' => '1985-03-15',
            'gender' => 'female',
            'phone' => '+1-555-0201',
            'address' => '123 Main St, City, State 12345',
            'emergency_contact_name' => 'John Johnson',
            'emergency_contact_phone' => '+1-555-0202',
            'medical_history' => 'No significant medical history',
            'allergies' => 'Penicillin',
        ]);

        Patient::create([
            'user_id' => $patient2->id,
            'medical_record_number' => 'MR002',
            'date_of_birth' => '1978-07-22',
            'gender' => 'male',
            'phone' => '+1-555-0203',
            'address' => '456 Oak Ave, City, State 12345',
            'emergency_contact_name' => 'Jane Smith',
            'emergency_contact_phone' => '+1-555-0204',
            'medical_history' => 'Hypertension, Diabetes Type 2',
            'allergies' => 'None known',
        ]);

        // Create services
        $services = [
            ['name' => 'General Consultation', 'description' => 'General medical consultation', 'price' => 100.00, 'category' => 'Consultation'],
            ['name' => 'Blood Test', 'description' => 'Complete blood count test', 'price' => 50.00, 'category' => 'Laboratory'],
            ['name' => 'X-Ray', 'description' => 'Chest X-ray examination', 'price' => 75.00, 'category' => 'Imaging'],
            ['name' => 'ECG', 'description' => 'Electrocardiogram test', 'price' => 60.00, 'category' => 'Cardiology'],
            ['name' => 'Ultrasound', 'description' => 'Abdominal ultrasound', 'price' => 120.00, 'category' => 'Imaging'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create appointments
        $appointments = [
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'appointment_date' => now()->addDays(1)->setTime(10, 0),
                'status' => 'scheduled',
                'reason' => 'Regular checkup',
                'fee' => 150.00,
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 2,
                'appointment_date' => now()->addDays(2)->setTime(14, 0),
                'status' => 'confirmed',
                'reason' => 'Follow-up visit',
                'fee' => 120.00,
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }

        // Create medical records
        $medicalRecords = [
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'appointment_id' => 1,
                'diagnosis' => 'Hypertension',
                'symptoms' => 'High blood pressure, headaches',
                'treatment_plan' => 'Medication and lifestyle changes',
                'vital_signs' => [
                    'blood_pressure' => '140/90',
                    'heart_rate' => '80',
                    'temperature' => '98.6',
                ],
                'visit_date' => now()->subDays(5),
            ],
        ];

        foreach ($medicalRecords as $record) {
            MedicalRecord::create($record);
        }

        // Create prescriptions
        $prescriptions = [
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'medical_record_id' => 1,
                'medicine_name' => 'Lisinopril',
                'dosage' => '10mg',
                'frequency' => 'Once daily',
                'quantity' => 30,
                'instructions' => 'Take with food in the morning',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(25),
                'is_active' => true,
            ],
        ];

        foreach ($prescriptions as $prescription) {
            Prescription::create($prescription);
        }

        // Create bills
        $bill1 = Bill::create([
            'patient_id' => 1,
            'bill_number' => 'BILL-001',
            'total_amount' => 200.00,
            'paid_amount' => 0.00,
            'balance' => 200.00,
            'status' => 'pending',
            'due_date' => now()->addDays(30),
            'notes' => 'Consultation and blood test',
        ]);

        // Create bill services
        BillService::create([
            'bill_id' => $bill1->id,
            'service_id' => 1, // General Consultation
            'quantity' => 1,
            'unit_price' => 100.00,
            'total_price' => 100.00,
        ]);

        BillService::create([
            'bill_id' => $bill1->id,
            'service_id' => 2, // Blood Test
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_price' => 50.00,
        ]);
    }
}
