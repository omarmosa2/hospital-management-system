<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Patients Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg card-hover border-l-4 border-blue-500 dark:shadow-slate-900">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-slate-400 text-sm font-medium">{{ __('total_patients') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-slate-100 mt-2">{{ $stats['total_patients'] ?? 0 }}</p>
                <p class="text-green-600 dark:text-green-400 text-sm mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>+12% {{ __('from_last_month') }}
                </p>
            </div>
            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-blue-600 dark:text-blue-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Doctors Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg card-hover border-l-4 border-green-500 dark:shadow-slate-900">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-slate-400 text-sm font-medium">{{ __('total_doctors') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-slate-100 mt-2">{{ $stats['total_doctors'] ?? 0 }}</p>
                <p class="text-green-600 dark:text-green-400 text-sm mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>+3 {{ __('this_month') }}
                </p>
            </div>
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                <i class="fas fa-user-md text-green-600 dark:text-green-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Today's Appointments Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg card-hover border-l-4 border-yellow-500 dark:shadow-slate-900">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-slate-400 text-sm font-medium">{{ __('todays_appointments') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-slate-100 mt-2">{{ $stats['today_appointments'] ?? 0 }}</p>
                <p class="text-yellow-600 dark:text-yellow-400 text-sm mt-1">
                    <i class="fas fa-clock mr-1"></i>{{ __('scheduled_text') }}
                </p>
            </div>
            <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-day text-yellow-600 dark:text-yellow-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Revenue Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg card-hover border-l-4 border-purple-500 dark:shadow-slate-900">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-slate-400 text-sm font-medium">{{ __('total_revenue') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-slate-100 mt-2">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</p>
                <p class="text-purple-600 dark:text-purple-400 text-sm mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>+8% {{ __('from_last_month') }}
                </p>
            </div>
            <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                <i class="fas fa-dollar-sign text-purple-600 dark:text-purple-400 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Appointments Chart -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100">{{ __('appointments_overview') }}</h3>
            <div class="flex space-x-2">
                <button class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full text-sm font-medium">{{ __('this_month_text') }}</button>
                <button class="px-3 py-1 text-gray-500 dark:text-slate-400 rounded-full text-sm font-medium">{{ __('this_week') }}</button>
            </div>
        </div>
        <div class="h-64">
            <canvas id="appointmentsChart"></canvas>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100">{{ __('monthly_revenue') }}</h3>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                <span class="text-sm text-gray-600 dark:text-slate-400">{{ __('revenue') }}</span>
            </div>
        </div>
        <div class="h-64">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Data Tables -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Appointments -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900">
        <div class="p-6 border-b border-gray-100 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100">{{ __('recent_appointments') }}</h3>
                <a href="{{ route('appointments.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                    {{ __('view_all') }} <i class="fas fa-arrow-left mr-1"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            @if(isset($stats['recent_appointments']) && $stats['recent_appointments']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['recent_appointments'] as $appointment)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-600 transition-colors duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar text-blue-600 dark:text-blue-400"></i>
                                </div>
                            <div>
                                    <p class="font-semibold text-gray-900 dark:text-slate-100">{{ $appointment->patient->user->name ?? __('not_specified') }}</p>
                                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ $appointment->doctor->user->name ?? __('not_specified') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-500">{{ $appointment->appointment_date->format('d M Y - H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-left">
                                <span class="px-3 py-1 text-xs rounded-full font-medium
                                @if($appointment->status == 'scheduled') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                @elseif($appointment->status == 'confirmed') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                @elseif($appointment->status == 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                @endif">
                                    @if($appointment->status == 'scheduled') {{ __('scheduled') }}
                                    @elseif($appointment->status == 'confirmed') {{ __('confirmed') }}
                                    @elseif($appointment->status == 'completed') {{ __('completed') }}
                                    @else {{ __('cancelled') }}
                                    @endif
                            </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-calendar-times text-gray-300 dark:text-slate-600 text-4xl mb-4"></i>
                    <p class="text-gray-500 dark:text-slate-400">{{ __('no_recent_appointments') }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Bills -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900">
        <div class="p-6 border-b border-gray-100 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100">{{ __('recent_bills') }}</h3>
                <a href="{{ route('bills.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                    {{ __('view_all') }} <i class="fas fa-arrow-left mr-1"></i>
                </a>
            </div>
        </div>
        <div class="p-6">
            @if(isset($stats['recent_bills']) && $stats['recent_bills']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['recent_bills'] as $bill)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-600 transition-colors duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-invoice-dollar text-green-600 dark:text-green-400"></i>
                                </div>
                            <div>
                                    <p class="font-semibold text-gray-900 dark:text-slate-100">{{ $bill->patient->user->name ?? __('not_specified') }}</p>
                                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('bill_number') }} #{{ $bill->bill_number }}</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-500">{{ $bill->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="text-left">
                                <p class="font-bold text-gray-900 dark:text-slate-100">${{ number_format($bill->total_amount, 2) }}</p>
                                <span class="px-3 py-1 text-xs rounded-full font-medium
                                    @if($bill->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                    @elseif($bill->status == 'paid') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                    @elseif($bill->status == 'partial') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                    @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                    @endif">
                                    @if($bill->status == 'pending') {{ __('pending') }}
                                    @elseif($bill->status == 'paid') {{ __('paid') }}
                                    @elseif($bill->status == 'partial') {{ __('partial') }}
                                    @else {{ __('cancelled') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-file-invoice text-gray-300 dark:text-slate-600 text-4xl mb-4"></i>
                    <p class="text-gray-500 dark:text-slate-400">{{ __('no_recent_bills') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Appointments Chart
const appointmentsCtx = document.getElementById('appointmentsChart').getContext('2d');
new Chart(appointmentsCtx, {
    type: 'doughnut',
    data: {
        labels: ['{{ __('scheduled') }}', '{{ __('confirmed') }}', '{{ __('completed') }}', '{{ __('cancelled') }}'],
        datasets: [{
            data: [{{ $stats['pending_appointments'] ?? 0 }}, 5, 10, 2],
            backgroundColor: ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            }
        }
    }
});

// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: ['{{ __('january') }}', '{{ __('february') }}', '{{ __('march') }}', '{{ __('april') }}', '{{ __('may') }}', '{{ __('june') }}'],
        datasets: [{
            label: '{{ __('revenue') }}',
            data: [12000, 19000, 15000, 25000, 22000, 30000],
            borderColor: '#8B5CF6',
            backgroundColor: 'rgba(139, 92, 246, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#8B5CF6',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
