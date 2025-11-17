@extends('layouts.app')

@section('title', 'العيادات')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">العيادات</h1>
            <p class="text-gray-600 mt-2">{{ __('view_all_clinics') }}</p>
        </div>
    </div>

    <!-- Clinics Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($clinics->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-500 to-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-hospital ml-2"></i>
                                اسم العيادة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-map-marker-alt ml-2"></i>
                                الموقع
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-info-circle ml-2"></i>
                                الوصف
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-user-md ml-2"></i>
                                {{ __('number_of_doctors') }}
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
                        @foreach($clinics as $clinic)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <!-- Clinic Name -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-hospital text-white"></i>
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $clinic->name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Location -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <i class="fas fa-map-marker-alt text-gray-400 ml-2"></i>
                                        {{ $clinic->location ?? 'غير محدد' }}
                                    </div>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-xs">
                                        {{ $clinic->description ? Str::limit($clinic->description, 60) : 'لا يوجد وصف' }}
                                    </div>
                                </td>

                                <!-- Doctors Count -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-user-md ml-2"></i>
                                            {{ $clinic->doctors_count ?? 0 }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($clinic->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle ml-1"></i>
                                            نشطة
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle ml-1"></i>
                                            غير نشطة
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('reception.clinics.show', $clinic) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        <i class="fas fa-eye ml-2"></i>
                                        {{ __('view_details') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hospital text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد عيادات</h3>
                <p class="text-gray-600">{{ __('no_clinics_yet') }}</p>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($clinics->hasPages())
        <div class="mt-8">
            {{ $clinics->links() }}
        </div>
    @endif
</div>
@endsection
