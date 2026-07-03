<x-layout title="التحقق — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ url()->previous() }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">التحقق</div></div></div>
<div class="screen">
  <div class="stack-lg">
    <div class="stack-sm">
      <div class="eyebrow">خطوة أخيرة</div>
      <div class="section-title">أدخل رمز التحقق</div>
      <div class="footnote">أرسلنا رمزاً مكوّناً من ٦ أرقام إلى رقم جوّالك المسجّل <span dir="ltr">‎+966 50 •• •• 45</span></div>
    </div>

    <div class="otp">
      <input type="tel" inputmode="numeric" maxlength="1" value="4" aria-label="الرقم الأول">
      <input type="tel" inputmode="numeric" maxlength="1" value="9" aria-label="الرقم الثاني">
      <input type="tel" inputmode="numeric" maxlength="1" value="1" aria-label="الرقم الثالث">
      <input type="tel" inputmode="numeric" maxlength="1" value="8" aria-label="الرقم الرابع">
      <input type="tel" inputmode="numeric" maxlength="1" value="" aria-label="الرقم الخامس">
      <input type="tel" inputmode="numeric" maxlength="1" value="" aria-label="الرقم السادس">
    </div>

    <div class="row row-between">
      <span class="footnote">لم يصلك الرمز بعد؟</span>
      <span class="footnote">إعادة الإرسال خلال <span dir="ltr">00:47</span></span>
    </div>

    <div class="alert alert--info">
      <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="10.5" width="14" height="9.5" rx="2.2"/><path d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/><circle cx="12" cy="15" r="1.1" fill="currentColor" stroke="none"/></svg></div>
      <div>
        <div class="alert__title">حفاظاً على أمان حسابك</div>
        <div class="alert__body">لا تُشارك هذا الرمز مع أي جهة. لن يطلبه منك موظفو رشيد إطلاقاً.</div>
      </div>
    </div>

    <div class="stack-sm">
      <button class="btn btn--primary btn--block btn--lg">تأكيد الرمز</button>
      <button class="btn btn--ghost btn--block">تغيير الرقم</button>
    </div>

    <div class="footnote center">بإتمام التحقق فإنك توافق على شروط الاستخدام وسياسة الخصوصية في رشيد</div>
  </div>
</div>
</x-layout>
