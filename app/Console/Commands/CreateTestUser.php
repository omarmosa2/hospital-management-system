<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for login';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@hospital.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create doctor user
        $doctor = User::firstOrCreate(
            ['email' => 'doctor@hospital.com'],
            [
                'name' => 'Dr. Test Doctor',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create patient user
        $patient = User::firstOrCreate(
            ['email' => 'patient@hospital.com'],
            [
                'name' => 'Test Patient',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->info('Test users created successfully!');
        $this->line('Admin: admin@hospital.com / password');
        $this->line('Doctor: doctor@hospital.com / password');
        $this->line('Patient: patient@hospital.com / password');
    }
}