@extends('layouts.app')

@section('title', __('create_new_bill'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ __('create_new_bill') }}</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">إنشاء فاتورة للمريض والخدمات</p>
        </div>
        <a href="{{ route('bills.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors duration-200">
            <i class="fas fa-arrow-right mr-2"></i>
            العودة للقائمة
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <form action="{{ route('bills.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Patient Selection -->
            <div class="border-b border-gray-200 dark:border-slate-700 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4">اختيار المريض</h3>
                <div>
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">المريض</label>
                    <select id="patient_id" name="patient_id" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 @error('patient_id') border-red-500 @enderror">
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} - {{ $patient->medical_record_number }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Services Selection -->
            <div class="border-b border-gray-200 dark:border-slate-700 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4">اختيار الخدمات</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($services as $service)
                        <div class="border border-gray-200 dark:border-slate-600 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors duration-200">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                       class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-slate-600 rounded"
                                       {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $service->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-slate-400">{{ $service->description }}</div>
                                    <div class="text-sm font-bold text-blue-600 dark:text-blue-400">${{ number_format($service->price, 2) }}</div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('services')
                    <p class="text-red-500 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bill Details -->
            <div class="border-b border-gray-200 dark:border-slate-700 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4">تفاصيل الفاتورة</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="discount" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">الخصم ($)</label>
                        <input type="number" id="discount" name="discount" value="{{ old('discount', 0) }}" step="0.01" min="0"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 @error('discount') border-red-500 @enderror">
                        @error('discount')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">المبلغ الإجمالي</label>
                        <div id="totalAmount" class="w-full px-4 py-2 bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-700 dark:text-slate-200">
                            $0.00
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">ملاحظات</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('notes') border-red-500 @enderror"
                              placeholder="أي ملاحظات إضافية حول الفاتورة...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('bills.index') }}" class="px-6 py-2 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors duration-200">
                    {{ __('cancel') }}
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    إنشاء الفاتورة
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Calculate total amount when services are selected
function calculateTotal() {
    const checkboxes = document.querySelectorAll('input[name="services[]"]:checked');
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    let total = 0;
    
    checkboxes.forEach(checkbox => {
        const serviceCard = checkbox.closest('.border');
        const priceText = serviceCard.querySelector('.text-blue-600').textContent;
        const price = parseFloat(priceText.replace('$', ''));
        total += price;
    });
    
    const finalTotal = total - discount;
    document.getElementById('totalAmount').textContent = '$' + finalTotal.toFixed(2);
}

// Add event listeners
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="services[]"]');
    const discountInput = document.getElementById('discount');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', calculateTotal);
    });
    
    discountInput.addEventListener('input', calculateTotal);
    
    // Initial calculation
    calculateTotal();
});
</script>
@endsection
