@extends('layouts.app')

@section('title', 'تعديل الفاتورة')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">تعديل الفاتورة</h1>
            <p class="text-gray-600 mt-2">فاتورة رقم: {{ $bill->bill_number }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('bills.show', $bill) }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-eye mr-2"></i>
                عرض
            </a>
            <a href="{{ route('bills.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <form action="{{ route('bills.update', $bill) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Patient Selection -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">المريض</h3>
                <div>
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">المريض</label>
                    <select id="patient_id" name="patient_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('patient_id') border-red-500 @enderror">
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $bill->patient_id) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} - {{ $patient->medical_record_number }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Services Selection -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">الخدمات</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($services as $service)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" name="services[]" value="{{ $service->id }}" 
                                       class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                       {{ in_array($service->id, old('services', $bill->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $service->description }}</div>
                                    <div class="text-sm font-bold text-blue-600">${{ number_format($service->price, 2) }}</div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('services')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bill Details -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">تفاصيل الفاتورة</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="discount" class="block text-sm font-medium text-gray-700 mb-2">الخصم ($)</label>
                        <input type="number" id="discount" name="discount" value="{{ old('discount', $bill->discount) }}" step="0.01" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount') border-red-500 @enderror">
                        @error('discount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">حالة الفاتورة</label>
                        <select id="status" name="status" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="pending" {{ old('status', $bill->status) == 'pending' ? 'selected' : '' }}>معلق</option>
                            <option value="paid" {{ old('status', $bill->status) == 'paid' ? 'selected' : '' }}>مدفوع</option>
                            <option value="partial" {{ old('status', $bill->status) == 'partial' ? 'selected' : '' }}>جزئي</option>
                            <option value="cancelled" {{ old('status', $bill->status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">المبلغ الإجمالي</label>
                    <div id="totalAmount" class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700">
                        $0.00
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                              placeholder="أي ملاحظات إضافية حول الفاتورة...">{{ old('notes', $bill->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('bills.show', $bill) }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    إلغاء
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    حفظ التغييرات
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
