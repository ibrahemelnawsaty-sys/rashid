<x-layout title="إنشاء حساب — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ route('landing') }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">إنشاء حساب</div></div></div>
<div class="screen">
  <form method="POST" action="{{ route('auth.register') }}" x-data="{ residency: '{{ old('residency_type', 'citizen') }}' }">
    @csrf
    <input type="hidden" name="residency_type" :value="residency">
    <div class="stack-lg">
      <div class="stack-sm">
        <div class="eyebrow">مرحباً بك في رشيد</div>
        <div class="section-title">أنشئ حسابك</div>
        <div class="footnote">دقيقة واحدة تكفي لتبدأ رحلتك نحو قرارٍ مالي أرشد.</div>
      </div>

      @if ($errors->any())
      <div class="alert alert--danger"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5 3 20h18L12 4.5z"/><path d="M12 10.5v4"/><circle cx="12" cy="17.4" r=".6" fill="currentColor" stroke="none"/></svg></div><div><div class="alert__body">{{ $errors->first() }}</div></div></div>
      @endif

      <div class="field">
        <label class="field__label" for="phone">رقم الجوال</label>
        <div class="field__control @error('phone') is-error @enderror">
          <input id="phone" name="phone" type="tel" inputmode="tel" dir="ltr" placeholder="5X XXX XXXX" value="{{ old('phone') }}">
          <span class="field__suffix" dir="ltr">966+</span>
        </div>
        <div class="footnote">سنرسل رمز تحقّق لتأكيد رقمك.</div>
      </div>

      <div class="field">
        <label class="field__label" for="name">الاسم الكامل</label>
        <div class="field__control @error('name') is-error @enderror">
          <input id="name" name="name" type="text" placeholder="مثال: محمد عبدالله" value="{{ old('name') }}">
        </div>
      </div>

      <div class="stack-sm">
        <div class="field__label">نوع الإقامة</div>
        <div class="segmented">
          <div role="button" tabindex="0" class="segmented__opt" :class="{ 'is-active': residency === 'citizen' }" @click="residency = 'citizen'">مواطن</div>
          <div role="button" tabindex="0" class="segmented__opt" :class="{ 'is-active': residency === 'resident' }" @click="residency = 'resident'">مقيم</div>
        </div>
      </div>

      <label class="row">
        <input type="checkbox" name="consent" value="1" {{ old('consent') ? 'checked' : '' }}>
        <div class="footnote">أوافق على معالجة بياناتي وفق سياسة الخصوصية وشروط الاستخدام في رشيد.</div>
      </label>

      <div class="stack-sm">
        <button type="submit" class="btn btn--accent btn--block btn--lg">متابعة</button>
        <a href="{{ route('auth.login') }}" class="btn btn--ghost btn--block">لديك حساب؟ سجّل الدخول</a>
      </div>
    </div>
  </form>
</div>
</x-layout>
