<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - تسجيل الدخول</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        * { font-family: 'Tajawal', sans-serif; }
        body { font-family: 'Tajawal', sans-serif; direction: rtl; text-align: right; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .floating-animation {
            animation: floating 6s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Background with animated elements -->
    <div class="min-h-screen gradient-bg relative overflow-hidden">
        <!-- Floating shapes -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white opacity-10 rounded-full floating-animation"></div>
        <div class="absolute top-40 right-20 w-32 h-32 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-20 left-1/4 w-16 h-16 bg-white opacity-10 rounded-full floating-animation" style="animation-delay: -4s;"></div>
        <div class="absolute bottom-40 right-1/3 w-24 h-24 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: -1s;"></div>
        
        <!-- Main content -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <div class="w-full sm:max-w-md mt-6 fade-in">
                <!-- Logo and title -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4">
                        <i class="fas fa-hospital text-3xl text-blue-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">نظام إدارة المستشفى</h1>
                    <p class="text-blue-100">مرحباً بك، يرجى تسجيل الدخول للمتابعة</p>
                </div>

                <!-- Login form -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="mr-3">
                                    <h3 class="text-sm font-medium text-red-800">حدث خطأ في تسجيل الدخول</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-blue-600"></i>
                                البريد الإلكتروني
                            </label>
                            <div class="relative">
                                <input id="email" 
                                       class="input-focus block w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-300" 
                                       type="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus 
                                       placeholder="أدخل بريدك الإلكتروني" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Password field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-blue-600"></i>
                                كلمة المرور
                            </label>
                            <div class="relative">
                                <input id="password" 
                                       class="input-focus block w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-300" 
                                       type="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="أدخل كلمة المرور" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Remember me and forgot password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" 
                                       type="checkbox" 
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" 
                                       name="remember">
                                <span class="mr-2 text-sm text-gray-600">تذكرني</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-blue-600 hover:text-blue-500 transition-colors duration-200" href="{{ route('password.request') }}">
                                    نسيت كلمة المرور؟
                                </a>
                            @endif
                        </div>

                        <!-- Login button -->
                        <div>
                            <button type="submit" class="btn-hover w-full flex justify-center items-center px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 border border-transparent rounded-xl font-semibold text-white uppercase tracking-widest hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                تسجيل الدخول
                            </button>
                        </div>
                    </form>

                    <!-- Demo credentials -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            بيانات الدخول التجريبية:
                        </h4>
                        <div class="text-xs text-blue-700 space-y-1">
                            <div><strong>البريد الإلكتروني:</strong> admin@hospital.com</div>
                            <div><strong>كلمة المرور:</strong> password123</div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8">
                    <p class="text-blue-100 text-sm">
                        © {{ date('Y') }} نظام إدارة المستشفى. جميع الحقوق محفوظة.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for enhanced interactions -->
    <script>
        // Add loading state to form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.querySelector('button[type="submit"]');
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>جاري تسجيل الدخول...';
            button.disabled = true;
        });

        // Add focus effects to inputs
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
            });
        });

        // Auto-fill demo credentials on click
        document.querySelector('.bg-blue-50').addEventListener('click', function() {
            document.getElementById('email').value = 'admin@hospital.com';
            document.getElementById('password').value = 'password123';
        });
    </script>
</body>
</html>
