@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }">
    <div>
        <button @click="open = !open" type="button" class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="language-menu" aria-expanded="true" aria-haspopup="true">
            <i class="fas fa-globe mr-2"></i>
            {{ LaravelLocalization::getCurrentLocaleNative() }}
            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="language-menu" style="display: none;">
        <div class="py-1" role="none">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                   class="group flex items-center px-4 py-2 text-sm {{ app()->getLocale() === $localeCode ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}" 
                   role="menuitem">
                    <span class="mr-3 text-lg">
                        @if($localeCode === 'ar')
                            🇸🇦
                        @elseif($localeCode === 'en')
                            🇬🇧
                        @elseif($localeCode === 'fr')
                            🇫🇷
                        @elseif($localeCode === 'tr')
                            🇹🇷
                        @endif
                    </span>
                    {{ $properties['native'] }}
                    @if(app()->getLocale() === $localeCode)
                        <i class="fas fa-check ml-auto text-blue-600"></i>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Alpine.js for dropdown functionality -->
@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush