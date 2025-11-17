@extends('layouts.app')

@section('title', __('clinics'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ __('clinics') }}</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">{{ __('manage_hospital_clinics_specialists') }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            @can('create clinics')
            <a href="{{ route('clinics.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                {{ __('add_new_clinic') }}
            </a>
            @endcan
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <div class="relative">
                    <input type="text" placeholder="{{ __('search_for_clinic') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 dark:text-slate-400"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>{{ __('all_locations') }}</option>
                    <option>{{ __('first_floor') }}</option>
                    <option>{{ __('second_floor') }}</option>
                    <option>{{ __('third_floor') }}</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>{{ __('all_statuses') }}</option>
                    <option>{{ __('active') }}</option>
                    <option>{{ __('inactive') }}</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Clinics Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        @if($clinics->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-700 dark:to-blue-800">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-hospital ml-2"></i>
                                {{ __('clinic_name') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-map-marker-alt ml-2"></i>
                                {{ __('location') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-info-circle ml-2"></i>
                                {{ __('description') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-user-md ml-2"></i>
                                {{ __('number_of_doctors') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-calendar-alt ml-2"></i>
                                {{ __('number_of_appointments') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-toggle-on ml-2"></i>
                                {{ __('status') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-cog ml-2"></i>
                                {{ __('actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        @foreach($clinics as $clinic)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors duration-200">
                                <!-- Clinic Name -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-hospital text-white"></i>
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-bold text-gray-900 dark:text-slate-100">{{ $clinic->name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Location -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-slate-100">
                                        <i class="fas fa-map-marker-alt text-gray-400 dark:text-slate-400 ml-2"></i>
                                        {{ $clinic->location ?? __('not_specified') }}
                                    </div>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 dark:text-slate-400 max-w-xs">
                                        {{ $clinic->description ? Str::limit($clinic->description, 60) : __('no_description') }}
                                    </div>
                                </td>

                                <!-- Doctors Count -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            <i class="fas fa-user-md ml-2"></i>
                                            {{ $clinic->doctors_count ?? 0 }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Appointments Count -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                            <i class="fas fa-calendar-alt ml-2"></i>
                                            {{ $clinic->appointments_count ?? 0 }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($clinic->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                            <i class="fas fa-check-circle ml-1"></i>
                                            {{ __('active') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                            <i class="fas fa-times-circle ml-1"></i>
                                            {{ __('inactive') }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        @can('view clinics')
                                        <a href="{{ route('clinics.show', $clinic) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200"
                                           title="{{ __('view') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endcan

                                        @can('edit clinics')
                                        <a href="{{ route('clinics.edit', $clinic) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-green-600 dark:bg-green-700 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition-colors duration-200"
                                           title="{{ __('edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('delete clinics')
                                        <form action="{{ route('clinics.destroy', $clinic) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('confirm_delete_clinic') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 dark:bg-red-700 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition-colors duration-200"
                                                    title="{{ __('delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="bg-gray-100 dark:bg-slate-700 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hospital text-gray-400 dark:text-slate-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-slate-100 mb-2">{{ __('no_clinics') }}</h3>
                <p class="text-gray-600 dark:text-slate-400 mb-6">{{ __('no_clinics_yet') }}</p>
                @can('create clinics')
                <a href="{{ route('clinics.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('add_first_clinic') }}
                </a>
                @endcan
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($clinics->hasPages())
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700 dark:text-slate-300">
                    {{ __('showing') }} {{ $clinics->firstItem() }} {{ __('to') }} {{ $clinics->lastItem() }} {{ __('from') }} {{ $clinics->total() }} {{ __('clinics') }}
                </div>
                <div>
                    {{ $clinics->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
