@extends('layouts.app')

@section('title', 'تفاصيل الموعد')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">تفاصيل الموعد</h1>
            <p class="text-gray-600 mt-2">معلومات مفصلة عن الموعد</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('appointments.edit', $appointment) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                تعديل
            </a>
            <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Appointment Details Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">معلومات الموعد</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">التاريخ والوقت</h4>
                        <p class="text-gray-600">{{ $appointment->appointment_date->format('d/m/Y') }}</p>
                        <p class="text-gray-600">{{ $appointment->appointment_date->format('H:i') }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">حالة الموعد</h4>
                        <span class="px-3 py-1 text-sm rounded-full font-medium
                            @if($appointment->status == 'scheduled') bg-yellow-100 text-yellow-800
                            @elseif($appointment->status == 'confirmed') bg-blue-100 text-blue-800
                            @elseif($appointment->status == 'completed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @if($appointment->status == 'scheduled') مجدول
                            @elseif($appointment->status == 'confirmed') مؤكد
                            @elseif($appointment->status == 'completed') مكتمل
                            @else ملغي
                            @endif
                        </span>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">الرسوم</h4>
                        <p class="text-gray-600 text-lg font-bold">${{ number_format($appointment->fee ?? 0, 2) }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">تاريخ الإنشاء</h4>
                        <p class="text-gray-600">{{ $appointment->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                @if($appointment->reason)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2">سبب الموعد</h4>
                        <p class="text-gray-600">{{ $appointment->reason }}</p>
                    </div>
                @endif
                
                @if($appointment->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2">ملاحظات</h4>
                        <p class="text-gray-600">{{ $appointment->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Patient and Doctor Info -->
        <div class="space-y-6">
            <!-- Patient Info -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">معلومات المريض</h3>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-medium">{{ substr($appointment->patient->user->name ?? 'N', 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $appointment->patient->user->name ?? 'غير محدد' }}</h4>
                        <p class="text-sm text-gray-600">{{ $appointment->patient->medical_record_number ?? '' }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-envelope w-4 mr-2"></i>
                        <span class="text-sm">{{ $appointment->patient->user->email ?? '' }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-phone w-4 mr-2"></i>
                        <span class="text-sm">{{ $appointment->patient->phone ?? '' }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-calendar w-4 mr-2"></i>
                        <span class="text-sm">{{ \Carbon\Carbon::parse($appointment->patient->date_of_birth ?? now())->age }} سنة</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('patients.show', $appointment->patient) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        عرض الملف الشخصي <i class="fas fa-arrow-left mr-1"></i>
                    </a>
                </div>
            </div>

            <!-- Doctor Info -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">معلومات الطبيب</h3>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-green-600 font-medium">{{ substr($appointment->doctor->user->name ?? 'D', 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $appointment->doctor->user->name ?? 'غير محدد' }}</h4>
                        <p class="text-sm text-gray-600">{{ $appointment->doctor->specialty ?? '' }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-envelope w-4 mr-2"></i>
                        <span class="text-sm">{{ $appointment->doctor->user->email ?? '' }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-phone w-4 mr-2"></i>
                        <span class="text-sm">{{ $appointment->doctor->phone ?? '' }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-id-card w-4 mr-2"></i>
                        <span class="text-sm">{{ $appointment->doctor->license_number ?? '' }}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('doctors.show', $appointment->doctor) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        عرض الملف الشخصي <i class="fas fa-arrow-left mr-1"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">إجراءات سريعة</h3>
                <div class="space-y-3">
                    @if($appointment->status == 'scheduled')
                        <form action="{{ route('appointments.confirm', $appointment) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-50 text-blue-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-blue-100 transition-colors duration-200">
                                <i class="fas fa-check mr-2"></i>
                                تأكيد الموعد
                            </button>
                        </form>
                    @endif
                    
                    @if($appointment->status == 'confirmed')
                        <form action="{{ route('appointments.complete', $appointment) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-50 text-green-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-green-100 transition-colors duration-200">
                                <i class="fas fa-check-circle mr-2"></i>
                                إكمال الموعد
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('medical-records.create') }}?appointment_id={{ $appointment->id }}" class="w-full bg-purple-50 text-purple-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-purple-100 transition-colors duration-200 block">
                        <i class="fas fa-file-medical mr-2"></i>
                        إنشاء سجل طبي
                    </a>
                    
                    <a href="{{ route('prescriptions.create') }}?appointment_id={{ $appointment->id }}" class="w-full bg-yellow-50 text-yellow-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-yellow-100 transition-colors duration-200 block">
                        <i class="fas fa-prescription mr-2"></i>
                        كتابة وصفة طبية
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
