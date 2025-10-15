<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Clinic;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get statistics based on user role
        if ($user->isAdmin()) {
            $stats = $this->getAdminStats();
        } elseif ($user->isDoctor()) {
            $stats = $this->getDoctorStats($user);
        } elseif ($user->isNurse()) {
            $stats = $this->getNurseStats();
        } elseif ($user->isReceptionist()) {
            $stats = $this->getReceptionistStats();
        } elseif ($user->isPatient()) {
            $stats = $this->getPatientStats($user);
        } else {
            $stats = [];
        }

        return view('dashboard', compact('stats'));
    }

    private function getAdminStats()
    {
        return [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_clinics' => Clinic::count(),
            'active_clinics' => Clinic::where('is_active', true)->count(),
            'total_appointments' => Appointment::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')->count(),
            'total_revenue' => Bill::sum('total_amount'),
            'monthly_revenue' => Bill::whereMonth('created_at', now()->month)->sum('total_amount'),
            'recent_appointments' => Appointment::with(['patient', 'doctor', 'clinic'])
                ->orderBy('appointment_date', 'desc')
                ->limit(5)
                ->get(),
            'recent_bills' => Bill::with('patient')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'clinics_stats' => Clinic::withCount(['doctors', 'appointments'])
                ->orderBy('appointments_count', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    private function getDoctorStats($user)
    {
        $doctor = $user->doctor;
        
        return [
            'my_appointments' => Appointment::where('doctor_id', $doctor->id)->count(),
            'today_appointments' => Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', today())
                ->count(),
            'pending_appointments' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'scheduled')
                ->count(),
            'my_patients' => Patient::whereHas('appointments', function($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })->count(),
            'my_clinic' => $doctor->clinic,
            'recent_appointments' => Appointment::with(['patient', 'doctor', 'clinic'])
                ->where('doctor_id', $doctor->id)
                ->orderBy('appointment_date', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    private function getNurseStats()
    {
        return [
            'total_patients' => Patient::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'recent_appointments' => Appointment::with(['patient', 'doctor'])
                ->orderBy('appointment_date', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    private function getReceptionistStats()
    {
        return [
            'total_patients' => Patient::count(),
            'total_appointments' => Appointment::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')->count(),
            'total_bills' => Bill::count(),
            'pending_bills' => Bill::where('status', 'pending')->count(),
            'recent_appointments' => Appointment::with(['patient', 'doctor'])
                ->orderBy('appointment_date', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    private function getPatientStats($user)
    {
        $patient = $user->patient;
        
        return [
            'my_appointments' => Appointment::where('patient_id', $patient->id)->count(),
            'upcoming_appointments' => Appointment::where('patient_id', $patient->id)
                ->where('appointment_date', '>', now())
                ->whereIn('status', ['scheduled', 'confirmed'])
                ->count(),
            'my_prescriptions' => $patient->prescriptions()->where('is_active', true)->count(),
            'my_bills' => Bill::where('patient_id', $patient->id)->count(),
            'recent_appointments' => Appointment::with(['patient', 'doctor'])
                ->where('patient_id', $patient->id)
                ->orderBy('appointment_date', 'desc')
                ->limit(5)
                ->get(),
        ];
    }
}
