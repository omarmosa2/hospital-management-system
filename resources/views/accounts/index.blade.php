@extends('layouts.app')

@section('title', 'إدارة الحسابات')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">إدارة الحسابات</h1>
            <p class="text-gray-600 mt-2">إدارة جميع حسابات المستخدمين في النظام</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 mr-3">
                <i class="fas fa-plus mr-2"></i>
                إنشاء حساب جديد
            </a>
            <button onclick="exportAccounts()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                تصدير البيانات
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <div class="relative">
                    <input type="text" placeholder="البحث عن حساب..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>جميع الأدوار</option>
                    <option>مدير</option>
                    <option>طبيب</option>
                    <option>ممرض</option>
                    <option>موظف استقبال</option>
                    <option>مريض</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>جميع الحالات</option>
                    <option>نشط</option>
                    <option>غير نشط</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Accounts Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">قائمة الحسابات</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المستخدم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">البريد الإلكتروني</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الدور</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">كلمة المرور</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإنشاء</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($role->name == 'Admin') bg-red-100 text-red-800
                                        @elseif($role->name == 'Doctor') bg-blue-100 text-blue-800
                                        @elseif($role->name == 'Nurse') bg-green-100 text-green-800
                                        @elseif($role->name == 'Receptionist') bg-yellow-100 text-yellow-800
                                        @elseif($role->name == 'Patient') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($role->name == 'Admin') مدير
                                        @elseif($role->name == 'Doctor') طبيب
                                        @elseif($role->name == 'Nurse') ممرض
                                        @elseif($role->name == 'Receptionist') موظف استقبال
                                        @elseif($role->name == 'Patient') مريض
                                        @else {{ $role->name }}
                                        @endif
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <input type="password" 
                                           value="••••••••" 
                                           class="text-sm font-mono bg-gray-100 border-0 rounded px-2 py-1 w-24" 
                                           readonly>
                                    <button onclick="showPassword({{ $user->id }})" 
                                            class="mr-2 text-blue-600 hover:text-blue-900" 
                                            title="إظهار كلمة المرور">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas fa-circle text-xs mr-1"></i>
                                    {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('accounts.edit', $user) }}" 
                                       class="text-blue-600 hover:text-blue-900" 
                                       title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('accounts.toggleStatus', $user) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-yellow-600 hover:text-yellow-900" 
                                                title="{{ $user->is_active ? 'إلغاء تفعيل' : 'تفعيل' }}">
                                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('accounts.resetPassword', $user) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-purple-600 hover:text-purple-900" 
                                                title="إعادة تعيين كلمة المرور"
                                                onclick="return confirm('هل أنت متأكد من إعادة تعيين كلمة المرور؟')">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('accounts.destroy', $user) }}" 
                                              method="POST" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900" 
                                                    title="حذف"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا الحساب؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد حسابات</h3>
                                    <p class="text-gray-500">لم يتم العثور على أي حسابات في النظام</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Password Modal -->
<div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">كلمة المرور</h3>
                <button onclick="closePasswordModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الحالية</label>
                <input type="text" id="passwordValue" readonly
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 font-mono">
            </div>
            <div class="flex justify-end">
                <button onclick="closePasswordModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    إغلاق
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showPassword(userId) {
    // In a real application, you would fetch the password from the server
    // For security reasons, we'll show a placeholder
    document.getElementById('passwordValue').value = '•••••••• (مشفر)';
    document.getElementById('passwordModal').classList.remove('hidden');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
}

function exportAccounts() {
    // In a real application, you would implement CSV/Excel export
    alert('سيتم تنفيذ تصدير البيانات قريباً');
}
</script>
@endsection
