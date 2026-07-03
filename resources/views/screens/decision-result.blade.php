@php
    $isAvoid = ($outcome?->verdict ?? 'avoid_borrowing') === 'avoid_borrowing';
    $amountSar = number_format($amount / 100);
    $interestSar = number_format(($interestMax ?? 0) / 100);
    $affPct = (int) round((float) ($outcome?->affordability_score ?? 0));
    $cheapest = number_format((float) ($outcome?->cheapest_apr ?? \App\Services\Support\FinanceMath::APR_MIN), 2);
    $aprMaxInt = (int) ($aprMax ?? 48);
@endphp
<x-layout title="نتيجة تحليلك — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ route('app.decisions.create') }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">نتيجة تحليلك</div></div></div>
<div class="screen">
<div class="stack">

@if ($isAvoid)
<div class="alert alert--success"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.6"/><path d="M8.4 12.3l2.4 2.4 4.6-5"/></svg></div><div><div class="alert__title">الخبر السار: لست مضطراً للاقتراض</div><div class="alert__body">راجعنا دخلك ومصروفاتك وقدرتك على الادخار، ووجدنا أنّ أمامك مساراً أذكى يجنّبك الفوائد.</div></div></div>
@else
<div class="alert alert--warning"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5 3 20h18L12 4.5z"/><path d="M12 10.5v4"/><circle cx="12" cy="17.4" r=".6" fill="currentColor" stroke="none"/></svg></div><div><div class="alert__title">إن كان الاقتراض حتمياً، فلنرشّده</div><div class="alert__body">إليك التكلفة الحقيقية والبدائل الأقل عبئاً قبل أن تقرّر.</div></div></div>
@endif

<div class="card card--pad">
<div class="stack-sm">
<div class="eyebrow">الصدمة الإيجابية</div>
<div class="footnote">لو اقترضت <span class="money" dir="ltr">{{ $amountSar }} <span class="money__unit">ريال</span></span> على مدى {{ $tenor }} شهراً، ستدفع فوائد تقديرية قدرها:</div>
<div class="badge badge--danger"><span class="dot"></span>فوائد بلا مقابل</div>
<div class="amount-display" dir="ltr">+{{ $interestSar }} <span class="money__unit">ريال</span></div>
<div class="divider"></div>
<div class="row-between">
<div class="stat"><div class="stat__label">أعلى APR في السوق</div><div class="stat__value" dir="ltr">{{ $aprMaxInt }}%</div></div>
<div class="stat"><div class="stat__label">الأقل المتاح لك</div><div class="stat__value" dir="ltr">{{ $cheapest }}%</div><div class="stat__foot"><span class="badge badge--success">الأدنى</span></div></div>
</div>
</div>
</div>

<div class="card"><div class="card__body">
<div class="stack-sm">
<div class="row-between"><div class="section-title">قدرتك على السداد</div><div class="badge {{ $affPct >= 60 ? 'badge--success' : ($affPct >= 40 ? 'badge--warning' : 'badge--danger') }}"><span class="dot"></span>{{ $affPct >= 60 ? 'مريحة' : ($affPct >= 40 ? 'متوسطة' : 'ضيّقة') }}</div></div>
<div class="progress"><div class="progress__bar {{ $affPct >= 60 ? 'progress__bar--success' : ($affPct >= 40 ? 'progress__bar--warning' : 'progress__bar--danger') }}" style="width:{{ $affPct }}%"></div></div>
<div class="row-between"><div class="footnote">درجة القدرة على السداد وفق دخلك المتاح ونسبة التزامك</div><div class="stat__value" dir="ltr">{{ $affPct }}%</div></div>
</div>
</div></div>

<div class="card"><div class="card__body">
<div class="stack-sm">
<div class="section-title">لماذا هذا القرار؟</div>
<div class="footnote">{{ $outcome?->rationale_ar }}</div>
</div>
</div></div>

<div class="stack-sm">
<div class="section-title">بدائل بصفر فوائد</div>

@forelse ($alternatives as $alt)
<div class="alt-card {{ $loop->first ? 'is-top' : '' }}">
<div class="alt-card__head"><div class="alt-num">{{ $loop->iteration }}</div><div class="grow"><div class="alt-card__title">{{ $alt->name_ar }}</div><div class="alt-card__summary">{{ \Illuminate\Support\Str::limit($alt->summary_ar, 120) }}</div></div></div>
<div class="alt-card__body">
<div class="row-between">
<div class="saving-chip">توفير متوقّع <span class="money" dir="ltr">{{ $interestSar }} <span class="money__unit">ريال</span></span></div>
<a href="{{ route('app.alternatives.index') }}" class="btn btn--ghost btn--sm">التفاصيل</a>
</div>
@if ($alt->providers->isNotEmpty())
<div class="row">
@foreach ($alt->providers->take(3) as $ap)
@php $pname = $ap->provider->name_ar ?? ($ap->provider->name ?? null); @endphp
@if ($pname)<span class="badge badge--info">{{ $pname }}</span>@endif
@endforeach
</div>
@endif
</div>
</div>
@empty
<div class="footnote">لا توجد بدائل مقترحة حالياً.</div>
@endforelse

</div>

<div class="stack-sm">
<a href="{{ route('app.goals.index') }}" class="btn btn--primary btn--block btn--lg">ابدأ خطة ادخار بدل القرض</a>
<a href="{{ route('app.advisor.index') }}" class="btn btn--ghost btn--block">استشر المستشار الذكي</a>
</div>

<div class="footnote center">تحليل تقديري لأغراض إرشادية، وقرارك المالي يبقى لك.</div>

</div>
</div>
</x-layout>
