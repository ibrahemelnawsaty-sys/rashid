<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FinancialAnalysisService;
use Illuminate\Contracts\View\View;

/**
 * لوحة الفرد المالية: تجمّع الملف المالي والأهداف والحسابات والإشعارات.
 * المصادقة لم تُبنَ بعد؛ يُجلب المستخدم التجريبي (فرد) مباشرةً.
 */
class DashboardController extends Controller
{
    public function __construct(
        private readonly FinancialAnalysisService $analysisService,
    ) {}

    public function index(): View
    {
        $user = User::where('role', 'individual')->firstOrFail();

        // الملف المالي المخزّن؛ يُحتسب عند غيابه (محرك حتمي، لا LLM).
        $profile = $user->financialProfile
            ?? $this->analysisService->analyzeProfile($user);

        // الأهداف المالية النشطة وغيرها لحساب إجمالي الادخار.
        $goals = $user->financialGoals()->orderBy('priority')->get();
        $totalSavedHalalas = (int) $goals->sum('saved_amount_halalas');

        // الحسابات البنكية مع أحدث رصيد لكل حساب (eager loading لمنع N+1).
        $bankAccounts = $user->bankAccounts()
            ->with(['bank', 'balances'])
            ->get();

        // إشعارات المستخدم (جدول notifications القياسي في قاعدة البيانات).
        $notifications = $user->notifications()->latest()->take(5)->get();

        return view('screens.dashboard', [
            'user' => $user,
            'profile' => $profile,
            'goals' => $goals,
            'totalSavedHalalas' => $totalSavedHalalas,
            'bankAccounts' => $bankAccounts,
            'notifications' => $notifications,
        ]);
    }
}
