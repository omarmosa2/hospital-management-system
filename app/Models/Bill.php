<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bill extends Model
{
    protected $fillable = [
        'patient_id',
        'bill_number',
        'total_amount',
        'paid_amount',
        'balance',
        'status',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'due_date' => 'date',
    ];

    /**
     * Get the patient that owns the bill.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the services for the bill.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'bill_services')
                    ->withPivot('quantity', 'unit_price', 'total_price')
                    ->withTimestamps();
    }

    /**
     * Get the bill services for the bill.
     */
    public function billServices()
    {
        return $this->hasMany(BillService::class);
    }

    /**
     * Calculate the balance amount.
     */
    public function calculateBalance(): float
    {
        return $this->total_amount - $this->paid_amount;
    }

    /**
     * Check if the bill is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date < now() && $this->status !== 'paid';
    }
}
