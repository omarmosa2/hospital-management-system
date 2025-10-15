<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Clinic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Build query based on user role
        $query = Appointment::with(['patient.user', 'doctor.user', 'clinic']);
        
        if ($user->isDoctor()) {
            // Doctors only see their own appointments
            $query->where('doctor_id', $user->doctor->id);
        }
        // Receptionists and other roles can see all appointments
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('patient.user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('doctor.user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('reason', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }
        
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }
        
        // Order and paginate
        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(15);
        
        // Get statistics
        $stats = [
            'total_appointments' => Appointment::count(),
            'scheduled_appointments' => Appointment::where('status', 'scheduled')->count(),
            'confirmed_appointments' => Appointment::where('status', 'confirmed')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'cancelled_appointments' => Appointment::where('status', 'cancelled')->count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'this_week_appointments' => Appointment::whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month_appointments' => Appointment::whereMonth('appointment_date', now()->month)->count(),
        ];
        
        // Get doctors for filter dropdown
        $doctors = Doctor::with('user')->where('is_available', true)->get();
        
        return view('appointments.index', compact('appointments', 'stats', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create appointments');
        
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with(['user', 'clinic'])->where('is_available', true)->get();
        $clinics = Clinic::where('is_active', true)->get();
        return view('appointments.create', compact('patients', 'doctors', 'clinics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create appointments');
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'clinic_id' => 'required|exists:clinics,id',
            'appointment_date' => 'required|date|after:now',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Verify doctor belongs to selected clinic
        $doctor = Doctor::find($request->doctor_id);
        if ($doctor->clinic_id != $request->clinic_id) {
            return back()->withErrors(['doctor_id' => 'الطبيب المحدد لا يعمل في العيادة المختارة.']);
        }

        // Check for time conflicts
        $conflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($conflict) {
            return back()->withErrors(['appointment_time' => 'هذا الوقت محجوز بالفعل للطبيب المحدد.']);
        }

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'clinic_id' => $request->clinic_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'تم إنشاء الموعد بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user']);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $appointment->load(['patient.user', 'doctor.user']);
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled',
        ]);

        // Check for time conflicts (excluding current appointment)
        $conflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'cancelled')
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($conflict) {
            return back()->withErrors(['appointment_time' => 'هذا الوقت محجوز بالفعل للطبيب المحدد.']);
        }

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'تم تحديث الموعد بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'تم حذف الموعد بنجاح.');
    }

    /**
     * Confirm an appointment
     */
    public function confirm(Appointment $appointment)
    {
        $appointment->update(['status' => 'confirmed']);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'تم تأكيد الموعد بنجاح.');
    }

    /**
     * Complete an appointment
     */
    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'تم إكمال الموعد بنجاح.');
    }
}
