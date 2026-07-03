<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * المصادقة بالجوال عبر رمز لمرة واحدة (OTP) — لا كلمات مرور.
 * التسجيل/الدخول ينشئان رمزاً ويحوّلان لشاشة التحقق، والتحقق ينشئ الجلسة.
 */
class AuthController extends Controller
{
    public function __construct(private readonly OtpService $otp) {}

    // ---------- التسجيل ----------

    public function showRegister(): View
    {
        return view('screens.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string'],
            'residency_type' => ['required', 'in:citizen,resident'],
            'consent' => ['accepted'],
        ], [], ['consent' => 'الموافقة']);

        $phone = OtpService::normalizePhone($data['phone']);
        if (! $phone) {
            throw ValidationException::withMessages(['phone' => 'أدخل رقم جوال سعودي صحيح يبدأ بـ 5.']);
        }

        if (User::where('phone', $phone)->exists()) {
            throw ValidationException::withMessages(['phone' => 'هذا الجوال مسجّل مسبقاً — سجّل الدخول.']);
        }

        $user = User::create([
            'name' => $data['name'],
            'phone' => $phone,
            'role' => 'individual',
            'status' => 'active',
            'residency_type' => $data['residency_type'],
            'locale' => 'ar',
        ]);

        return $this->startOtp($request, $phone, 'login', $user->id);
    }

    // ---------- الدخول ----------

    public function showLogin(): View
    {
        return view('screens.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate(['phone' => ['required', 'string']]);

        $phone = OtpService::normalizePhone($data['phone']);
        if (! $phone) {
            throw ValidationException::withMessages(['phone' => 'أدخل رقم جوال سعودي صحيح.']);
        }

        $user = User::where('phone', $phone)->first();
        if (! $user) {
            throw ValidationException::withMessages(['phone' => 'لا يوجد حساب بهذا الرقم — أنشئ حساباً جديداً.']);
        }

        return $this->startOtp($request, $phone, 'login', $user->id);
    }

    // ---------- التحقق ----------

    public function showVerify(Request $request): View|RedirectResponse
    {
        $phone = $request->session()->get('otp_phone');
        if (! $phone) {
            return redirect()->route('auth.login');
        }

        return view('screens.verify-otp', [
            'phone' => $phone,
            'devOtp' => config('rashid.otp_dev_show') ? $request->session()->get('dev_otp') : null,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $data = $request->validate(['code' => ['required', 'digits:6']]);

        $phone = $request->session()->get('otp_phone');
        $purpose = $request->session()->get('otp_purpose', 'login');
        if (! $phone) {
            return redirect()->route('auth.login');
        }

        if (! $this->otp->verify($phone, $purpose, $data['code'])) {
            throw ValidationException::withMessages(['code' => 'الرمز غير صحيح أو منتهي الصلاحية.']);
        }

        $user = User::where('phone', $phone)->firstOrFail();
        $user->forceFill(['phone_verified_at' => Carbon::now()])->save();

        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->forget(['otp_phone', 'otp_purpose', 'dev_otp']);

        $target = $user->financialProfile()->exists() ? 'app.dashboard' : 'app.onboarding.welcome';

        return redirect()->route($target);
    }

    public function resend(Request $request): RedirectResponse
    {
        $phone = $request->session()->get('otp_phone');
        $purpose = $request->session()->get('otp_purpose', 'login');
        if (! $phone) {
            return redirect()->route('auth.login');
        }

        $user = User::where('phone', $phone)->first();

        return $this->startOtp($request, $phone, $purpose, $user?->id);
    }

    // ---------- الخروج ----------

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }

    // ---------- مساعد ----------

    private function startOtp(Request $request, string $phone, string $purpose, ?int $userId): RedirectResponse
    {
        $code = $this->otp->send($phone, $purpose, $userId);

        $request->session()->put('otp_phone', $phone);
        $request->session()->put('otp_purpose', $purpose);
        if (config('rashid.otp_dev_show')) {
            $request->session()->put('dev_otp', $code);
        }

        return redirect()->route('auth.otp');
    }
}
