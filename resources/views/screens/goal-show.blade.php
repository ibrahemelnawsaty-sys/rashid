<x-layout title="تفصيل الهدف — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ url()->previous() }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">هدف: سيارة</div><div class="appbar__spacer"></div><button class="iconbtn" aria-label="تعديل الهدف"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 19.5h4L18.7 9.3a1.9 1.9 0 0 0-2.7-2.7L5.8 16.8v2.7z"/><path d="M14.5 8l2.7 2.7"/></svg></button></div></div>
<div class="screen">
  <div class="stack-lg">

    <div class="card">
      <div class="card__body">
        <div class="stack">
          <div class="row-between">
            <div class="row">
              <span class="pill"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 13 6 8.8A2 2 0 0 1 7.9 7.5h8.2A2 2 0 0 1 18 8.8L19.5 13"/><path d="M3.5 13h17v4.2a1 1 0 0 1-1 1h-1.3a1 1 0 0 1-1-1V16.4H6.8v.8a1 1 0 0 1-1 1H4.5a1 1 0 0 1-1-1V13z"/><circle cx="7.2" cy="16" r="1.1"/><circle cx="16.8" cy="16" r="1.1"/></svg></span>
              <div>
                <div class="section-title">شراء سيارة</div>
                <div class="footnote">خطة ادخار شهرية</div>
              </div>
            </div>
            <span class="badge badge--success"><span class="dot"></span>في المسار الصحيح</span>
          </div>

          <div class="row-between">
            <span class="amount-lg"><span class="money" dir="ltr">27,000 <span class="money__unit">ريال</span></span></span>
            <span class="footnote" dir="ltr">60%</span>
          </div>

          <div class="progress"><div class="progress__bar progress__bar--success" style="width:60%"></div></div>

          <div class="grid-2">
            <div class="stat">
              <div class="stat__label">الهدف</div>
              <div class="stat__value"><span class="money" dir="ltr">45,000 <span class="money__unit">ريال</span></span></div>
            </div>
            <div class="stat">
              <div class="stat__label">المتبقّي</div>
              <div class="stat__value"><span class="money" dir="ltr">18,000 <span class="money__unit">ريال</span></span></div>
            </div>
          </div>

          <div class="divider"></div>

          <div class="row-between">
            <span class="footnote">التاريخ المتوقّع للوصول</span>
            <span class="badge badge--info">يوليو 2027</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card__body">
        <div class="stack">
          <div class="stack-sm">
            <div class="eyebrow">محاكاة</div>
            <div class="section-title">العائد التراكمي</div>
            <div class="footnote">قارن بين الادخار وحده والادخار مع عائد صكوك «صح» بنسبة <span dir="ltr">4.60%</span>.</div>
          </div>

          <svg viewBox="0 0 300 150" role="img" aria-label="مخطط يقارن نمو المدّخرات مع عائد الصك مقابل الادخار وحده خلال اثني عشر شهراً">
            <path d="M10 122 C 90 108, 170 72, 290 26 L 290 138 L 10 138 Z" fill="var(--color-surface-alt)" stroke="none"/>
            <path d="M10 122 L 290 54" fill="none" stroke="var(--color-ink-muted)" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="6 6"/>
            <path d="M10 122 C 90 108, 170 72, 290 26" fill="none" stroke="var(--color-primary)" stroke-width="3" stroke-linecap="round"/>
          </svg>

          <div class="row">
            <span class="badge badge--success"><span class="dot"></span>مع عائد الصك</span>
            <span class="badge badge--neutral"><span class="dot"></span>ادخار فقط</span>
          </div>

          <div class="alert alert--success">
            <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 15.5l5-5 3 3 7.5-7.5"/><path d="M15.5 6h5v5"/></svg></div>
            <div>
              <div class="alert__title">بمساهمة 1,500 ريال شهرياً تصل خلال 12 شهراً</div>
              <div class="alert__body">ومع عائد الصك تربح نحو <span class="money" dir="ltr">620 <span class="money__unit">ريال</span></span> إضافية عند بلوغ الهدف.</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="stack">
      <div class="section-title">المساهمات</div>

      <div class="card">
        <div class="card__body">
          <div class="listrow">
            <div class="listrow__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.6"/><path d="M8.4 12.3l2.4 2.4 4.6-5"/></svg></div>
            <div class="grow">
              <div class="listrow__title">مساهمة يونيو</div>
              <div class="listrow__sub">١ يونيو 2026 · مكتملة</div>
            </div>
            <span class="money" dir="ltr">1,500 <span class="money__unit">ريال</span></span>
          </div>
          <div class="listrow">
            <div class="listrow__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.6"/><path d="M8.4 12.3l2.4 2.4 4.6-5"/></svg></div>
            <div class="grow">
              <div class="listrow__title">مساهمة مايو</div>
              <div class="listrow__sub">١ مايو 2026 · مكتملة</div>
            </div>
            <span class="money" dir="ltr">1,500 <span class="money__unit">ريال</span></span>
          </div>
          <div class="listrow">
            <div class="listrow__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 1.8"/></svg></div>
            <div class="grow">
              <div class="listrow__title">مساهمة يوليو</div>
              <div class="listrow__sub">١ يوليو 2026 · مجدولة</div>
            </div>
            <span class="badge badge--warning">مستحقّة قريباً</span>
          </div>
          <div class="listrow">
            <div class="listrow__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3.8" y="5" width="16.4" height="15" rx="2"/><path d="M3.8 9.5h16.4M8 3.5v3M16 3.5v3"/></svg></div>
            <div class="grow">
              <div class="listrow__title">مساهمة أغسطس</div>
              <div class="listrow__sub">١ أغسطس 2026 · مجدولة</div>
            </div>
            <span class="money" dir="ltr">1,500 <span class="money__unit">ريال</span></span>
          </div>
        </div>
      </div>
    </div>

    <button class="btn btn--accent btn--block btn--lg">سجّل مساهمة</button>

  </div>
</div>
</x-layout>
