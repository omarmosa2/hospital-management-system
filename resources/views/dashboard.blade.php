@extends('layouts.app')

@section('title', __('dashboard'))

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="gradient-bg rounded-2xl p-8 text-white animate-fadeInUp dark:bg-gradient-to-r dark:from-slate-800 dark:to-slate-900 dark:shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2 dark:text-slate-100">{{ __('hello') }}، {{ Auth::user()->name }}</h1>
                <p class="text-blue-100 dark:text-slate-400 text-lg">{{ __('welcome_to_system') }}</p>
                <p class="text-blue-200 dark:text-slate-500 text-sm mt-2">{{ now()->format('l، d F Y') }}</p>
            </div>
            <div class="text-right">
                <div class="text-4xl font-bold dark:text-slate-100">{{ now()->format('H:i') }}</div>
                <div class="text-blue-200 dark:text-slate-400">{{ now()->format('A') }}</div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content Based on Role -->
    @if(auth()->user()->isAdmin())
        @include('dashboard.admin')
    @elseif(auth()->user()->isDoctor())
        @include('dashboard.doctor')
    @elseif(auth()->user()->isNurse())
        @include('dashboard.nurse')
    @elseif(auth()->user()->isReceptionist())
        @include('dashboard.receptionist')
    @elseif(auth()->user()->isPatient())
        @include('dashboard.patient')
    @endif
</div>
@endsection
