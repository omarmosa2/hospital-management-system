<!-- Receptionist Dashboard -->
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 dark:from-blue-700 dark:to-purple-800 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ __('hello') }}، {{ auth()->user()->name }}</h1>
                <p class="text-blue-100 dark:text-blue-200 text-lg">{{ __('receptionist_dashboard') }}</p>
            </div>
            <div class="bg-white bg-opacity-20 dark:bg-opacity-30 rounded-full p-4">
                <i class="fas fa-user-tie text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-slate-400 text-sm font-medium">{{ __('appointments_today') }}</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['today_appointments'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-3">
                    <i class="fas fa-calendar-day text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-slate-400 text-sm font-medium">{{ __('scheduled_appointments') }}</p>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['scheduled_appointments'] ?? 0 }}</p>
                </div>
                <div class="bg-yellow-100 dark:bg-yellow-900 rounded-full p-3">
                    <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-slate-400 text-sm font-medium">{{ __('new_patients') }}</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['new_patients'] ?? 0 }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 rounded-full p-3">
                    <i class="fas fa-user-plus text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-slate-400 text-sm font-medium">{{ __('total_bills') }}</p>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['total_bills'] ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 rounded-full p-3">
                    <i class="fas fa-file-invoice-dollar text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Appointments -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('upcoming_appointments') }}</h3>
                <a href="{{ route('appointments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    {{ __('view_all') }}
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recent_appointments ?? [] as $appointment)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-medium text-sm">{{ substr($appointment->patient->user->name ?? 'N', 0, 1) }}</span>
                            </div>
                            <div class="mr-3">
                                <p class="font-medium text-gray-900">{{ $appointment->patient->user->name ?? __('not_specified') }}</p>
                                <p class="text-sm text-gray-500">{{ $appointment->appointment_date->format('d/m/Y') }} - {{ $appointment->appointment_time }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($appointment->status == 'scheduled') bg-yellow-100 text-yellow-800
                            @elseif($appointment->status == 'confirmed') bg-blue-100 text-blue-800
                            @elseif($appointment->status == 'completed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @if($appointment->status == 'scheduled') {{ __('scheduled') }}
                            @elseif($appointment->status == 'confirmed') {{ __('confirmed') }}
                            @elseif($appointment->status == 'completed') {{ __('completed') }}
                            @else {{ __('cancelled') }}
                            @endif
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">{{ __('no_upcoming_appointments') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('quick_actions') }}</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('appointments.create') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-plus-circle text-blue-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-blue-900">{{ __('book_new_appointment') }}</span>
                </a>
                <a href="{{ route('patients.create') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-user-plus text-green-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-green-900">{{ __('add_patient') }}</span>
                </a>
                <a href="{{ route('bills.create') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-file-invoice text-purple-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-purple-900">{{ __('create_bill') }}</span>
                </a>
                <a href="{{ route('appointments.index') }}" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <i class="fas fa-calendar-alt text-orange-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-orange-900">{{ __('manage_appointments_text') }}</span>
                </a>
                <a href="{{ route('reception.doctors.index') }}" class="flex flex-col items-center p-4 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                    <i class="fas fa-list text-teal-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-teal-900">{{ __('view_doctors') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('recent_activity') }}</h3>
        <div class="space-y-3">
            @forelse($recent_activity ?? [] as $activity)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-{{ $activity['icon'] }} text-blue-600 text-sm"></i>
                    </div>
                    <div class="mr-3">
                        <p class="text-sm font-medium text-gray-900">{{ $activity['message'] }}</p>
                        <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">{{ __('no_recent_activity') }}</p>
            @endforelse
        </div>
    </div>
</div>
