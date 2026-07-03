<x-layout title="أهلاً بك — رشيد">
<div class="appbar appbar--brand"><div class="appbar__row"><div class="appbar__title">رشيد</div><div class="appbar__spacer"></div><span class="badge badge--accent">تجربتك تبدأ الآن</span></div></div>
<div class="screen">
<div class="stack-lg">

  <div class="center stack-sm">
    <div class="welcome-badge"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3.5 19 6.2v4.9c0 4.4-3 7.3-7 8.9-4-1.6-7-4.5-7-8.9V6.2l7-2.7z"/><path d="M9.2 12.2l1.9 1.9 3.9-4"/></svg></div>
    <div class="section-title">أهلاً بك في رشيد</div>
    <p class="footnote center" style="max-width:36ch">رفيقك المالي الذي يقف في صفّك. هدفنا حمايتك ماليّاً ومساعدتك على القرار الأنسب لك — لا بيع منتجات ولا دفعك للاقتراض. كل توصية مبنيّة على مصلحتك أنت وحدك.</p>
  </div>

  <div class="stepper">
    <div class="stepper__item is-active"><span class="stepper__dot">1</span><span>الموافقة</span></div>
    <div class="stepper__item"><span class="stepper__dot">2</span><span>المصدر</span></div>
    <div class="stepper__item"><span class="stepper__dot">3</span><span>بياناتك</span></div>
  </div>

  <div class="card"><div class="card__body stack">
    <div class="listrow" style="border-bottom:0">
      <div class="listrow__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="10.5" width="14" height="9.5" rx="2.2"/><path d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/><circle cx="12" cy="15" r="1.1" fill="currentColor" stroke="none"/></svg></div>
      <div class="grow"><div class="listrow__title">خصوصيتك أولاً</div><div class="listrow__sub">بياناتك مشفّرة وتبقى ملكك وحدك، ولك سحبها في أي وقت.</div></div>
    </div>
    <div class="divider" style="margin:0"></div>
    <div class="listrow" style="border-bottom:0">
      <div class="listrow__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4v16"/><path d="M7 6h10"/><path d="M8 20h8"/><path d="M7 6 4 12.5a3 3 0 0 0 6 0L7 6z"/><path d="M17 6l-3 6.5a3 3 0 0 0 6 0L17 6z"/></svg></div>
      <div class="grow"><div class="listrow__title">رأي محايد</div><div class="listrow__sub">نوازن قبل أن تقترض، ونكشف التكلفة الحقيقية، ونقترح البدائل الأنسب.</div></div>
    </div>
    <div class="divider" style="margin:0"></div>
    <div class="listrow" style="border-bottom:0">
      <div class="listrow__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4.4"/><circle cx="12" cy="12" r="1.1" fill="currentColor" stroke="none"/></svg></div>
      <div class="grow"><div class="listrow__title">أهداف واضحة</div><div class="listrow__sub">خطط ادخار عملية وخطوات ملموسة للوصول إلى ما تريد.</div></div>
    </div>
  </div></div>

  <div class="stack-sm">
    <a href="{{ route('app.onboarding.consent') }}" class="btn btn--accent btn--block btn--lg">لنبدأ</a>
    <p class="footnote center">بالمتابعة أنت توافق على شروط الخدمة وسياسة الخصوصية</p>
  </div>

</div>
</div>
</x-layout>
