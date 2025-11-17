@extends('layouts.app')

@section('title', __('welcome'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Language Switcher Example -->
    <div class="mb-8 flex justify-end">
        <x-language-switcher />
    </div>

    <!-- Translation Examples -->
    <div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
        <h1 class="text-3xl font-bold text-gray-900">
            {{ __('welcome') }}
        </h1>

        <!-- Basic Translation -->
        <div class="border-b pb-4">
            <h2 class="text-xl font-semibold mb-2">{{ __('dashboard') }}</h2>
            <p class="text-gray-600">{{ __('loading') }}</p>
        </div>

        <!-- Form Example with Translations -->
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    {{ __('username') }}
                </label>
                <input type="text" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       placeholder="{{ __('username') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    {{ __('password') }}
                </label>
                <input type="password" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                       placeholder="{{ __('password') }}">
            </div>

            <div class="flex items-center">
                <input type="checkbox" class="rounded border-gray-300">
                <label class="ml-2 text-sm text-gray-600">
                    {{ __('remember_me') }}
                </label>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                {{ __('login') }}
            </button>
        </form>

        <!-- Navigation Links Example -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-3">{{ __('actions') }}</h3>
            <div class="flex flex-wrap gap-2">
                <a href="#" class="px-4 py-2 bg-green-600 text-white rounded">
                    {{ __('create') }}
                </a>
                <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded">
                    {{ __('edit') }}
                </a>
                <a href="#" class="px-4 py-2 bg-red-600 text-white rounded">
                    {{ __('delete') }}
                </a>
                <a href="#" class="px-4 py-2 bg-gray-600 text-white rounded">
                    {{ __('cancel') }}
                </a>
            </div>
        </div>

        <!-- Localized URLs Example -->
        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-3">{{ __('language') }}</h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}" 
                   class="px-4 py-2 border rounded {{ app()->getLocale() === 'ar' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' }}">
                    {{ __('arabic') }}
                </a>
                <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" 
                   class="px-4 py-2 border rounded {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' }}">
                    {{ __('english') }}
                </a>
                <a href="{{ LaravelLocalization::getLocalizedURL('fr') }}" 
                   class="px-4 py-2 border rounded {{ app()->getLocale() === 'fr' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' }}">
                    {{ __('french') }}
                </a>
                <a href="{{ LaravelLocalization::getLocalizedURL('tr') }}" 
                   class="px-4 py-2 border rounded {{ app()->getLocale() === 'tr' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' }}">
                    {{ __('turkish') }}
                </a>
            </div>
        </div>

        <!-- Status Messages Example -->
        <div class="border-t pt-4">
            <div class="space-y-2">
                <div class="p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ __('success') }}: {{ __('save') }}
                </div>
                <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ __('error') }}: {{ __('loading') }}
                </div>
                <div class="p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                    {{ __('warning') }}: {{ __('are_you_sure') }}
                </div>
            </div>
        </div>

        <!-- Current Locale Info -->
        <div class="border-t pt-4">
            <p class="text-sm text-gray-600">
                <strong>{{ __('language') }}:</strong> {{ LaravelLocalization::getCurrentLocaleNative() }}
            </p>
            <p class="text-sm text-gray-600">
                <strong>Locale Code:</strong> {{ app()->getLocale() }}
            </p>
            <p class="text-sm text-gray-600">
                <strong>Direction:</strong> {{ LaravelLocalization::getCurrentLocaleDirection() }}
            </p>
        </div>
    </div>
</div>
@endsection