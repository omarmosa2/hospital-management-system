<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of patient files.
     */
    public function index()
    {
        Gate::authorize('view patient files');
        
        $patients = Patient::with(['user', 'appointments.doctor.user', 'appointments.clinic', 'medicalRecords', 'prescriptions'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('patient-files.index', compact('patients'));
    }

    /**
     * Display the specified patient file.
     */
    public function show(Patient $patient)
    {
        Gate::authorize('view patient files');
        
        $patient->load([
            'user',
            'appointments.doctor.user',
            'appointments.clinic',
            'medicalRecords',
            'prescriptions.medications'
        ]);
        
        return view('patient-files.show', compact('patient'));
    }

    /**
     * Generate PDF for patient file.
     */
    public function generatePdf(Patient $patient)
    {
        Gate::authorize('view patient files');
        
        $patient->load([
            'user',
            'appointments.doctor.user',
            'appointments.clinic',
            'medicalRecords',
            'prescriptions.medications'
        ]);
        
        $pdf = Pdf::loadView('patient-files.pdf', compact('patient'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('patient-file-' . $patient->medical_record_number . '.pdf');
    }

    /**
     * Print patient file.
     */
    public function print(Patient $patient)
    {
        Gate::authorize('view patient files');
        
        $patient->load([
            'user',
            'appointments.doctor.user',
            'appointments.clinic',
            'medicalRecords',
            'prescriptions.medications'
        ]);
        
        return view('patient-files.print', compact('patient'));
    }
}