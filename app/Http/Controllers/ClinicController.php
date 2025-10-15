<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinic;
use Illuminate\Support\Facades\Gate;

class ClinicController extends Controller
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
        Gate::authorize('view clinics');
        
        $user = auth()->user();
        
        if ($user->isReceptionist()) {
            // For receptionist, show only clinics that have appointments today
            $clinics = Clinic::whereHas('appointments', function($query) {
                $query->whereDate('appointment_date', today());
            })
            ->withCount(['doctors', 'appointments'])
            ->orderBy('name')
            ->paginate(12);
        } else {
            // For other roles, show all clinics
            $clinics = Clinic::withCount(['doctors', 'appointments'])
                ->orderBy('name')
                ->paginate(12);
        }
            
        return view('clinics.index', compact('clinics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create clinics');
        
        return view('clinics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create clinics');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'working_hours' => 'nullable|array',
            'working_hours.*.enabled' => 'boolean',
            'working_hours.*.start' => 'nullable|date_format:H:i',
            'working_hours.*.end' => 'nullable|date_format:H:i',
        ]);

        $clinicData = $request->all();
        
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
        
        $clinicData['working_hours'] = $workingHours;
        $clinicData['is_active'] = true;

        Clinic::create($clinicData);

        return redirect()->route('clinics.index')
            ->with('success', 'تم إنشاء العيادة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clinic $clinic)
    {
        Gate::authorize('view clinics');
        
        $clinic->load(['doctors.user', 'appointments.patient', 'appointments.doctor.user']);
        
        return view('clinics.show', compact('clinic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clinic $clinic)
    {
        Gate::authorize('edit clinics');
        
        return view('clinics.edit', compact('clinic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clinic $clinic)
    {
        Gate::authorize('edit clinics');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
            'working_hours' => 'nullable|array',
            'working_hours.*.enabled' => 'boolean',
            'working_hours.*.start' => 'nullable|date_format:H:i',
            'working_hours.*.end' => 'nullable|date_format:H:i',
        ]);

        $clinicData = $request->all();
        
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
        
        $clinicData['working_hours'] = $workingHours;
        $clinic->update($clinicData);

        return redirect()->route('clinics.index')
            ->with('success', 'تم تحديث العيادة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clinic $clinic)
    {
        Gate::authorize('delete clinics');
        
        // Check if clinic has doctors or appointments
        if ($clinic->doctors()->count() > 0 || $clinic->appointments()->count() > 0) {
            return redirect()->route('clinics.index')
                ->with('error', 'لا يمكن حذف العيادة لوجود أطباء أو مواعيد مرتبطة بها');
        }

        $clinic->delete();

        return redirect()->route('clinics.index')
            ->with('success', 'تم حذف العيادة بنجاح');
    }
}
