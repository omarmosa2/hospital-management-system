<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clinic;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = [
            [
                'name' => 'عيادة القلب',
                'description' => 'عيادة متخصصة في أمراض القلب والشرايين',
                'location' => 'الطابق الأول - الجناح الشمالي',
                'phone' => '0112345678',
                'email' => 'cardiology@hospital.com',
                'is_active' => true,
            ],
            [
                'name' => 'عيادة الأطفال',
                'description' => 'عيادة متخصصة في طب الأطفال والرضع',
                'location' => 'الطابق الثاني - الجناح الشرقي',
                'phone' => '0112345679',
                'email' => 'pediatrics@hospital.com',
                'is_active' => true,
            ],
            [
                'name' => 'عيادة العظام',
                'description' => 'عيادة متخصصة في جراحة العظام والمفاصل',
                'location' => 'الطابق الأول - الجناح الجنوبي',
                'phone' => '0112345680',
                'email' => 'orthopedics@hospital.com',
                'is_active' => true,
            ],
            [
                'name' => 'عيادة العيون',
                'description' => 'عيادة متخصصة في طب وجراحة العيون',
                'location' => 'الطابق الثالث - الجناح الغربي',
                'phone' => '0112345681',
                'email' => 'ophthalmology@hospital.com',
                'is_active' => true,
            ],
            [
                'name' => 'عيادة الجلدية',
                'description' => 'عيادة متخصصة في الأمراض الجلدية والتناسلية',
                'location' => 'الطابق الثاني - الجناح الجنوبي',
                'phone' => '0112345682',
                'email' => 'dermatology@hospital.com',
                'is_active' => true,
            ],
            [
                'name' => 'عيادة النساء والولادة',
                'description' => 'عيادة متخصصة في طب النساء والولادة',
                'location' => 'الطابق الثالث - الجناح الشرقي',
                'phone' => '0112345683',
                'email' => 'gynecology@hospital.com',
                'is_active' => true,
            ],
            [
                'name' => 'عيادة الأنف والأذن والحنجرة',
                'description' => 'عيادة متخصصة في أمراض الأنف والأذن والحنجرة',
                'location' => 'الطابق الثاني - الجناح الغربي',
                'phone' => '0112345684',
                'email' => 'ent@hospital.com',
                'is_active' => true,
            ],
            [
                'name' => 'عيادة الطب الباطني',
                'description' => 'عيادة متخصصة في الطب الباطني والأمراض الداخلية',
                'location' => 'الطابق الأول - الجناح الشرقي',
                'phone' => '0112345685',
                'email' => 'internal@hospital.com',
                'is_active' => true,
            ],
        ];

        foreach ($clinics as $clinic) {
            Clinic::create($clinic);
        }
    }
}
