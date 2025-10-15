<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'clinic_id',
        'phone',
        'working_hours',
        'bio',
        'consultation_fee',
        'is_available',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'consultation_fee' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Get the user that owns the doctor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the clinic that owns the doctor.
     */
    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    /**
     * Get the appointments for the doctor.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the medical records for the doctor.
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * Get the prescriptions for the doctor.
     */
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    /**
     * Get the patients assigned to this doctor.
     */
    public function assignedPatients(): HasMany
    {
        return $this->hasMany(Patient::class, 'assigned_doctor_id');
    }
}
