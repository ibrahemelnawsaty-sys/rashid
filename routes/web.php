<?php

use App\Http\Controllers\App\AlternativesController;
use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\App\DecisionController;
use App\Http\Controllers\App\GoalsController;
use Illuminate\Support\Facades\Route;

/*
| مسارات رشيد — طبقة العرض (واجهة العميل).
| المرحلة الحالية: عرض الشاشات ببيانات تجريبية. تُربط بالمتحكّمات والخدمات لاحقاً.
*/

// عام + مصادقة
Route::view('/', 'screens.landing')->name('landing');
Route::view('/register', 'screens.register')->name('auth.register');
Route::view('/login', 'screens.login')->name('auth.login');
Route::view('/verify-otp', 'screens.verify-otp')->name('auth.otp');

// تطبيق العميل (الفرد) — بادئة /app
Route::prefix('app')->group(function () {
    // الإعداد الأولي
    Route::view('/onboarding', 'screens.onboarding-welcome')->name('app.onboarding.welcome');
    Route::view('/onboarding/consent', 'screens.onboarding-consent')->name('app.onboarding.consent');
    Route::view('/onboarding/data-source', 'screens.onboarding-source')->name('app.onboarding.source');
    Route::view('/onboarding/manual', 'screens.onboarding-manual')->name('app.onboarding.manual');

    // اللوحة والقرار المحوري
    Route::get('/', [DashboardController::class, 'index'])->name('app.dashboard');
    Route::get('/decisions/new', [DecisionController::class, 'create'])->name('app.decisions.create');
    Route::post('/decisions', [DecisionController::class, 'store'])->name('app.decisions.store');
    Route::get('/decisions/{decisionSession}', [DecisionController::class, 'show'])->name('app.decisions.show');

    // البدائل والتمويل
    Route::get('/alternatives', [AlternativesController::class, 'index'])->name('app.alternatives.index');
    Route::view('/alternatives/gov_development_finance', 'screens.alternative-show')->name('app.alternatives.show');
    Route::view('/finance-requests/compare', 'screens.finance-compare')->name('app.finance_requests.compare');

    // الادخار والمستشار
    Route::get('/goals', [GoalsController::class, 'index'])->name('app.goals.index');
    Route::view('/goals/1', 'screens.goal-show')->name('app.goals.show');
    Route::view('/advisor', 'screens.advisor')->name('app.advisor.index');

    // الإعدادات والخصوصية
    Route::view('/notifications', 'screens.notifications')->name('app.notifications.index');
    Route::view('/profile', 'screens.profile')->name('app.profile.show');
    Route::view('/consents', 'screens.consents')->name('app.consents.index');
});
