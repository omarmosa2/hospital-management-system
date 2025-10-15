<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Clinic;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class DoctorController extends Controller
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
        Gate::authorize('view doctors');
        
        $user = auth()->user();
        
        if ($user->isReceptionist()) {
            // For receptionist, show only doctors who have appointments today
            $doctors = Doctor::whereHas('appointments', function($query) {
                $query->whereDate('appointment_date', today());
            })
            ->with(['user', 'clinic'])
            ->paginate(10);
        } else {
            // For other roles, show all doctors
            $doctors = Doctor::with(['user', 'clinic'])->paginate(10);
        }
        
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create doctors');
        
        $clinics = Clinic::where('is_active', true)->get();
        return view('doctors.create', compact('clinics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create doctors');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'clinic_id' => 'required|exists:clinics,id',
            'phone' => 'required|string|max:20',
            'consultation_fee' => 'required|numeric|min:0',
            'working_hours' => 'nullable|array',
            'working_hours.*.enabled' => 'boolean',
            'working_hours.*.start' => 'nullable|date_format:H:i',
            'working_hours.*.end' => 'nullable|date_format:H:i',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Doctor');

        // Process working hours - only include enabled days
        $workingHours = [];
        if ($request->working_hours) {
            foreach ($request->working_hours as $index => $day) {
                if (isset($day['enabled']) && $day['enabled']) {
                    $workingHours[$index] = [
                        'enabled' => true,
                        'start' => $day['start'] ?? '09:00',
                        'end' => $day['end'] ?? '17:00',
                    ];
                } else {
                    $workingHours[$index] = [
                        'enabled' => false,
                        'start' => null,
                        'end' => null,
                    ];
                }
            }
        }

        Doctor::create([
            'user_id' => $user->id,
            'clinic_id' => $request->clinic_id,
            'phone' => $request->phone,
            'working_hours' => $workingHours,
            'consultation_fee' => $request->consultation_fee,
            'is_available' => true,
        ]);

        return redirect()->route('doctors.index')
            ->with('success', 'تم إنشاء الطبيب بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $doctor->load('user', 'appointments.patient', 'medicalRecords.patient');
        return view('doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        Gate::authorize('edit doctors');
        
        $doctor->load('user');
        $clinics = Clinic::where('is_active', true)->get();
        return view('doctors.edit', compact('doctor', 'clinics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        Gate::authorize('edit doctors');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $doctor->user_id,
            'clinic_id' => 'required|exists:clinics,id',
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|max:50|unique:doctors,license_number,' . $doctor->id,
            'consultation_fee' => 'required|numeric|min:0',
            'bio' => 'nullable|string',
            'working_hours' => 'nullable|array',
            'working_hours.*.enabled' => 'boolean',
            'working_hours.*.start' => 'nullable|date_format:H:i',
            'working_hours.*.end' => 'nullable|date_format:H:i',
        ]);

        $doctor->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Process working hours - only include enabled days
        $workingHours = $doctor->working_hours ?? [];
        if ($request->working_hours) {
            foreach ($request->working_hours as $index => $day) {
                if (isset($day['enabled']) && $day['enabled']) {
                    $workingHours[$index] = [
                        'enabled' => true,
                        'start' => $day['start'] ?? '09:00',
                        'end' => $day['end'] ?? '17:00',
                    ];
                } else {
                    $workingHours[$index] = [
                        'enabled' => false,
                        'start' => null,
                        'end' => null,
                    ];
                }
            }
        }

        $doctor->update([
            'clinic_id' => $request->clinic_id,
            'phone' => $request->phone,
            'license_number' => $request->license_number,
            'working_hours' => $workingHours,
            'bio' => $request->bio,
            'consultation_fee' => $request->consultation_fee,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('doctors.index')
            ->with('success', 'تم تحديث الطبيب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        Gate::authorize('delete doctors');
        
        $doctor->user->delete();
        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with('success', 'تم حذف الطبيب بنجاح');
    }

    /**
     * Get doctor's consultation fee
     */
    public function getFee(Doctor $doctor)
    {
        return response()->json(['fee' => $doctor->consultation_fee]);
    }

    /**
     * Get clinic's working hours
     */
    public function getClinicWorkingHours(Clinic $clinic)
    {
        return response()->json(['working_hours' => $clinic->working_hours ?? []]);
    }
}
