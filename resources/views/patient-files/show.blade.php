@extends('layouts.app')

@section('title', __('patient_folder'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ __('patient_folder') }}</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">{{ $patient->user->name }} - {{ __('file_number_label') }}: {{ $patient->medical_record_number }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('patient-files.generate-pdf', $patient) }}" 
               class="inline-flex items-center px-4 py-2 bg-red-600 dark:bg-red-700 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition-colors duration-200">
                <i class="fas fa-file-pdf mr-2"></i>
                {{ __('download_pdf') }}
            </a>
            <a href="{{ route('patient-files.print', $patient) }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition-colors duration-200">
                <i class="fas fa-print mr-2"></i>
                {{ __('print') }}
            </a>
            <a href="{{ route('patient-files.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                {{ __('back_to_folders') }}
            </a>
        </div>
    </div>

    <!-- Patient Information Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">{{ substr($patient->user->name, 0, 1) }}</span>
                    </div>
                    <div class="mr-4">
                        <h2 class="text-2xl font-bold">{{ $patient->user->name }}</h2>
                        <p class="text-blue-100 dark:text-blue-200">{{ __('file_number_label') }}: {{ $patient->medical_record_number }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-blue-100 dark:text-blue-200">{{ __('registration_date') }}</div>
                    <div class="text-lg font-semibold">{{ $patient->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $patient->age ?? __('not_specified') }}</div>
                    <div class="text-sm text-gray-500 dark:text-slate-400">{{ __('age') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $patient->gender == 'male' ? __('male') : __('female') }}</div>
                    <div class="text-sm text-gray-500 dark:text-slate-400">{{ __('gender') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $patient->appointments->count() }}</div>
                    <div class="text-sm text-gray-500 dark:text-slate-400">{{ __('appointments') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $patient->medicalRecords->count() }}</div>
                    <div class="text-sm text-gray-500 dark:text-slate-400">{{ __('medical_records') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center">
                <i class="fas fa-user text-blue-600 dark:text-blue-400 mr-2"></i>
                {{ __('personal_information') }}
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('full_name_label') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('email_label') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->user->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('phone_label') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->phone ?? __('not_specified') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('address_label') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->address ?? __('not_specified') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('date_of_birth_label') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->date_of_birth ? $patient->date_of_birth->format('d/m/Y') : __('not_specified') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('marital_status') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->marital_status ?? __('not_specified') }}</span>
                </div>
            </div>
        </div>

        <!-- Medical Information -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center">
                <i class="fas fa-heartbeat text-red-600 dark:text-red-400 mr-2"></i>
                {{ __('medical_information') }}
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('blood_type') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->blood_type ?? __('not_specified') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('weight') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->weight ?? __('not_specified') }} {{ __('kg') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('height') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->height ?? __('not_specified') }} {{ __('cm') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('allergies') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->allergies ?? __('none') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('chronic_conditions') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->chronic_conditions ?? __('none') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-slate-400">{{ __('current_medications') }}:</span>
                    <span class="font-medium text-gray-900 dark:text-slate-100">{{ $patient->current_medications ?? __('none') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments History -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 flex items-center">
                <i class="fas fa-calendar-alt text-green-600 dark:text-green-400 mr-2"></i>
                {{ __('appointment_history') }}
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('date') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('doctor') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('clinic') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('reason') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('status') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('fees') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($patient->appointments as $appointment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $appointment->appointment_date->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500 dark:text-slate-400">{{ $appointment->appointment_time }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                {{ $appointment->doctor->user->name ?? __('not_specified') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                {{ $appointment->clinic->name ?? __('not_specified') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-slate-100">
                                {{ $appointment->reason ?? __('not_specified') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($appointment->status == 'scheduled') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                    @elseif($appointment->status == 'confirmed') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                    @elseif($appointment->status == 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                    @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                    @endif">
                                    @if($appointment->status == 'scheduled') {{ __('scheduled') }}
                                    @elseif($appointment->status == 'confirmed') {{ __('confirmed') }}
                                    @elseif($appointment->status == 'completed') {{ __('completed') }}
                                    @else {{ __('cancelled') }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                ${{ number_format($appointment->fee ?? 0, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-slate-400">
                                {{ __('no_appointments_recorded') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Medical Records -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 flex items-center">
                <i class="fas fa-file-medical text-purple-600 dark:text-purple-400 mr-2"></i>
                {{ __('medical_records') }}
            </h3>
        </div>
        <div class="p-6">
            @forelse($patient->medicalRecords as $record)
                <div class="border border-gray-200 dark:border-slate-700 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900 dark:text-slate-100">{{ $record->title }}</h4>
                        <span class="text-sm text-gray-500 dark:text-slate-400">{{ $record->created_at->format('d/m/Y') }}</span>
                    </div>
                    <p class="text-gray-600 dark:text-slate-400 text-sm">{{ $record->description }}</p>
                    @if($record->diagnosis)
                        <div class="mt-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('diagnosis') }}:</span>
                            <span class="text-sm text-gray-600 dark:text-slate-400">{{ $record->diagnosis }}</span>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 dark:text-slate-400 text-center py-8">{{ __('no_medical_records') }}</p>
            @endforelse
        </div>
    </div>

    <!-- Prescriptions -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 flex items-center">
                <i class="fas fa-prescription-bottle-alt text-orange-600 dark:text-orange-400 mr-2"></i>
                {{ __('prescriptions') }}
            </h3>
        </div>
        <div class="p-6">
            @forelse($patient->prescriptions as $prescription)
                <div class="border border-gray-200 dark:border-slate-700 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900 dark:text-slate-100">{{ __('prescription_number') }} #{{ $prescription->id }}</h4>
                        <span class="text-sm text-gray-500 dark:text-slate-400">{{ $prescription->created_at->format('d/m/Y') }}</span>
                    </div>
                    @if($prescription->medications->count() > 0)
                        <div class="mt-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('medications') }}:</span>
                            <ul class="mt-1 text-sm text-gray-600 dark:text-slate-400">
                                @foreach($prescription->medications as $medication)
                                    <li>• {{ $medication->name }} - {{ $medication->dosage }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($prescription->notes)
                        <div class="mt-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('notes') }}:</span>
                            <span class="text-sm text-gray-600 dark:text-slate-400">{{ $prescription->notes }}</span>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 dark:text-slate-400 text-center py-8">{{ __('no_prescriptions') }}</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
