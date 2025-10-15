<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign roles to test users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor']);
        $patientRole = Role::firstOrCreate(['name' => 'Patient']);

        // Assign roles to users
        $admin = User::where('email', 'admin@hospital.com')->first();
        if ($admin) {
            $admin->assignRole($adminRole);
            $this->info('Admin role assigned to admin@hospital.com');
        }

        $doctor = User::where('email', 'doctor@hospital.com')->first();
        if ($doctor) {
            $doctor->assignRole($doctorRole);
            $this->info('Doctor role assigned to doctor@hospital.com');
        }

        $patient = User::where('email', 'patient@hospital.com')->first();
        if ($patient) {
            $patient->assignRole($patientRole);
            $this->info('Patient role assigned to patient@hospital.com');
        }

        $this->info('Roles assigned successfully!');
    }
}
