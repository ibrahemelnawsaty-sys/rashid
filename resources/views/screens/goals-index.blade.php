<x-layout title="أهدافي — رشيد">
<div class="appbar"><div class="appbar__row"><div class="appbar__title">أهدافي</div><div class="appbar__spacer"></div><a class="iconbtn" href="{{ route('app.goals.create') }}" aria-label="إضافة هدف جديد"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg></a></div></div>
<div class="screen screen--pb">
<div class="stack">

@if($goals->isNotEmpty())
<div class="row-between">
<div>
<div class="eyebrow">إجمالي المدّخر في أهدافك</div>
<div class="amount-display"><span class="money" dir="ltr">{{ number_format($totalSavedHalalas / 100) }} <span class="money__unit">ريال</span></span></div>
</div>
<span class="badge badge--success"><span class="dot"></span> {{ $activeCount }} {{ $activeCount == 1 ? 'هدف نشط' : 'أهداف نشطة' }}</span>
</div>

<div class="section-title">أهدافك</div>

@foreach($goals as $goal)
@php
  $target = (int) $goal->target_amount_halalas; $saved = (int) $goal->saved_amount_halalas;
  $pct = $target > 0 ? min(100, (int) round($saved / $target * 100)) : 0;
  $remaining = max(0, $target - $saved);
  $plan = $goal->savingsPlans->firstWhere('status', 'active');
  if ($goal->status === 'achieved') { $bd = ['success', 'مكتمل']; }
  elseif ($pct >= 80) { $bd = ['accent', 'قريب الاكتمال']; }
  else { $bd = ['info', 'في المسار']; }
@endphp
<a href="{{ route('app.goals.show', $goal) }}" class="card" style="display:block">
<div class="card__body">
<div class="stack-sm">
<div class="row-between">
<div class="row"><span class="pill"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4.4"/><circle cx="12" cy="12" r="1.1" fill="currentColor" stroke="none"/></svg></span><div class="grow"><div class="stat__label" style="color:var(--color-ink);font-weight:700">{{ $goal->title }}</div></div></div>
<span class="badge badge--{{ $bd[0] }}"><span class="dot"></span> {{ $bd[1] }}</span>
</div>
<div class="progress"><div class="progress__bar {{ $pct >= 100 ? 'progress__bar--success' : '' }}" style="width:{{ $pct }}%"></div></div>
<div class="row-between">
<div class="footnote">المدّخر <span class="money" dir="ltr">{{ number_format($saved / 100) }} <span class="money__unit">ريال</span></span> من <span class="money" dir="ltr">{{ number_format($target / 100) }} <span class="money__unit">ريال</span></span></div>
<div class="footnote" dir="ltr">{{ $pct }}%</div>
</div>
<div class="divider"></div>
<div class="row-between">
<div class="stat"><div class="stat__label">المبلغ المتبقّي</div><div class="stat__value"><span class="money" dir="ltr">{{ number_format($remaining / 100) }} <span class="money__unit">ريال</span></span></div></div>
@if($plan && $plan->end_date)
<div class="stat"><div class="stat__label">الموعد المتوقّع</div><div class="stat__value" dir="ltr">{{ $plan->end_date->format('Y/m') }}</div></div>
@endif
</div>
</div>
</div>
</a>
@endforeach

<a href="{{ route('app.goals.create') }}" class="btn btn--accent btn--block btn--lg">＋ إنشاء هدف جديد</a>

@else
<div class="empty">
<div class="empty__art"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4.4"/><circle cx="12" cy="12" r="1.1" fill="currentColor" stroke="none"/></svg></div>
<div class="empty__title">حدّد أول هدف لك</div>
<div class="empty__desc">ابدأ الادخار بدل الاستدانة. حدّد هدفاً ومبلغاً وتاريخاً، وسنرافقك خطوة بخطوة للوصول إليه.</div>
<a href="{{ route('app.goals.create') }}" class="btn btn--accent btn--lg">＋ إنشاء هدف جديد</a>
</div>
@endif

</div>
</div>
@include('partials.bottomnav', ['active' => 'target'])
</x-layout>
