@extends('layouts.app')

@section('title', __('clinic_details'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ __('clinic_details') }}</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">{{ $clinic->name }}</p>
        </div>
        <div class="flex space-x-4">
            @can('edit clinics')
            <a href="{{ route('clinics.edit', $clinic) }}" class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                {{ __('edit') }}
            </a>
            @endcan
            <a href="{{ route('clinics.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                {{ __('back_to_list') }}
            </a>
        </div>
    </div>

    <!-- Clinic Information -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mr-2"></i>
                {{ __('clinic_information') }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500 dark:text-slate-400">{{ __('name') }}:</div>
                        <div class="text-sm text-gray-900 dark:text-slate-100">{{ $clinic->name }}</div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500 dark:text-slate-400">{{ __('description') }}:</div>
                        <div class="text-sm text-gray-900 dark:text-slate-100">{{ $clinic->description ?? __('not_specified') }}</div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500 dark:text-slate-400">{{ __('location') }}:</div>
                        <div class="text-sm text-gray-900 dark:text-slate-100">{{ $clinic->location ?? __('not_specified') }}</div>
                    </div>
                </div>

                <div class="space-y-4">

                    <div class="flex items-start">
                        <div class="w-24 text-sm font-medium text-gray-500 dark:text-slate-400">{{ __('status') }}:</div>
                        <div class="text-sm">
                            @if($clinic->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ __('active') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    {{ __('inactive') }}
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
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-md text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="mr-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">{{ __('number_of_doctors') }}</h3>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $clinic->doctors->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                    </div>
                    <div class="mr-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">{{ __('number_of_appointments') }}</h3>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $clinic->appointments->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Doctors Section -->
    @if($clinic->doctors->count() > 0)
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-6 flex items-center">
                <i class="fas fa-user-md text-purple-600 dark:text-purple-400 mr-2"></i>
                {{ __('doctors_in_clinic') }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($clinic->doctors as $doctor)
                <div class="border border-gray-200 dark:border-slate-600 rounded-lg p-4 hover:shadow-md transition-shadow duration-200 bg-white dark:bg-slate-700">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-slate-100">{{ $doctor->user->name }}</h4>
                            <p class="text-sm text-gray-500 dark:text-slate-400">{{ $doctor->specialty ?? __('not_specified') }}</p>
                        </div>
                        <div>
                            @if($doctor->is_available)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ __('available') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    {{ __('not_available') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600 dark:text-slate-400">
                        <div class="flex items-center">
                            <i class="fas fa-phone w-4 mr-2"></i>
                            <span>{{ $doctor->phone ?? __('not_specified') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-dollar-sign w-4 mr-2"></i>
                            <span>{{ number_format($doctor->consultation_fee, 2) }} {{ __('sar') }}</span>
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
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-6 flex items-center">
                <i class="fas fa-calendar-check text-orange-600 dark:text-orange-400 mr-2"></i>
                {{ __('appointments_in_clinic') }}
            </h3>

            <div class="space-y-4">
                @foreach($clinic->appointments->take(10) as $appointment)
                <div class="border border-gray-200 dark:border-slate-600 rounded-lg p-4 hover:shadow-md transition-shadow duration-200 bg-white dark:bg-slate-700">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4 mb-2">
                                <h4 class="font-medium text-gray-900 dark:text-slate-100">{{ $appointment->patient->user->name }}</h4>
                                <span class="text-sm text-gray-500 dark:text-slate-400">{{ __('with_dr') }} {{ $appointment->doctor->user->name }}</span>
                            </div>

                            <div class="flex items-center space-x-6 text-sm text-gray-600 dark:text-slate-400">
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
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ __('scheduled') }}
                                    </span>
                                    @break
                                @case('confirmed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        <i class="fas fa-check mr-1"></i>
                                        {{ __('confirmed') }}
                                    </span>
                                    @break
                                @case('completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        {{ __('completed') }}
                                    </span>
                                    @break
                                @case('cancelled')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        {{ __('cancelled') }}
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
                <p class="text-sm text-gray-500 dark:text-slate-400">{{ __('showing') }} 10 {{ __('from') }} {{ $clinic->appointments->count() }} {{ __('appointments') }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
