<x-layout title="هل أقترض؟ — رشيد">
<div class="appbar"><div class="appbar__row"><a href="{{ url()->previous() }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">هل أقترض؟</div><div class="appbar__spacer"></div><span class="pill">خطوة 1 من 3</span></div></div>
<div class="screen">
  <form method="POST" action="{{ route('app.decisions.store') }}" x-data="{ purpose: 'car', tenor: 24 }">
    @csrf
    <input type="hidden" name="purpose" :value="purpose">
    <input type="hidden" name="tenor_months" :value="tenor">

    <div class="stack-lg">
      @if ($errors->any())
        <div class="alert alert--danger">
          <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5 3 20h18L12 4.5z"/><path d="M12 10.5v4"/><circle cx="12" cy="17.4" r=".6" fill="currentColor" stroke="none"/></svg></div>
          <div><div class="alert__title">تحقّق من المدخلات</div><div class="alert__body">{{ $errors->first() }}</div></div>
        </div>
      @endif

      <div class="stack-sm">
        <div class="eyebrow">نيّة الاقتراض</div>
        <div class="section-title">كم المبلغ الذي تحتاجه؟</div>
        <div class="footnote">اكتب المبلغ التقريبي الذي تفكّر في اقتراضه، وسنحلّله لك بهدوء ودون أي التزام.</div>
      </div>

      <div class="field is-amount">
        <div class="field__label">المبلغ المطلوب</div>
        <div class="field__control">
          <input name="amount" inputmode="numeric" value="{{ old('amount', '30,000') }}" aria-label="المبلغ المطلوب بالريال">
          <span class="field__suffix">ريال</span>
        </div>
      </div>

      <div class="divider"></div>

      <div class="stack-sm">
        <div class="section-title">ما الغرض؟</div>
        <div class="footnote">يساعدنا تحديد الغرض على اقتراح البدائل الأنسب لحالتك.</div>
      </div>

      <div class="icon-grid">
        <div role="button" tabindex="0" class="icon-opt" :class="{ 'is-active': purpose === 'car' }" @click="purpose = 'car'"><span class="emoji"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 13 6 8.8A2 2 0 0 1 7.9 7.5h8.2A2 2 0 0 1 18 8.8L19.5 13"/><path d="M3.5 13h17v4.2a1 1 0 0 1-1 1h-1.3a1 1 0 0 1-1-1V16.4H6.8v.8a1 1 0 0 1-1 1H4.5a1 1 0 0 1-1-1V13z"/><circle cx="7.2" cy="16" r="1.1"/><circle cx="16.8" cy="16" r="1.1"/></svg></span>سيارة</div>
        <div role="button" tabindex="0" class="icon-opt" :class="{ 'is-active': purpose === 'marriage' }" @click="purpose = 'marriage'"><span class="emoji"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6.5 4h11l3 5-8.5 11L3.5 9l3-5z"/><path d="M3.5 9h17"/><path d="M9 4l3 16 3-16"/></svg></span>زواج</div>
        <div role="button" tabindex="0" class="icon-opt" :class="{ 'is-active': purpose === 'emergency' }" @click="purpose = 'emergency'"><span class="emoji"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5 3 20h18L12 4.5z"/><path d="M12 10.5v4"/><circle cx="12" cy="17.4" r=".6" fill="currentColor" stroke="none"/></svg></span>طوارئ</div>
        <div role="button" tabindex="0" class="icon-opt" :class="{ 'is-active': purpose === 'education' }" @click="purpose = 'education'"><span class="emoji"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5 3 9l9 4 9-4-9-4z"/><path d="M6.5 11v3.8c0 1.4 2.5 2.7 5.5 2.7s5.5-1.3 5.5-2.7V11"/><path d="M21 9v4.5"/></svg></span>تعليم</div>
        <div role="button" tabindex="0" class="icon-opt" :class="{ 'is-active': purpose === 'debt_consolidation' }" @click="purpose = 'debt_consolidation'"><span class="emoji"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 8.5l5 5 3-3 7.5 7.5"/><path d="M15.5 18h5v-5"/></svg></span>سداد ديون</div>
        <div role="button" tabindex="0" class="icon-opt" :class="{ 'is-active': purpose === 'business' }" @click="purpose = 'business'"><span class="emoji"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3.5" y="8" width="17" height="11.5" rx="2"/><path d="M9 8V6.5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2V8"/><path d="M3.5 13h17"/></svg></span>مشروع</div>
      </div>

      <div class="divider"></div>

      <div class="stack-sm">
        <div class="section-title">خلال كم شهر تسدّد؟</div>
        <div class="footnote">اختر المدة التي تريح ميزانيتك الشهرية.</div>
      </div>

      <div class="segmented" role="group" aria-label="مدة السداد بالأشهر">
        <div role="button" tabindex="0" class="segmented__opt" :class="{ 'is-active': tenor === 12 }" @click="tenor = 12">12</div>
        <div role="button" tabindex="0" class="segmented__opt" :class="{ 'is-active': tenor === 24 }" @click="tenor = 24">24</div>
        <div role="button" tabindex="0" class="segmented__opt" :class="{ 'is-active': tenor === 36 }" @click="tenor = 36">36</div>
        <div role="button" tabindex="0" class="segmented__opt" :class="{ 'is-active': tenor === 60 }" @click="tenor = 60">60</div>
      </div>
      <div class="footnote">الحد الأقصى 60 شهراً وفق ضوابط ساما (SAMA).</div>

      <div class="alert alert--info">
        <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3.5 19 6.2v4.9c0 4.4-3 7.3-7 8.9-4-1.6-7-4.5-7-8.9V6.2l7-2.7z"/></svg></div>
        <div>
          <div class="alert__title">خصوصيتك محفوظة</div>
          <div class="alert__body">لن نطلب أي بيانات بنكية في هذه الخطوة، والتحليل يبقى بين يديك وحدك.</div>
        </div>
      </div>

      <button type="submit" class="btn btn--accent btn--block btn--lg">حلّل قراري</button>
    </div>
  </form>
</div>
</x-layout>
