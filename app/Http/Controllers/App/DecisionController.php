<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Alternative;
use App\Models\DecisionSession;
use App\Models\DecisionTree;
use App\Models\User;
use App\Services\DecisionTreeService;
use App\Services\Support\FinanceMath;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * شجرة القرار المالي العقلاني: إدخال نيّة الاقتراض، تشغيل المحرك الحتمي،
 * وعرض المخرَج (منع/ترشيد) مع المبرّرات والبدائل. لا LLM في القرار.
 */
class DecisionController extends Controller
{
    public function __construct(
        private readonly DecisionTreeService $decisionTreeService,
    ) {}

    /** نموذج «هل أقترض؟». */
    public function create(): View
    {
        return view('screens.decision-new');
    }

    /** ينشئ جلسة قرار، يشغّل المحرك، ويحوّل لصفحة النتيجة. */
    public function store(Request $request): RedirectResponse
    {
        $user = User::where('role', 'individual')->firstOrFail();

        // المبلغ قد يصل منسّقاً بفواصل (مثل "30,000")؛ نُطبّعه قبل التحقّق.
        $request->merge([
            'amount' => is_string($request->input('amount'))
                ? preg_replace('/[^\d.]/', '', $request->input('amount'))
                : $request->input('amount'),
        ]);

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'purpose' => ['required', 'in:emergency,marriage,car,debt_consolidation,business,education,other'],
            'tenor_months' => ['required', 'integer', 'min:1', 'max:60'],
        ]);

        // تخزين المبلغ بالهللات (أعداد صحيحة) — لا floats.
        $amountHalalas = (int) round(((float) $validated['amount']) * 100);

        $tree = DecisionTree::where('is_active', true)->orderByDesc('id')->first();

        $session = DecisionSession::create([
            'user_id' => $user->id,
            'decision_tree_id' => $tree?->id,
            'purpose' => $validated['purpose'],
            'requested_amount_halalas' => $amountHalalas,
            'status' => 'in_progress',
            'started_at' => Carbon::now(),
        ]);

        // حفظ المدة المختارة لإعادة إنتاج أرقام العرض في صفحة النتيجة.
        $session->answers()->create([
            'node_key' => 'tenor_months',
            'answer' => ['value' => (int) $validated['tenor_months']],
            'weight' => 0,
        ]);

        // تشغيل المحرك الحتمي: يُنتج decision_outcome ويغلق الجلسة.
        $this->decisionTreeService->run($session, [
            'tenor_months' => (int) $validated['tenor_months'],
        ]);

        return redirect()->route('app.decisions.show', $session);
    }

    /** يعرض نتيجة الجلسة مع مخرَجها وأرقام «الصدمة الإيجابية» والبدائل. */
    public function show(DecisionSession $decisionSession): View
    {
        $decisionSession->loadMissing('outcome', 'user.financialProfile', 'answers');
        $outcome = $decisionSession->outcome;
        $profile = $decisionSession->user?->financialProfile;

        // المدة المختارة (من الإجابات) لإعادة حساب أرقام العرض.
        $tenorAnswer = $decisionSession->answers->firstWhere('node_key', 'tenor_months');
        $tenor = (int) ($tenorAnswer->answer['value'] ?? 24);

        $amount = (int) $decisionSession->requested_amount_halalas;
        $disposable = (int) ($profile->disposable_income_halalas ?? 0);
        $dti = (float) ($profile->dti_ratio ?? 0);

        // أرقام العرض تُحسب حتمياً بالهللات (لا تُخزَّن؛ للعرض فقط).
        $interestMax = FinanceMath::totalInterestHalalas($amount, $tenor, FinanceMath::MARKET_APR_MAX);
        $aprMax = FinanceMath::MARKET_APR_MAX;
        $monthsToSave = $disposable > 0 ? (int) ceil($amount / $disposable) : null;

        // البدائل الموصى بها بالترتيب المنتَج من المحرك (مع مقدّميها).
        $slugs = $outcome?->recommended_alternative_slugs ?? [];
        $alternatives = collect();
        if (! empty($slugs)) {
            $found = Alternative::with(['providers.provider'])
                ->whereIn('slug', $slugs)
                ->get()
                ->keyBy('slug');

            $alternatives = collect($slugs)
                ->map(fn ($slug) => $found->get($slug))
                ->filter()
                ->values();
        }

        return view('screens.decision-result', [
            'session' => $decisionSession,
            'outcome' => $outcome,
            'alternatives' => $alternatives,
            'amount' => $amount,
            'tenor' => $tenor,
            'interestMax' => $interestMax,
            'aprMax' => $aprMax,
            'monthsToSave' => $monthsToSave,
            'disposable' => $disposable,
            'dti' => $dti,
        ]);
    }
}
