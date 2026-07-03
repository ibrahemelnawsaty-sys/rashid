<x-layout title="هدف جديد — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ route('app.goals.index') }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">هدف جديد</div></div></div>
<div class="screen">
  <form method="POST" action="{{ route('app.goals.store') }}">
    @csrf
    <div class="stack-lg">
      <div class="stack-sm">
        <div class="eyebrow">ادّخر بدل أن تستدين</div>
        <div class="section-title">ما هدفك القادم؟</div>
        <div class="footnote">حدّد هدفاً ومبلغاً، وسنساعدك على الوصول إليه عبر خطة ادخار بدل الاقتراض.</div>
      </div>

      @if ($errors->any())
      <div class="alert alert--danger"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5 3 20h18L12 4.5z"/><path d="M12 10.5v4"/><circle cx="12" cy="17.4" r=".6" fill="currentColor" stroke="none"/></svg></div><div><div class="alert__body">{{ $errors->first() }}</div></div></div>
      @endif

      <div class="field">
        <label class="field__label" for="title">اسم الهدف</label>
        <div class="field__control @error('title') is-error @enderror">
          <input id="title" name="title" type="text" placeholder="مثال: شراء سيارة، زواج، صندوق طوارئ" value="{{ old('title') }}" maxlength="80">
        </div>
      </div>

      <div class="field is-amount">
        <label class="field__label" for="target">المبلغ المستهدف</label>
        <div class="field__control @error('target') is-error @enderror">
          <input id="target" name="target" inputmode="numeric" dir="ltr" placeholder="0" value="{{ old('target') }}" aria-label="المبلغ المستهدف بالريال">
          <span class="field__suffix">ريال</span>
        </div>
      </div>

      <div class="field">
        <label class="field__label" for="target_date">التاريخ المستهدف (اختياري)</label>
        <div class="field__control @error('target_date') is-error @enderror">
          <input id="target_date" name="target_date" type="date" dir="ltr" value="{{ old('target_date') }}">
        </div>
      </div>

      <div class="field is-amount">
        <label class="field__label" for="monthly">المساهمة الشهرية المخطّطة (اختياري)</label>
        <div class="field__control">
          <input id="monthly" name="monthly" inputmode="numeric" dir="ltr" placeholder="0" value="{{ old('monthly') }}" aria-label="المساهمة الشهرية بالريال">
          <span class="field__suffix">ريال</span>
        </div>
        <div class="footnote">نحسب لك الموعد المتوقّع للوصول بناءً على مساهمتك الشهرية.</div>
      </div>

      <button type="submit" class="btn btn--accent btn--block btn--lg">إنشاء الهدف</button>
    </div>
  </form>
</div>
</x-layout>
