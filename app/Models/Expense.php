<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'expense_number',
        'title',
        'description',
        'category',
        'amount',
        'payment_method',
        'status',
        'expense_date',
        'due_date',
        'vendor',
        'reference_number',
        'notes',
        'approved_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
        'due_date' => 'date',
    ];

    /**
     * Get the user who approved this expense.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the category name.
     */
    public function getCategoryNameAttribute(): string
    {
        return __($this->category);
    }

    /**
     * Get the status name.
     */
    public function getStatusNameAttribute(): string
    {
        return __($this->status);
    }

    /**
     * Get the payment method name.
     */
    public function getPaymentMethodNameAttribute(): string
    {
        return __($this->payment_method);
    }
}
