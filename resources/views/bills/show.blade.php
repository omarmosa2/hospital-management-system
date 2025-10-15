@extends('layouts.app')

@section('title', 'تفاصيل الفاتورة')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">تفاصيل الفاتورة</h1>
            <p class="text-gray-600 mt-2">فاتورة رقم: {{ $bill->bill_number }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('bills.edit', $bill) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                تعديل
            </a>
            <a href="{{ route('bills.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Bill Details Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">معلومات الفاتورة</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">رقم الفاتورة</h4>
                        <p class="text-gray-600">{{ $bill->bill_number }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">حالة الفاتورة</h4>
                        <span class="px-3 py-1 text-sm rounded-full font-medium
                            @if($bill->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($bill->status == 'paid') bg-green-100 text-green-800
                            @elseif($bill->status == 'partial') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @if($bill->status == 'pending') معلق
                            @elseif($bill->status == 'paid') مدفوع
                            @elseif($bill->status == 'partial') جزئي
                            @else ملغي
                            @endif
                        </span>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">تاريخ الإنشاء</h4>
                        <p class="text-gray-600">{{ $bill->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">آخر تحديث</h4>
                        <p class="text-gray-600">{{ $bill->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                @if($bill->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2">ملاحظات</h4>
                        <p class="text-gray-600">{{ $bill->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Services List -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">الخدمات المطلوبة</h3>
                <div class="space-y-4">
                    @forelse($bill->services as $service)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-cog text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $service->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $service->description }}</p>
                                </div>
                            </div>
                            <div class="text-left">
                                <p class="font-bold text-gray-900">${{ number_format($service->pivot->total_price, 2) }}</p>
                                <p class="text-sm text-gray-500">الكمية: {{ $service->pivot->quantity }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-cog text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">لا توجد خدمات</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Patient Info and Summary -->
        <div class="space-y-6">
            <!-- Patient Info -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">معلومات المريض</h3>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-medium">{{ substr($bill->patient->user->name ?? 'N', 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $bill->patient->user->name ?? 'غير محدد' }}</h4>
                        <p class="text-sm text-gray-600">{{ $bill->patient->medical_record_number ?? '' }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-envelope w-4 mr-2"></i>
                        <span class="text-sm">{{ $bill->patient->user->email ?? '' }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-phone w-4 mr-2"></i>
                        <span class="text-sm">{{ $bill->patient->phone ?? '' }}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('patients.show', $bill->patient) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        عرض الملف الشخصي <i class="fas fa-arrow-left mr-1"></i>
                    </a>
                </div>
            </div>

            <!-- Bill Summary -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">ملخص الفاتورة</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">المبلغ الإجمالي:</span>
                        <span class="font-medium">${{ number_format($bill->total_amount + $bill->discount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">الخصم:</span>
                        <span class="font-medium text-red-600">-${{ number_format($bill->discount, 2) }}</span>
                    </div>
                    <hr class="border-gray-200">
                    <div class="flex justify-between">
                        <span class="text-lg font-bold text-gray-900">المبلغ النهائي:</span>
                        <span class="text-lg font-bold text-blue-600">${{ number_format($bill->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Actions -->
            @if($bill->status == 'pending' || $bill->status == 'partial')
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">إجراءات الدفع</h3>
                    <div class="space-y-3">
                        <button onclick="openPaymentModal({{ $bill->id }}, {{ $bill->total_amount }})" 
                                class="w-full bg-green-50 text-green-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-green-100 transition-colors duration-200">
                            <i class="fas fa-credit-card mr-2"></i>
                            تسجيل الدفع
                        </button>
                        <button onclick="markAsPaid({{ $bill->id }})" 
                                class="w-full bg-blue-50 text-blue-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-blue-100 transition-colors duration-200">
                            <i class="fas fa-check mr-2"></i>
                            تم الدفع بالكامل
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">تسجيل الدفع</h3>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="paymentForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">المبلغ</label>
                    <input type="number" id="paymentAmount" name="amount" step="0.01" min="0.01" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">طريقة الدفع</label>
                    <select name="payment_method" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">اختر طريقة الدفع</option>
                        <option value="cash">نقداً</option>
                        <option value="card">بطاقة ائتمان</option>
                        <option value="bank_transfer">تحويل بنكي</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        إلغاء
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        تسجيل الدفع
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openPaymentModal(billId, totalAmount) {
    document.getElementById('paymentModal').classList.remove('hidden');
    document.getElementById('paymentForm').action = `/bills/${billId}/payment`;
    document.getElementById('paymentAmount').max = totalAmount;
    document.getElementById('paymentAmount').value = totalAmount;
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

function markAsPaid(billId) {
    if (confirm('هل أنت متأكد من تسجيل الدفع بالكامل؟')) {
        fetch(`/bills/${billId}/payment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                amount: document.querySelector('.text-blue-600').textContent.replace('$', ''),
                payment_method: 'cash'
            })
        }).then(() => {
            location.reload();
        });
    }
}
</script>
@endsection
