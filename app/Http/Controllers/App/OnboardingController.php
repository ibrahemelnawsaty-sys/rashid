<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Consent;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\Obligation;
use App\Services\FinancialAnalysisService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * الإعداد الأولي: الموافقة (PDPL) ثم بناء الملف المالي يدوياً،
 * وتشغيل محرك التحليل لإنشاء financial_profiles.
 */
class OnboardingController extends Controller
{
    public function __construct(private readonly FinancialAnalysisService $analysis) {}

    public function welcome(): View
    {
        return view('screens.onboarding-welcome');
    }

    public function consent(): View
    {
        return view('screens.onboarding-consent');
    }

    public function storeConsent(Request $request): RedirectResponse
    {
        $request->validate(['agree' => ['accepted']], [], ['agree' => 'الموافقة']);

        Consent::create([
            'user_id' => $request->user()->id,
            'type' => 'pdpl_processing',
            'scope' => ['purpose' => 'financial_analysis'],
            'status' => 'granted',
            'granted_at' => Carbon::now(),
            'ip_at_grant' => $request->ip(),
        ]);

        return redirect()->route('app.onboarding.source');
    }

    public function source(): View
    {
        return view('screens.onboarding-source');
    }

    public function manual(): View
    {
        return view('screens.onboarding-manual');
    }

    public function storeManual(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'income' => ['required', 'numeric', 'min:0'],
            'expenses' => ['required', 'numeric', 'min:0'],
            'obligation_monthly' => ['nullable', 'numeric', 'min:0'],
            'obligation_remaining' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = $request->user();

        // إعادة بناء نظيفة إن كرّر الإعداد
        $user->incomes()->delete();
        $user->expenses()->delete();
        $user->obligations()->delete();

        Income::create([
            'user_id' => $user->id,
            'source' => 'salary',
            'amount_halalas' => (int) round(((float) $data['income']) * 100),
            'frequency' => 'monthly',
            'is_verified' => false,
        ]);

        Expense::create([
            'user_id' => $user->id,
            'category_id' => ExpenseCategory::query()->value('id'),
            'amount_halalas' => (int) round(((float) $data['expenses']) * 100),
            'frequency' => 'monthly',
            'is_essential' => true,
            'source' => 'manual',
        ]);

        $monthly = (float) ($data['obligation_monthly'] ?? 0);
        if ($monthly > 0) {
            Obligation::create([
                'user_id' => $user->id,
                'creditor_type' => 'bank',
                'creditor_name' => 'التزام قائم',
                'remaining_halalas' => (int) round(((float) ($data['obligation_remaining'] ?? 0)) * 100),
                'monthly_installment_halalas' => (int) round($monthly * 100),
            ]);
        }

        // بناء الملف المالي عبر المحرك الحتمي
        $this->analysis->analyzeProfile($user);

        return redirect()->route('app.dashboard');
    }
}
