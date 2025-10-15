@extends('layouts.app')

@section('title', 'إضافة مصروف جديد')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">إضافة مصروف جديد</h1>
            <p class="text-gray-600 mt-2">قم بملء البيانات التالية لإضافة مصروف جديد</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('expenses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                رجوع للمصروفات
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <form action="{{ route('expenses.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    المعلومات الأساسية
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            عنوان المصروف <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               placeholder="أدخل عنوان المصروف"
                               required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category" class="block text-sm font-medium text-gray-700">
                            الفئة <span class="text-red-500">*</span>
                        </label>
                        <select id="category" 
                                name="category" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror"
                                required>
                            <option value="">اختر الفئة</option>
                            <option value="equipment" {{ old('category') == 'equipment' ? 'selected' : '' }}>معدات</option>
                            <option value="medicines" {{ old('category') == 'medicines' ? 'selected' : '' }}>أدوية</option>
                            <option value="utilities" {{ old('category') == 'utilities' ? 'selected' : '' }}>مرافق</option>
                            <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                            <option value="staff" {{ old('category') == 'staff' ? 'selected' : '' }}>موظفين</option>
                            <option value="supplies" {{ old('category') == 'supplies' ? 'selected' : '' }}>مستلزمات</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>أخرى</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6 space-y-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        الوصف
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="أدخل وصفاً مفصلاً للمصروف">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Financial Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-dollar-sign text-green-600 mr-2"></i>
                    المعلومات المالية
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Amount -->
                    <div class="space-y-2">
                        <label for="amount" class="block text-sm font-medium text-gray-700">
                            المبلغ <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="amount" 
                               name="amount" 
                               value="{{ old('amount') }}"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('amount') border-red-500 @enderror"
                               placeholder="0.00"
                               required>
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div class="space-y-2">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">
                            طريقة الدفع <span class="text-red-500">*</span>
                        </label>
                        <select id="payment_method" 
                                name="payment_method" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('payment_method') border-red-500 @enderror"
                                required>
                            <option value="">اختر طريقة الدفع</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقداً</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>بطاقة ائتمان</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                            <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>شيك</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Dates and Vendor -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-calendar text-purple-600 mr-2"></i>
                    التواريخ والمورد
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Expense Date -->
                    <div class="space-y-2">
                        <label for="expense_date" class="block text-sm font-medium text-gray-700">
                            تاريخ المصروف <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="expense_date" 
                               name="expense_date" 
                               value="{{ old('expense_date', date('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('expense_date') border-red-500 @enderror"
                               required>
                        @error('expense_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="space-y-2">
                        <label for="due_date" class="block text-sm font-medium text-gray-700">
                            تاريخ الاستحقاق
                        </label>
                        <input type="date" 
                               id="due_date" 
                               name="due_date" 
                               value="{{ old('due_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vendor -->
                    <div class="space-y-2">
                        <label for="vendor" class="block text-sm font-medium text-gray-700">
                            المورد
                        </label>
                        <input type="text" 
                               id="vendor" 
                               name="vendor" 
                               value="{{ old('vendor') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vendor') border-red-500 @enderror"
                               placeholder="اسم المورد أو الشركة">
                        @error('vendor')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reference Number -->
                    <div class="space-y-2">
                        <label for="reference_number" class="block text-sm font-medium text-gray-700">
                            رقم المرجع
                        </label>
                        <input type="text" 
                               id="reference_number" 
                               name="reference_number" 
                               value="{{ old('reference_number') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('reference_number') border-red-500 @enderror"
                               placeholder="رقم الفاتورة أو المرجع">
                        @error('reference_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-6 space-y-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700">
                        ملاحظات إضافية
                    </label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                              placeholder="أي ملاحظات إضافية">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    حفظ المصروف
                </button>
                <a href="{{ route('expenses.index') }}" 
                   class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
