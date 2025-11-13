@extends('layouts.app')

@section('title', 'المرضى')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">المرضى</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">إدارة معلومات المرضى والسجلات الطبية</p>
        </div>
        @can('create patients')
        <div class="mt-4 md:mt-0">
            <a href="{{ route('patients.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                إضافة مريض جديد
            </a>
        </div>
        @endcan
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-900 dark:to-blue-800 rounded-2xl p-6 text-white shadow-lg dark:shadow-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 dark:text-blue-300 text-sm font-medium">إجمالي المرضى</p>
                    <p class="text-3xl font-bold">{{ $stats['total_patients'] }}</p>
                </div>
                <div class="bg-blue-400 dark:bg-blue-700 rounded-full p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 dark:from-green-900 dark:to-green-800 rounded-2xl p-6 text-white shadow-lg dark:shadow-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 dark:text-green-300 text-sm font-medium">الذكور</p>
                    <p class="text-3xl font-bold">{{ $stats['male_patients'] }}</p>
                </div>
                <div class="bg-green-400 dark:bg-green-700 rounded-full p-3">
                    <i class="fas fa-male text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-pink-500 to-pink-600 dark:from-pink-900 dark:to-pink-800 rounded-2xl p-6 text-white shadow-lg dark:shadow-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-100 dark:text-pink-300 text-sm font-medium">الإناث</p>
                    <p class="text-3xl font-bold">{{ $stats['female_patients'] }}</p>
                </div>
                <div class="bg-pink-400 dark:bg-pink-700 rounded-full p-3">
                    <i class="fas fa-female text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 dark:from-purple-900 dark:to-purple-800 rounded-2xl p-6 text-white shadow-lg dark:shadow-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 dark:text-purple-300 text-sm font-medium">إجمالي المواعيد</p>
                    <p class="text-3xl font-bold">{{ $stats['total_appointments'] }}</p>
                </div>
                <div class="bg-purple-400 dark:bg-purple-700 rounded-full p-3">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <div class="relative">
                    <input type="text" placeholder="البحث عن مريض..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 dark:text-slate-500"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>جميع الأعمار</option>
                    <option>0-18</option>
                    <option>19-35</option>
                    <option>36-50</option>
                    <option>50+</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>جميع الجنس</option>
                    <option>ذكر</option>
                    <option>أنثى</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Patients Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">قائمة المرضى</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">المريض</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">رقم المريض الطبي</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">العمر</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">الجنس</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">الهاتف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">المواعيد</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-blue-600 dark:from-green-700 dark:to-blue-700 rounded-full flex items-center justify-center">
                                        <span class="text-white font-medium text-sm">{{ substr($patient->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $patient->user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-slate-400">{{ $patient->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-slate-100">{{ $patient->medical_record_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-slate-100">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} سنة</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $patient->gender == 'male' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 'bg-pink-100 dark:bg-pink-900 text-pink-800 dark:text-pink-200' }}">
                                    {{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-slate-100">{{ $patient->phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                    {{ $patient->appointments_count }} موعد
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('edit patients')
                                    <a href="{{ route('patients.edit', $patient) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('delete patients')
                                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المريض؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-user-injured text-gray-300 dark:text-slate-600 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">لا توجد مرضى</h3>
                                    <p class="text-gray-500 dark:text-slate-400 mb-6">لم يتم تسجيل أي مرضى بعد</p>
                                    @can('create patients')
                                    <a href="{{ route('patients.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        إضافة أول مريض
                                    </a>
                                    @endcan
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
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            {{ $patients->links() }}
        </div>
    @endif
</div>
@endsection