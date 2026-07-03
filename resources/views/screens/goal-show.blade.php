@php
  $target = (int) $goal->target_amount_halalas; $saved = (int) $goal->saved_amount_halalas;
  $pct = $target > 0 ? min(100, (int) round($saved / $target * 100)) : 0;
  $remaining = max(0, $target - $saved);
  if ($goal->status === 'achieved') { $bd = ['success', 'مكتمل']; }
  elseif ($pct >= 80) { $bd = ['accent', 'قريب الاكتمال']; }
  else { $bd = ['info', 'في المسار']; }
  $statusMap = ['completed' => 'مكتملة', 'scheduled' => 'مجدولة', 'failed' => 'فشلت'];
@endphp
<x-layout title="هدف: {{ $goal->title }} — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ route('app.goals.index') }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">{{ \Illuminate\Support\Str::limit($goal->title, 24) }}</div></div></div>
<div class="screen">
  <div class="stack-lg">

    <div class="card"><div class="card__body"><div class="stack">
      <div class="row-between">
        <div class="row"><span class="pill"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4.4"/><circle cx="12" cy="12" r="1.1" fill="currentColor" stroke="none"/></svg></span><div><div class="section-title">{{ $goal->title }}</div><div class="footnote">هدف ادخار</div></div></div>
        <span class="badge badge--{{ $bd[0] }}"><span class="dot"></span>{{ $bd[1] }}</span>
      </div>

      <div class="row-between">
        <span class="amount-lg"><span class="money" dir="ltr">{{ number_format($saved / 100) }} <span class="money__unit">ريال</span></span></span>
        <span class="footnote" dir="ltr">{{ $pct }}%</span>
      </div>
      <div class="progress"><div class="progress__bar {{ $pct >= 100 ? 'progress__bar--success' : '' }}" style="width:{{ $pct }}%"></div></div>

      <div class="grid-2">
        <div class="stat"><div class="stat__label">الهدف</div><div class="stat__value"><span class="money" dir="ltr">{{ number_format($target / 100) }} <span class="money__unit">ريال</span></span></div></div>
        <div class="stat"><div class="stat__label">المتبقّي</div><div class="stat__value"><span class="money" dir="ltr">{{ number_format($remaining / 100) }} <span class="money__unit">ريال</span></span></div></div>
      </div>

      @if($plan && $plan->end_date)
      <div class="divider"></div>
      <div class="row-between">
        <span class="footnote">الموعد المتوقّع للوصول</span>
        <span class="badge badge--info" dir="ltr">{{ $plan->end_date->format('Y/m') }}</span>
      </div>
      @endif
    </div></div></div>

    @if($goal->status !== 'achieved')
    <form method="POST" action="{{ route('app.goals.contribute', $goal) }}">
      @csrf
      <div class="card"><div class="card__body"><div class="stack-sm">
        <div class="section-title">سجّل مساهمة جديدة</div>
        <div class="field is-amount">
          <div class="field__control">
            <input name="amount" inputmode="numeric" dir="ltr" placeholder="0" aria-label="مبلغ المساهمة بالريال" required>
            <span class="field__suffix">ريال</span>
          </div>
        </div>
        <button type="submit" class="btn btn--accent btn--block btn--lg">أضِف إلى مدّخراتي</button>
      </div></div></div>
    </form>
    @else
    <div class="alert alert--success"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.6"/><path d="M8.4 12.3l2.4 2.4 4.6-5"/></svg></div><div><div class="alert__title">مبارك! بلغتَ هدفك</div><div class="alert__body">وصلت إلى هدفك دون اقتراض ولا فوائد. أحسنت الالتزام.</div></div></div>
    @endif

    <div class="stack">
      <div class="section-title">سجل المساهمات</div>
      @forelse($contributions as $c)
      <div class="card"><div class="card__body"><div class="listrow" style="border-bottom:0;min-height:auto">
        <div class="listrow__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.6"/><path d="M8.4 12.3l2.4 2.4 4.6-5"/></svg></div>
        <div class="grow"><div class="listrow__title">مساهمة</div><div class="listrow__sub"><span dir="ltr">{{ $c->contributed_at?->format('Y/m/d') }}</span> · {{ $statusMap[$c->status] ?? $c->status }}</div></div>
        <span class="money" dir="ltr">{{ number_format(($c->amount_halalas ?? 0) / 100) }} <span class="money__unit">ريال</span></span>
      </div></div></div>
      @empty
      <div class="empty">
        <div class="empty__art"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3.2" y="6.5" width="17.6" height="11" rx="2"/><circle cx="12" cy="12" r="2.4"/><path d="M6.6 9.6h.01M17.4 14.4h.01"/></svg></div>
        <div class="empty__title">لا مساهمات بعد</div>
        <div class="empty__desc">سجّل أول مساهمة لتبدأ رحلتك نحو هذا الهدف.</div>
      </div>
      @endforelse
    </div>

  </div>
</div>
</x-layout>
