@props([
    /** @var \App\Models\Partner */
    'partner',
    /** strip | badge */
    'variant' => 'strip',
    /** When false, renders a div instead of li (admin previews). */
    'listItem' => true,
])

@php
    use Illuminate\Support\Str;

    $logoUrl = \App\Support\KamaliMedia::partnerLogo($partner->logo);
    $initials = collect(preg_split('/\s+/', trim($partner->name)))
        ->filter()
        ->take(2)
        ->map(fn (string $word) => Str::upper(Str::substr($word, 0, 1)))
        ->implode('');
    $isStrip = $variant === 'strip';
    $wrapperTag = $listItem ? 'li' : 'div';
    $innerTag = $partner->url ? 'a' : 'article';
    $linkAttrs = $partner->url
        ? 'href="'.e($partner->url).'" target="_blank" rel="noreferrer"'
        : '';
@endphp

<{{ $wrapperTag }} @class([
    'group h-full w-full',
    'min-w-[min(100%,16.5rem)] max-w-[16.5rem] shrink-0 snap-start sm:min-w-0' => $listItem && $isStrip,
    'max-w-[16.5rem]' => ! $listItem,
])>
    <{{ $innerTag }}
        {!! $linkAttrs !!}
        @class([
            'partner-tile flex h-full min-h-[11.5rem] flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-gold/40 focus-visible:ring-offset-2 focus-visible:ring-offset-cream',
            'p-5' => $isStrip,
            'items-center justify-center p-5 text-center sm:p-6' => ! $isStrip,
        ])
        @if ($partner->url) aria-label="{{ $partner->name }} (opens in new tab)" @endif
    >
        @if ($isStrip)
            <div class="partner-tile__logo-wrap">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="" class="partner-tile__logo" loading="lazy" decoding="async" />
                @else
                    <div class="partner-tile__mark" aria-hidden="true">{{ $initials ?: 'K' }}</div>
                @endif
            </div>

            <p class="partner-tile__name mt-4 flex-1">{{ $partner->name }}</p>

            <div class="mt-4 flex min-h-[2.25rem] items-end justify-between gap-3 border-t border-dark/8 pt-3">
                <p class="min-w-0 flex-1 text-[10px] uppercase leading-relaxed tracking-[0.14em] text-dark/45 sm:text-[11px]">
                    @if ($partner->note)
                        {{ $partner->note }}
                    @else
                        &nbsp;
                    @endif
                </p>
                @if ($partner->url)
                    <span class="shrink-0 text-[10px] uppercase tracking-[0.14em] text-dark/45 transition group-hover:text-gold sm:text-[11px]">
                        Visit <span aria-hidden="true">↗</span>
                    </span>
                @endif
            </div>
        @else
            <div class="flex w-full flex-col items-center">
                @if ($logoUrl)
                    <div class="partner-tile__logo-wrap !justify-center !border-0 !bg-transparent !px-0">
                        <img src="{{ $logoUrl }}" alt="" class="partner-tile__logo mx-auto !max-h-10" loading="lazy" />
                    </div>
                @else
                    <div class="partner-tile__mark" aria-hidden="true">{{ $initials ?: 'K' }}</div>
                @endif
                <p class="mt-4 font-display text-lg leading-snug text-dark sm:text-xl">{{ $partner->name }}</p>
                <div class="mx-auto mt-3 h-px w-8 bg-gold/50 transition-all duration-500 motion-safe:group-hover:w-12"></div>
            </div>
        @endif
    </{{ $innerTag }}>
</{{ $wrapperTag }}>
