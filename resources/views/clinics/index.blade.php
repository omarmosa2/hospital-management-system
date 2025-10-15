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

    <!-- Clinics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($clinics as $clinic)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="p-6">
                    <!-- Clinic Header and Status -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-hospital text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $clinic->name }}</h3>
                                <p class="text-gray-600">{{ $clinic->location }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $clinic->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                {{ $clinic->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </div>
                    </div>

                    <!-- Clinic Info -->
                    <div class="space-y-3 mb-6">
                        @if($clinic->description)
                        <div class="flex items-start text-gray-600">
                            <i class="fas fa-info-circle w-5 mr-3 mt-0.5"></i>
                            <span class="text-sm">{{ Str::limit($clinic->description, 80) }}</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone w-5 mr-3"></i>
                            <span class="text-sm">{{ $clinic->phone }}</span>
                        </div>
                        
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope w-5 mr-3"></i>
                            <span class="text-sm">{{ $clinic->email }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-user-md w-5 mr-3"></i>
                                <span class="text-sm">الأطباء</span>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $clinic->doctors_count }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt w-5 mr-3"></i>
                                <span class="text-sm">المواعيد</span>
                            </div>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $clinic->appointments_count }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        @can('view clinics')
                        <a href="{{ route('clinics.show', $clinic) }}" class="flex-1 bg-blue-50 text-blue-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-blue-100 transition-colors duration-200">
                            <i class="fas fa-eye mr-1"></i>
                            عرض
                        </a>
                        @endcan
                        
                        @can('edit clinics')
                        <a href="{{ route('clinics.edit', $clinic) }}" class="flex-1 bg-green-50 text-green-600 px-4 py-2 rounded-lg text-center text-sm font-medium hover:bg-green-100 transition-colors duration-200">
                            <i class="fas fa-edit mr-1"></i>
                            تعديل
                        </a>
                        @endcan
                        
                        @can('delete clinics')
                        <form action="{{ route('clinics.destroy', $clinic) }}" method="POST" class="flex-1" onsubmit="return confirm('هل أنت متأكد من حذف هذه العيادة؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors duration-200">
                                <i class="fas fa-trash mr-1"></i>
                                حذف
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <i class="fas fa-hospital text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد عيادات</h3>
                    <p class="text-gray-600 mb-6">لم يتم إضافة أي عيادات بعد</p>
                    @can('create clinics')
                    <a href="{{ route('clinics.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        إضافة أول عيادة
                    </a>
                    @endcan
                </div>
            </div>
        @endforelse
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
