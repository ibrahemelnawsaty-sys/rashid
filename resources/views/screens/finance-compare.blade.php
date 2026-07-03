<x-layout title="مقارنة العروض — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ url()->previous() }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">قارن العروض</div></div></div>
<div class="screen">
  <div class="stack-lg">

    <div class="stack-sm">
      <div class="eyebrow">تمويل شراء سيارة · <span class="money" dir="ltr">30,000 <span class="money__unit">ريال</span></span></div>
      <div class="section-title">أربعة عروض مرتّبة بالأقل تكلفة إجمالية</div>
      <div class="footnote">قارنّا القسط الشهري والتكلفة الكلية على مدة 36 شهراً بعد رسوم الإصدار. الأرشد لك هو الأقل تكلفةً إجمالاً، لا الأقل قسطاً.</div>
    </div>

    <div class="stack">

      <div class="apr-row is-best">
        <div class="row-between">
          <div class="row"><strong>مصرف الراجحي</strong><span class="badge badge--accent">الأرشد</span></div>
          <span class="badge badge--success"><span class="dot"></span>APR <span dir="ltr">3.92%</span></span>
        </div>
        <div class="apr-row__bar"><div class="apr-row__fill apr-row__fill--best" style="width:58%"></div></div>
        <div class="row-between">
          <div class="footnote">قسط شهري <span class="money" dir="ltr">884 <span class="money__unit">ريال</span></span></div>
          <div class="footnote">إجمالي التكلفة <span class="money" dir="ltr">31,824 <span class="money__unit">ريال</span></span></div>
        </div>
      </div>

      <div class="apr-row">
        <div class="row-between">
          <div class="row"><strong>البنك الأهلي</strong></div>
          <span class="badge badge--neutral">APR <span dir="ltr">5.40%</span></span>
        </div>
        <div class="apr-row__bar"><div class="apr-row__fill apr-row__fill--mid" style="width:71%"></div></div>
        <div class="row-between">
          <div class="footnote">قسط شهري <span class="money" dir="ltr">905 <span class="money__unit">ريال</span></span></div>
          <div class="footnote">إجمالي التكلفة <span class="money" dir="ltr">32,580 <span class="money__unit">ريال</span></span></div>
        </div>
      </div>

      <div class="apr-row">
        <div class="row-between">
          <div class="row"><strong>بنك الرياض</strong></div>
          <span class="badge badge--neutral">APR <span dir="ltr">6.85%</span></span>
        </div>
        <div class="apr-row__bar"><div class="apr-row__fill apr-row__fill--mid" style="width:84%"></div></div>
        <div class="row-between">
          <div class="footnote">قسط شهري <span class="money" dir="ltr">925 <span class="money__unit">ريال</span></span></div>
          <div class="footnote">إجمالي التكلفة <span class="money" dir="ltr">33,300 <span class="money__unit">ريال</span></span></div>
        </div>
      </div>

      <div class="apr-row">
        <div class="row-between">
          <div class="row"><strong>شركة تمويل مرابحة</strong></div>
          <span class="badge badge--warning">APR <span dir="ltr">9.10%</span></span>
        </div>
        <div class="apr-row__bar"><div class="apr-row__fill apr-row__fill--high" style="width:100%"></div></div>
        <div class="row-between">
          <div class="footnote">قسط شهري <span class="money" dir="ltr">956 <span class="money__unit">ريال</span></span></div>
          <div class="footnote">إجمالي التكلفة <span class="money" dir="ltr">34,416 <span class="money__unit">ريال</span></span></div>
        </div>
      </div>

    </div>

    <div class="alert alert--info">
      <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3.5 19 6.2v4.9c0 4.4-3 7.3-7 8.9-4-1.6-7-4.5-7-8.9V6.2l7-2.7z"/></svg></div>
      <div>
        <div class="alert__title">محمي بضوابط ساما</div>
        <div class="alert__body">مدة التمويل لا تتجاوز 60 شهراً، ورسوم الإصدار مسقوفة عند 0.5% من مبلغ التمويل أو <span class="money" dir="ltr">2,500 <span class="money__unit">ريال</span></span> أيّهما أقل. أي بندٍ خارج هذه الحدود يحق لك رفضه.</div>
      </div>
    </div>

    <div class="stack-sm">
      <button class="btn btn--primary btn--block btn--lg">اختر الأرشد · الراجحي</button>
      <div class="footnote center">اختيار الأرشد يوفّر عليك <span class="money" dir="ltr">2,592 <span class="money__unit">ريال</span></span> مقارنةً بأغلى عرض.</div>
    </div>

  </div>
</div>
</x-layout>
