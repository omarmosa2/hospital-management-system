<!-- Doctor Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- My Appointments Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg card-hover border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">مواعيدي</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['my_appointments'] ?? 0 }}</p>
                <p class="text-blue-600 text-sm mt-1">
                    <i class="fas fa-calendar mr-1"></i>إجمالي المواعيد
                </p>
            </div>
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Today's Appointments Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg card-hover border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">مواعيد اليوم</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['today_appointments'] ?? 0 }}</p>
                <p class="text-green-600 text-sm mt-1">
                    <i class="fas fa-clock mr-1"></i>مواعيد مجدولة
                </p>
            </div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-day text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Appointments Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg card-hover border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">مواعيد معلقة</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_appointments'] ?? 0 }}</p>
                <p class="text-yellow-600 text-sm mt-1">
                    <i class="fas fa-hourglass-half mr-1"></i>تحتاج تأكيد
                </p>
            </div>
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- My Patients Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg card-hover border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">مرضاي</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['my_patients'] ?? 0 }}</p>
                <p class="text-purple-600 text-sm mt-1">
                    <i class="fas fa-user-friends mr-1"></i>إجمالي المرضى
                </p>
            </div>
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Doctor's Schedule and Recent Appointments -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Today's Schedule -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">جدول اليوم</h3>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                <span class="text-sm text-gray-600">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
        <div class="space-y-4">
            <!-- Sample schedule items -->
            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">أحمد محمد</p>
                        <p class="text-sm text-gray-600">فحص دوري</p>
                    </div>
                </div>
                <div class="text-left">
                    <p class="text-sm font-medium text-gray-900">09:00</p>
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">مؤكد</span>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">فاطمة علي</p>
                        <p class="text-sm text-gray-600">متابعة</p>
                    </div>
                </div>
                <div class="text-left">
                    <p class="text-sm font-medium text-gray-900">11:30</p>
                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">مجدول</span>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">محمد حسن</p>
                        <p class="text-sm text-gray-600">استشارة</p>
                    </div>
                </div>
                <div class="text-left">
                    <p class="text-sm font-medium text-gray-900">14:00</p>
                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">مؤكد</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">المواعيد الأخيرة</h3>
            <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                عرض الكل <i class="fas fa-arrow-left mr-1"></i>
            </a>
        </div>
        <div class="space-y-4">
            @if(isset($stats['recent_appointments']) && $stats['recent_appointments']->count() > 0)
                @foreach($stats['recent_appointments'] as $appointment)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $appointment->patient->user->name ?? 'غير محدد' }}</p>
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
                @endforeach
            @else
                <div class="text-center py-8">
                    <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">لا توجد مواعيد حديثة</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-2xl p-6 shadow-lg">
    <h3 class="text-xl font-bold text-gray-900 mb-6">إجراءات سريعة</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('appointments.create') }}" class="flex items-center space-x-3 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors duration-200">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-plus text-blue-600"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-900">موعد جديد</p>
                <p class="text-sm text-gray-600">إضافة موعد</p>
            </div>
        </a>
        
        <a href="{{ route('patients.create') }}" class="flex items-center space-x-3 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors duration-200">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-plus text-green-600"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-900">مريض جديد</p>
                <p class="text-sm text-gray-600">إضافة مريض</p>
            </div>
        </a>
        
        <a href="{{ route('medical-records.create') }}" class="flex items-center space-x-3 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors duration-200">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-file-medical text-purple-600"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-900">سجل طبي</p>
                <p class="text-sm text-gray-600">إضافة سجل</p>
            </div>
        </a>
        
        <a href="{{ route('prescriptions.create') }}" class="flex items-center space-x-3 p-4 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-colors duration-200">
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-prescription text-yellow-600"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-900">وصفة طبية</p>
                <p class="text-sm text-gray-600">كتابة وصفة</p>
            </div>
        </a>
    </div>
</div>
