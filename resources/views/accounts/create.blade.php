@extends('layouts.app')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">إنشاء حساب جديد</h1>
            <p class="text-gray-600 mt-2">قم بملء البيانات التالية لإنشاء حساب جديد</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                رجوع للحسابات
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <form action="{{ route('accounts.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    المعلومات الأساسية
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            الاسم الكامل <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="أدخل الاسم الكامل"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            البريد الإلكتروني <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="أدخل البريد الإلكتروني"
                               required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Password Section -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-lock text-green-600 mr-2"></i>
                    كلمة المرور
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            كلمة المرور <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               placeholder="أدخل كلمة المرور"
                               required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            تأكيد كلمة المرور <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="أعد إدخال كلمة المرور"
                               required>
                    </div>
                </div>
                
                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="mr-3">
                            <h3 class="text-sm font-medium text-blue-800">متطلبات كلمة المرور</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>يجب أن تكون 8 أحرف على الأقل</li>
                                    <li>يجب أن تحتوي على أحرف وأرقام</li>
                                    <li>يُنصح باستخدام رموز خاصة</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Roles Section -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-tag text-purple-600 mr-2"></i>
                    الأدوار والصلاحيات
                </h3>
                
                <div class="space-y-4">
                    <p class="text-sm text-gray-600 mb-4">اختر الأدوار المناسبة للحساب الجديد:</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($roles as $role)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="role_{{ $role->id }}" 
                                           name="roles[]" 
                                           value="{{ $role->id }}"
                                           {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="role_{{ $role->id }}" class="mr-3 text-sm font-medium text-gray-700 cursor-pointer">
                                        @if($role->name == 'Admin') 
                                            <div class="flex items-center">
                                                <i class="fas fa-crown text-red-500 mr-2"></i>
                                                مدير
                                            </div>
                                        @elseif($role->name == 'Doctor') 
                                            <div class="flex items-center">
                                                <i class="fas fa-user-md text-blue-500 mr-2"></i>
                                                طبيب
                                            </div>
                                        @elseif($role->name == 'Nurse') 
                                            <div class="flex items-center">
                                                <i class="fas fa-user-nurse text-green-500 mr-2"></i>
                                                ممرض
                                            </div>
                                        @elseif($role->name == 'Receptionist') 
                                            <div class="flex items-center">
                                                <i class="fas fa-user-tie text-yellow-500 mr-2"></i>
                                                موظف استقبال
                                            </div>
                                        @elseif($role->name == 'Patient') 
                                            <div class="flex items-center">
                                                <i class="fas fa-user text-purple-500 mr-2"></i>
                                                مريض
                                            </div>
                                        @else 
                                            <div class="flex items-center">
                                                <i class="fas fa-user text-gray-500 mr-2"></i>
                                                {{ $role->name }}
                                            </div>
                                        @endif
                                    </label>
                                </div>
                                
                                <!-- Role Description -->
                                <div class="mt-2 text-xs text-gray-500">
                                    @if($role->name == 'Admin')
                                        صلاحيات كاملة في النظام
                                    @elseif($role->name == 'Doctor')
                                        إدارة المرضى والمواعيد والوصفات
                                    @elseif($role->name == 'Nurse')
                                        عرض البيانات الطبية والمساعدة
                                    @elseif($role->name == 'Receptionist')
                                        إدارة المواعيد والفواتير
                                    @elseif($role->name == 'Patient')
                                        عرض مواعيده وبياناته الطبية
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('roles')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Account Status -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-toggle-on text-orange-600 mr-2"></i>
                    حالة الحساب
                </h3>
                
                <div class="flex items-center space-x-3">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="mr-2 text-sm font-medium text-gray-700">
                            تفعيل الحساب فوراً
                        </label>
                    </div>
                </div>
                
                <p class="text-sm text-gray-500 mt-2">
                    إذا تم إلغاء تحديد هذا الخيار، سيتم إنشاء الحساب في حالة غير مفعل
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    إنشاء الحساب
                </button>
                <a href="{{ route('accounts.index') }}" 
                   class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength = getPasswordStrength(password);
    updatePasswordStrengthIndicator(strength);
});

function getPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return strength;
}

function updatePasswordStrengthIndicator(strength) {
    // This function can be expanded to show visual password strength indicator
    console.log('Password strength:', strength);
}
</script>
@endsection
