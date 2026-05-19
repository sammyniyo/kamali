@props([
    /** @var \App\Models\Partner */
    'partner',
])

@php
    use Illuminate\Support\Str;

    $logoUrl = \App\Support\KamaliMedia::partnerLogo($partner->logo);
    $category = trim((string) $partner->note);
    $tag = $partner->url ? 'a' : 'div';
    $linkAttrs = $partner->url
        ? 'href="'.e($partner->url).'" target="_blank" rel="noreferrer"'
        : '';
@endphp

<li class="group">
    <{{ $tag }}
        {!! $linkAttrs !!}
        @class([
            'partners-trust__cell flex flex-col items-center text-center focus:outline-none focus-visible:ring-2 focus-visible:ring-gold/40 focus-visible:ring-offset-2 focus-visible:ring-offset-cream rounded-lg',
            'transition-opacity hover:opacity-100' => (bool) $partner->url,
        ])
        @if ($partner->url) aria-label="{{ $partner->name }} (opens in new tab)" @endif
    >
        <div class="partners-trust__logo flex h-12 w-full items-center justify-center px-2">
            @if ($logoUrl)
                <img
                    src="{{ $logoUrl }}"
                    alt="{{ $partner->name }}"
                    class="partners-trust__logo-img"
                    loading="lazy"
                    decoding="async"
                />
            @else
                <span class="max-w-full truncate font-display text-base leading-none tracking-tight text-dark/55 transition group-hover:text-dark/75">
                    {{ $partner->name }}
                </span>
            @endif
        </div>
        @if ($category !== '')
            <p class="partners-trust__category">{{ $category }}</p>
        @endif
    </{{ $tag }}>
</li>
