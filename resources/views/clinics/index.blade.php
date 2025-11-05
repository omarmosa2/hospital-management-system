@extends('layouts.app')

@section('title', 'العيادات')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">العيادات</h1>
            <p class="text-gray-600 mt-2">إدارة عيادات المستشفى والمتخصصين</p>
        </div>
        <div class="mt-4 md:mt-0">
            @can('create clinics')
            <a href="{{ route('clinics.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                إضافة عيادة جديدة
            </a>
            @endcan
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <div class="relative">
                    <input type="text" placeholder="البحث عن عيادة..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>جميع المواقع</option>
                    <option>الطابق الأول</option>
                    <option>الطابق الثاني</option>
                    <option>الطابق الثالث</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>جميع الحالات</option>
                    <option>نشط</option>
                    <option>غير نشط</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Clinics Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($clinics->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-500 to-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-hospital ml-2"></i>
                                اسم العيادة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-map-marker-alt ml-2"></i>
                                الموقع
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-info-circle ml-2"></i>
                                الوصف
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-user-md ml-2"></i>
                                عدد الأطباء
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                <i class="fas fa-calendar-alt ml-2"></i>
                                عدد المواعيد
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
                        @foreach($clinics as $clinic)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <!-- Clinic Name -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-hospital text-white"></i>
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $clinic->name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Location -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <i class="fas fa-map-marker-alt text-gray-400 ml-2"></i>
                                        {{ $clinic->location ?? 'غير محدد' }}
                                    </div>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-xs">
                                        {{ $clinic->description ? Str::limit($clinic->description, 60) : 'لا يوجد وصف' }}
                                    </div>
                                </td>

                                <!-- Doctors Count -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-user-md ml-2"></i>
                                            {{ $clinic->doctors_count ?? 0 }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Appointments Count -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-calendar-alt ml-2"></i>
                                            {{ $clinic->appointments_count ?? 0 }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($clinic->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle ml-1"></i>
                                            نشط
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle ml-1"></i>
                                            غير نشط
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        @can('view clinics')
                                        <a href="{{ route('clinics.show', $clinic) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                           title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endcan

                                        @can('edit clinics')
                                        <a href="{{ route('clinics.edit', $clinic) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200"
                                           title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('delete clinics')
                                        <form action="{{ route('clinics.destroy', $clinic) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذه العيادة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                                                    title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
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
                    <i class="fas fa-hospital text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد عيادات</h3>
                <p class="text-gray-600 mb-6">لم يتم إضافة أي عيادات بعد</p>
                @can('create clinics')
                <a href="{{ route('clinics.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    إضافة أول عيادة
                </a>
                @endcan
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($clinics->hasPages())
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    عرض {{ $clinics->firstItem() }} إلى {{ $clinics->lastItem() }} من {{ $clinics->total() }} عيادة
                </div>
                <div>
                    {{ $clinics->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
