<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@hospital.com'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]
        );
        $admin->assignRole('Admin');
        echo "تم إنشاء/تحديث حساب الأدمن بنجاح\n";
        echo "البريد الإلكتروني: admin@hospital.com\n";
        echo "كلمة المرور: password123\n\n";

        // Create or update doctor user
        $doctor = User::updateOrCreate(
            ['email' => 'doctor@hospital.com'],
            [
                'name' => 'د. أحمد محمد',
                'password' => Hash::make('doctor123'),
                'is_active' => true,
            ]
        );
        $doctor->assignRole('Doctor');
        echo "تم إنشاء/تحديث حساب الطبيب بنجاح\n";
        echo "البريد الإلكتروني: doctor@hospital.com\n";
        echo "كلمة المرور: doctor123\n\n";

        // Create or update receptionist user
        $receptionist = User::updateOrCreate(
            ['email' => 'reception@hospital.com'],
            [
                'name' => 'موظف استقبال',
                'password' => Hash::make('reception123'),
                'is_active' => true,
            ]
        );
        $receptionist->assignRole('Receptionist');
        echo "تم إنشاء/تحديث حساب موظف الاستقبال بنجاح\n";
        echo "البريد الإلكتروني: reception@hospital.com\n";
        echo "كلمة المرور: reception123\n\n";

        echo "=== جميع الحسابات تم إنشاؤها بنجاح ===\n";
    }
}