<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Bill;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of salaries.
     */
    public function index()
    {
        Gate::authorize('view salaries');
        
        // Get doctors with their salary information
        $doctors = Doctor::with(['user', 'clinic'])
            ->withCount(['appointments'])
            ->get()
            ->map(function ($doctor) {
                // Calculate total payments for this doctor from completed appointments
                $totalPayments = $doctor->appointments()
                    ->where('status', 'completed')
                    ->sum('fee');
                
                // Calculate doctor's salary (assuming 70% of total payments)
                $doctorSalary = $totalPayments * 0.7;
                
                // Calculate clinic's share (30% of total payments)
                $clinicShare = $totalPayments * 0.3;
                
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->user->name,
                    'email' => $doctor->user->email,
                    'phone' => $doctor->phone,
                    'clinic_name' => $doctor->clinic->name,
                    'consultation_fee' => $doctor->consultation_fee,
                    'appointments_count' => $doctor->appointments_count,
                    'total_payments' => $totalPayments,
                    'doctor_salary' => $doctorSalary,
                    'clinic_share' => $clinicShare,
                    'is_available' => $doctor->is_available,
                ];
            });
        
        // Calculate totals
        $totalPayments = $doctors->sum('total_payments');
        $totalDoctorSalaries = $doctors->sum('doctor_salary');
        $totalClinicShare = $doctors->sum('clinic_share');
        
        return view('salaries.index', compact('doctors', 'totalPayments', 'totalDoctorSalaries', 'totalClinicShare'));
    }
}