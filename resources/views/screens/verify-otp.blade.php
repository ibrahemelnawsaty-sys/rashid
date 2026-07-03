<x-layout title="التحقق — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ route('auth.login') }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">التحقق</div></div></div>
<div class="screen">
  <div class="stack-lg">
    <div class="stack-sm">
      <div class="eyebrow">خطوة أخيرة</div>
      <div class="section-title">أدخل رمز التحقق</div>
      <div class="footnote">أرسلنا رمزاً مكوّناً من ٦ أرقام إلى رقم جوّالك <span dir="ltr">+966 {{ substr($phone, 3, 2) }} ••• {{ substr($phone, -2) }}</span></div>
    </div>

    @if ($errors->any())
    <div class="alert alert--danger"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5 3 20h18L12 4.5z"/><path d="M12 10.5v4"/><circle cx="12" cy="17.4" r=".6" fill="currentColor" stroke="none"/></svg></div><div><div class="alert__body">{{ $errors->first() }}</div></div></div>
    @endif

    @if (! empty($devOtp))
    <div class="alert alert--warning"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9.2 18h5.6"/><path d="M10 21h4"/><path d="M12 3.2a5.8 5.8 0 0 1 3.9 10.1c-.7.6-1 1.4-1 2.3H9.1c0-.9-.3-1.7-1-2.3A5.8 5.8 0 0 1 12 3.2z"/></svg></div><div><div class="alert__title">وضع تجريبي (لا توجد رسائل SMS بعد)</div><div class="alert__body">رمزك هو: <strong dir="ltr" style="letter-spacing:.2em">{{ $devOtp }}</strong></div></div></div>
    @endif

    <form method="POST" action="{{ route('auth.otp.verify') }}" x-data="{ d: ['','','','','',''] }">
      @csrf
      <input type="hidden" name="code" :value="d.join('')">
      <div class="stack-lg">
        <div class="otp">
          @for ($i = 0; $i < 6; $i++)
          <input x-ref="o{{ $i }}" type="tel" inputmode="numeric" maxlength="1" dir="ltr" aria-label="الرقم {{ $i + 1 }}"
            x-on:input="d[{{ $i }}] = $event.target.value.replace(/\D/g,'').slice(-1); $event.target.value = d[{{ $i }}]; if (d[{{ $i }}] && {{ $i }} < 5) $refs.o{{ $i + 1 }}.focus()"
            x-on:keydown.backspace="if (! d[{{ $i }}] && {{ $i }} > 0) $refs.o{{ $i - 1 }}.focus()">
          @endfor
        </div>
        <button type="submit" class="btn btn--primary btn--block btn--lg">تأكيد الرمز</button>
      </div>
    </form>

    <form method="POST" action="{{ route('auth.otp.resend') }}">
      @csrf
      <div class="center"><button type="submit" class="btn btn--ghost">لم يصلك الرمز؟ إعادة الإرسال</button></div>
    </form>

    <div class="footnote center">لا تُشارك هذا الرمز مع أحد. لن يطلبه منك موظفو رشيد إطلاقاً.</div>
  </div>
</div>
</x-layout>
