@extends('layouts.app')

@section('title', 'إضافة طبيب جديد')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">إضافة طبيب جديد</h1>
            <p class="text-gray-600 mt-2">أدخل معلومات الطبيب الجديد</p>
        </div>
        <a href="{{ route('doctors.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
            <i class="fas fa-arrow-right mr-2"></i>
            العودة للقائمة
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <form action="{{ route('doctors.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Personal Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">المعلومات الشخصية</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div>
            </div>

            <!-- Professional Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">المعلومات المهنية</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="clinic_id" class="block text-sm font-medium text-gray-700 mb-2">العيادة <span class="text-red-500">*</span></label>
                        <select id="clinic_id" name="clinic_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('clinic_id') border-red-500 @enderror"
                                onchange="loadClinicWorkingHours()">
                            <option value="">اختر العيادة</option>
                            @foreach($clinics as $clinic)
                                <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                    {{ $clinic->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('clinic_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    
                    <div>
                        <label for="consultation_fee" class="block text-sm font-medium text-gray-700 mb-2">رسوم الاستشارة ($)</label>
                        <input type="number" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') }}" step="0.01" min="0" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('consultation_fee') border-red-500 @enderror">
                        @error('consultation_fee')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
            </div>

            <!-- Working Hours -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">ساعات العمل</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                        $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
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
                                               {{ old('working_hours.'.$index.'.enabled', true) ? 'checked' : '' }}
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
                                           value="{{ old('working_hours.'.$index.'.start', '09:00') }}"
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">إلى</label>
                                    <input type="time" name="working_hours[{{ $index }}][end]" 
                                           value="{{ old('working_hours.'.$index.'.end', '17:00') }}"
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('doctors.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    إلغاء
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    حفظ الطبيب
                </button>
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
            input.value = '';
        });
    }
}

// Load clinic working hours
function loadClinicWorkingHours() {
    const clinicId = document.getElementById('clinic_id').value;
    
    if (!clinicId) {
        // Reset all days to default state
        for (let i = 0; i < 7; i++) {
            const checkbox = document.querySelector(`input[name="working_hours[${i}][enabled]"]`);
            const startInput = document.querySelector(`input[name="working_hours[${i}][start]"]`);
            const endInput = document.querySelector(`input[name="working_hours[${i}][end]"]`);
            
            checkbox.checked = true;
            startInput.value = '09:00';
            endInput.value = '17:00';
            toggleDayHours(i);
        }
        return;
    }
    
    // Fetch clinic working hours
    fetch(`/clinics/${clinicId}/working-hours`)
        .then(response => response.json())
        .then(data => {
            const workingHours = data.working_hours || [];
            
            for (let i = 0; i < 7; i++) {
                const checkbox = document.querySelector(`input[name="working_hours[${i}][enabled]"]`);
                const startInput = document.querySelector(`input[name="working_hours[${i}][start]"]`);
                const endInput = document.querySelector(`input[name="working_hours[${i}][end]"]`);
                
                if (workingHours[i] && workingHours[i].enabled) {
                    checkbox.checked = true;
                    startInput.value = workingHours[i].start || '09:00';
                    endInput.value = workingHours[i].end || '17:00';
                } else {
                    checkbox.checked = false;
                    startInput.value = '';
                    endInput.value = '';
                }
                
                toggleDayHours(i);
            }
        })
        .catch(error => {
            console.error('Error loading clinic working hours:', error);
        });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    for (let i = 0; i < 7; i++) {
        toggleDayHours(i);
    }
    
    // Load clinic working hours if clinic is already selected
    const clinicId = document.getElementById('clinic_id').value;
    if (clinicId) {
        loadClinicWorkingHours();
    }
});
</script>
@endsection