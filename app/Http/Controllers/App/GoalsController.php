<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

/**
 * أهداف المستخدم المالية وتقدّمها (المدّخر مقابل الهدف).
 */
class GoalsController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $goals = $user->financialGoals()
            ->orderBy('priority')
            ->get();

        $totalSavedHalalas = (int) $goals->sum('saved_amount_halalas');
        $activeCount = $goals->where('status', 'active')->count();

        return view('screens.goals-index', [
            'user' => $user,
            'goals' => $goals,
            'totalSavedHalalas' => $totalSavedHalalas,
            'activeCount' => $activeCount,
        ]);
    }
}
