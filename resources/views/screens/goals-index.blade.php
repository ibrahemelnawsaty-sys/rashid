<x-layout title="أهدافي — رشيد">
<div class="appbar"><div class="appbar__row"><div class="appbar__title">أهدافي</div><div class="appbar__spacer"></div><button class="iconbtn" aria-label="إضافة هدف جديد">＋</button></div></div>
<div class="screen screen--pb">
<div class="stack">

<div class="row-between">
<div>
<div class="eyebrow">إجمالي المدّخر في أهدافك</div>
<div class="amount-display"><span class="money" dir="ltr">26,000 <span class="money__unit">ريال</span></span></div>
</div>
<span class="badge badge--success"><span class="dot"></span> هدفان نشطان</span>
</div>

<div class="section-title">أهدافك</div>

<div class="card">
<div class="card__body">
<div class="stack-sm">
<div class="row-between">
<div class="row"><span class="pill"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 13 6 8.8A2 2 0 0 1 7.9 7.5h8.2A2 2 0 0 1 18 8.8L19.5 13"/><path d="M3.5 13h17v4.2a1 1 0 0 1-1 1h-1.3a1 1 0 0 1-1-1V16.4H6.8v.8a1 1 0 0 1-1 1H4.5a1 1 0 0 1-1-1V13z"/><circle cx="7.2" cy="16" r="1.1"/><circle cx="16.8" cy="16" r="1.1"/></svg></span><div class="grow"><div class="stat__label">شراء سيارة</div><div class="footnote">هدف طويل الأمد</div></div></div>
<span class="badge badge--info"><span class="dot"></span> في المسار</span>
</div>
<div class="progress"><div class="progress__bar" style="width:60%"></div></div>
<div class="row-between">
<div class="footnote">المدّخر <span class="money" dir="ltr">18,000 <span class="money__unit">ريال</span></span> من <span class="money" dir="ltr">30,000 <span class="money__unit">ريال</span></span></div>
<div class="footnote" dir="ltr">60%</div>
</div>
<div class="divider"></div>
<div class="row-between">
<div class="stat"><div class="stat__label">المبلغ المتبقّي</div><div class="stat__value"><span class="money" dir="ltr">12,000 <span class="money__unit">ريال</span></span></div></div>
<div class="stat"><div class="stat__label">الموعد المتوقّع</div><div class="stat__value">مارس 2027</div></div>
</div>
</div>
</div>
</div>

<div class="card">
<div class="card__body">
<div class="stack-sm">
<div class="row-between">
<div class="row"><span class="pill"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3.5 19 6.2v4.9c0 4.4-3 7.3-7 8.9-4-1.6-7-4.5-7-8.9V6.2l7-2.7z"/></svg></span><div class="grow"><div class="stat__label">صندوق الطوارئ</div><div class="footnote">شبكة أمان مالية</div></div></div>
<span class="badge badge--accent"><span class="dot"></span> قريب الاكتمال</span>
</div>
<div class="progress"><div class="progress__bar progress__bar--success" style="width:80%"></div></div>
<div class="row-between">
<div class="footnote">المدّخر <span class="money" dir="ltr">8,000 <span class="money__unit">ريال</span></span> من <span class="money" dir="ltr">10,000 <span class="money__unit">ريال</span></span></div>
<div class="footnote" dir="ltr">80%</div>
</div>
<div class="divider"></div>
<div class="row-between">
<div class="stat"><div class="stat__label">المبلغ المتبقّي</div><div class="stat__value"><span class="money" dir="ltr">2,000 <span class="money__unit">ريال</span></span></div></div>
<div class="stat"><div class="stat__label">الموعد المتوقّع</div><div class="stat__value">سبتمبر 2026</div></div>
</div>
</div>
</div>
</div>

<button class="btn btn--accent btn--block btn--lg">＋ إنشاء هدف جديد</button>

<div class="alert alert--success">
<div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.6"/><path d="M8.4 12.3l2.4 2.4 4.6-5"/></svg></div>
<div>
<div class="alert__title">أنت على المسار الصحيح</div>
<div class="alert__body">استمرارك على وتيرة الادخار الحالية يقرّبك من أهدافك في الموعد المتوقّع تماماً.</div>
</div>
</div>

</div>
</div>
@include('partials.bottomnav', ['active' => 'target'])
</x-layout>
