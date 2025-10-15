@extends('layouts.app')

@section('title', 'أضبارات المرضى')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">أضبارات المرضى</h1>
            <p class="text-gray-600 mt-2">إدارة ومراجعة أضبارات المرضى الطبية</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="exportAllFiles()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                تصدير جميع الأضبارات
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <div class="relative">
                    <input type="text" placeholder="البحث عن مريض..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>جميع الأعمار</option>
                    <option>0-18 سنة</option>
                    <option>19-35 سنة</option>
                    <option>36-50 سنة</option>
                    <option>50+ سنة</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>جميع الحالات</option>
                    <option>نشط</option>
                    <option>غير نشط</option>
                </select>
                <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>
    </div>

    <!-- Patient Files List -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">قائمة أضبارات المرضى</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المريض</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رقم الملف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العمر</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الجنس</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الهاتف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المواعيد</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السجلات الطبية</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">آخر زيارة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-lg font-bold">{{ substr($patient->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $patient->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $patient->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $patient->medical_record_number }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $patient->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $patient->age ?? 'غير محدد' }} سنة
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $patient->gender == 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    <i class="fas fa-{{ $patient->gender == 'male' ? 'male' : 'female' }} mr-1"></i>
                                    {{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $patient->phone ?? 'غير محدد' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                                    {{ $patient->appointments->count() }} موعد
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-file-medical text-green-500 mr-2"></i>
                                    {{ $patient->medicalRecords->count() }} سجل
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($patient->appointments->count() > 0)
                                    {{ $patient->appointments->sortByDesc('appointment_date')->first()->appointment_date->format('d/m/Y') }}
                                @else
                                    لا توجد زيارات
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('patient-files.show', $patient) }}" 
                                       class="text-blue-600 hover:text-blue-900" 
                                       title="عرض الأضبارة">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('patient-files.generate-pdf', $patient) }}" 
                                       class="text-red-600 hover:text-red-900" 
                                       title="تحميل PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    
                                    <a href="{{ route('patient-files.print', $patient) }}" 
                                       target="_blank"
                                       class="text-green-600 hover:text-green-900" 
                                       title="طباعة">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-folder-open text-gray-300 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد أضبارات</h3>
                                    <p class="text-gray-500">لم يتم العثور على أي أضبارات للمرضى</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($patients->hasPages())
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            {{ $patients->links() }}
        </div>
    @endif
</div>

<script>
function exportAllFiles() {
    // In a real application, you would implement bulk PDF export
    alert('سيتم تنفيذ تصدير جميع الأضبارات قريباً');
}
</script>
@endsection
