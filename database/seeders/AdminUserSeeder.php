<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password123'),
        ]);

        $admin->assignRole('Admin');

        echo "تم إنشاء حساب الأدمن بنجاح\n";
        echo "البريد الإلكتروني: admin@hospital.com\n";
        echo "كلمة المرور: password123\n";
    }
}