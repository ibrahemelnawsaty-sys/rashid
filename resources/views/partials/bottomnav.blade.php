@props(['active' => 'home'])
<nav class="bottomnav" aria-label="التنقّل الرئيسي">
    <a href="{{ route('app.dashboard') }}" @class(['is-active' => $active === 'home'])>
        <span class="ic"><x-icon name="home" /></span>الرئيسية
    </a>
    <a href="{{ route('app.dashboard') }}" @class(['is-active' => $active === 'money'])>
        <span class="ic"><x-icon name="bar-chart" /></span>أموالي
    </a>
    <a href="{{ route('app.decisions.create') }}" @class(['is-active' => $active === 'scale'])>
        <span class="ic"><x-icon name="scale" /></span>هل أقترض؟
    </a>
    <a href="{{ route('app.goals.index') }}" @class(['is-active' => $active === 'target'])>
        <span class="ic"><x-icon name="target" /></span>أهدافي
    </a>
    <a href="{{ route('app.advisor.index') }}" @class(['is-active' => $active === 'chat'])>
        <span class="ic"><x-icon name="message" /></span>مستشار
    </a>
</nav>
