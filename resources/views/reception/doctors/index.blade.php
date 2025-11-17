@extends('layouts.app')

@section('title', __('doctors'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('doctors') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('view_all_doctors') }}</p>
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

    <!-- Doctors Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($doctors->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-green-500 to-green-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-user-md ml-2"></i>
                                اسم الطبيب
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-hospital ml-2"></i>
                                العيادة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-phone ml-2"></i>
                                رقم الهاتف
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-dollar-sign ml-2"></i>
                                رسوم الاستشارة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-info-circle ml-2"></i>
                                السيرة الذاتية
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-toggle-on ml-2"></i>
                                الحالة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-cog ml-2"></i>
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($doctors as $doctor)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <!-- Doctor Name -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user-md text-white"></i>
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $doctor->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $doctor->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Clinic -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <i class="fas fa-hospital text-gray-400 ml-2"></i>
                                        {{ $doctor->clinic->name ?? 'غير محدد' }}
                                    </div>
                                </td>

                                <!-- Phone -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <i class="fas fa-phone text-gray-400 ml-2"></i>
                                        {{ $doctor->phone }}
                                    </div>
                                </td>

                                <!-- Consultation Fee -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-dollar-sign ml-2"></i>
                                            {{ number_format($doctor->consultation_fee, 2) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Bio -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-xs">
                                        {{ $doctor->bio ? Str::limit($doctor->bio, 50) : 'لا توجد سيرة ذاتية' }}
                                    </div>
                                </td>

                                <!-- Availability Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($doctor->is_available)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle ml-1"></i>
                                            متاح
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle ml-1"></i>
                                            غير متاح
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('reception.doctors.show', $doctor) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                           title="{{ __('view_details') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($doctor->is_available)
                                            <a href="{{ route('appointments.create') }}?doctor_id={{ $doctor->id }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200"
                                               title="حجز موعد">
                                                <i class="fas fa-calendar-plus"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-md text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد أطباء</h3>
                <p class="text-gray-600">{{ __('no_doctors_yet') }}</p>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($doctors->hasPages())
        <div class="mt-8">
            {{ $doctors->links() }}
        </div>
    @endif
</div>
@endsection
