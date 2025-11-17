@extends('layouts.app')

@section('title', 'تفاصيل الطبيب')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $doctor->user->name }}</h1>
            <p class="text-gray-600 mt-2">{{ $doctor->clinic->name ?? 'غير محدد' }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
            @if($doctor->is_available)
                <a href="{{ route('appointments.create') }}?doctor_id={{ $doctor->id }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    حجز موعد
                </a>
            @endif
            
            <a href="{{ route('reception.doctors.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة للأطباء
            </a>
        </div>
    </div>

    <!-- Doctor Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    المعلومات الشخصية
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الاسم:</div>
                        <div class="text-sm text-gray-900">{{ $doctor->user->name }}</div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">البريد:</div>
                        <div class="text-sm text-gray-900">{{ $doctor->user->email }}</div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الهاتف:</div>
                        <div class="text-sm text-gray-900">{{ $doctor->phone }}</div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">العيادة:</div>
                        <div class="text-sm text-gray-900">{{ $doctor->clinic->name ?? 'غير محدد' }}</div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الحالة:</div>
                        <div class="text-sm">
                            @if($doctor->is_available)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    متاح
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    غير متاح
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-md text-green-600 mr-2"></i>
                    المعلومات المهنية
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">رسوم الاستشارة</span>
                        <span class="text-lg font-bold text-gray-900">${{ number_format($doctor->consultation_fee, 2) }}</span>
                    </div>
                    
                    @if($doctor->bio)
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">نبذة عن الطبيب</h4>
                            <p class="text-gray-700 leading-relaxed">{{ $doctor->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Working Hours -->
            @if($doctor->working_hours)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-clock text-orange-600 mr-2"></i>
                        ساعات العمل
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                        @endphp
                        @foreach($doctor->working_hours as $index => $day)
                            @if(isset($day['enabled']) && $day['enabled'])
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="font-medium text-gray-900">{{ $days[$index] ?? 'اليوم ' . ($index + 1) }}</span>
                                    <span class="text-sm text-gray-600">{{ $day['start'] ?? '09:00' }} - {{ $day['end'] ?? '17:00' }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">الإحصائيات</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 mr-3"></i>
                            <span class="text-sm text-gray-600">{{ __('appointments') }}</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $doctor->appointments_count ?? 0 }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-file-medical text-green-600 mr-3"></i>
                            <span class="text-sm text-gray-600">السجلات الطبية</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $doctor->medical_records_count ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">الإجراءات</h3>
                <div class="space-y-3">
                    @if($doctor->is_available)
                        <a href="{{ route('appointments.create') }}?doctor_id={{ $doctor->id }}" 
                           class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            حجز موعد
                        </a>
                    @endif
                    
                    <a href="{{ route('reception.clinics.show', $doctor->clinic) }}" 
                       class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-hospital mr-2"></i>
                        {{ __('view_clinic') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments -->
    @if($doctor->appointments && $doctor->appointments->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-calendar-alt text-purple-600 mr-2"></i>
                {{ __('recent_appointments') }}
            </h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المريض</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الوقت</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($doctor->appointments->take(5) as $appointment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $appointment->patient->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $appointment->appointment_date->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $appointment->appointment_time ?? 'غير محدد' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($appointment->status == 'confirmed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            مؤكد
                                        </span>
                                    @elseif($appointment->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            في الانتظار
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $appointment->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
