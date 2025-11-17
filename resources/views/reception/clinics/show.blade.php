@extends('layouts.app')

@section('title', 'تفاصيل العيادة')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $clinic->name }}</h1>
            <p class="text-gray-600 mt-2">{{ $clinic->location ?? 'غير محدد' }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('reception.clinics.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة للعيادات
            </a>
        </div>
    </div>

    <!-- Clinic Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    المعلومات الأساسية
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الاسم:</div>
                        <div class="text-sm text-gray-900">{{ $clinic->name }}</div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الموقع:</div>
                        <div class="text-sm text-gray-900">{{ $clinic->location ?? 'غير محدد' }}</div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الحالة:</div>
                        <div class="text-sm">
                            @if($clinic->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    نشطة
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    غير نشطة
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($clinic->description)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-file-alt text-purple-600 mr-2"></i>
                        الوصف
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $clinic->description }}</p>
                </div>
            @endif

            <!-- Working Hours -->
            @if($clinic->working_hours)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-clock text-orange-600 mr-2"></i>
                        ساعات العمل
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                        @endphp
                        @foreach($clinic->working_hours as $index => $day)
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
                            <i class="fas fa-user-md text-blue-600 mr-3"></i>
                            <span class="text-sm text-gray-600">{{ __('doctors') }}</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $clinic->doctors_count ?? 0 }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-green-600 mr-3"></i>
                            <span class="text-sm text-gray-600">{{ __('appointments') }}</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ $clinic->appointments_count ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">الإجراءات</h3>
                <div class="space-y-3">
                    <a href="{{ route('appointments.create') }}?clinic_id={{ $clinic->id }}" 
                       class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>
                        حجز موعد
                    </a>
                    
                    <a href="{{ route('reception.doctors.index') }}?clinic_id={{ $clinic->id }}" 
                       class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-user-md mr-2"></i>
                        {{ __('view_doctors') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctors in this Clinic -->
    @if($clinic->doctors && $clinic->doctors->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user-md text-green-600 mr-2"></i>
                {{ __('doctors_in_clinic') }}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($clinic->doctors as $doctor)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-md text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $doctor->user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $doctor->phone }}</p>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-sm text-gray-500">رسوم الاستشارة</span>
                            <span class="font-medium text-gray-900">${{ number_format($doctor->consultation_fee, 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
