@extends('layouts.app')

@section('title', __('add_new_expense'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ __('add_new_expense') }}</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">{{ __('fill_data_to_add') }} {{ __('expenses') }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('expenses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                {{ __('back_to_expenses') }}
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <form action="{{ route('expenses.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="border-b border-gray-200 dark:border-slate-700 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mr-2"></i>
                    {{ __('basic_information') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                            {{ __('expense_title') }} <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('title') border-red-500 @enderror"
                               placeholder="{{ __('enter_expense_title') }}"
                               required>
                        @error('title')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                            {{ __('category') }} <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <select id="category"
                                name="category"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 @error('category') border-red-500 @enderror"
                                required>
                            <option value="">{{ __('select_category') }}</option>
                            <option value="equipment" {{ old('category') == 'equipment' ? 'selected' : '' }}>{{ __('equipment') }}</option>
                            <option value="medicines" {{ old('category') == 'medicines' ? 'selected' : '' }}>{{ __('medicines') }}</option>
                            <option value="utilities" {{ old('category') == 'utilities' ? 'selected' : '' }}>{{ __('utilities') }}</option>
                            <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>{{ __('maintenance') }}</option>
                            <option value="staff" {{ old('category') == 'staff' ? 'selected' : '' }}>{{ __('staff') }}</option>
                            <option value="supplies" {{ old('category') == 'supplies' ? 'selected' : '' }}>{{ __('supplies') }}</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>{{ __('other') }}</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6 space-y-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                        {{ __('description') }}
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('description') border-red-500 @enderror"
                              placeholder="{{ __('enter_detailed_expense_description') }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Financial Information -->
            <div class="border-b border-gray-200 dark:border-slate-700 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center">
                    <i class="fas fa-dollar-sign text-green-600 dark:text-green-400 mr-2"></i>
                    {{ __('financial_information') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Amount -->
                    <div class="space-y-2">
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                            {{ __('amount') }} <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="number"
                               id="amount"
                               name="amount"
                               value="{{ old('amount') }}"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('amount') border-red-500 @enderror"
                               placeholder="0.00"
                               required>
                        @error('amount')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div class="space-y-2">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                            {{ __('payment_method') }} <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <select id="payment_method"
                                name="payment_method"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 @error('payment_method') border-red-500 @enderror"
                                required>
                            <option value="">{{ __('select_payment_method') }}</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>{{ __('cash') }}</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>{{ __('credit_card') }}</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>{{ __('bank_transfer') }}</option>
                            <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>{{ __('check') }}</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Dates and Vendor -->
            <div class="border-b border-gray-200 dark:border-slate-700 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center">
                    <i class="fas fa-calendar text-purple-600 dark:text-purple-400 mr-2"></i>
                    {{ __('dates_and_vendor') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Expense Date -->
                    <div class="space-y-2">
                        <label for="expense_date" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                            {{ __('expense_date') }} <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="date"
                               id="expense_date"
                               name="expense_date"
                               value="{{ old('expense_date', date('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 @error('expense_date') border-red-500 @enderror"
                               required>
                        @error('expense_date')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="space-y-2">
                        <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                            {{ __('due_date') }}
                        </label>
                        <input type="date"
                               id="due_date"
                               name="due_date"
                               value="{{ old('due_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vendor -->
                    <div class="space-y-2">
                        <label for="vendor" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                            {{ __('vendor') }}
                        </label>
                        <input type="text"
                               id="vendor"
                               name="vendor"
                               value="{{ old('vendor') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('vendor') border-red-500 @enderror"
                               placeholder="{{ __('vendor_or_company_name') }}">
                        @error('vendor')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reference Number -->
                    <div class="space-y-2">
                        <label for="reference_number" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                            {{ __('reference_number') }}
                        </label>
                        <input type="text"
                               id="reference_number"
                               name="reference_number"
                               value="{{ old('reference_number') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('reference_number') border-red-500 @enderror"
                               placeholder="{{ __('invoice_or_reference_number') }}">
                        @error('reference_number')
                            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-6 space-y-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                        {{ __('additional_notes') }}
                    </label>
                    <textarea id="notes"
                              name="notes"
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 @error('notes') border-red-500 @enderror"
                              placeholder="{{ __('any_additional_notes') }}">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-slate-700">
                <button type="submit"
                        class="flex-1 bg-blue-600 dark:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    {{ __('save_expense') }}
                </button>
                <a href="{{ route('expenses.index') }}"
                   class="flex-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    {{ __('cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
