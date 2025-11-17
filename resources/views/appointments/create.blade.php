    @extends('layouts.app')

@section('title', __('book_new_appointment'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('book_new_appointment') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('book_appointment_between') }}</p>
        </div>
        <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
            <i class="fas fa-arrow-right mr-2"></i>
            {{ __('back_to_list') }}
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <form action="{{ route('appointments.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Patient, Clinic and Doctor Selection -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('select_patient_clinic_doctor') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('patient') }}</label>
                        <select id="patient_id" name="patient_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('patient_id') border-red-500 @enderror">
                            <option value="">{{ __('select_patient') }}</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user->name }} - {{ $patient->medical_record_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="clinic_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('clinic') }} <span class="text-red-500">*</span></label>
                        <select id="clinic_id" name="clinic_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('clinic_id') border-red-500 @enderror">
                            <option value="">{{ __('select_clinic') }}</option>
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
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('doctor') }}</label>
                        <select id="doctor_id" name="doctor_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('doctor_id') border-red-500 @enderror">
                            <option value="">{{ __('select_doctor') }}</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" data-clinic="{{ $doctor->clinic_id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->user->name }} - {{ $doctor->specialty }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Appointment Details -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('appointment_details') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">{{ __('appointment_date') }}</label>
                        <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('appointment_date') border-red-500 @enderror">
                        @error('appointment_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">{{ __('appointment_time') }}</label>
                        <input type="time" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('appointment_time') border-red-500 @enderror">
                        @error('appointment_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">{{ __('appointment_status') }}</label>
                        <select id="status" name="status" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>{{ __('scheduled') }}</option>
                            <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>{{ __('confirmed') }}</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="fee" class="block text-sm font-medium text-gray-700 mb-2">{{ __('appointment_fee') }} ($)</label>
                        <input type="number" id="fee" name="fee" value="{{ old('fee') }}" step="0.01" min="0" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fee') border-red-500 @enderror">
                        @error('fee')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">{{ __('appointment_reason') }}</label>
                    <textarea id="reason" name="reason" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('reason') border-red-500 @enderror"
                              placeholder="{{ __('enter_appointment_reason_symptoms') }}">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Additional Notes -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('additional_notes') }}</h3>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">{{ __('notes') }}</label>
                    <textarea id="notes" name="notes" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                              placeholder="{{ __('any_additional_notes_about_appointment') }}">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('appointments.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    {{ __('cancel') }}
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    {{ __('book_appointment') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Filter doctors based on selected clinic
document.getElementById('clinic_id').addEventListener('change', function() {
    const clinicId = this.value;
    const doctorSelect = document.getElementById('doctor_id');
    const doctorOptions = doctorSelect.querySelectorAll('option');
    
    // Reset doctor selection
    doctorSelect.value = '';
    
    // Show/hide doctors based on clinic
    doctorOptions.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            const doctorClinicId = option.getAttribute('data-clinic');
            if (clinicId && doctorClinicId !== clinicId) {
                option.style.display = 'none';
            } else {
                option.style.display = 'block';
            }
        }
    });
});

// Auto-populate fee when doctor is selected
document.getElementById('doctor_id').addEventListener('change', function() {
    const doctorId = this.value;
    if (doctorId) {
        // You can make an AJAX call here to get the doctor's consultation fee
        // For now, we'll use a simple approach
        fetch(`/doctors/${doctorId}/fee`)
            .then(response => response.json())
            .then(data => {
                if (data.fee) {
                    document.getElementById('fee').value = data.fee;
                }
            })
            .catch(error => {
                console.log('Could not fetch doctor fee');
            });
    }
});

// Set minimum date to today
document.getElementById('appointment_date').min = new Date().toISOString().split('T')[0];
</script>
@endsection
