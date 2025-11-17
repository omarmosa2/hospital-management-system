<?php

return [
    // Supported locales
    'supportedLocales' => [
        'ar' => ['name' => 'Arabic', 'script' => 'Arab', 'native' => 'العربية', 'regional' => 'ar_SA'],
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    ],

    // Use Accept-Language header
    'useAcceptLanguageHeader' => true,

    // Hide default locale in URL
    'hideDefaultLocaleInURL' => false,

    // Locale session key
    'localesOrder' => ['session', 'cookie', 'header'],

    // Session key name
    'sessionKey' => 'locale',

    // Cookie key name
    'cookieKey' => 'locale',

    // Locale mapping
    'localesMapping' => [],

    // UTF-8 suffix for locale
    'utf8suffix' => '.UTF-8',

    // URL ignore routes
    'urlsIgnored' => ['/skipped'],
];