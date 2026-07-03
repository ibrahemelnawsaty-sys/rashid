@props(['name' => '', 'class' => ''])
@php
$icons = [
 'home' => '<path d="M4 11.5 12 4l8 7.5"/><path d="M6 10.5V19a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-8.5"/><path d="M10 20v-5h4v5"/>',
 'bar-chart' => '<path d="M4 20h16"/><rect x="5.5" y="10" width="3.4" height="7" rx="1"/><rect x="10.3" y="6" width="3.4" height="11" rx="1"/><rect x="15.1" y="13" width="3.4" height="4" rx="1"/>',
 'scale' => '<path d="M12 4v16"/><path d="M7 6h10"/><path d="M8 20h8"/><path d="M7 6 4 12.5a3 3 0 0 0 6 0L7 6z"/><path d="M17 6l-3 6.5a3 3 0 0 0 6 0L17 6z"/>',
 'target' => '<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4.4"/><circle cx="12" cy="12" r="1.1" fill="currentColor" stroke="none"/>',
 'message' => '<path d="M20.5 11.3a7.5 7.5 0 0 1-10.9 6.7L4.5 19.5l1.5-4.9A7.5 7.5 0 1 1 20.5 11.3z"/>',
 'bell' => '<path d="M6.5 9.5a5.5 5.5 0 0 1 11 0c0 4.5 1.8 5.5 1.8 5.5H4.7s1.8-1 1.8-5.5z"/><path d="M10.2 19a2 2 0 0 0 3.6 0"/>',
 'user' => '<circle cx="12" cy="8.2" r="3.4"/><path d="M5.5 20a6.5 6.5 0 0 1 13 0"/>',
 'shield' => '<path d="M12 3.5 19 6.2v4.9c0 4.4-3 7.3-7 8.9-4-1.6-7-4.5-7-8.9V6.2l7-2.7z"/>',
 'check-circle' => '<circle cx="12" cy="12" r="8.6"/><path d="M8.4 12.3l2.4 2.4 4.6-5"/>',
 'alert' => '<path d="M12 4.5 3 20h18L12 4.5z"/><path d="M12 10.5v4"/><circle cx="12" cy="17.4" r=".6" fill="currentColor" stroke="none"/>',
];
$inner = $icons[$name] ?? '';
@endphp
<svg class="ico {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $inner !!}</svg>
