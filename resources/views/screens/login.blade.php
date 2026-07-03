<x-layout title="تسجيل الدخول — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ route('landing') }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">تسجيل الدخول</div></div></div>
<div class="screen">
  <form method="POST" action="{{ route('auth.login') }}">
    @csrf
    <div class="stack-lg">
      <div class="stack-sm">
        <div class="eyebrow">مرحباً بعودتك</div>
        <div class="section-title">سجّل الدخول إلى رشيد</div>
        <div class="footnote">أدخل رقم جوّالك لنرسل إليك رمز دخول آمن لمرة واحدة. لا كلمة مرور تحفظها ولا تنساها.</div>
      </div>

      @if ($errors->any())
      <div class="alert alert--danger"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5 3 20h18L12 4.5z"/><path d="M12 10.5v4"/><circle cx="12" cy="17.4" r=".6" fill="currentColor" stroke="none"/></svg></div><div><div class="alert__body">{{ $errors->first() }}</div></div></div>
      @endif

      <div class="card card--pad">
        <div class="card__body">
          <div class="stack">
            <div class="field">
              <label class="field__label" for="phone">رقم الجوال</label>
              <div class="field__control @error('phone') is-error @enderror">
                <input id="phone" name="phone" type="tel" inputmode="tel" dir="ltr" placeholder="5X XXX XXXX" value="{{ old('phone') }}">
                <span class="field__suffix" dir="ltr">966+</span>
              </div>
            </div>
            <button type="submit" class="btn btn--primary btn--block btn--lg">إرسال رمز الدخول</button>
            <div class="footnote center">سنرسل رمزاً مكوّناً من ٦ أرقام خلال ثوانٍ.</div>
          </div>
        </div>
      </div>

      <div class="alert alert--info">
        <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="10.5" width="14" height="9.5" rx="2.2"/><path d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/><circle cx="12" cy="15" r="1.1" fill="currentColor" stroke="none"/></svg></div>
        <div>
          <div class="alert__title">دخول آمن دون كلمة مرور</div>
          <div class="alert__body">نتحقق من هويتك عبر رمز يُرسَل إلى جوّالك ويصلح لمرة واحدة فقط. لن يطلبه منك موظفو رشيد أبداً.</div>
        </div>
      </div>

      <div class="divider"></div>
      <div class="center stack-sm">
        <div class="footnote">ليس لديك حساب في رشيد بعد؟</div>
        <a href="{{ route('auth.register') }}" class="btn btn--ghost btn--block">أنشئ حساباً جديداً</a>
      </div>
    </div>
  </form>
</div>
</x-layout>
