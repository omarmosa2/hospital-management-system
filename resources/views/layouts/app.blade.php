@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
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
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        * { font-family: 'Tajawal', sans-serif; }
        body { font-family: 'Tajawal', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .sidebar-gradient { background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%); }
        .text-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }

        /* Custom scrollbar - Light Mode */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }

        /* Custom scrollbar - Dark Mode */
        html.dark ::-webkit-scrollbar-track { background: #1e293b; }
        html.dark ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        html.dark ::-webkit-scrollbar-thumb:hover { background: #64748b; }

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

        /* Theme Toggle Button Animation */
        .theme-toggle-btn {
            transition: all 0.3s ease;
        }

        .theme-toggle-btn:hover {
            transform: rotate(20deg);
        }

        /* Dark Mode Specific Styles */
        html.dark .bg-white {
            background-color: #1e293b;
            color: #f1f5f9;
        }

        html.dark .text-gray-900 {
            color: #f1f5f9;
        }

        html.dark .text-gray-600 {
            color: #cbd5e1;
        }

        html.dark .text-gray-400 {
            color: #94a3b8;
        }

        html.dark .border-gray-200 {
            border-color: #334155;
        }

        html.dark .bg-gray-50 {
            background-color: #0f172a;
        }

        html.dark .bg-gray-100 {
            background-color: #1e293b;
        }

        html.dark .shadow-sm,
        html.dark .shadow-lg,
        html.dark .shadow-xl {
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.3);
        }

        html.dark input,
        html.dark textarea,
        html.dark select {
            background-color: #0f172a;
            border-color: #475569;
            color: #f1f5f9;
        }

        html.dark input::placeholder,
        html.dark textarea::placeholder {
            color: #94a3b8;
        }

        html.dark .hover\:bg-gray-100:hover {
            background-color: #334155;
        }

        html.dark .hover\:bg-red-50:hover {
            background-color: #1e293b;
        }

        html.dark .hover\:bg-green-100:hover {
            background-color: #1e293b;
        }
    </style>

    <!-- Tailwind Dark Mode Configuration -->
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-slate-900">
    <div class="min-h-screen flex">
        <!-- Mobile Menu Button -->
        <button class="md:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-lg" onclick="toggleMobileMenu()">
            <i class="fas fa-bars text-gray-600"></i>
        </button>

        <!-- Sidebar -->
        <div class="sidebar-gradient w-64 min-h-screen shadow-xl hidden md:block" id="sidebar">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-8" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-hospital text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-white text-xl font-bold">MediCare</h1>
                        <p class="text-blue-200 text-xs">{{ __('hospital_management') }}</p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>{{ __('dashboard') }}</span>
                    </a>
                    
                    @can('view clinics')
                        @if(auth()->user()->isReceptionist())
                            <a href="{{ route('reception.clinics.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('reception.clinics.*') ? 'bg-blue-600 text-white' : '' }}">
                                <i class="fas fa-hospital w-5"></i>
                                <span>{{ __('clinics') }}</span>
                            </a>
                        @else
                            <a href="{{ route('clinics.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('clinics.*') ? 'bg-blue-600 text-white' : '' }}">
                                <i class="fas fa-hospital w-5"></i>
                                <span>{{ __('clinics') }}</span>
                            </a>
                        @endif
                    @endcan
                    
                    @can('view doctors')
                        @if(auth()->user()->isReceptionist())
                            <a href="{{ route('reception.doctors.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('reception.doctors.*') ? 'bg-blue-600 text-white' : '' }}">
                                <i class="fas fa-user-md w-5"></i>
                                <span>{{ __('doctors') }}</span>
                            </a>
                        @else
                            <a href="{{ route('doctors.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('doctors.*') ? 'bg-blue-600 text-white' : '' }}">
                                <i class="fas fa-user-md w-5"></i>
                                <span>{{ __('doctors') }}</span>
                            </a>
                        @endif
                    @endcan
                    
                    @can('view patients')
                    <a href="{{ route('patients.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('patients.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-users w-5"></i>
                        <span>{{ __('patients') }}</span>
                    </a>
                    @endcan
                    
                    @can('view appointments')
                    <a href="{{ route('appointments.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('appointments.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span>{{ __('appointments') }}</span>
                    </a>
                    @endcan
                    
                    @can('view expenses')
                    <a href="{{ route('expenses.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('expenses.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-receipt w-5"></i>
                        <span>{{ __('hospital_expenses') }}</span>
                    </a>
                    @endcan
                    
                    @can('view salaries')
                    <a href="{{ route('salaries.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('salaries.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>{{ __('salaries') }}</span>
                    </a>
                    @endcan
                    
                    @can('manage accounts')
                    <a href="{{ route('accounts.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('accounts.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-users-cog w-5"></i>
                        <span>{{ __('manage_accounts_system') }}</span>
                    </a>
                    @endcan
                    
                    @can('view patient files')
                    <a href="{{ route('patient-files.index') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200 {{ request()->routeIs('patient-files.*') ? 'bg-blue-600 text-white' : '' }}">
                        <i class="fas fa-folder-open w-5"></i>
                        <span>{{ __('patient_folders') }}</span>
                    </a>
                    @endcan
                </nav>
            </div>

            <!-- User Profile Section -->
            <div class="absolute bottom-0 w-64 p-6 border-t border-blue-600">
                <div class="flex items-center gap-3">
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
                        <div class="absolute bottom-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg py-2 hidden" id="user-menu">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                                <i class="fas fa-user {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('profile') }}
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700">
                                <i class="fas fa-cog {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('settings') }}
                            </a>
                            <hr class="my-1 border-gray-200 dark:border-slate-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-slate-700">
                                    <i class="fas fa-sign-out-alt {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('logout') }}
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
            <header class="bg-white shadow-sm border-b border-gray-200 dark:bg-slate-800 dark:border-slate-700">
                <div class="px-4 md:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="md:block">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-slate-100">@yield('title', __('dashboard'))</h2>
                            <p class="text-gray-600 dark:text-slate-400 text-sm mt-1 hidden md:block">{{ __('welcome') }} {{ __('to_hospital_system') }}</p>
                        </div>
                        <div class="flex items-center gap-2 md:gap-4">
                            <!-- Language Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 p-2 text-gray-400 hover:text-gray-600 dark:text-slate-400 dark:hover:text-slate-200 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors duration-300" title="{{ __('change_language') }}">
                                    <i class="fas fa-globe text-lg md:text-xl"></i>
                                    <span class="hidden md:inline text-sm font-medium">{{ LaravelLocalization::getCurrentLocaleNative() }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute left-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-200 dark:border-slate-700 z-50"
                                     style="display: none;">
                                    <div class="py-1">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors duration-150 {{ app()->getLocale() === $localeCode ? 'bg-gray-50 dark:bg-slate-700/50 font-semibold' : '' }}">
                                                <i class="fas fa-language text-gray-400 dark:text-slate-500"></i>
                                                <span>{{ $properties['native'] }}</span>
                                                @if(app()->getLocale() === $localeCode)
                                                    <i class="fas fa-check text-green-500 mr-auto"></i>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Theme Toggle Button -->
                            <button id="theme-toggle-btn" class="theme-toggle-btn relative p-2 text-gray-400 hover:text-gray-600 dark:text-slate-400 dark:hover:text-slate-200 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors duration-300" title="تبديل الوضع">
                                <i class="fas fa-moon text-lg md:text-xl dark:hidden"></i>
                                <i class="fas fa-sun text-lg md:text-xl hidden dark:inline"></i>
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
        // Wait for theme manager to be ready
        function initializeThemeToggle() {
            if (window.themeManager) {
                console.log('✓ Theme manager is ready');
            } else {
                console.warn('⚠ Theme manager not ready, retrying...');
                setTimeout(initializeThemeToggle, 100);
            }
        }

        // Initialize theme toggle
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeThemeToggle);
        } else {
            initializeThemeToggle();
        }

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

    <!-- Theme Manager Script -->
    <script type="module">
        /**
         * Dark Mode Theme Manager
         * Handles theme switching and persistence
         */
        class ThemeManager {
            constructor() {
                this.STORAGE_KEY = 'hospital-theme-mode';
                this.DARK_CLASS = 'dark';
                this.init();
                this.setupEventListeners();
            }

            init() {
                const savedTheme = localStorage.getItem(this.STORAGE_KEY);
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = savedTheme ? savedTheme === 'dark' : prefersDark;
                this.setTheme(isDark);

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (!localStorage.getItem(this.STORAGE_KEY)) {
                        this.setTheme(e.matches);
                    }
                });
            }

            setupEventListeners() {
                const setupButton = () => {
                    const themeToggleBtn = document.getElementById('theme-toggle-btn');
                    if (themeToggleBtn) {
                        themeToggleBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            this.toggle();
                        });
                        console.log('✓ Theme toggle button initialized');
                    } else {
                        console.warn('⚠ Theme toggle button not found');
                    }
                };

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', setupButton);
                } else {
                    setupButton();
                }
            }

            setTheme(isDark) {
                const html = document.documentElement;
                if (isDark) {
                    html.classList.add(this.DARK_CLASS);
                    localStorage.setItem(this.STORAGE_KEY, 'dark');
                    console.log('🌙 Dark mode enabled');
                } else {
                    html.classList.remove(this.DARK_CLASS);
                    localStorage.setItem(this.STORAGE_KEY, 'light');
                    console.log('☀️ Light mode enabled');
                }
                window.dispatchEvent(new CustomEvent('themechange', { detail: { isDark } }));
            }

            toggle() {
                const isDark = document.documentElement.classList.contains(this.DARK_CLASS);
                console.log('Toggling theme from:', isDark ? 'dark' : 'light');
                this.setTheme(!isDark);
            }

            getCurrentTheme() {
                return document.documentElement.classList.contains(this.DARK_CLASS) ? 'dark' : 'light';
            }

            isDarkMode() {
                return document.documentElement.classList.contains(this.DARK_CLASS);
            }
        }

        // Initialize theme manager
        window.themeManager = new ThemeManager();
        console.log('✓ Theme Manager initialized successfully');
    </script>
</body>
</html>
