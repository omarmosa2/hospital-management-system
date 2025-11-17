# دليل نظام الترجمة i18n - Translation System Guide

## نظرة عامة - Overview

تم إنشاء نظام ترجمة متعدد اللغات يدعم 4 لغات:
- العربية (ar)
- الإنجليزية (en)
- الفرنسية (fr)
- التركية (tr)

---

## 1. ملفات الترجمة - Translation Files

تم إنشاء ملفات JSON للترجمة في مجلد `lang/`:

```
lang/
├── ar.json  (العربية)
├── en.json  (English)
├── fr.json  (Français)
└── tr.json  (Türkçe)
```

### مثال على محتوى ملف الترجمة:
```json
{
    "welcome": "مرحباً",
    "login": "تسجيل الدخول",
    "logout": "تسجيل الخروج",
    "username": "اسم المستخدم",
    "password": "كلمة المرور"
}
```

---

## 2. الإعدادات - Configuration

### ملف `config/laravellocalization.php`

```php
'supportedLocales' => [
    'ar' => ['name' => 'Arabic', 'script' => 'Arab', 'native' => 'العربية'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English'],
    'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'Français'],
    'tr' => ['name' => 'Turkish', 'script' => 'Latn', 'native' => 'Türkçe'],
],
```

---

## 3. استخدام الترجمة في Blade - Using Translations in Blade

### الطريقة الأساسية:
```blade
{{ __('welcome') }}
{{ __('login') }}
{{ __('username') }}
```

### مع متغيرات:
```blade
{{ __('welcome_user', ['name' => $user->name]) }}
```

### في ملف JSON:
```json
{
    "welcome_user": "مرحباً :name"
}
```

---

## 4. الروابط المترجمة - Localized URLs

### بنية الروابط:
```
/ar/dashboard    (العربية)
/en/dashboard    (English)
/fr/dashboard    (Français)
/tr/dashboard    (Türkçe)
```

### إنشاء رابط مترجم:
```blade
<a href="{{ LaravelLocalization::getLocalizedURL('ar') }}">العربية</a>
<a href="{{ LaravelLocalization::getLocalizedURL('en') }}">English</a>
<a href="{{ LaravelLocalization::getLocalizedURL('fr') }}">Français</a>
<a href="{{ LaravelLocalization::getLocalizedURL('tr') }}">Türkçe</a>
```

### الحصول على رابط الصفحة الحالية بلغة أخرى:
```blade
<a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
    Switch to English
</a>
```

---

## 5. مكون تبديل اللغة - Language Switcher Component

### الاستخدام في Layout:
```blade
<!-- في ملف resources/views/layouts/app.blade.php -->
<div class="header">
    <x-language-switcher />
</div>
```

### مثال كامل لأزرار تغيير اللغة:
```blade
<div class="language-switcher">
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}" 
           class="btn {{ app()->getLocale() === $localeCode ? 'active' : '' }}">
            {{ $properties['native'] }}
        </a>
    @endforeach
</div>
```

---

## 6. أمثلة عملية - Practical Examples

### مثال 1: صفحة تسجيل الدخول
```blade
<form method="POST" action="{{ route('login') }}">
    @csrf
    <h2>{{ __('login') }}</h2>
    
    <label>{{ __('username') }}</label>
    <input type="text" name="username" placeholder="{{ __('username') }}">
    
    <label>{{ __('password') }}</label>
    <input type="password" name="password" placeholder="{{ __('password') }}">
    
    <button type="submit">{{ __('login') }}</button>
</form>
```

### مثال 2: قائمة التنقل
```blade
<nav>
    <a href="{{ LaravelLocalization::localizeUrl('/dashboard') }}">
        {{ __('dashboard') }}
    </a>
    <a href="{{ LaravelLocalization::localizeUrl('/patients') }}">
        {{ __('patients') }}
    </a>
    <a href="{{ LaravelLocalization::localizeUrl('/doctors') }}">
        {{ __('doctors') }}
    </a>
</nav>
```

### مثال 3: رسائل النجاح والخطأ
```blade
@if(session('success'))
    <div class="alert alert-success">
        {{ __(session('success')) }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ __(session('error')) }}
    </div>
@endif
```

---

## 7. في الـ Controllers

### تعيين رسالة مترجمة:
```php
return redirect()->back()->with('success', __('saved_successfully'));
```

### الحصول على اللغة الحالية:
```php
$currentLocale = app()->getLocale(); // ar, en, fr, tr
```

### تغيير اللغة برمجياً:
```php
app()->setLocale('ar');
```

---

## 8. إضافة مفاتيح ترجمة جديدة

### الخطوات:
1. أضف المفتاح في جميع ملفات اللغات (ar.json, en.json, fr.json, tr.json)

**مثال في ar.json:**
```json
{
    "new_patient": "مريض جديد",
    "patient_added": "تم إضافة المريض بنجاح"
}
```

**مثال في en.json:**
```json
{
    "new_patient": "New Patient",
    "patient_added": "Patient added successfully"
}
```

2. استخدمه في Blade:
```blade
<h1>{{ __('new_patient') }}</h1>
```

---

## 9. التوجيه التلقائي - Automatic Redirection

النظام يدعم:
- ✅ التوجيه التلقائي حسب لغة المتصفح
- ✅ حفظ اللغة في الجلسة (Session)
- ✅ حفظ اللغة في الكوكيز (Cookie)

---

## 10. دوال مساعدة مفيدة - Helpful Functions

```php
// الحصول على اللغة الحالية
LaravelLocalization::getCurrentLocale() // 'ar'

// الحصول على اسم اللغة الأصلي
LaravelLocalization::getCurrentLocaleNative() // 'العربية'

// الحصول على جميع اللغات المدعومة
LaravelLocalization::getSupportedLocales()

// التحقق من دعم لغة معينة
LaravelLocalization::checkLocaleInSupportedLocales('ar') // true

// الحصول على اتجاه اللغة (RTL/LTR)
LaravelLocalization::getCurrentLocaleDirection() // 'rtl' for Arabic
```

---

## 11. تحديث Layout الرئيسي

### في `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('dashboard') }} - {{ config('app.name') }}</title>
</head>
<body>
    <!-- Language Switcher -->
    <x-language-switcher />
    
    <!-- Content -->
    @yield('content')
</body>
</html>
```

---

## 12. الاختبار - Testing

### اختبر الروابط التالية:
```
http://localhost/ar/dashboard
http://localhost/en/dashboard
http://localhost/fr/dashboard
http://localhost/tr/dashboard
```

---

## 13. نصائح مهمة - Important Tips

1. ✅ استخدم دائماً `__('key')` للترجمة
2. ✅ أضف المفاتيح في جميع ملفات اللغات
3. ✅ استخدم `LaravelLocalization::getLocalizedURL()` للروابط
4. ✅ حافظ على تناسق أسماء المفاتيح
5. ✅ استخدم snake_case لأسماء المفاتيح

---

## 14. الصيانة - Maintenance

### إضافة لغة جديدة:
1. أنشئ ملف JSON جديد في `lang/`
2. أضف اللغة في `config/laravellocalization.php`
3. أضف جميع مفاتيح الترجمة

### تحديث الترجمات:
- عدّل الملفات في مجلد `lang/`
- لا حاجة لإعادة تشغيل السيرفر

---

## المراجع - References

- [Laravel Localization Documentation](https://github.com/mcamara/laravel-localization)
- [Laravel Translation Docs](https://laravel.com/docs/localization)