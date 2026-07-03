<?php

use App\Http\Controllers\App\AlternativesController;
use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\App\DecisionController;
use App\Http\Controllers\App\GoalsController;
use App\Http\Controllers\App\OnboardingController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
| مسارات رشيد — واجهة العميل (الفرد) مع المصادقة بالجوال (OTP) والإعداد الأولي.
*/

// صفحة الهبوط العامة
Route::view('/', 'screens.landing')->name('landing');

// المصادقة (للزوّار)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/verify-otp', [AuthController::class, 'showVerify'])->name('auth.otp');
    Route::post('/verify-otp', [AuthController::class, 'verify'])->name('auth.otp.verify');
    Route::post('/resend-otp', [AuthController::class, 'resend'])->name('auth.otp.resend');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// تطبيق العميل — يتطلّب مصادقة
Route::middleware('auth')->prefix('app')->group(function () {
    // الإعداد الأولي (بلا فحص الإكمال)
    Route::get('/onboarding', [OnboardingController::class, 'welcome'])->name('app.onboarding.welcome');
    Route::get('/onboarding/consent', [OnboardingController::class, 'consent'])->name('app.onboarding.consent');
    Route::post('/onboarding/consent', [OnboardingController::class, 'storeConsent'])->name('app.onboarding.consent.store');
    Route::get('/onboarding/data-source', [OnboardingController::class, 'source'])->name('app.onboarding.source');
    Route::get('/onboarding/manual', [OnboardingController::class, 'manual'])->name('app.onboarding.manual');
    Route::post('/onboarding/manual', [OnboardingController::class, 'storeManual'])->name('app.onboarding.manual.store');

    // الشاشات التي تتطلّب إكمال الإعداد
    Route::middleware('onboarded')->group(function () {
        // اللوحة والقرار المحوري
        Route::get('/', [DashboardController::class, 'index'])->name('app.dashboard');
        Route::get('/decisions/new', [DecisionController::class, 'create'])->name('app.decisions.create');
        Route::post('/decisions', [DecisionController::class, 'store'])->name('app.decisions.store');
        Route::get('/decisions/{decisionSession}', [DecisionController::class, 'show'])->name('app.decisions.show');

        // البدائل
        Route::get('/alternatives', [AlternativesController::class, 'index'])->name('app.alternatives.index');
        Route::get('/alternatives/{slug}', [AlternativesController::class, 'show'])->name('app.alternatives.show');
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
});
