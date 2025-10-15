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

    <!-- Doctors Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($doctors as $doctor)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="p-6">
                    <!-- Doctor Avatar and Status -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xl font-bold">{{ substr($doctor->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $doctor->user->name }}</h3>
                                <p class="text-gray-600">طبيب</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $doctor->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                {{ $doctor->is_available ? 'متاح' : 'غير متاح' }}
                            </span>
                        </div>
                    </div>

                    <!-- Doctor Info -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope w-5 mr-3"></i>
                            <span class="text-sm">{{ $doctor->user->email }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone w-5 mr-3"></i>
                            <span class="text-sm">{{ $doctor->phone }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-dollar-sign w-5 mr-3"></i>
                            <span class="text-sm font-medium">${{ number_format($doctor->consultation_fee, 2) }}</span>
                        </div>
                    </div>

                    <!-- Bio -->
                    @if($doctor->bio)
                        <p class="text-gray-600 text-sm mb-6 line-clamp-2">{{ $doctor->bio }}</p>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="{{ route('doctors.show', $doctor) }}" class="flex-1 bg-blue-50 text-blue-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-blue-100 transition-colors duration-200">
                            <i class="fas fa-eye mr-1"></i>
                            عرض
                        </a>
                        <a href="{{ route('doctors.edit', $doctor) }}" class="flex-1 bg-green-50 text-green-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-green-100 transition-colors duration-200">
                            <i class="fas fa-edit mr-1"></i>
                            تعديل
                        </a>
                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors duration-200">
                                <i class="fas fa-trash mr-1"></i>
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <i class="fas fa-user-md text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد أطباء</h3>
                    <p class="text-gray-600 mb-6">لم يتم إضافة أي أطباء بعد</p>
                    <a href="{{ route('doctors.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        إضافة أول طبيب
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($doctors->hasPages())
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            {{ $doctors->links() }}
        </div>
    @endif
</div>
@endsection