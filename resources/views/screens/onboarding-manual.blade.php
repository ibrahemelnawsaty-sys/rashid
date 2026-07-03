<x-layout title="الإدخال اليدوي — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ url()->previous() }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">الإدخال اليدوي</div></div></div>
<div class="screen">
  <div class="stack-lg">

    <div class="steps">
      <div class="s is-done">الحسابات</div>
      <div class="s is-done">التحقّق</div>
      <div class="s is-active">الدخل</div>
      <div class="s">المصروفات</div>
    </div>

    <div class="stack-sm">
      <div class="eyebrow">الخطوة 3 من 4</div>
      <div class="section-title">ما مصادر دخلك؟</div>
      <div class="footnote">نستخدم هذه المعلومات لبناء صورة دقيقة عن وضعك المالي وقدرتك على الالتزام.</div>
    </div>

    <div class="field is-amount">
      <div class="field__label">قيمة الدخل الشهري</div>
      <div class="field__control">
        <input inputmode="numeric" value="9,000" aria-label="قيمة الدخل الشهري">
        <span class="field__suffix">ريال</span>
      </div>
    </div>

    <div class="stack-sm">
      <div class="field__label">نوع الدخل</div>
      <div class="segmented" role="tablist" aria-label="نوع الدخل">
        <div class="segmented__opt is-active">راتب</div>
        <div class="segmented__opt">أعمال حرة</div>
        <div class="segmented__opt">دعم حكومي</div>
      </div>
    </div>

    <div class="stack-sm">
      <div class="field__label">تكرار الدخل</div>
      <div class="segmented" role="tablist" aria-label="تكرار الدخل">
        <div class="segmented__opt is-active">شهري</div>
        <div class="segmented__opt">ربع سنوي</div>
        <div class="segmented__opt">متغيّر</div>
      </div>
    </div>

    <div class="card">
      <div class="card__body">
        <div class="row row-between">
          <div class="stack-sm">
            <div class="eyebrow">الملخّص</div>
            <div class="stat__label">الدخل الشهري المقدّر</div>
          </div>
          <span class="money" dir="ltr">9,000 <span class="money__unit">ريال</span></span>
        </div>
        <div class="divider"></div>
        <div class="row row-between">
          <div class="footnote">راتب ثابت · يُودَع شهرياً</div>
          <span class="badge badge--success"><span class="dot"></span>مصدر مؤكَّد</span>
        </div>
      </div>
    </div>

    <div class="alert --info">
      <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="10.5" width="14" height="9.5" rx="2.2"/><path d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/><circle cx="12" cy="15" r="1.1" fill="currentColor" stroke="none"/></svg></div>
      <div>
        <div class="alert__title">بياناتك محفوظة</div>
        <div class="alert__body">تُشفّر معلوماتك المالية ولا تُشارك مع أي جهة دون إذنك.</div>
      </div>
    </div>

    <div class="stack-sm">
      <button class="btn btn--accent btn--block btn--lg">التالي: المصروفات</button>
      <button class="btn btn--ghost btn--block">إضافة مصدر آخر +</button>
    </div>

  </div>
</div>
</x-layout>
