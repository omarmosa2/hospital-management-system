@extends('layouts.app')

@section('title', 'المواعيد')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">المواعيد</h1>
            <p class="text-gray-600 mt-2">إدارة مواعيد المرضى مع الأطباء</p>
        </div>
        @can('create appointments')
        <div class="mt-4 md:mt-0">
            <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                حجز موعد جديد
            </a>
        </div>
        @endcan
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">إجمالي المواعيد</p>
                    <p class="text-3xl font-bold">{{ $stats['total_appointments'] }}</p>
                </div>
                <div class="bg-blue-400 rounded-full p-3">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">مواعيد مجدولة</p>
                    <p class="text-3xl font-bold">{{ $stats['scheduled_appointments'] }}</p>
                </div>
                <div class="bg-yellow-400 rounded-full p-3">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">مواعيد مكتملة</p>
                    <p class="text-3xl font-bold">{{ $stats['completed_appointments'] }}</p>
                </div>
                <div class="bg-green-400 rounded-full p-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">مواعيد اليوم</p>
                    <p class="text-3xl font-bold">{{ $stats['today_appointments'] }}</p>
                </div>
                <div class="bg-purple-400 rounded-full p-3">
                    <i class="fas fa-calendar-day text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">مواعيد مؤكدة</p>
                    <p class="text-3xl font-bold">{{ $stats['confirmed_appointments'] }}</p>
                </div>
                <div class="bg-indigo-400 rounded-full p-3">
                    <i class="fas fa-check text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">مواعيد ملغية</p>
                    <p class="text-3xl font-bold">{{ $stats['cancelled_appointments'] }}</p>
                </div>
                <div class="bg-red-400 rounded-full p-3">
                    <i class="fas fa-times-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-teal-100 text-sm font-medium">هذا الأسبوع</p>
                    <p class="text-3xl font-bold">{{ $stats['this_week_appointments'] }}</p>
                </div>
                <div class="bg-teal-400 rounded-full p-3">
                    <i class="fas fa-calendar-week text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">هذا الشهر</p>
                    <p class="text-3xl font-bold">{{ $stats['this_month_appointments'] }}</p>
                </div>
                <div class="bg-orange-400 rounded-full p-3">
                    <i class="fas fa-calendar text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <form method="GET" class="space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex-1 lg:mr-6">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="البحث عن موعد، مريض، طبيب..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="status" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">جميع الحالات</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>مجدول</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                    
                    <select name="doctor_id" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">جميع الأطباء</option>
                        @foreach($doctors ?? [] as $doctor)
                            <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->user->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <input type="date" 
                           name="date" 
                           value="{{ request('date') }}"
                           class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        بحث
                    </button>
                    
                    @if(request()->hasAny(['search', 'status', 'doctor_id', 'date']))
                        <a href="{{ route('appointments.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            مسح
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Appointments List -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">قائمة المواعيد</h3>
                    <p class="text-sm text-gray-600 mt-1">إجمالي {{ $appointments->total() }} موعد</p>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-calendar-alt"></i>
                    <span>آخر تحديث: {{ now()->format('H:i') }}</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                المريض
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-user-md mr-2"></i>
                                الطبيب
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-hospital mr-2"></i>
                                العيادة
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                التاريخ والوقت
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-file-medical mr-2"></i>
                                السبب
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                الحالة
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-dollar-sign mr-2"></i>
                                الرسوم
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-2"></i>
                                الإجراءات
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 group">
                            <!-- Patient Column -->
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-lg">{{ substr($appointment->patient->user->name ?? 'N', 0, 1) }}</span>
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                            {{ $appointment->patient->user->name ?? 'غير محدد' }}
                                        </div>
                                        <div class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full inline-block mt-1">
                                            {{ $appointment->patient->medical_record_number ?? 'MR-000000' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Doctor Column -->
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user-md text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $appointment->doctor->user->name ?? 'غير محدد' }}</div>
                                        <div class="text-xs text-gray-500">{{ $appointment->doctor->specialty ?? 'طبيب عام' }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Clinic Column -->
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-hospital text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $appointment->clinic->name ?? 'غير محدد' }}</div>
                                        <div class="text-xs text-gray-500">{{ $appointment->clinic->location ?? 'غير محدد' }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Date & Time Column -->
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-center">
                                    <div class="text-sm font-bold text-gray-900 bg-blue-50 px-3 py-1 rounded-lg inline-block">
                                        {{ $appointment->appointment_date->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-600 mt-1 flex items-center justify-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $appointment->appointment_time ?? 'غير محدد' }}
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Reason Column -->
                            <td class="px-6 py-5">
                                <div class="text-sm text-gray-900 max-w-xs">
                                    <div class="bg-gray-50 px-3 py-2 rounded-lg border-r-4 border-blue-500">
                                        {{ $appointment->reason ?? 'غير محدد' }}
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Status Column -->
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full
                                    @if($appointment->status == 'scheduled') bg-yellow-100 text-yellow-800 border border-yellow-200
                                    @elseif($appointment->status == 'confirmed') bg-blue-100 text-blue-800 border border-blue-200
                                    @elseif($appointment->status == 'completed') bg-green-100 text-green-800 border border-green-200
                                    @else bg-red-100 text-red-800 border border-red-200
                                    @endif">
                                    @if($appointment->status == 'scheduled')
                                        <i class="fas fa-clock mr-1"></i>مجدول
                                    @elseif($appointment->status == 'confirmed')
                                        <i class="fas fa-check mr-1"></i>مؤكد
                                    @elseif($appointment->status == 'completed')
                                        <i class="fas fa-check-circle mr-1"></i>مكتمل
                                    @else
                                        <i class="fas fa-times mr-1"></i>ملغي
                                    @endif
                                </span>
                            </td>
                            
                            <!-- Fee Column -->
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                <div class="text-sm font-bold text-gray-900 bg-green-50 px-3 py-1 rounded-lg inline-block">
                                    ${{ number_format($appointment->fee ?? 0, 2) }}
                                </div>
                            </td>
                            
                            <!-- Actions Column -->
                            <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-center space-x-1">
                                    <a href="{{ route('appointments.show', $appointment) }}" 
                                       class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-lg transition-all duration-200" 
                                       title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('appointments.edit', $appointment) }}" 
                                       class="p-2 text-green-600 hover:text-green-800 hover:bg-green-100 rounded-lg transition-all duration-200" 
                                       title="تعديل الموعد">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($appointment->status == 'scheduled')
                                        <form action="{{ route('appointments.confirm', $appointment) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-lg transition-all duration-200" 
                                                    title="تأكيد الموعد"
                                                    onclick="return confirm('هل تريد تأكيد هذا الموعد؟')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($appointment->status == 'confirmed')
                                        <form action="{{ route('appointments.complete', $appointment) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="p-2 text-green-600 hover:text-green-800 hover:bg-green-100 rounded-lg transition-all duration-200" 
                                                    title="إكمال الموعد"
                                                    onclick="return confirm('هل تريد إكمال هذا الموعد؟')">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-lg transition-all duration-200" 
                                                title="حذف الموعد"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-calendar-times text-gray-300 text-3xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد مواعيد</h3>
                                    <p class="text-gray-500 mb-6 max-w-md text-center">لم يتم حجز أي مواعيد بعد. ابدأ بحجز أول موعد للمرضى</p>
                                    @can('create appointments')
                                    <a href="{{ route('appointments.create') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-lg">
                                        <i class="fas fa-plus mr-2"></i>
                                        حجز أول موعد
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($appointments->hasPages())
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    عرض 
                    <span class="font-semibold">{{ $appointments->firstItem() }}</span>
                    إلى 
                    <span class="font-semibold">{{ $appointments->lastItem() }}</span>
                    من 
                    <span class="font-semibold">{{ $appointments->total() }}</span>
                    نتيجة
                </div>
                <div class="flex items-center space-x-2">
                    {{ $appointments->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change
    const filterSelects = document.querySelectorAll('select[name="status"], select[name="doctor_id"]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
    
    // Add loading state to buttons
    const submitButton = document.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>جاري البحث...';
            this.disabled = true;
        });
    }
    
    // Add confirmation for status changes
    const statusButtons = document.querySelectorAll('button[title="تأكيد الموعد"], button[title="إكمال الموعد"]');
    statusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm(this.getAttribute('onclick').match(/confirm\('([^']+)'\)/)[1])) {
                e.preventDefault();
            }
        });
    });
    
    // Add tooltips for action buttons
    const actionButtons = document.querySelectorAll('a[title], button[title]');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endpush
