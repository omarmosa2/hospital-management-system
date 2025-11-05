@extends('layouts.app')

@section('title', 'الأطباء')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">الأطباء</h1>
            <p class="text-gray-600 mt-2">إدارة معلومات الأطباء والمتخصصين</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('doctors.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                إضافة طبيب جديد
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <div class="relative">
                    <input type="text" placeholder="البحث عن طبيب..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>جميع الأطباء</option>
                    <option>متاح</option>
                    <option>غير متاح</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>جميع الحالات</option>
                    <option>متاح</option>
                    <option>غير متاح</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Doctors Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($doctors->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-green-500 to-green-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-user-md ml-2"></i>
                                اسم الطبيب
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-envelope ml-2"></i>
                                البريد الإلكتروني
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-hospital ml-2"></i>
                                العيادة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-phone ml-2"></i>
                                رقم الهاتف
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-dollar-sign ml-2"></i>
                                رسوم الاستشارة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-toggle-on ml-2"></i>
                                الحالة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-cog ml-2"></i>
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($doctors as $doctor)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <!-- Doctor Name -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-bold">{{ substr($doctor->user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $doctor->user->name }}</div>
                                            <div class="text-xs text-gray-500">طبيب</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <i class="fas fa-envelope text-gray-400 ml-2"></i>
                                        {{ $doctor->user->email }}
                                    </div>
                                </td>

                                <!-- Clinic -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <i class="fas fa-hospital text-gray-400 ml-2"></i>
                                        {{ $doctor->clinic->name ?? 'غير محدد' }}
                                    </div>
                                </td>

                                <!-- Phone -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <i class="fas fa-phone text-gray-400 ml-2"></i>
                                        {{ $doctor->phone }}
                                    </div>
                                </td>

                                <!-- Consultation Fee -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-dollar-sign ml-2"></i>
                                            {{ number_format($doctor->consultation_fee, 2) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Availability Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($doctor->is_available)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle ml-1"></i>
                                            متاح
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle ml-1"></i>
                                            غير متاح
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('doctors.show', $doctor) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                           title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('doctors.edit', $doctor) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200"
                                           title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                                                    title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-md text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد أطباء</h3>
                <p class="text-gray-600 mb-6">لم يتم إضافة أي أطباء بعد</p>
                <a href="{{ route('doctors.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    إضافة أول طبيب
                </a>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($doctors->hasPages())
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            {{ $doctors->links() }}
        </div>
    @endif
</div>
@endsection