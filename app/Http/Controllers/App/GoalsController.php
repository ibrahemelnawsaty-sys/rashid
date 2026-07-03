<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\FinancialGoal;
use App\Models\SavingsContribution;
use App\Services\SavingsPlanService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * أهداف المستخدم المالية: عرض التقدّم، إنشاء هدف، وتسجيل المساهمات.
 */
class GoalsController extends Controller
{
    public function __construct(private readonly SavingsPlanService $savings) {}

    public function index(): View
    {
        $user = auth()->user();

        $goals = $user->financialGoals()
            ->with('savingsPlans')
            ->orderBy('priority')
            ->get();

        return view('screens.goals-index', [
            'user' => $user,
            'goals' => $goals,
            'totalSavedHalalas' => (int) $goals->sum('saved_amount_halalas'),
            'activeCount' => $goals->where('status', 'active')->count(),
        ]);
    }

    public function create(): View
    {
        return view('screens.goal-create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'target' => preg_replace('/[^\d.]/', '', (string) $request->input('target')),
            'monthly' => preg_replace('/[^\d.]/', '', (string) $request->input('monthly')),
        ]);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:80'],
            'target' => ['required', 'numeric', 'min:1'],
            'target_date' => ['nullable', 'date', 'after:today'],
            'monthly' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = auth()->user();

        $goal = $user->financialGoals()->create([
            'title' => $data['title'],
            'target_amount_halalas' => (int) round(((float) $data['target']) * 100),
            'saved_amount_halalas' => 0,
            'target_date' => $data['target_date'] ?? null,
            'priority' => (int) ($user->financialGoals()->max('priority') ?? 0) + 1,
            'status' => 'active',
        ]);

        if (! empty($data['monthly'])) {
            $this->savings->createPlan($user, $goal, [
                'monthly_amount_halalas' => (int) round(((float) $data['monthly']) * 100),
            ]);
        }

        return redirect()->route('app.goals.show', $goal);
    }

    public function show(FinancialGoal $goal): View
    {
        abort_unless($goal->user_id === auth()->id(), 403);

        $goal->load('savingsPlans');
        $plan = $goal->savingsPlans->firstWhere('status', 'active') ?? $goal->savingsPlans->first();

        $contributions = SavingsContribution::whereIn('savings_plan_id', $goal->savingsPlans->pluck('id'))
            ->orderByDesc('contributed_at')
            ->get();

        return view('screens.goal-show', [
            'goal' => $goal,
            'plan' => $plan,
            'contributions' => $contributions,
        ]);
    }

    public function contribute(Request $request, FinancialGoal $goal): RedirectResponse
    {
        abort_unless($goal->user_id === auth()->id(), 403);

        $request->merge(['amount' => preg_replace('/[^\d.]/', '', (string) $request->input('amount'))]);
        $data = $request->validate(['amount' => ['required', 'numeric', 'min:1']]);
        $amount = (int) round(((float) $data['amount']) * 100);

        $plan = $goal->savingsPlans()->where('status', 'active')->latest('id')->first()
            ?? $this->savings->createPlan(auth()->user(), $goal, ['monthly_amount_halalas' => $amount]);

        $this->savings->recordContribution($plan, $amount);

        return redirect()->route('app.goals.show', $goal);
    }
}
