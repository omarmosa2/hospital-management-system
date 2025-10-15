<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Clinic management
            'view clinics',
            'create clinics',
            'edit clinics',
            'delete clinics',
            
            // Doctor management
            'view doctors',
            'create doctors',
            'edit doctors',
            'delete doctors',
            
            // Patient management
            'view patients',
            'create patients',
            'edit patients',
            'delete patients',
            
            // Appointment management
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',
            'confirm appointments',
            
            // Medical records
            'view medical records',
            'create medical records',
            'edit medical records',
            'delete medical records',
            
            // Prescriptions
            'view prescriptions',
            'create prescriptions',
            'edit prescriptions',
            'delete prescriptions',
            
            // Expenses
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',
            'approve expenses',
            
            // Services
            'view services',
            'create services',
            'edit services',
            'delete services',
            
            // Reports
            'view reports',
            'generate reports',
            
            // Salaries
            'view salaries',
            
            // Account Management
            'manage accounts',
            
            // Patient Files
            'view patient files',
            
            // Dashboard
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions([
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view clinics',
            'create clinics',
            'edit clinics',
            'delete clinics',
            'view doctors',
            'create doctors',
            'edit doctors',
            'delete doctors',
            'view patients',
            'edit patients',
            'delete patients',
            'view appointments',
            'edit appointments',
            'delete appointments',
            'confirm appointments',
            'view medical records',
            'create medical records',
            'edit medical records',
            'delete medical records',
            'view prescriptions',
            'create prescriptions',
            'edit prescriptions',
            'delete prescriptions',
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',
            'approve expenses',
            'view services',
            'create services',
            'edit services',
            'delete services',
            'view reports',
            'generate reports',
            'view salaries',
            'manage accounts',
            'view patient files',
            'view dashboard',
        ]);

        $doctorRole = Role::firstOrCreate(['name' => 'Doctor']);
        $doctorRole->syncPermissions([
            'view patients',
            'view appointments',
            'create appointments',
            'edit appointments',
            'confirm appointments',
            'view medical records',
            'create medical records',
            'edit medical records',
            'view prescriptions',
            'create prescriptions',
            'edit prescriptions',
            'view dashboard',
        ]);

        $nurseRole = Role::firstOrCreate(['name' => 'Nurse']);
        $nurseRole->syncPermissions([
            'view patients',
            'view appointments',
            'view medical records',
            'view prescriptions',
            'view dashboard',
        ]);

        $receptionistRole = Role::firstOrCreate(['name' => 'Receptionist']);
        $receptionistRole->syncPermissions([
            'view patients',
            'create patients',
            'edit patients',
            'view appointments',
            'create appointments',
            'edit appointments',
            'view bills',
            'create bills',
            'edit bills',
            'process payments',
            'view services',
            'view clinics',
            'view doctors',
            'view patient files',
            'view dashboard',
        ]);

        $patientRole = Role::firstOrCreate(['name' => 'Patient']);
        $patientRole->syncPermissions([
            'view appointments',
            'view medical records',
            'view prescriptions',
            'view bills',
        ]);
    }
}
