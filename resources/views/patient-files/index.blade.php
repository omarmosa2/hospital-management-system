@extends('layouts.app')

@section('title', __('patient_folders'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ __('patient_folders') }}</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">{{ __('manage_patient_files') }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="exportAllFiles()" class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                {{ __('export_all_folders') }}
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <div class="relative">
                    <input type="text" placeholder="{{ __('search_for_patient') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 dark:text-slate-400"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>{{ __('all_ages') }}</option>
                    <option>{{ __('age_0_18') }}</option>
                    <option>{{ __('age_19_35') }}</option>
                    <option>{{ __('age_36_50') }}</option>
                    <option>{{ __('age_50_plus') }}</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>{{ __('all_statuses') }}</option>
                    <option>{{ __('active') }}</option>
                    <option>{{ __('inactive') }}</option>
                </select>
                <input type="date" class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
            </div>
        </div>
    </div>

    <!-- Patient Files List -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">{{ __('patient_folders_list') }}</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('patient') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('file_number') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('age') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('gender') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('phone') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('appointments') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('medical_records') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('last_visit') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-lg font-bold">{{ substr($patient->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $patient->user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-slate-400">{{ $patient->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $patient->medical_record_number }}</div>
                                <div class="text-sm text-gray-500 dark:text-slate-400">ID: {{ $patient->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                {{ $patient->age ?? __('not_specified') }} {{ __('years') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $patient->gender == 'male' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 'bg-pink-100 dark:bg-pink-900 text-pink-800 dark:text-pink-200' }}">
                                    <i class="fas fa-{{ $patient->gender == 'male' ? 'male' : 'female' }} mr-1"></i>
                                    {{ $patient->gender == 'male' ? __('male') : __('female') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                {{ $patient->phone ?? __('not_specified') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-500 dark:text-blue-400 mr-2"></i>
                                    {{ $patient->appointments->count() }} {{ __('appointment') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                <div class="flex items-center">
                                    <i class="fas fa-file-medical text-green-500 dark:text-green-400 mr-2"></i>
                                    {{ $patient->medicalRecords->count() }} {{ __('record') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                @if($patient->appointments->count() > 0)
                                    {{ $patient->appointments->sortByDesc('appointment_date')->first()->appointment_date->format('d/m/Y') }}
                                @else
                                    {{ __('no_visits') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('patient-files.show', $patient) }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300" 
                                       title="{{ __('view') }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('patient-files.generate-pdf', $patient) }}" 
                                       class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" 
                                       title="{{ __('download_pdf') }}">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    
                                    <a href="{{ route('patient-files.print', $patient) }}" 
                                       target="_blank"
                                       class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300" 
                                       title="{{ __('print') }}">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-folder-open text-gray-300 dark:text-slate-600 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">{{ __('no_patient_folders') }}</h3>
                                    <p class="text-gray-500 dark:text-slate-400">{{ __('no_patient_folders_found') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($patients->hasPages())
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            {{ $patients->links() }}
        </div>
    @endif
</div>

<script>
function exportAllFiles() {
    // In a real application, you would implement bulk PDF export
    alert('{{ __('export_all_folders_soon') }}');
}
</script>
@endsection
