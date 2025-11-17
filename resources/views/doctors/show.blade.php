@extends('layouts.app')

@section('title', __('doctor_details'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('doctor_details') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('detailed_doctor_information') }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('doctors.edit', $doctor) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                {{ __('edit') }}
            </a>
            <a href="{{ route('doctors.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                {{ __('back_to_list') }}
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Doctor Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <!-- Doctor Avatar and Status -->
                <div class="text-center mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-3xl font-bold">{{ substr($doctor->user->name, 0, 1) }}</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $doctor->user->name }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2 {{ $doctor->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        <i class="fas fa-circle text-xs mr-1"></i>
                        {{ $doctor->is_available ? __('available') : __('not_available') }}
                    </span>
                </div>

                <!-- Contact Information -->
                <div class="space-y-4">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-envelope w-5 mr-3"></i>
                        <span>{{ $doctor->user->email }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-phone w-5 mr-3"></i>
                        <span>{{ $doctor->phone }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-dollar-sign w-5 mr-3"></i>
                        <span class="font-medium">${{ number_format($doctor->consultation_fee, 2) }}</span>
                    </div>
                </div>

                <!-- Bio -->
                @if($doctor->bio)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('doctor_bio') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $doctor->bio }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Doctor Details and Statistics -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Working Hours -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('working_hours') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $days = [
                            __('saturday'),
                            __('sunday'),
                            __('monday'),
                            __('tuesday'),
                            __('wednesday'),
                            __('thursday'),
                            __('friday')
                        ];
                        $workingHours = $doctor->working_hours ?? [];
                    @endphp
                    @foreach($days as $index => $day)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-900">{{ $day }}</span>
                            <span class="text-sm text-gray-600">
                                @if(isset($workingHours[$index]['start']) && isset($workingHours[$index]['end']))
                                    {{ $workingHours[$index]['start'] }} - {{ $workingHours[$index]['end'] }}
                                @else
                                    {{ __('closed') }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-blue-600"></i>
                        </div>
                        <div class="mr-4">
                            <p class="text-2xl font-bold text-gray-900">{{ $doctor->appointments->count() }}</p>
                            <p class="text-gray-600 text-sm">{{ __('total_appointments') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-green-600"></i>
                        </div>
                        <div class="mr-4">
                            <p class="text-2xl font-bold text-gray-900">{{ $doctor->appointments->pluck('patient_id')->unique()->count() }}</p>
                            <p class="text-gray-600 text-sm">{{ __('number_of_patients') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-medical text-purple-600"></i>
                        </div>
                        <div class="mr-4">
                            <p class="text-2xl font-bold text-gray-900">{{ $doctor->medicalRecords->count() }}</p>
                            <p class="text-gray-600 text-sm">{{ __('medical_records') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900">{{ __('recent_appointments') }}</h3>
                    <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        {{ __('view_all') }} <i class="fas fa-arrow-left mr-1"></i>
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($doctor->appointments->take(5) as $appointment)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $appointment->patient->user->name ?? __('not_specified') }}</p>
                                    <p class="text-sm text-gray-600">{{ $appointment->appointment_date->format('d M Y - H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-left">
                                <span class="px-3 py-1 text-xs rounded-full font-medium
                                    @if($appointment->status == 'scheduled') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status == 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($appointment->status == 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($appointment->status == 'scheduled') {{ __('scheduled') }}
                                    @elseif($appointment->status == 'confirmed') {{ __('confirmed') }}
                                    @elseif($appointment->status == 'completed') {{ __('completed') }}
                                    @else {{ __('cancelled') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">{{ __('no_appointments') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection