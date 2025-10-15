<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();

        if ($patients->isEmpty() || $doctors->isEmpty()) {
            $this->command->info('لا توجد بيانات للمرضى أو الأطباء. يرجى تشغيل PatientSeeder أولاً.');
            return;
        }

        $appointments = [
            [
                'patient_id' => $patients->first()->id,
                'doctor_id' => $doctors->first()->id,
                'appointment_date' => Carbon::tomorrow()->format('Y-m-d'),
                'appointment_time' => '09:00',
                'reason' => 'فحص دوري',
                'notes' => 'فحص شامل للجسم',
                'status' => 'scheduled',
                'fee' => 100.00,
            ],
            [
                'patient_id' => $patients->skip(1)->first()?->id ?? $patients->first()->id,
                'doctor_id' => $doctors->first()->id,
                'appointment_date' => Carbon::tomorrow()->addDay()->format('Y-m-d'),
                'appointment_time' => '10:30',
                'reason' => 'متابعة علاج',
                'notes' => 'متابعة حالة السكري',
                'status' => 'confirmed',
                'fee' => 80.00,
            ],
            [
                'patient_id' => $patients->last()->id,
                'doctor_id' => $doctors->first()->id,
                'appointment_date' => Carbon::today()->format('Y-m-d'),
                'appointment_time' => '14:00',
                'reason' => 'استشارة طبية',
                'notes' => 'استشارة حول الحساسية',
                'status' => 'completed',
                'fee' => 120.00,
            ],
            [
                'patient_id' => $patients->first()->id,
                'doctor_id' => $doctors->first()->id,
                'appointment_date' => Carbon::yesterday()->format('Y-m-d'),
                'appointment_time' => '11:00',
                'reason' => 'فحص طارئ',
                'notes' => 'شكوى من ألم في الصدر',
                'status' => 'completed',
                'fee' => 150.00,
            ],
            [
                'patient_id' => $patients->skip(1)->first()?->id ?? $patients->first()->id,
                'doctor_id' => $doctors->first()->id,
                'appointment_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'appointment_time' => '16:00',
                'reason' => 'فحص مختبر',
                'notes' => 'مراجعة نتائج التحاليل',
                'status' => 'scheduled',
                'fee' => 60.00,
            ],
        ];

        foreach ($appointments as $appointmentData) {
            Appointment::create($appointmentData);
        }

        $this->command->info('تم إنشاء ' . count($appointments) . ' موعد تجريبي.');
    }
}
