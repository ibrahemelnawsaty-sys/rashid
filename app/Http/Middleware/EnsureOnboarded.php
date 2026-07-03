<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * يضمن أن العميل الفرد أكمل إعداده المالي قبل دخول شاشات التطبيق.
 * إن لم يوجد financial_profile يُحوَّل إلى مسار الإعداد الأولي.
 */
class EnsureOnboarded
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isIndividual() && ! $user->financialProfile()->exists()) {
            return redirect()->route('app.onboarding.welcome');
        }

        return $next($request);
    }
}
