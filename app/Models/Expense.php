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
     * Get the category name in Arabic.
     */
    public function getCategoryNameAttribute(): string
    {
        $categories = [
            'equipment' => 'معدات',
            'medicines' => 'أدوية',
            'utilities' => 'مرافق',
            'maintenance' => 'صيانة',
            'staff' => 'موظفين',
            'supplies' => 'مستلزمات',
            'other' => 'أخرى',
        ];

        return $categories[$this->category] ?? $this->category;
    }

    /**
     * Get the status name in Arabic.
     */
    public function getStatusNameAttribute(): string
    {
        $statuses = [
            'pending' => 'معلق',
            'approved' => 'موافق عليه',
            'paid' => 'مدفوع',
            'rejected' => 'مرفوض',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get the payment method name in Arabic.
     */
    public function getPaymentMethodNameAttribute(): string
    {
        $methods = [
            'cash' => 'نقداً',
            'card' => 'بطاقة ائتمان',
            'bank_transfer' => 'تحويل بنكي',
            'check' => 'شيك',
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }
}
