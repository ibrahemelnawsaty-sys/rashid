<x-layout title="الموافقات والخصوصية — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ url()->previous() }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">الموافقات والخصوصية</div></div></div>
<div class="screen">
  <div class="stack">
    <div class="stack-sm">
      <div class="eyebrow">حماية بياناتك</div>
      <div class="section-title">أنت تتحكّم في موافقاتك</div>
      <p class="footnote">وفقاً لنظام حماية البيانات الشخصية (PDPL)، نعرض لك بشفافية كل موافقة منحتها ولمن، ويمكنك سحب أيّ موافقة في أيّ وقت دون أن يؤثّر ذلك على حقوقك السابقة.</p>
    </div>

    <div class="card">
      <div class="card__body stack-sm">
        <div class="row-between">
          <div class="stack-sm">
            <div class="row"><span>معالجة البيانات</span><span class="pill">PDPL</span></div>
            <div class="footnote">الأساس التشغيلي لخدمات رشيد وتحليل وضعك المالي.</div>
          </div>
          <span class="badge badge--success"><span class="dot"></span>ممنوحة</span>
        </div>
        <div class="divider"></div>
        <div class="row-between">
          <div class="footnote">مُنِحت في 12 مارس 2026</div>
          <button class="btn btn--ghost btn--sm">سحب</button>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card__body stack-sm">
        <div class="row-between">
          <div class="stack-sm">
            <div class="row"><span>ربط المصرفية المفتوحة</span><span class="pill">AIS</span></div>
            <div class="footnote">قراءة أرصدة وحركات حساباتك لتحديث بياناتك تلقائياً.</div>
          </div>
          <span class="badge badge--success"><span class="dot"></span>ممنوحة</span>
        </div>
        <div class="divider"></div>
        <div class="stack-sm">
          <div class="row-between"><span class="footnote">المزوّد المعتمد</span><span class="footnote">سِمَة — الخدمات المصرفية المفتوحة</span></div>
          <div class="row-between"><span class="footnote">آخر مزامنة</span><span class="footnote">اليوم، 9:14 صباحاً</span></div>
        </div>
        <div class="divider"></div>
        <div class="row-between">
          <div class="footnote">مُنِحت في 12 مارس 2026 · صالحة حتى 12 سبتمبر 2026</div>
          <button class="btn btn--ghost btn--sm">سحب</button>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card__body stack-sm">
        <div class="row-between">
          <div class="stack-sm">
            <div>التسويق والعروض</div>
            <div class="footnote">إشعارات ترويجية ورسائل عن منتجات الشركاء.</div>
          </div>
          <span class="badge badge--neutral">مسحوبة</span>
        </div>
        <div class="divider"></div>
        <div class="row-between">
          <div class="footnote">سُحِبت في 28 يونيو 2026</div>
          <button class="btn btn--ghost btn--sm">منح</button>
        </div>
      </div>
    </div>

    <div class="sheet">
      <div class="sheet__grip"></div>
      <div class="stack">
        <div class="stack-sm">
          <div class="section-title">تأكيد سحب الموافقة</div>
          <p class="footnote">عند سحب موافقة «ربط المصرفية المفتوحة» سنوقف مزامنة أرصدتك تلقائياً، وقد تصبح بعض التحليلات والتنبيهات غير محدَّثة حتى تمنح الموافقة مجدداً. لن يُحذف تاريخك السابق.</p>
        </div>
        <div class="stack-sm">
          <button class="btn btn--danger btn--block">تأكيد السحب</button>
          <button class="btn btn--secondary btn--block">تراجع</button>
        </div>
      </div>
    </div>

    <div class="alert alert--info">
      <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3.5 19 6.2v4.9c0 4.4-3 7.3-7 8.9-4-1.6-7-4.5-7-8.9V6.2l7-2.7z"/></svg></div>
      <div>
        <div class="alert__title">سجلّ تدقيق موثّق</div>
        <div class="alert__body">يُسجَّل كل منح أو سحب للموافقات مع التاريخ والوقت في سجلّ التدقيق، ويمكنك طلب نسخة منه في أيّ وقت.</div>
      </div>
    </div>
  </div>
</div>
</x-layout>
