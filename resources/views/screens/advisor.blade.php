<x-layout title="المستشار الذكي — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ url()->previous() }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div><div class="appbar__title">مستشارك</div><div class="appbar__sub">يشرح لك أرقامك بلغة بسيطة</div></div><div class="appbar__spacer"></div><button class="iconbtn" aria-label="سجل المحادثات"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 1.8"/></svg></button></div></div>
<div class="screen screen--pb">
  <div class="stack">
    <div class="bubble bubble--assistant">أهلاً محمد، أنا مستشارك في رشيد. دوري أن أشرح لك ما تعنيه أرقامك المالية وأوضّح خياراتك بلغة بسيطة، لكن القرار يبقى لك دائماً. اسألني عن أي رقم أو بديل.</div>

    <div class="bubble bubble--user">اشرح لي نتيجة تحليلي.</div>

    <div class="bubble bubble--assistant">باختصار، وضعك مريح. دخلك <span class="money" dir="ltr">9,000 <span class="money__unit">ريال</span></span> ومصروفك <span class="money" dir="ltr">5,550 <span class="money__unit">ريال</span></span>، أي يتبقّى معك شهرياً <span class="money" dir="ltr">3,450 <span class="money__unit">ريال</span></span>. ونسبة التزامك إلى دخلك <span dir="ltr">32%</span>، وهي منخفضة ومطمئنة.</div>

    <div class="bubble bubble--assistant">لذلك الادّخار أفضل لك من الاقتراض لشراء السيارة: قرض بـ <span class="money" dir="ltr">30,000 <span class="money__unit">ريال</span></span> سيكلّفك فوائد تقديرية تقارب <span class="money" dir="ltr">6,840 <span class="money__unit">ريال</span></span>. أما بفائضك الشهري فتستطيع تكوين المبلغ خلال نحو <span dir="ltr">5</span> أشهر عبر البدائل، ويبقى المبلغ كاملاً في جيبك دون أي كلفة.</div>

    <div class="typing" aria-label="المستشار يكتب"><i></i><i></i><i></i></div>
  </div>

  <div class="stack-sm">
    <div class="eyebrow">اقتراحات سريعة</div>
    <div class="row">
      <span class="pill">ما أفضل بديل لهدفي؟</span>
      <span class="pill">كم أوفّر لو ادّخرت؟</span>
      <span class="pill">اشرح نسبة الالتزام</span>
    </div>
  </div>

  <div class="field">
    <div class="field__control">
      <input type="text" placeholder="اكتب سؤالك للمستشار…" aria-label="اكتب سؤالك">
      <button class="iconbtn" aria-label="إرسال الرسالة"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20V5"/><path d="M6.5 10.5 12 5l5.5 5.5"/></svg></button>
    </div>
  </div>

  <div class="footnote center">جميع الأرقام مستخرجة من محرك تحليل رشيد الخاص بك.</div>
</div>
@include('partials.bottomnav', ['active' => 'chat'])
</x-layout>
