@extends('layouts.app')

@section('title', __('hospital_expenses'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ __('hospital_expenses') }}</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">{{ __('manage_hospital_expenses_purchases') }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                {{ __('add_new_expense') }}
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <div class="relative">
                    <input type="text" placeholder="{{ __('search_for_expense') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 dark:text-slate-400"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>{{ __('all_categories') }}</option>
                    <option>{{ __('equipment') }}</option>
                    <option>{{ __('medicines') }}</option>
                    <option>{{ __('utilities') }}</option>
                    <option>{{ __('maintenance') }}</option>
                    <option>{{ __('staff') }}</option>
                    <option>{{ __('supplies') }}</option>
                    <option>{{ __('other') }}</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>{{ __('all_statuses') }}</option>
                    <option>{{ __('pending') }}</option>
                    <option>{{ __('approved') }}</option>
                    <option>{{ __('paid') }}</option>
                    <option>{{ __('rejected') }}</option>
                </select>
                <input type="date" class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
            </div>
        </div>
    </div>

    <!-- Expenses List -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">{{ __('expense_list') }}</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('expense_number') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('title') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('category') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('amount') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('payment_method') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('status') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('date') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $expense->expense_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                                        <i class="fas fa-receipt text-red-600 dark:text-red-400"></i>
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $expense->title }}</div>
                                        <div class="text-sm text-gray-500 dark:text-slate-400">{{ Str::limit($expense->description, 30) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    {{ $expense->category_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-slate-100">
                                ${{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                {{ $expense->payment_method_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($expense->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                    @elseif($expense->status == 'approved') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                    @elseif($expense->status == 'paid') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                    @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                    @endif">
                                    {{ $expense->status_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                {{ $expense->expense_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('expenses.show', $expense) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('expenses.edit', $expense) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($expense->status == 'pending')
                                        <form action="{{ route('expenses.approve', $expense) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300" title="{{ __('approve') }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('expenses.reject', $expense) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" title="{{ __('reject') }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @elseif($expense->status == 'approved')
                                        <form action="{{ route('expenses.markPaid', $expense) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300" title="{{ __('mark_as_paid') }}">
                                                <i class="fas fa-credit-card"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('confirm_delete_expense') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-receipt text-gray-300 dark:text-slate-600 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">{{ __('no_expenses') }}</h3>
                                    <p class="text-gray-500 dark:text-slate-400 mb-6">{{ __('no_expenses_yet') }}</p>
                                    <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        {{ __('add_first_expense') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($expenses->hasPages())
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            {{ $expenses->links() }}
        </div>
    @endif
</div>

@endsection
