<x-layout :title="$alternative->name_ar . ' — رشيد'">
<div class="appbar"><div class="appbar__row"><a href="{{ route('app.alternatives.index') }}" class="backbtn" aria-label="رجوع"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 12h15"/><path d="M13 5.5 19.5 12 13 18.5"/></svg></a><div class="appbar__title">{{ \Illuminate\Support\Str::limit($alternative->name_ar, 26) }}</div></div></div>
<div class="screen">
  <div class="stack-lg">
    <div class="hero-card">
      <div class="hero-card__label">بديل بصفر فوائد</div>
      <div class="hero-card__value">{{ $alternative->name_ar }}</div>
      <div class="hero-card__meta">{{ $alternative->summary_ar }}</div>
    </div>

    <div class="stack-sm">
      <div class="section-title">المزوّدون المعتمدون</div>

      @forelse ($alternative->providers as $ap)
        @php
          $p = $ap->provider;
          $pname = $p->name_ar ?? ($p->name ?? 'مزوّد');
          $initials = \Illuminate\Support\Str::of($pname)->substr(0, 2);
          $metric = null;
          if (! empty($p->target_return)) {
              $metric = 'عائد حتى ' . rtrim(rtrim(number_format((float) $p->target_return, 2), '0'), '.') . '%';
          } elseif (isset($p->interest_free) && $p->interest_free) {
              $metric = 'صفر فوائد';
          } elseif (! empty($p->max_amount_halalas)) {
              $metric = 'حتى ' . number_format($p->max_amount_halalas / 100) . ' ريال';
          } elseif (! empty($p->admin_fee_halalas)) {
              $metric = 'رسوم من ' . number_format($p->admin_fee_halalas / 100) . ' ريال';
          } elseif (! empty($p->management_fee)) {
              $metric = 'رسوم إدارة ' . rtrim(rtrim(number_format((float) $p->management_fee, 3), '0'), '.') . '%';
          }
        @endphp
        <div class="card">
          <div class="card__body">
            <div class="row">
              <div class="listrow__icon">{{ $initials }}</div>
              <div class="grow">
                <div class="listrow__title">{{ $pname }}</div>
                @if (! empty($p->details_ar))<div class="listrow__sub">{{ \Illuminate\Support\Str::limit($p->details_ar, 60) }}</div>@endif
              </div>
              @if ($metric)<span class="badge badge--success">{{ $metric }}</span>@endif
            </div>
          </div>
        </div>
      @empty
        <div class="footnote">سيُضاف المزوّدون المعتمدون قريباً.</div>
      @endforelse

      <div class="footnote">جهات مرخّصة وموثوقة تخضع لإشراف رسمي، وشروطها معلنة وشفافة.</div>
    </div>

    <div class="alert alert--info">
      <div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.6"/><path d="M9.6 9.6a2.5 2.5 0 0 1 4.6 1.4c0 1.7-2.2 2-2.2 3.4"/><circle cx="12" cy="17" r=".6" fill="currentColor" stroke="none"/></svg></div>
      <div>
        <div class="alert__title">كيف يساعدك هذا المسار؟</div>
        <div class="alert__body">يمكّنك من الوصول للمبلغ الذي تحتاجه دون فوائد أو التزامات ربحية. استشر مستشار رشيد لاختيار المزوّد الأنسب لحالتك.</div>
      </div>
    </div>

    <div class="stack-sm">
      <a href="{{ route('app.advisor.index') }}" class="btn btn--accent btn--block btn--lg">استشر المستشار حول هذا المسار</a>
      <a href="{{ route('app.alternatives.index') }}" class="btn btn--ghost btn--block">استعرض بقية البدائل</a>
    </div>
  </div>
</div>
</x-layout>
