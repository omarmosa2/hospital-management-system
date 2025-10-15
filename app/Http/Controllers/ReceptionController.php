<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReceptionController extends Controller
{
    /**
     * Display a listing of clinics for reception.
     */
    public function clinicsIndex(Request $request)
    {
        Gate::authorize('view clinics');
        
        $query = Clinic::withCount(['doctors', 'appointments'])
            ->orderBy('name');
        
        $clinics = $query->paginate(12);
        
        return view('reception.clinics.index', compact('clinics'));
    }

    /**
     * Display the specified clinic for reception.
     */
    public function clinicsShow(Clinic $clinic)
    {
        Gate::authorize('view clinics');
        
        $clinic->load(['doctors.user', 'appointments.patient.user']);
        $clinic->loadCount(['doctors', 'appointments']);
        
        return view('reception.clinics.show', compact('clinic'));
    }

    /**
     * Display a listing of doctors for reception.
     */
    public function doctorsIndex(Request $request)
    {
        Gate::authorize('view doctors');
        
        $query = Doctor::with(['user', 'clinic'])
            ->orderBy('created_at', 'desc');
        
        // Filter by clinic if specified
        if ($request->filled('clinic_id')) {
            $query->where('clinic_id', $request->clinic_id);
        }
        
        $doctors = $query->paginate(12);
        $clinics = Clinic::where('is_active', true)->orderBy('name')->get();
        
        return view('reception.doctors.index', compact('doctors', 'clinics'));
    }

    /**
     * Display the specified doctor for reception.
     */
    public function doctorsShow(Doctor $doctor)
    {
        Gate::authorize('view doctors');
        
        $doctor->load(['user', 'clinic', 'appointments.patient.user', 'medicalRecords']);
        $doctor->loadCount(['appointments', 'medicalRecords']);
        
        return view('reception.doctors.show', compact('doctor'));
    }
}
