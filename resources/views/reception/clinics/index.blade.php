@extends('layouts.app')

@section('title', 'العيادات')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">العيادات</h1>
            <p class="text-gray-600 mt-2">عرض جميع العيادات المتاحة في المستشفى</p>
        </div>
    </div>

    <!-- Clinics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($clinics as $clinic)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Clinic Header -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold">{{ $clinic->name }}</h3>
                            <p class="text-blue-100 text-sm mt-1">{{ $clinic->location ?? 'غير محدد' }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <i class="fas fa-hospital text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Clinic Details -->
                <div class="p-6">
                    <!-- Status -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-600">الحالة</span>
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

                    <!-- Description -->
                    @if($clinic->description)
                        <div class="mb-4">
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ Str::limit($clinic->description, 100) }}
                            </p>
                        </div>
                    @endif

                    <!-- Working Hours -->
                    @if($clinic->working_hours)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">ساعات العمل</h4>
                            <div class="space-y-1">
                                @php
                                    $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                                @endphp
                                @foreach($clinic->working_hours as $index => $day)
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

                    <!-- Doctors Count -->
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                        <span>عدد الأطباء</span>
                        <span class="font-medium">{{ $clinic->doctors_count ?? 0 }}</span>
                    </div>

                    <!-- View Details Button -->
                    <div class="pt-4 border-t border-gray-200">
                        <a href="{{ route('reception.clinics.show', $clinic) }}" 
                           class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-eye mr-2"></i>
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-hospital text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد عيادات</h3>
                    <p class="text-gray-600">لم يتم إضافة أي عيادات بعد</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($clinics->hasPages())
        <div class="mt-8">
            {{ $clinics->links() }}
        </div>
    @endif
</div>
@endsection
