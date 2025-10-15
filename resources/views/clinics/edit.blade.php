@extends('layouts.app')

@section('title', 'تعديل العيادة')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">تعديل العيادة</h1>
            <p class="text-gray-600 mt-2">تعديل معلومات العيادة: {{ $clinic->name }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('clinics.show', $clinic) }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-eye mr-2"></i>
                عرض
            </a>
            <a href="{{ route('clinics.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <form action="{{ route('clinics.update', $clinic) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    المعلومات الأساسية
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            اسم العيادة <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $clinic->name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="أدخل اسم العيادة"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            الموقع
                        </label>
                        <input type="text" 
                               id="location" 
                               name="location" 
                               value="{{ old('location', $clinic->location) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-500 @enderror"
                               placeholder="أدخل موقع العيادة">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>


            <!-- Additional Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-file-alt text-purple-600 mr-2"></i>
                    معلومات إضافية
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            الوصف
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="أدخل وصفاً مختصراً للعيادة">{{ old('description', $clinic->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $clinic->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="mr-2 text-sm font-medium text-gray-700">
                            العيادة نشطة
                        </label>
                    </div>
                </div>
            </div>

            <!-- Working Hours -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-clock text-orange-600 mr-2"></i>
                    ساعات العمل
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                        $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                        $workingHours = old('working_hours', $clinic->working_hours ?? []);
                    @endphp
                    @foreach($days as $index => $day)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-medium text-gray-900">{{ $day }}</h4>
                                <label class="flex items-center">
                                    <span class="mr-2 text-sm text-gray-600">مفعل</span>
                                    <div class="relative inline-block w-12 h-6">
                                        <input type="checkbox" 
                                               name="working_hours[{{ $index }}][enabled]" 
                                               value="1"
                                               {{ isset($workingHours[$index]['enabled']) && $workingHours[$index]['enabled'] ? 'checked' : '' }}
                                               class="day-toggle sr-only"
                                               onchange="toggleDayHours({{ $index }})">
                                        <div class="toggle-bg bg-gray-200 border-2 border-gray-200 rounded-full h-6 w-12 transition-colors duration-200 ease-in-out"></div>
                                        <div class="toggle-dot absolute left-0 top-0 bg-white border-2 border-gray-200 rounded-full h-6 w-6 shadow transform transition-transform duration-200 ease-in-out"></div>
                                    </div>
                                </label>
                            </div>
                            <div class="space-y-2 day-hours" id="day-hours-{{ $index }}">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">من</label>
                                    <input type="time" name="working_hours[{{ $index }}][start]" 
                                           value="{{ $workingHours[$index]['start'] ?? '09:00' }}"
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">إلى</label>
                                    <input type="time" name="working_hours[{{ $index }}][end]" 
                                           value="{{ $workingHours[$index]['end'] ?? '17:00' }}"
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    حفظ التغييرات
                </button>
                <a href="{{ route('clinics.index') }}" 
                   class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    إلغاء
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
