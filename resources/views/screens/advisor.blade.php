<x-layout title="المستشار الذكي — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ route('app.dashboard') }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div><div class="appbar__title">مستشارك</div><div class="appbar__sub">يشرح لك أرقامك بلغة بسيطة</div></div></div></div>
<div class="screen screen--pb">
  <div class="stack">
    <div class="bubble bubble--assistant">أهلاً {{ \Illuminate\Support\Str::of($user->name)->explode(' ')->first() }}، أنا مستشارك في رشيد. دوري أن أشرح لك ما تعنيه أرقامك المالية وأوضّح خياراتك بلغة بسيطة، لكن القرار يبقى لك دائماً. اسألني عن أي رقم أو بديل.</div>

    @foreach ($messages as $m)
      <div class="bubble {{ $m->role === 'user' ? 'bubble--user' : 'bubble--assistant' }}">{{ $m->content }}</div>
    @endforeach
  </div>

  <div class="stack-sm">
    <div class="eyebrow">اقتراحات سريعة</div>
    <div class="row">
      @foreach (['اشرح نسبة الالتزام', 'كم أوفّر لو ادّخرت؟', 'ما البدائل المتاحة؟'] as $s)
      <form method="POST" action="{{ route('app.advisor.store') }}">@csrf<input type="hidden" name="message" value="{{ $s }}"><button class="pill" type="submit">{{ $s }}</button></form>
      @endforeach
    </div>
  </div>

  <form method="POST" action="{{ route('app.advisor.store') }}" class="field">
    @csrf
    <div class="field__control">
      <input type="text" name="message" placeholder="اكتب سؤالك للمستشار…" aria-label="اكتب سؤالك" maxlength="500" required autocomplete="off">
      <button class="iconbtn" type="submit" aria-label="إرسال الرسالة"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20V5"/><path d="M6.5 10.5 12 5l5.5 5.5"/></svg></button>
    </div>
  </form>

  <div class="footnote center">جميع الأرقام مستخرجة من محرك تحليل رشيد الخاص بك.</div>
</div>
<script>window.scrollTo(0, document.body.scrollHeight);</script>
@include('partials.bottomnav', ['active' => 'chat'])
</x-layout>
