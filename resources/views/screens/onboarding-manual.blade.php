<x-layout title="الإدخال اليدوي — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ route('app.onboarding.source') }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">الإدخال اليدوي</div></div></div>
<div class="screen">
  <form method="POST" action="{{ route('app.onboarding.manual.store') }}">
    @csrf
    <div class="stack-lg">

      <div class="steps">
        <div class="s is-done">الموافقة</div>
        <div class="s is-done">المصدر</div>
        <div class="s is-active">بياناتك</div>
      </div>

      <div class="stack-sm">
        <div class="eyebrow">الخطوة الأخيرة</div>
        <div class="section-title">أخبرنا عن وضعك المالي</div>
        <div class="footnote">أدخل أرقاماً تقريبية شهرية؛ سنحسب لك نسبة التزامك وقدرتك على الادخار فوراً. يمكنك تعديلها لاحقاً في أي وقت.</div>
      </div>

      @if ($errors->any())
      <div class="alert alert--danger"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5 3 20h18L12 4.5z"/><path d="M12 10.5v4"/><circle cx="12" cy="17.4" r=".6" fill="currentColor" stroke="none"/></svg></div><div><div class="alert__body">{{ $errors->first() }}</div></div></div>
      @endif

      <div class="field is-amount">
        <label class="field__label" for="income">الدخل الشهري</label>
        <div class="field__control @error('income') is-error @enderror">
          <input id="income" name="income" inputmode="numeric" dir="ltr" placeholder="0" value="{{ old('income') }}" aria-label="الدخل الشهري بالريال">
          <span class="field__suffix">ريال</span>
        </div>
        <div class="footnote">مجموع دخلك الشهري (راتب + أي دخل آخر).</div>
      </div>

      <div class="field is-amount">
        <label class="field__label" for="expenses">المصروفات الشهرية</label>
        <div class="field__control @error('expenses') is-error @enderror">
          <input id="expenses" name="expenses" inputmode="numeric" dir="ltr" placeholder="0" value="{{ old('expenses') }}" aria-label="المصروفات الشهرية بالريال">
          <span class="field__suffix">ريال</span>
        </div>
        <div class="footnote">متوسط ما تنفقه شهرياً (سكن، غذاء، مواصلات...).</div>
      </div>

      <div class="divider"></div>

      <div class="stack-sm">
        <div class="section-title">التزاماتك الحالية (اختياري)</div>
        <div class="footnote">إن كان عليك قسط قرض أو تمويل قائم، أدخل قيمته الشهرية لحساب نسبة التزامك بدقّة.</div>
      </div>

      <div class="field is-amount">
        <label class="field__label" for="obligation_monthly">القسط الشهري للالتزامات</label>
        <div class="field__control">
          <input id="obligation_monthly" name="obligation_monthly" inputmode="numeric" dir="ltr" placeholder="0" value="{{ old('obligation_monthly') }}" aria-label="القسط الشهري للالتزامات بالريال">
          <span class="field__suffix">ريال</span>
        </div>
      </div>

      <div class="field is-amount">
        <label class="field__label" for="obligation_remaining">إجمالي المبلغ المتبقّي (اختياري)</label>
        <div class="field__control">
          <input id="obligation_remaining" name="obligation_remaining" inputmode="numeric" dir="ltr" placeholder="0" value="{{ old('obligation_remaining') }}" aria-label="إجمالي المبلغ المتبقّي بالريال">
          <span class="field__suffix">ريال</span>
        </div>
      </div>

      <div class="alert alert--info">
        <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="10.5" width="14" height="9.5" rx="2.2"/><path d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/><circle cx="12" cy="15" r="1.1" fill="currentColor" stroke="none"/></svg></div>
        <div><div class="alert__title">بياناتك محفوظة</div><div class="alert__body">تُشفّر معلوماتك المالية ولا تُشارك مع أي جهة دون إذنك.</div></div>
      </div>

      <button type="submit" class="btn btn--accent btn--block btn--lg">احسب وضعي المالي</button>
    </div>
  </form>
</div>
</x-layout>
