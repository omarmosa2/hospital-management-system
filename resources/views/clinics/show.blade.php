@extends('layouts.app')

@section('title', 'تفاصيل العيادة')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">تفاصيل العيادة</h1>
            <p class="text-gray-600 mt-2">{{ $clinic->name }}</p>
        </div>
        <div class="flex space-x-4">
            @can('edit clinics')
            <a href="{{ route('clinics.edit', $clinic) }}" class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                تعديل
            </a>
            @endcan
            <a href="{{ route('clinics.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Clinic Information -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                معلومات العيادة
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الاسم:</div>
                        <div class="text-sm text-gray-900">{{ $clinic->name }}</div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الوصف:</div>
                        <div class="text-sm text-gray-900">{{ $clinic->description ?? 'غير محدد' }}</div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الموقع:</div>
                        <div class="text-sm text-gray-900">{{ $clinic->location ?? 'غير محدد' }}</div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500">الحالة:</div>
                        <div class="text-sm">
                            @if($clinic->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    نشط
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    غير نشط
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-md text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mr-4">
                        <h3 class="text-lg font-semibold text-gray-900">عدد الأطباء</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $clinic->doctors->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mr-4">
                        <h3 class="text-lg font-semibold text-gray-900">عدد المواعيد</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $clinic->appointments->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Doctors Section -->
    @if($clinic->doctors->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-user-md text-purple-600 mr-2"></i>
                الأطباء في هذه العيادة
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($clinic->doctors as $doctor)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $doctor->user->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $doctor->specialty ?? 'غير محدد' }}</p>
                        </div>
                        <div>
                            @if($doctor->is_available)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    متاح
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    غير متاح
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-phone w-4 mr-2"></i>
                            <span>{{ $doctor->phone ?? 'غير محدد' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-dollar-sign w-4 mr-2"></i>
                            <span>{{ number_format($doctor->consultation_fee, 2) }} ريال</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Appointments Section -->
    @if($clinic->appointments->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-calendar-check text-orange-600 mr-2"></i>
                المواعيد في هذه العيادة
            </h3>
            
            <div class="space-y-4">
                @foreach($clinic->appointments->take(10) as $appointment)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4 mb-2">
                                <h4 class="font-medium text-gray-900">{{ $appointment->patient->user->name }}</h4>
                                <span class="text-sm text-gray-500">مع د. {{ $appointment->doctor->user->name }}</span>
                            </div>
                            
                            <div class="flex items-center space-x-6 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar w-4 mr-2"></i>
                                    <span>{{ $appointment->appointment_date->format('Y-m-d') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock w-4 mr-2"></i>
                                    <span>{{ $appointment->appointment_time }}</span>
                                </div>
                                @if($appointment->reason)
                                <div class="flex items-center">
                                    <i class="fas fa-comment w-4 mr-2"></i>
                                    <span>{{ Str::limit($appointment->reason, 50) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex-shrink-0">
                            @switch($appointment->status)
                                @case('scheduled')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        مجدول
                                    </span>
                                    @break
                                @case('confirmed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-check mr-1"></i>
                                        مؤكد
                                    </span>
                                    @break
                                @case('completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        مكتمل
                                    </span>
                                    @break
                                @case('cancelled')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        ملغي
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($clinic->appointments->count() > 10)
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-500">عرض 10 من أصل {{ $clinic->appointments->count() }} موعد</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
