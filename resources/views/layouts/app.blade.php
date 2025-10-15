<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Hospital Management')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        * { font-family: 'Tajawal', sans-serif; }
        body { font-family: 'Tajawal', sans-serif; direction: rtl; text-align: right; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .sidebar-gradient { background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%); }
        .text-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
        
        /* Animation for cards */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out; }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .card-hover:hover { transform: none; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Mobile Menu Button -->
        <button class="md:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-lg" onclick="toggleMobileMenu()">
            <i class="fas fa-bars text-gray-600"></i>
        </button>

        <!-- Sidebar -->
        <div class="sidebar-gradient w-64 min-h-screen shadow-xl hidden md:block" id="sidebar">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-hospital text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-white text-xl font-bold">MediCare</h1>
                        <p class="text-blue-200 text-xs">Hospital Management</p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>لوحة التحكم</span>
                    </a>
                    
                    @can('view clinics')
                        @if(auth()->user()->isReceptionist())
                            <a href="{{ route('reception.clinics.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('reception.clinics.*') ? 'bg-blue-600 text-white' : '' }}">
                                <i class="fas fa-hospital w-5"></i>
                                <span>العيادات</span>
                            </a>
                        @else
                            <a href="{{ route('clinics.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('clinics.*') ? 'bg-blue-600 text-white' : '' }}">
                                <i class="fas fa-hospital w-5"></i>
                                <span>العيادات</span>
                            </a>
                        @endif
                    @endcan
                    
                    @can('view doctors')
                        @if(auth()->user()->isReceptionist())
                            <a href="{{ route('reception.doctors.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('reception.doctors.*') ? 'bg-blue-600 text-white' : '' }}">
                                <i class="fas fa-user-md w-5"></i>
                                <span>الأطباء</span>
                            </a>
                        @else
                            <a href="{{ route('doctors.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('doctors.*') ? 'bg-blue-600 text-white' : '' }}">
                                <i class="fas fa-user-md w-5"></i>
                                <span>الأطباء</span>
                            </a>
                        @endif
                    @endcan
                    
                    @can('view patients')
                    <a href="{{ route('patients.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('patients.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-users w-5"></i>
                        <span>المرضى</span>
                    </a>
                    @endcan
                    
                    @can('view appointments')
                    <a href="{{ route('appointments.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('appointments.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span>المواعيد</span>
                    </a>
                    @endcan
                    
                    @can('view expenses')
                    <a href="{{ route('expenses.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('expenses.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-receipt w-5"></i>
                        <span>مصروفات المشفى</span>
                    </a>
                    @endcan
                    
                    @can('view salaries')
                    <a href="{{ route('salaries.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('salaries.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>الرواتب</span>
                    </a>
                    @endcan
                    
                    @can('manage accounts')
                    <a href="{{ route('accounts.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('accounts.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-users-cog w-5"></i>
                        <span>إدارة الحسابات</span>
                    </a>
                    @endcan
                    
                    @can('view patient files')
                    <a href="{{ route('patient-files.index') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('patient-files.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-folder-open w-5"></i>
                        <span>أضبارات المرضى</span>
                    </a>
                    @endcan
                </nav>
            </div>

            <!-- User Profile Section -->
            <div class="absolute bottom-0 w-64 p-6 border-t border-blue-600">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-blue-200 text-xs">{{ Auth::user()->getRoleNames()->first() }}</p>
                    </div>
                    <div class="relative">
                        <button type="button" class="text-blue-200 hover:text-white" id="user-menu-button">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="absolute bottom-0 right-0 w-48 bg-white rounded-lg shadow-lg py-2 hidden" id="user-menu">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>الملف الشخصي
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>الإعدادات
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:mr-0">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 md:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="md:block">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900">@yield('title', 'لوحة التحكم')</h2>
                            <p class="text-gray-600 text-sm mt-1 hidden md:block">مرحباً بك في نظام إدارة المستشفى</p>
                        </div>
                        <div class="flex items-center space-x-2 md:space-x-4">
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-bell text-lg md:text-xl"></i>
                                <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                            </button>
                            
                            <!-- Search -->
                            <div class="relative hidden md:block">
                                <input type="text" placeholder="البحث..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            
                            <!-- Mobile Search -->
                            <button class="md:hidden p-2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-search text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="mr-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="mr-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Toggle user menu
        document.getElementById('user-menu-button').addEventListener('click', function(e) {
            e.stopPropagation();
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        });

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const button = document.getElementById('user-menu-button');
            const menu = document.getElementById('user-menu');
            
            if (!button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        // Mobile menu toggle
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('z-40');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileButton = document.querySelector('[onclick="toggleMobileMenu()"]');
            
            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !mobileButton.contains(event.target)) {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('fixed', 'z-40');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('fixed', 'z-40');
                sidebar.classList.remove('hidden');
            } else {
                sidebar.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
