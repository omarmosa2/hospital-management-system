<!-- Nurse Dashboard -->
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">مرحباً، {{ auth()->user()->name }}</h1>
                <p class="text-green-100 text-lg">ممرض - لوحة التحكم</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4">
                <i class="fas fa-user-nurse text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">المرضى اليوم</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['today_patients'] ?? 0 }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">السجلات الطبية</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['medical_records'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-file-medical text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">الوصفات الطبية</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['prescriptions'] ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-prescription-bottle-alt text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">المواعيد المكتملة</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['completed_appointments'] ?? 0 }}</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <i class="fas fa-check-circle text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Medical Records -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">أحدث السجلات الطبية</h3>
                <a href="{{ route('medical-records.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    عرض الكل
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recent_medical_records ?? [] as $record)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-medical text-green-600"></i>
                            </div>
                            <div class="mr-3">
                                <p class="font-medium text-gray-900">{{ $record->title }}</p>
                                <p class="text-sm text-gray-500">{{ $record->patient->user->name ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $record->created_at->format('d/m/Y') }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">لا توجد سجلات طبية حديثة</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">الإجراءات السريعة</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('medical-records.create') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-file-medical text-green-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-green-900">سجل طبي جديد</span>
                </a>
                <a href="{{ route('prescriptions.create') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-prescription-bottle-alt text-purple-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-purple-900">وصفة طبية</span>
                </a>
                <a href="{{ route('patients.index') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-blue-900">المرضى</span>
                </a>
                <a href="{{ route('appointments.index') }}" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <i class="fas fa-calendar-alt text-orange-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-orange-900">المواعيد</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Prescriptions -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">أحدث الوصفات الطبية</h3>
            <a href="{{ route('prescriptions.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                عرض الكل
            </a>
        </div>
        <div class="space-y-3">
            @forelse($recent_prescriptions ?? [] as $prescription)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-prescription-bottle-alt text-purple-600"></i>
                        </div>
                        <div class="mr-3">
                            <p class="font-medium text-gray-900">وصفة #{{ $prescription->id }}</p>
                            <p class="text-sm text-gray-500">{{ $prescription->patient->user->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $prescription->created_at->format('d/m/Y') }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">لا توجد وصفات طبية حديثة</p>
            @endforelse
        </div>
    </div>
</div>
