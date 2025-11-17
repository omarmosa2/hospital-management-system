@extends('layouts.app')

@section('title', __('edit_clinic'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ __('edit_clinic') }}</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">{{ __('edit_info') }}: {{ $clinic->name }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('clinics.show', $clinic) }}" class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-200">
                <i class="fas fa-eye mr-2"></i>
                {{ __('view') }}
            </a>
            <a href="{{ route('clinics.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                {{ __('back_to_list') }}
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <form action="{{ route('clinics.update', $clinic) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="border-b border-gray-200 dark:border-slate-700 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mr-2"></i>
                    {{ __('basic_information') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                            {{ __('clinic_name') }} <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $clinic->name) }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('name') border-red-500 @enderror"
                               placeholder="{{ __('enter_clinic_name') }}"
                               required>
                        @error('name')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                            {{ __('location') }}
                        </label>
                        <input type="text"
                               id="location"
                               name="location"
                               value="{{ old('location', $clinic->location) }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('location') border-red-500 @enderror"
                               placeholder="{{ __('enter_clinic_location') }}">
                        @error('location')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>


            <!-- Additional Information -->
            <div class="border-b border-gray-200 dark:border-slate-700 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center">
                    <i class="fas fa-file-alt text-purple-600 dark:text-purple-400 mr-2"></i>
                    {{ __('additional_information') }}
                </h3>

                <div class="space-y-6">
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                            {{ __('description') }}
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('description') border-red-500 @enderror"
                                  placeholder="{{ __('enter_brief_clinic_description') }}">{{ old('description', $clinic->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox"
                               id="is_active"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $clinic->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-slate-600 rounded">
                        <label for="is_active" class="mr-2 text-sm font-medium text-gray-700 dark:text-slate-300">
                            {{ __('clinic_active') }}
                        </label>
                    </div>
                </div>
            </div>

            <!-- Working Hours -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center">
                    <i class="fas fa-clock text-orange-600 dark:text-orange-400 mr-2"></i>
                    {{ __('working_hours') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                        $workingHours = old('working_hours', $clinic->working_hours ?? []);
                    @endphp
                    @foreach($days as $index => $day)
                        <div class="border border-gray-200 dark:border-slate-600 rounded-lg p-4 bg-white dark:bg-slate-700">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-medium text-gray-900 dark:text-slate-100">{{ $day }}</h4>
                                <label class="flex items-center">
                                    <span class="mr-2 text-sm text-gray-600 dark:text-slate-400">{{ __('enabled') }}</span>
                                    <div class="relative inline-block w-12 h-6">
                                        <input type="checkbox"
                                               name="working_hours[{{ $index }}][enabled]"
                                               value="1"
                                               {{ isset($workingHours[$index]['enabled']) && $workingHours[$index]['enabled'] ? 'checked' : '' }}
                                               class="day-toggle sr-only"
                                               onchange="toggleDayHours({{ $index }})">
                                        <div class="toggle-bg bg-gray-200 dark:bg-slate-600 border-2 border-gray-200 dark:border-slate-600 rounded-full h-6 w-12 transition-colors duration-200 ease-in-out"></div>
                                        <div class="toggle-dot absolute left-0 top-0 bg-white border-2 border-gray-200 dark:border-slate-600 rounded-full h-6 w-6 shadow transform transition-transform duration-200 ease-in-out"></div>
                                    </div>
                                </label>
                            </div>
                            <div class="space-y-2 day-hours" id="day-hours-{{ $index }}">
                                <div>
                                    <label class="block text-xs text-gray-600 dark:text-slate-400 mb-1">{{ __('from') }}</label>
                                    <input type="time" name="working_hours[{{ $index }}][start]"
                                           value="{{ $workingHours[$index]['start'] ?? '09:00' }}"
                                           class="w-full px-2 py-1 border border-gray-300 dark:border-slate-600 rounded text-sm bg-white dark:bg-slate-600 text-gray-900 dark:text-slate-100">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 dark:text-slate-400 mb-1">{{ __('to') }}</label>
                                    <input type="time" name="working_hours[{{ $index }}][end]"
                                           value="{{ $workingHours[$index]['end'] ?? '17:00' }}"
                                           class="w-full px-2 py-1 border border-gray-300 dark:border-slate-600 rounded text-sm bg-white dark:bg-slate-600 text-gray-900 dark:text-slate-100">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-slate-700">
                <button type="submit"
                        class="flex-1 bg-blue-600 dark:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    {{ __('save_changes') }}
                </button>
                <a href="{{ route('clinics.index') }}"
                   class="flex-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    {{ __('cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

.day-toggle:checked + .toggle-bg {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.day-toggle:checked ~ .toggle-dot {
    transform: translateX(24px);
    border-color: #3b82f6;
}

.toggle-bg {
    cursor: pointer;
}

.toggle-dot {
    cursor: pointer;
}
</style>

<script>
function toggleDayHours(dayIndex) {
    const checkbox = document.querySelector(`input[name="working_hours[${dayIndex}][enabled]"]`);
    const dayHours = document.getElementById(`day-hours-${dayIndex}`);
    const timeInputs = dayHours.querySelectorAll('input[type="time"]');
    
    if (checkbox.checked) {
        dayHours.style.opacity = '1';
        dayHours.style.pointerEvents = 'auto';
        timeInputs.forEach(input => {
            input.disabled = false;
            input.required = true;
        });
    } else {
        dayHours.style.opacity = '0.5';
        dayHours.style.pointerEvents = 'none';
        timeInputs.forEach(input => {
            input.disabled = true;
            input.required = false;
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    for (let i = 0; i < 7; i++) {
        toggleDayHours(i);
    }
    
    // Show success message if any
    @if(session('success'))
        alert('{{ session('success') }}');
    @endif
    
    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
});
</script>
@endsection
