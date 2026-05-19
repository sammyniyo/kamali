{{--
    KG monogram. `kamali-logo-mark.png` is generated with a dark-field knockout
    (see `scripts/knockout-logo-background.php`) so the mark reads cleanly on dark UIs.
    Props: variant = nav | footer | drawer | admin | compact
--}}
@props(['variant' => 'nav'])

@php
    $markUrl = asset('images/kamali-logo-mark.png');
    $imgClass = match ($variant) {
        'footer' => 'h-16 w-auto sm:h-[4.25rem] md:h-20',
        'drawer' => 'h-12 w-auto sm:h-14',
        'admin' => 'h-12 w-auto sm:h-14',
        'compact' => 'h-9 w-auto sm:h-10',
        default =>
            'h-11 max-h-[2.875rem] w-auto sm:h-12 sm:max-h-[3rem] md:h-[3.35rem] md:max-h-[3.35rem]',
    };
@endphp

<a
    {{ $attributes->merge([
        'href' => route('home'),
        'class' =>
            'inline-flex items-center gap-0 shrink-0 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-gold/45 focus-visible:ring-offset-2 focus-visible:ring-offset-dark transition-opacity hover:opacity-95',
    ]) }}
>
    <img
        src="{{ $markUrl }}"
        alt="Kamali Architects"
        class="{{ $imgClass }} w-auto object-contain object-left select-none"
        width="400"
        height="400"
        decoding="async"
    />
</a>
