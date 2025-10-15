@extends('layouts.app')

@section('title', 'أضبارة المريض')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">أضبارة المريض</h1>
            <p class="text-gray-600 mt-2">{{ $patient->user->name }} - رقم الملف: {{ $patient->medical_record_number }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('patient-files.generate-pdf', $patient) }}" 
               class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                <i class="fas fa-file-pdf mr-2"></i>
                تحميل PDF
            </a>
            <a href="{{ route('patient-files.print', $patient) }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-print mr-2"></i>
                طباعة
            </a>
            <a href="{{ route('patient-files.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                رجوع للأضبارات
            </a>
        </div>
    </div>

    <!-- Patient Information Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">{{ substr($patient->user->name, 0, 1) }}</span>
                    </div>
                    <div class="mr-4">
                        <h2 class="text-2xl font-bold">{{ $patient->user->name }}</h2>
                        <p class="text-blue-100">رقم الملف: {{ $patient->medical_record_number }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-blue-100">تاريخ التسجيل</div>
                    <div class="text-lg font-semibold">{{ $patient->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $patient->age ?? 'غير محدد' }}</div>
                    <div class="text-sm text-gray-500">العمر</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</div>
                    <div class="text-sm text-gray-500">الجنس</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $patient->appointments->count() }}</div>
                    <div class="text-sm text-gray-500">المواعيد</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $patient->medicalRecords->count() }}</div>
                    <div class="text-sm text-gray-500">السجلات الطبية</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user text-blue-600 mr-2"></i>
                المعلومات الشخصية
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">الاسم الكامل:</span>
                    <span class="font-medium">{{ $patient->user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">البريد الإلكتروني:</span>
                    <span class="font-medium">{{ $patient->user->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">رقم الهاتف:</span>
                    <span class="font-medium">{{ $patient->phone ?? 'غير محدد' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">العنوان:</span>
                    <span class="font-medium">{{ $patient->address ?? 'غير محدد' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">تاريخ الميلاد:</span>
                    <span class="font-medium">{{ $patient->date_of_birth ? $patient->date_of_birth->format('d/m/Y') : 'غير محدد' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">الحالة الاجتماعية:</span>
                    <span class="font-medium">{{ $patient->marital_status ?? 'غير محدد' }}</span>
                </div>
            </div>
        </div>

        <!-- Medical Information -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-heartbeat text-red-600 mr-2"></i>
                المعلومات الطبية
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">فصيلة الدم:</span>
                    <span class="font-medium">{{ $patient->blood_type ?? 'غير محدد' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">الوزن:</span>
                    <span class="font-medium">{{ $patient->weight ?? 'غير محدد' }} كغ</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">الطول:</span>
                    <span class="font-medium">{{ $patient->height ?? 'غير محدد' }} سم</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">الحساسية:</span>
                    <span class="font-medium">{{ $patient->allergies ?? 'لا توجد' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">الأمراض المزمنة:</span>
                    <span class="font-medium">{{ $patient->chronic_conditions ?? 'لا توجد' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">الأدوية الحالية:</span>
                    <span class="font-medium">{{ $patient->current_medications ?? 'لا توجد' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments History -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-calendar-alt text-green-600 mr-2"></i>
                تاريخ المواعيد
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الطبيب</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العيادة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السبب</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الرسوم</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($patient->appointments as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $appointment->appointment_date->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $appointment->appointment_time }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $appointment->doctor->user->name ?? 'غير محدد' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $appointment->clinic->name ?? 'غير محدد' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $appointment->reason ?? 'غير محدد' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($appointment->status == 'scheduled') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status == 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($appointment->status == 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($appointment->status == 'scheduled') مجدول
                                    @elseif($appointment->status == 'confirmed') مؤكد
                                    @elseif($appointment->status == 'completed') مكتمل
                                    @else ملغي
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ number_format($appointment->fee ?? 0, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                لا توجد مواعيد مسجلة
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Medical Records -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-file-medical text-purple-600 mr-2"></i>
                السجلات الطبية
            </h3>
        </div>
        <div class="p-6">
            @forelse($patient->medicalRecords as $record)
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">{{ $record->title }}</h4>
                        <span class="text-sm text-gray-500">{{ $record->created_at->format('d/m/Y') }}</span>
                    </div>
                    <p class="text-gray-600 text-sm">{{ $record->description }}</p>
                    @if($record->diagnosis)
                        <div class="mt-2">
                            <span class="text-sm font-medium text-gray-700">التشخيص:</span>
                            <span class="text-sm text-gray-600">{{ $record->diagnosis }}</span>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">لا توجد سجلات طبية</p>
            @endforelse
        </div>
    </div>

    <!-- Prescriptions -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-prescription-bottle-alt text-orange-600 mr-2"></i>
                الوصفات الطبية
            </h3>
        </div>
        <div class="p-6">
            @forelse($patient->prescriptions as $prescription)
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">وصفة طبية #{{ $prescription->id }}</h4>
                        <span class="text-sm text-gray-500">{{ $prescription->created_at->format('d/m/Y') }}</span>
                    </div>
                    @if($prescription->medications->count() > 0)
                        <div class="mt-2">
                            <span class="text-sm font-medium text-gray-700">الأدوية:</span>
                            <ul class="mt-1 text-sm text-gray-600">
                                @foreach($prescription->medications as $medication)
                                    <li>• {{ $medication->name }} - {{ $medication->dosage }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($prescription->notes)
                        <div class="mt-2">
                            <span class="text-sm font-medium text-gray-700">ملاحظات:</span>
                            <span class="text-sm text-gray-600">{{ $prescription->notes }}</span>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">لا توجد وصفات طبية</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
