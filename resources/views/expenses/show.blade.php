@extends('layouts.app')

@section('title', 'تفاصيل المصروف')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">تفاصيل المصروف</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">رقم المصروف: {{ $expense->expense_number }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('expenses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                رجوع للمصروفات
            </a>
        </div>
    </div>

    <!-- Expense Details -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 border-b border-gray-200 dark:border-slate-700 pb-2">المعلومات الأساسية</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">العنوان</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-slate-100">{{ $expense->title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">الوصف</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-slate-100">{{ $expense->description ?? 'لا يوجد وصف' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">الفئة</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                            {{ $expense->category_name }}
                        </span>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 border-b border-gray-200 dark:border-slate-700 pb-2">المعلومات المالية</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">المبلغ</label>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-slate-100">${{ number_format($expense->amount, 2) }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">طريقة الدفع</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-slate-100">{{ $expense->payment_method_name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">الحالة</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($expense->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                            @elseif($expense->status == 'approved') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                            @elseif($expense->status == 'paid') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                            @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                            @endif">
                            {{ $expense->status_name }}
                        </span>
                    </div>
                </div>

                <!-- Dates and Vendor -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 border-b border-gray-200 dark:border-slate-700 pb-2">التواريخ والمورد</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">تاريخ المصروف</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-slate-100">{{ $expense->expense_date->format('d/m/Y') }}</p>
                    </div>

                    @if($expense->due_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">تاريخ الاستحقاق</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-slate-100">{{ $expense->due_date->format('d/m/Y') }}</p>
                    </div>
                    @endif

                    @if($expense->vendor)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">المورد</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-slate-100">{{ $expense->vendor }}</p>
                    </div>
                    @endif

                    @if($expense->reference_number)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">رقم المرجع</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-slate-100">{{ $expense->reference_number }}</p>
                    </div>
                    @endif
                </div>

                <!-- Additional Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 border-b border-gray-200 dark:border-slate-700 pb-2">معلومات إضافية</h3>

                    @if($expense->approver)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">تمت الموافقة من قبل</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-slate-100">{{ $expense->approver->name }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">تاريخ الإنشاء</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-slate-100">{{ $expense->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">آخر تحديث</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $expense->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    @if($expense->notes)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ملاحظات</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $expense->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('expenses.edit', $expense) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    تعديل
                </a>
                
                @if($expense->status == 'pending')
                    <form action="{{ route('expenses.approve', $expense) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                            <i class="fas fa-check mr-2"></i>
                            موافقة
                        </button>
                    </form>
                    
                    <form action="{{ route('expenses.reject', $expense) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            رفض
                        </button>
                    </form>
                @elseif($expense->status == 'approved')
                    <form action="{{ route('expenses.markPaid', $expense) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                            <i class="fas fa-credit-card mr-2"></i>
                            تسجيل الدفع
                        </button>
                    </form>
                @endif
                
                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المصروف؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        حذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
