@extends('layouts.app')

@section('title', 'الأطباء')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">الأطباء</h1>
            <p class="text-gray-600 mt-2">عرض جميع الأطباء المتاحين في المستشفى</p>
        </div>
        
        <div class="mt-4 md:mt-0">
            <!-- Filter by Clinic -->
            <form method="GET" class="flex items-center space-x-3">
                <select name="clinic_id" onchange="this.form.submit()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">جميع العيادات</option>
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}" {{ request('clinic_id') == $clinic->id ? 'selected' : '' }}>
                            {{ $clinic->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <!-- Doctors Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($doctors as $doctor)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Doctor Header -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold">{{ $doctor->user->name }}</h3>
                            <p class="text-green-100 text-sm mt-1">{{ $doctor->clinic->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <i class="fas fa-user-md text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Doctor Details -->
                <div class="p-6">
                    <!-- Contact Info -->
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone w-5 mr-3"></i>
                            <span class="text-sm">{{ $doctor->phone }}</span>
                        </div>
                        
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-dollar-sign w-5 mr-3"></i>
                            <span class="text-sm font-medium">${{ number_format($doctor->consultation_fee, 2) }}</span>
                        </div>
                    </div>

                    <!-- Bio -->
                    @if($doctor->bio)
                        <div class="mb-4">
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ Str::limit($doctor->bio, 100) }}
                            </p>
                        </div>
                    @endif

                    <!-- Availability Status -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-600">الحالة</span>
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

                    <!-- Working Hours -->
                    @if($doctor->working_hours)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">ساعات العمل</h4>
                            <div class="space-y-1">
                                @php
                                    $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                                @endphp
                                @foreach($doctor->working_hours as $index => $day)
                                    @if(isset($day['enabled']) && $day['enabled'])
                                        <div class="flex justify-between text-xs text-gray-600">
                                            <span>{{ $days[$index] ?? 'اليوم ' . ($index + 1) }}</span>
                                            <span>{{ $day['start'] ?? '09:00' }} - {{ $day['end'] ?? '17:00' }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="pt-4 border-t border-gray-200 space-y-2">
                        <a href="{{ route('reception.doctors.show', $doctor) }}" 
                           class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-eye mr-2"></i>
                            عرض التفاصيل
                        </a>
                        
                        @if($doctor->is_available)
                            <a href="{{ route('appointments.create') }}?doctor_id={{ $doctor->id }}" 
                               class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-calendar-plus mr-2"></i>
                                حجز موعد
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-md text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد أطباء</h3>
                    <p class="text-gray-600">لم يتم إضافة أي أطباء بعد</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($doctors->hasPages())
        <div class="mt-8">
            {{ $doctors->links() }}
        </div>
    @endif
</div>
@endsection
