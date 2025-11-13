@extends('layouts.app')

@section('title', 'الرواتب')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">الرواتب</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">إدارة رواتب الأطباء وتوزيع الإيرادات</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition-colors duration-200">
                <i class="fas fa-print mr-2"></i>
                طباعة التقرير
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <div class="mr-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-slate-400">إجمالي الإيرادات</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-slate-100">${{ number_format($totalPayments, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-md text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div class="mr-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-slate-400">إجمالي رواتب الأطباء</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-slate-100">${{ number_format($totalDoctorSalaries, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hospital text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <div class="mr-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-slate-400">حصة العيادات</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-slate-100">${{ number_format($totalClinicShare, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctors Salaries Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">تفاصيل رواتب الأطباء</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">
                            الطبيب
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">
                            العيادة
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">
                            عدد المواعيد
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">
                            رسوم الاستشارة
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            إجمالي الدفعات
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            راتب الطبيب
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            حصة العيادة
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الحالة
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($doctors as $doctor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">{{ substr($doctor['name'], 0, 1) }}</span>
                                </div>
                                <div class="mr-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $doctor['name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $doctor['email'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $doctor['clinic_name'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $doctor['appointments_count'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($doctor['consultation_fee'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${{ number_format($doctor['total_payments'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                            ${{ number_format($doctor['doctor_salary'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600">
                            ${{ number_format($doctor['clinic_share'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $doctor['is_available'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                {{ $doctor['is_available'] ? 'متاح' : 'غير متاح' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-user-md text-4xl mb-4"></i>
                                <p class="text-lg font-medium">لا توجد بيانات رواتب</p>
                                <p class="text-sm">لم يتم العثور على أي أطباء أو دفعات</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Footer -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">${{ number_format($totalPayments, 2) }}</div>
                <div class="text-sm text-gray-500">إجمالي الإيرادات</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">${{ number_format($totalDoctorSalaries, 2) }}</div>
                <div class="text-sm text-gray-500">إجمالي رواتب الأطباء (70%)</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">${{ number_format($totalClinicShare, 2) }}</div>
                <div class="text-sm text-gray-500">حصة العيادات (30%)</div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
}
</style>
@endsection
