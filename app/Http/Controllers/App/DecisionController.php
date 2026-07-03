<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\DecisionSession;
use App\Models\DecisionTree;
use App\Models\User;
use App\Services\DecisionTreeService;
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

        // تشغيل المحرك الحتمي: يُنتج decision_outcome ويغلق الجلسة.
        $this->decisionTreeService->run($session, [
            'tenor_months' => (int) $validated['tenor_months'],
        ]);

        return redirect()->route('app.decisions.show', $session);
    }

    /** يعرض نتيجة الجلسة مع مخرَجها والبدائل الموصى بها. */
    public function show(DecisionSession $decisionSession): View
    {
        $outcome = $decisionSession->outcome;

        // البدائل الموصى بها بالترتيب المنتَج من المحرك (مع مقدّميها).
        $slugs = $outcome?->recommended_alternative_slugs ?? [];

        $alternatives = collect();
        if (! empty($slugs)) {
            $found = \App\Models\Alternative::with(['providers.provider'])
                ->whereIn('slug', $slugs)
                ->get()
                ->keyBy('slug');

            // إعادة الترتيب وفق تسلسل التوصية لا وفق ترتيب القاعدة.
            $alternatives = collect($slugs)
                ->map(fn ($slug) => $found->get($slug))
                ->filter()
                ->values();
        }

        return view('screens.decision-result', [
            'session' => $decisionSession,
            'outcome' => $outcome,
            'alternatives' => $alternatives,
        ]);
    }
}
