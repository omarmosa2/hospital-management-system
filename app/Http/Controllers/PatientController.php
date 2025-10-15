<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Bill;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view patients');
        
        $patients = Patient::with(['user', 'assignedDoctor.user'])
            ->withCount(['appointments', 'bills'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        // Get statistics
        $stats = [
            'total_patients' => Patient::count(),
            'male_patients' => Patient::where('gender', 'male')->count(),
            'female_patients' => Patient::where('gender', 'female')->count(),
            'total_appointments' => Appointment::count(),
            'total_bills' => Bill::count(),
            'recent_patients' => Patient::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];
        
        return view('patients.index', compact('patients', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Admin cannot create patients - only receptionist can
        if (auth()->user()->isAdmin()) {
            abort(403, 'الأدمن لا يمكنه إضافة مرضى جدد');
        }
        
        Gate::authorize('create patients');
        
        $doctors = Doctor::with('user')->get();
        return view('patients.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Admin cannot create patients - only receptionist can
        if (auth()->user()->isAdmin()) {
            abort(403, 'الأدمن لا يمكنه إضافة مرضى جدد');
        }
        
        Gate::authorize('create patients');
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string|max:500',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'assigned_doctor_id' => 'nullable|exists:doctors,id',
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => 'patient_' . time() . '@hospital.local', // Generate unique email
            'password' => bcrypt('password123'), // Default password
            'email_verified_at' => now(),
        ]);

        // Create patient record
        $patient = Patient::create([
            'user_id' => $user->id,
            'medical_record_number' => 'MR-' . Str::random(8),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'emergency_contact' => $request->emergency_contact_name . ' - ' . $request->emergency_contact_phone,
            'medical_history' => $request->medical_history,
            'allergies' => $request->allergies,
            'assigned_doctor_id' => $request->assigned_doctor_id,
        ]);

        return redirect()->route('patients.index')
            ->with('success', 'تم إنشاء المريض بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load(['user', 'assignedDoctor.user', 'appointments.doctor.user']);
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        Gate::authorize('edit patients');
        
        $doctors = Doctor::with('user')->get();
        $patient->load('user');
        return view('patients.edit', compact('patient', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        Gate::authorize('edit patients');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string|max:500',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'assigned_doctor_id' => 'nullable|exists:doctors,id',
        ]);

        // Update user account
        $patient->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update patient record
        $patient->update([
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'emergency_contact' => $request->emergency_contact_name . ' - ' . $request->emergency_contact_phone,
            'medical_history' => $request->medical_history,
            'allergies' => $request->allergies,
            'assigned_doctor_id' => $request->assigned_doctor_id,
        ]);

        return redirect()->route('patients.index')
            ->with('success', 'تم تحديث المريض بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        Gate::authorize('delete patients');
        
        // Check if patient has appointments or bills
        if ($patient->appointments()->count() > 0 || $patient->bills()->count() > 0) {
            return redirect()->route('patients.index')
                ->with('error', 'لا يمكن حذف المريض لوجود مواعيد أو فواتير مرتبطة به');
        }
        
        $patient->user->delete();
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'تم حذف المريض بنجاح.');
    }
}
