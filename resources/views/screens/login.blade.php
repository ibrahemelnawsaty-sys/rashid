<x-layout title="تسجيل الدخول — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ url()->previous() }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">تسجيل الدخول</div></div></div>
<div class="screen">
  <div class="stack-lg">
    <div class="stack-sm">
      <div class="eyebrow">مرحباً بعودتك</div>
      <div class="section-title">سجّل الدخول إلى رشيد</div>
      <div class="footnote">أدخل رقم جوّالك لنرسل إليك رمز دخول آمن لمرة واحدة. لا كلمة مرور تحفظها ولا تنساها.</div>
    </div>

    <div class="card card--pad">
      <div class="card__body">
        <div class="stack">
          <div class="field">
            <label class="field__label">رقم الجوال</label>
            <div class="field__control">
              <span class="field__suffix"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6.5 3.5h3l1.4 4.6-1.9 1.4a10.5 10.5 0 0 0 4.9 4.9l1.4-1.9 4.6 1.4v3a2 2 0 0 1-2.1 2A15.5 15.5 0 0 1 4.5 5.6a2 2 0 0 1 2-2.1z"/></svg></span>
              <input type="tel" inputmode="numeric" dir="ltr" placeholder="05X XXX XXXX" value="0512 345 678">
            </div>
          </div>
          <button class="btn btn--primary btn--block btn--lg">إرسال رمز الدخول</button>
          <div class="footnote center">سنرسل رمزاً مكوّناً من أربعة أرقام خلال ثوانٍ.</div>
        </div>
      </div>
    </div>

    <div class="alert alert--info">
      <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="10.5" width="14" height="9.5" rx="2.2"/><path d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/><circle cx="12" cy="15" r="1.1" fill="currentColor" stroke="none"/></svg></div>
      <div>
        <div class="alert__title">دخول آمن دون كلمة مرور</div>
        <div class="alert__body">نتحقق من هويتك عبر رمز يُرسَل إلى جوّالك ويصلح لمرة واحدة فقط. لن يطلبه منك موظفو رشيد أبداً، فلا تشاركه مع أحد.</div>
      </div>
    </div>

    <div class="divider"></div>

    <div class="center stack-sm">
      <div class="footnote">ليس لديك حساب في رشيد بعد؟</div>
      <button class="btn btn--ghost btn--block">أنشئ حساباً جديداً</button>
    </div>
  </div>
</div>
</x-layout>
