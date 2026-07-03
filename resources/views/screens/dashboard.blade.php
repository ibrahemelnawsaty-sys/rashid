@php
  $dti = (float) ($profile->dti_ratio ?? 0);
  $band = $dti <= 33 ? 'success' : ($dti <= 45 ? 'warning' : 'danger');
  $bandLabel = $dti <= 33 ? 'منخفضة ومريحة' : ($dti <= 45 ? 'متوسطة' : 'مرتفعة');
  $off = 163.36 * (1 - min(100, max(0, $dti)) / 100);
  $income = (int) ($profile->monthly_income_halalas ?? 0);
  $expenses = (int) ($profile->monthly_expenses_halalas ?? 0);
  $disposable = (int) ($profile->disposable_income_halalas ?? 0);
  $emergency = (int) ($profile->emergency_fund_halalas ?? 0);
  $months = $expenses > 0 ? number_format($emergency / $expenses, 1) : '0';
  $risk = $profile->risk_band ?? 'low';
  $riskLabel = $risk === 'low' ? 'هادئة' : ($risk === 'medium' ? 'متوازنة' : 'مرتفعة');
  $riskBadge = $risk === 'low' ? 'success' : ($risk === 'medium' ? 'warning' : 'danger');
  $unread = $notifications->whereNull('read_at')->count();
@endphp
<x-layout title="اللوحة المالية — رشيد">
<div class="appbar"><div class="appbar__row"><div><div class="appbar__title">أهلاً {{ \Illuminate\Support\Str::of($user->name)->explode(' ')->first() }}</div><div class="appbar__sub">نظرة على وضعك المالي</div></div><div class="appbar__spacer"></div><a class="iconbtn" href="{{ route('app.notifications.index') }}" aria-label="الإشعارات"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6.5 9.5a5.5 5.5 0 0 1 11 0c0 4.5 1.8 5.5 1.8 5.5H4.7s1.8-1 1.8-5.5z"/><path d="M10.2 19a2 2 0 0 0 3.6 0"/></svg>@if($unread)<span class="count">{{ $unread }}</span>@endif</a><a class="iconbtn" href="{{ route('app.profile.show') }}" aria-label="الملف الشخصي"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8.2" r="3.4"/><path d="M5.5 20a6.5 6.5 0 0 1 13 0"/></svg></a></div></div>
<div class="screen screen--pb">
<div class="stack">

<div class="hero-card">
<div class="hero-card__label">صافي التدفق الشهري</div>
<div class="hero-card__value"><span class="money" dir="ltr">{{ $disposable >= 0 ? '+' : '' }}{{ number_format($disposable / 100) }} <span class="money__unit">ريال</span></span></div>
<div class="hero-card__meta">الدخل {{ number_format($income / 100) }} · المصروف {{ number_format($expenses / 100) }}</div>
</div>

<div class="grid-2">
<div class="card"><div class="card__body">
<div class="stat">
<div class="stat__label">نسبة الالتزام DTI</div>
<div class="gauge"><svg viewBox="0 0 120 70" role="img" aria-label="نسبة الالتزام {{ (int) round($dti) }} بالمئة"><path d="M8 62 A52 52 0 0 1 112 62" fill="none" stroke="var(--color-surface-alt)" stroke-width="10" stroke-linecap="round"/><path d="M8 62 A52 52 0 0 1 112 62" fill="none" stroke="var(--color-{{ $band }})" stroke-width="10" stroke-linecap="round" stroke-dasharray="163.36" stroke-dashoffset="{{ $off }}"/></svg><div class="gauge__num" dir="ltr">{{ (int) round($dti) }}<span>%</span></div></div>
<div class="stat__foot"><span class="badge badge--{{ $band }}"><span class="dot"></span>{{ $bandLabel }}</span></div>
</div>
</div></div>
<div class="card"><div class="card__body">
<div class="stat">
<div class="stat__label">إجمالي الادخار</div>
<div class="stat__value"><span class="money" dir="ltr">{{ number_format($totalSavedHalalas / 100) }} <span class="money__unit">ريال</span></span></div>
<div class="stat__foot">عبر أهدافك النشطة</div>
</div>
</div></div>
</div>

<div class="grid-2">
<div class="card"><div class="card__body">
<div class="stat">
<div class="stat__label">صندوق الطوارئ</div>
<div class="stat__value"><span class="money" dir="ltr">{{ number_format($emergency / 100) }} <span class="money__unit">ريال</span></span></div>
<div class="stat__foot">يغطّي <span dir="ltr">{{ $months }}</span> شهر من مصروفك</div>
</div>
</div></div>
<div class="card"><div class="card__body">
<div class="stat">
<div class="stat__label">شريحة المخاطر</div>
<div class="stat__value">{{ $riskLabel }}</div>
<div class="stat__foot"><span class="badge badge--{{ $riskBadge }}"><span class="dot"></span>{{ $risk === 'low' ? 'منخفضة' : ($risk === 'medium' ? 'متوسطة' : 'مرتفعة') }}</span></div>
</div>
</div></div>
</div>

<div class="card card--pad">
<div class="stack-sm">
<div class="eyebrow">قبل أن تقرّر</div>
<div class="section-title">تفكّر في قرض؟ دعنا نحسبه معك أولاً</div>
<div class="footnote">سنعرض لك التكلفة الحقيقية والبدائل الأنسب قبل أي التزام.</div>
<a href="{{ route('app.decisions.create') }}" class="btn btn--accent btn--block btn--lg">هل أقترض؟</a>
</div>
</div>

@if($notifications->isNotEmpty())
<div class="stack-sm">
<div class="section-title">تنبيهات</div>
@foreach($notifications as $n)
@php $d = (array) $n->data; $lvl = in_array($d['level'] ?? 'info', ['info','success','warning','danger']) ? $d['level'] : 'info'; @endphp
<div class="alert alert--{{ $lvl }}">
<div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.6"/><path d="M12 8v5"/><circle cx="12" cy="16" r=".6" fill="currentColor" stroke="none"/></svg></div>
<div><div class="alert__title">{{ $d['title'] ?? 'تنبيه' }}</div><div class="alert__body">{{ $d['body'] ?? '' }}</div></div>
</div>
@endforeach
</div>
@endif

@if($bankAccounts->isNotEmpty())
<div class="stack-sm">
<div class="section-title">حساباتك</div>
<div class="card"><div class="card__body">
@foreach($bankAccounts as $acc)
@php $bal = $acc->balances->sortByDesc('captured_at')->first(); @endphp
<div class="listrow">
<div class="listrow__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 10h16"/><path d="M12 3.5 4 7.2V10h16V7.2l-8-3.7z"/><path d="M6.5 10v6.5M10 10v6.5M14 10v6.5M17.5 10v6.5"/><path d="M4 20h16"/></svg></div>
<div class="grow"><div class="listrow__title">{{ $acc->bank?->name_ar ?? 'حساب بنكي' }}</div><div class="listrow__sub">حساب {{ $acc->account_type === 'savings' ? 'ادّخار' : 'جاري' }} {{ $acc->iban_masked }}</div></div>
<div class="money" dir="ltr">{{ number_format(($bal?->balance_halalas ?? 0) / 100) }} <span class="money__unit">ريال</span></div>
</div>
@endforeach
</div></div>
</div>
@else
<div class="empty">
<div class="empty__art"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 10h16"/><path d="M12 3.5 4 7.2V10h16V7.2l-8-3.7z"/><path d="M6.5 10v6.5M10 10v6.5M14 10v6.5M17.5 10v6.5"/><path d="M4 20h16"/></svg></div>
<div class="empty__title">لم تربط أي حساب بعد</div>
<div class="empty__desc">اربط حساباتك لاحقاً لمتابعة أرصدتك وتحليل إنفاقك تلقائياً.</div>
</div>
@endif

</div>
</div>
@include('partials.bottomnav', ['active' => 'home'])
</x-layout>
