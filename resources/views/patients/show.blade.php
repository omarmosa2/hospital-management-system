@extends('layouts.app')

@section('title', 'تفاصيل المريض')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">تفاصيل المريض</h1>
            <p class="text-gray-600 mt-2">معلومات مفصلة عن المريض</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('patients.edit', $patient) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                تعديل
            </a>
            <a href="{{ route('patients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Patient Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <!-- Patient Avatar and Info -->
                <div class="text-center mb-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-3xl font-bold">{{ substr($patient->user->name, 0, 1) }}</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $patient->user->name }}</h2>
                    <p class="text-gray-600">{{ $patient->medical_record_number }}</p>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} سنة</p>
                </div>

                <!-- Contact Information -->
                <div class="space-y-4">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-envelope w-5 mr-3"></i>
                        <span>{{ $patient->user->email }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-phone w-5 mr-3"></i>
                        <span>{{ $patient->phone }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-venus-mars w-5 mr-3"></i>
                        <span>{{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-calendar w-5 mr-3"></i>
                        <span>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') }}</span>
                    </div>
                </div>

                <!-- Emergency Contact -->
                @if($patient->emergency_contact_name)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">جهة الاتصال في الطوارئ</h3>
                        <div class="space-y-2">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-user w-5 mr-3"></i>
                                <span>{{ $patient->emergency_contact_name }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-phone w-5 mr-3"></i>
                                <span>{{ $patient->emergency_contact_phone }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Patient Details and Medical Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Medical Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">المعلومات الطبية</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">التاريخ الطبي</h4>
                        <p class="text-gray-600 text-sm">
                            {{ $patient->medical_history ?: 'لا يوجد تاريخ طبي مسجل' }}
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">الحساسية</h4>
                        <p class="text-gray-600 text-sm">
                            {{ $patient->allergies ?: 'لا توجد حساسية مسجلة' }}
                        </p>
                    </div>
                </div>
                
                @if($patient->address)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2">العنوان</h4>
                        <p class="text-gray-600 text-sm">{{ $patient->address }}</p>
                    </div>
                @endif
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-blue-600"></i>
                        </div>
                        <div class="mr-4">
                            <p class="text-2xl font-bold text-gray-900">{{ $patient->appointments->count() }}</p>
                            <p class="text-gray-600 text-sm">إجمالي المواعيد</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-medical text-green-600"></i>
                        </div>
                        <div class="mr-4">
                            <p class="text-2xl font-bold text-gray-900">{{ $patient->medicalRecords->count() }}</p>
                            <p class="text-gray-600 text-sm">السجلات الطبية</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-prescription text-purple-600"></i>
                        </div>
                        <div class="mr-4">
                            <p class="text-2xl font-bold text-gray-900">{{ $patient->prescriptions->count() }}</p>
                            <p class="text-gray-600 text-sm">الوصفات الطبية</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900">المواعيد الأخيرة</h3>
                    <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        عرض الكل <i class="fas fa-arrow-left mr-1"></i>
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($patient->appointments->take(5) as $appointment)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-md text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $appointment->doctor->user->name ?? 'غير محدد' }}</p>
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
                                    @if($appointment->status == 'scheduled') مجدول
                                    @elseif($appointment->status == 'confirmed') مؤكد
                                    @elseif($appointment->status == 'completed') مكتمل
                                    @else ملغي
                                    @endif
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">لا توجد مواعيد</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Medical Records -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900">السجلات الطبية الأخيرة</h3>
                    <a href="{{ route('medical-records.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        عرض الكل <i class="fas fa-arrow-left mr-1"></i>
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($patient->medicalRecords->take(3) as $record)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-medical text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $record->diagnosis }}</p>
                                    <p class="text-sm text-gray-600">{{ $record->visit_date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="text-left">
                                <p class="text-sm text-gray-500">{{ $record->doctor->user->name ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-file-medical text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">لا توجد سجلات طبية</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
