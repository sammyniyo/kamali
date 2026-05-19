@props([
    'heading',
    'body',
    'eyebrow' => null,
    'actionText' => null,
    'actionHref' => null,
    /** When true, styles for dark section backgrounds (e.g. nested in cream page) */
    'invert' => false,
])

@php
    $panel = $invert
        ? 'border-cream/15 bg-cream/[0.06] text-cream'
        : 'border-dark/10 bg-white/75 text-dark';
    $muted = $invert ? 'text-cream/70' : 'text-dark/65';
    $eyebrowClass = $invert ? 'text-cream/50' : 'text-dark/45';
@endphp

<div {{ $attributes->merge(['class' => "rounded-2xl border {$panel} px-6 py-10 text-center shadow-[0_2px_32px_rgba(0,0,0,0.04)] backdrop-blur sm:px-10 sm:py-12"]) }} role="status">
    @if ($eyebrow)
        <p class="label {{ $eyebrowClass }}">{{ $eyebrow }}</p>
    @endif
    <p class="font-display text-xl leading-snug sm:text-2xl {{ $eyebrow ? 'mt-3' : '' }}">{{ $heading }}</p>
    <p class="mx-auto mt-3 max-w-lg text-sm leading-relaxed {{ $muted }}">{{ $body }}</p>
    @if ($actionText && $actionHref)
        <a class="btn btn-gold mt-7 inline-flex justify-center" href="{{ $actionHref }}">{{ $actionText }}</a>
    @endif
</div>
