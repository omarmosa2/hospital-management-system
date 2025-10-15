<!-- Patient Statistics Cards -->
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

    <!-- Upcoming Appointments Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg card-hover border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">المواعيد القادمة</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['upcoming_appointments'] ?? 0 }}</p>
                <p class="text-green-600 text-sm mt-1">
                    <i class="fas fa-clock mr-1"></i>مواعيد مجدولة
                </p>
            </div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- My Prescriptions Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg card-hover border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">وصفاتي الطبية</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['my_prescriptions'] ?? 0 }}</p>
                <p class="text-yellow-600 text-sm mt-1">
                    <i class="fas fa-prescription mr-1"></i>وصفات نشطة
                </p>
            </div>
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-prescription-bottle text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- My Bills Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg card-hover border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">فواتيري</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['my_bills'] ?? 0 }}</p>
                <p class="text-purple-600 text-sm mt-1">
                    <i class="fas fa-file-invoice mr-1"></i>إجمالي الفواتير
                </p>
            </div>
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-file-invoice-dollar text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Appointments and Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Upcoming Appointments -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">المواعيد القادمة</h3>
            <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                عرض الكل <i class="fas fa-arrow-left mr-1"></i>
            </a>
        </div>
        <div class="space-y-4">
            <!-- Sample upcoming appointments -->
            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">د. أحمد محمد</p>
                        <p class="text-sm text-gray-600">طبيب القلب</p>
                        <p class="text-xs text-gray-500">غداً - 10:00 صباحاً</p>
                    </div>
                </div>
                <div class="text-left">
                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">مؤكد</span>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-gray-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">د. فاطمة علي</p>
                        <p class="text-sm text-gray-600">طبيبة أطفال</p>
                        <p class="text-xs text-gray-500">الخميس - 2:00 مساءً</p>
                    </div>
                </div>
                <div class="text-left">
                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">مجدول</span>
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

<!-- Quick Actions and Health Summary -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <h3 class="text-xl font-bold text-gray-900 mb-6">إجراءات سريعة</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('appointments.create') }}" class="flex items-center space-x-3 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors duration-200">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-plus text-blue-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">حجز موعد</p>
                    <p class="text-sm text-gray-600">حجز موعد جديد</p>
                </div>
            </a>
            
            <a href="{{ route('medical-records.index') }}" class="flex items-center space-x-3 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors duration-200">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-medical text-green-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">السجل الطبي</p>
                    <p class="text-sm text-gray-600">عرض السجل الطبي</p>
                </div>
            </a>
            
            <a href="{{ route('prescriptions.index') }}" class="flex items-center space-x-3 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors duration-200">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-prescription text-purple-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">الوصفات الطبية</p>
                    <p class="text-sm text-gray-600">عرض الوصفات</p>
                </div>
            </a>
            
            <a href="{{ route('bills.index') }}" class="flex items-center space-x-3 p-4 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-colors duration-200">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-invoice text-yellow-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">الفواتير</p>
                    <p class="text-sm text-gray-600">عرض الفواتير</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Health Summary -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <h3 class="text-xl font-bold text-gray-900 mb-6">ملخص الصحة</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-heart text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">معدل النبض</p>
                        <p class="text-sm text-gray-600">72 نبضة/دقيقة</p>
                    </div>
                </div>
                <span class="text-green-600 font-bold">طبيعي</span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-thermometer-half text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">درجة الحرارة</p>
                        <p class="text-sm text-gray-600">36.5°C</p>
                    </div>
                </div>
                <span class="text-blue-600 font-bold">طبيعي</span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-weight text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">الوزن</p>
                        <p class="text-sm text-gray-600">70 كيلو</p>
                    </div>
                </div>
                <span class="text-yellow-600 font-bold">مستقر</span>
            </div>
        </div>
    </div>
</div>
