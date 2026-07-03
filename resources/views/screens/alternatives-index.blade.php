<x-layout title="البدائل — رشيد">
<div class="appbar"><div class="appbar__row"><div class="appbar__title">البدائل</div><div class="appbar__spacer"></div><span class="badge badge--accent">{{ $alternatives->count() }} مسارات</span></div></div>
<div class="screen screen--pb">
<div class="stack-lg">

<div class="stack-sm">
<div class="eyebrow">قبل أن تقترض</div>
<div class="section-title">مسارات أذكى من القرض</div>
<div class="footnote">رتّبنا لك بدائل واقعية بأقل تكلفة وأخفّ التزام، والأنسب لوضعك يأتي في المقدّمة.</div>
</div>

@foreach ($alternatives as $alt)
<div class="alt-card {{ $loop->first ? 'is-top' : '' }}">
<div class="alt-card__head"><span class="alt-num">{{ $loop->iteration }}</span><div class="grow"><div class="alt-card__title">{{ $alt->name_ar }}</div><div class="alt-card__summary">{{ $alt->summary_ar }}</div></div></div>
<div class="alt-card__body">
@if ($alt->providers->isNotEmpty())
<div class="row">
@foreach ($alt->providers->take(4) as $ap)
@php $pn = $ap->provider->name_ar ?? ($ap->provider->name ?? null); @endphp
@if ($pn)<span class="badge badge--info">{{ $pn }}</span>@endif
@endforeach
</div>
@endif
<a href="{{ route('app.alternatives.show', $alt->slug) }}" class="btn btn--secondary btn--block">استعرض التفاصيل</a>
</div>
</div>
@endforeach

<div class="alert alert--info"><div class="alert__icon"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9.2 18h5.6"/><path d="M10 21h4"/><path d="M12 3.2a5.8 5.8 0 0 1 3.9 10.1c-.7.6-1 1.4-1 2.3H9.1c0-.9-.3-1.7-1-2.3A5.8 5.8 0 0 1 12 3.2z"/></svg></div><div><div class="alert__title">لست مضطراً للاختيار الآن</div><div class="alert__body">يمكنك الجمع بين أكثر من مسار، أو استشارة مستشار رشيد لاختيار الأنسب لوضعك المالي.</div></div></div>

</div>
</div>
@include('partials.bottomnav', ['active' => 'scale'])
</x-layout>
